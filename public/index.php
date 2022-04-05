<?php 

/**Archivo que gestiona internamente todas las conexiones en la arquitectura MVC */

/**Incluye
 * La conexion a la bd
 * Funciones o helpers
 * El autoload
 */
require_once __DIR__ . '/../includes/app.php';

/**Se utiliza
 * La clase router: gestiona las rutas y llamadas a controladores
 * Se importan los controladores: encargados de ejecutar y accionar una funcion
 */
use MVC\Router; //Usar el namespace de la clase router
use Controlador\PropiedadControlador;
use Controlador\VendedorControlador;
use Controlador\PaginasControlador; 
use Controlador\LoginControlador;

$router = new Router; // Nueva instancia de router

/**Administracion de rutas privadas: El usuario no triene acceso */
/**
 * Se obtiene la una url especifica la cual queda como key en el arreglo rutasGET del router.
 * Se pasan dos valores: el nombre de la clase especificando su namespace \namespace\clase y la funcion que se va a ejecutar 'index()'.
 */
/**Propiedades */
$router->get('/admin',[PropiedadControlador::class,'index']);
$router->get('/propiedades/crear',[PropiedadControlador::class,'crear']);
$router->post('/propiedades/crear',[PropiedadControlador::class,'crear']);
$router->get('/propiedades/actualizar',[PropiedadControlador::class,'actualizar']);
$router->post('/propiedades/actualizar',[PropiedadControlador::class,'actualizar']);
$router->post('/propiedades/eliminar',[PropiedadControlador::class,'eliminar']);

/**Vendedores */
$router->get('/vendedores/crear',[VendedorControlador::class,'crear']);
$router->post('/vendedores/crear',[VendedorControlador::class,'crear']);
$router->get('/vendedores/actualizar',[VendedorControlador::class,'actualizar']);
$router->post('/vendedores/actualizar',[VendedorControlador::class,'actualizar']);
$router->post('/vendedores/eliminar',[VendedorControlador::class,'eliminar']);

/**Se gestionan las rutas publicas: cualquier usuario tiene acceso a estas paginas */
/**Páginas públicas*/
$router->get('/',[PaginasControlador::class,'index']);
$router->get('/nosotros',[PaginasControlador::class,'nosotros']);
$router->get('/propiedades',[PaginasControlador::class,'propiedades']);
$router->get('/propiedad',[PaginasControlador::class,'propiedad']);
$router->get('/blog',[PaginasControlador::class,'blog']);
$router->get('/entrada',[PaginasControlador::class,'entrada']);
$router->get('/contacto',[PaginasControlador::class,'contacto']);
$router->post('/contacto',[PaginasControlador::class,'contacto']);

/**Rutas para el login de usuarios */
$router->get('/login',[LoginControlador::class,'login']);
$router->post('/login',[LoginControlador::class,'login']);
$router->get('/logout',[LoginControlador::class,'logout']);

//Se comprueba que existan dichas rutas y que haya un controlador y funcion asociada a ellas
$router->comprobarRutas(); //Llama la funcion de comprobar rutas