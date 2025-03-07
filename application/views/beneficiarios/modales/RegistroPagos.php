<div class="modal fade" id="myModalregistroPagos" data-keyboard="false" data-backdrop="static" role="dialog">
<div class="modal-dialog modal-lg" id="mdialTamanio">
    <div class="modal-content">
        <div class="modal-header">
            <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
            <h1 class="modal-title">Registro Pagos</h1>
            <?php 
              if(isset($pagos[0]->formaDepagoP))
              {
                  $formapag = $pagos[0]->formaDepagoP;
                  $pagosexi = 1;
              }
              else
              {
                  $formapag = '01';
                  $pagosexi = 0;
              }
            ?>
        </div>
        &nbsp; &nbsp; &nbsp; &nbsp;<input type="checkbox" id="agregar_pago" name="agregar_pago" <?php echo $pagosexi > 0 ? 'checked' : '' ?> > <label for="">Agregar Pago</label>
        <div class="modal-body" style="max-height: calc(100vh - 212px);overflow-y: auto;">
            <div class="panel panel-info">
                <div class="panel-heading">
                   <h3 class="panel-title">Pagos</h3>
                   <input type="hidden" id="idPago" name="idPago" readonly value="<?php echo isset($pagos[0]->idPago) ? $pagos[0]->idPago : 0 ?>">
                </div>
                <div class="panel-body">
                  <div class="row">
                      <div class="col-md-2">
                          <label for="no_cliente_pago" class="control-label">No.- Cliente</label>
                            <div class="input-group">
                              <input type="text" class="form-control" value="<?php echo isset($pagos[0]->no_cte) ? $pagos[0]->no_cte : '' ?>" id="id_cliente_pago" name="id_cliente_pago">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" type="button" data-toggle="modal" data-target="#myModalCliente">
                                    <span class="glyphicon glyphicon-search"></span>
                                  </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <label for="clave" class="col-md-1 control-label">Nombre:</label>
                            <input type="hidden" class="form-control" value="<?php echo isset($pagos[0]->clave_cliente) ? $pagos[0]->clave_cliente : '' ?>" name="cliente_clave" id="clave">
                            <input type="text" class="form-control" value="<?php echo isset($pagos[0]->nombre_cliente) ? $pagos[0]->nombre_cliente : '' ?>" name="nombre_cliente_pago" id="nombre_cliente_pago">                
                        </div>
                        <div class="col-md-3">
                          <label for="rfc_pago_cliente" class="col-md-1 control-label">RFC:</label>
                          <input type="text" class="form-control" name="rfc_pago" id="rfc_pago" value="<?php echo isset($pagos[0]->rfc_pago) ? $pagos[0]->rfc_pago : '' ?>">
                        </div>
                    </div>
                  <br>
                  <div class="row">
                            <div class="col-sm-2">
                                <label for="">Fecha de Pago</label>
                                <input type="date" id="fechapago" value="<?php echo isset($pagos[0]->fechaPago) ? date('Y-m-d',strtotime($pagos[0]->fechaPago)) : date('Y-m-d') ?>" name="fechapago" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="">Forma de Pago</label>
                                <select name="formaDePago" id="formaDePago" class="form-control">
                                  <?php foreach($formapago as $formaspago): ?>
                                     <option value="<?php echo $formaspago['c_FormaPago']?>" <?php echo ($formaspago['c_FormaPago'] == $formapag ? 'selected' : '') ?> >
                                         <?php echo $formaspago['c_FormaPago'] . ' - ' . $formaspago['descripcion']; ?>
                                     </option>
                                  <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="">Moneda</label>
                                <select name="moneda_pago" id="moneda_pago" class="form-control">
                                    <?php foreach($monedas as $moneda): ?>
                                    <option value="<?php echo $moneda['c_Moneda']?>" <?php echo ($moneda['c_Moneda']  == 'MXN'? 'selected' : '')?>>
                                        <?php echo $moneda['c_Moneda'] . ' - ' . $moneda['descripcion'];?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="">Tipo de Cambio</label>
                                <input type="number" name="tipoCambio" id="tipoCambio" value="<?php echo isset($pagos[0]->tipoCambioP) ? $pagos[0]->tipoCambioP : '' ?>" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label for="">Monto</label>
                                <input type="number" name="monto_pago" id="monto_pago" value="<?php echo isset($pagos[0]->monto) ? $pagos[0]->monto : '' ?>" class="form-control">
                            </div>
                        </div>
                </div>
            </div>

            <div class="panel panel-info">
                            <div class="panel-heading">
                            <h3 class="panel-title">Datos Ordenante</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-2">
                                    <label for="numOperacion" class="control-label" data-toggle="tooltip">
                                        Num. Operacion
                                    </label>
                                        <input type="text" name="numOperacion" value="<?php echo isset($pagos[0]->numOperacion) ? $pagos[0]->numOperacion : '' ?>" id="numOperacion" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                    <label for="ctaOrdenante" class="control-label" data-toggle="tooltip">
                                        Cta. Ordenante
                                    </label>
                                        <input type="text" name="ctaOrdenante" value="<?php echo isset($pagos[0]->ctaOrdenante) ? $pagos[0]->ctaOrdenante : '' ?>"  id="ctaOrdenante" class="form-control">
                                    </div>
                               
                                    <div class="col-md-3">
                                    <label for="rfcEmisorCtaOrd" class="control-label" data-toggle="tooltip">
                                        RFC Emisor Ord.
                                    </label>
                                        <input type="text" name="rfcEmisorCtaOrd" value="<?php echo isset($pagos[0]->rfcEmisorCtaOrd) ? $pagos[0]->rfcEmisorCtaOrd : '' ?>" id="rfcEmisorCtaOrd" class="form-control">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-7">
                                        <label for="nomBancoOrdExt" class="ontrol-label" data-toggle="tooltip">
                                            Nom. Banco Ord.
                                        </label>
                                            <input type="text" name="nomBancoOrdExt" id="nomBancoOrdExt" value="<?php echo isset($pagos[0]->nomBancoOrdExt) ? $pagos[0]->nomBancoOrdExt : '' ?>" class="form-control">
                                    </div>
                                </div>
                            </div>
            </div>

            <div class="panel panel-info">
                            <div class="panel-heading">
                            <h3 class="panel-title">Datos Beneficiario</h3>
                            </div>
                            <div class="panel-body">
                            <div class="col-md-12"></div>
                            <div class="col-md-3">
                                <label for="rfcEmisorCtaBen" class="control-label" data-toggle="tooltip">
                                RFC Emisor Ben.
                                </label>
                                <input type="text" name="rfcEmisorCtaBen" value="<?php echo isset($pagos[0]->rfcEmisorCtaBen) ? $pagos[0]->rfcEmisorCtaBen : '' ?>" id="rfcEmisorCtaBen" class="form-control">
                                </div>
                                <div class="col-md-3">
                                <label for="ctaBeneficiario" class=" control-label" data-toggle="tooltip">
                                Cta. Beneficiario
                                </label>
                                <input type="text" name="ctaBeneficiario" value="<?php echo isset($pagos[0]->ctaBeneficiario) ? $pagos[0]->ctaBeneficiario : '' ?>" id="ctaBeneficiario" class="form-control">
                                </div>
                            </div>
            </div>

            <div class="panel panel-info">
                            <div class="panel-heading">
                            <h3 class="panel-title">Informaci&oacute;n de la Operaci&oacute;n</h3>
                            </div>
                            <div class="panel-body">
                            <div class="row">
                            <div class="col-sm-9">
                                <label for="tipoCadPago" class="col-md-2 control-label" data-toggle="tooltip"
                                title="Atributo condicional para identificar la clave del tipo de
                                cadena de pago que genera la entidad receptora del pago.
                                Considerar las reglas de obligatoriedad publicadas en la
                                página del SAT para éste atributo de acuerdo con el
                                catálogo catCFDI:c_FormaPago.">
                                Tipo Cad. Pago
                                </label>
                                <div class="col-md-2">
                                <select name="tipoCadPago" id="tipoCadPago" value="<?php echo isset($pagos[0]->tipoCadPago) ? $pagos[0]->tipoCadPago : '' ?>" class="form-control" onchange="habilitarFile()">
                                <option value=""></option>
                                <option value="01">SPEI</option>
                                </select>
                                </div>
                                <div id="divXML" style="display:none;">
                                <label for="xml" class="col-md-2 control-label" data-toggle="tooltip"
                                title="Carga el archivo XMLL de su pago ">
                                XML Pago
                                </label>
                                <input id="fileChooser" type="file"></div>
                            </div>
                            </div>
                            <br>
                           <div class="row">
                                  <div class="col-md-10">
                                  <label for="certPago" class="col-md-2 control-label" data-toggle="tooltip"
                                  title="Atributo condicional que sirve para incorporar el certificado
                                  que ampara al pago, como una cadena de texto en
                                  formato base 64. Es requerido en caso de que el atributo
                                  TipoCadPago contenga información.">
                                  Certificado Pago
                                  </label>
                                  <input name="certPago" id="certPago" value="<?php echo isset($pagos[0]->certPago) ? $pagos[0]->certPago : '' ?>" class="form-control">
                                  </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-10">
                                <label for="cadPago" class="col-md-2 control-label" data-toggle="tooltip"
                                title="Atributo condicional para expresar la cadena original del
                                comprobante de pago generado por la entidad emisora de
                                la cuenta beneficiaria. Es requerido en caso de que el
                                atributo TipoCadPago contenga información.">
                                Cadena Pago
                                </label>
                                <input name="cadPago" id="cadPago" class="form-control" value="<?php echo isset($pagos[0]->cadPago) ? $pagos[0]->cadPago : '' ?>">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-10">
                                <label for="selloPago" class="col-md-2 control-label" data-toggle="tooltip"
                                title="Atributo condicional para integrar el sello digital que se
                                asocie al pago. La entidad que emite el comprobante de
                                pago, ingresa una cadena original y el sello digital en una
                                sección de dicho comprobante, este sello digital es el que
                                se debe registrar en este campo. Debe ser expresado
                                como una cadena de texto en formato base 64. Es
                                requerido en caso de que el atributo TipoCadPago
                                contenga información.">
                                Sello Pago
                                </label>
                                <input name="selloPago" id="selloPago" value="<?php echo isset($pagos[0]->selloPago) ? $pagos[0]->selloPago : ''?>" class="form-control">
                                </div>
                            </div>
                            </div>
           </div>

            <div class="panel panel-info" id="panel_doctosrelacionados">
                <div class="panel-heading">
                  <h3 class="panel-title">Relacionados al Pago</h3>
                </div>
                <div class="panel-body">
                <div class="row">
                    <div class="col-md-1">
                      <label>Serie:</label>
                      <input type="text" id="serie_pago" onkeyup="mayusculas()" name="serie_pago" class="form-control" >
                    </div>
                   <div class="col-md-2">
                     <label>Folio:</label>
                      <input type="text" id="folio_pago" name="folio_pago" class="form-control">
                   </div>
                    <div class="col-md-1">
                    <br />
                        <button type="button" class="btn btn-success" id="btn_agrega_docto"><span class="glyphicon glyphicon-search"></span></button>
                    </div>
                    <div class="col-md-5" id="monedaDRdiv" style="display:none;">
                    <label>Moneda:</label>
                    <select name="monedaDR" id="monedaDR" class="form-control">
                        <?php foreach($monedas as $moneda): ?>
                        <option value="<?php echo $moneda['c_Moneda']?>" <?php echo ($moneda['c_Moneda']  == 'MXN'? 'selected' : '')?>>
                            <?php echo $moneda['c_Moneda'] . ' - ' . $moneda['descripcion'];?>
                        </option>
                        <?php endforeach;?>
                    </select>
                    </div>
                    <div class="col-md-3" id="tcDRdiv" style="display:none;">
                    <label>Tipo de Cambio:</label>
                    <input type="text" id="tc" class="form-control" placeholder="1.00" >
                    </div>
                </div>
                <br>
                <div class="row">
                   <div class="col-md-3">
                      <label for="">En Tipo Usar: 1 (Pagos); 2 (Remesas)</label> 
                      <br>
                      <br>
                      <input type="checkbox" id="editarcampos" onclick="cambiocampos()" name="editarcampos"> <label for="">Permitir editar los campos de Saldo, #Parc. y Pago.</label>
                   </div>
                </div>
                <div class="row">
                   <br>
                   <div class="col-md-1">
                       <label for="">Tipo:</label>
                       <input type="text" onkeypress="return soloNumeroPagos(event)" maxlength="1" class="form-control" id="tipo_pago_detalle" name="tipo_pago_detalle">
                   </div>
                   <div class="col-md-1">
                       <label for="">Serie:</label>
                       <input type="text" readonly class="form-control" id="serie_pago_detalle" name="serie_pago_detalle">
                   </div>
                   <div class="col-md-2">
                       <label for="">Folio:</label>
                       <input type="text" readonly class="form-control" id="folio_pago_detalle" name="folio_pago_detalle">
                   </div>
                   <div class="col-md-2">
                       <label for="">Referencia:</label>
                       <input type="text" class="form-control" id="referencia_pago_detalle" name="referencia_pago_detalle">
                   </div>
                   <div class="col-md-3">
                       <label for="">UUID:</label>
                       <input type="text" readonly class="form-control" id="uuid_pago_detalle" name="uuid_pago_detalle">
                   </div>
                   <div class="col-md-1">
                       <label for="">Moneda:</label>
                       <input type="text" readonly class="form-control" id="moneda_pago_detalle" name="moneda_pago_detalle">
                   </div>
                   <div class="col-md-2">
                        <label for="">Tipo Cambio:</label>
                        <input type="text" readonly class="form-control" id="tipo_cambio_pago_detalle" name="tipo_cambio_pago_detalle">
                   </div>
                </div>
                <br>
                <div class="row">
                   <div class="col-md-1">
                      <label for="">Metodo:</label>
                      <input type="text" readonly class="form-control" id="metodo_pago_detalle" name="metodo_pago_detalle">
                   </div>
                   <div class="col-md-2">
                      <label for="">Saldo:</label>
                      <input type="text" readonly class="form-control" id="saldo_pago_detalle" name="saldo_pago_detalle">
                   </div>
                   <div class="col-md-1">
                      <label for="">#Parc:</label>
                      <input type="text" readonly class="form-control" id="parc_pago_detalle" name="parc_pago_detalle">
                   </div>
                   <div class="col-md-2">
                      <label for="">Pago:</label>
                      <input type="text" readonly class="form-control" id="pago_pago_detalle" name="pago_pago_detalle">
                   </div>
                   <div class="col-md-2">
                       <label for="">Dif. Importe:</label>
                       <input type="text" class="form-control" id="dif_impo_pago_detalle" name="dif_impo_pago_detalle">
                   </div>
                   <div class="col-md-2">
                      <label for="">Total Pago:</label>
                      <input type="text" readonly class="form-control" id="total_pago_pago_detalle" name="total_pago_pago_detalle">
                   </div>
                   <div class="col-md-2">
                       <label for="">Saldo Insoluto:</label>
                       <input type="text" readonly class="form-control" id="saldo_inso_pago_detalle" name="saldo_inso_pago_detalle">
                   </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2">  
                        <label for="">Obj Imp:</label>
                        <select name="objeto_imp_dr" id="objeto_imp_dr" class="form-control">
                            <option value="">-Seleccione-</option>
                            <option value="01">01 - No objeto de impuesto</option>
                            <option value="02" selected >02 - Si objeto de impuesto</option>
                            <option value="03">03 - Si objeto del impuesto y no obligado al desglose</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                   <center>
                      <button type="button" class="btn btn-success" onclick="agregar_tabla_pagos()">
                      Agregar
                      <br>
                     <span class="fa fa-caret-down"></span>
                      </button>
                   </center>
                </div>
                <br>
                <table id="docto_relacionado" class="table table-bordered table-hover" cellspacing="0" width="100%">
                  <thead  style="background-color:#5a5a5a; color:white;">
                     <tr>
                        <th>Tipo</th>
                        <th>Serie</th>
                        <th>Folio</th>
                        <th>Referencia</th>
                        <th>UUID</th>
                        <th>Moneda</th>
                        <th>Tipo Cambio</th>
                        <th>Metodo</th>
                        <th>Saldo</th>
                        <th>#Parc</th>
                        <th>Pago</th>
                        <th>Dif. Importe</th>
                        <th>Total Pago</th>
                        <th>Saldo Insoluto</th>
                        <th>Obj imp</th>
                     </tr>
                  </thead>
                  <?php
                     if(isset($pagos) && count($pagos) > 0)
                     {
                          foreach($pagos_detalle as $pagos_deta)
                          {
                              echo ('<tr>');
                              echo ('<td>'.$pagos_deta->tipo.'</td>');
                              echo ('<td>'.$pagos_deta->serie.'</td>');
                              echo ('<td>'.$pagos_deta->folio.'</td>');
                              echo ('<td>'.$pagos_deta->referencia.'</td>');
                              echo ('<td>'.$pagos_deta->uuid.'</td>');
                              echo ('<td>'.$pagos_deta->monedaDR.'</td>');
                              echo ('<td>'.$pagos_deta->tipoCambioDR.'</td>');
                              echo ('<td>'.$pagos_deta->metodoDePagoDR.'</td>');
                              echo ('<td>'.$pagos_deta->impSaldoAnt.'</td>');
                              echo ('<td>'.$pagos_deta->numParcialidad.'</td>');
                              echo ('<td>'.$pagos_deta->impPagado.'</td>');
                              echo ('<td>'.$pagos_deta->c_aPorDiferencia.'</td>');
                              echo ('<td>'.$pagos_deta->totalPago.'</td>');
                              echo ('<td>'.$pagos_deta->impSaldoInsoluto.'</td>');
                              echo ('<td>'.$pagos_deta->objimpdr.'</td>');
                              echo ('</tr>');
                          }
                     }
                  ?>
                  <tbody>
                  </tbody>
                </table>
              <div class="row">
                  <div class="col-md-6">
                  </div>
                  <div class="col-md-2">
                    <label for="" class="form-label">Suma total (moneda en factura)</label>
                  </div>
                  <div class="col-md-1">
                      <input type="text" readonly value="<?php echo isset($impPagado) ? number_format($impPagado,2,'.','') : '0.00'?>" id="factura_sub_total" name="factura_sub_total" class="form-control" >
                  </div>
                  <div class="col-md-1">
                      <input type="text" readonly value="<?php echo isset($impDife) ? number_format($impDife,2,'.','') : '0.00'?>" id="factura_dife" name="factura_dife" class="form-control" >
                  </div>
                  <div class="col-md-1">
                      <input type="text" readonly value="<?php echo isset($totalPago) ? number_format($totalPago,2,'.','') : '0.00'?>" id="factura_total" name="factura_total" class="form-control" >
                  </div>
                  <div class="col-md-1">
                      <input type="text" readonly value="<?php echo isset($saldoInso) ? number_format($saldoInso,2,'.','') : '0.00'?>" id="factura_insoluto" name="factura_insoluto" class="form-control" >
                  </div>
               </div>
               <br>
              <div class="row">
                  <div class="col-md-6">
                  </div>
                  <div class="col-md-2">
                       <label for="" class="form-label">Suma total (moneda de pago)</label>
                  </div>
                  <div class="col-md-1">
                      <input type="text" readonly id="mo_pago_sub_total" name="mo_pago_sub_total" class="form-control" value='0.00'>
                  </div>
                  <div class="col-md-1">
                      <input type="text" readonly id="mo_pago_dife" name="mo_pago_dife" class="form-control" value='0.00'>
                  </div>
                  <div class="col-md-1">
                      <input type="text" readonly id="mo_pago_total" name="mo_pago_total" class="form-control" value='0.00'>
                  </div>
                  <div class="col-md-1">
                      <input type="text" readonly id="mo_pago_insoluto" name="mo_pago_insoluto" class="form-control" value='0.00'>
                  </div>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" onclick="mayormontopago()">Listo</button>
            <button type="button" class="btn btn-danger" onclick="cerrar_pago()">Cancelar</button>
        </div>
    </div>

