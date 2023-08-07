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
       
        $sql = "SELECT * FROM medicos WHERE medico_situacion = 1";
        $medicos = Medico::fetchArray($sql);

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
        $medico_especialidad = $_GET['medico_especialidad'];
        $medico_clinica = $_GET['medico_clinica'];

        $sql = " SELECT * from medicos inner join especialidades on medico_especialidad = especialidad_id inner join clinicas on clinica_id = medico_clinica where medico_situacion = 1";
        if ($medico_nombre != '') {
            $sql .= " AND medico_nombre LIKE '%$medico_nombre%' ";
        }
        if ($medico_especialidad != '') {
            $sql .= " AND medico_especialidad = '$medico_especialidad' ";
        }
        if ($medico_clinica != '') {
            $sql .= " AND medico_clinica = '$medico_clinica' ";
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