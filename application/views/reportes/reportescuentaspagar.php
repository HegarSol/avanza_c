<?php
if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
?>

<br>

<form class="form-horizontal" name="form1" id="" action="" target="_blank" method="POST">

  <div class= "container">
   <div class="panel panel-default">
      <div class="panel-heading">
      </div>
      <div class="panel-body">
         <div class="row">
            <div class="col-md-3">
              <input type="radio" id="" value="factu" name="faccom" checked> Facturas
              <input type="radio" id="" value="comple" name="faccom"> Complementos de pago
            </div>
        </div>
        <br>
        <input type="hidden" value="<?php echo $rfc;?>" id="rfcempresa" name="rfcempresa" readonly>
       <div class="row">
            <div class="col-md-3">
              <input type="radio" id="" value="todos" name="topro" onchange="mostrarproveedor()" checked> Todos
              <input type="radio" id="" value="provee" name="topro" onchange="mostrarproveedor()"> Proveedor
            </div>
            <div class="col-md-2">
            <br>
               <button type="button" class="btn btn-primary" id="buscarproveedor" onclick="abrirprovee()">Buscar proveedor</button>
            </div>
            <div class="col-md-3">
               <label for="" id="nombreprove2">Proveedor:</label>
               <input type="text" id="nombreprove" readonly name="nombreprove" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="" id="rfcprove2">RFC:</label>
                <input type="text" id="rfcprove" readonly name="rfcprove" class="form-control">
            </div>
       </div>
       <br>
       <div class="row">
            <div class="col-md-3">
              <input type="radio" id="" value="1" name="pepaam" checked> Pendientes
              <input type="radio" id="" value="2" name="pepaam"> Pagadas
              <input type="radio" id="" value="" name="pepaam"> Ambas
            </div>
       </div>
       <br>
       <div class="row">
            <div class="col-md-3">
              <input type="radio" id="" value="gene" name="gera" onchange="mostrarfecha()" checked> General
              <input type="radio" id="" value="fecha" name="gera" onchange="mostrarfecha()"> Rangos fechas de factura
            </div>
            <div class="col-md-3">
               <label for="" id="fechaini2">Fecha inicial:</label>
               <input type="date" id="fechaini" name="fechaini" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="" id="fechafinal2">Fecha final:</label>
                <input type="date" id="fechafinal" name="fechafinal" class="form-control">
            </div>
      </div>
      <br>
       <div class="row">
            <div class="col-md-3">
              <input type="radio" id="" value="1" name="acude" checked> Acumulado
              <input type="radio" id="" value="" name="acude"> Detallado
            </div>
      </div>
      </div>
      <div class="panel-footer">
        <div class="row">
          <div class="col-md-3">
             <button type="button" class="btn btn-primary" onclick="document.form1.action='<?php echo base_url();?>reportesm/ReporteCuentasPagar/imprimir'; document.form1.submit()"; ><span class="glyphicon glyphicon-print"></span> Imprimir</button>
             <button type="button" class="btn btn-success" onclick="document.form1.action='<?php echo base_url();?>reportesm/ReporteCuentasPagar/Excelexport'; document.form1.submit()"; ><span class="glyphicon glyphicon-file"></span> Exportar excel</button>
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

<div class="modal fade" id="myModalProveedores" role="dialog" >
<div class="modal-dialog modal-lg" >
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Proveedores</h1>
        </div>
        <div class="modal-body" >
          <table id="Beneficiarios2" class="stripe row-border responsive nowrap" cellspacing="0" width="90%">
              <thead style="background-color:#5a5a5a; color:white;"> 
                   <th>Accion</th>
                    <th>No Prov</th>
                    <th>Nombre</th>
                    <th>RFC</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>tipo_proveedor</th>
              </thead>
          </table>
        </div>
        <div class="modal-footer">
           <!-- <button type="button" class="btn btn-success" onclick="seleccionarbanco()">Aceptar</button> -->
        </div>
    </div>
</div>
</div>

<style>

#fechaini2{display:none;}
#fechaini{display:none;}
#fechafinal2{display:none;}
#fechafinal{display:none;}

#buscarproveedor{display:none;}
#nombreprove{display:none;}
#rfcprove{display:none;}
#nombreprove2{display:none;}
#rfcprove2{display:none;}

</style>

<script>

$('#Beneficiarios2').DataTable({
    responsive: true, 
    filter:true, 
    processing: true, 
    serverSide: true,
      ajax: {
          url : baseurl + "catalogos/Beneficiarios/ajax_list_beneficiarios",
          type : "POST"
          },
          "language" : {"url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
         ,"sDom": 'T<"clear">lfrtip', "oTableTools": {  "sRowSelect": "single","aButtons": ""},
         columnDefs: [ 
             { responsivePriority: 1, targets: 1, name : 'no_prov' }, 
        ]
   })

</script>

<script>

function selectbenefi(no_prov,nombre,rfc,direcion,telefono,tipo_prov)
{
   document.getElementById('nombreprove').value = nombre;
   document.getElementById('rfcprove').value = rfc;
}
function abrirprovee()
{
  $('#myModalProveedores').modal('show');
}
function mostrarproveedor()
{
  var tipo = $('input:radio[name=topro]:checked').val();
  if(tipo == 'todos')
  {
    document.getElementById('buscarproveedor').style.display = 'none';
    document.getElementById('nombreprove').style.display = 'none';
    document.getElementById('rfcprove').style.display = 'none';
    document.getElementById('nombreprove2').style.display = 'none';
    document.getElementById('rfcprove2').style.display = 'none';
  }
  else
  {
    document.getElementById('buscarproveedor').style.display = 'block';
    document.getElementById('nombreprove').style.display = 'block';
    document.getElementById('rfcprove').style.display = 'block';
    document.getElementById('nombreprove2').style.display = 'block';
    document.getElementById('rfcprove2').style.display = 'block';
  }
}
function mostrarfecha()
{
  var tipo = $('input:radio[name=gera]:checked').val();

  if(tipo == 'gene')
  {
    document.getElementById('fechaini2').style.display = 'none';
    document.getElementById('fechaini').style.display = 'none';
    document.getElementById('fechafinal2').style.display = 'none';
    document.getElementById('fechafinal').style.display = 'none';
  }
  else
  {
    document.getElementById('fechaini2').style.display = 'block';
    document.getElementById('fechaini').style.display = 'block';
    document.getElementById('fechafinal2').style.display = 'block';
    document.getElementById('fechafinal').style.display = 'block';
  }
}
</script>