</div>
</div>

<script>
function cerrar_pago()
{
   document.getElementById('agregar_pago').checked = false;
   $('#myModalregistroPagos').modal('hide');
}
function mayormontopago()
{
    var monto_pago = parseFloat(document.getElementById('monto_pago').value);
    var total_pago = parseFloat(document.getElementById('factura_total').value);

    if(total_pago > monto_pago)
    {
        var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'El total de la factura no puede ser mayor al monto del pago.'});
    }
    else
    {
        $('#myModalregistroPagos').modal('hide');
    }
}
function mayusculas()
{
  var x = document.getElementById('serie_pago');
  x.value = x.value.toUpperCase();
}
</script>


<style>
#mdialTamanio{
      width: 80% !important;
}
.ui-autocomplete {
    z-index: 5000;
}
</style>

<script>
function cambiocampos()
{
   var valor = document.getElementById('editarcampos').checked;
   if(valor == true)
   {
       $('#saldo_pago_detalle').prop('readonly',false);
       $('#parc_pago_detalle').prop('readonly',false);
       $('#pago_pago_detalle').prop('readonly',false);
   }
   else
   {
       $('#saldo_pago_detalle').prop('readonly',true);
       $('#parc_pago_detalle').prop('readonly',true);
       $('#pago_pago_detalle').prop('readonly',true);
   }
   
}
    function soloNumeroPagos(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toUpperCase();
       letras = "12";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales)
       {
            if(key == especiales[i])
            {
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial)
        {
            return false;
        }
    }
