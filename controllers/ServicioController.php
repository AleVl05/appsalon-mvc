<?php 

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController{
    public static function index( Router $router){

        $servicios = Servicio::all();

        if (session_status() === PHP_SESSION_NONE) {
               session_start();
        }

        isAdmin();



        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'] ?? '', 
            'servicios' => $servicios,
        ]);
    }




    public static function crear( Router $router){
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        isAdmin();

        $servicio = new Servicio(); //se crea un objeto vacio
        $alertas = [];
     
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $servicio->sincronizar($_POST); // se le añade lo que esta en el post al objeto
            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'] ?? '', 
            'servicio' => $servicio,  // mandas esa informacion para llenar los values
            'alertas' => $alertas,  // mandas esa informacion para llenar los values
            
        ]);

    }
    




    public static function actualizar ( Router $router){
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        isAdmin();


        if(!is_numeric($_GET['id'])) return;
        
        $servicio = Servicio::find($_GET['id']);
        $alertas = [];
     
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'] ?? '', 
            'servicio' => $servicio, 
            'alertas' => $alertas,  
            
        ]);

    }

    public static function eliminar(){
        

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        isAdmin();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $servicio = Servicio::find($_POST['id']);
            $servicio->eliminar();
            header('Location: /servicios');
            
        }

    }
}