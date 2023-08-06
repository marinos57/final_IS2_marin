<?php

namespace Controllers;

use Exception;
use Model\Medico;
use Model\Paciente;
use Model\Clinica;
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
    

    public static function buscarAPI() {
        $cita_paciente = $_GET['cita_paciente'];
        $cita_fecha = $_GET['cita_fecha'];
        $cita_hora = $_GET['cita_hora'];
        $cita_referencia = $_GET['cita_referencia'];
    
        // Realizar la consulta SQL con JOINs para obtener los datos de paciente, medico y cita
        $sql = "SELECT citas.cita_id, 
                       pacientes.paciente_nombre, 
                       medicos.medico_nombre,
                       citas.cita_fecha,
                       citas.cita_hora,
                       citas.cita_referencia
                FROM citas 
                JOIN pacientes ON citas.cita_paciente = pacientes.paciente_id 
                JOIN medicos ON citas.cita_medico = medicos.medico_id 
                WHERE citas.cita_situacion = 1";
    
        if (!empty($cita_paciente)) {
            $sql .= " AND pacientes.paciente_nombre LIKE '%$cita_paciente%'";
        }
    
        if (!empty($cita_fecha)) {
            $sql .= " AND citas.cita_fecha = '$cita_fecha'";
        }
    
        if (!empty($cita_hora)) {
            $sql .= " AND citas.cita_hora = '$cita_hora'";
        }
    
        if (!empty($cita_referencia)) {
            $sql .= " AND citas.cita_referencia = '$cita_referencia'";
        }
    
        try {
            // Realizar la consulta SQL y obtener los resultados (asumiendo que ya tienes la conexión)
        
            $citas = Cita::fetchArray($sql);

      

            //$medicos = Medico::fetchArray($sql);

    
            // Establecer la cabecera de respuesta para indicar que es JSON
            header('Content-Type: application/json');
    
            // Enviar la respuesta como un objeto JSON
            var_dump($citas);
            exit();
            echo json_encode($citas);
        } catch (Exception $e) {
            // En caso de error, enviar un JSON con información del error
            header('Content-Type: application/json');
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
}