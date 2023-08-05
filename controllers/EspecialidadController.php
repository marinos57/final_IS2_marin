<?php

namespace Controllers;

use Exception;
use Model\Especialidad;
use MVC\Router;

class EspecialidadController{
    public static function index(Router $router){
        $especialidades = Especialidad::all();
       
        $router->render('especialidades/index', [
            'especialidades' => $especialidades,
   
        ]);

    }

    public static function guardarAPI(){
        try {
            $especialidad = new Especialidad($_POST);
            $resultado = $especialidad->crear();

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
            $especialidad = new Especialidad($_POST);
            $resultado = $especialidad->actualizar();

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
            // Verificar que se reciba el ID de la especialidad en la solicitud POST
            if(isset($_POST['especialidad_id'])){
                $especialidad_id = $_POST['especialidad_id'];
                $especialidad = Especialidad::find($especialidad_id);
                
                // Verificar si se encontró la especialidad con el ID proporcionado
                if(!$especialidad){
                    echo json_encode([
                        'mensaje' => 'La especialidad no existe en la base de datos',
                        'codigo' => 0
                    ]);
                    return;
                }
    
                // Actualizar la propiedad "especialidad_situacion" para marcar la especialidad como eliminada
                $especialidad->especialidad_situacion = 0;
                $resultado = $especialidad->actualizar();
    
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
                    'mensaje' => 'No se proporcionó el ID de la especialidad',
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
        $especialidad_nombre = $_GET['especialidad_nombre'];
       

        $sql = "SELECT * FROM especialidades where especialidad_situacion = 1 ";
        if($especialidad_nombre != '') {
            $sql.= " and especialidad_nombre like '%$especialidad_nombre%' ";
        }
        try {
            
            $especialidades = Especialidad::fetchArray($sql);
    
            echo json_encode($especialidades);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
}