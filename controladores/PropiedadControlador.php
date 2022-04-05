<?php

//Se comunica con el modelo y llama y recibe datos de la vista

namespace Controlador;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadControlador
{

    public static function index(Router $router)
    {
        /**No se crea una nueva instacia de router
         * Se pasa un objeto de tipo router a la funcion y no perder la referencia al objeto del index
         */

        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();

        $resultado = $_GET['resultado'] ?? null;

        $router->render('propiedades/admin', [
            "propiedades" => $propiedades,
            "resultado" => $resultado,
            "vendedores" => $vendedores
        ]);
    }

    public static function crear(Router $router)
    {
        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();

        $errores = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $propiedad = new Propiedad($_POST['propiedad']);

            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                //generar un nombre único
                $extensionImagen = explode('/', $_FILES['propiedad']['type']['imagen']); // image/jpeg : image/png
                $nombreImagen = md5(uniqid(rand(), true)) . '.' . $extensionImagen[1];
                //Reliza un resize a la imagen con Intervention
                $imagen = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600); //Abre el archivo y ajusta su tamaño
                $propiedad->setImagen($nombreImagen);
            }
            // //Validación de información
            $errores = $propiedad->validar();

            //Revisar que el array de errores esté vacío
            if (empty($errores)) {

                //Subir los archivos al servidor
                if (!is_dir(CARPETA_IMAGENES)) { //Define si existe o no una carpeta especifica
                    mkdir(CARPETA_IMAGENES); //Crea la carpeta
                }
                $imagen->save(CARPETA_IMAGENES . $nombreImagen); //Guarda la IMAGEN en el servidor

                $resultado = $propiedad->guardar(); //Insertar datos en la bd
            }
        }

        $router->render('propiedades/crear', [
            "propiedad" => $propiedad,
            "vendedores" => $vendedores,
            "errores" => $errores
        ]);
    }

    public static function actualizar(Router $router)
    {
        $id = validarORedireccionar('/admin');
        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        //Ejecutar el código después que el usuario envía el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            /**POO
             * Sincronizar el array asociativo de la superglobal POST y almacenar en memoria como un objeto
             */
            $propiedad->sincronizar($_POST['propiedad']);

            /**Subir archivos o imagenes POO con Intervention Image*/
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                //generar un nombre único
                $extensionImagen = explode('/', $_FILES['propiedad']['type']['imagen']); // image/jpeg : image/png
                $nombreImagen = md5(uniqid(rand(), true)) . '.' . $extensionImagen[1];

                $imagen = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                $propiedad->setImagen($nombreImagen);
            }

            /**POO
             * Validación de atributos de la clase en memoria
             */
            $errores = $propiedad->validar();

            //Revisar que el array de errores esté vacío
            if (empty($errores)) {
                //Subir los archivos al servidor
                /**POO */
                if ($_FILES['propiedad']['tmp_name']['imagen']) {
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                }

                $propiedad->guardar();
            }
        }
        $router->render('propiedades/actualizar', [
            "propiedad" => $propiedad,
            "errores" => $errores,
            "vendedores" => $vendedores
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
                    //Obtener el registro con el id específico
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                } else {
                    header('location: /admin');
                }
            }
        }
    }
}
