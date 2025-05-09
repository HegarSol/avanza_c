<?php
if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
  $desabilitado="";
  if (isset($errores) && $errores!=""){
    for($i= 0; $i<count($errores); $i++)
    { echo "<script> var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: '".$errores[$i]."'});</script>"; }
  }
 
  $this->load->view('beneficiarios/modales/TablaCuentas');
  $this->load->view('beneficiarios/modales/TablaConfigCuentas');
  $this->load->view('beneficiarios/modales/ModalXML');

?>

<!-- <div class="col-md-2"></div> No. Interno: <b> <?php echo $datosbenefi[0]['no_prov']; ?> </b>
<br>
<div class="col-md-2"></div> Pertenece: <b> <?php echo $datosbenefi[0]['nombre']; ?> </b> -->

<br>
<br>
<br>
<br>

<div class="row">
    <center>
    <a href="<?php echo base_url().'catalogos/Beneficiarios/index'?>" class="btn btn-default btn-lg" role="button"><span class="fa fa-arrow-left"></span> Atras</a>
    <button type="button" onclick="btnPantalla()" class="btn btn-warning btn-lg"><span class="fa fa-hdd-o"></span> Recargar Estafeta</button>
    <button type="button" onclick="btnVerDocument(0)"class="btn btn-primary btn-lg"><span class="fa fa-eye"></span> Ver Docs</button>
    <button type="button" onclick="aceptarDoc()" class="btn btn-success btn-lg"><span class="fa fa-check"></span> Aceptar</button>
    <button type="button" onclick="rechazarDoc()" class="btn btn-danger btn-lg"><span class="fa fa-minus"></span> Rechazar</button>
    <button type="button" onclick="cargacompro()"class="btn btn-info btn-lg"><span class="fa fa-upload"></span> Carga XML/PDF</button>
    <button type="button" onclick="btnVerDocument(1)" class="btn btn-info btn-lg"><span class="fa fa-plus"></span> Carga PDF sin XML</button>
    <button type="button" onclick="cargarxml()" class="btn btn-info btn-lg"><span class="fa fa-plus"></span> Carga XML sin PDF</button>
    </center>
</div>

<br>
<br>

<div class="modal fade" id="ventanaspincompro" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog">
       <div class="modal-content">
           <div class="modal-header" style="background-color:#222222; color:white;">
               <h4 class="modal-tilte">OBTENIENDO COMPROBANTES</h4>
           </div>
           <div class="modal-body">
           <center><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></center>
           <br>
           <br>
           <center><h2>POR FAVOR ESPERE.....</h2></center>
           </div>
       </div>
  </div>
</div>

<div id="espacioEstafeta"></div>

<div class="modal fade" id="modalCargaXML" tabindex="-1" role="dialog" aria-labelledby="modalGrande">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
         </button>
         <h3 class="modal-title">Almacena XML</h3>
       </div>
       <div class="modal-body">
         <form enctype="multipart/form-data" action="#" id="formularioXML">
            <div class="form-group">
            <label for="xml">Archivo XML</label>
				  <input id="xmlmulti" class="form-control" type="file" name="xml" multiple accept="application/xml">
				  <p class="help-block">Seleccione el archivo XML a almacenar</p>
            </div>
            <input type="checkbox" id="aceptarxml" name="aceptarxml"> <label for="check">Aceptar los XML</label>
         </form>
      </div>
      <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="button" class="btn btn-primary" onclick="almacenaxml()">Almacenar</button>
		 </div>
     </div> 
   </div>
</div>

<div class="modal fade" id="modalCargaComprobante" tabindex="-1" role="dialog" aria-labelledby="modalGrande">
   <div class="modal-dialog" role="document">
	  <div class="modal-content">
		 <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
			   <span aria-hidden="true">&times;</span>
			</button>
			<h3 class="modal-title">Almacena Comprobante</h3>
		 </div>
		 <div class="modal-body">
			<form enctype="multipart/form-data" action="#" id="formularioComprobante">
			   <div class="form-group">
				  <label for="xml">Archivo XML</label>
				  <input id="xml" class="form-control" type="file" name="xml">
				  <p class="help-block">Seleccione el archivo XML a almacenar</p>
			   </div>
			   <div class="form-group">
				  <label for="pdf">Archivo PDF</label>
				  <input id="pdf" class="form-control" type="file" name="pdf">
				  <p class="help-block">Seleccione el archivo PDF a almacenar</p>
			   </div>
			</form>
		 </div>
		 <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="button" class="btn btn-primary" onclick="almacenaComprobante()">Almacenar</button>
		 </div>
	  </div>
   </div>
</div>

<style>
#mdialTamanio{
      width: 80% !important;
}
</style>

