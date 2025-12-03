<?php
if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
  $desabilitado="";
  if (isset($errores) && $errores!=""){
    for($i= 0; $i<count($errores); $i++)
    { echo "<script> var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: '".$errores[$i]."'});</script>"; }
  }
 
?>

<div class= "contairner-fluid">
   <div class="panel panel-default">
      <div class="panel-heading">
         <form class="form-horizontal">
            <div class="form-group">
            </div>
         </form>
      </div>
      <div class="panel-body">
         <table id="dicccionarioconta" class="stripe row-border responsive nowrap"  cellspacing="0" width="100%">
            <thead style="background-color:#5a5a5a; color:white;">
               <tr>
                  <th>Id</th>
                  <th>ClaveProdServ</th>
                  <th>Cuenta</th>
                  <th>Subcuenta</th>
                  <th>Ssubcuenta</th>
                  <th>Acciones</th>
            </tr>
         </thead>
         </table>
      </div>
      <div class="panel-footer">
      </div>
   </div>
  <div class="col-md-2 col-lg-2 col-sm-3" align="center">
    <br>
     </div><br>
  <div class="col-md-10 col-lg-10 col-sm-9">
  </div><div class="col-sm-1"></div>
</div>

<div class="modal fade" id="modaleditarcuenta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form>
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Editar Cuenta del Diccionario Contable</h4>
               </div>
               <div class="modal-body">
                    <div class="form-group">
                       <label for="id" class="control-label">id:</label>
                       <input type="text" readonly class="form-control" id="id" name="id" required>
                     </div>               
                    <div class="form-group">
                       <label for="cuenta" class="control-label">Cuenta:</label>
                       <input type="text" class="form-control" id="cuenta" name="cuenta" required>
                     </div>
                        <div class="form-group
                          ">
                          <label for="sub_cta" class="control-label">Subcuenta:</label>
                            <input type="text" class="form-control" id="sub_cta" name="sub_cta" required>
                        </div>
                        <div class="form-group

                            ">
                            <label for="ssub_cta" class="control-label">Ssubcuenta:</label>
                                <input type="text" class="form-control" id="ssub_cta" name="ssub_cta" required>
                        </div>
                        <div class="form-group

                            ">
                            <label for="codigoSAT" class="control-label">ClaveProdServ:</label>
                                <input type="text" class="form-control" id="codigoSAT" name="codigoSAT" required>
                        </div>
               </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" onclick="editardiccionaconta()">Guardar Cambios</button>
                </div>
          </form>
        </div>
      </div>
</div>

<script>
function editarcuenta(cuenta,sub_cta,ssub_cta,codigoSAT,id){
    $('#modaleditarcuenta #id').val(id);
    $('#modaleditarcuenta #cuenta').val(cuenta);
    $('#modaleditarcuenta #sub_cta').val(sub_cta);
    $('#modaleditarcuenta #ssub_cta').val(ssub_cta);
    $('#modaleditarcuenta #codigoSAT').val(codigoSAT);
    $('#modaleditarcuenta').modal('show');
}
function editardiccionaconta(){
    var id = $('#modaleditarcuenta #id').val();
    var cuenta = $('#modaleditarcuenta #cuenta').val();
    var sub_cta = $('#modaleditarcuenta #sub_cta').val();
    var ssub_cta = $('#modaleditarcuenta #ssub_cta').val();
    var codigoSAT = $('#modaleditarcuenta #codigoSAT').val();

    $.ajax({
        url: '<?php echo base_url(); ?>herramientas/editarcuenta',
        type: 'POST',
        data: {id:id,cuenta:cuenta,sub_cta:sub_cta,ssub_cta:ssub_cta,codigoSAT:codigoSAT},
        dataType: 'json',
        success: function (data) {
            if(data.status){
                $('#modaleditarcuenta').modal('hide');
                $('#dicccionarioconta').DataTable().ajax.reload();
                var n = noty({ layout:'topRight',type: 'success',  theme: 'relax',text: data.data});
            } else {
                var n = noty({ layout:'topRight',type: 'error',  theme: 'relax',text: 'Error al editar la cuenta'});
            }
        },
        error: function () {
            var n = noty({ layout:'topRight',type: 'error',  theme: 'relax',text: 'Error en el servidor'});
        }
    });
    return false;
}
</script>