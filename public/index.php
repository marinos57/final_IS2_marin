<?php 
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AppController;
use Controllers\EspecialidadController;
use Controllers\ClinicaController;
use Controllers\PacienteController;
use Controllers\MedicoController;
use Controllers\CitaController;
use Controllers\DetalleCitasController;



$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);
//especialidades
$router->get('/', [AppController::class,'index']);
$router->get('/especialidades', [EspecialidadController::class,'index'] );
$router->post('/API/especialidades/guardar', [EspecialidadController::class,'guardarAPI'] );
$router->post('/API/especialidades/modificar', [EspecialidadController::class,'modificarAPI'] );
$router->post('/API/especialidades/eliminar', [EspecialidadController::class,'eliminarAPI'] );
$router->get('/API/especialidades/buscar', [EspecialidadController::class,'buscarAPI'] );

//clinicas

$router->get('/clinicas', [ClinicaController::class,'index'] );
$router->post('/API/clinicas/guardar', [ClinicaController::class,'guardarAPI'] );
$router->post('/API/clinicas/modificar', [ClinicaController::class,'modificarAPI'] );
$router->post('/API/clinicas/eliminar', [ClinicaController::class,'eliminarAPI'] );
$router->get('/API/clinicas/buscar', [ClinicaController::class,'buscarAPI'] );


//pacientes
$router->get('/pacientes', [PacienteController::class,'index'] );
$router->post('/API/pacientes/guardar', [PacienteController::class,'guardarAPI'] );
$router->post('/API/pacientes/modificar', [PacienteController::class,'modificarAPI'] );
$router->post('/API/pacientes/eliminar', [PacienteController::class,'eliminarAPI'] );
$router->get('/API/pacientes/buscar', [PacienteController::class,'buscarAPI'] );


//medicos

$router->get('/medicos', [MedicoController::class,'index'] );
$router->post('/API/medicos/guardar', [MedicoController::class,'guardarAPI'] );
$router->post('/API/medicos/modificar', [MedicoController::class,'modificarAPI'] );
$router->post('/API/medicos/eliminar', [MedicoController::class,'eliminarAPI'] );
$router->get('/API/medicos/buscar', [MedicoController::class,'buscarAPI'] );


//citas

$router->get('/citas', [CitaController::class,'index'] );
$router->post('/API/citas/guardar', [CitaController::class,'guardarAPI'] );
$router->post('/API/citas/modificar', [CitaController::class,'modificarAPI'] );
$router->post('/API/citas/eliminar', [CitaController::class,'eliminarAPI'] );
$router->get('/API/citas/buscar', [CitaController::class,'buscarAPI'] );



//detalles
$router->get('/detallecitas', [DetalleCitasController::class,'index'] );
// $router->get('/API/detallecitas/buscarporCitas', [DetalleCitasController::class,'buscarPorCitas'] );



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