<div class="modal fade" id="modalVerComprobante" tabindex="-1" role="dialog" aria-labelledby="modalGrande">
   <div class="modal-dialog modal-lg" role="document" id="mdialTamanio">
	  <div class="modal-content">
		 <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
			   <span aria-hidden="true">&times;</span>
			</button>
			<center><h3 class="modal-title">Comprobante</h3></center>
		 </div>
		 <div class="modal-body">
              <div class="row">
                  <div class="col-sm-3">
                     <div class="input-group">
                        <span class="input-group-addon">Tipo Comprobante</span>
                        <input type="text" id="tipo_comprobante" readonly name="tipo_comprobante" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-2">
                     <div class="input-group">
                        <span class="input-group-addon">Version</span>
                        <input type="text" id="version" readonly name="version" class="form-control">
                     </div>
                  </div>
                  <div class="col-sm-5">
                     <div class="input-group">
                        <span class="input-group-addon">UUID</span>
                        <input type="text" id="uuid" readonly name="uuid" class="form-control">
                     </div>
                  </div>
              </div>
              <br>
              <div class="row">
                  <div class="col-sm-3">
                        <div class="input-group">
                           <span class="input-group-addon">Folio</span>
                           <input type="text" id="folio" readonly name="folio" class="form-control">
                        </div>
                     </div>
                     <div class="col-sm-2">
                        <div class="input-group">
                           <span class="input-group-addon">Serie</span>
                           <input type="text" id="serie" readonly name="serie" class="form-control" onkeyup=mayusculas()>
                        </div>
                     </div>
                     <div class="col-sm-4">
                        <div class="input-group">
                           <span class="input-group-addon">Fecha</span>
                           <input type="date" id="fecha" readonly name="fecha" class="form-control">
                        </div>
                     </div>
              </div>
              <br>
              <div class="row">
                     <div class="col-sm-4">
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
                     <div class="col-sm-3">
                        <div class="input-group">
                           <span class="input-group-addon">#Cta</span>
                           <input type="text" id="cta" readonly name="cta" class="form-control">
                        </div>
                     </div>
                     <div class="col-sm-2">
                        <div class="input-group">
                           <span class="input-group-addon">Estado</span>
                           <input type="text" id="estado" readonly name="estado" class="form-control">
                        </div>
                     </div>
              </div>
              <br>
              <div class="row">
                  
                     <div class="col-sm-5">
                        <div class="input-group">
                           <span class="input-group-addon">Codigo SAT</span>
                           <input type="text" id="codigo_sat" readonly name="codigo_sat" class="form-control">
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="input-group">
                           <span class="input-group-addon">Moneda</span>
                           <input type="text" id="moneda" readonly name="moneda" class="form-control">
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="input-group">
                           <span class="input-group-addon">Tipo Cambio</span>
                           <input type="text" id="tipo_cambio" readonly style='text-align:right' name="tipo_cambio" class="form-control">
                        </div>
                     </div>
              </div>
              <br>
              <br>
              <div class="row">
                    <div class="col-sm-3">
                        <div class="input-group">
                           <span class="input-group-addon">RFC</span>
                           <input type="text" id="rfc" readonly name="rfc" class="form-control">
                        </div>
                     </div>
                     <div class="col-sm-4">
                        <div class="input-group">
                           <span class="input-group-addon">Nombre</span>
                           <input type="text" id="nombre" readonly name="nombre" class="form-control">
                        </div>
                     </div>
              </div>
              <br>
              <br>
              <div class="row">
                   <div class="col-sm-3">
                        <div class="input-group">
                           <span class="input-group-addon">Receptor</span>
                           <input type="text" id="receptor" readonly name="receptor" class="form-control">
                        </div>
                     </div>
                     <div class="col-sm-3">
                     <form enctype="multipart/form-data" action="#" id="formularioComprobantepdf">
                          <label for="pdf">Archivo PDF</label>
                           <input id="pdf" class="form-control" type="file" name="pdf">
                           <p class="help-block">Seleccione el archivo PDF a almacenar</p>
                     </form>
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
                           <input type="text" id="tasa_iva" onblur = "calcula()" readonly style='text-align:right' name="tasa_iva" class="form-control">
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
		 <div class="modal-footer">
            <div class="row">
               <div class="col-md-10"></div>
               <div class="col-md-1">
               <button type="button" class="btn btn-success" onclick="agregarregistro()" id="agregar" name="agregar" style="display:none">Agregar</button>
               </div>
               <div class="col-md-1">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
               </div>
            </div>
		 </div>
	  </div>
   </div>
</div>

<div class="modal fade" id="myModalPrevisual" role="dialog">
<div class="modal-dialog modal-lg" id="mdialTamanio">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Póliza de provisión</h1>
        </div>
        
            <div class="modal-body" >

               <div class="row">
                  <div class="col-md-1">
                       <label for="">Póliza</label>
                       <input type="text" class="form-control" value="P" readonly id="tipo_provision" name="tipo_provision">
                  </div>
                  <div class="col-md-1">
                       <label for="">Consecutivo</label>
                       <input type="text" class="form-control" value="" readonly id="movi_provision" name="movi_provision">
                  </div>
                  <div class="col-md-3">
                       <label for="">UUID:</label>
                       <input type="text" class="form-control" readonly id="uuid_provision" name="uuid_provision">
                  </div>
                  <div class="col-md-2">
                       <label for="">Fecha:</label>
                       <input type="date" class="form-control" id="fecha_provision" name="fecha_provision">
                  </div>
                  <div class="col-md-1">
                       <label for="">Proveedor</label>
                       <input type="text" class="form-control" readonly id="provee_provisi" name="provee_provisi">
                  </div>
                  <div class="col-md-2">
                       <label for="">Póliza de pago</label>
                       <input type="text" class="form-control" readonly id="pago_provision" name="pago_provision">
                  </div>
                  <div class="col-md-1">
                        <label for="">Factura</label>
                        <input type="text" class="form-control" readonly id="num_factur_provisi" name="num_factur_provisi">
                  </div>
                  <div class="col-md-1">
                        <label for=""></label>
                        <input type="text" class="form-control" readonly id="serie_provisi" name="serie_provisi">
                  </div>
               </div>

<br>
<br>

               <div id="div1">
               <table cellspacing="0" width="100%" class="table table-bordered table-hover" id="tableprevisual">
               
                  <thead style="background-color:#222222; color:white;">
                     <th>Cuenta</th>
                     <th>Sub cuenta</th>
                     <th>Ssub cuenta</th>
                     <th>Nombre cuenta</th>
                     <th>Concepto</th>
                     <th>Monto</th>
                     <th>+/-</th>
                  </thead>
                 
                  <tbody>
                     
                  </tbody>
                  
               </table>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-8"></div>
                <div class="col-sm-1">
                   <label for="">+</label>
                   <input type="text" readonly class="form-control" id="positivo" name="positivo" value="0">
                </div>
                <div class="col-sm-1">
                   <label for="">-</label>
                   <input type="text" readonly class="form-control"  id="negativo" name="negativo" value="0">
                </div>
                <div class="col-sm-1">
                   <label for="">=</label>
                   <input type="text" readonly class="form-control"  id="totalpoliza" name="totalpoliza" value="0">
                </div>
            </div>
            <br>
            <br>
        <div class="modal-footer">
           <button type="button" class="btn btn-success" onclick="aceptarasiento('tableprevisual')" >Guardar</button>
        </div>
    </div>
</div>
</div>




<div class="modal fade" id="myModalPUEpagada" role="dialog" >
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Factura ya pagada</h1>
        </div>
            <div class="modal-body" >
                <div class="row">
                       <div class="col-sm-4">
                          <input type="radio" name="facturapagada" id="radiogastos" value="radiogastos"> Adjuntar a la póliza que ya elaboré.
                      </div>
               </div>
                      <br>
                <div class="row">
                      <div class="col-sm-4">
                          <input type="radio" name="facturapagada" id="radiocompras" value="radiocompras"> Elaborar la póliza para esta factura.
                       </div>
              </div>
                       <br>
               <div class="row">
                      <div class="col-sm-4">
                          <input type="radio" name="facturapagada" id="radiogascom" value="radiogascom"> La acepto, haré lo propio después.
                       </div>
             </div>
                       <br>
             <div class="row">
                       <div class="col-sm-7">
                          <input type="radio" name="facturapagada" id="radiobene" value="radiobene"> Quiero crear la poliza de provisión (va contra el NIF-C9).
                       </div>
                       <!-- <div class="col-sm-2">
                            <input type="radio" name="facturapagada" id="radiocorre" value="radiocorre"> Aún no lo sé, después regreso.
                       </div> -->
               </div>
          </div>
        <div class="modal-footer">
           <button type="button" class="btn btn-success" onclick="seleccionfacturapaga()">Aceptar</button>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="myModalpolizasPago" role="dialog" >
