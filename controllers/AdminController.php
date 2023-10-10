<?php


namespace Controllers;

use MVC\Router;
use Model\AdminCita;

class AdminController
{


    public static function index(Router $router)
    {
        $alertas = [];

        $fecha = $_GET['fecha'] ?? date('Y-m-d', strtotime('+1 day'));
        $fechas = explode('-', $fecha);

        if (!checkdate($fechas[1], $fechas[2], $fechas[0])) {
            $alertas['error'][] = "Fecha no Válida";
            $fecha = date('Y-m-d', strtotime('+1 day'));
        }

        //Consultar la Base de Datos
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasServicios ";
        $consulta .= " ON citasServicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasServicios.servicioId ";
        $consulta .= " WHERE fecha =  '$fecha' ";

        $consulta = AdminCita::SQL($consulta);

        count($consulta) === 0 ? $alertas['error'][] = 'No hay Citas para esta Fecha' : '';

        $router->render('admin/index', [
            'nombreCliente' => $_SESSION['nombre'],
            'citas' => $consulta,
            'fecha' => $fecha,
            'errores' => $alertas
        ]);
    }
}
