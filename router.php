<?php

/**Se encarga de registrar todas las rutas URL de la app */

namespace MVC; //Se asigna un namespace a la clase router


class Router{

    public $rutasGET = [];
    public $rutasPOST = [];

    /**Función que obtiene una url, el controlador y  la funcion asociada y la almacena en arreglos asociativos */
    public function get($url,$fn){
        $this->rutasGET[$url] = $fn;        
    }
    public function post($url,$fn){
        $this->rutasPOST[$url] = $fn;        
    }

    /**Funcion que lee la url actual y el metodo que se esta ejecutando */
    public function comprobarRutas(){
        session_start(); //Inicia la sesion y se tiene acceso a $_SESSION
        $auth = $_SESSION['login'] ?? null;
        
        $rutasProtegidas = ['/admin','/propiedades/crear','/propiedades/actualizar','/propiedades/eliminar','/vendedores/crear','/vendedores/actualizar','/vendedores/eliminar']; //Arreglo de rutas protegidas

        $urlActual = $_SERVER['REQUEST_URI'] === '' ? '/' : $_SERVER['REQUEST_URI']; //Url actual
        $metodo = $_SERVER['REQUEST_METHOD']; //Metodo utilizado GET o POST

        /** Proteger lasd rutas */
        if(in_array($urlActual,$rutasProtegidas) && !$auth){
            header('location: /');
        }
        /**Se extrae el controlador asociado a una url y el método get o post a ejecutar*/
        if($metodo === 'GET'){
            $fn = $this->rutasGET[$urlActual]??null; 
        }else{
            $fn = $this->rutasPOST[$urlActual]??null;
        }

        /**Si la url existe y hay una funcion asociada de un controlador*/
        if($fn){
            /**Ejecuta un callback del controlador y se pasan argumentos
             * 1. Se pasa un método estático de una clase ej: Controller\Class::index()
             * 2. Se pasan los argumentos del objeto actual: el arreglo get y post
             */
            call_user_func($fn,$this);
        }else{
            echo 'Página no encontrada';
        }
    }

    /**Mostrar una vista 
     * Se pasa como argumento una url de una vista particular que se mostrara
     * y un arreglo asociativo  con datos requeridos
    */
    public function render($view, $datos = []){
        /**Se pasan datos en forma de arreglo asociativo
         * cada valor que se pasa, se creará una variable con el mismo nombre que la llave del arreglo asociativo y su valor correspondiente
         * Los datos se pasan a los includes
         */
        foreach($datos as $key => $value){
            $$key = $value;
        }
    
        ob_start(); //Incia un almacenamiento en memoria

        /**Se incluye la vista determinada por la funcion a ejecutar
         * Se usan comillas dobles para que el include lea como una variable a $view y no como texto
         */
        include __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean(); //Limpia el buffer y la vista se almacena en la variable

        /**Se incluye la masterpage que contiene el header y el footer */
        include __DIR__ . "/views/layout.php";
    }

}