<div class="modal-dialog modal-lg"  id="mdialTamanio">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" id="cerrarclick" name="cerrarclick" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Pólizas de pago a proveedor</h1>
              <input type="hidden" id="uuid_poliza" name="uuid_poliza">
        </div>
            <div class="modal-body" >
                  <div class="row">
                        <div class="col-md-2">
                         Prov: 
                        <b><input type="text" id="num_prodve" name="num_prodve" class="form-control" readonly></b>
                        </div>
                  </div>
                  <div class="row">
                        <div class="col-md-4">
                        Nombre: 
                        <b><input type="text" id="nom_prodve" name="nom_prodve" class="form-control" readonly></b>
                        </div>
                  </div>
                  <div class="row">
                        <div class="col-md-3">
                        RFC: 
                        <b><input type="text" id="rfc_prodve" name="rfc_prodve" class="form-control" readonly></b>
                        </div>
                  </div>
                  <div class="row">
                        <div class="col-md-5">
                        Direccion: 
                        <b><input type="text" id="dire_prodve" name="dire_prodve" class="form-control" readonly></b>
                        </div>
                  </div>
                  <br>
                  <div class="row">
                     <div class="col-md-1"></div>

                  </div>
                  <br>
                  <br>

                  <div id="tabla_pagos_polizas"></div>

            </div>
        <div class="modal-footer">
                  <button type="button" class="btn btn-success" onclick="actualizarpolizapago()"><span class="fa fa-check"></span> Aceptar</button>
                  <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" aria-hidden="true" ><span class="fa fa-times"></span> Cerrar</button>
        </div>
    </div>
</div>
</div>


<style>
#mdialTamanio{
      width: 80% !important;
}
#div1{
  max-height: 600px;
  overflow: scroll;
}
</style>

<script>
   $(document).ready(function(){
      btnPantalla();
   });
</script>

<script>

