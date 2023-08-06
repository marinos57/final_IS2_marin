<?php

namespace Controllers;

use Exception;
use Model\Paciente;
use MVC\Router;

class PacienteController{
    public static function index(Router $router){
        $pacientes = Paciente::all();
        // $pacientes2 = Producto::all();
        // var_dump($pacientes);
        // exit;
        $router->render('pacientes/index', [
            'pacientes' => $pacientes,
            // 'productos2' => $productos2,
        ]);

    }

    public static function guardarAPI(){
        try {
            $paciente = new Paciente($_POST);
            $resultado = $paciente->crear();

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
            $paciente = new Paciente($_POST);
            $resultado = $paciente->actualizar();

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
          
            if(isset($_POST['paciente_id'])){
                $paciente_id = $_POST['paciente_id'];
                $paciente = Paciente::find($paciente_id);
                
    
                if(!$paciente){
                    echo json_encode([
                        'mensaje' => 'El paciente no existe en la base de datos',
                        'codigo' => 0
                    ]);
                    return;
                }
    
        
                $paciente->paciente_situacion = 0;
                $resultado = $paciente->actualizar();
    
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
                    'mensaje' => 'No se proporcionó el ID del paciente',
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
        $paciente_nombre = $_GET['paciente_nombre'];
        $paciente_dpi = $_GET['paciente_dpi'];
        $paciente_telefono = $_GET['paciente_telefono'];


        $sql = "SELECT * FROM pacientes where paciente_situacion = 1 ";
        if($paciente_nombre != '') {
            $sql.= " and paciente_nombre like '%$paciente_nombre%' ";
        }
        if($paciente_dpi != '') {
            $sql.= " and paciente_dpi = $paciente_dpi ";
        }
        if($paciente_telefono != '') {
            $sql.= " and paciente_telefono = $paciente_telefono ";
        }
        try {
            
            $pacientes = Paciente::fetchArray($sql);
    
            echo json_encode($pacientes);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
}