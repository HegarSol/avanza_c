<?php
if(!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
$desabilitado="";
if(isset($errores) && $errores!=""){
    for($i=0; $i<count($errores); $i++){
        echo "<script> var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: '".$errores[$i]."'});</script>";
    }
}

$img = $datosbanco[0]['logo'];

?>

<form class="form-horizontal">

<div class="panel-group">
   <div class="panel panel-default">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="row">
                 <input type="hidden" id="idbanco" name="idbanco" value="<?php echo $no_banco[0];?>" readonly>
                 <div class="col-sm-3">
                    <img id="blah" src="<?php echo isset($img) && $img!="0" ? "data:image/jpeg;base64,$img": base_url().'public/img/logo.png'?>" alt="your image" width="220px" height="110px" />
                </div>
                <div class="col-sm-2">
                    <br>
                    <br>
                    <b>Cuenta: <?php echo $datosbanco[0]['cuenta'] ?></b>
                    <br>
                    <b>Banco: <?php echo $datosbanco[0]['banco'] ?></b>
                </div>
                <div class="col-sm-2">
                    <br>
                    <label for="">Fecha pago:</label>
                    <input type="date" class="form-control" id="fechapago" name="fechapago">
                </div>
                <div class="col-sm-1">
                    <br>
                    <br>
                    <button type="button" class="btn btn-primary" onclick="buscarnominas()"><span class="glyphicon glyphicon-search"></span> Buscar</button>
                </div>
                <div class="col-sm-1">
                    <br>
                    <br>
                    <a href="<?php echo base_url().'catalogos/Bancos/index'?>" class="btn btn-info" role="button"><span class="fa fa-arrow-left"></span> Atras</a>
                </div>
                <div class="col-sm-1">
                    <br>
                    <br>
                    <button type="button" class="btn btn-success" onclick="polizarnomina()"> <span class="fa fa-check"></span> Polizar</button>
                </div>
            </div>
        </div>
   </div>
</div>

<div class="panel-group">
<div class="panel panel-default">
<div class="panel-heading"></div>
   <div class="panel-body">
     <div class="row">
           <div class="col-sm-6">
                <label for="">Concepto:</label>
                <input type="text" class="form-control" id="concepto" name="concepto" >
           </div>
           <div class="col-sm-4">
                <label for="">Referencia:</label>
                <input type="text" class="form-control" id="referencia" name="referencia">
           </div>
     </div>
  </div>
</div>
</div>
</div>

</form>

<div class="modal fade" id="ventanaspincorreo" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog">
       <div class="modal-content">
           <div class="modal-header" style="background-color:#222222; color:white;">
               <h4 class="modal-tilte">CREANDO POLIZA(S)</h4>
           </div>
           <div class="modal-body">
           <center><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></center>
           <br>
           <br>
           <center><h2>POR FAVOR ESPERE.....</h2></center>
           </div>
       </div>
  </div>
</div>

<div class="panel-group">
<div class="panel panel-default">
<div class="panel-heading"></div>
   <div class="panel-body">
    <div id="div1">
       <table id="tablaimporta" class="table table-bordered table-hover"  cellspacing="0" width="100%">
             <thead style="background-color:#5a5a5a; color:white;">
                 <tr>
                    <th>Seleccionar</th>
                    <th>Tipo operacion</th>
                    <th>Nombre</th>
                    <th style="display:none">sueldo</th>
                    <th style="display:none">tiempo_extra</th>
                    <th style="display:none">vacaciones</th>
                    <th style="display:none">aguinaldo</th>
                    <th style="display:none">ptu</th>
                    <th style="display:none">indemnizaciones</th>
                    <th style="display:none">otras_percepciones</th>
                    <th style="display:none">vales_despensa</th>
                    <th style="display:none">gratificaciones</th>
                    <th style="display:none">premio_puntualidad</th>
                    <th style="display:none">asistencia</th>
                    <th style="display:none">guarderias</th>
                    <th style="display:none">dias_festivos</th>
                    <th style="display:none">fondo_ahorro</th>
                    <th style="display:none">prima_vacacional</th>
                    <th style="display:none">ayuda_funeraria</th>
                    <th style="display:none">prima_dominical</th>
                    <th style="display:none">extras_triples</th>
                    <th style="display:none">pagos_separacion</th>
                    <th style="display:none">prima_antiguedad</th>
                    <th style="display:none">jubi_pen_ha_re</th>
                    <th style="display:none">jubi_pen_ha_re_par</th>
                    <th style="display:none">subsi_incapaci</th>
                    <th style="display:none">asimilados</th>
                    <th style="display:none">septimo_dias</th>
                    <th style="display:none">descanso_labora</th>
                    <th style="display:none">isr</th>
                    <th style="display:none">imss</th>
                    <th style="display:none">infonavit</th>
                    <th style="display:none">prestamo</th>
                    <th style="display:none">ahorro_sindical</th>
                    <th style="display:none">ahorro_bancario</th>
                    <th style="display:none">otras_deducion</th>
                    <th style="display:none">ajuste_subsi_causado</th>
                    <th style="display:none">ajuste_subsi_empleo</th>
                    <th style="display:none">isr_ajustado</th>
                    <th style="display:none">descuen_incapaci</th>
                    <th style="display:none">pension_alimen</th>
                    <th style="display:none">reintegro_isr_pagado</th>
                    <th style="display:none">subsidio_para_empleo</th>
                    <th style="display:none">viaticos</th>
                    <th style="display:none">aplica_saldo_favor_compensa</th>
                    <th style="display:none">reinte_isr_ret</th>,
                    <th style="display:none">alimentos_bienes</th>
                    <th style="display:none">isr_ajustado_subsidio</th>
                    <th style="display:none">subsio_efec_entrega</th>
                    <th style="display:none">pago_disti_listados_suedo</th>
                    <th>Total percepciones</th>
                    <th>Total deducciones</th>
                    <th>Total otros pagos</th>
                    <th>Total</th>
                 </tr>
             </thead>
             <tbody>
            </tbody>
      </table>
    </div>
   </div>
</div>
</div>


<script>
    function checar()
   {
         var detallereci = [];
          $("input[type=checkbox]:checked").each(function(){
                var recibo = [];
                var tipo = $(this).parent().parent().find('td:eq(1)').find('select').val();
                var nombre = $(this).parent().parent().find('td').eq(2).html();
                var sueldo = $(this).parent().parent().find('td').eq(3).html();
                var tiempo_extra = $(this).parent().parent().find('td').eq(4).html();
                var vacaciones = $(this).parent().parent().find('td').eq(5).html();
                var aguinaldo = $(this).parent().parent().find('td').eq(6).html();
                var ptu = $(this).parent().parent().find('td').eq(7).html();
                var indemnizaciones = $(this).parent().parent().find('td').eq(8).html();
                var otras_perce = $(this).parent().parent().find('td').eq(9).html();
                var vales_despensa = $(this).parent().parent().find('td').eq(10).html();
                var gratificaciones = $(this).parent().parent().find('td').eq(11).html();
                var premio_puntualidad = $(this).parent().parent().find('td').eq(12).html();
                var asistencia = $(this).parent().parent().find('td').eq(13).html();
                var guarderias = $(this).parent().parent().find('td').eq(14).html();
                var dias_festivos = $(this).parent().parent().find('td').eq(15).html();
                var fondo_ahorro = $(this).parent().parent().find('td').eq(16).html();
                var prima_vacacional = $(this).parent().parent().find('td').eq(17).html();
                var ayuda_funeraria = $(this).parent().parent().find('td').eq(18).html();
                var prima_dominical = $(this).parent().parent().find('td').eq(19).html();
                var extras_triples = $(this).parent().parent().find('td').eq(20).html();
                var pagos_separacion = $(this).parent().parent().find('td').eq(21).html();
                var prima_antiguedad = $(this).parent().parent().find('td').eq(22).html();
                var jubi_pen_ha_re = $(this).parent().parent().find('td').eq(23).html();
                var jubi_pen_ha_re_par = $(this).parent().parent().find('td').eq(24).html();
                var subsi_incapaci = $(this).parent().parent().find('td').eq(25).html();
                var asimilados = $(this).parent().parent().find('td').eq(26).html();
                var septimo_dias = $(this).parent().parent().find('td').eq(27).html();
                var descanso_labora = $(this).parent().parent().find('td').eq(28).html();
                var isr = $(this).parent().parent().find('td').eq(29).html();
                var imss = $(this).parent().parent().find('td').eq(30).html();
                var infonavit = $(this).parent().parent().find('td').eq(31).html();
                var prestamo = $(this).parent().parent().find('td').eq(32).html();
                var ahorro_sindical = $(this).parent().parent().find('td').eq(33).html();
                var ahorro_bancario = $(this).parent().parent().find('td').eq(34).html();
                var otras_deducion = $(this).parent().parent().find('td').eq(35).html();
                var ajuste_subsi_causado = $(this).parent().parent().find('td').eq(36).html();
                var ajuste_subsi_empleo = $(this).parent().parent().find('td').eq(37).html();
                var isr_ajustado = $(this).parent().parent().find('td').eq(38).html();
                var descuen_incapaci = $(this).parent().parent().find('td').eq(39).html();
                var pension_alimen = $(this).parent().parent().find('td').eq(40).html();
                var reintegro_isr_pagado = $(this).parent().parent().find('td').eq(41).html();
                var subsidio_para_empleo = $(this).parent().parent().find('td').eq(42).html();
                var viaticos = $(this).parent().parent().find('td').eq(43).html();
                var aplica_saldo_favor_compensa = $(this).parent().parent().find('td').eq(44).html();
                var reinte_isr_ret = $(this).parent().parent().find('td').eq(45).html();
                var alimentos_bienes = $(this).parent().parent().find('td').eq(46).html();
                var isr_ajustado_subsidio = $(this).parent().parent().find('td').eq(47).html();
                var subsio_efec_entrega = $(this).parent().parent().find('td').eq(48).html();
                var pago_disti_listados_suedo = $(this).parent().parent().find('td').eq(49).html();
                var total_percepciones = $(this).parent().parent().find('td').eq(50).html();
                var total_deducciones = $(this).parent().parent().find('td').eq(51).html();
                var total_otros_pagos = $(this).parent().parent().find('td').eq(52).html();
                recibo = [ 
                tipo,
                nombre,
                sueldo,
                tiempo_extra,
                vacaciones,
                aguinaldo, 
                ptu, 
                indemnizaciones,
                otras_perce,
                vales_despensa,
                gratificaciones,
                premio_puntualidad,
                asistencia,
                guarderias,
                dias_festivos,
                fondo_ahorro,
                prima_vacacional,
                ayuda_funeraria,
                prima_dominical,
                extras_triples,
                pagos_separacion,
                prima_antiguedad,
                jubi_pen_ha_re,
                jubi_pen_ha_re_par,
                subsi_incapaci,
                asimilados,
                septimo_dias,
                descanso_labora,
                isr,
                imss,
                infonavit,
                prestamo,
                ahorro_sindical,
                ahorro_bancario,
                otras_deducion,
                ajuste_subsi_causado,
                ajuste_subsi_empleo,
                isr_ajustado,
                descuen_incapaci,
                pension_alimen,
                reintegro_isr_pagado,
                subsidio_para_empleo,
                viaticos,
                aplica_saldo_favor_compensa,
                reinte_isr_ret,
                alimentos_bienes,
                isr_ajustado_subsidio,
                subsio_efec_entrega,
                pago_disti_listados_suedo,
                total_percepciones,
                total_deducciones,
                total_otros_pagos 
                ];
                detallereci.push(recibo);
            });
            return detallereci;
   }
    function polizarnomina()
    {
        var chek = checar();
        var concep = document.getElementById('concepto').value;
        var refe = document.getElementById('referencia').value;
        var id = document.getElementById('idbanco').value;
        var fechapago = document.getElementById('fechapago').value;

        if(chek.length == 0)
        {
            swal("Sin datos", "No hay datos seleccionados", "warning");
        }
        else
        {

            $('#ventanaspincorreo').modal('show');

            jQuery.ajax({
                type:"POST",
                url: baseurl+"catalogos/Importan/insertpolizar",
                data:{chek:chek,concep:concep,refe:refe,id:id,fechapago:fechapago},
                dataType:"html",
                success:function(response)
                {
                    $('#ventanaspincorreo').modal('hide');
                    swal('Hecho','Poliza(s) creada(s) correctamente' , "success");
                    document.getElementById('concepto').value = '';
                    document.getElementById('referencia').value = '';
                    document.getElementById('fechapago').value = '';
                    $('#tablaimporta tbody').empty();
                }
            });
        }
    }
    function buscarnominas()
    {


        var id = document.getElementById('idbanco').value;
        var fechap = document.getElementById('fechapago').value;

            jQuery.ajax({
                type:"POST",
                url: baseurl+"catalogos/Importan/getNomina",
                data:{id:id,fechap:fechap},
                dataType:"html",
                success:function(response)
                {
                    $("#tablaimporta tbody").empty();
                    response=JSON.parse(response);
                    if(response.length == 0)
                    {
                        swal("Sin datos", "No hay datos con esta fecha de pago o puede que si haya, pero no esten timbrados.", "warning");
                    }
                    else
                    {
                        for(var i in response)
                        {
                            var nombre = response[i].nombre;
                            var sueldo = response[i].sueldo;
                            var tiempo_extra = response[i].tiempo_extra;
                            var vacaciones = response[i].vacaciones;
                            var aguinaldo = response[i].aguinaldo;
                            var ptu = response[i].ptu;
                            var indemnizaciones = response[i].indemnizaciones;
                            var otras_perce = response[i].otras_percepciones;
                            var vales_despensa = response[i].vales_despensa;
                            var gratificaciones = response[i].gratificaciones;
                            var premio_puntualidad = response[i].premio_puntualidad;
                            var asistencia = response[i].asistencia;
                            var guarderias = response[i].guarderias;
                            var dias_festivos = response[i].dias_festivos;
                            var fondo_ahorro = response[i].fondo_ahorro;
                            var prima_vacacional = response[i].prima_vacacional;
                            var ayuda_funeraria = response[i].ayuda_funeraria;
                            var prima_dominical = response[i].prima_dominical;
                            var extras_triples = response[i].extras_triples;
                            var pagos_separacion = response[i].pagos_separacion;
                            var prima_antiguedad = response[i].prima_antiguedad;
                            var jubi_pen_ha_re = response[i].jubi_pen_ha_re;
                            var jubi_pen_ha_re_par = response[i].jubi_pen_ha_re_par;
                            var subsi_incapaci = response[i].subsi_incapaci;
                            var asimilados = response[i].asimilados;
                            var septimo_dias = response[i].septimo_dias;
                            var descanso_labora = response[i].descanso_labora;
                            var isr = response[i].isr;
                            var imss = response[i].imss;
                            var infonavit = response[i].infonavit;
                            var prestamo = response[i].prestamo;
                            var ahorro_sindical = response[i].ahorro_sindical;
                            var ahorro_bancario = response[i].ahorro_bancario;
                            var otras_deducion = response[i].otras_deducion;
                            var ajuste_subsi_causado = response[i].ajuste_subsi_causado;
                            var ajuste_subsi_empleo = response[i].ajuste_subsi_empleo;
                            var isr_ajustado = response[i].isr_ajustado;
                            var descuen_incapaci = response[i].descuen_incapaci;
                            var pension_alimen = response[i].pension_alimen;
                            var reintegro_isr_pagado = response[i].reintegro_isr_pagado;
                            var subsidio_para_empleo = response[i].subsidio_para_empleo;
                            var viaticos = response[i].viaticos;
                            var aplica_saldo_favor_compensa = response[i].aplica_saldo_favor_compensa;
                            var reinte_isr_ret = response[i].reinte_isr_ret;
                            var alimentos_bienes = response[i].alimentos_bienes;
                            var isr_ajustado_subsidio = response[i].isr_ajustado_subsidio;
                            var subsio_efec_entrega = response[i].subsio_efec_entrega;
                            var pago_disti_listados_suedo = response[i].pago_disti_listados_suedo;
                            var total_percepciones = response[i].total_percepciones;
                            var total_deducciones = response[i].total_deducciones;
                            var total_otros_pagos = response[i].total_otros_pagos;


                            var total = parseFloat(sueldo) + parseFloat(vacaciones) + parseFloat(aguinaldo) + parseFloat(ptu) + parseFloat(otras_perce) + parseFloat(prima_vacacional) - parseFloat(isr) - parseFloat(imss) - parseFloat(infonavit);

                            var tbody = document.getElementById('tablaimporta').getElementsByTagName("TBODY")[0];
                            var row = document.createElement("TR")

                            var element1 = document.createElement("input");
                            element1.type = "checkbox";
                            element1.name="chkbox[]";     
                            element1.checked = true;    
                            element1.setAttribute('onChange','');
                            var td1 = document.createElement("TD")
                            td1.style.textAlign = 'center';
                            td1.appendChild(element1)

                            var element2 = document.createElement("select");
                            var td2 = document.createElement("TD")

                            var array = ["Transferencia","Cheque"];
                            
                            for (var i = 0; i < array.length; i++) 
                            {
                                    var option = document.createElement("option");
                                    option.value = array[i];
                                    option.text = array[i];
                                    element2.appendChild(option);
                                    td2.appendChild(element2);
                            }

                            td2.style.textAlign = 'center';
                            element2.className = 'form-control';
                            

                            var td3 = document.createElement("TD")
                            td3.appendChild(document.createTextNode(nombre))
                            var td4 = document.createElement("TD")
                            td4.setAttribute('style','display:none')
                            td4.appendChild(document.createTextNode(sueldo.toFixed(2)))
                            var td5 = document.createElement("TD")
                            td5.setAttribute('style','display:none')
                            td5.appendChild(document.createTextNode(tiempo_extra.toFixed(2)))
                            var td6 = document.createElement("TD")
                            td6.setAttribute('style','display:none')
                            td6.appendChild(document.createTextNode(vacaciones.toFixed(2)))
                            var td7 = document.createElement("TD")
                            td7.setAttribute('style','display:none')
                            td7.appendChild(document.createTextNode(aguinaldo.toFixed(2)))
                            var td8 = document.createElement("TD")
                            td8.setAttribute('style','display:none')
                            td8.appendChild(document.createTextNode(ptu.toFixed(2)))
                            var td9 = document.createElement("TD")
                            td9.setAttribute('style','display:none')
                            td9.appendChild(document.createTextNode(indemnizaciones.toFixed(2)))
                            var td10 = document.createElement("TD")
                            td10.setAttribute('style','display:none')
                            td10.appendChild(document.createTextNode(otras_perce.toFixed(2)))
                            var td11 = document.createElement("TD")
                            td11.setAttribute('style','display:none')
                            td11.appendChild(document.createTextNode(vales_despensa.toFixed(2)))
                            var td12 = document.createElement("TD")
                            td12.setAttribute('style','display:none')
                            td12.appendChild(document.createTextNode(gratificaciones.toFixed(2)))
                            var td13 = document.createElement("TD")
                            td13.setAttribute('style','display:none')
                            td13.appendChild(document.createTextNode(premio_puntualidad.toFixed(2)))
                            
                            var td14 = document.createElement("TD")
                            td14.setAttribute('style','display:none')
                            td14.appendChild(document.createTextNode(asistencia.toFixed(2)))
                            var td15 = document.createElement("TD")
                            td15.setAttribute('style','display:none')
                            td15.appendChild(document.createTextNode(guarderias.toFixed(2)))
                            var td16 = document.createElement("TD")
                            td16.setAttribute('style','display:none')
                            td16.appendChild(document.createTextNode(dias_festivos.toFixed(2)))
                            var td17 = document.createElement("TD")
                            td17.setAttribute('style','display:none')
                            td17.appendChild(document.createTextNode(fondo_ahorro.toFixed(2)))
                            var td18 = document.createElement("TD")
                            td18.setAttribute('style','display:none')
                            td18.appendChild(document.createTextNode(prima_vacacional.toFixed(2)))
                            var td19 = document.createElement("TD")
                            td19.setAttribute('style','display:none')
                            td19.appendChild(document.createTextNode(ayuda_funeraria.toFixed(2)))
                            var td20 = document.createElement("TD")
                            td20.setAttribute('style','display:none')
                            td20.appendChild(document.createTextNode(prima_dominical.toFixed(2)))
                            var td21 = document.createElement("TD")
                            td21.setAttribute('style','display:none')
                            td21.appendChild(document.createTextNode(extras_triples.toFixed(2)))
                            var td22 = document.createElement("TD")
                            td22.setAttribute('style','display:none')
                            td22.appendChild(document.createTextNode(pagos_separacion.toFixed(2)))

                            var td23 = document.createElement("TD")
                            td23.setAttribute('style','display:none')
                            td23.appendChild(document.createTextNode(prima_antiguedad.toFixed(2)))
                            var td24 = document.createElement("TD")
                            td24.setAttribute('style','display:none')
                            td24.appendChild(document.createTextNode(jubi_pen_ha_re.toFixed(2)))
                            var td25 = document.createElement("TD")
                            td25.setAttribute('style','display:none')
                            td25.appendChild(document.createTextNode(jubi_pen_ha_re_par.toFixed(2)))
                            var td26 = document.createElement("TD")
                            td26.setAttribute('style','display:none')
                            td26.appendChild(document.createTextNode(subsi_incapaci.toFixed(2)))
                            var td27 = document.createElement("TD")
                            td27.setAttribute('style','display:none')
                            td27.appendChild(document.createTextNode(asimilados.toFixed(2)))
                            var td28 = document.createElement("TD")
                            td28.setAttribute('style','display:none')
                            td28.appendChild(document.createTextNode(septimo_dias.toFixed(2)))
                            var td29 = document.createElement("TD")
                            td29.setAttribute('style','display:none')
                            td29.appendChild(document.createTextNode(descanso_labora.toFixed(2)))
                            var td30 = document.createElement("TD")
                            td30.setAttribute('style','display:none')
                            td30.appendChild(document.createTextNode(isr.toFixed(2)))
                            var td31 = document.createElement("TD")
                            td31.setAttribute('style','display:none')
                            td31.appendChild(document.createTextNode(imss.toFixed(2)))

                            var td32 = document.createElement("TD")
                            td32.setAttribute('style','display:none')
                            td32.appendChild(document.createTextNode(infonavit.toFixed(2)))
                            var td33 = document.createElement("TD")
                            td33.setAttribute('style','display:none')
                            td33.appendChild(document.createTextNode(prestamo.toFixed(2)))
                            var td34 = document.createElement("TD")
                            td34.setAttribute('style','display:none')
                            td34.appendChild(document.createTextNode(ahorro_sindical.toFixed(2)))
                            var td35 = document.createElement("TD")
                            td35.setAttribute('style','display:none')
                            td35.appendChild(document.createTextNode(ahorro_bancario.toFixed(2)))
                            var td36 = document.createElement("TD")
                            td36.setAttribute('style','display:none')
                            td36.appendChild(document.createTextNode(otras_deducion.toFixed(2)))
                            var td37 = document.createElement("TD")
                            td37.setAttribute('style','display:none')
                            td37.appendChild(document.createTextNode(ajuste_subsi_causado.toFixed(2)))
                            var td38 = document.createElement("TD")
                            td38.setAttribute('style','display:none')
                            td38.appendChild(document.createTextNode(ajuste_subsi_empleo.toFixed(2)))
                            var td39 = document.createElement("TD")
                            td39.setAttribute('style','display:none')
                            td39.appendChild(document.createTextNode(isr_ajustado.toFixed(2)))
                            var td40 = document.createElement("TD")
                            td40.setAttribute('style','display:none')
                            td40.appendChild(document.createTextNode(descuen_incapaci.toFixed(2)))

                            var td41 = document.createElement("TD")
                            td41.setAttribute('style','display:none')
                            td41.appendChild(document.createTextNode(pension_alimen.toFixed(2)))
                            var td42 = document.createElement("TD")
                            td42.setAttribute('style','display:none')
                            td42.appendChild(document.createTextNode(reintegro_isr_pagado.toFixed(2)))
                            var td43 = document.createElement("TD")
                            td43.setAttribute('style','display:none')
                            td43.appendChild(document.createTextNode(subsidio_para_empleo.toFixed(2)))
                            var td44 = document.createElement("TD")
                            td44.setAttribute('style','display:none')
                            td44.appendChild(document.createTextNode(viaticos.toFixed(2)))
                            var td45 = document.createElement("TD")
                            td45.setAttribute('style','display:none')
                            td45.appendChild(document.createTextNode(aplica_saldo_favor_compensa.toFixed(2)))
                            var td46 = document.createElement("TD")
                            td46.setAttribute('style','display:none')
                            td46.appendChild(document.createTextNode(reinte_isr_ret.toFixed(2)))
                            var td47 = document.createElement("TD")
                            td47.setAttribute('style','display:none')
                            td47.appendChild(document.createTextNode(alimentos_bienes.toFixed(2)))
                            var td48 = document.createElement("TD")
                            td48.setAttribute('style','display:none')
                            td48.appendChild(document.createTextNode(isr_ajustado_subsidio.toFixed(2)))
                            var td49 = document.createElement("TD")
                            td49.setAttribute('style','display:none')
                            td49.appendChild(document.createTextNode(subsio_efec_entrega.toFixed(2)))
                            var td50 = document.createElement("TD")
                            td50.setAttribute('style','display:none')
                            td50.appendChild(document.createTextNode(pago_disti_listados_suedo.toFixed(2)))
                            var td51 = document.createElement("TD")
                            td51.appendChild(document.createTextNode(total_percepciones.toFixed(2)))
                            var td52 = document.createElement("TD")
                            td52.appendChild(document.createTextNode(total_deducciones.toFixed(2)))
                            var td53 = document.createElement("TD")
                            td53.appendChild(document.createTextNode(total_otros_pagos.toFixed(2)))
                            var td54 = document.createElement("TD")
                            td54.appendChild(document.createTextNode(((total_percepciones - total_deducciones) + total_otros_pagos).toFixed(2)))
                            
                            
                            row.appendChild(td1);
                            row.appendChild(td2);
                            row.appendChild(td3);
                            row.appendChild(td4);
                            row.appendChild(td5);
                            row.appendChild(td6);
                            row.appendChild(td7);
                            row.appendChild(td8);
                            row.appendChild(td9);
                            row.appendChild(td10);
                            row.appendChild(td11);
                            row.appendChild(td12);
                            row.appendChild(td13);
                            row.appendChild(td14);
                            row.appendChild(td15);
                            row.appendChild(td16);
                            row.appendChild(td17);
                            row.appendChild(td18);
                            row.appendChild(td19);
                            row.appendChild(td20);
                            row.appendChild(td21);
                            row.appendChild(td22);
                            row.appendChild(td23);
                            row.appendChild(td24);
                            row.appendChild(td25);
                            row.appendChild(td26);
                            row.appendChild(td27);
                            row.appendChild(td28);
                            row.appendChild(td29);
                            row.appendChild(td30);
                            row.appendChild(td31);
                            row.appendChild(td32);
                            row.appendChild(td33);
                            row.appendChild(td34);
                            row.appendChild(td35);
                            row.appendChild(td36);
                            row.appendChild(td37);
                            row.appendChild(td38);
                            row.appendChild(td39);
                            row.appendChild(td40);
                            row.appendChild(td41);
                            row.appendChild(td42);
                            row.appendChild(td43);
                            row.appendChild(td44);
                            row.appendChild(td45);
                            row.appendChild(td46);
                            row.appendChild(td47);
                            row.appendChild(td48);
                            row.appendChild(td49);
                            row.appendChild(td50);
                            row.appendChild(td51);
                            row.appendChild(td52);
                            row.appendChild(td53);
                            row.appendChild(td54);


                            tbody.appendChild(row);
                        }
                    }
                }
            });

        
    }
</script>