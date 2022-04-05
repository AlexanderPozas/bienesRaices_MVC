<?php

namespace Model;

use Error;
use Exception;

class ActiveRecord
{
    //Variables estáticas de la base de datos
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    //Variables estáticas para validacion de datos
    protected static $errores = [];

    public static function setDB($database)
    {
        self::$db = $database;
    }

    public function setImagen($imagen)
    {
        if (!is_null($this->id)) {
            //Comprobar si existe el archivo
            $this->borrarImagen();
        }
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    public function borrarImagen()
    {
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    public function guardar()
    {
        /**Definimos si existe el valor id en el objeto con información */
        if (!is_null($this->id)) {
            $this->actualizar();
        } else {
            $this->crear();
        }
    }

    public function crear()
    {

        //Sanitizar los datos
        $atributosSanitizados = $this->sanitizarAtributos();
        // $string = array_keys($atributosSanitizados); //devuelve las llaves del arreglo en formato array string
        // $string = array_values($atributosSanitizados); //devuelve los valores del arreglo en formato array string

        // $string = join("', '",array_values($atributosSanitizados)); //Crea una variable string con los valores del arreglo separado por comas y apostrofes
        // $string = join(', ',array_keys($atributosSanitizados)); //Crea una variable string con los valores del arreglo separado por comas
        // debug($string);

        //Insertar en la base de datos forma reducida, utilizando arreglos y sus valores
        $query = "INSERT INTO " . static::$tabla . " (";
        $query .= join(',', array_keys($atributosSanitizados));
        $query .= ") VALUES ('";
        $query .= join("', '", array_values($atributosSanitizados));
        $query .= "');";

        $resultado = self::$db->query($query);
        if ($resultado) {
            // echo 'Insertado Correctamente';

            //Redireccionar al usuario
            //No se puede utilizar cuando hay código html antes
            header('Location: /admin?resultado=1');
            /**Enviar mas valores en query string 'Location: /admin?resultado=1&mensaje='hola'*/
        }
    }

    public function actualizar()
    {
        //Sanitizar los datos
        $atributosSanitizados = $this->sanitizarAtributos();
        // $query = "UPDATE propiedades
        // SET titulo = '${titulo}', precio = ${precio},imagen = '${nombreImagen}', descripcion = '${descripcion}',
        // habitaciones = ${habitaciones}, wc = ${wc},estacionamiento = ${estacionamiento},
        // vendedorId = ${vendedorId} WHERE id = ${id}";

        $valores = [];
        foreach ($atributosSanitizados as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1;";

        $resultado = self::$db->query($query);
        if ($resultado) {
            // echo 'Insertado Correctamente';

            //Redireccionar al usuario
            //No se puede utilizar cuando hay código html antes
            header('Location: /admin?resultado=2');
            /**Enviar mas valores en query string 'Location: /admin?resultado=1&mensaje='hola'*/
        }
    }

    public function atributos()
    {
        $atributos = [];
        /**Crea un arreglo de atributos
         * $atributos['id']= valor que tiene id del objeto de la clase
         * $atributos['titulo']= valor que tiene titulo del objeto de la clase
         * .
         * .
         * .
         */
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') continue; //Saltamos el id ya que estamos creando una objeto y lo genera auto mysql
            $atributos[$columna] = $this->$columna; //Se utiliza $ en this y en columna porque es un valor variable
        }
        return $atributos;
    }

    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        /**Sanitizamos los atributos utilizando escape_string
         * Recorremos el arreglo $atributos con el metodo llave-valor y lo asignamos a un nuevo arreglo con los valores sanitizados
         */
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    public static function getErrores(): array
    {
        return static::$errores;
    }

    public function validar()
    {
        static::$errores = [];
        //Funcion que se va a sobrescribir en otras clases
        // return static::$errores;
    }

    /**Listar todas los registros en forma de objetos no de arreglo asociativo*/
    public static function all()
    {
        $query = "SELECT * FROM " . static::$tabla . ";";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    /**Listar cierto numero de registros */
    public static function get($cantidad){
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad . ";";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    /**Listar un registro por su id */
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = ${id}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado); //Regresa ek primer elemento del arreglo
    }

    //Eliminar un registro
    public function eliminar()
    {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id);
        $query .= " LIMIT 1;";
        $resultado = self::$db->query($query);
        if ($resultado) {
            $this->borrarImagen();
            header('location: /admin?resultado=3');
        }
    }


    public static function consultarSQL($query)
    {
        //Consultar la base de datos
        $resultado = self::$db->query($query);
        //Iterar para obtener todos los registros
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }
        //Limpiar memoria
        $resultado->free();
        //retornar los resultados
        return $array;
    }
    protected static function crearObjeto($registro)
    {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    /**Update
     * Sincroniza el objeto con los valores que modifica el usuario
     */
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
        return $this;
    }
}
