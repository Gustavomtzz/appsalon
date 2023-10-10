<?php

namespace Controllers;

use Classes\Email;
use MVC\Router;
use Model\Usuario;


class LoginController
{

    public static function index(Router $router)
    {
        $mensaje = null;
        $errores = [];
        if (isset($_GET['msj'])) {
            $mensaje = intval($_GET['msj']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $errores = $auth->validarLogin();
            if (empty($errores)) {
                $existeUsuario = $auth::where('email', $auth->email);
                if ($existeUsuario) {
                    $passwordCorrecto = $auth->comprobarPassword($existeUsuario->password);
                    if ($passwordCorrecto) {
                        $confirmado = $existeUsuario->confirmado;
                        if ($confirmado === "1") {
                            session_start();
                            $_SESSION['login'] = true;
                            $_SESSION['email'] = $auth->email;
                            $_SESSION['usuarioId'] = $existeUsuario->id;
                            $_SESSION['nombre'] = $existeUsuario->nombre . " " . $existeUsuario->apellido;

                            //Reedireccionamos
                            if ($existeUsuario->admin === "1") {
                                $_SESSION['admin'] = $existeUsuario->admin;
                                header('Location: /admin');
                            } else {
                                header('Location: /cita');
                            }
                        }
                    } else {
                        $errores = $auth::getAlertas();
                    }
                } else {
                    $errores['error'][] = 'Usuario Inexistente';
                }
            }
        }



        $router->render('paginas/index', [
            'errores' => $errores,
            'mensaje' => $mensaje
        ]);
    }

    public static function logout()
    {
        $sesion = cerrarSesion();
        if ($sesion) {
            header('Location: /');
        }
    }
    public static function olvide(Router $router)
    {
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $validarEmail = $auth->validarEmail();

            if ($validarEmail) {
                //Busco el Usuario en la Columna Email y le paso el EMAIL que ESCRIBIO
                $usuario = Usuario::where('email', $auth->email);
                //Verificar si Hay usuario con el Email dado
                if ($usuario && $usuario->confirmado === "1") {
                    //Generar Token nuevo
                    $usuario->crearToken();

                    //Enviar Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token, 'recuperar');
                    $enviado = $email->enviarEmail();

                    //Si el EMAIL se envio correctamente
                    if ($enviado) {
                        $usuario->confirmado = "0";
                        $usuario->guardar();

                        $alertas['exito'][] = "Revisa tu Email";
                    } else {
                        $alertas['error'][] = "El Email no se pudo enviar";
                    }
                } else {
                    $alertas['error'][] = "Usuario no encontrado o no confirmado";
                }
            } else {
                $alertas = Usuario::getAlertas();
            }
        }


        $router->render('paginas/olvide', [
            'errores' => $alertas
        ]);
    }
    public static function recuperar(Router $router)
    {
        $token = "";
        $alertas = [];
        $error = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_GET['token'])) {
                $token = s($_GET['token']);
            }
            $usuario = Usuario::where('token', $token);

            if (!empty($usuario)) {
                if (!empty($_POST['password']) && strlen($_POST['password']) >= 6) {
                    $usuario->password = s($_POST['password']);
                    $usuario->hashPassword();
                    $usuario->token = "";
                    $usuario->confirmado = "1";
                    $usuario->guardar();
                    header('Location: /?msj=3');
                } else {
                    $alertas['error'][] = "El Password es Obligatorio";
                    $alertas['error'][] = "El Password debe tener al menos 6 caracteres";
                }
            } else {
                $alertas['error'][] = "TOKEN NO VÁLIDO";
                $error = true;
            }
        }

        $router->render('paginas/recuperar', [
            'token' => $token,
            'errores' => $alertas,
            'error' => $error
        ]);
    }
    public static function crear(Router $router)
    {

        $usuario = new Usuario;
        $errores = [];
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $usuario->sincronizar($_POST);
            $usuario->validarDatos();
            $errores = $usuario->getAlertas();

            if (!$errores) {
                //Verificar que el usuario no este registrado
                $noExiste = $usuario->existeUsuario();

                if ($noExiste->num_rows === 0) {
                    //Hashear Password
                    $usuario->hashPassword();
                    //Generar un Token Único
                    $usuario->crearToken();
                    //Enviar Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token, 'confirmar-cuenta');
                    $enviado = $email->enviarEmail();

                    if ($enviado) {
                        $resultado = $usuario->guardar();

                        if ($resultado['resultado'] === true) {
                            $usuario->redireccionar("/mensaje");
                        }
                    }
                } else {
                    $errores = $usuario->getAlertas();
                }
            }
        }

        $router->render('paginas/crear-cuenta', [
            'usuario' => $usuario,
            'errores' => $errores
        ]);
    }


    public static function confirmar(Router $router)
    {

        $alertas = [];
        $token = null;

        if (isset($_GET['token'])) {
            $token = s($_GET['token']);
        }

        $usuario = Usuario::where('token', $token);

        if (!empty($usuario)) {
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
            $alertas['exito'][] = 'Usuario Creado Correctamente';
        } else {
            $alertas['error'][] = 'TOKEN NO VÁLIDO';
        }

        $router->render('paginas/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router)
    {
        $router->render('paginas/mensaje');
    }

    public static function listarServicios(Router $router)
    {
        $router->render('paginas/servicios');
    }
}
