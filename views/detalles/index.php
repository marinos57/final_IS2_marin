<h1 class="text-center">Formulario de detalle de Citas</h1>
<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioCitas">
        <input type="hidden" name="cita_id" id="cita_id">
        <div class="row mb-3">
            <div class="col">
                <label for="cita_paciente">Nombre del Paciente</label>
                <input type="text" name="cita_paciente" id="cita_paciente" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                 <label for="cita_medico">Nombre del Médico</label>
                <input type="date" name="cita_medico" id="cita_medico" class="form-control">

            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="cita_fecha">Fecha de la cita</label>
                <input type="date" name="cita_fecha" id="cita_fecha" pattern="\d{4}-\d{2}-\d{2}" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <button type="button" id="btnBuscar" class="btn btn-info w-100">Buscar</button>
            </div>
        </div>
    </form>
</div>
<div class="row justify-content-center" id="divTabla">
    <div class="col-lg-8">
        <h2>Listado de Citas</h2>
        <table class="table table-bordered table-hover" id="tablaCitas">
            <tr>
                <th colspan="6" class="titulo-citas">CITAS PARA EL DIA DE HOY</th>
            </tr>
            <tr>
                <th colspan="6" class="titulo-blanco"></th>
            </tr>
            <thead class="table-dark">
                <tr>
                    <th>NO. </th>
                    <th>PACIENTE</th>
                    <th>DPI</th>
                    <th>TELEFONO</th>
                    <th>HORA</th>
                    <th>REFERIDO</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script src="<?= asset('./build/js/detalles/index.js')  ?>"></script>