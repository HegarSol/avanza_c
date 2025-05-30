<div class="modal fade" id="myModalCuentasPagar" role="dialog" >
<div class="modal-dialog modal-lg" id="mdialTamanio">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" id="cerrarclick2" name="cerrarclick2" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Cuentas por Pagar</h1>
        </div>
        <div class="modal-body">
        <b>Prov:</b> <span id="numprov" name="numprov"></span>
        <br>
        <b>Nombre:</b> <span id="nomprov" name="nomprov"></span>
        <br>
        <b>R.F.C:</b> <span id="rfcprov" name="rfcprov"></span>
        <br>
        <b>Direccion:</b> <span id="direprov" name="direprov"></span>
        <br>
        <input type="text" style="display:none" readonly id="tipoproveedor" name="tipoproveedor"></input>


        <!-- <input type="checkbox" id="mostrar_formas_pago" onclick="formaspago()" name="mostrar_formas_pago"> <b> Mostrar todas las formas de pagos</b> -->
        <br>
        <br>

        <button type="button" class="btn btn-warning" id="sinchecar" onclick="sin()">Mostrar todas las formas de pagos</button>
        <button type="button" class="btn btn-warning" style="display:none" id="conchecar" onclick="con()">Mostrar forma de pago actual</button>

        <br>
        <br>

        <button class="btn btn-primary" onclick="editarpoliza()"><span class="fa fa-pencil-square-o"></span> Editar póliza</button>
        <button class="btn btn-primary" onclick="verdetalle()"><span class="fa fa-eye"></span> Ver Docs</button>
        <button class="btn btn-info" onclick="descargarxml()"><span class="fa fa-download"></span> Descargar xml</button>

        <?php
        if($CXP == 'bene')
        {
        ?>
        <button class="btn btn-success" id="historicotrue" onclick="historicotrue()"><span class="fa fa-calendar"></span> Historico</button>
        <button class="btn btn-danger" id="historicofalse" style="display: none;" onclick="historicofalse()"><span class="fa fa-calendar"></span> Historico</button>
        <?php
        }
        ?>

        <?php
        if($CXP == 'bene')
        {
        ?>
            <button class="btn btn-danger" onclick="borarpoliza()"><span class="fa fa-eraser"></span> Borrar póliza</button>
         <?php
         }
         ?>
       
        <button class="btn btn-danger" onclick="borarfactura()"><span class="fa fa-eraser"></span> Borrar Factura</button>

        <?php
        if($CXP == 'bene')
        {
        ?>
        <button class="btn btn-danger" onclick="quitarpago()"><span class="fa fa-times"></span> Quitar Pago</button>    
        <?php
        }
        ?>

        <?php
        if($CXP == 'bene')
        {
        ?>
        <button class="btn btn-info" onclick="crearcontrareci()"><span class="fa fa-list-alt"></span> Crear contra recibos</button>
        <?php
        }
        ?>

        <?php
        if($CXP == 'BAN')
        {
        ?>
        <button class="btn btn-info" onclick="agregarsientocontable()"><span class="fa fa-list"></span> Mostrar contra recibos</button>
        <?php
        }
        ?>

       
       <?php 
       if($CXP == 'BAN')
       {    
       ?>
        <button class="btn btn-success" onclick="agregarpoliza()"><span class="fa fa-check"></span> Aceptar</button>
        <br>
        <br>
        <b>Seleciona las facturas que deseas agregar a la póliza actual marcando la casilla "Seleccionar" y después presiona el boton (<span class="fa fa-check"></span>Aceptar)</b>
      <?php
       }
      ?>

        <br>
        <br>
      <b>** Para "Editar póliza","Ver Docs",<?php if($CXP == 'bene') {?>"Borrar póliza", <?php }?>"Borrar Factura" <?php if($CXP == 'bene') {?>,"Quitar Pago" <?php }?> seleccione el renglon y despues precione dicho boton **</b>
        <br>
        <br>

        <div id="espacioEstafetaporpagar"></div>

        <div class="row">
               <div class="col-sm-6">
               </div>
               <div class="col-sm-2">
                     <div class="input-group">
                        <span class="input-group-addon">Total a Pagar</span>
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


<script>
   function agregarsientocontable()
   {
      document.getElementById('contrarecibospor').value = document.getElementById('numprov').innerHTML;
      $("#cerrarclick2").trigger("click");
      $('#myModalContrarecibos').modal('show');
      // var tbody = document.getElementById('asiento_conta').getElementsByTagName("TBODY")[0];
      //                       var row = document.createElement("TR")
                            
      //                       var element1 = document.createElement("input");
      //                       element1.type = "checkbox";
      //                       element1.name="chkbox[]"; 
                            
                            
      //                       var td0 = document.createElement("TD")
      //                       td0.style.textAlign = 'center';
      //                       td0.appendChild(element1)
      //                       var td1 = document.createElement("TD")
      //                       td1.appendChild(document.createTextNode(1))
      //                       var td2 = document.createElement("TD")
      //                       td2.appendChild(document.createTextNode(4))
      //                       var td3 = document.createElement("TD")
      //                       td3.appendChild(document.createTextNode(9))
      //                       var td4 = document.createElement("TD")
      //                       td4.appendChild(document.createTextNode(''))
      //                       var td5 = document.createElement("TD")
      //                       td5.appendChild(document.createTextNode(2))
      //                       var td6 = document.createElement("TD")
      //                       td6.appendChild(document.createTextNode(''))
      //                       var td7 = document.createElement("TD")
      //                       td7.appendChild(document.createTextNode(5))
      //                       var td8 = document.createElement("TD")
      //                       td8.appendChild(document.createTextNode('-'))
                               

      //                       row.appendChild(td0);
      //                       row.appendChild(td1);
      //                       row.appendChild(td2);
      //                       row.appendChild(td3);
      //                       row.appendChild(td4);
      //                       row.appendChild(td5);
      //                       row.appendChild(td6);798
      //                       row.appendChild(td7);
      //                       row.appendChild(td8);
      //                       tbody.appendChild(row);
   }
