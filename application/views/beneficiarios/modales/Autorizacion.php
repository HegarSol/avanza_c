
<div class="modal fade" id="myModalAutorizacion" role="dialog" >
<div class="modal-dialog modal-lg" id="mdialTamanio">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" id="cerrarclick2" name="cerrarclick2" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Cuentas por Pagar</h1>
        </div>
        <div class="modal-body">
        <b>R.F.C:</b> <span id="rfcprov" name="rfcprov"><?php echo $rfc?></span>
        <br>
        <br>

        <button class="btn btn-primary" onclick="verdetalle()"><span class="fa fa-eye"></span> Ver Docs</button>

        <button class="btn btn-success" onclick="agregarpoliza()"><span class="fa fa-check"></span> Aceptar</button>
     
        <br>
        <br>

<table id="tblAutorizacion" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                    <tr>
                        <th>Seleccionar</th>
                        <th>Version</th>
                        <th>Folio</th>                        
                        <th>Fecha</th>
                        <th>Fecha Pago</th>
                        <th>Importe</th>                        
                        <th>Metodo pago</th>
                        <th>UUID</th>
                        <th>Antiguedad</th>
                    </tr>
             </thead>
            <tbody>
            </tbody>
</table>

        <br>

        <div id="espacioEstafetaporpagar"></div>

        <div class="row">
               <div class="col-sm-6">
               </div>
               <div class="col-sm-2">
                     <div class="input-group">
                        <span class="input-group-addon">Total autorización</span>
                        <input type="text" id="total_pagar" readonly name="total_pagar" class="form-control">
                     </div>
               </div>
               <div class="col-sm-2">
                     <div class="input-group">
                        <span class="input-group-addon">Total Deuda</span>
                        <input type="text" id="total_deuda" readonly name="total_deuda"  class="form-control">
                     </div>
               </div>
        </div>

        </div>
        <div class="modal-footer">
          <!-- <button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-danger">Cerrar</button> -->
        </div>
    </div>
</div>
</div>



