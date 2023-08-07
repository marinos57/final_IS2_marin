<h1>Detalles de Citas</h1>

<?php foreach ($detallesCitas as $fecha => $detallesPorFecha) : ?>
    <?php foreach ($detallesPorFecha as $clinica => $detallesPorClinica) : ?>
        <?php foreach ($detallesPorClinica as $medico => $detallesPorMedico) : ?>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th colspan="6">Citas para el día de hoy (<?= $fecha ?>)</th>
                    </tr>
                    <tr>
                        <th colspan="6">Clínica: <?= $clinica ?> - Doctor <?= $medico ?></th>
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
        <?php endforeach ?>
    <?php endforeach ?>
<?php endforeach ?>

