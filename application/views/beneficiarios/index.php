<?php
if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
  $desabilitado="";
  if (isset($errores) && $errores!=""){
    for($i= 0; $i<count($errores); $i++)
    { echo "<script> var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: '".$errores[$i]."'});</script>"; }
  }
 
  $this->load->view('beneficiarios/modales/CuentasPagar');

?>

<div class="container-fluid">
   <div class="panel panel-default">
       <div class="panel-heading">
           <form class="form-horizontal">
               <div class="form-group">
                  &nbsp;&nbsp;
                  <a href="<?php echo base_url();?>catalogos/Beneficiarios/agregar" class="btn btn-success btn-lg" role="button"><span class="glyphicon glyphicon-plus"></span> Agregar Beneficiario</a>
                  <!-- <a href="<?php echo base_url();?>catalogos/Beneficiarios/estafeta" class="btn btn-warning btn-lg"><span class="fa fa-folder-open-o"></span> Estafeta</a> -->
                  <button type="button" onclick="beneestafe()" class="btn btn-warning btn-lg"><span class="fa fa-folder-open-o"></span> Estafeta</button>
               </div>
           </form>
       </div>
       <div class="panel-body">
         <table id="Beneficiarios" class="stripe row-border responsive nowrap" cellspacing="0" width="100%">
             <thead style="background-color:#5a5a5a; color:white;">
                <tr>
                    <th>No Prov</th>
                    <th>Nombre</th>
                    <th>RFC</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>Tipo Proveedor</th>
                    <th>Acciones</th>
                </tr>
             </thead>
         </table>
       </div>
       <div class="panel-footer">
       </div>
   </div>
</div>


<script>
function abrircuentaspagar(rfcReceptor,no_prov,nombre,rfcEmisor,direccion,tipo_prove)
{

               document.getElementById('numprov').innerHTML = no_prov;
               document.getElementById('nomprov').innerHTML = nombre;
               document.getElementById('rfcprov').innerHTML = rfcEmisor;
               document.getElementById('direprov').innerHTML = direccion;
               document.getElementById('tipoproveedor').value = tipo_prove;
               var forma2 = 'D';
               verTabla(rfcReceptor,forma2);

              $('#myModalCuentasPagar').modal('show');
          
}
function beneestafe()
{
// var oTT = $.fn.dataTable.TableTools.fnGetInstance("Beneficiarios");
//             var aData = oTT.fnGetSelectedData();
//             if (aData.length != 1) 
//                 { 
//                    var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Seleccione un registro.'});
//                 }
//             else
//             {
             // console.log(aData[0][0]);
              location.href="<?php echo base_url();?>catalogos/Beneficiarios/estafeta";
           // }
}
</script>