function sin()
{
            var formapago = '<?php echo $tipo_letra ?>';
            var no_banco = '<?php echo isset($id) ? $id : '' ?>';
            var mov = '<?php echo isset($datospoliza[0]['no_mov']) ? $datospoliza[0]['no_mov'] : '' ?>';
            var rfc = '<?php echo $rfc ?>';
            if(formapago == 'O')
            {
               var rfcemisor = 'TODOS';
            }
            else
            {
               if(document.getElementById('tipoproveedor').value == 4)
               {
                  var rfcemisor = 'TODOS';
               }
               else
               {
                  var rfcemisor = document.getElementById('rfcprov').innerHTML;
               }

            }

            var historico = '';
            var forma = '0';

            tablacue(rfc,rfcemisor,historico,forma,formapago, no_banco, mov);

            document.getElementById('sinchecar').style.display = 'none';
            document.getElementById('conchecar').style.display = 'block';

}
function con()
{

            var formapago = '<?php echo $tipo_letra ?>';
            var no_banco = '<?php echo isset($id) ? $id : '' ?>';
            var mov = '<?php echo isset($datospoliza[0]['no_mov']) ? $datospoliza[0]['no_mov'] : '' ?>';
            var rfc = '<?php echo $rfc ?>';
            
            if(formapago == 'O')
            {
               var rfcemisor = 'TODOS';
            }
            else
            {
               if(document.getElementById('tipoproveedor').value == 4)
               {
                  var rfcemisor = 'TODOS';
               }
               else
               {
                  var rfcemisor = document.getElementById('rfcprov').innerHTML;
               }

            }

            var historico = '';

            if(formapago == 'C')
            {
               var forma = '02';
            }
            else if(formapago == 'D')
            {
               var forma = '0';
            }
            else if(formapago == 'T')
            {
               var forma = '03';
            }
            else if(formapago == 'O')
            {
               var forma = '04';
            }

            tablacue(rfc,rfcemisor,historico,forma,formapago, no_banco, mov);

            document.getElementById('sinchecar').style.display = 'block';
            document.getElementById('conchecar').style.display = 'none';

}

function checartodo()
{

   var campos = '';
   var total = parseFloat(0);
          $("input[type=checkbox]:checked").each(function(){
                var recibo = [];
                var tipo = $(this).parent().parent().find('td').eq(2).html();
                var monto = parseFloat($(this).parent().parent().find('td').eq(20).html());
                total += monto;             
                campos+= tipo+',';

            });
            document.getElementById('uuidpagar').value = campos;
            document.getElementById('total_pagar').value = total.toFixed(2);
}

   function checar()
   {
         var detallereci = [];
          $("input[type=checkbox]:checked").each(function(){
                var recibo = [];
                var tipo = $(this).parent().parent().find('td').eq(2).html();
                var poliza = $(this).parent().parent().find('td').eq(27).html();
                var rfc = $(this).parent().parent().find('td').eq(21).html();
                var eliminar = "Eliminar";
                recibo = [tipo,poliza,rfc,eliminar];
                detallereci.push(recibo);
            });
            return detallereci;
   }
   function checarcontrare()
   {
      var detallereci = [];
          $("input[type=checkbox]:checked").each(function(){
                var recibo = [];
                var uuid = $(this).parent().parent().find('td').eq(2).html();
                var folio = $(this).parent().parent().find('td').eq(4).html();
                var serie = $(this).parent().parent().find('td').eq(5).html();
                var fecha = $(this).parent().parent().find('td').eq(6).html();
                var total = $(this).parent().parent().find('td').eq(20).html();
                var subto = $(this).parent().parent().find('td').eq(13).html();
                var iva = $(this).parent().parent().find('td').eq(14).html();
                var rfcemisor = $(this).parent().parent().find('td').eq(21).html();
                var eliminar = "Eliminar";
                recibo = [folio,serie,uuid,fecha,total,subto,iva,rfcemisor,eliminar];
                detallereci.push(recibo);
            });
            return detallereci;
   }
function crearcontrareci()
{
    var che = checarcontrare();
    if(che == '')
    {
      var n = noty({ layout:'topRight',type: 'warning', theme:'relax', text: 'No ha seleccionado las facturas para crear el contra recibo.'});
    }
    else
    {

        for(var i in che)
        {
          //  console.log(che[i]);
            var folio = che[i][0];
            var seri = che[i][1];
            var uuid = che[i][2];
            var fecha = che[i][3];
            var total = che[i][4];
            var subto = che[i][5];
            var iva = che[i][6];
            var rfcemi = che[i][7];
            var numpro = document.getElementById('numprov').innerHTML;

            jQuery.ajax({
               type:"POST",
               url: baseurl + "Contrarecibos/crearcontrareci",
               data:{folio:folio,seri:seri,numpro:numpro,uuid:uuid},
               dataType:"html",
               success:function(response)
               {
                   response=JSON.parse(response);
                   if(response.status == true)
                   {                    
                     $("#cerrarclick2").trigger("click");
                     window.open(baseurl+'Contrarecibos/pdf?folio='+folio+'&seri='+seri+'&uuid='+uuid+"&fecha="+fecha+"&total="+total+"&subt="+subto+"&iva="+iva+"&rfcemi="+rfcemi,'_blank');
                   }
                   else
                   {
                     var n = noty({ layout:'topRight',type: 'warning', theme:'relax', text: response.error});
                   }
               }
            });
        }
    }

}
function agregarpoliza()
{
   var chek = checar();

   if(chek == '')
   {
       var n = noty({ layout:'topRight',type: 'warning', theme:'relax', text: 'No ha seleccionado las facturas para agregar a la póliza.'});
   }
   else
   {
      var fecha_poliza = document.getElementById('fechatrabajo').value;
      var tipo_mov = '<?php if(isset($tipo) == 1){echo 'T';}else if(isset($tipo) == 2){ echo 'C'; } ?>';
      var no_banco = '<?php echo isset($datos[0]["no_banco"]);?>';
      var no_mov = document.getElementById('no_mov').value;
      var no_prov = document.getElementById('numprov').innerHTML;

      var poliza = tipo_mov + ' ' + no_banco + '       ' + no_mov;

      document.getElementById('montopoli').value = document.getElementById('total_pagar').value;
      $("#myClasifica tbody").empty();
      for(var i in chek)
      {
         let uuid = chek[i][0];
         let poli = chek[i][1];
         let rfc = chek[i][2];

         jQuery.ajax({
             type:"POST",
             url: baseurl + "catalogos/Beneficiarios/getbeneficirfc",
             data:{rfc:rfc},
             dataType:"html",
             success:function(response)
             {
                 response=JSON.parse(response);


                  var btn2 = document.createElement("INPUT");
                   btn2.setAttribute("type","button");
                   btn2.setAttribute('onclick','abrirregistro(this)');
                   btn2.id = 'btnbuscar2';
                   btn2.className = 'btn btn-primary';
                   btn2.value = 'Verificar'


                  var tbody = document.getElementById('tableclasifica').getElementsByTagName('TBODY')[0];
                  var row = document.createElement("TR")
                  var td4 = document.createElement("TD")
                  td4.appendChild(document.createTextNode(uuid))
                  var td5 = document.createElement("TD")
                  td5.appendChild(document.createTextNode(poli))
                  var td6 = document.createElement("TD")
                  td6.appendChild(document.createTextNode(response[0].no_prov))
                  var td7 = document.createElement("TD")
                  td7.appendChild(btn2)

                  row.appendChild(td4);
                  row.appendChild(td5);
                  row.appendChild(td6);
                  row.appendChild(td7);

                  tbody.appendChild(row);
             }
         });


      }

      $("#cerrarclick2").trigger("click");
     
     $('#myClasifica').modal('show');

      // verTabla('<?php echo $rfc ?>','<?php echo $tipo_letra?>');
   }
}

