        <div class="container justify-content-center">
            <div class="row">
                <div class="col text-center mt-5">
                    <a href="/final_IS2_marin/" class="btn btn-primary">Regresar</a>
                </div>
            </div>
        </div>
<?php foreach ($detallesCitas as $fecha => $detallesPorFecha) : ?>
    <?php foreach ($detallesPorFecha as $clinica => $detallesPorClinica) : ?>
        <?php foreach ($detallesPorClinica as $medico => $detallesPorMedico) : ?>
   
        <div class="container justify-content-center mt-5 bg-light d-flex">
            <table class="table table-bordered table-hover mt-5 mb-5 mx-5">
                <thead class="table-bordered table-info">
                    <tr>
                        <th class="text-center" colspan="6">Citas en esta fecha: (<?= $fecha ?>)</th>
                    </tr>
                    <tr>
                        <th class="text-center" colspan="6">Clínica: <?= $clinica ?> - Doctor <?= $medico ?> (<?= $detallesPorMedico[0]['especialidad_nombre'] ?>)</th>
                    </tr>
                    <tr>
                        <th>No.</th>
                        <th>Paciente</th>
                        <th>DPI</th>
                        <th>Teléfono</th>
                        <th>Hora de la Cita</th>
                        <th>Referido</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detallesPorMedico as $indice => $detalle) : ?>
                        <tr>
                            <td><?= $indice + 1 ?></td>
                            <td><?= $detalle['paciente_nombre'] ?></td>
                            <td><?= $detalle['paciente_dpi'] ?></td>
                            <td><?= $detalle['paciente_telefono'] ?></td>
                            <td><?= $detalle['cita_hora'] ?></td>
                            <td><?= $detalle['cita_referencia'] ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <?php endforeach ?>
    <?php endforeach ?>
<?php endforeach ?>
        <div class="container justify-content-center">
            <div class="row">
                <div class="col text-center mt-5">
                    <a href="/final_IS2_marin/" class="btn btn-primary">Regresar</a>
                </div>
            </div>
        </div>