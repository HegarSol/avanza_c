<?php
if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
?>


  <br>

  <div class= "contairner-fluid">
   <div class="panel panel-default">
      <div class="panel-heading">

      </div>
      <div class="panel-body">
        <div class="col-md-12">
          <table id="empresas" class="stripe row-border responsive nowrap"  cellspacing="0" width="100%">
            <thead style="background-color:#5a5a5a; color:white;">
              <th>Id</th>
              <th>RFC</th>
              <th>Razón</th>
              <th>Teléfono</th>
              <th>Acciones</th>
            </thead>
          </table>
        </div>
      </div>
        <div class="panel-footer">
            <a href="<?php echo base_url();?>empresas/agregar" class="btn btn-success btn-lg" role="button" ><span class="glyphicon glyphicon-plus" ></span> Agregar Empresa</a>
      </div>
  </div>
  </div>
  <div class="col-md-2 col-lg-2 col-sm-3" align="center">
    <br>
     </div><br>
  <div class="col-md-10 col-lg-10 col-sm-9">
  </div><div class="col-sm-1"></div>
</div>

