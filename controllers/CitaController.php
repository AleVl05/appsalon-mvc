<?php 

namespace Controllers;

use MVC\Router;

class CitaController {
    public static function index(Router $router){

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        isAuth();
        
        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre'] ?? '', //EPICO! UNA SUPER UTILIDAD DE LA GLOBAL SESSION
            'id' => $_SESSION['id'] ?? '', 
        ]);
    }
}