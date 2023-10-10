<?php

namespace Model;

use Model\ActiveRecord;


class Usuario extends ActiveRecord
{
    //Tabla de BD
    protected static $tabla = "usuarios";
    //Mapear Atributos
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];


    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;


    public function __construct($args = [])
    {

        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
    }

    //Validar Datos 
    public function validarDatos()
    {
        // Validar Campos
        if (!$this->nombre) {
            self::$alertas['error'][] = "El Nombre del Cliente es Obligatorio";
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = "El Apellido del Cliente es Obligatorio";
        }
        if (!$this->telefono) {
            self::$alertas['error'][] = "El Telefono del Cliente es Obligatorio";
        }
        if (strlen($this->telefono) > 10) {
            self::$alertas['error'][] = "El Telefono no puede ser Mayor a 10 Caracteres";
        }
        if (!$this->email) {
            self::$alertas['error'][] = "El Email del Cliente es Obligatorio";
        }
        if (!$this->password) {
            self::$alertas['error'][] = "El Password del Cliente es Obligatorio";
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = "El Password debe contener al menos 6 caracteres";
        }


        // Validar Campos
        return self::$alertas;
    }

    public function validarLogin()
    {
        if (!$this->email) {
            self::$alertas['error'][] = "El Email del Cliente es Obligatorio";
        }
        if (!$this->password) {
            self::$alertas['error'][] = "El Password esta Vacio";
        }
        // Validar Campos
        return self::$alertas;
    }

    public function validarEmail()
    {
        if (!$this->email) {
            self::$alertas['error'][] = "El Email del Cliente es Obligatorio";
            return;
        }
        return true;
    }

    public function existeUsuario()
    {
        $query = "SELECT * FROM " . self::$tabla . " WHERE email='" . $this->email . "' LIMIT 1";
        $resultado = static::$db->query($query);

        if ($resultado->num_rows) {
            self::$alertas['error'][] = "El Usuario ya esta registrado";
        }
        return $resultado;
    }

    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }


    public function comprobarPassword($passwordHash)
    {
        $auth = password_verify($this->password, $passwordHash);
        if (!$auth) {
            self::$alertas['error'][] = 'El Password es incorrecto';
        }

        return $auth;
    }

    public function crearToken()
    {
        $this->token = uniqid();
    }


    public function redireccionar($pagina)
    {
        header('Location:' . $pagina);
    }
}
