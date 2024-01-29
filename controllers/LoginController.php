<?php 

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router){
        $alertas= [];
        $auth = null;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
            $auth = new Usuario($_POST); //esto es lo que escribio el usuario


            $alertas = $auth->validarLogin(); //retorna alertas si hay errores
        
            if(empty($alertas)){
                //verificar si el usuario existe viendo el email
                $usuario = Usuario::where('email', $auth->email);
                if($usuario){
                    //verificar password
                    
                    if( $usuario->comprobarPasswordAndVerificado($auth->password) ){ //quisquilloso
                       


                        //inicia sesion
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        $_SESSION['admin'] = $usuario->admin;
                        //debuguear($_SESSION);

                        if ($usuario->admin === "1") {  //ASI SE HACE ROLES!!
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        }else{
                            echo "cliente";
                            header('Location: /cita');
                        }
                    }
                }
                else{
                    $auth->setAlerta('error','Che pibe, no existe una cuenta con este nombre');
                    
                }
            }
        }

        $alertas = $auth ? $auth->getAlertas() : []; 
        $router->render('auth/login',[
            'alertas' => $alertas,
        ]);

    }  

    public static function logout(){
        session_start();

        $_SESSION = []; //cierra la session al entrar al link simplemente jaja  

        header('Location: /');
  
    }  

    public static function olvide(Router $router){
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            $alertas = $auth->validarEmail();

            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);

                if($usuario && $usuario->confirmado === "1"){ //si el usuario existe y esta confirmad
                    
                    $usuario->creartoken();
                    $usuario->guardar();

                    //enviar email

                    $email = new Email($usuario->email ,$usuario->nombre,$usuario->token);
                    $email->enviarInstruccionesRecuperarPassword();



                    Usuario::setAlerta('exito', 'El codigo de recuperacion enviado a tu email');
                    $alertas = Usuario::getAlertas();

                }
                else{
                   Usuario::setAlerta('error', 'el usuario no existe o no esta confirmado');
                   $alertas = Usuario::getAlertas();
                }
        
            }
        }


        $router->render('auth/olvide-password', [
            'alertas' => $alertas
        ]);
    }


    public static function recuperar(Router $router){
        $alertas = [];

        $token = s($_GET['token']);
        $error = null;
        //buscar usuario por su token
        $usuario = Usuario::where('token', $token);
        
        
        if(empty($usuario)){ //si el token no es valido
            Usuario::setAlerta('error', 'Token no válido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //leer el nuevo password y guardarlo
            $passwordNueva = new Usuario($_POST);

            $alertas = $passwordNueva->validarPassword();

            if(empty($alertas)){
                $usuario->password = null; //borra el password anterior
                $usuario->password = $passwordNueva->password; //ahora es = al que puso el usuario
                $usuario->hashPassword(); //hashea el nuevo password
                $usuario->token = null; //elimina el token

                $resultado = $usuario->guardar();
                if($resultado){ //si el guardar se ejecuta correctamente manda true
                    header('Location: /');             
                }
            }
        }

        

        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password',[
            'alertas' => $alertas,
            'error' => $error,

        ]);
    }


    public static function crear(Router $router){

        $usuario = new Usuario($_POST);
        $alertas = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $usuario->sincronizar($_POST); //ESTO ES PORQUE el usuario de arriba no esta definido en este if, el profe explicara mejor despues
        $alertas = $usuario->validarNuevaCuenta();  
        
        
        if(empty($alertas)){
            // ver si el usuario existe despues de que no hay errores:
            
                $resultado = $usuario->existeUsuario(); 
                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas(); // los gets son perfectos para traer algo despues, AQUI DIRA QUE EL USUARIO YA FUE CREADO porque hay un numrow
                } else{
                    $usuario->hashPassword();
                    $usuario->crearToken();

                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    
                    $email->enviarConfirmacion();

                    // debuguear($usuario);
                    $resultados2 = $usuario->guardar(); 

                    if($resultados2){
                        header('Location: /mensaje');
                    }
                }


            }
        }

        $router->render('auth/crear-cuenta', [
            'usuarioEnviado' =>$usuario, //usuarioEnviado puede ser usado en TODAS LAS PAGINAS AHORA
            'alertas' => $alertas //alertas puede ser usado en TODAS LAS PAGINAS AHORA
        ]);
    }

    
    public static function mensaje(Router $router){

        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router){
        $alertas = [];

        $tokenUrl = s($_GET['token']);

        $usuario = Usuario::where('token', $tokenUrl); //esto basicamente es como poner un new Usuario, porque esta recibiendo todo el objeto con ese id que es el token

        if(empty($usuario)){
            debuguear($usuario);
            Usuario::setAlerta('error', 'Token no valido');
            $alertas = Usuario::getAlertas(); //asi va a actualizar el cambio de arriba
        }else{
            $usuario->confirmado = "1"; // aqui inteliphense se puso quisquilloso pero pone 1 a confr
            $usuario->token = null; //aqui elimina el token
            $usuario->guardar(); // y aqui guarda los cambios porque ya existe el id
            Usuario::setAlerta('exito', 'Token validado correctamente');
            $alertas = Usuario::getAlertas(); //asi va a actualizar el cambio de arriba
        }

        //debuguear($usuario);
        
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas

        ]);
    }


    
}
