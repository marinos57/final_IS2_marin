<?php

namespace Controllers;

use Exception;
use Model\Medico;
use Model\Paciente;
use Model\Cita;
use MVC\Router;

class CitaController{
    public static function index(Router $router) {
        $citas = Cita::all();
       
         // Obtener solo las especialidades activas
             // Obtener solo las especialidades activas
             $pacientes = Paciente::consultarSQL("SELECT * FROM pacientes WHERE paciente_situacion = 1");

             // Obtener solo las clínicas activas
             $medicos = Medico::consultarSQL("SELECT * FROM medicos WHERE medico_situacion = 1");
     
 
        //  var_dump($especialidades);
        //  var_dump($clinicas);

        //  exit();
         $router->render('citas/index', [
             'citas' => $citas,
             'pacientes' => $pacientes,
             'medicos' => $medicos
         ]);
    }


    public static function guardarAPI(){
        try {
            $cita = new Cita($_POST);
            $resultado = $cita->crear();

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
            $cita = new Cita($_POST);
            $resultado = $cita->actualizar();

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
          
            if(isset($_POST['cita_id'])){
                $cita_id = $_POST['cita_id'];
                $cita = cita::find($cita_id);
                
    
                if(!$cita){
                    echo json_encode([
                        'mensaje' => 'La cita no existe en la base de datos',
                        'codigo' => 0
                    ]);
                    return;
                }
    
        
                $cita->cita_situacion = 0;
                $resultado = $cita->actualizar();
    
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
                    'mensaje' => 'No se proporcionó el ID del cita',
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
        $cita_nombre = $_GET['cita_nombre'];
        $sql = "SELECT citas.cita_id, citas.cita_nombre, 
               pacientes.paciente_nombre, 
               medicos.medico_nombre 
        FROM citas 
        JOIN pacientes ON citas.cita_paciente = pacientes.paciente_id 
        JOIN medicos ON citas.cita_medico = medicos.medico_id 
        WHERE citas.cita_situacion = 1";
        if ($cita_nombre != '') {
            $sql .= " AND m.medico_nombre LIKE '%$cita_nombre%' ";
        }
    
        try {
            $citas = Cita::fetchArray($sql);
    
            echo json_encode($citas);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
}