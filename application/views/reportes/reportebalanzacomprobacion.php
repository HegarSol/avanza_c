<?php
if(!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
?>

<br>

<form action="" class="form-horizontal" name="form1" id="" name="" action="" target="_blank" method="POST">

              <div class="row">
                  <div class="col-md-2">
                     <label for="">Período:</label>
                     <select name="periodo" id="periodo" onchange="cambiopedi()" class="form-control">
                        <option value="" selected> -Seleccione- </option>
                        <option value="mensual">Mensual</option>
                        <option value="bimestral">Bimestral</option>
                        <option value="anual">Anual</option>
                        <option value="otro">Otro</option>
                     </select>
                  </div>
                  <div class="col-md-2" >
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
                            <option value="13">Mes 13 cierre</option>
                    </select>
                    </div>
                 </div>
                 <div class="col-md-2" >
                   <div id="bimestrales">
                    <label for="">Bimestral:</label>
                    <select name="bimes" id="bimes" class="form-control">
                         <option value="" selected> -Seleccione- </option>
                         <option value="01">1er. Bim.</option>
                         <option value="02">2do. Bim.</option>
                         <option value="03">3er. Bim.</option>
                         <option value="04">4to. Bim.</option>
                         <option value="05">5to. Bim.</option>
                         <option value="06">6to. Bim.</option>
                    </select>
                    </div>
                 </div>
                 <div class="col-md-2">
                   <div id="fechai">
                     <label for="">Del: </label>
                     <input type="date" id="fecha_ini" name="fecha_ini" class="form-control">
                   </div>
                 </div>
                 <div class="col-md-2" >
                   <div id="fechaf">
                     <label for="">Al: </label>
                     <input type="date" id="fecha_fin" name="fecha_fin" class="form-control">
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
                        <option value="2024">2024</option>
                        <option value="2025" selected>2025</option>
                     </select>
                 </div>
            </div>
             <br>
            <div class="row">
                <div class="col-md-3">
                </div>
                 <div class="col-md-3">
                    <label for="">Tipo de envío (N - Normal,C - Complementario):</label>
                    <input type="text" id="tipoenvio" name="tipoenvio" onkeypress="return soloSignos(event);" readonly value="N" maxlength="1" style="width: 20%" class="form-control"><b>*Solo para SAT</b>
                 </div>
                 <div class="col-md-1">
                 <br>
                    <input type="radio" id="ctasubcta" value="1" checked value="ctasub" name="radiocuenta">Cuenta-subcta
                 </div>
                 <div class="col-md-1">
                 <br>
                    <input type="radio" id="ctamyo" value="2" value="ctamyo" name="radiocuenta">Cta mayor
                 </div>
            </div>

            <br>

            <div class="row">
               <div class="col-md-3">
               </div>
               <div class="col-md-2">
                  <input type="date" class="form-control" id="fechaenvio" name="fechaenvio">
               </div>
            </div>

             <br>
             <br>

<center>
             <div class="row">
               <button type="button" class="btn btn-info" onclick="buscarbalanza()" ><span class="glyphicon glyphicon-check"></span> Aceptar</button>
               <button type="button" class="btn btn-primary" onclick="document.form1.action='<?php echo base_url();?>reportesm/BalanzaComprobacion/imprimir'; document.form1.submit()"; ><span class="glyphicon glyphicon-print"></span> Imprimir</button>
               <button type="button" class="btn btn-success" onclick="document.form1.action='<?php echo base_url();?>reportesm/BalanzaComprobacion/Excelexport'; document.form1.submit()"; ><span class="glyphicon glyphicon-file"></span> Exportar excel</button>
               <button type="button" class="btn btn-warning" disabled id="xmlsat" name="xmlsat" onclick="document.form1.action='<?php echo base_url();?>reportesm/BalanzaComprobacion/xml'; document.form1.submit()"; ><span class="glyphicon glyphicon-qrcode"></span> SAT</button>
             </div>
</center>

<br>

<div class="row">
<div class="col-md-5">
</div>
  <div class="col-md-1">
     <label for="">Totales:</label>
  </div>
  <div class="col-md-1">
      <input type="text" id="inicial2" readonly style="text-align:right;" value="0.00" name="inicial2" class="form-control">
  </div>
  <div class="col-md-1">
      <input type="text" id="cargos2" readonly style="text-align:right;" name="cargos2" value="0.00" class="form-control">
  </div>
  <div class="col-md-1">
      <input type="text" id="abonos2" readonly style="text-align:right;" name="abonos2" value="0.00" class="form-control">
  </div>
  <div class="col-md-1">
      <input type="text" id="saldomensual2" readonly style="text-align:right;" value="0.00" name="saldomensual2" class="form-control">
  </div>
  <div class="col-md-1">
      <input type="text" id="final2" readonly style="text-align:right;" name="final2" value="0.00" class="form-control">
  </div>
</div>



<br>
<br>

<div id="espacioBalanza"></div>


</form>

<style>
#meses{display:none;}
#bimestrales{display:none;}
#fechai{display:none;}
#fechaf{display:none;}
#fechaenvio{display:none;}
</style>

<script>
    $(document).ready(function(){
        dsd();
    });
</script>

<script>
    function dsd()
    {
        var fecha = new Date();
        var hoy = fecha.getDate();
        var mesAnterior = fecha.getMonth() - 1 + 1; 

        document.getElementById('mese').value = '0'+mesAnterior;
    }
   function verificar()
   {
        if(document.getElementById('tipoenvio').value == 'C')
        {
            document.getElementById('fechaenvio').style.display = 'block';
        }
        else
        {
            document.getElementById('fechaenvio').style.display = 'none';
        }
   }
    function soloSignos(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toUpperCase();
       letras = "NC";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales)
       {
            if(key == especiales[i])
            {
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial)
        {
            return false;
        }

        setTimeout(function(){
            verificar();
         }, 1000);

    }
function buscarbalanza()
{
   var mes = document.getElementById('mese').value;
   var bim = document.getElementById('bimes').value;
   var fechafin = document.getElementById('fecha_fin').value;
   var fechaini = document.getElementById('fecha_ini').value;
   var perio = document.getElementById('periodo').value;
   var ano = document.getElementById('anol').value;
   var tipoprove = $("input:radio[name=radiocuenta]:checked").val();

   jQuery.ajax({
        url: baseurl + "reportesm/BalanzaComprobacion/balanza",
        type:"POST",
        data:{mes:mes,bim:bim,ano:ano,fechafin:fechafin,fechaini:fechaini,perio:perio,radiocuenta:tipoprove},
        dataType: "html",
        success:function(data)
        {

           $('#tabla_balanza tbody').empty();
            $('#espacioBalanza').html(data);
            $('#tabla_balanza').DataTable({
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
function cambiopedi()
{
   var perio = document.getElementById('periodo').value;
    if(perio == 'mensual')
    {
        document.getElementById('meses').style.display = 'block';
        document.getElementById('bimestrales').style.display = 'none';
        document.getElementById('fechai').style.display = 'none';
        document.getElementById('fechaf').style.display = 'none';
        $('#tipoenvio').prop('readonly',false);
        $('#xmlsat').prop('disabled',false);
    }
    else if(perio == 'bimestral')
    {
        document.getElementById('meses').style.display = 'none';
        document.getElementById('bimestrales').style.display = 'block';
        document.getElementById('fechai').style.display = 'none';
        document.getElementById('fechaf').style.display = 'none';
        $('#tipoenvio').prop('readonly',true);
         document.getElementById('tipoenvio').value = 'N';
         $('#xmlsat').prop('disabled',true);
    }
    else if(perio == 'anual')
    {
        document.getElementById('meses').style.display = 'none';
        document.getElementById('bimestrales').style.display = 'none';
        document.getElementById('fechai').style.display = 'none';
        document.getElementById('fechaf').style.display = 'none';
        $('#tipoenvio').prop('readonly',true);
         document.getElementById('tipoenvio').value = 'N';
         $('#xmlsat').prop('disabled',true);
    }
    else if(perio == 'otro')
    {
        document.getElementById('meses').style.display = 'none';
        document.getElementById('bimestrales').style.display = 'none';
        document.getElementById('fechai').style.display = 'block';
        document.getElementById('fechaf').style.display = 'block';
        $('#tipoenvio').prop('readonly',true);
         document.getElementById('tipoenvio').value = 'N';
         $('#xmlsat').prop('disabled',true);
    }
    else
    {
        document.getElementById('meses').style.display = 'none';
        document.getElementById('bimestrales').style.display = 'none';
        document.getElementById('fechai').style.display = 'none';
         document.getElementById('fechaf').style.display = 'none';
         $('#tipoenvio').prop('readonly',true);
         document.getElementById('tipoenvio').value = 'N';
         $('#xmlsat').prop('disabled',true);
    }
}
</script>