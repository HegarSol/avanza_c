<?php
if(!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');

$this->load->view('beneficiarios/modales/TablaCuentasOperaciones');

?>

<br>

<form class="form-horizontal" name="form1" id="" action="" target="_blank" method="POST">

  <div class= "container">
   <div class="panel panel-default">
      <div class="panel-heading">
      </div>
      <div class="panel-body">
        <input type="hidden" value="<?php echo $rfc;?>" id="rfcempresa" name="rfcempresa" readonly>
              <div class="row">
                  <div class="col-md-3">
                      <label for="">De la cuenta:</label>&nbsp;&nbsp;<a class="glyphicon glyphicon-search" data-toggle="modal" data-target="#myModalCuentasOperaciones"></a>
                      <input type="text" id="cuenta" name="cuenta" class="form-control">
                  </div>
                  <div class="col-md-3">
                      <label for=""><br></label>
                      <input type="text" id="subcuenta" name="subcuenta" class="form-control">
                  </div>
                  <div class="col-md-3">
                      <label for="">A la cuenta:</label>
                      <input type="text" id="subcuenta2" name="subcuenta2" class="form-control">
                  </div>
              </div>
               <br>
              <div class="row">
                  <div class="col-md-3">
                     <label for="">De la fecha:</label>
                     <input type="date" id="fechaini" name="fechaini" class="form-control">
                  </div>
                  <div class="col-md-3">
                     <label for="">A la fecha:</label>
                     <input type="date" id="fechafin" name="fechafin" class="form-control">
                  </div>
               </div>
               <br>
               <div class="row">
                  <div class="col-md-10">
                      <input type="checkbox" id="agrupado" value="1" name="agrupado"> Agrupado por referencia(cuenta de clientes,corresponsal,PHCC,etc.);
                  </div>
           </div>
      </div>
      <div class="panel-footer">
        <div class="row">
          <div class="col-md-3">
             <button type="button" class="btn btn-primary" onclick="document.form1.action='<?php echo base_url();?>reportesm/ReporteAuxiliarContable/imprimir'; document.form1.submit()"; ><span class="glyphicon glyphicon-print"></span> Imprimir</button>
             <button type="button" class="btn btn-success" onclick="document.form1.action='<?php echo base_url();?>reportesm/ReporteAuxiliarContable/Excelexport'; document.form1.submit()"; ><span class="glyphicon glyphicon-file"></span> Exportar excel</button>
          </div>
        </div>
      </div>
      
  </div>
  </div>
  <div class="col-md-2 col-lg-2 col-sm-3" align="center">
    <br>
     </div><br>
  <div class="col-md-10 col-lg-10 col-sm-9">
  </div><div class="col-sm-1"></div>
</div>

</form>

<script>
function seleccionarcunetaoperaciones(cuenta, subcuenta, nombre, ssubcuenta)
{
    document.getElementById('cuenta').value = cuenta;
    document.getElementById('subcuenta').value = subcuenta;
    document.getElementById('subcuenta2').value = ssubcuenta;
    
}

</script>