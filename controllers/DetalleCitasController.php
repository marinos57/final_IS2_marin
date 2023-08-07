<?php

namespace Controllers;

use Exception;
use Model\Cita;
use Model\Paciente;
use Model\Medico;
use Model\Clinica;
use MVC\Router;

class DetalleCitasController
{
    public static function index(Router $router)
    {
        $detallesCitas = static::getDetallesCitas();
        
        $router->render('detallecitas/index', [
            'detallesCitas' => $detallesCitas
        ]);
    }



    public static function getDetallesCitas()
{
    $sql =  "
    SELECT
        citas.cita_id,
        pacientes.paciente_nombre,
        pacientes.paciente_dpi,
        pacientes.paciente_telefono,
        citas.cita_hora,
        citas.cita_referencia,
        medicos.medico_nombre,
        clinicas.clinica_nombre,
        citas.cita_fecha,
        especialidades.especialidad_nombre
    FROM
        citas
        JOIN pacientes ON citas.cita_paciente = pacientes.paciente_id
        JOIN medicos ON citas.cita_medico = medicos.medico_id
        JOIN clinicas ON medicos.medico_clinica = clinicas.clinica_id
        JOIN especialidades ON medicos.medico_especialidad = especialidades.especialidad_id
    WHERE
        citas.cita_situacion = 1;
";

    try {
        // Ejecutar el query y obtener los resultados
        $detallesCitas = Cita::fetchArray($sql);

        // Organizar los resultados por fecha, clínica y médico
        $detallesCitasOrganizados = [];
        foreach ($detallesCitas as $detalleCita) {
            $fecha = $detalleCita['cita_fecha'];
            $clinica = $detalleCita['clinica_nombre'];
            $medicoNombre = "DOCTOR " . $detalleCita['medico_nombre'];

            if (!isset($detallesCitasOrganizados[$fecha])) {
                $detallesCitasOrganizados[$fecha] = [];
            }
            if (!isset($detallesCitasOrganizados[$fecha][$clinica])) {
                $detallesCitasOrganizados[$fecha][$clinica] = [];
            }
            if (!isset($detallesCitasOrganizados[$fecha][$clinica][$medicoNombre])) {
                $detallesCitasOrganizados[$fecha][$clinica][$medicoNombre] = [];
            }

            $detallesCitasOrganizados[$fecha][$clinica][$medicoNombre][] = $detalleCita;
        }

        return $detallesCitasOrganizados;
    } catch (Exception $e) {
        // Manejar el error si es necesario
        return []; // Si hay un error, retornar un array vacío
    }
}
}