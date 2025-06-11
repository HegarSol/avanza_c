
<table class="table table-striped table-bordered" id="tabla_pendientes">
   <thead>
     <tr>
        <th>Version</th>
        <th>UUID</th>
        <th>Tipo Comprobante</th>
        <th>Fecha</th>
        <th>Folio</th>
        <th>Serie</th>
        <th>RFC</th>
        <th>Nombre</th>
        <th>Total</th>
        <th style="display:none">forma_pago</th>
        <th style="display:none">metodo_pago</th>
        <th style="display:none">cta</th>
        <th style="display:none">codigo_sat</th>
        <th style="display:none">moneda</th>
        <th style="display:none">tipo_cambio</th>
        <th style="display:none">rfc_emisor</th>
        <th style="display:none">nombre_emisor</th>
        <th style="display:none">rfc_recepto</th>
        <th style="display:none">subtotal</th>
        <th style="display:none">tasa_iva</th>
        <th style="display:none">iva</th>
        <th style="display:none">ret_iva</th>
        <th style="display:none">ret_isr</th>
        <th style="display:none">tasa_ieps</th>
        <th style="display:none">ieps</th>
        <th style="display:none">estado sat</th>
        <th style="display:none">poliza_pago</th>
     </tr>
   </thead>
   <tbody>
      
      <?php if(empty($comprobantes)): ?>
         <tr>
            <td colspan="25" style="text-align:center">No hay comprobantes pendientes</td>
         </tr>
      <?php else: ?>
      <?php foreach($comprobantes as $comprobante): ?>
          <tr>
             <td><?php echo $comprobante->version; ?></td>
             <td><?php echo $comprobante->uuid; ?></td>
             <td><?php echo $comprobante->tipo_comprobante; ?></td>
             <td><?php echo $comprobante->fecha; ?></td>
             <td><?php echo $comprobante->folio; ?></td>
             <td><?php echo $comprobante->serie; ?></td>
             <td><?php echo $comprobante->rfc_emisor; ?></td>
             <td><?php echo $comprobante->nombre_emisor; ?></td>
             <td style='text-align:right'><?php echo $comprobante->total; ?></td>
             <td style="display:none"><?php echo $comprobante->forma_pago; ?></td>
             <td style="display:none"><?php echo $comprobante->metodo_pago; ?></td>
             <td style="display:none"><?php echo $comprobante->cuenta_bancaria; ?></td>
             <td style="display:none"><?php echo $comprobante->codigo_sat; ?></td>
             <td style="display:none"><?php echo $comprobante->moneda; ?></td>
             <td style="display:none"><?php echo $comprobante->tipo_cambio; ?></td>
             <td style="display:none"><?php echo $comprobante->rfc_emisor; ?></td>
             <td style="display:none"><?php echo $comprobante->nombre_emisor; ?></td>
             <td style="display:none"><?php echo $comprobante->empresa; ?></td>
             <td style="display:none"><?php echo $comprobante->subtotal; ?></td>
             <td style="display:none"><?php echo $comprobante->tasa_iva; ?></td>
             <td style="display:none"><?php echo $comprobante->iva; ?></td>
             <td style="display:none"><?php echo $comprobante->ret_iva; ?></td>
             <td style="display:none"><?php echo $comprobante->ret_isr; ?></td>
             <td style="display:none"><?php echo $comprobante->tasa_ieps; ?></td>
             <td style="display:none"><?php echo $comprobante->ieps;?></td>
             <td style="display:none"><?php echo $comprobante->estado_sat;?></td>
             <td style="display:none"><?php echo $comprobante->poliza_pago?></td>
          </tr>
      <?php endforeach;?>
      <?php endif; ?>
   </tbody>
</table>
