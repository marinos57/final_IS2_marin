<h1 class="text-center">Formulario de ingreso de Medicos</h1>
<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioMedicos">
        <input type="hidden" name="medico_id" id="medico_id">
        <div class="row mb-3">
            <div class="col">
                <label for="medico_nombre">Nombre del Medico</label>
                <input type="text" name="medico_nombre" id="medico_nombre" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                    <label for="medico_especialidad">Especialidad del Médico</label>
                    <!-- Aquí se agregará el select de especialidades -->
                    <select name="medico_especialidad" id="especialidad_select" class="form-control"></select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="medico_clinica">Asignar Clínica al Médico</label>
                    <!-- Aquí se agregará el select de clínicas -->
                <select name="medico_clinica" id="clinica_select" class="form-control"></select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <button type="submit" form="formularioMedicos" id="btnGuardar" data-saludo= "hola" data-saludo2="hola2" class="btn btn-primary w-100">Guardar</button>
            </div>
            <div class="col">
                <button type="button" id="btnModificar" class="btn btn-warning w-100">Modificar</button>
            </div>
            <div class="col">
                <button type="button" id="btnBuscar" class="btn btn-info w-100">Buscar</button>
            </div>
            <div class="col">
                <button type="button" id="btnCancelar" class="btn btn-danger w-100">Cancelar</button>
            </div>
        </div>
    </form>
</div>
<div class="row justify-content-center" id="divTabla">
    <div class="col-lg-8">
        <h2>Listado de Medicos</h2>
        <table class="table table-bordered table-hover" id="tablaMedicos">
            <thead class="table-dark">
                <tr>
                    <th>NO. </th>
                    <th>NOMBRE</th>
                    <th>Especialidad</th>
                    <th>Clinica</th>
                    <th>MODIFICAR</th>
                    <th>ELIMINAR</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script src="<?= asset('./build/js/medicos/index.js')  ?>"></script>
<script src="<?= asset('./build/js/especialidades/index.js')  ?>"></script>