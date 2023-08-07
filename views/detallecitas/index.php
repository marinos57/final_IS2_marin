<h1>Detalles de Citas</h1>

<?php foreach ($detallesCitas as $medicoNombre => $detallesPorMedico) : ?>
    <h2><?= $medicoNombre ?></h2>
    <table>
        <thead>
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
