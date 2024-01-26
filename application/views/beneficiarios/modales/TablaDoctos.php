<input type="hidden" name="monto_pago_seleccionado" id="monto_pago_seleccionado"
value=<?php echo $pago->monto;?>>
<input type="hidden" name="tcP" id="tcP"
value=<?php echo $pago->tipoCambioP;?>>
<input type="hidden" name="monedaP" id="monedaP"
value=<?php echo $pago->monedaP;?>>
<table class="table table-bordered" id="tbl_doctos">
  <thead>
    <tr>
      <th style="display: none">idDocto</th>
      <th>ID Documento</th>
      <th>Serie</th>
      <th>Folio</th>
      <th>Moneda</th>
      <th>Tipo Cambio</th>
      <th>Metodo de Pago</th>
      <th>Saldo</th>
      <th width="200px">Pago</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($doctos as $docto): ?>
      <tr>
        <td style="display: none"><?php echo $docto->idPagos_uuid;?></td>
        <td><?php echo $docto->uuid; ?></td>
        <td><?php echo $docto->serie;?></td>
        <td><?php echo $docto->folio; ?></td>
        <td><?php echo $docto->monedaDR; ?></td>
        <td><?php echo $docto->tipoCambioDR; ?></td>
        <td><?php echo $docto->metodoDePagoDR; ?></td>
        <td><?php echo $docto->impSaldoAnt; ?></td>
        <td>
          <div class="input-group">
            <span class="input-group-addon">$</span>
            <input type="money" class="form-control inputPago" data-mask="000,000,000.00" data-mask-reverse="true"
              value="<?php echo $docto->impPagado;?>">
            <span class="input-group-btn">
              <button class="btn btn-success" onclick="update_importe_pagado(this)">
                <span class="glyphicon glyphicon-ok"></span>
              </button>
            </span>
          </div>
        </td>
        <td>
          <div class="btn-group" role="group" aria-label="..">
            <button type="button" class="btn btn-danger" onclick="borra_docto('<?php echo $docto->idPagos_uuid;?>')">
              <span class="glyphicon glyphicon-trash"></span>
            </button>
          </div>
        </td>
      </tr>
    <?php endforeach;?>
  </tbody>
</table>
<div class="col-sm-8">&nbsp;</div><div class="col-sm-4"><label for="clave" class="col-sm-4 control-label">Total Pagos:</label>
   <div class="input-group">
     <span class="input-group-addon">$</span>
     <input type="money" class="form-control " id="totalPago" data-mask-reverse="true" readonly
       value="<?php $sum=0; foreach($doctos as $docto) $sum=$sum+$docto->impPagado; echo $sum; ?>">
   </div>
 </div>

<script>
$(document).ready(function(){
  $(".inputPago").each(function() {
      $(this).keyup(function(){ calcularTotal($(this).parent().index());
      });
  });
});
</script>
