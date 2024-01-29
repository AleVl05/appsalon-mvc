<?php 

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIcontroller{
    public static function index(){
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    public static function guardar(){

        $cita = new Cita($_POST); // el post que le llega de js (tambien puedes mandar por postman)
        $resultado = $cita->guardar(); 


        $IdServicios = explode(",", $_POST['servicios']);

        foreach($IdServicios as $idservicio){
            $inyeccion = [
                'citaId' => $resultado['id'],
                'servicioId' => $idservicio
            ];
            $citaServicio = new CitaServicio($inyeccion);
            $citaServicio->guardar();
        }

        $respuesta = [
            'resultado' => $resultado,
        ];

        echo json_encode($respuesta); // lo que manda a js 
            


        // $respuesta = [ //este es un objeto de php, que sera trasformado a un objeto de JS con JSON
        //     'mensaje' => $_POST //este post se esta mandando desde js en un dataform y abajo se lo mandas a la pagina, que al mismo tiempo retorna de nuevo a JS!
        // ];


        // echo json_encode($respuesta); //ese echo sera el contenido que se mostraria cuando se cargue la pagina, como no hay pagina, solo puedes acceder a el con postman y con fetch de JS
    }

    public static function eliminar(){
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id =$_POST['id'];
            $cita = Cita::find($id);
            $cita->eliminar();
            header('Location' . $_SERVER['HTTP_REFERER']); //EPICOOO, aqui te manda a la ultima pagina donde estabas!! 
        }
    }
}

