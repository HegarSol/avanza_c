<?php
    $total_deuda = 0;
?>

<table id="tblCuentasPagar" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                  <tr>
                    <th>Seleccionar</th>
                    <th>Version</th>
                    <th>UUID</th>
                    <th style="display:none">Tipo Comprobantes</th>
                    <th>Folio</th>
                    <th>Serie</th>
                    <th>Fecha</th>
                    <th style="display:none">No Certificado</th>
                    <th style="display:none">Forma Pago</th>
                    <th style="display:none">Metodo Pago</th>
                    <th style="display:none">Cuenta Bancaria</th>
                    <th style="display:none">Tipo Cambio</th>
                    <th style="display:none">Moneda</th>
                    <th>SubTotal</th>
                    <th>IVA</th>
                    <th>Tasa IVA</th>
                    <th style="display:none">Ret. IVA</th>
                    <th style="display:none">Ret. ISR</th>
                    <th style="display:none">IEPS</th>
                    <th style="display:none">Tasa IEPS</th>
                    <th>Total</th>
                    <th>RFC Emisor</th>
                    <th style="display:none">RFC Receptor</th>
                    <th style="display:none">Fecha Timbrado</th>
                    <th style="display:none">No Certificado SAT</th>
                    <th style="display:none">Fecha Ingreso</th>
                    <th style="display:none">Fecha Programada</th>
                    <th>Poliza Contabilidad</th>
                    <th style="display:none">Fecha Contabilidad</th>
                    <th style="display:none">Poliza Pago</th>
                    <th style="display:none">Fecha Pago</th>
                    <th style="display:none">Descripcion</th>
                    <th style="display:none">Valida</th>
                    <th style="display:none">Estado SAT</th>
                    <th style="display:none">Codigo SAT</th>
                    <th style="display:none">Tipo Factura</th>
                    <th style="display:none">Error</th>
                    <th style="display:none">STATUS</th>
                    <th style="display:none">Path</th>
                    <th>Nombre emisor</th>
                    <th style="display:none">Descuento</th>
                    <th style="display:none">Departamento</th>
                    <th style="display:none">Referencia</th>
                    <th style="display:none">Fecha Validacion</th>
                  </tr>
              </thead>
              <tbody>
            <?php foreach($comprobantes as $comprobante): ?>
                <tr>
                    <td><input type="checkbox" <?php echo $comprobante->poliza_pago == $poliza ? 'checked' : '' ?> class="form-control" onclick="checartodo()"></td>
                    <td><?php echo $comprobante->version; ?></td>
                    <td><?php echo $comprobante->uuid; ?></td>
                    <td style="display:none"><?php echo $comprobante->tipo_comprobante; ?></td>
                    <td><?php echo $comprobante->folio; ?></td>
                    <td><?php echo $comprobante->serie; ?></td>
                    <td><?php echo $comprobante->fecha; ?></td>
                    <td style="display:none"><?php echo $comprobante->no_certificado;?></td>
                    <td style="display:none"><?php echo $comprobante->forma_pago; ?></td>
                    <td style="display:none"><?php echo $comprobante->metodo_pago; ?></td>
                    <td style="display:none"><?php echo $comprobante->cuenta_bancaria; ?></td>
                    <td style="display:none"><?php echo $comprobante->tipo_cambio; ?></td>
                    <td style="display:none"><?php echo $comprobante->moneda; ?></td>
                    <td><?php echo $comprobante->subtotal; ?></td>
                    <td><?php echo $comprobante->iva; ?></td>
                    <td><?php echo $comprobante->tasa_iva; ?></td>
                    <td style="display:none"><?php echo $comprobante->ret_iva; ?></td>
                    <td style="display:none"><?php echo $comprobante->ret_isr; ?></td>
                    <td style="display:none"><?php echo $comprobante->ieps; ?></td>
                    <td style="display:none"><?php echo $comprobante->tasa_ieps; ?></td>
                    <td><?php echo $comprobante->total; ?></td>
                    <td><?php echo $comprobante->rfc_emisor; ?></td>
                    <td style="display:none"><?php echo $comprobante->rfc_receptor; ?></td>
                    <td style="display:none"><?php echo $comprobante->fecha_timbrado; ?></td>
                    <td style="display:none"><?php echo $comprobante->no_certificado_sat; ?></td>
                    <td style="display:none"><?php echo $comprobante->fecha_ingreso; ?></td>
                    <td style="display:none"><?php echo $comprobante->fecha_programada; ?></td>
                    <td><?php echo $comprobante->poliza_contabilidad; ?></td>
                    <td style="display:none"><?php echo $comprobante->fecha_contabilidad; ?></td>
                    <td style="display:none"><?php echo $comprobante->poliza_pago; ?></td>
                    <td style="display:none"><?php echo $comprobante->fecha_pago; ?></td>
                    <td style="display:none"><?php echo $comprobante->descripcion; ?></td>
                    <td style="display:none"><?php echo $comprobante->valida; ?></td>
                    <td style="display:none"><?php echo $comprobante->estado_sat; ?></td>
                    <td style="display:none"><?php echo $comprobante->codigo_sat; ?></td>
                    <td style="display:none"><?php echo $comprobante->tipo_factura; ?></td>
                    <td style="display:none"><?php echo $comprobante->error;?></td>
                    <td style="display:none"><?php echo $comprobante->status; ?></td>
                    <td style="display:none"><?php echo $comprobante->path;?></td>
                    <td><?php echo $comprobante->nombre_emisor; ?></td>
                    <td style="display:none"><?php echo $comprobante->descuento; ?></td>
                    <td style="display:none"><?php echo $comprobante->departamento; ?></td>
                    <td style="display:none"><?php echo $comprobante->referencia; ?></td>
                    <td style="display:none"><?php echo $comprobante->fecha_validacion;?></td>
                </tr>

              <?php  $total_deuda = $total_deuda + $comprobante->total; ?>

            <?php endforeach; ?>
          </tbody>
          </table>
<script>
           document.getElementById('total_deuda').value = '<?php echo number_format($total_deuda,2,'.',''); ?>';
</script>