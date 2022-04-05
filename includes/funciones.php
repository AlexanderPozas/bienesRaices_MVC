<?php

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

function incluirTemplate(string $nombre, bool $inicio = false): void
{
    include TEMPLATES_URL . "/${nombre}.php";
}

function usuarioAutenticado(): void
{
    session_start();
    if (!$_SESSION['login']) {
        header('location: /');
    }
}

function debug($var): void
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    exit;
}

/**Funcion para escapar entradas html 
 * Evita de inyeccion de código html, javascript
 */
function s($html)
{
    return htmlspecialchars($html);
}

//Validar tipo de contenido
function validarTipoContenido($tipo)
{
    $tipos = ['vendedor', 'propiedad'];
    return in_array($tipo, $tipos);
}

function  mensajeNotificacion($codigo)
{
    $mensaje = '';
    switch ($codigo) {
        case 1:
            $mensaje = 'Creado Correctamente';
            break;
        case 2:
            $mensaje = 'Acutalizado Correctamente';
            break;
        case 3:
            $mensaje = 'Eliminado Correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }
    return $mensaje;
}

function validarORedireccionar(string $url)
{
    //Obtener valores que se pasan por url desde el index
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT); //Validamos que el valor que se pasa sea un entero

    if (!$id) {
        //Sino es un entero, se regresa a la página index.php
        header("Location: ${url}");
    }
    return $id;
}