function agregar_tabla_pagos()
{

  // if(document.getElementById('uuid_pago_detalle').value == '')
  // {
  //    swal('Advertencia', 'Faltan datos por agregar', 'warning');
  // }
  if(document.getElementById('tipo_pago_detalle').value == '')
  {
    swal('Advertencia','Agregue un Tipo: 1 (Pagos); 2 (Remesas)','warning');
  }
  else if(document.getElementById('referencia_pago_detalle').value == '')
  {
    swal('Advertencia','Agregue la referencia','warning');
  }
  else if(document.getElementById('dif_impo_pago_detalle').value == '')
  {
    swal('Advertencia','Agregue el importe de diferencia','warning');
  }
  else if(document.getElementById('objeto_imp_dr').value == '')
  {
    swal('Advertencia','Falta agregar si es objeto de impuesto','warning');
  }
  else
  {

    var table = x('docto_relacionado'); 
    var rowCount = table.rows.length;
    var uuid = [];
    var verdad = false;
    var uuid_campo = document.getElementById('uuid_pago_detalle').value;
    
            for(var i = 0; i < rowCount; i++)
            {
               uuid[i] = table.rows[i].cells[4].innerHTML;
               if(uuid_campo == uuid[i])
               {
                  verdad = true;
               }
            }

            if(verdad == true)
            {
              var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Esta factura ya esta agregada en el pago'});
                document.getElementById('tipo_pago_detalle').value = '';
                document.getElementById('serie_pago_detalle').value = '';
                document.getElementById('folio_pago_detalle').value = '';
                document.getElementById('referencia_pago_detalle').value = '';
                document.getElementById('uuid_pago_detalle').value = '';
                document.getElementById('moneda_pago_detalle').value = '';
                document.getElementById('tipo_cambio_pago_detalle').value = '';
                document.getElementById('metodo_pago_detalle').value = '';
                document.getElementById('saldo_pago_detalle').value = '';
                document.getElementById('parc_pago_detalle').value = '';
                document.getElementById('pago_pago_detalle').value = '';
                document.getElementById('dif_impo_pago_detalle').value = '';
                document.getElementById('total_pago_pago_detalle').value = '';
                document.getElementById('saldo_inso_pago_detalle').value = '';
            }
            else
            {
                if(document.getElementById('moneda_pago_detalle').value == 'MXN')
                {

                      if(document.getElementById('tipo_cambio_pago_detalle').value == '')
                      {
                         var tipo_cambio_pago = 0.0000;
                      }
                      else
                      {
                          var tipo_cambio_pago = document.getElementById('tipo_cambio_pago_detalle').value;
                      }
                     var pago_pago = parseFloat(document.getElementById('pago_pago_detalle').value);
                     var dife_pago = parseFloat(document.getElementById('dif_impo_pago_detalle').value);
                     var total_pago = pago_pago + dife_pago;

                     var saldo_pago = parseFloat(document.getElementById('saldo_pago_detalle').value);
                     var saldo_inso = saldo_pago - pago_pago;

                     var tbody = document.getElementById('docto_relacionado').getElementsByTagName("TBODY")[0];
                     var row = document.createElement("TR")
                    
                     var td0 = document.createElement("TD")
                     td0.appendChild(document.createTextNode(document.getElementById('tipo_pago_detalle').value))
                     var td1 = document.createElement("TD")
                     td1.appendChild(document.createTextNode(document.getElementById('serie_pago_detalle').value))
                     var td2 = document.createElement("TD")
                     td2.appendChild(document.createTextNode(document.getElementById('folio_pago_detalle').value))
                     var td3 = document.createElement("TD")
                     td3.appendChild(document.createTextNode(document.getElementById('referencia_pago_detalle').value))
                     var td4 = document.createElement("TD")
                     td4.appendChild(document.createTextNode(document.getElementById('uuid_pago_detalle').value))
                     var td5 = document.createElement("TD")
                     td5.appendChild(document.createTextNode(document.getElementById('moneda_pago_detalle').value))
                     var td6 = document.createElement("TD")
                     td6.appendChild(document.createTextNode(tipo_cambio_pago))
                     var td7 = document.createElement("TD")
                     td7.appendChild(document.createTextNode(document.getElementById('metodo_pago_detalle').value))
                     var td8 = document.createElement("TD")
                     td8.appendChild(document.createTextNode(saldo_pago.toFixed(2)))
                     var td9 = document.createElement("TD")
                     td9.appendChild(document.createTextNode(document.getElementById('parc_pago_detalle').value))
                     var td10 = document.createElement("TD")
                     td10.appendChild(document.createTextNode(pago_pago.toFixed(2)))
                     var td11 = document.createElement("TD")
                     td11.appendChild(document.createTextNode(dife_pago.toFixed(2)))
                     var td12 = document.createElement("TD")
                     td12.appendChild(document.createTextNode(total_pago.toFixed(2)))
                     var td13 = document.createElement("TD")
                     td13.appendChild(document.createTextNode(saldo_inso.toFixed(2)))
                     var td14 = document.createElement("TD")
                     td14.appendChild(document.createTextNode(document.getElementById('objeto_imp_dr').value))

                     var factura_total = parseFloat(document.getElementById('factura_total').value);
                     var nueva_factu_total = total_pago + factura_total;
                     document.getElementById('factura_total').value = nueva_factu_total.toFixed(2);

                     var factu_inso = parseFloat(document.getElementById('factura_insoluto').value);
                     var nueva_inso = factu_inso + saldo_inso;
                     document.getElementById('factura_insoluto').value = nueva_inso.toFixed(2);



                     var factu_dife = parseFloat(document.getElementById('factura_dife').value);
                     var dip = parseFloat(document.getElementById('dif_impo_pago_detalle').value);
                     var nueva_refe = factu_dife + dip;
                     document.getElementById('factura_dife').value = nueva_refe.toFixed(2);

                     var factura_sub = parseFloat(document.getElementById('factura_sub_total').value);
                     var pago_de = parseFloat(document.getElementById('pago_pago_detalle').value);
                     var nueva_pago = factura_sub + pago_de;
                     document.getElementById('factura_sub_total').value = nueva_pago.toFixed(2);

                    //  var factu_to = parseFloat(document.getElementById('factura_total').value);
                    //  var totl_pago = parseFloat(document.getElementById('total_pago_pago_detalle').value);
                    //  var nuevo_tol = factu_to + totl_pago;
                    //  document.getElementById('factura_total').value = nuevo_tol.toFixed(2);

                    //  var factu_inso = parseFloat(document.getElementById('factura_insoluto').value);
                    //  var insolu = parseFloat(document.getElementById('saldo_inso_pago_detalle').value);
                    //  var nuevo_inso = factu_inso + insolu;
                    //  document.getElementById('factura_insoluto').value = nuevo_inso.toFixed(2);

                     row.appendChild(td0);
                     row.appendChild(td1);
                     row.appendChild(td2);
                     row.appendChild(td3);
                     row.appendChild(td4);
                     row.appendChild(td5);
                     row.appendChild(td6);
                     row.appendChild(td7);
                     row.appendChild(td8);
                     row.appendChild(td9);
                     row.appendChild(td10);
                     row.appendChild(td11);
                     row.appendChild(td12);
                     row.appendChild(td13);
                     row.appendChild(td14);

                     tbody.appendChild(row);

                     document.getElementById('tipo_pago_detalle').value = '';
                     document.getElementById('serie_pago_detalle').value = '';
                     document.getElementById('folio_pago_detalle').value = '';
                     document.getElementById('referencia_pago_detalle').value = '';
                     document.getElementById('uuid_pago_detalle').value = '';
                     document.getElementById('moneda_pago_detalle').value = '';
                     document.getElementById('tipo_cambio_pago_detalle').value = '';
                     document.getElementById('metodo_pago_detalle').value = '';
                     document.getElementById('saldo_pago_detalle').value = '';
                     document.getElementById('parc_pago_detalle').value = '';
                     document.getElementById('pago_pago_detalle').value = '';
                     document.getElementById('dif_impo_pago_detalle').value = '';
                     document.getElementById('total_pago_pago_detalle').value = '';
                     document.getElementById('saldo_inso_pago_detalle').value = '';
                }
                else
                {
                   var pago_pago = parseFloat(document.getElementById('pago_pago_detalle').value);
                   var dife_pago = parseFloat(document.getElementById('dif_impo_pago-detalle').value);
                   var total_pago = pago_pago + dife_pago;

                   var saldo_pago = parseFloat(document.getElementById('saldo_pago_detalle').value);
                   var saldo_inso = saldo_pago - pago_pago;

                   var tbody = document.getElementById('docto_relacionado').getElementByTagName("TBODY")[0];
                   var row = document.createElement("TR")

                   var td0 = document.createElement("TD")
                   td0.appendChild(document.createTextNode(document.getElementById('tipo_pago_detalle').value))
                   var td1 = document.createElement("TD")
                   td1.appendChild(document.createTextNode(document.getElementById('serie_pago_detalle').value))
                   var td2 = document.createElement("TD")
                   td2.appendChild(document.createTextNode(document.getElementById('folio_pago_detalle').value))
                   var td3 = document.createElement("TD")
                   td3.appendChild(document.createTextNode(document.getElementById('referencia_pago_detalle').value))
                   var td4 = document.createElement("TD")
                   td4.appendChild(document.createTextNode(document.getElementById('uuid_pago_detalle').value))
                   var td5 = document.createElement("TD")
                   td5.appendChild(document.createTextNode(document.getElementById('moneda_pago_detalle').value))
                   var td6 = document.createElement("TD")
                   td6.appendChild(document.createTextNode(document.getElementById('tipo_cambio_pago_detalle').value))
                   var td7 = document.createElement("TD")
                   td7.appendChild(document.createTextNode(document.getElementById('metodo_pago_detalle').value))
                   var td8 = document.createElement("TD")
                   td8.appendChild(document.createTextNode(saldo_pago.toFixed(2)))
                   var td9 = document.createElement("TD")
                   td9.appendChild(document.createTextNode(document.getElementById('parc_pago_detalle').value))
                   var td10 = document.createElement("TD")
                   td10.appendChild(document.createTextNode(pago_pago.toFixed(2)))
                   var td11 = document.createElement("TD")
                   td11.appendChild(document.createTextNode(dife_pago.toFixed(2)))
                   var td12 = document.createElement("TD")
                   td12.appendChild(document.createTextNode(total_pago.toFixed(2)))
                   var td13 = document.createElement("TD")
                   td13.appendChild(document.createTextNode(saldo_inso.toFixed(2)))
                   var td14 = document.createElement("TD")
                   td14.appendChild(document.createTextNode(document.getElementById('objeto_imp_dr').value))



                  row.appendChild(td0);
                  row.appendChild(td1);
                  row.appendChild(td2);
                  row.appendChild(td3);
                  row.appendChild(td4);
                  row.appendChild(td5);
                  row.appendChild(td6);
                  row.appendChild(td7);
                  row.appendChild(td8);
                  row.appendChild(td9);
                  row.appendChild(td10);
                  row.appendChild(td11);
                  row.appendChild(td12);
                  row.appendChild(td13);
                  row.appendChild(td14);

                  tbody.appendChild();

                  document.getElementById('tipo_pago_detalle').value = '';
                  document.getElementById('serie_pago_detalle').value = '';
                  document.getElementById('folio_pago_detalle').value = '';
                  document.getElementById('referencia_pago_detalle').value = '';
                  document.getElementById('uuid_pago_detalle').value = '';
                  document.getElementById('moneda_pago_detalle').value = '';
                  document.getElementById('tipo_cambio_pago_detalle').value = '';
                  document.getElementById('metodo_pago_detalle').value = '';
                  document.getElementById('saldo_pago_detalle').value = '';
                  document.getElementById('parc_pago_detalle').value = '';
                  document.getElementById('pago_pago_detalle').value = '';
                  document.getElementById('dif_pago_detalle').value = '';
                  document.getElementById('total_pago_pago_detalle').value = '';
                  document.getElementById('total_pago_pago_detalle').value = '';
                  document.getElementById('saldo_inso_pago_detalle').value = '';

                   //swal("Advertencia","El tipo de cambio no es MXN","warning");
                }
            }     
  }
}
  function calcularTotal(index)
  {
     var total = 0;
     $('.inputPago').each(function(){
         total += parseFloat(this.value.replace(',',''))||0;
     });
     $("#totalPago").val(total);
     //addCommas(total);
  }
  $('#btn_agrega_docto').on('click', function (){


    if($('#clave').val() == ''){
      swal('Error', 'Debe especificar un cliente','error');
      return;
    }
    if($('#folio_pago').val() == '')
    {
      var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Agregue el folio'});
      return;
    }

    var id_pago = $('#id_pago_seleccionado').val();
    var id_cliente_pago = $('#id_cliente_pago').val();
    var serie = $('#serie_pago').val();
    var folio = $('#folio_pago').val();

    $.ajax({
      url: baseurl + "Pagos/agrega_docto",
      type: 'POST',
      dataType: 'html',
      data: {
        id_pago:id_pago,
        id_cliente_pago:id_cliente_pago,
        serie:serie,
        folio:folio
      },
      success: function (response){
        response=JSON.parse(response);

        if(response.success){
          $('#serie_pago').val('');
          $('#folio_pago').val('');

            if(response.data.metodoDePagoDR == 'PPD')
            {
                //document.getElementById('tipo_pago_detalle').value = response.data.tipo;
                document.getElementById('serie_pago_detalle').value = response.data.serie;
                document.getElementById('folio_pago_detalle').value = response.data.folio;
                document.getElementById('referencia_pago_detalle').value = response.data.referencia;
                //document.getElementById('referencia').value = response.data.referencia;
                document.getElementById('uuid_pago_detalle').value = response.data.uuid;
                document.getElementById('moneda_pago_detalle').value = response.data.monedaDR;
                document.getElementById('tipo_cambio_pago_detalle').value = document.getElementById('tipoCambio').value;
                document.getElementById('metodo_pago_detalle').value = response.data.metodoDePagoDR;
                document.getElementById('saldo_pago_detalle').value = response.data.impSaldoAnt;
                document.getElementById('parc_pago_detalle').value = response.data.numParcialidad;
                document.getElementById('pago_pago_detalle').value = response.data.impPagado;
                //document.getElementById('dif_impo_pago_detalle').value = response.data.c_aPorDiferencia;
                document.getElementById('total_pago_pago_detalle').value = response.data.totalPago;
                document.getElementById('saldo_inso_pago_detalle').value = response.data.impSaldoInsoluto;
            }
            else
            {
              swal("Advertencia","La factura que desea agregar el metodo de pago no es PPD (Pago en Parcialidades o Diferido)","warning");
            }

        } else {
          swal('Error', response.error, 'error');
        }
      },
      error: function (){
        swal('Error', response.error, 'error');
      }
    });
});
$('[data-toggle="tooltip"]').tooltip();
function guardar_pago_regi(tableID)
{ 
  if($('#clave').val()!=""){
    var id_pago = document.getElementById('idPago').value;
    var nombre_cliente_pago = document.getElementById('nombre_cliente_pago').value;
    var clave = document.getElementById('clave').value;
    var id_cliente_pago = document.getElementById('id_cliente_pago').value;
    var rfc_pago = document.getElementById('rfc_pago').value;
    var fecha_pago = document.getElementById('fechapago').value;
    var forma_pago = document.getElementById('formaDePago').value;
    var moneda = document.getElementById('moneda_pago').value;
    var tipoCambio = document.getElementById('tipoCambio').value;
    var monto = document.getElementById('monto_pago').value;
    var numopera = document.getElementById('numOperacion').value;
    var ctaOrdenante = document.getElementById('ctaOrdenante').value;
    var rfcemisorctaord = document.getElementById('rfcEmisorCtaOrd').value;
    var nombancoord = document.getElementById('nomBancoOrdExt').value;
    var rfcemisorctaben = document.getElementById('rfcEmisorCtaBen').value;
    var ctabenefici = document.getElementById('ctaBeneficiario').value;
    var tipocadpago = document.getElementById('tipoCadPago').value;
    var certpago = document.getElementById('certPago').value;
    var cadpago = document.getElementById('cadPago').value;
    var sellopago = document.getElementById('selloPago').value;
    var tipo_movimiento = '<?php if($tipo == 1){echo 'T';}else if($tipo == 2){ echo 'C'; }else if($tipo == 3){echo 'D';}else{echo 'O';} ?>';
    var no_banco = '<?php echo $id ?>';
    var no_mov = document.getElementById('no_mov').value;

            // detalle pago
            var xyz = false;          var table = x(tableID);  
            var tipo = [];            var serie = [];         var folio = [];
            var referencia = [];      var uuid = [];          var monedaP = [];
            var tipo_cambio = [];     var metodo = [];        var saldo = [];
            var parc = [];            var pago = [];          var difimporte = [];    
            var total_pago = [];      var saldo_inso = [];    var objimpdr = [];
            var rowCount = table.rows.length;

            for(var i = 0; i < rowCount; i++)
            {
               tipo[i] = table.rows[i].cells[0].innerHTML;
               serie[i] = table.rows[i].cells[1].innerHTML;
               folio[i] = table.rows[i].cells[2].innerHTML;
               referencia[i] = table.rows[i].cells[3].innerHTML;
               uuid[i] = table.rows[i].cells[4].innerHTML;
               monedaP[i] = table.rows[i].cells[5].innerHTML;
               tipo_cambio[i] = table.rows[i].cells[6].innerHTML;
               metodo[i] = table.rows[i].cells[7].innerHTML;
               saldo[i] = table.rows[i].cells[8].innerHTML;
               parc[i] = table.rows[i].cells[9].innerHTML;
               pago[i] = table.rows[i].cells[10].innerHTML;
               difimporte[i] = table.rows[i].cells[11].innerHTML;
               total_pago[i] = table.rows[i].cells[12].innerHTML;
               saldo_inso[i] = table.rows[i].cells[13].innerHTML;
               objimpdr[i] = table.rows[i].cells[14].innerHTML;
            }

var jqXHR = jQuery.ajax({
        type:"POST",
        async: false,
        url: baseurl + "Pagos/insertpago",
        data:{nombre_cliente_pago:nombre_cliente_pago,rfc_pago:rfc_pago,id_cliente_pago:id_cliente_pago,clave:clave,id_pago:id_pago,fecha_pago:fecha_pago,forma_pago:forma_pago,moneda:moneda,tipoCambio:tipoCambio,monto:monto,numopera:numopera,
        ctaOrdenante:ctaOrdenante,rfcemisorctaord:rfcemisorctaord,nombancoord:nombancoord,
        rfcemisorctaben:rfcemisorctaben,ctabenefici:ctabenefici,tipocadpago:tipocadpago,certpago:certpago,cadpago:cadpago,
        sellopago:sellopago,tipo_movimiento:tipo_movimiento,no_banco:no_banco,no_mov:no_mov,tipo:tipo,serie:serie,folio:folio,
        referencia:referencia,uuid:uuid,monedaP:monedaP,tipo_cambio:tipo_cambio,metodo:metodo,saldo:saldo,parc:parc,pago:pago,
        difimporte:difimporte,total_pago:total_pago,saldo_inso:saldo_inso,objimpdr:objimpdr},
        dataType:"html",
        success:function(response)
        {

        },
        error: function()
        {

        }
    });

    return jqXHR.responseText;

  }
  else
  {
    swal('Advertencia', 'Seleccione un cliente primero en el registro de pago.', 'warning');
  }


}

