
<div class="modal fade" id="myModalAutorizacion" role="dialog" >
<div class="modal-dialog modal-lg" id="mdialTamanio">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" id="cerrarclick2" name="cerrarclick2" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Autorización</h1>
        </div>
        <div class="modal-body">
        <b>R.F.C:</b> <span id="rfcprov" name="rfcprov"><?php echo $rfc?></span>
        <br>
        <br>


        <button class="btn btn-success" onclick="agregarpoliza('<?php echo $rfc?>')"><span class="fa fa-check"></span> Aceptar</button>
     
        <br>
        <br>

        <div id="div1">
<table id="tblAutorizacion" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                    <tr>
                        <th>Autorizar</th>
                        <th>RFC - Proveedor</th>
                        <th>Folio</th>                        
                        <th>Fecha</th>
                        <th>Fecha Pago</th>
                        <th>Importe</th>                        
                        <th>Metodo pago</th>
                        <th>UUID</th>
                        <th>Antiguedad</th>
                        <th>XML</th>
                        <th>PDF</th>
                    </tr>
             </thead>
            <tbody>
            </tbody>
</table>
</div>
        <br>

        <div id="espacioEstafetaporpagar"></div>

        <div class="row">
               <div class="col-sm-6">
               </div>
               <div class="col-sm-2">
                     <div class="input-group">
                        <span class="input-group-addon">Total autorización</span>
                        <input type="text" id="total_pagar2" readonly name="total_pagar2" class="form-control">
                     </div>
               </div>
               <div class="col-sm-2">
                     <div class="input-group">
                        <span class="input-group-addon">Total Deuda</span>
                        <input type="text" id="total_deuda2" readonly name="total_deuda2"  class="form-control">
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


<style>
#mdialTamanio{
      width: 80% !important;
}
#div1{
  max-height: 400px;
  overflow: scroll;
}
</style>

<script>
   function agregarpoliza(rfc)
   {

      var chek = checar();

      if(chek == '')
      {
         var n = noty({ layout:'topRight',type: 'warning', theme:'relax', text: 'No ha seleccionado las facturas para agregar a la póliza.'});
      }
      else
      {
         jQuery.ajax({
            url: baseurl+"catalogos/Beneficiarios/getupdateAutorizacion",
            type:"POST",
            data:{rfc:rfc,chek:chek},
            dataType:"html",
            success:function(data)
            {
               $('#myModalAutorizacion').modal('hide');  
            }
         });
      }
   }

   function checar()
   {
         var detallereci = [];
          $("input[type=checkbox]:checked").each(function(){
                var recibo = [];
                var uuid = $(this).parent().parent().find('td').eq(7).html();
                var eliminar = "Eliminar";
                recibo = [uuid,eliminar];
                detallereci.push(recibo);
            });
            return detallereci;
   }
</script>