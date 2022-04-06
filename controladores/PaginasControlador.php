<?php

namespace Controlador;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasControlador
{
    public static function index(Router $router)
    {

        $propiedades = Propiedad::get(3);
        $inicio = true;

        $router->render('/paginas/index', [
            "propiedades" => $propiedades,
            "inicio" => $inicio
        ]);
    }
    public static function nosotros(Router $router)
    {
        $router->render('/paginas/nosotros');
    }
    public static function propiedades(Router $router)
    {
        $propiedades = Propiedad::all();
        $router->render('/paginas/propiedades', [
            "propiedades" => $propiedades
        ]);
    }
    public static function propiedad(Router $router)
    {
        $id = validarORedireccionar('/propiedades');
        $propiedad = Propiedad::find($id);

        $router->render('/paginas/propiedad', [
            "propiedad" => $propiedad
        ]);
    }
    public static function blog(Router $router)
    {
        $router->render('/paginas/blog');
    }
    public static function entrada(Router $router)
    {
        $router->render('paginas/entrada');
    }

    public static function contacto(Router $router)
    {
        $mensaje = null; //Se utiliza para el mensaje de exito o no
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $_POST['contacto'];
            

            //Crear una instancia de phpmailer
            $mail = new PHPMailer;
            //Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = 'c7996675630a8d';
            $mail->Password = 'e049f264f053f3';
            $mail->SMTPSecure = 'tls'; //Encriptación
            $mail->Port = 2525;

            //Configurar el contenido del email
            $mail->setFrom('admin@bienesraices.com'); //Email de quien nos envia el correo
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com'); //Email al que llega el correo / Nombre
            $mail->Subject = 'Tienes un nuevo mensaje'; //Titulo del mensaje

            //Contenido del html
            $mail->isHTML(true); //Habilita el html
            $mail->CharSet = 'UTF-8'; //Conjunto de caracteres permitidos

            $contenido = '<html>';
            $contenido .= '<p>Nombre: ' . $resultado['nombre'] . '</p> ';
            $contenido .= '<p>Mensaje: ' . $resultado['mensaje'] . '</p> ';

            //Si el usuario dedcide ser contactado por telefono
            if ($resultado['contacto'] === 'telefono') {
                $contenido .= '<p>El usuario decidio ser contactado por telefono:</p>';
                $contenido .= '<p>Telefono: ' . $resultado['telefono'] . '</p> ';
                $contenido .= '<p>Fecha: ' . $resultado['fecha'] . '</p> ';
                $contenido .= '<p>Hora: ' . $resultado['hora'] . '</p> ';
            }else{
                /**EL usuario decidio ser contactado por email */
                $contenido .= '<p>El usuario decidio ser contactado por email:</p>';
                $contenido .= '<p>Email: ' . $resultado['email'] . '</p> ';
            }

            $contenido .= '<p>Compra o Vende: ' . $resultado['tipo'] . '</p> ';
            $contenido .= '<p>Presupuesto: $' . $resultado['presupuesto'] . '</p> ';

            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es un texto alternativo sin html';

            /**Si el mensaje se envio correctamente */
            if ($mail->send()) {
                $mensaje = 'Mensaje Enviado Correctamente';
            } else {
                $mensaje = 'El mensaje no se pudo enviar';
            }
        }
        $router->render('/paginas/contacto', [
            "mensaje" => $mensaje
        ]);
    }
}
