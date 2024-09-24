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
         <div class="col-md-4">
         </div>
         <div class="col-md-1" >
                   <div id="meses">
                    <label for="">Mes:</label>
                    <select name="mese" id="mese" class="form-control">
                            <option value="" selected> -Seleccione- </option>
                            <option value="01">Enero</option>
                            <option value="02">Febrero</option>
                            <option value="03">Marzo</option>
                            <option value="04">Abril</option>
                            <option value="05">Mayo</option>
                            <option value="06">Junio</option>
                            <option value="07">Julio</option>
                            <option value="08">Agosto</option>
                            <option value="09">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                    </select>
                    </div>
                 </div>
                 <div class="col-md-1">
                     <label for="">Año: </label>
                     <select name="anol" id="anol" class="form-control">
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024" selected>2024</option>
                     </select>
                 </div>
      </div>
   </div>
   <div class="row">
          <div class="col-md-4">
          </div>
          <div class="col-md-3">
             <button type="button" class="btn btn-info" onclick="buscarcomparativo()" ><span class="glyphicon glyphicon-check"></span> Aceptar</button>
             <button type="button" class="btn btn-success" onclick="document.form1.action='<?php echo base_url();?>reportesm/ReporteEstadoResultado/Excelexport'; document.form1.submit()"; ><span class="glyphicon glyphicon-file"></span> Exportar excel</button>
          </div>
        </div>

        <br>
        <br>

        <div id="espacioComparativo"></div>

</form>

<script>
   function buscarcomparativo()
   {
          var mes = document.getElementById('mese').value;
          var ano = document.getElementById('anol').value;

        jQuery.ajax({
            url: baseurl + "reportesm/ReporteEstadoResultadoComparativo/buscar",
            type:"POST",
            data:{ano:ano,mes:mes},
            dataType: "html",
            success:function(data)
            {
                $('#tabla_comparativo tbody').empty();
                $('#espacioComparativo').html(data);
                $('#tabla_comparativo').DataTable({
                language: { "url" : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
                "sDom": 'T<"clear">lfrtip', "oTableTools": {  "sRowSelect": "single","aButtons": ""},
                pageLength: 1000,
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