function aceptarasiento(tableID)
  {

     var tipo_pro = document.getElementById('tipo_provision').value;
     var mov_pro = document.getElementById('movi_provision').value;
     var uuid_pro = document.getElementById('uuid_provision').value;
     var fecha_pro = document.getElementById('fecha_provision').value;
     var prove_provi = document.getElementById('provee_provisi').value;
     var pago_provi = document.getElementById('pago_provision').value;
     var num_fact_pro = document.getElementById('num_factur_provisi').value;
     var serie_provisi = document.getElementById('serie_provisi').value;
     var tol = document.getElementById('totalpoliza').value;
     
     var mes = '<?php echo $_SESSION["mes"];?>';
     var ano = '<?php echo $_SESSION["ano"];?>';

      var cuenta = [];
      var sub_cta = [];
      var ssub_cta = [];
      var nom = [];
      var conce = [];
      var mon = [];
      var c_a = [];
      var table = x(tableID);
      var rowCount = table.rows.length;

      for(var i = 0; i < rowCount; i++)
      {
         cuenta[i] = table.rows[i].cells[0].innerHTML;
         sub_cta[i] = table.rows[i].cells[1].innerHTML;
         ssub_cta[i] = table.rows[i].cells[2].innerHTML;
         nom[i] = table.rows[i].cells[3].innerHTML;
         conce[i] = table.rows[i].cells[4].innerHTML;
         mon[i] = table.rows[i].cells[5].innerHTML;
         c_a[i] = table.rows[i].cells[6].innerHTML;
      }

      var fechadivi = fecha_pro.split('-');
      var fechaano = fechadivi[0];
      var fechames = fechadivi[1];

      if(mes == fechames && ano == fechaano)
      {
         if(tol == 0)
         {
              jQuery.ajax({
                    type:"POST",
                    url: baseurl + "catalogos/Beneficiarios/insert_poliza_provision",
                    data: {tipo:tipo_pro,mov:mov_pro,uuid:uuid_pro,fecha:fecha_pro,provee:prove_provi,pago:pago_provi,ssub_cta:ssub_cta,
                    num_fact:num_fact_pro,serie_provisi:serie_provisi,total:tol,cuenta:cuenta,sub_cta:sub_cta,nom:nom,conce:conce,
                    mon:mon,c_a:c_a},
                    dataType:"html",
                    success:function(msg)
                    {
                       msg=JSON.parse(msg);

                        if(msg[0].mensaje=="Insertado Correctamente")
                        {
                           swal('Tipo: '+tipo_pro+' Consecutivo: '+mov_pro,msg[0].mensaje , "success");

                           var oTT = $.fn.dataTable.TableTools.fnGetInstance("tabla_pendientes");
                           var aData2 = oTT.fnGetSelectedData();

                           jQuery.ajax({
                                 url: baseurl+"catalogos/Beneficiarios/getaceptar",
                                 type:"POST",
                                 data:{uuid:aData2[0][1]},
                                 dataType:"html",
                                 success:function(response)
                                 {
                                 response=JSON.parse(response);
                                    if(response.status == true)
                                    {
                                       swal("Correcto","Aceptado","success");
                                     //  $('#myModalPUEpagada').modal('hide');
                                     //  btnPantalla();
                                    }
                                    else
                                    {
                                       var n = noty({ layout:'topRight',type: 'warning', theme:'relax', text: response.error});
                                    }
                                 }
                           });


                           location.reload();
                        }
                        else
                        {
                           swal("Error",msg[0].mensaje,"error");
                        }
                    } 
              });             
         }
         else
         {
            swal("Advertencia","No cuadra el asiento","warning");
         }
      }
      else
      {
         var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'No esta dentro del mismo ejercicio de trabajo'});
      }

  }
  function actualizarpolizapago()
    {
        var oTTs = $.fn.dataTable.TableTools.fnGetInstance("tabla_polizas_pagos_prove");
        var aData = oTTs.fnGetSelectedData();

        if (aData.length != 1) 
        { 
             var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Seleccione un registro.'});
        }
        else
        {
            var fecha_poliza = aData[0][3]; 
            var poliza = aData[0][0] + ' ' +aData[0][1] + '       ' + aData[0][2];
            var uuid = document.getElementById('uuid_poliza').value;

            jQuery.ajax({
                type:"POST",
                url: baseurl + "catalogos/Beneficiarios/update_poliza",
                data:{fecha_poliza:fecha_poliza,poliza:poliza,uuid:uuid},
                dataType:"html",
                success:function(response)
                {
                   response=JSON.parse(response);
                   if(response.status == true)
                   {
                       swal("Correcto","Póliza agregada a la factura","success");
                       $("#cerrarclick").trigger("click");

                       var oTT = $.fn.dataTable.TableTools.fnGetInstance("tabla_pendientes");
                       var aData2 = oTT.fnGetSelectedData();

                       jQuery.ajax({
                           url: baseurl+"catalogos/Beneficiarios/getaceptar",
                           type:"POST",
                           data:{uuid:aData2[0][1]},
                           dataType:"html",
                           success:function(response)
                           {
                           response=JSON.parse(response);
                              if(response.status == true)
                              {
                                 swal("Correcto","Aceptado","success");
                                // $('#myModalPUEpagada').modal('hide');
                                // btnPantalla();
                              }
                              else
                              {
                                 var n = noty({ layout:'topRight',type: 'warning', theme:'relax', text: response.error});
                              }
                           }
                     });
                   }
                   else
                   {
                       swal("Error",response.error,"error");
                   }
                }
             });
        }
    }
    function recorrercuentas()
    {
      var cajadeta = [];

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
                           previsualizaasiento();
                           $('#myModalxml').modal('hide');
                           $('#myModalPrevisual').modal('show');
                        }
                  });
               }
       } 
       else 
       {
           previsualizaasiento();
           $('#myModalxml').modal('hide');
           $('#myModalPrevisual').modal('show');
       }
    }
    function previsualizaasiento()
    {
            var oTT2 = $.fn.dataTable.TableTools.fnGetInstance("tabla_pendientes");
            var aData2 = oTT2.fnGetSelectedData();


           $valorw = jQuery.ajax({
               url : baseurl + "catalogos/Beneficiarios/getbeneficirfc",
               type:"POST",
               data:{rfc:aData2[0][6]},
               dataType:"html",
               success:function(response2)
               {
                  response2=JSON.parse(response2);
                   
               
                        var nom_prov = response2[0].no_prov;
                        var departa = document.getElementById('departamentos').value;

                        jQuery.ajax({
                           type:"POST",
                           url: baseurl + "catalogos/Operaciones/buildAcientoContable",
                           data:{uuid:aData2[0][1],nom_prov:nom_prov,departa:departa},
                           dataType:"html",
                           success:function(response)
                           {
                              $("#tableprevisual tbody").empty();
                              
                              document.getElementById('negativo').value = '0';
                              document.getElementById('positivo').value = '0';
                              document.getElementById('totalpoliza').value = '0';

                              response=JSON.parse(response);
                                 for(var i in response.data)
                                 {

                                    var btn2 = document.createElement("INPUT");
                                    btn2.setAttribute("type","button");
                                    btn2.setAttribute('onclick','abrirmodalconficun(this)');
                                    btn2.id = 'btnbuscarconfig';
                                    btn2.className = 'btn btn-primary';
                                    btn2.value = 'Configuración cuentas';

                                    var clave = response.data[i].clave;
                                    var importe = response.data[i].importe;
                                    var c_a = response.data[i].c_a;
                                    var cta = response.data[i].cuenta;
                                    var sub_cta = response.data[i].sub_cta;
                                    var nom_cta = response.data[i].nombre_cta;
                                    var ssub_cta = response.data[i].ssub_cta;

                                    if(c_a == '-')
                                    {
                                       var nega = parseFloat(document.getElementById('negativo').value);
                                       var montotal =+ importe + nega;
                                       document.getElementById('negativo').value = montotal.toFixed(2);
                                    }
                                    else
                                    {
                                       var posi = parseFloat(document.getElementById('positivo').value);
                                       var montotal =+ importe + posi;
                                       document.getElementById('positivo').value = montotal.toFixed(2);
                                    }

                                    var tbody = document.getElementById('tableprevisual').getElementsByTagName('TBODY')[0];
                                    var row = document.createElement("TR")
                                    var td3 = document.createElement("TD")
                                    td3.appendChild(document.createTextNode(cta))
                                    var td4 = document.createElement("TD")
                                    td4.appendChild(document.createTextNode(sub_cta))
                                    var td10 = document.createElement("TD")
                                    td10.appendChild(document.createTextNode(ssub_cta))
                                    var td6 = document.createElement("TD")
                                    td6.appendChild(document.createTextNode(nom_cta))
                                    var td7 = document.createElement("TD")
                                    td7.appendChild(document.createTextNode(''))
                                    var td8 = document.createElement("TD")
                                    td8.setAttribute('style','text-align:right')
                                    td8.appendChild(document.createTextNode(parseFloat(importe).toFixed(2)))
                                    var td9 = document.createElement("TD")
                                    td9.appendChild(document.createTextNode(c_a))

                                 row.appendChild(td3);
                                 row.appendChild(td4);
                                 row.appendChild(td10);
                                 row.appendChild(td6);
                                 row.appendChild(td7);
                                 row.appendChild(td8);
                                 row.appendChild(td9);


                                 tbody.appendChild(row);

                                 }

                                 var totales = parseFloat(document.getElementById('positivo').value) - parseFloat(document.getElementById('negativo').value);
                                 document.getElementById('totalpoliza').value = totales.toFixed(2);
                           }
                        });
               }
            });
   }
  function seleccionfacturapaga()
  {
          var tipoprove = $("input:radio[name=facturapagada]:checked").val();

         switch (tipoprove)
         {
               case 'radiogastos':
                   var tipo = 1;          
                   break;
               case 'radiocompras':
                   var tipo = 2;
                   break;
               case 'radiogascom': 
                   var tipo = 3;
                   break;
               case 'radiobene': 
                   var tipo = 4;
                   break;
               case 'radiocorre': 
                   var tipo = 5;
                   break;  
         }

         if(tipo == 1)
         {
              $('#myModalPUEpagada').modal('hide');
              var oTT = $.fn.dataTable.TableTools.fnGetInstance("tabla_pendientes");
               var aData = oTT.fnGetSelectedData();
              
               jQuery.ajax({
               url : baseurl + "catalogos/Beneficiarios/getbeneficirfc",
               type:"POST",
               data:{rfc:aData[0][6]},
               dataType:"html",
               success:function(response2)
               {
                  response2=JSON.parse(response2);

                   if(response2=='')
                   {
                     //var n = noty({ layout:'topRight',type: 'warning', theme:'relax', text: 'No tiene agregado a este proveedor, para aceptar esta factura agregelo primero.'});
                        swal({
                           title: "¿Desea agregarlo?",
                           text: "No tiene agregado a este proveedor, para adjuntar a la poliza.",
                           type: "warning",
                           showCancelButton: true,
                           confirmButtonColor: "#DD6B55",
                           confirmButtonText: "Aceptar",
                           cancelButtonText: "No, Cancelar",
                           closeOnConfirm: false,
                           closeOnCancel: false
                           },
                           function(isConfirm){
                           if (isConfirm)
                           { location.href=baseurl+"catalogos/Beneficiarios/agregar";  }
                           else {
                              swal("Cancelado", "No se creara al proveedor.", "error");
                           }
                        });
                   }
                   else
                   {
                        jQuery.ajax({
                              type:"POST",
                              url: baseurl+"catalogos/Beneficiarios/getPolizasPagoProveedor",
                              data:{datas:1,nom_prov:aData[0][6]},
                              dataType:"html",
                              success:function(data)
                              {

                                    $('#tabla_pagos_polizas').html(data);
                                    $('#tabla_polizas_pagos_prove').DataTable({
                                       language: { "url" : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
                                       "sDom": 'T<"clear">lfrtip', "oTableTools": {  "sRowSelect": "single","aButtons": ""},
                                       "columnDefs" : [
                                          {
                                             "targets" : [-1],
                                             "orderable" : false
                                          }
                                       ]
                                    });

                                    document.getElementById('num_prodve').value = response2[0]['no_prov'];
                                    document.getElementById('nom_prodve').value = response2[0]['nombre'];
                                    document.getElementById('rfc_prodve').value = response2[0]['rfc'];
                                    document.getElementById('dire_prodve').value = response2[0]['direccion'];
                              }
                        });
                    }
               }
            })

              $('#myModalpolizasPago').modal('show');
         }
         else if(tipo == 2)
         {

         }
         else if(tipo == 3)
         {
            var oTT = $.fn.dataTable.TableTools.fnGetInstance("tabla_pendientes");
            var aData = oTT.fnGetSelectedData();

            jQuery.ajax({
               url : baseurl + "catalogos/Beneficiarios/getbeneficirfc",
               type:"POST",
               data:{rfc:aData[0][6]},
               dataType:"html",
               success:function(response)
               {
                   response=JSON.parse(response);

                   if(response=='')
                   {
                     //var n = noty({ layout:'topRight',type: 'warning', theme:'relax', text: 'No tiene agregado a este proveedor, para aceptar esta factura agregelo primero.'});
                        swal({
                           title: "¿Desea agregarlo?",
                           text: "No tiene agregado a este proveedor, para aceptar esta factura agregelo primero.",
                           type: "warning",
                           showCancelButton: true,
                           confirmButtonColor: "#DD6B55",
                           confirmButtonText: "Aceptar",
                           cancelButtonText: "No, Cancelar",
                           closeOnConfirm: false,
                           closeOnCancel: false
                           },
                           function(isConfirm){
                           if (isConfirm)
                           { location.href=baseurl+"catalogos/Beneficiarios/agregar";  }
                           else {
                              swal("Cancelado", "No se creara al proveedor.", "error");
                           }
                        });
                   }
                   else
                   {
                     jQuery.ajax({
                           url: baseurl+"catalogos/Beneficiarios/getaceptar",
                           type:"POST",
                           data:{uuid:aData[0][1]},
                           dataType:"html",
                           success:function(response)
                           {
                           response=JSON.parse(response);
                              if(response.status == true)
                              {
                                 var n = noty({ layout:'topRight',type: 'success',  theme: 'relax',text: 'ACEPTADA.'});
                                 $('#myModalPUEpagada').modal('hide');
                                 btnPantalla();
                              }
                              else
                              {
                                 var n = noty({ layout:'topRight',type: 'warning', theme:'relax', text: response.error});
                              }
                           }
                     });
                   }
               }
            });


         }
         else if(tipo == 4)
         {
               $('#myModalPUEpagada').modal('hide');

               const filteredCategories = [];

               var oTT2 = $.fn.dataTable.TableTools.fnGetInstance("tabla_pendientes");
               var aData2 = oTT2.fnGetSelectedData();

               jQuery.ajax({
                  url : baseurl + "catalogos/Beneficiarios/getbeneficirfc",
                  type:"POST",
                  data:{rfc:aData2[0][6]},
                  dataType:"html",
                  success:function(response2)
                  {
                     response2=JSON.parse(response2);

                     if(response2=='')
                     {
                        //var n = noty({ layout:'topRight',type: 'warning', theme:'relax', text: 'No tiene agregado a este proveedor, para aceptar esta factura agregelo primero.'});
                           swal({
                              title: "¿Desea agregarlo?",
                              text: "No tiene agregado a este proveedor, para adjuntar a la poliza.",
                              type: "warning",
                              showCancelButton: true,
                              confirmButtonColor: "#DD6B55",
                              confirmButtonText: "Aceptar",
                              cancelButtonText: "No, Cancelar",
                              closeOnConfirm: false,
                              closeOnCancel: false
                              },
                              function(isConfirm){
                              if (isConfirm)
                              { location.href=baseurl+"catalogos/Beneficiarios/agregar";  }
                              else {
                                 swal("Cancelado", "No se creara al proveedor.", "error");
                              }
                           });
                     }
                     else
                     {
                         let date = new Date(aData2[0][3]);

            
                           // console.log(date);

                              let day = date.getDate();
                              let month = date.getMonth() + 1;
                              let year = date.getFullYear();

                              if(day.toString().length == 1)
                              {
                                 day = '0'+day;
                              }
                              if(month.toString().length == 1)
                                 {
                                    month = '0'+month;
                                 }
                              
                                 jQuery.ajax({
                                 url : baseurl + "catalogos/Beneficiarios/getbeneficirfc",
                                 type:"POST",
                                 data:{rfc:aData2[0][6]},
                                 dataType:"html",
                                 success:function(response)
                                 {
                                    response=JSON.parse(response);
                                 // var idpros = response[0].no_prov;
                                    
                              document.getElementById('uuid_provision').value = aData2[0][1];
                              document.getElementById('provee_provisi').value = response[0].no_prov;
                              document.getElementById('pago_provision').value = aData2[0][26];
                              document.getElementById('fecha_provision').value = year+'-'+month+'-'+day;
                              document.getElementById('num_factur_provisi').value = aData2[0][4];
                              document.getElementById('serie_provisi').value = aData2[0][5];
                                 }
                              });

                              jQuery.ajax({
                                    url: baseurl+"catalogos/Beneficiarios/getarchivos",
                                    type:"POST",
                                    data:{uuid:aData2[0][1]},
                                    dataType:"html",
                                    success:function(response)
                                    {
                                       $("#table tbody").empty();
                                       response=JSON.parse(response);
                                 
                                          if(response.data == 0)
                                          {
                                             document.getElementById("estadocol").innerHTML = 'Las claves del XML ya las tiene en su diccionario. Presione el botón de aceptar.';
                                             $("#estadocol").css("color","#3ADA13");
                                             $('#myModalxml').modal('show');
                                          }
                                          else
                                          {
                                             document.getElementById("estadocol").innerHTML = '';

                                                                  if(response.status == false)
                                                                  {
                                                                     var n = noty({ layout:'topRight',type: 'warning', theme:'relax', text: response.error});
                                                                  }
                                                                  else
                                                                  {

                                                                     for(var i in response.data)
                                                                     {

                                                                     var btn2 = document.createElement("INPUT");
                                                                           btn2.setAttribute("type","button");
                                                                           btn2.setAttribute('onclick','abrirmodalcuentas(this)');
                                                                           btn2.id = 'btnbuscar';
                                                                           btn2.className = 'btn btn-primary';
                                                                           btn2.value = 'Abrir catálogo cuentas'

                                                                           var clave = response.data[i].clave;
                                                                           var descrip = response.data[i].descripcionSAT;
                                                                           var descripxml = response.data[i].descripcionxml;

                                                                           var tbody = document.getElementById('table').getElementsByTagName('TBODY')[0];
                                                                           var row = document.createElement("TR")
                                                                           var td2 = document.createElement("TD")
                                                                           td2.appendChild(btn2)
                                                                           var td3 = document.createElement("TD")
                                                                           td3.appendChild(document.createTextNode(''))
                                                                           var td4 = document.createElement("TD")
                                                                           td4.appendChild(document.createTextNode(''))
                                                                           var td5 = document.createElement("TD")
                                                                           td5.appendChild(document.createTextNode(''))
                                                                           var td6 = document.createElement("TD")
                                                                           td6.appendChild(document.createTextNode(''))
                                                                           var td7 = document.createElement("TD")
                                                                           td7.appendChild(document.createTextNode(clave))
                                                                           var td8 = document.createElement("TD")
                                                                           td8.appendChild(document.createTextNode(descrip))
                                                                           var td9 = document.createElement("TD")
                                                                           td9.appendChild(document.createTextNode(descripxml))

                                                                           row.appendChild(td2);
                                                                           row.appendChild(td3);
                                                                           row.appendChild(td4);
                                                                           row.appendChild(td5);
                                                                           row.appendChild(td6);
                                                                           row.appendChild(td7);
                                                                           row.appendChild(td8);
                                                                           row.appendChild(td9);

                                                                           tbody.appendChild(row);

                                                                     }

                                                                     $('#myModalxml').modal('show');
                                                                  }
                                          }


                                    }
                              });
                     }
                  }
               }); 
             
              
         }
         else
         {
               $('#myModalPUEpagada').modal('hide');
         }
  }
//   function abrirmodalconficun(r)
//   {
//       $('#myModalxml').modal('hide');

//        var p = r.parentNode.parentNode.rowIndex;
//       // document.getElementById('renglon').value = p;

//        //$('#myModalCuentas').modal('show');
//       // $('#myModalPrevisual').modal('hide');

//       // var pr = r.parentNode.parentNode.rowIndex;
//        document.getElementById('renglonconfi').value = p;

//        $('#myModalConfigCuentas').modal('show');
//   }
//   function seleccionarconf(cuenta,subcta,nombre)
//   {
//       $('#myModalConfigCuentas').modal('hide');
     
//       var p = document.getElementById('renglonconfi').value;
//         document.getElementById('table').tBodies[0].rows[p-1].cells[1].innerHTML = cuenta;
//         document.getElementById('table').tBodies[0].rows[p-1].cells[2].innerHTML = subcta;
//         document.getElementById('table').tBodies[0].rows[p-1].cells[3].innerHTML = nombre;  
//    //   document.getElementById('tableprevisual').tBodies[0].rows[pr-1].cells[1].innerHTML = cuenta;
//    //   document.getElementById('tableprevisual').tBodies[0].rows[pr-1].cells[2].innerHTML = subcta;
//    //   document.getElementById('tableprevisual').tBodies[0].rows[pr-1].cells[3].innerHTML = nombre; 

//    //   $('#myModalPrevisual').modal('show');
//       $('#myModalxml').modal('show');
//   }
  function abrirmodalcuentas(r)
  {

       $('#myModalxml').modal('hide');

       var p = r.parentNode.parentNode.rowIndex;
       document.getElementById('renglon').value = p;

       $('#myModalCuentas').modal('show');
  }

  function seleccionarcuneta(cuenta,subcta,nombre,ssubcta)
  {

       $('#myModalCuentas').modal('hide');

        var p = document.getElementById('renglon').value;
        document.getElementById('table').tBodies[0].rows[p-1].cells[1].innerHTML = cuenta;
        document.getElementById('table').tBodies[0].rows[p-1].cells[2].innerHTML = subcta;
        document.getElementById('table').tBodies[0].rows[p-1].cells[3].innerHTML = ssubcta;
        document.getElementById('table').tBodies[0].rows[p-1].cells[4].innerHTML = nombre;  

        $('#myModalxml').modal('show');
  }
   function almacenaxml()
   {
      var fileinput = document.getElementById('xmlmulti');
      var files = fileinput.files;
      var formData = new FormData();

      for (let i = 0; i < files.length; i++) {
         formData.append('xml', files[i]);
     // }
      // var formElement = document.getElementById("formularioXML");
      // var formData = new FormData(formElement);
      formData.append('empresa','<?php echo $rfc?>');
      formData.append('aceptar',document.getElementById('aceptarxml').checked);

     $.ajax({
        url: baseurl + "catalogos/Beneficiarios/leerxml",
        type:"POST",
        data: formData,
        processData : false,
        contentType : false,
        success: function(data){

         $.ajax({
       url : "http://avanzab.hegarss.com/api/Comprobantes/uploadxmlmulti",
		 //url : "http://localhost:85/git_hub_repo/avanza_buzon_github/api/Comprobantes/uploadxmlmulti",
		 type : "POST",
		 data : formData,
		 processData : false,
		 contentType : false,
		 success : function (data){
			var n = noty({
			   text : "Comprobante Registrado Correctamente",
			   theme : "relax",
			   type : 'success'
      }).show();

   //        $.ajax({
   //            url: baseurl + "catalogos/Beneficiarios/bitacoraalmacena",
   //            type:"POST",
   //            data : formData,
   //             processData : false,
   //             contentType : false,
   //            success : function (data)
   //            {

   //            }
   //        });
          
   //   btnPantalla();
	// 	 	$('#modalCargaXML').modal('hide');
               },
               error : function(request, status, error){
                  var n = noty({
                     text : request.responseJSON.error,
                     theme : 'relax',
                     type : 'error'
                  }).show();
                  $('#modalCargaXML').modal('hide');
               }
            })

        }
     });
      
      

   }

   }
   function almacenaComprobante(){
	  var formElement = document.getElementById("formularioComprobante");
	  var formData = new FormData(formElement);
	  formData.append('empresa','<?php echo $rfc?>');
	  $.ajax({
       url : "http://avanzab.hegarss.com/api/Comprobantes/upload",
		 //url : "http://localhost:85/getcfdi/api/Comprobantes/upload",
		 type : "POST",
		 data : formData,
		 processData : false,
		 contentType : false,
		 success : function (data){
			var n = noty({
			   text : "Comprobante Registrado Correctamente",
			   theme : "relax",
			   type : 'success'
      }).show();

          $.ajax({
              url: baseurl + "catalogos/Beneficiarios/bitacoraalmacena",
              type:"POST",
              data : formData,
               processData : false,
               contentType : false,
              success : function (data)
              {

              }
          });
          
      btnPantalla();
			$('#modalCargaComprobante').modal('hide');
		 },
		 error : function(request, status, error){
			var n = noty({
			   text : request.responseJSON.error,
			   theme : 'relax',
			   type : 'error'
			}).show();
			$('#modalCargaComprobante').modal('hide');
		 }
	  })
   }
</script>

<script>
   $(document).ready(function (){
      $('#folio').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
     });
   });