<div class="modal fade" id="myModalCuentasPagarDetalle" role="dialog" >
<div class="modal-dialog modal-lg" id="mdialTamanio">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Detalle Cuenta por Pagar</h1>
        </div>
        <div class="modal-body">
             <div class="row">
                 <div class="col-sm-2">
                     <div class="input-group">
                        <span class="input-group-addon">Version</span>
                        <input type="text" id="version" readonly name="version" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="input-group">
                        <span class="input-group-addon">UUID</span>
                        <input type="text" id="uuid" readonly name="uuid" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-2">
                     <div class="input-group">
                        <span class="input-group-addon">Tipo comprobante</span>
                        <input type="text" id="tipo_comprobante" readonly name="tipo_comprobante" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-2">
                     <div class="input-group">
                        <span class="input-group-addon">Folio</span>
                        <input type="text" id="folio" readonly name="folio" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-2">
                     <div class="input-group">
                        <span class="input-group-addon">Serie</span>
                        <input type="text" id="serie" readonly name="serie" class="form-control">
                     </div>
                  </div>
             </div>
             <br>
             <div class="row">
                 <div class="col-sm-2">
                     <div class="input-group">
                        <span class="input-group-addon">Fecha</span>
                        <input type="text" id="fecha" readonly name="fecha" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <div class="input-group">
                        <span class="input-group-addon">No Certificado</span>
                        <input type="text" id="no_certificado" readonly name="no_certificado" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-2">
                     <div class="input-group">
                        <span class="input-group-addon">Forma Pago</span>
                        <input type="text" id="forma_pago" readonly name="forma_pago" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <div class="input-group">
                        <span class="input-group-addon">Metodo Pago</span>
                        <input type="text" id="metodo_pago" readonly name="metodo_pago" class="form-control">
                     </div>
                  </div>
             </div>
             <br>
             <div class="row">
                 <div class="col-sm-3">
                     <div class="input-group">
                        <span class="input-group-addon">#Cuenta Bancari</span>
                        <input type="text" id="cuenta_banca" readonly name="cuenta_banca" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-2">
                     <div class="input-group">
                        <span class="input-group-addon">Tipo Cambio</span>
                        <input type="text" id="tipo_cambio" readonly name="tipo_cambio" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-2">
                     <div class="input-group">
                        <span class="input-group-addon">Moneda</span>
                        <input type="text" id="moneda" readonly name="moneda" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-2">
                     <div class="input-group">
                        <span class="input-group-addon">Emisor</span>
                        <input type="text" id="emisor" readonly name="emisor" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <div class="input-group">
                        <span class="input-group-addon">Nombre Emisor</span>
                        <input type="text" id="nombre_emisor" readonly name="nombre_emisor" class="form-control">
                     </div>
                  </div>
             </div>
             <br>
             <div class="row">
                 <div class="col-sm-3">
                     <div class="input-group">
                        <span class="input-group-addon">Fecha Timbrado</span>
                        <input type="text" id="fecha_timbrado" readonly name="fecha_timbrado" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <div class="input-group">
                        <span class="input-group-addon">No Certifcado SAT</span>
                        <input type="text" id="no_cert_sat" readonly name="no_cert_sat" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <div class="input-group">
                        <span class="input-group-addon">Fecha Ingreso</span>
                        <input type="text" id="fecha_ingreso" readonly name="fecha_ingreso" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <div class="input-group">
                        <span class="input-group-addon">Fecha Programada</span>
                        <input type="text" id="fecha_programada" readonly name="fecha_programada" class="form-control">
                     </div>
                  </div>
             </div>
             <br>
             <div class="row">
                 <div class="col-sm-3">
                     <div class="input-group">
                        <span class="input-group-addon">Poliza Contabilidad</span>
                        <input type="text" id="poliza_contabili" readonly name="poliza_cotabili" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <div class="input-group">
                        <span class="input-group-addon">Fecha Contabilidad</span>
                        <input type="text" id="fecha_contabili" readonly name="fecha_cotabili" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <div class="input-group">
                        <span class="input-group-addon">Poliza Pago</span>
                        <input type="text" id="poliza_pago" readonly name="poliza_pago" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <div class="input-group">
                        <span class="input-group-addon">Fecha Pago</span>
                        <input type="text" id="fecha_pago" readonly name="fecha_pago" class="form-control">
                     </div>
                  </div>
             </div>
             <br>
             <div class="row">
                 <div class="col-sm-4">
                     <div class="input-group">
                        <span class="input-group-addon">Descripcion</span>
                        <input type="text" id="descripcion" readonly name="descripcion" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-2">
                     <div class="input-group">
                        <span class="input-group-addon">Estado SAT</span>
                        <input type="text" id="estado_sat" readonly name="estado_sat" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="input-group">
                        <span class="input-group-addon">Codigo SAT</span>
                        <input type="text" id="codigo_sat" readonly name="codigo_sat" class="form-control">
                     </div>
                  </div>
             </div>
             <br>
             <div class="row">
                 <div class="col-sm-3">
                     <div class="input-group">
                        <span class="input-group-addon">Tipo Factura</span>
                        <input type="text" id="tipo_factura" readonly name="tipo_factura" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <div class="input-group">
                        <span class="input-group-addon">Error</span>
                        <input type="text" id="error" readonly name="error" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-1">
                     <div class="input-group">
                        <span class="input-group-addon">Status</span>
                        <input type="text" id="status" readonly name="status" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-2">
                     <div class="input-group">
                        <span class="input-group-addon">Descuento</span>
                        <input type="text" id="descuento" readonly name="descuento" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <div class="input-group">
                        <span class="input-group-addon">Departamento</span>
                        <input type="text" id="departamento" readonly name="departamento" class="form-control">
                     </div>
                  </div>
             </div>
             <br>
             <div class="row">
                 <div class="col-sm-3">
                     <div class="input-group">
                        <span class="input-group-addon">Referencia</span>
                        <input type="text" id="referencia" readonly name="referencia" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <div class="input-group">
                        <span class="input-group-addon">Fecha Validacion</span>
                        <input type="text" id="fecha_validacion" readonly name="fecha_validacion" class="form-control">
                     </div>
                  </div>
             </div>
             <br>
             <div class="row">
                   <div class="col-sm-3">
                        <div class="input-group">
                           <span class="input-group-addon">Receptor</span>
                           <input type="text" id="receptor" readonly name="receptor" class="form-control">
                        </div>
                     </div>
                     <div class="col-sm-3">
                     </div>
                     <div class="col-sm-3">
                     </div>
                     <div class="col-sm-2">
                        <div class="input-group">
                           <span class="input-group-addon">Subtotal</span>
                           <input type="text" id="subtotal" readonly style='text-align:right' name="subtotal" class="form-control">
                        </div>
                     </div>
              </div>
              <br>
              <div class="row">
                     <div class="col-sm-3">
                     </div>
                     <div class="col-sm-4">
                     </div>
                     <div class="col-sm-2">
                        <div class="input-group">
                           <span class="input-group-addon">Tasa</span>
                           <input type="text" id="tasa_iva" readonly style='text-align:right' name="tasa_iva" class="form-control">
                        </div>
                     </div>
                     <div class="col-sm-2">
                        <div class="input-group">
                           <span class="input-group-addon">I.V.A</span>
                           <input type="text" id="iva" readonly style='text-align:right' name="iva" class="form-control">
                        </div>
                     </div>
              </div>
              <br>
              <div class="row">
                     <div class="col-sm-3">
                     </div>
                     <div class="col-sm-3">
                     </div>
                     <div class="col-sm-3">
                     </div>
                     <div class="col-sm-2">
                        <div class="input-group">
                           <span class="input-group-addon">Ret. IVA</span>
                           <input type="text" id="ret_iva" readonly style='text-align:right' name="ret_iva" class="form-control">
                        </div>
                     </div>
              </div>
              <br>
              <div class="row">
                     <div class="col-sm-3">
                     </div>
                     <div class="col-sm-3">
                     </div>
                     <div class="col-sm-3">
                     </div>
                     <div class="col-sm-2">
                        <div class="input-group">
                           <span class="input-group-addon">Ret. ISR</span>
                           <input type="text" id="ret_isr" readonly style='text-align:right' name="ret_isr" class="form-control">
                        </div>
                     </div>
              </div>
              <br>
              <div class="row">
                     <div class="col-sm-3">
                     </div>
                     <div class="col-sm-4">
                     </div>
                     <div class="col-sm-2">
                        <div class="input-group">
                           <span class="input-group-addon">Tasa</span>
                           <input type="text" id="tasa_ieps" readonly style='text-align:right' name="tasa_ieps" class="form-control">
                        </div>
                     </div>
                     <div class="col-sm-2">
                        <div class="input-group">
                           <span class="input-group-addon">IEPS</span>
                           <input type="text" id="ieps" readonly style='text-align:right' name="ieps" class="form-control">
                        </div>
                     </div>
              </div>
              <br>
              <div class="row">
                     <div class="col-sm-3">
                     </div>
                     <div class="col-sm-3">
                     </div>
                     <div class="col-sm-3">
                     </div>
                     <div class="col-sm-2">
                        <div class="input-group">
                           <span class="input-group-addon">Total</span>
                           <input type="text" id="total" readonly style='text-align:right' name="total" class="form-control">
                        </div>
                     </div>
              </div>
        </div>
    </div>
</div>
</div>

<style>
#mdialTamanio{
      width: 80% !important;
}
</style>