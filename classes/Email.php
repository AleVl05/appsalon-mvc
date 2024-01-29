<?php 

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre , $token) {

        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;

    }

    public function enviarConfirmacion(){

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];



        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'Appsalon.com');
        $mail->Subject = 'confirma tu cuenta';


        //SET HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en Appsalon, solo debes confirmarla hacinedo click en el siguiente enlace:</p>";
        $contenido .= "<p>Presiona aqui: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        //enviar
        
        $mail->send();

        //SI NECESITAS VALIDAR USA ESTO:
        // if (!$mail->send()) {
        //     echo 'Error: ' . $mail->ErrorInfo;
        // } else {
        //     echo 'Correo enviado exitosamente!';
        // }

    }

    public function enviarInstruccionesRecuperarPassword(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];


        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'Appsalon.com');
        $mail->Subject = 'restablece tu contraseña';


        //SET HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitador recuperar tu contraseña, haz click en el siguiente enlace para restablecerla:</p>";
        $contenido .= "<p>Presiona aqui: <a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "'>Reestablecer contraseña</a></p>";
        $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        //enviar
        
        $mail->send();
    }
}