function recorrercuentas()
{
      var cajadeta = [];
      var p = document.getElementById('renglonclasi').value;
      let uuid = document.getElementById('tableclasifica').tBodies[0].rows[p-1].cells[0].innerHTML;
      let prov = document.getElementById('tableclasifica').tBodies[0].rows[p-1].cells[2].innerHTML;

      if ($('#btnbuscar').length) 
         {

               $("#table tr:gt(0)").each(function () {
                  var detalle = [];
                  var this_row = $(this);
                  var c = $.trim(this_row.find('td:eq(1)').html());
                  var sb = $.trim(this_row.find('td:eq(2)').html());
                  var ssb = $.trim(this_row.find('td:eq(3)').html());
                  var desc = $.trim(this_row.find('td:eq(4)').html());
                  var clave = $.trim(this_row.find('td:eq(5)').html());
                  if(c == '')
                  {
                     cajadeta.length=0;
                     return false;
                  }
                  else
                  {
                     detalle = [c,sb,ssb,desc,clave];
                     cajadeta.push(detalle);
                  }
               });

               if(cajadeta == 0)
               {
                  var n = noty({ layout:'topRight',type: 'warning', theme:'relax', text: 'Falta de agregar cuenta(s) a una(s) clave(s)'});
               }
               else
               {
                  jQuery.ajax({
                        type:"POST",
                        url: baseurl + "catalogos/Beneficiarios/insertdic",
                        data:{datos:cajadeta},
                        dataType:"html",
                        success:function()
                        {
                              jQuery.ajax({
                                 type:"POST",
                                 url: baseurl + "catalogos/Operaciones/buildAcientoContableContra",
                                 data:{uuid:uuid,nom_prov:prov,datos:cajadeta,poli:''},
                                 dataType:"html",
                                 success:function(response)
                                 {
                                    response=JSON.parse(response);

                                       for(var i in response.data)
                                       {
                                             var tbody = document.getElementById('asiento_conta').getElementsByTagName("TBODY")[0];
                                             var row = document.createElement("TR")
                                             
                                             var element1 = document.createElement("input");
                                             element1.type = "checkbox";
                                             element1.name="chkbox[]"; 
                                             
                                             console.log(response.data[i].nombre_cta);
                                             
                                             var td0 = document.createElement("TD")
                                             td0.style.textAlign = 'center';
                                             td0.appendChild(element1)
                                             var td1 = document.createElement("TD")
                                             td1.appendChild(document.createTextNode(response.data[i].cuenta))
                                             var td2 = document.createElement("TD")
                                             td2.appendChild(document.createTextNode(response.data[i].sub_cta))
                                             var td9 = document.createElement("TD")
                                             td9.appendChild(document.createTextNode(response.data[i].ssub_cta))
                                             var td3 = document.createElement("TD")
                                             td3.appendChild(document.createTextNode(0))
                                             var td4 = document.createElement("TD")
                                             td4.appendChild(document.createTextNode(''))
                                             var td5 = document.createElement("TD")
                                             td5.appendChild(document.createTextNode(response.data[i].nombre_cta))
                                             var td6 = document.createElement("TD")
                                             td6.appendChild(document.createTextNode(''))
                                             var td7 = document.createElement("TD")
                                             td7.appendChild(document.createTextNode(response.data[i].importe))
                                          
                                                if(response.data[i].c_a == '+')
                                                {
                                                   var c_a = '-';
                                                }
                                                else
                                                {
                                                   var c_a = '+';
                                                }
                                          
                                             var td8 = document.createElement("TD")
                                             td8.appendChild(document.createTextNode(c_a))

                                             row.appendChild(td0);
                                             row.appendChild(td1);
                                             row.appendChild(td2);
                                             row.appendChild(td9);
                                             row.appendChild(td3);
                                             row.appendChild(td4);
                                             row.appendChild(td5);
                                             row.appendChild(td6);
                                             row.appendChild(td7);
                                             row.appendChild(td8);
                                             tbody.appendChild(row);

                                             
                                             var posit = parseFloat(document.getElementById('positivo').value);
                                             var nega = parseFloat(document.getElementById('negativo').value);
                                             
                                             var monto = parseFloat(response.data[i].importe);

                                             if(c_a == '+')
                                             {
                                                var total = posit + monto;
                                                document.getElementById('positivo').value = total.toFixed(2);
                                             }
                                             else
                                             {
                                                var total = nega + monto;
                                                document.getElementById('negativo').value = total.toFixed(2);
                                             }

                                             var posit2 = parseFloat(document.getElementById('positivo').value);
                                             var nega2 = parseFloat(document.getElementById('negativo').value);

                                             var total2 = posit2-nega2;
                                             
                                             document.getElementById('totalpoliza').value = total2.toFixed(2);
                                       }
                                 }
                              });
                                    $('#myModalxml').modal('hide');

                                    $('#myClasifica').modal('show');
                        }
                  });
               }
       } 
       else 
       {
         $('#myModalxml').modal('hide');
         $('#myClasifica').modal('show');
       }
}
function agruparcuentas()
{
    var cajadeta = [];
    $("#asiento_conta tr:gt(0)").each(function () {
                  var detalle = [];
                  var this_row = $(this);
                  var c = $.trim(this_row.find('td:eq(1)').html());
                  var sb = $.trim(this_row.find('td:eq(2)').html());
                  var prov = $.trim(this_row.find('td:eq(3)').html());
                  var refe = $.trim(this_row.find('td:eq(4)').html());
                  var nom = $.trim(this_row.find('td:eq(5)').html());
                  var conc = $.trim(this_row.find('td:eq(6)').html());
                  var monto = $.trim(this_row.find('td:eq(7)').html());
                  var c_a = $.trim(this_row.find('td:eq(8)').html());

                  detalle = [c,sb,prov,refe,nom,conc,monto,c_a];
                  cajadeta.push(detalle);
                 
               });

    jQuery.ajax({
       type:"POST",
       url: baseurl + "catalogos/operaciones/agruparcuentas",
       data:{as:cajadeta},
       dataType:"html",
       success:function(res)
       {
           $("#asiento_conta tbody").empty();
           document.getElementById('positivo').value = 0.00;
           document.getElementById('negativo').value = 0.00;
           document.getElementById('totalpoliza').value = 0.00;

           response=JSON.parse(res);

           for(var i in response.data)
            {
                        var tbody = document.getElementById('asiento_conta').getElementsByTagName("TBODY")[0];
                              var row = document.createElement("TR")
                              
                              var element1 = document.createElement("input");
                              element1.type = "checkbox";
                              element1.name="chkbox[]"; 
                              
                              
                              var td0 = document.createElement("TD")
                              td0.style.textAlign = 'center';
                              td0.appendChild(element1)
                              var td1 = document.createElement("TD")
                              td1.appendChild(document.createTextNode(response.data[i].cuenta))
                              var td2 = document.createElement("TD")
                              td2.appendChild(document.createTextNode(response.data[i].subcuenta))
                              var td3 = document.createElement("TD")
                              td3.appendChild(document.createTextNode(response.data[i].prov))
                              var td4 = document.createElement("TD")
                              td4.appendChild(document.createTextNode(response.data[i].refe))
                              var td5 = document.createElement("TD")
                              td5.appendChild(document.createTextNode(response.data[i].nombre_cuenta))
                              var td6 = document.createElement("TD")
                              td6.appendChild(document.createTextNode(response.data[i].concep))
                              var td7 = document.createElement("TD")
                              td7.appendChild(document.createTextNode((response.data[i].importe).toFixed(2)))                           
                              var td8 = document.createElement("TD")
                              td8.appendChild(document.createTextNode(response.data[i].c_a))

                              row.appendChild(td0);
                              row.appendChild(td1);
                              row.appendChild(td2);
                              row.appendChild(td3);
                              row.appendChild(td4);
                              row.appendChild(td5);
                              row.appendChild(td6);
                              row.appendChild(td7);
                              row.appendChild(td8);
                              tbody.appendChild(row);

                              
                              var posit = parseFloat(document.getElementById('positivo').value);
                              var nega = parseFloat(document.getElementById('negativo').value);
                              
                              var monto = parseFloat(response.data[i].importe);

                              if(response.data[i].c_a == '+')
                              {
                                 var total = posit + monto;
                                 document.getElementById('positivo').value = total.toFixed(2);
                              }
                              else
                              {
                                 var total = nega + monto;
                                 document.getElementById('negativo').value = total.toFixed(2);
                              }

                              var posit2 = parseFloat(document.getElementById('positivo').value);
                              var nega2 = parseFloat(document.getElementById('negativo').value);

                              var total2 = posit2-nega2;
                              
                              document.getElementById('totalpoliza').value = total2.toFixed(2);
                     }
       }
    });
}
function abrirregistro(r)
{
   var p = r.parentNode.parentNode.rowIndex;
   document.getElementById('tableclasifica').tBodies[0].rows[p-1].cells[3].innerHTML = '';
   let uuid = document.getElementById('tableclasifica').tBodies[0].rows[p-1].cells[0].innerHTML;
   let poli = document.getElementById('tableclasifica').tBodies[0].rows[p-1].cells[1].innerHTML;
   let numprov = document.getElementById('tableclasifica').tBodies[0].rows[p-1].cells[2].innerHTML;
   let no_prov = document.getElementById('numprov').innerHTML;
   let porpaga = document.getElementById('valorporpagar').value;
console.log(1);

   document.getElementById('renglonclasi').value = p;
  
 if(poli == '')
 {
            jQuery.ajax({
                          url: baseurl+"catalogos/Beneficiarios/getarchivos",
                          type:"POST",
                          data:{uuid:uuid},
                          dataType:"html",
                          success:function(response2)
                          {
                             $("#table tbody").empty();
                             response2=JSON.parse(response2);
                             if(response2.data == 0)
                             {

                                    jQuery.ajax({
                                       type:"POST",
                                       url: baseurl + "catalogos/Operaciones/buildAcientoContableContra",
                                       data:{uuid:uuid,nom_prov:no_prov,datos:0,poli:poli,porpaga:porpaga},
                                       dataType:"html",
                                       success:function(response)
                                       {

                                         //  response=JSON.parse(response);

                                          //    for(var i in response.data)
                                          //    {
                                          //          var tbody = document.getElementById('asiento_conta').getElementsByTagName("TBODY")[0];
                                          //          var row = document.createElement("TR")
                                                   
                                          //          var element1 = document.createElement("input");
                                          //          element1.type = "checkbox";
                                          //          element1.name="chkbox[]"; 
                                                   
                                          //        //  console.log(response.data[i]);
                                                   
                                          //          var td0 = document.createElement("TD")
                                          //          td0.style.textAlign = 'center';
                                          //          td0.appendChild(element1)
                                          //          var td1 = document.createElement("TD")
                                          //          td1.appendChild(document.createTextNode(response.data[i].cuenta))
                                          //          var td2 = document.createElement("TD")
                                          //          td2.appendChild(document.createTextNode(response.data[i].sub_cta))
                                          //          var td3 = document.createElement("TD")
                                          //          td3.appendChild(document.createTextNode(numprov))
                                          //          var td4 = document.createElement("TD")
                                          //          td4.appendChild(document.createTextNode(''))
                                          //          var td5 = document.createElement("TD")
                                          //          td5.appendChild(document.createTextNode(response.data[i].nombre_cta))
                                          //          var td6 = document.createElement("TD")
                                          //          td6.appendChild(document.createTextNode(''))
                                          //          var td7 = document.createElement("TD")
                                          //          td7.appendChild(document.createTextNode(response.data[i].importe))
                                                
                                          //             if(response.data[i].c_a == '+')
                                          //             {
                                          //                var c_a = '-';
                                          //             }
                                          //             else
                                          //             {
                                          //                var c_a = '+';
                                          //             }
                                                
                                          //          var td8 = document.createElement("TD")
                                          //          td8.appendChild(document.createTextNode(c_a))

                                          //          row.appendChild(td0);
                                          //          row.appendChild(td1);
                                          //          row.appendChild(td2);
                                          //          row.appendChild(td3);
                                          //          row.appendChild(td4);
                                          //          row.appendChild(td5);
                                          //          row.appendChild(td6);
                                          //          row.appendChild(td7);
                                          //          row.appendChild(td8);
                                          //          tbody.appendChild(row);

                                                   
                                          //          var posit = parseFloat(document.getElementById('positivo').value);
                                          //          var nega = parseFloat(document.getElementById('negativo').value);
                                                   
                                          //          var monto = parseFloat(response.data[i].importe);

                                          //          if(c_a == '+')
                                          //          {
                                          //             var total = posit + monto;
                                          //             document.getElementById('positivo').value = total.toFixed(2);
                                          //          }
                                          //          else
                                          //          {
                                          //             var total = nega + monto;
                                          //             document.getElementById('negativo').value = total.toFixed(2);
                                          //          }

                                          //          var posit2 = parseFloat(document.getElementById('positivo').value);
                                          //          var nega2 = parseFloat(document.getElementById('negativo').value);

                                          //          var total2 = posit2-nega2;
                                                   
                                          //          document.getElementById('totalpoliza').value = total2.toFixed(2);
                                          //    }
                                       }
                                    });
                             }
                             else
                             {

                                  document.getElementById("estadocol").innerHTML = '';

                                                   if(response2.status == false)
                                                   {
                                                      var n = noty({ layout:'topRight',type: 'warning', theme:'relax', text: response2.error});
                                                   }
                                                   else
                                                   {

                                                      for(var i in response2.data)
                                                      {

                                                            var btn2 = document.createElement("INPUT");
                                                            btn2.setAttribute("type","button");
                                                            btn2.setAttribute('onclick','abrirmodalcuentas(this)');
                                                            btn2.id = 'btnbuscar';
                                                            btn2.className = 'btn btn-primary';
                                                            btn2.value = 'Abrir catálogo cuentas'

                                                            var clave = response2.data[i].clave;
                                                            var descrip = response2.data[i].descripcionSAT;
                                                            var descripxml = response2.data[i].descripcionxml;

                                                            var tbody = document.getElementById('table').getElementsByTagName('TBODY')[0];
                                                            var row = document.createElement("TR")
                                                            var td2 = document.createElement("TD")
                                                            td2.appendChild(btn2)
                                                            var td3 = document.createElement("TD")
                                                            td3.appendChild(document.createTextNode(''))
                                                            var td4 = document.createElement("TD")
                                                            td4.appendChild(document.createTextNode(''))
                                                            var td8 = document.createElement("TD")
                                                            td8.appendChild(document.createTextNode(''))
                                                            var td5 = document.createElement("TD")
                                                            td5.appendChild(document.createTextNode(''))
                                                            var td6 = document.createElement("TD")
                                                            td6.appendChild(document.createTextNode(clave))
                                                            var td7 = document.createElement("TD")
                                                            td7.appendChild(document.createTextNode(descrip))
                                                            var td9 = document.createElement("TD")
                                                            td9.appendChild(document.createTextNode(descripxml))

                                                            row.appendChild(td2);
                                                            row.appendChild(td3);
                                                            row.appendChild(td4);
                                                            row.appendChild(td8);
                                                            row.appendChild(td5);
                                                            row.appendChild(td6);
                                                            row.appendChild(td7);
                                                            row.appendChild(td9);

                                                            tbody.appendChild(row);

                                                      }
                                                      $('#myClasifica').modal('hide');
                                                      $('#myModalxml').modal('show');
                                                   }
                             }
                          }
                       });
 }
 else
 {
             jQuery.ajax({
               type:"POST",
               url: baseurl + "catalogos/Bancos/buscar_factu",
               data:{dato:uuid,poli:poli,no_prov:no_prov},
               dataType:"html",
               success:function(response)
               {
                                  
                   // response=JSON.parse(response);
                   // if(response.status == true)
                   // {

                    //    for(var i in response.data)
                    //    {
                    //          var tbody = document.getElementById('asiento_conta').getElementsByTagName("TBODY")[0];
                     //         var row = document.createElement("TR")
                              
                     //         var element1 = document.createElement("input");
                     //         element1.type = "checkbox";
                     //         element1.name="chkbox[]"; 
                              
                              
                    //          var td0 = document.createElement("TD")
                    //          td0.style.textAlign = 'center';
                    //          td0.appendChild(element1)
                    //          var td1 = document.createElement("TD")
                    //          td1.appendChild(document.createTextNode(response.data[i].cuenta))
                    //          var td2 = document.createElement("TD")
                    //          td2.appendChild(document.createTextNode(response.data[i].sub_cta))
                    //          var td3 = document.createElement("TD")
                    //          td3.appendChild(document.createTextNode(numprov))
                    //          var td4 = document.createElement("TD")
                    //          td4.appendChild(document.createTextNode(''))
                   //           var td5 = document.createElement("TD")
                   //           td5.appendChild(document.createTextNode(response.data[i].nombre_cta))
                   //           var td6 = document.createElement("TD")
                   //           td6.appendChild(document.createTextNode(''))
                    //          var td7 = document.createElement("TD")
                  //            td7.appendChild(document.createTextNode(response.data[i].importe))
                           
                    //       if(response.data[i].c_a == '+')
                   //        {
                    //          var c_a = '-';
                    //       }
                    //       else
                    //       {
                    //          var c_a = '+';
                    //       }
                           
                   //           var td8 = document.createElement("TD")
                    //          td8.appendChild(document.createTextNode(c_a))

                    //          row.appendChild(td0);
                   //           row.appendChild(td1);
                    //          row.appendChild(td2);
                    //          row.appendChild(td3);
                   //           row.appendChild(td4);
                   //           row.appendChild(td5);
                   //           row.appendChild(td6);
                   //           row.appendChild(td7);
                   //           row.appendChild(td8);
                   //           tbody.appendChild(row);

                              
                   //           var posit = parseFloat(document.getElementById('positivo').value);
                   //           var nega = parseFloat(document.getElementById('negativo').value);
                              
                   //           var monto = parseFloat(response.data[i].importe);

                   //           if(c_a == '+')
                   //           {
                    //             var total = posit + monto;
                   //              document.getElementById('positivo').value = total.toFixed(2);
                   //           }
                   //           else
                   //           {
                   //              var total = nega + monto;
                    //             document.getElementById('negativo').value = total.toFixed(2);
                      //        }

                    //          var posit2 = parseFloat(document.getElementById('positivo').value);
                   //           var nega2 = parseFloat(document.getElementById('negativo').value);

                  //            var total2 = posit2-nega2;
                              
                  //            document.getElementById('totalpoliza').value = total2.toFixed(2);
                              
                  //      }
                  //  }
               }
           });
 }

}
function abrirmodalcuentas(r)
  {

       $('#myModalxml').modal('hide');

       var p = r.parentNode.parentNode.rowIndex;
       document.getElementById('renglon').value = p;

       $('#myModalCuentas').modal('show');
  }
  function seleccionarcuneta(cuenta,subcta,nombre)
  {

       $('#myModalCuentas').modal('hide');

        var p = document.getElementById('renglon').value;
        document.getElementById('table').tBodies[0].rows[p-1].cells[1].innerHTML = cuenta;
        document.getElementById('table').tBodies[0].rows[p-1].cells[2].innerHTML = subcta;
        document.getElementById('table').tBodies[0].rows[p-1].cells[3].innerHTML = nombre;  

        $('#myModalxml').modal('show');
  }
