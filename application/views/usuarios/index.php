<?php
if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
if(isset($reseteo))
  {if($reseteo==1){echo "<script> var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text:'Se realizó correctamente el reseteo de intentos de inicio de sesión.'});</script>";}
  else{ echo "<script> var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'No se pudo realizar el reinicio de intentos. Pruebe de nuevo.'});</script>"; } }
  if(isset($reseteoPass))
  {if($reseteoPass==1){echo "<script> var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text:'Se realizó correctamente el reseteo de contraseña.'});</script>";}
  else{ echo "<script> var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'No se pudo realizar el reinicio de contraseña. Pruebe de nuevo.'});</script>"; } }?>

<br>

<div class= "contairner-fluid">
   <div class="panel panel-default">
      <div class="panel-heading">

      </div>
      <div class="panel-body">
        <div class="col-md-12">
          <table id="users"  class="table table-strippered responsive nowrap"  cellspacing="0" width="100%">
            <thead style="background-color:#5a5a5a; color:white;">
              <th>Id</th>
              <th>Nombre</th>
              <th>Usuario</th>
              <th>Bloqueado</th>
              <th>Ultimo Acceso</th>
              <th>Acciones</th>
            </thead>
          </table>
        </div>
      </div>
      <div class="panel-footer">
          <!-- <div <?php echo $permisosGrupo['add']==1 ? '':'style="display: none;"';?>> -->
            <a href="<?php echo base_url();?>Usuarios/agregar" class="btn btn-success btn-lg" role="button">
              <span class="glyphicon glyphicon-plus"></span>Agregar Usuario
            </a>
          <!-- </div> -->
      </div>
  </div>
  </div>
  <div class="col-md-2 col-lg-2 col-sm-3" align="center">
    <br>
     </div><br>
  <div class="col-md-10 col-lg-10 col-sm-9">
  </div><div class="col-sm-1"></div>
</div>

