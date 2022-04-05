<?php

namespace Controlador;

use Model\Vendedor;
use MVC\Router;

class VendedorControlador
{
    public static function crear(Router $router)
    {

        $vendedor = new Vendedor();
        $errores = Vendedor::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            /**Instanciar el objeto */
            $vendedor = new Vendedor($_POST['vendedor']);

            /**Validar los datos */
            $errores = $vendedor->validar();

            if (empty($errores)) {
                $vendedor->guardar(); //Insertar en bd
            }
        }

        $router->render('/vendedores/crear', [
            "errores" => $errores,
            "vendedor" => $vendedor

        ]);
    }
    public static function actualizar(Router $router)
    {
        $id = validarORedireccionar('/admin');
        $vendedor = Vendedor::find($id);
        $errores = Vendedor::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $args = $_POST['vendedor'];
            $vendedor->sincronizar($args);

            $errores = $vendedor->validar();

            if (empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('/vendedores/actualizar', [
            "errores" => $errores,
            "vendedor" => $vendedor
        ]);
    }
    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if ($id) {
                $tipo = $_POST['tipo'];
                if (validarTipoContenido($tipo)) {
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                } else {
                    header('location: /admin');
                }
            }
        }
    }
}
