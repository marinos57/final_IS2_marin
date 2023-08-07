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
        $paciente_nombre = $_GET['paciente_nombre'] ?? '';
        $medico_nombre = $_GET['medico_nombre'] ?? '';
        // $cita_paciente = $_GET['cita_paciente'] ?? '';
        // $cita_medico = $_GET['cita_medico'] ?? '';
        $cita_fecha = $_GET['cita_fecha'] ?? '';
        $cita_hora = $_GET['cita_hora'] ?? '';
        $cita_referencia = $_GET['cita_referencia'] ?? '';
    
        $sql = "SELECT
            p.paciente_nombre,
            m.medico_nombre,
            c.cita_paciente,
            c.cite_medico, 
            c.cita_fecha,
            c.cita_hora,
            c.cita_referencia,
            c.cita_id
        FROM
            citas c
            INNER JOIN pacientes p ON c.cita_paciente = p.paciente_id
            INNER JOIN medicos m ON c.cita_medico = m.medico_id
        WHERE
            c.cita_situacion = 1";
    
        if (!empty($paciente_nombre)) {
            $sql .= " AND p.paciente_nombre LIKE '%$paciente_nombre%'";
        }
    
        if (!empty($medico_nombre)) {
            $sql .= " AND m.medico_nombre LIKE '%$medico_nombre%'";
        }
        
        if (!empty($cita_paciente)) {
            $sql .= " AND c.cita_paciente = '$cita_paciente'";
        }
    
        if (!empty($cita_medico)) {
            $sql .= " AND c.cita_medico = '$cita_medico'";
        }
    
        if (!empty($cita_fecha)) {
            $sql .= " AND c.cita_fecha = '$cita_fecha'";
        }
    
        if (!empty($cita_hora)) {
            $sql .= " AND c.cita_hora = '$cita_hora'";
        }
    
        if (!empty($cita_referencia)) {
            $sql .= " AND c.cita_referencia = '$cita_referencia'";
        }
    
        try {
            // Realizar la consulta SQL y obtener los resultados (asumiendo que ya tienes la conexión)
            $citas = Cita::fetchArray($sql);
    
            // Establecer la cabecera de respuesta para indicar que es JSON
            header('Content-Type: application/json');
    
            // Enviar la respuesta como un objeto JSON
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