<?php
if(!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
?>

<br>

<form class="form-horizontal" name="form1" id="" target="_blank" method="POST" action="">
   <div class="panel-heading">
   </div>
   <div class="panel-body">
      <div class="row">
         <div class="col-md-3">
         </div>
         <div class="col-md-2">
            <label for="">De fecha:</label>
            <input type="date" name="fechaini" id="fechaini" class="form-control">
         </div>
         <div class="col-md-2">
             <label for="">A fecha:</label>
             <input type="date" name="fechafin" id="fechafin" class="form-control">
         </div>
      </div>
   </div>
   <div class="row">
          <div class="col-md-5">
          </div>
          <div class="col-md-3">
             <!-- <button type="button" class="btn btn-info" onclick="buscarlibro()" ><span class="glyphicon glyphicon-check"></span> Aceptar</button> -->
             <button type="button" class="btn btn-success" onclick="document.form1.action='<?php echo base_url();?>reportesm/ReportePagado/Excelexport'; document.form1.submit()"; ><span class="glyphicon glyphicon-file"></span> Exportar excel</button>
          </div>
        </div>
</form>