function editarpoliza()
{
    var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblCuentasPagar");
      var aData = oTT.fnGetSelectedData();
      if(aData.length != 1)
      {
         var n = noty({ layout:'topRight',type: 'warning', theme:'relax', text: 'Seleccione un registro.'});
      }
      else if(aData[0][27] == '')
      {
         var n = noty({ layout:'topRight',type: 'warning', theme:'relax', text: 'No se puede editar la factura por que no tiene pólisa.'});
      }
      else
      {

          jQuery.ajax({
              type: "POST",
              url: baseurl+"catalogos/Beneficiarios/getpolizacuenta",
              data: {poliza:aData[0][27]},
              dataType: "html",
              success:function(response)
              {
                  $('#asiento_conta_provision tbody').empty();
                  document.getElementById('positivo_provision').value = 0.00;
                  document.getElementById('negativo_provision').value = 0.00;
                  document.getElementById('totalpoliza_provision').value = 0.00;
                  response=JSON.parse(response);
                  document.getElementById('id_asiento_contable').value = response[0].id_encabezado;
                  document.getElementById('tipo_asiento_contable').value = response[0].tipo_mov;
                  document.getElementById('banco_asiento_contable').value = response[0].no_banco;
                  document.getElementById('mov_asiento_contable').value = response[0].no_mov;
                  document.getElementById('fechacontable').value = response[0].fecha;
                  for(var i in response)
                  {

                     var tbody = document.getElementById('asiento_conta_provision').getElementsByTagName("TBODY")[0];
                     var row = document.createElement("TR")

                     var element1 = document.createElement("input");
                     element1.type = "checkbox";
                     element1.name="chkbox[]"; 

                     // let nf = new Intl.NumberFormat('en-US');
                     // nf.format(response[i].monto)

                     const formatoMexico = (number) => {
                     const exp = /(\d)(?=(\d{3})+(?!\d))/g;
                     const rep = '$1,';
                     return number.toString().replace(exp,rep);
                     }

                     
                     var td0 = document.createElement("TD")
                     td0.style.textAlign = 'center';
                     td0.appendChild(element1)
                     var td1 = document.createElement("TD")
                     td1.appendChild(document.createTextNode(response[i].cuenta))
                     var td2 = document.createElement("TD")
                     td2.appendChild(document.createTextNode(response[i].sub_cta))
                     var td9 = document.createElement("TD")
                     td9.appendChild(document.createTextNode(response[i].ssub_cta))
                     var td3 = document.createElement("TD")
                     td3.appendChild(document.createTextNode(response[i].no_prov))
                     var td4 = document.createElement("TD")
                     td4.appendChild(document.createTextNode(response[i].factrefe))
                     var td5 = document.createElement("TD")
                     td5.appendChild(document.createTextNode(response[i].nombre_cuenta))
                     var td6 = document.createElement("TD")
                     td6.setAttribute("contenteditable","true");
                     td6.appendChild(document.createTextNode(response[i].concepto))
                     var td7 = document.createElement("TD")
                     td7.appendChild(document.createTextNode(formatoMexico(response[i].monto)))
                     var td8 = document.createElement("TD")
                     td8.appendChild(document.createTextNode(response[i].c_a))
                      

                     row.appendChild(td0);
                     row.appendChild(td1);
                     row.appendChild(td2);
                     row.appendChild(td9);
                     row.appendChild(td3);
                     row.appendChild(td4);
                     row.appendChild(td5);
                     row.appendChild(td6);
                     row.appendChild(td7);
                     row.appendChild(td8);
                     tbody.appendChild(row);


                     var posit = parseFloat(document.getElementById('positivo_provision').value);
                     var nega = parseFloat(document.getElementById('negativo_provision').value);

                     if(response[i].c_a == '+')
                     {
                        var total = posit + parseFloat(response[i].monto);
                        document.getElementById('positivo_provision').value = total.toFixed(2);
                     }
                     else
                     {
                        var total = nega + parseFloat(response[i].monto);
                        document.getElementById('negativo_provision').value = total.toFixed(2);
                     }

                     var posit2 = parseFloat(document.getElementById('positivo_provision').value);
                     var nega2 = parseFloat(document.getElementById('negativo_provision').value);

                     var total2 = posit2-nega2;

                     document.getElementById('totalpoliza_provision').value = total2.toFixed(2);
                  }
                  document.getElementById('polizacientocontable').innerHTML = aData[0][27];
                  $('#myModalasientoContable').modal('show');
                  $("#cerrarclick2").trigger("click");
              }
          });
      }
}
function historicofalse()
{

    var rfc = '<?php echo $rfc ?>';
    var rfcemisor = document.getElementById('rfcprov').innerHTML;
    var historico = '';
    var formapago = '<?php echo $tipo_letra ?>';
    var no_banco = '<?php echo isset($id) ? $id : '' ?>';
    var mov = '<?php echo isset($datospoliza[0]['no_mov']) ? $datospoliza[0]['no_mov'] : '' ?>';

    if(formapago == 'C')
      {
         var forma = '02';
      }
      else if(formapago == 'D')
      {
         var forma = '0';
      }
      else if(formapago == 'T')
      {
         var forma = '03';
      }
      else if(formapago == 'O')
      {
         var forma = '04';
      }

   document.getElementById("historicofalse").style.display = "none";
   document.getElementById("historicotrue").style.display = "block";

   tablacue(rfc,rfcemisor,historico,forma,formapago,no_banco,mov);
}
function formaspago()
{
      var valor = document.getElementById('mostrar_formas_pago').checked;
      var no_banco = '<?php echo isset($id) ? $id : '' ?>';
      var mov = '<?php echo isset($datospoliza[0]['no_mov']) ? $datospoliza[0]['no_mov'] : '' ?>';
      if(valor == true)
      {
            var formapago = '<?php echo $tipo_letra ?>';
            var rfc = '<?php echo $rfc ?>';
            if(formapago == 'O')
            {
               var rfcemisor = 'TODOS';
            }
            else
            {
               if(document.getElementById('tipoproveedor').value == 4)
               {
                  var rfcemisor = 'TODOS';
               }
               else
               {
                  var rfcemisor = document.getElementById('rfcprov').innerHTML;
               }

            }

            var historico = '';
            var forma = '0';

      }
      else
      {
         var formapago = '<?php echo $tipo_letra ?>';
            var rfc = '<?php echo $rfc ?>';
            
            if(formapago == 'O')
            {
               var rfcemisor = 'TODOS';
            }
            else
            {
               if(document.getElementById('tipoproveedor').value == 4)
               {
                  var rfcemisor = 'TODOS';
               }
               else
               {
                  var rfcemisor = document.getElementById('rfcprov').innerHTML;
               }

            }

            var historico = '';

            if(formapago == 'C')
            {
               var forma = '02';
            }
            else if(formapago == 'D')
            {
               var forma = '0';
            }
            else if(formapago == 'T')
            {
               var forma = '03';
            }
            else if(formapago == 'O')
            {
               var forma = '04';
            }
      }

      tablacue(rfc,rfcemisor,historico,forma,formapago,no_banco,mov);
      
}
function historicotrue()
{

    var rfc = '<?php echo $rfc ?>';
    var rfcemisor = document.getElementById('rfcprov').innerHTML;
    var historico = true;
    var formapago = '<?php echo $tipo_letra ?>';
    var no_banco = '<?php echo isset($id) ? $id : '' ?>';
    var mov = '<?php echo isset($datospoliza[0]['no_mov']) ? $datospoliza[0]['no_mov'] : '' ?>';

      if(formapago == 'C')
      {
         var forma = '02';
      }
      else if(formapago == 'D')
      {
         var forma = '0';
      }
      else if(formapago == 'T')
      {
         var forma = '03';
      }
      else if(formapago == 'O')
      {
         var forma = '04';
      }

    document.getElementById("historicotrue").style.display = "none";
    document.getElementById("historicofalse").style.display = "block";

    tablacue(rfc,rfcemisor,historico,forma,formapago,no_banco,mov);

}
function tablacue(rfc,rfcemisor,historico,formapago,tipo,no_banco,mov)
{
   // console.log(tipo);
   // console.log(no_banco);
   // console.log(mov);

   document.getElementById('total_pagar').value = '0.00';
   jQuery.ajax({
       url: baseurl+"catalogos/Beneficiarios/getpendientesPagar",
       type:"POST",
       data:{rfc:rfc,rfcemisor:rfcemisor,historico:historico,formapago:formapago,tipo:tipo,no_banco:no_banco,mov:mov},
       dataType:"html",
       success:function(data)
       {
            
          if(data == 'No se encontraron registros')
          {
            $('#espacioEstafetaporpagar').innerHTML = 'No se encontraron registros';
          }
          else
          {
           $('#espacioEstafetaporpagar').html(data);
           $('#tblCuentasPagar').DataTable({
              language: { "url" : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
              "sDom": 'T<"clear">lfrtip', "oTableTools": {  "sRowSelect": "single","aButtons": ""},
              "columnDefs" : [
                 {
                    "targets" : [-1],
                    "orderable" : false
                 }
              ]
           });
          }

       },
       error:function()
       {
        var n = noty({text: 'Error al recuperar la informacion', type: 'error', theme: 'relax'});
       }
    });
}
function borarpoliza()
{
   var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblCuentasPagar");
      var aData = oTT.fnGetSelectedData();
      if(aData.length != 1)
      {
         var n = noty({ layout: 'topRight',type:'warning',theme:'relax', text: 'Seleccione un registro.'});
      }
      else
      {
           jQuery.ajax({
              type: "POST",
              url: baseurl + "",
              data: {},
              dataType:"html",
              success:function(response)
              {

              }
           });
      }
}
function borarfactura()
{

    var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblCuentasPagar");
       var aData = oTT.fnGetSelectedData();
       if(aData.length != 1)
       {
           var n = noty({ layout: 'topRight', type:"warning", theme: 'relax', text: 'Seleccione un registro.'});
       }
       else
       {
        // console.log(aData[0][5]);
            jQuery.ajax({
                 type:"POST",
                 url: baseurl + "catalogos/Beneficiarios/eliminarfactura",
                 data: {uuid:aData[0][2]},
                 dataType: "html",
                 success:function(response)
                 {
                    response=JSON.parse(response);
                    if(response.status == true)
                    {
                      verTabla('<?php echo $rfc ?>','<?php echo $tipo_letra ?>');
                      swal("Correcto","Eliminado satisfactoriamente.","success");                      
                    }
                    else
                    {
                      swal("Advertencia",response.error,"warning");
                    }
                 }
            });
       }
}
function quitarpago()
{
   var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblCuentasPagar");
      var aData = oTT.fnGetSelectedData();
      if(aData.length != 1)
      {
          var n = noty({ layout: 'topRight', type: 'warning', theme: 'relax', text: 'Seleccione un registro.'});
      }
      else
      {
           jQuery.ajax({
               type: "POST",
               url: baseurl + "catalogos/Beneficiarios/quitarpago",
               data: {uuid:aData[0][5],poliza:aData[0][29] ,empresa:'<?php echo $rfc ?>'},
               dataType: "html",
               success:function(response)
               {
                   response=JSON.parse(response);
                   if(response.status == true)
                   {
                      verTabla('<?php echo $rfc ?>','<?php echo $tipo_letra ?>');
                      swal("Correcto",'Liberado satisfactoriamente',"success");
                   }
                   else
                   {
                      swal("Advertencia",response.error,"warning");
                   }
               }
           });
      }
}
function descargarxml()
{
    var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblCuentasPagar");
    var aData = oTT.fnGetSelectedData();   
    var uuid = aData[0][2];

    if(aData.length != 1)
      {  
          var n = noty({ layout: 'topRight', type: 'warning', theme: 'relax', text: 'Seleccione un registro.'});
      }
      else
      {
         window.open(baseurl + "catalogos/Beneficiarios/descargarxml?uuid="+uuid, '_blank');
      }
}
function verdetalle()
{
    var oTT = $.fn.dataTable.TableTools.fnGetInstance("tblCuentasPagar");
            var aData = oTT.fnGetSelectedData();
            if (aData.length != 1) 
                { 
                   var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Seleccione un registro.'});
                }
            else
            {
                document.getElementById('version').value = aData[0][1];
                document.getElementById('uuid').value = aData[0][2];
                document.getElementById('tipo_comprobante').value = aData[0][3];
                document.getElementById('folio').value = aData[0][4];
                document.getElementById('serie').value = aData[0][5];
                document.getElementById('fecha').value = aData[0][6];
                document.getElementById('no_certificado').value = aData[0][7];
                document.getElementById('receptor').value = aData[0][22];
                document.getElementById('subtotal').value = aData[0][13];
                document.getElementById('tasa_iva').value = aData[0][15];
                document.getElementById('iva').value = aData[0][14];
                document.getElementById('ret_iva').value = aData[0][16];
                document.getElementById('ret_isr').value = aData[0][17];
                document.getElementById('tasa_ieps').value = aData[0][19];
                document.getElementById('ieps').value = aData[0][18];
                document.getElementById('total').value = aData[0][20];
                document.getElementById('forma_pago').value = aData[0][8];
                document.getElementById('metodo_pago').value = aData[0][9];
                document.getElementById('cuenta_banca').value = aData[0][10];
                document.getElementById('tipo_cambio').value = aData[0][11];
                document.getElementById('moneda').value = aData[0][12];
                document.getElementById('emisor').value = aData[0][21];
                document.getElementById('nombre_emisor').value = aData[0][39];
                document.getElementById('fecha_timbrado').value = aData[0][23];
                document.getElementById('no_cert_sat').value = aData[0][24];
                document.getElementById('fecha_ingreso').value = aData[0][25];
                document.getElementById('fecha_programada').value = aData[0][26];
                document.getElementById('poliza_contabili').value = aData[0][27];
                document.getElementById('fecha_contabili').value = aData[0][28];
                document.getElementById('poliza_pago').value = aData[0][29];
                document.getElementById('fecha_pago').value = aData[0][30];
                document.getElementById('descripcion').value = aData[0][31];
                document.getElementById('estado_sat').value = aData[0][33];
                document.getElementById('codigo_sat').value = aData[0][34];
                document.getElementById('tipo_factura').value = aData[0][35];
                document.getElementById('error').value = aData[0][36];
                document.getElementById('status').value = aData[0][37];
                document.getElementById('descuento').value = aData[0][40];
                document.getElementById('departamento').value = aData[0][41];
                document.getElementById('referencia').value = aData[0][42];
                document.getElementById('fecha_validacion').value = aData[0][43];

                 $('#myModalCuentasPagarDetalle').modal('show');
            }
}
function verTabla(rfcReceptor,formapago)
{

     if(formapago == 'C')
      {
         var forma = '02';
      }
      else if(formapago == 'D')
      {
         var forma = '0';
      }
      else if(formapago == 'T')
      {
         var forma = '03';
      }
      else if(formapago == 'O')
      {
         var forma = '04';
      }


    var rfc = rfcReceptor;
    if(formapago == 'O')
    {
      var rfcemisor = 'TODOS';
    }
    else
    {
       if(document.getElementById('tipoproveedor').value == 4)
       {
         var rfcemisor = 'TODOS';
       }
       else
       {
         var rfcemisor = document.getElementById('rfcprov').innerHTML;
       }

    }
    var historico = '';

jQuery.ajax({
       url: baseurl+"catalogos/Beneficiarios/getpendientesPagar",
       type:"POST",
       data:{rfc:rfc,rfcemisor:rfcemisor,historico:historico,formapago:forma},
       dataType:"html",
       success:function(data)
       {
          if(data == 'No se encontraron registros')
          {
            $('#espacioEstafetaporpagar').innerHTML = 'No se encontraron registros';
          }
          else
          {
           $('#espacioEstafetaporpagar').html(data);
           $('#tblCuentasPagar').DataTable({
              language: { "url" : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
              "sDom": 'T<"clear">lfrtip', "oTableTools": {  "sRowSelect": "single","aButtons": ""},
              "columnDefs" : [
                 {
                    "targets" : [-1],
                    "orderable" : false
                 }
              ]
           });
          }

       },
       error:function()
       {
        var n = noty({text: 'Error al recuperar la informacion', type: 'error', theme: 'relax'});
       }
    });
}
// function cerratable()
// {
//     $('#espacioEstafetaporpagar').empty();
//     $('#tblCuentasPagar').DataTable().clear().draw();
// }
</script>