function abarirmodalpago()
{
   $('#myModalPagos').modal('show');
}
function habilitarFile()
{
  if(x("tipoCadPago").value =='01')
  {$("#divXML").show();}
  else {
    $("#divXML").hide();
    x("certPago").value = '';
    x("selloPago").value = '';
    x("cadPago").value = '';
    x("monto_pago").value = '';
    x("fechapago").value = '';
    x("numOperacion").value = '';
  }
}
function CopiarValor(inpt){
    document.getElementById('importe').value=inpt.value;
  }
  var fileChooser = document.getElementById('fileChooser');

function parseTextAsXml(text) {
    var parser = new DOMParser(),
        xmlDoc = parser.parseFromString(text, "text/xml");
        var txt = "";
        var y;
        y = xmlDoc.getElementsByTagName("SPEI_Tercero")[0];//.childNodes[0];
        x("certPago").value = y.getAttribute('numeroCertificado');
        x("selloPago").value = y.getAttribute('sello');
        x("cadPago").value = y.getAttribute('cadenaCDA');
        x("monto_pago").value = y.getElementsByTagName("Beneficiario")[0].getAttribute('MontoPago');
        x("fechaPago").value = y.getAttribute('FechaOperacion')+
        'T'+ y.getAttribute('Hora');
        x("numOperacion").value = y.getAttribute('ClaveSPEI');
}

function waitForTextReadComplete(reader) {
    reader.onloadend = function(event) {
        var text = event.target.result;
        parseTextAsXml(text);
    }
}

function handleFileSelection() {
    var file = fileChooser.files[0],
        reader = new FileReader();

    waitForTextReadComplete(reader);
    reader.readAsText(file);
}

fileChooser.addEventListener('change', handleFileSelection, false);
</script>