<?php

namespace Controllers;

use Exception;
use Model\Medico;
use Model\Paciente;
use Model\Clinica;
use Model\Cita;
use Model\Detalle;
use Model\Especialidad;
use MVC\Router;

// ...

class DetalleController{
    public static function index(Router $router)
    {
        // Obtener solo las clínicas activas usando el método all() del modelo Clinica
        $detalles = Detalle::all();
        $detalles = Clinica::all();
        $detalles = Medico::all();
        $detalles = Paciente::all();
        $detalles = Cita::all();
        $detalles = Clinica::all();

        $router->render('detalles/index', [
            'detalles' => $detalles,
        ]);
    }

    public static function buscarAPI() {
        // Obtener los parámetros de búsqueda enviados por la petición
        $cita_fecha = $_GET['cita_fecha'] ?? null;
        $medico_id = $_GET['medico_id'] ?? null;
        $dpi = $_GET['dpi'] ?? null;
    
        // Construir la consulta SQL base
        $sql = "SELECT citas.cita_id, 
                       pacientes.paciente_nombre, 
                       pacientes.paciente_dpi,
                       pacientes.paciente_telefono,
                       citas.cita_hora,
                       citas.cita_referencia,
                       medicos.medico_nombre,
                       clinicas.clinica_nombre,
                       citas.cita_fecha
                FROM citas 
                JOIN pacientes ON citas.cita_paciente = pacientes.paciente_id 
                JOIN medicos ON citas.cita_medico = medicos.medico_id 
                JOIN clinicas ON medicos.medico_clinica = clinicas.clinica_id
                WHERE citas.cita_situacion = 1";
    
        // Agregar condiciones según los parámetros de búsqueda
        // if ($fecha) {
        //     // Formatear la fecha para evitar posibles inyecciones SQL
        //     $fecha_formateada = date("Y-m-d", strtotime($fecha));
        //     $sql .= " AND citas.cita_fecha = '$fecha_formateada'";
        // }
        // if ($medico_id) {
        //     $sql .= " AND citas.cita_medico = $medico_id";
        // }
        // if ($dpi) {
        //     $sql .= " AND pacientes.paciente_dpi = '$dpi'";
        // }
    
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
