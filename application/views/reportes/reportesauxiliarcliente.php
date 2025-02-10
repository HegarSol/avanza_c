<?php
if(!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');


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
                  <!-- <div class="col-md-3">
                      <label for="">Cuenta:</label>
                      <input type="text" id="cuenta" readonly name="cuenta" value="108" class="form-control">
                  </div> -->
                  <div class="col-md-3">
                      <label for=""><br></label>&nbsp;&nbsp;<a class="glyphicon glyphicon-search" data-toggle="modal" data-target="#myModalBenefi"></a>
                      <input type="text" id="subcuenta" name="subcuenta" class="form-control">
                  </div>
                  <!-- <div class="col-md-3">
                      <label for="">A la cuenta:</label>
                      <input type="text" id="subcuenta2" name="subcuenta2" class="form-control">
                  </div> -->
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
                      <input type="checkbox" id="no_pagado" value="1" name="no_pagado"> No pagado
                  </div>
           </div>
      </div>
      <div class="panel-footer">
        <div class="row">
          <div class="col-md-3">
             <button type="button" class="btn btn-primary" onclick="document.form1.action='<?php echo base_url();?>reportesm/ReporteAuxiliarCliente/imprimir'; document.form1.submit()"; ><span class="glyphicon glyphicon-print"></span> Imprimir</button>
             <button type="button" class="btn btn-success" onclick="document.form1.action='<?php echo base_url();?>reportesm/ReporteAuxiliarCliente/Excelexport'; document.form1.submit()"; ><span class="glyphicon glyphicon-file"></span> Exportar excel</button>
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

<div class="modal fade" id="myModalBenefi" role="dialog" >
<div class="modal-dialog modal-lg" >
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Busqueda Cuenta</h1>
        </div>
        <div class="modal-body" >
          <table id="Beneficiarios2" class="stripe row-border responsive nowrap" cellspacing="0" width="90%">
              <thead style="background-color:#5a5a5a; color:white;">
                    <th>Accion</th>
                    <th>Cuenta</th>
                    <th>Sub cta</th>
                    <th>Nombre cta</th>
                    <th>Ssub cta</th>
              </thead>
          </table>
            <!-- <button class="btn btn-success" aria-hidden="true" onclick="selectbenefi()" ><span class="glyphicon glyphicon-ok"></span> Seleccionar</button> -->
        </div>
    </div>
</div>
</div>

</form>

<script>
  function seleccionarcuneta(cta,sub_cta,nombre,ssub_cta)
  {
      document.getElementById('subcuenta').value = sub_cta;
      //$('#myModalBenefi').modal('hide');
  }
  $('#Beneficiarios2').DataTable({
    responsive: true, 
    filter:true, 
    processing: true, 
    serverSide: true,
      ajax: {
          url : baseurl + "catalogos/Cuentas/ajax_cuentaselejir",
          type : "POST"
          },
          "language" : {"url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
         ,"sDom": 'T<"clear">lfrtip', "oTableTools": {  "sRowSelect": "single","aButtons": ""},
         columnDefs: [ 
             { responsivePriority: 1, targets: 1, name : 'no_prov' }, 
        ]
   })
</script>