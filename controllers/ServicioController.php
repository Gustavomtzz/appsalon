<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController
{

    public static function index(Router $router)
    {
        $servicios = Servicio::all();

        $router->render('/servicios/index', [
            'nombreCliente' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]);
    }
    public static function crear(Router $router)
    {

        $servicio = new Servicio;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $alertas =  $servicio->validar();

            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /admin');
            }
        }


        $alertas = Servicio::getAlertas();
        $router->render('/servicios/crear', [
            'nombreCliente' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'errores' => $alertas
        ]);
    }
    public static function actualizar(Router $router)
    {

        //Asigno el ID a la variable

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if ($id) {
            //Busco el ID en la tabla cita y creo el objeto en memoria
            $servicio = Servicio::find($id);
        } else {
            header('Location: /servicios');
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }


        $alertas = Servicio::getAlertas();
        $router->render('/servicios/actualizar', [
            'nombreCliente' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'errores' => $alertas
        ]);
    }

    public static function eliminar(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Asigno el ID a la variable
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                //Busco el ID en la tabla cita y creo el objeto en memoria
                $servicio = Servicio::find($id);
                if ($servicio) {
                    $servicio->eliminar();
                    header('Location: /servicios');
                } else {
                    header('Location: /servicios');
                }
            } else {
                header('Location: /servicios');
            }
        }
    }
}
