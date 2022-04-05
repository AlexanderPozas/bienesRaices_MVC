<?php

namespace Model;

date_default_timezone_set('America/Mexico_City'); //zona horaria


class Propiedad extends ActiveRecord
{
    /**Especificar nombre de la tabla en mysq */
    protected static $tabla = 'propiedades';    

    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];

    /**Atributos de la clase */
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

    /**Constructor de la clase */
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? '';
    }

    public function validar()
    {
        //Validación de información
        if (!$this->titulo) {
            self::$errores[] = 'Debes añadir un titulo';
        }
        if (!$this->precio) {
            self::$errores[] = 'El precio es obligatorio';
        }
        if (strlen($this->descripcion) < 50) {
            self::$errores[] = 'La descripción es obligatoria';
        }
        if (!$this->habitaciones) {
            self::$errores[] = 'Especifique el número de habitaciones';
        }
        if (!$this->wc) {
            self::$errores[] = 'Especifique el número de baños';
        }
        if (!$this->estacionamiento) {
            self::$errores[] = 'Especifique el número de estacionamientos';
        }
        if (!$this->vendedorId) {
            self::$errores[] = 'Elige un vendedor';
        }
        if (!$this->imagen) {
            self::$errores[] = 'La imagen es obligatoria';
        }
        return self::$errores;
    }

}
