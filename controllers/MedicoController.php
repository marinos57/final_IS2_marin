<?php

namespace Controllers;

use Exception;
use Model\Medico;
use Model\Clinica;
use Model\Especialidad;
use MVC\Router;

class MedicoController{
    public static function index(Router $router) {
        $medicos = Medico::all();
       
         // Obtener solo las especialidades activas
             // Obtener solo las especialidades activas
             $especialidades = Especialidad::consultarSQL("SELECT * FROM especialidades WHERE especialidad_situacion = 1");

             // Obtener solo las clínicas activas
             $clinicas = Clinica::consultarSQL("SELECT * FROM clinicas WHERE clinica_situacion = 1");
     
 
        //  var_dump($especialidades);
        //  var_dump($clinicas);

        //  exit();
         $router->render('medicos/index', [
             'medicos' => $medicos,
             'especialidades' => $especialidades,
             'clinicas' => $clinicas
         ]);
    }


    public static function guardarAPI(){
        try {
            $medico = new Medico($_POST);
            $resultado = $medico->crear();

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
            $medico = new Medico($_POST);
            $resultado = $medico->actualizar();

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
          
            if(isset($_POST['medico_id'])){
                $medico_id = $_POST['medico_id'];
                $medico = medico::find($medico_id);
                
    
                if(!$medico){
                    echo json_encode([
                        'mensaje' => 'El medico no existe en la base de datos',
                        'codigo' => 0
                    ]);
                    return;
                }
    
        
                $medico->medico_situacion = 0;
                $resultado = $medico->actualizar();
    
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
                    'mensaje' => 'No se proporcionó el ID del medico',
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
        $medico_nombre = $_GET['medico_nombre'];
        $sql = "SELECT medicos.medico_id, medicos.medico_nombre, 
               especialidades.especialidad_nombre, 
               clinicas.clinica_nombre 
        FROM medicos 
        JOIN especialidades ON medicos.medico_especialidad = especialidades.especialidad_id 
        JOIN clinicas ON medicos.medico_clinica = clinicas.clinica_id 
        WHERE medicos.medico_situacion = 1";
        if ($medico_nombre != '') {
            $sql .= " AND m.medico_nombre LIKE '%$medico_nombre%' ";
        }
    
        try {
            $medicos = Medico::fetchArray($sql);
    
            echo json_encode($medicos);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
}