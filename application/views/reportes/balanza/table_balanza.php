<?php
    $total_inicial = 0;
    $total_cargos = 0;
    $total_abonos = 0;
    $total_saldo_mensual = 0;
    $final = 0;
?>

<table class="table table-striped table-bordered" id="tabla_balanza">
   <thead>
      <tr>
         <th>Cuenta</th>
         <th>Sub Cta</th>
         <th>Nombre</th>
         <th>Inicial</th>
         <th>Cargos</th>
         <th>Abonos</th>
         <th>Saldo mensual</th>
         <th>Final</th>
      </tr>
   </thead>
   <tbody>
     <?php foreach($balanzas as $balanza):?>
      <tr>
         <td><?php echo $balanza['cuenta'] ;?></td>
         <td><?php echo $balanza['sub_cta'] ;?></td>
         <td><?php echo $balanza['nombre_cuenta'] ;?></td>
         <td style="text-align:right;"><?php echo number_format($balanza['sini'],2,'.','') ;?></td>
         <td style="text-align:right;"><?php echo number_format($balanza['cargos'],2,'.','') ;?></td>
         <td style="text-align:right;"><?php echo number_format($balanza['abonos'],2,'.','') ;?></td>
         <td style="text-align:right;"><?php echo number_format($balanza['cargos']-$balanza['abonos'],2,'.','');?></td>
         <td style="text-align:right;"><?php echo number_format(($balanza['sini']+$balanza['cargos'])-$balanza['abonos'],2,'.','');?></td>
      </tr>

     <?php  
         $total_inicial = $total_inicial + $balanza['sini']; 
         $total_cargos = $total_cargos + $balanza['cargos'];
         $total_abonos = $total_abonos + $balanza['abonos'];
         $nada = $balanza['cargos'] - $balanza['abonos'];
         $total_saldo_mensual = $total_saldo_mensual + $nada;
         $algo = ($balanza['sini']+$balanza['cargos'])-$balanza['abonos'];
         $final = $final + $algo;
      ?>

      <?php endforeach;?>
   </tbody>
</table>

<script>

document.getElementById('inicial2').value = '<?php echo number_format($total_inicial,2,'.',''); ?>';
document.getElementById('cargos2').value = '<?php echo number_format($total_cargos,2,'.',''); ?>';
document.getElementById('abonos2').value = '<?php echo number_format($total_abonos,2,'.',''); ?>';
document.getElementById('saldomensual2').value = '<?php echo number_format($total_saldo_mensual,2,'.',''); ?>';
document.getElementById('final2').value = '<?php echo number_format($final,2,'.',''); ?>';

</script>