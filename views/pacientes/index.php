<h1 class="text-center">Formulario de ingreso de Pacientes</h1>
<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioPacientes">
        <input type="hidden" name="paciente_id" id="paciente_id">
        <div class="row mb-3">
            <div class="col">
                <label for="paciente_nombre">Nombre del Paciente</label>
                <input type="text" name="paciente_nombre" id="paciente_nombre" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="paciente_dpi">DPI del Paciente</label>
                <input type="text" name="paciente_dpi" id="paciente_nombre" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="paciente_dpi">Telefono del Paciente</label>
                <input type="text" name="paciente_dpi" id="paciente_nombre" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <button type="submit" form="formularioPacientes" id="btnGuardar" data-saludo= "hola" data-saludo2="hola2" class="btn btn-primary w-100">Guardar</button>
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
        <h2>Listado de Clinicas</h2>
        <table class="table table-bordered table-hover" id="tablaClinicas">
            <thead class="table-dark">
                <tr>
                    <th>NO. </th>
                    <th>NOMBRE</th>
                    <th>DPI</th>
                    <th>TELEFONO</th>
                    <th>MODIFICAR</th>
                    <th>ELIMINAR</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script src="<?= asset('./build/js/clinicas/index.js')  ?>"></script>