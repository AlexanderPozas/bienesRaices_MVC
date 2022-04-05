<?php

namespace Controlador;

use Model\Admin;
use MVC\Router;

class LoginControlador
{
    public static function login(Router $router)
    {

        $auth = new Admin();

        $errores = Admin::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Admin($_POST);

            $errores = $auth->validar();

            if (empty($errores)) {
                //Verifica si el usuario existe o no
                $resultado = $auth->existeUsuario();
                if (!$resultado) {
                    $errores = Admin::getErrores(); //No existe el usuario
                } else {
                    //Verificar password
                    $autenticado = $auth->comprobarPassword($resultado);
                    if ($autenticado) {
                        //Autenticar el usuario
                        $auth->autenticar();
                    } else {
                        $errores = Admin::getErrores(); //Password incorrecto
                    }
                }
            }
        }

        $router->render('/auth/login', [
            'errores' => $errores
        ]);
    }
    public static function logout()
    {
        session_start();
        $_SESSION = [];

        header('location: /');
    }
}
