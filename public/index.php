<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;

use Controllers\AdminController;
use Controllers\ApiController;
use Controllers\CitaController;
use Controllers\LoginController;
use Controllers\ServicioController;

$router = new Router();

//Iniciar Sesion
$router->get("/", 'Controllers\\' . "LoginController::index"); //Otra Manera de Pasarle la funcion con NAMESPACE
$router->post("/", [LoginController::class, 'index']);
$router->get("/logout", [LoginController::class, 'logout']);

//Recuperar Password con Email
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);

//Confirmar TOKEN para nueva Contraseña
$router->get('/recuperar', [LoginController::class, 'recuperar']);
$router->post('/recuperar', [LoginController::class, 'recuperar']);

//Confirmar Cuenta
$router->get('/confirmar-cuenta', [LoginController::class, 'confirmar']);
$router->get('/mensaje', [LoginController::class, 'mensaje']);

//Crear Cuenta
$router->get('/crear-cuenta', [LoginController::class, 'crear']);
$router->post('/crear-cuenta', [LoginController::class, 'crear']);

//**AREA CLIENTES */
//Listar CITAS
$router->get('/api/servicios', [ApiController::class, 'index']);
$router->post('/api/citas', [ApiController::class, 'guardar']);
$router->post('/api/eliminar', [ApiController::class, 'eliminar']);

//Crear CITAS
$router->get('/cita', [CitaController::class, 'index']);
$router->post('/cita', [CitaController::class, 'index']);
//Area de Citas
//**FIN AREA CLIENTES */

//**AREA ADMINISTRADOR */
$router->get('/admin', [AdminController::class, 'index']);

//CRUD SERVICIOS
$router->get('/servicios', [ServicioController::class, 'index']);
$router->get('/servicios/crear', [ServicioController::class, 'crear']);
$router->post('/servicios/crear', [ServicioController::class, 'crear']);
$router->get('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->post('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->post('/servicios/eliminar', [ServicioController::class, 'eliminar']);

/**FIN AREA ADMINISTRADOR */

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
