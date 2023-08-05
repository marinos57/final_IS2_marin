<?php

namespace Controllers;

use Exception;
use Model\Clinica;
use MVC\Router;

class ClinicaController{
    public static function index(Router $router){
        $clinicas = Clinica::all();
       
        $router->render('clinicas$clinicas/index', [
            'clinicas$clinicas' => $clinicas,
   
        ]);

    }

    public static function guardarAPI(){
        try {
            $clinica = new Clinica($_POST);
            $resultado = $clinica->crear();

            if($resultado['resultado'] == 1){
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1
                ]);
            }else{
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
            }
            // echo json_encode($resultado);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    public static function modificarAPI(){
        try {
            $clinica = new Clinica($_POST);
            $resultado = $clinica->actualizar();

            if($resultado['resultado'] == 1){
                echo json_encode([
                    'mensaje' => 'Registro modificado correctamente',
                    'codigo' => 1
                ]);
            }else{
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
            }
            // echo json_encode($resultado);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    public static function eliminarAPI(){
        try {
          
            if(isset($_POST['clinica_id'])){
                $clinica_id = $_POST['clinica_id'];
                $clinica = Clinica::find($clinica_id);
                
             
                if(!$clinica){
                    echo json_encode([
                        'mensaje' => 'La clinica no existe en la base de datos',
                        'codigo' => 0
                    ]);
                    return;
                }
    
                $clinica->clinica_situacion = 0;
                $resultado = $clinica->actualizar();
    
                if($resultado['resultado'] == 1){
                    echo json_encode([
                        'mensaje' => 'Registro eliminado correctamente',
                        'codigo' => 1
                    ]);
                }else{
                    echo json_encode([
                        'mensaje' => 'Ocurrió un error al eliminar el registro',
                        'codigo' => 0
                    ]);
                }
            } else {
                echo json_encode([
                    'mensaje' => 'No se proporcionó el ID de la clinica',
                    'codigo' => 0
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
    

    public static function buscarAPI(){
        // $productos = Producto::all();
        $clinica_nombre = $_GET['clinica_nombre'];
       

        $sql = "SELECT * FROM clinicas where clinica_situacion = 1 ";
        if($clinica_nombre != '') {
            $sql.= " and clinica_nombre like '%$clinica_nombre%' ";
        }
        try {
            
            $clinicas = Clinica::fetchArray($sql);
    
            echo json_encode($clinicas);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
}