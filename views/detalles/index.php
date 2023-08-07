<h1 class="text-center">Formulario de detalle de Citas</h1>
<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="buscar_form">
        <input type="hidden" name="cita_id" id="cita_id">
            <div class="col">
                <label for="fecha_busqueda">Fecha de búsqueda:</label>
                <input type="date" id="fecha_busqueda" name="fecha_busqueda">
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
        <table class="table table-bordered table-hover" id="tabla_citas">
            <tr>
                <th colspan="6" id="fecha_busqueda">CITAS PARA EL DÍA DE HOY Y LA FECHA QUE SE BUSCÓ</th>
            </tr>
            <tr>
                <th>CLINICA_NOMBRE</th>
                <th>MEDICO_NOMBRE</th>
                <th>NO</th>
                <th>PACIENTE</th>
                <th>DPI</th>
                <th>TELEFONO</th>
                <th>HORA DE LA CITA</th>
                <th>REFERIDO (SI/NO)</th>
            </tr>
        </table>
    </div>
</div>
<script src="<?= asset('./build/js/detalles/index.js')  ?>"></script>