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
     
        //  exit();
         $router->render('citas/index', [
             'citas' => $citas,
             'pacientes' => $pacientes,
             'medicos' => $medicos
         ]);
    }
    public static function buscarAPI() {
    
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