<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    public $email;
    public $nombre;
    public $token;
    public $url;
    public $mensaje = [];

    public function __construct($email, $nombre, $token, $url)
    {

        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
        $this->url = $url;
    }


    public function enviarEmail()
    {
        //Crear una Instancia de PHPMAILER
        $phpmailer = new PHPMailer();

        //Configurar SMTP

        $phpmailer->isSMTP();
        $phpmailer->Host = $_ENV['EMAIL_HOST'];
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = $_ENV['EMAIL_PORT'];
        $phpmailer->Username = $_ENV['EMAIL_USER'];
        $phpmailer->Password = $_ENV['EMAIL_PASS'];

        //Quien ENVIA con setFROM y donde recibe en addAdrress
        $phpmailer->setFrom('admin@bienesraices.com', "BienesRaices"); //Quien Envia
        $phpmailer->addAddress($this->email, $this->nombre);     //Agregar Receptor

        //Contenido del Email
        //Habilitar HTML
        $phpmailer->isHTML(true);  //Permitimos HTML
        //Codificacioon UTF-8
        $phpmailer->CharSet = 'UTF-8';
        //Titulo cuando llega el mensaje antes de entrar al mismo
        $phpmailer->Subject = 'Confirmar tu cuenta';

        //Contenido
        $contenido = "<p>Salon APP MVC</p>";
        $contenido .= "Nombre: " . $this->nombre . "<br>";
        $contenido .= " Email: " . $this->email . "<br>";
        $contenido .= " TOKEN ACTIVACIÓN: " . $this->token . "<br>";
        $contenido .= "<a href=" . $_ENV["APP_URL"] . $this->url . "?token=" . $this->token . ">Click para Confirmar Cuenta</a>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta o email, ignora el mensaje</p>";

        $phpmailer->Body = $contenido; //Con HTML
        $phpmailer->AltBody = 'Este es un nuevo Email. Buenos Dias'; //Alternativo en caso de que no soporte HTML el servicio de mail
        $resultado = $phpmailer->send();


        if ($resultado) {
            $this->mensaje['exito'] = "Mensaje enviado Correctamente";
        } else {
            $this->mensaje['error'] = "El mensaje no se pudo enviar: {$phpmailer->ErrorInfo}";
        }

        return $this->mensaje;
    }
}
