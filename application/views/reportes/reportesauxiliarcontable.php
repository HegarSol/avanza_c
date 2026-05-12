<?php
if(!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');

$this->load->view('beneficiarios/modales/TablaCuentasOperaciones');

?>

<br>

<form class="form-horizontal" name="form1" id="rac" action="reportesm/ReporteAuxiliarContable" target="_blank" method="POST">

  <div class= "container">
   <div class="panel panel-default">
      <div class="panel-heading">
      </div>
      <div class="panel-body">
        <input type="hidden" value="<?php echo $rfc;?>" id="rfcempresa" name="rfcempresa" readonly>
              <div class="row">
                  <div class="col-md-3">
                      <label for="">De la cuenta:</label>&nbsp;&nbsp;<a class="glyphicon glyphicon-search" onclick="abrirModalCuentasOperaciones(1)"></a>
                      <input type="text" id="cuenta" name="cuenta" class="form-control">
                  </div>
                  <div class="col-md-3">
                      <label for="">Subcuenta<br></label>
                      <input onblur="validarSubcuenta(2)" type="text" id="subcuenta" name="subcuenta" class="form-control">
                  </div>
                  <div class="col-md-3">
                    <label for="">SSubcuenta<br></label>
                      <input onblur="validarSubcuenta(3)" type="text" id="ssubcuenta" name="ssubcuenta" class="form-control">
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-3">
                      <label for="">A la cuenta:</label>&nbsp;&nbsp;<a class="glyphicon glyphicon-search" onclick="abrirModalCuentasOperaciones(2)"></a>
                      <!-- <input type="text" id="cuenta" name="cuenta" class="form-control"> -->
                  </div>
                  <div class="col-md-3">
                      <label for="">Subcuenta 2<br></label>
                      <input type="text" id="subcuenta2" name="subcuenta2" class="form-control">
                  </div>
                  <div class="col-md-3">
                        <label for="">SSubcuenta 2<br></label>
                      <input type="text" id="ssubcuenta2" name="ssubcuenta2" class="form-control">
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
             <button type="button" class="btn btn-primary" onclick="validaForm(1);"><span class="glyphicon glyphicon-print"></span> Imprimir</button>
             <button type="button" class="btn btn-success" onclick="validaForm(2);"><span class="glyphicon glyphicon-file"></span> Exportar excel</button>
             <!-- <button type="button" class="btn btn-primary" onclick="document.form1.action='<?php echo base_url();?>reportesm/ReporteAuxiliarContable/imprimir'; document.form1.submit()"; ><span class="glyphicon glyphicon-print"></span> Imprimir</button>
             <button type="button" class="btn btn-success" onclick="document.form1.action='<?php echo base_url();?>reportesm/ReporteAuxiliarContable/Excelexport'; document.form1.submit()"; ><span class="glyphicon glyphicon-file"></span> Exportar excel</button> -->
          </div>
        </div>
      </div>
      <input type="hidden" id="tipo" name="tipo" >
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

    $(document).ready(function(){
        $('#fechaini').val(new Date().toISOString().split('T')[0]);
        $('#fechafin').val(new Date().toISOString().split('T')[0]);
        
    });
    </script>


<script>
function seleccionarcunetaoperaciones(cuenta, subcuenta, nombre, ssubcuenta)
{
    let tipo = $('#tipo').val();
    if (tipo == 1) {
        document.getElementById('cuenta').value = cuenta;
        document.getElementById('subcuenta').value = subcuenta;
        document.getElementById('ssubcuenta').value = ssubcuenta;
        document.getElementById('subcuenta2').value = subcuenta;
        document.getElementById('ssubcuenta2').value = ssubcuenta;
    } else if (tipo == 2) {
        document.getElementById('subcuenta2').value = subcuenta;
        document.getElementById('ssubcuenta2').value = ssubcuenta;
    }
    
    
}
function validarSubcuenta(nivel)
{
    if (nivel == 2)
    {
        document.getElementById('subcuenta2').value = document.getElementById('subcuenta').value;
    } else
    {
    document.getElementById('ssubcuenta2').value = document.getElementById('ssubcuenta').value;
    }
    
}

function validaForm(tipo)
{
  var f = document.getElementById('rac');
  if(tipo == 1)
  {
    f.action = "imprimir";
  } 
  else
  {
    f.action = "Excelexport";
  }
  if(document.getElementById('fechaini').value == '' || document.getElementById('fechafin').value == '')
  {
    alert('Debe seleccionar un rango de fechas');
    return false;
  }
if(document.getElementById('fechaini').value > document.getElementById('fechafin').value)
  {
    alert('La fecha inicial no puede ser mayor a la fecha final');
    return false;
  }

  if(document.getElementById('cuenta').value == '' && document.getElementById('subcuenta').value == '' && document.getElementById('ssubcuenta').value == '')
  {
    alert('Debe seleccionar una cuenta');
    return false;
  }
  if(document.getElementById('subcuenta').value > document.getElementById('subcuenta2').value )
  {
    alert('El rango de subcuentas no es correcto');
    return false;
  }
  if(document.getElementById('ssubcuenta').value > document.getElementById('ssubcuenta2').value )
  {
    alert('El rango de ssubcuentas no es correcto');
    return false;
  }
  f.submit();
}
</script>
