<?php
if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
  $desabilitado="";
  if (isset($errores) && $errores!=""){
    for($i= 0; $i<count($errores); $i++)
    { echo "<script> var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: '".$errores[$i]."'});</script>"; }
  }
 
?>

<div class="container-fluid">
   <div class="panel panel-default">
        <div class="panel-heading">
           <form action="form-horizontal">
             <div class="form-group">
             </div>
           </form>
        </div>
        <div class="panel-body">
           <table id="polizas" class="stripe row-border responsive nowrap" cellspacing="0" width="100%">
              <thead style="background-color:#5a5a5a; color:white;">
                 <tr>
                    <th>#Poliza</th>
                    <th>Fecha</th>
                    <th>Concepto</th>
                    <th>Acciones</th>
                 </tr>
              </thead>
           </table>
        </div>
        <div class="panel-footer">
            <a href="<?php echo base_url();?>catalogos/Polizasdiarias/agregar" class="btn btn-success btn-lg" role="button"><span class="glyphicon glyphicon-plus"></span> Agregar poliza diaria</a>
        </div>
   </div>
   <div class="col-md-2 col-ls-2 col-sm-3" align="center">
    <br>
   </div><br>
   <div class="col-md-10 col-lg-10 col-sm-9">
   </div><div class="col-sm-1"></div>
</div>