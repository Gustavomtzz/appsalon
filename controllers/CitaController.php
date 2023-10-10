<?php

namespace Controllers;


use MVC\Router;


class CitaController
{
    public static function index(Router $router)
    {
        if (empty($_SESSION)) {
            session_start();
        }

        $router->render('cliente/cita', [
            'nombreCliente' => $_SESSION['nombre'],
            'id' => $_SESSION['usuarioId']
        ]);
    }
}
