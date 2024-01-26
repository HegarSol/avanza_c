<table class="table table-striped table-bordered" id="tblcontraRecibos">
    <thead>
        <tr>
            <th>No Proveedor</th>
            <th>Folio</th>
            <th>Serie</th>
            <th>No Contra Recibo</th>
        </tr>
    </thead>
    <tbody>
         <?php foreach($comprobantes as $comprobante): ?>
            <tr>
                <td><?php echo $comprobante['proveedor']; ?></td>
                <td><?php echo $comprobante['fact']; ?></td>
                <td><?php echo $comprobante['serie']; ?></td>
                <td><?php echo $comprobante['no_contra']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>