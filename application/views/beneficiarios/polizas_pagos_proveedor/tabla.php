<table class="table table-striped table-bordered" id="tabla_polizas_pagos_prove">
   <thead>
     <tr>
        <th>Tipo Movimiento</th>
        <th>No Banco</th>
        <th>No Movimiento</th>
        <th>Fecha</th>
        <th>Concepto</th>
        <th>Monto</th>
        <th>Fecha Cobro</th>
     </tr>
   </thead>
   <tbody>
      <?php foreach($getpolizaspagoprove as $polizapago): ?>
          <tr>
             <td><?php echo $polizapago['tipo_mov']; ?></td>
             <td><?php echo $polizapago['no_banco']; ?></td>
             <td><?php echo $polizapago['no_mov']; ?></td>
             <td><?php echo date('d-m-Y',strtotime($polizapago['fecha'])); ?></td>
             <td><?php echo $polizapago['concepto']; ?></td>
             <td><?php echo $polizapago['monto']; ?></td>
             <td><?php echo $polizapago['fechaCobro']; ?></td>
          </tr>
      <?php endforeach;?>
   </tbody>
</table>