<?php

namespace Model;

class Vendedor extends ActiveRecord
{
    /**Especificar nombre de la tabla en mysq */
    protected static $tabla = 'vendedores';

    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

    /**Atributos de la clase*/
    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    /**Constructor de la clase */
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    public function validar()
    {
        //Validación de información
        if (!$this->nombre) {
            self::$errores[] = 'El nombre es obligatorio';
        }
        if (!$this->apellido) {
            self::$errores[] = 'El apellido es obligatorio';
        }
        if (!$this->telefono) {
            self::$errores[] = 'El telefono es obligatorio';
        }
        /**Expresión regular para validar un numero de telefono */
        // if (preg_match('/([0-9]){10}/', $this->telefono)) {
        //     self::$errores[] = 'Formato de telefono no valido';
        // }

        return self::$errores;
    }
}
