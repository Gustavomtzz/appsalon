<?php

namespace Controllers;

use Model\AdminCita;
use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;


class ApiController
{
    public static function index()
    {
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    public static function guardar()
    {
        //**Almacena la Cita y Devuelve el ID **/
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();
        $id = $resultado['id'];

        //**Almacena la Cita y el Servicio**/

        //Separo el ARRAY de los Servicios despues de una 'COMA';
        $idServicios = explode(',', $_POST['servicios']);

        //Almacena los Servicios con el ID de la Cita
        foreach ($idServicios as $idServicio) {
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $resultado = $citaServicio->guardar();
        }

        //Retornamos una Respuesta
        $respuesta = [
            'resultado' => $resultado,
        ];
        //Mostramos la Respuesta
        echo json_encode($respuesta);
    }


    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            //Verifico que no este Vacio el ID
            if (empty($_POST['id'])) {
                header('Location: /admin?error="ID VACIO');
            }
            //Asigno el ID a la variable
            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            if ($id) {
                //Busco el ID en la tabla cita y creo el objeto en memoria
                $cita = Cita::find($id);
                //Si hay un OBJETO en la tabla CITA, lo ELIMINO
                if ($cita) {
                    $cita->eliminar();
                    header('Location: /admin');
                } else {
                    header('Location: /admin?error="ID incorrecto"');
                }
            } else {
                header('Location: /admin?error="ID NO VALIDO"');
            }
        }
    }
}
