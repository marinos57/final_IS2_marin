<h1 class="text-center">Formulario de ingreso de Citas</h1>
<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioCitas">
        <input type="hidden" name="cita_id" id="cita_id">
        <div class="row mb-3">
            <div class="col">
                <label for="cita_paciente">Nombre del Paciente</label>
                <select name="cita_paciente" id="cita_paciente" class="form-control">
                    <?php foreach ($pacientes as $paciente) : ?>
                         <option value="<?php echo $paciente->paciente_id; ?>"><?php echo $paciente->paciente_nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                 <label for="cita_medico">Nombre del Médico</label>
                    <select name="cita_medico" id="cita_medico" class="form-control">
                        <?php foreach ($medicos as $medico) : ?>
                            <option value="<?php echo $medico->medico_id; ?>"><?php echo $medico->medico_nombre; ?></option>
                        <?php endforeach; ?>
                    </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="cita_fecha">Fecha de la cita</label>
                <input type="text" name="cita_fecha" id="cita_fecha" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="cita_hora">Hora de la cita</label>
                <input type="text" name="cita_hora" id="cita_hora" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="cita_referencia">Indicar si el Paciente es referido</label>
                <input type="text" name="cita_referencia" id="cita_referencia" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <button type="submit" form="formularioCitas" id="btnGuardar" data-saludo= "hola" data-saludo2="hola2" class="btn btn-primary w-100">Guardar</button>
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
        <h2>Listado de Citas</h2>
        <table class="table table-bordered table-hover" id="tablaCitas">
            <thead class="table-dark">
                <tr>
                    <th>NO. </th>
                    <th>NOMBRE DEL PACIENTE</th>
                    <th>MEDICO</th>
                    <th>FECHA</th>
                    <th>HORA</th>
                    <th>REFERIDO</th>
                    <th>MODIFICAR</th>
                    <th>ELIMINAR</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script src="<?= asset('./build/js/pacientes/index.js')  ?>"></script>