function agregarregistro()
{

   var formElement = document.getElementById("formularioComprobantepdf");
   var formData = new FormData(formElement);

               var tip_com = document.getElementById('tipo_comprobante').value;
               var vers = document.getElementById('version').value;
               var uuid = document.getElementById('uuid').value;
               var foli = document.getElementById('folio').value;
               var seri = document.getElementById('serie').value;
               var fecha = document.getElementById('fecha').value;
               var fom_pa = document.getElementById('forma_pago').value;
               var met_pa = document.getElementById('metodo_pago').value;
               var cta = document.getElementById('cta').value;
               var est = document.getElementById('estado').value;
               var cod_sat = document.getElementById('codigo_sat').value;
               var mone = document.getElementById('moneda').value;
               var tipo_cam = document.getElementById('tipo_cambio').value;
               var rfc = document.getElementById('rfc').value;
               var nom = document.getElementById('nombre').value;
               var recep = document.getElementById('receptor').value;
               var subto = document.getElementById('subtotal').value;
               var tasaiva = document.getElementById('tasa_iva').value;
               var iva = document.getElementById('iva').value;
               var retiva = document.getElementById('ret_iva').value;
               var reisar = document.getElementById('ret_isr').value;
               var tasaiep = document.getElementById('tasa_ieps').value;
               var ieps = document.getElementById('ieps').value;
               var total = document.getElementById( 'total').value;

               formData.append('empresa',recep);
               formData.append('tipo_com',tip_com);               
               formData.append('versio',vers);
               formData.append('foli',foli);
               formData.append('seri',seri);
               formData.append('fecha',fecha);               
               formData.append('fom_pa',fom_pa);
               formData.append('met_pa',met_pa);
               formData.append('cta',cta);
               formData.append('est',est);               
               formData.append('cod_sat',cod_sat);
               formData.append('mone',mone);
               formData.append('tipo_cam',tipo_cam);
               formData.append('rfc',rfc);               
               formData.append('nom',nom);
               formData.append('recep',recep);
               formData.append('subto',subto);               
               formData.append('tasaiva',tasaiva);
               formData.append('iva',iva);
               formData.append('retiva',retiva);               
               formData.append('reisar',reisar);
               formData.append('tasaiep',tasaiep);
               formData.append('ieps',ieps);               
               formData.append('total',total);

               jQuery.ajax({
                  type:"POST",
                  url:"http://avanzab.hegarss.com/api/Comprobantes/uploadpdf",
                  data:formData,
                  processData : false,
                  contentType : false,
                  success:function(response)
                  {
                    // response=JSON.parse(response);
                     if(response.status == true)
                     {
                        $('#modalVerComprobante').modal('hide');
                        var n = noty({
                              text : response.data,
                              theme : "relax",
                              type : 'success'
                        }).show();
                     }
                     else
                     {
                        var n = noty({
                           text : response.error,
                           theme : 'relax',
                           type : 'error'
                        }).show();
                     }
                  }
               })

}
function btnVerDocument(val)
{
   var condi = (val == 1); 
    if(!condi) // este es una prueba de sync de ramas.
         {
            var oTT = $.fn.dataTable.TableTools.fnGetInstance("tabla_pendientes");
            var aData = oTT.fnGetSelectedData();
            if (aData.length != 1) 
                { 
                   var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Seleccione un registro.'});
                   return;
                }
         }
   var doc = document;
   doc.getElementById('agregar').style.display = condi ? 'block' : 'none'; //'block';
   doc.getElementById('tipo_comprobante').value = condi ? 'I' : aData[0][2];
   doc.getElementById('version').value = condi ? 'N/A' : aData[0][0];
   doc.getElementById('uuid').value = condi ? '' : aData[0][1];
   doc.getElementById('folio').value = condi ? '' : aData[0][4];
   doc.getElementById('folio').readOnly = condi ? false : true;
   doc.getElementById('serie').value = condi ? '' : aData[0][5];
   doc.getElementById('serie').readOnly = condi ? false : true;
   doc.getElementById('fecha').value = condi ? '' : aData[0][3];
   doc.getElementById('fecha').readOnly = condi ? false : true;
   doc.getElementById('forma_pago').value = condi ? '' : aData[0][9];
   doc.getElementById('forma_pago').readOnly =  condi ? false : true;
   doc.getElementById('metodo_pago').value = condi ? '' : aData[0][9];
   doc.getElementById('metodo_pago').readOnly = condi ? false : true;
   doc.getElementById('cta').value = condi ? '' : aData[0][11];
   doc.getElementById('estado').value = condi ? '' : aData[0][25];
   doc.getElementById('codigo_sat').value = condi ? '' : aData[0][12];
   doc.getElementById('moneda').value = condi ? '' : aData[0][13];
   doc.getElementById('moneda').readOnly = condi ? false : true;
   doc.getElementById('tipo_cambio').value = condi ? '' : aData[0][14];
   doc.getElementById('tipo_cambio').readOnly = condi ? false : true;
   doc.getElementById('rfc').value = condi ? '' : aData[0][6];
   doc.getElementById('rfc').readOnly = condi ? false : true;
   doc.getElementById('nombre').value = condi ? '' : aData[0][7];
   doc.getElementById('nombre').readOnly = condi ? false : true;
   doc.getElementById('receptor').value = condi ? '<?php echo $rfc;?>' : aData[0][17];                         
   doc.getElementById('subtotal').value = condi ? '' : aData[0][18];
   doc.getElementById('subtotal').readOnly = condi ? false : true;
   doc.getElementById('tasa_iva').value = condi ? '' : aData[0][19];
   doc.getElementById('tasa_iva').readOnly = condi ? false : true;
   doc.getElementById('iva').value = condi ? '': aData[0][20];
   doc.getElementById('iva').readOnly = condi ? false : true;   
   doc.getElementById('ret_iva').value = condi ? '' : aData[0][21];
   doc.getElementById('ret_iva').readOnly =  condi ? false : true;
   doc.getElementById('ret_isr').value = condi ? '' : aData[0][22];
   doc.getElementById('ret_isr').readOnly = condi ? false : true;
   doc.getElementById('tasa_ieps').value = condi ? '' : aData[0][23];
   doc.getElementById('tasa_ieps').readOnly = condi ? false : true;
   doc.getElementById('ieps').value = condi ? '' : aData[0][24];
   doc.getElementById('ieps').readOnly = condi ? false : true;
   doc.getElementById('total').value =  condi ? '' : aData[0][8];
   doc.getElementById('total').readOnly = condi ? false : true;
   $('#modalVerComprobante').modal('show');
   $('#modalVerComprobante').on('shown.bs.modal', function () {
    $('#folio').focus();})
}
function cargacompro()
{
   $('#modalCargaComprobante').modal('show');
}
function cargarxml()
{
   $('#modalCargaXML').modal('show');
}
function aceptarDoc()
{
    var oTT = $.fn.dataTable.TableTools.fnGetInstance("tabla_pendientes");
            var aData = oTT.fnGetSelectedData();
            if (aData.length != 1) 
                { 
                   var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Seleccione un registro.'});
                }
            else
            {

              // console.log(aData[0][2]);
               if(aData[0][2] == 'P')
               {
                  jQuery.ajax({
                           url: baseurl+"catalogos/Beneficiarios/getaceptar",
                           type:"POST",
                           data:{uuid:aData[0][1]},
                           dataType:"html",
                           success:function(response)
                           {
                           response=JSON.parse(response);
                              if(response.status == true)
                              {
                                 var n = noty({ layout:'topRight',type: 'success',  theme: 'relax',text: 'ACEPTADA.'});
                               //  $('#myModalPUEpagada').modal('hide');
                                 btnPantalla();
                              }
                              else
                              {
                                 var n = noty({ layout:'topRight',type: 'warning', theme:'relax', text: response.error});
                              }
                           }
                     });
               }
               else
               {
                  var metodopago = aData[0][10];

                  // if(metodopago == 'PUE')
                  // {
                     document.getElementById('uuid_poliza').value = aData[0][1];
                     $('#myModalPUEpagada').modal('show');
                  // }
                  // else
                  // {
                  //     alert('la factura es PPD');
                  // }
               }


            }
}
function rechazarDoc()
{
     var oTT = $.fn.dataTable.TableTools.fnGetInstance("tabla_pendientes");
           var aData = oTT.fnGetSelectedData();
           if(aData.length != 1)
           {
               var n = noty({ layout:'topRight',type: 'warning', theme:'relax', text: 'Seleccione un registro.'});
           }
           else
           {
               jQuery.ajax({
                    url: baseurl+"catalogos/Beneficiarios/getrechazo",
                    type:"POST",
                    data:{uuid:aData[0][1]},
                    dataType:"html",
                    success:function(response)
                    {
                      response=JSON.parse(response);
                      if(response.status == true)
                      {
                         swal("Correcto","Rechazado","success");
                         btnPantalla();
                      }
                      else
                      {
                        var n = noty({ layout:'topRight',type: 'warning', theme:'relax', text: response.error});
                      }
                    }
               });
           }
}
function calcula()
{
var lnSubtotal = document.getElementById("subtotal").value;
var lnTasaiva = document.getElementById("tasa_iva").value / 100;
var lnTotIva = lnSubtotal * lnTasaiva;
document.getElementById("iva").value = lnTotIva.toFixed(2);
var lnTotal = parseFloat(lnSubtotal) + parseFloat(lnTotIva);
document.getElementById("total").value = lnTotal;
}
function mayusculas()
{
   var x = document.getElementById('serie');
  x.value = x.value.toUpperCase();
}

function btnPantalla()
{
  var rfc = '<?php echo $rfc ?>';

jQuery.ajax({
       url: baseurl+"catalogos/Beneficiarios/getpendientes",
       type:"POST",
       data:{rfc:rfc},
       dataType:"html",
       success:function(data)
       {
           $('#espacioEstafeta').html(data);
           $('#tabla_pendientes').DataTable({
              language: { "url" : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
              "sDom": 'T<"clear">lfrtip', "oTableTools": {  "sRowSelect": "single","aButtons": ""},
              "columnDefs" : [
                 {
                    "targets" : [-1],
                    "orderable" : false
                 }
              ]
           });
           
       },
       error:function()
       {
        var n = noty({text: 'Error al recuperar la informacion', type: 'error', theme: 'relax'});
       }
    });
}
</script>
