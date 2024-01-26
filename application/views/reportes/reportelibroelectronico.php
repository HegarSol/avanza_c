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
          <div class="col-md-2">
          </div>
           <div class="col-md-2">
                <label for="">Tipo de póliza</label>
                <select name="tipopoliza" id="tipopoliza" class="form-control">
                   <option value="*">Todas  | *</option>
                   <option value="T">Transferencia | T</option>
                   <option value="C">Cheques       | C</option>
                   <option value="D">Depositos     | D</option>
                   <option value="O">Póliza diaria | O</option>
                   <option value="P">Pasivo        | P</option>
                   <option value="I">Ingresos      | I</option>
                </select>
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
             <button type="button" class="btn btn-info" onclick="buscarlibro()" ><span class="glyphicon glyphicon-check"></span> Aceptar</button>
             <button type="button" class="btn btn-primary" onclick="document.form1.action='<?php echo base_url();?>reportesm/LibroElectronico/imprimir'; document.form1.submit()"; ><span class="glyphicon glyphicon-print"></span> Imprimir</button>
             <button type="button" class="btn btn-success" onclick="document.form1.action='<?php echo base_url();?>reportesm/LibroElectronico/Excelexport'; document.form1.submit()"; ><span class="glyphicon glyphicon-file"></span> Exportar excel</button>
          </div>
        </div>

<br>
<br>

<div id="espaciolibro"></div>

</form>

<script>
function buscarlibro()
{
    var tipopo = document.getElementById('tipopoliza').value;
    var fechain = document.getElementById('fechaini').value;
    var fechafin = document.getElementById('fechafin').value;

    jQuery.ajax({
        url: baseurl + "reportesm/LibroElectronico/libro",
        type:"POST",
        data:{tipopo:tipopo,fechaini:fechain,fechafin:fechafin},
        dataType: "html",
        success:function(data)
        {
            $('#tabla_libro tbody').empty();
            $('#espaciolibro').html(data);
            $('#tabla_libro').DataTable({
               language: { "url" : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
               "sDom": 'T<"clear">lfrtip', "oTableTools": {  "sRowSelect": "single","aButtons": ""},
               "columnDefs" : [
                  {
                     "targets" : [-1],
                     "orderable" : false
                  }
               ]
            });
        },
        error:function()
        {
            var n = noty({text: 'Error al recuperar la informacion', type: 'error', theme: 'relax'});
        }
    });
}

</script>