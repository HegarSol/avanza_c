<?php
if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
  $desabilitado="";
  if (isset($errores) && $errores!=""){
    for($i= 0; $i<count($errores); $i++)
    { echo "<script> var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: '".$errores[$i]."'});</script>"; }
  }
 
$img = $datosbanco[0]['logo'];

?>
  <form class="form-horizontal" name="reporte" id="reporte" action="../../../Reportes/reporteConciliacion" target="_blank" method="POST">

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
                       <label for="">Saldo en estado de cuenta</label>
                       <input type="text" class="form-control" id="saldoestado" value="0.00" onkeyup="resat();" name="saldoestado">
                </div>
                <div class="col-sm-2">
                <br>
                       <label for="">Diferencia</label>
                       <input type="text" readonly class="form-control" id="diferenciaestado" value="0.00" name="diferenciaestado">
                </div>
          </div>
          <br>
          <script type="text/javascript">
      // $(function () { $('#fechaini').datetimepicker({format: 'd/m/Y', seconds: false, formatTime: 'A g:i'}); });
      // $(function () { $('#fechafin').datetimepicker({format: 'd/m/Y', seconds: false, formatTime: 'A g:i'}); });
    </script>
          <div class="row">
              <div class="col-md-2">
                  <label for="">Del:</label>
                  <input type="date" class="form-control" id="fechaini" name="fechaini">
              
              </div>
              <div class="col-md-2">
                   <label for="">Al:</label>
                   <input type="date" class="form-control" id="fechafin" name="fechafin">
              
              </div>
              <div class="col-md-2">
                    <label for="">Tipo de póliza:</label>
                    <br>
                  <input type="radio" name="tipoliza" value="A" onclick="btnConciliacion('A');" checked> Ambas
                  <input type="radio" name="tipoliza" value="C" onclick="btnConciliacion('C');"> Cheques
                  <input type="radio" name="tipoliza" value="D" onclick="btnConciliacion('D');"> Depósitos
              </div>
              <div class="col-md-2">
                   <label for="">Mostrar movimientos:</label>
                   <br>
                   <input type="radio" name="mosmo" value="0" onclick="btnTransito('0')"> en transito
                   <input type="radio" name="mosmo" value="1" onclick="btnTransito('1')" checked> cobrados/en transito
              </div>
              <div class="col-md-1">
                 <br>
                   <button type="button" class="btn btn-success" onclick="btnConciliacion('A');"><span class="glyphicon glyphicon-search"></span> Buscar</button>
              </div>
              <div class="col-md-1">
                 <br>
                 <a href="<?php echo base_url().'catalogos/Bancos/index'?>" class="btn btn-danger" role="button"><span class="fa fa-arrow-left"></span> Atras</a>
              </div>
              <div class="col-md-1">
                 <br>
                 <button type="button" class="btn btn-primary" onclick="Reporteconci()"><span class="glyphicon glyphicon-print"></span> Imprimir</button>
              </div>
              <div class="col-md-1">
                 <br>
                 <button type="button" class="btn btn-primary" onclick="Excelreporte()"><span class="glyphicon glyphicon-file"></span> Exportar excel</button>
              </div>
          </div>
          <br>
          <div class="row">
             <div class="col-md-1">
               <label for="">Saldo inicial:</label>
               <input type="text" readonly class="form-control" value="0.00" id="saldoinicial" name="saldoinicial">
             </div>
             
             <div class="col-md-2">
               <label for="">Cargos conciliados:</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <font size="3"><b>+</b></font>
               <input type="text" readonly class="form-control" value="0.00" id="cargoconciliado" name="cargoconciliado">
             </div>
             
             <div class="col-md-2">
               <label for="">Abonos conciliados:</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <font size="3"><b>-</b></font>
               <input type="text" readonly class="form-control" value="0.00" id="abonoconciliado" name="abonoconciliado">
             </div>
             
             <div class="col-md-2">
               <label for="">Saldo en bancos:</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <font size="3"><b>=</b></font>
               <input type="text" readonly class="form-control" value="0.00" id="saldobancos" name="saldobancos">
             </div>

             <div class="col-md-2">
               <label for="">Cargos sin conciliar:</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <font size="3"><b>+</b></font>
               <input type="text" readonly class="form-control" value="0.00" id="cargossinconciliar" name="cargossinconciliar">
             </div>

             <div class="col-md-2">
               <label for="">Abonos sin conciliar:</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <font size="3"><b>-</b></font>
               <input type="text" readonly class="form-control" value="0.00" id="abonossinconciliar" name="abonossinconciliar">
             </div>

             <div class="col-md-1">
               <label for="">Saldo libros:</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <font size="3"><b>=</b></font>
               <input type="text" readonly class="form-control" value="0.00" id="saldolibros" name="saldolibros">
             </div>

          </div>

   </div>
</div>
</div>

</form>

<div class="panel-group">
<div class="panel panel-default">
<div class="panel-heading"></div>
   <div class="panel-body">
    <div id="div1">
       <table id="consiliacion" class="table table-bordered table-hover"  cellspacing="0" width="100%">
             <thead style="background-color:#5a5a5a; color:white;">
                 <tr>
                    <th>Tipo póliza</th>
                    <th>Num banco</th>
                    <th>Num mov</th>
                    <th>Fecha</th>
                    <th>Beneficiario</th>
                    <th>Concepto</th>
                    <th>+/-</th>
                    <th>Monto</th>
                    <th>Cobrado</th>
                    <th>Fecha cobro</th>
                    <th>Accion</th>
                 </tr>
             </thead>
             <tbody>
             </tbody>
      </table>
    </div>
   </div>
</div>
</div>

<div class="modal fade" id="myModalFechacobro" role="dialog" >
<div class="modal-dialog modal-lg" >
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Fecha cobro</h1>
            <input type="hidden" id="numerofechacobro" name="numerofechacobro">
        </div>
        <div class="modal-body" >
            <div class="row">
              <div class="col-md-4">
                 <label for="">Cambio fecha cobro</label>
                 <input type="date" id="fechacobrocambio" name="fechacobrocambio" class="form-control">
              </div>
            </div>
            <br>
            <button class="btn btn-success" onclick="returnCambiofecha()" data-dismiss="modal" aria-hidden="true" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button>
        </div>
    </div>
</div>
</div>


<style>
#div1{
  max-height: 600px;
  overflow: scroll;
}
</style>

<script>
function Excelreporte()
{
  var tipo = $('input:radio[name=tipoliza]:checked').val();
  var fechaini = document.getElementById('fechaini').value;
  var fechafin = document.getElementById('fechafin').value;
  var no_banco = '<?php echo $no_banco[0];?>';
  var mosmo = $('input:radio[name=mosmo]:checked').val();
  var cuenta = '<?php echo $datosbanco[0]['cuenta'] ?>';
  var banco = '<?php echo $datosbanco[0]['banco'] ?>';

  var saldoestado = document.getElementById('saldoestado').value;
  var difere = document.getElementById('diferenciaestado').value;

  var saldoini = document.getElementById('saldoinicial').value;
  var cargoconsi = document.getElementById('cargoconciliado').value;
  var abonoconsi = document.getElementById('abonoconciliado').value;
  var saldobancos = document.getElementById('saldobancos').value;
  var cargosinconsi = document.getElementById('cargossinconciliar').value;
  var abonosinconci = document.getElementById('abonossinconciliar').value;
  var saldolibros = document.getElementById('saldolibros').value;

        if(tipo == 'A')
        {
          var tipos = 'Ambas';
        }
        else if(tipo == 'C')
        {
           var tipos = 'Cheques';
        }
        else
        {
           var tipos = 'Depósitos';
        }
        if(mosmo == '0')
        {
           var mosmos = 'En transito';
        }
        else
        {
           var mosmos = 'Cobrados / en transito';
        }

  jQuery.ajax({
     type:"POST",
     url: baseurl + "catalogos/Conciliacion/getdatosconciliacion",
     data: {tipo:tipo,fechaini:fechaini,fechafin:fechafin,no_banco:no_banco,mosmo:mosmo},
     success:function(msg)
     {
      var i=1;
          var color="";
          if (msg!="")
          {
            var tab_text="<h1>Conciliacion bancaria</h1>"+
            "<b>Cuenta: &nbsp;&nbsp;</b>"+cuenta+
            "<br>"+
            "<b>Banco: &nbsp;&nbsp;</b>"+banco+
            "<br>"+
            "<b>Del:</b> " + fechaini +
            "&nbsp;&nbsp;<b>Al: </b> " + fechafin +
            "<br>"+
            "<b>Tipo de poliza:</b> "+tipos+
            "<br>"+
            "<b>Mostrar movimientos:</b> "+mosmos +
            "<br>"+
            "<b>Saldo inicial: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
            "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
            "&nbsp;&nbsp;&nbsp;</b>" + saldoini +
            "<br>"+
            "<b>Cargo conciliados + : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
            "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>" + cargoconsi +
            "<br>"+
            "<b>Abono conciliados - : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>" + abonoconsi +
            "<br>"+
            "<b>Saldo bancos = : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
            "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>" + saldobancos + "&nbsp;&nbsp;&nbsp;"+
            "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
            "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Saldo en estado: </b>&nbsp;&nbsp;&nbsp;"+
            "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+saldoestado+
            "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b> Diferencia: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+difere+
            "<br>"+
            "<b>Cargo sin conciliar + : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>" + cargosinconsi +
            "<br>"+
            "<b>Abonos sin conciliar - : &nbsp;&nbsp;&nbsp;&nbsp;</b>" + abonosinconci +
            "<br>"+
            "<b>Saldo libros = : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
            "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>" + saldolibros +
            "<table border='2px'>"+ 
               "<tr>"+
                 "<td bgcolor='#D7D7D7'>Tipo poliza</td>"+
                 "<td bgcolor='#D7D7D7'>Num banco</td>"+
                 "<td bgcolor='#D7D7D7'>Num mov</td>"+
                 "<td bgcolor='#D7D7D7'>Fecha</td>"+
                 "<td bgcolor='#D7D7D7'>Beneficiario</td>"+
                 "<td bgcolor='#D7D7D7'>Concepto</td>"+
                 "<td bgcolor='#D7D7D7'>+/-</td>"+
                 "<td bgcolor='#D7D7D7'>Monto</td>"+
                 "<td bgcolor='#D7D7D7'>Cobrado</td>"+
                 "<td bgcolor='#D7D7D7'>Fecha cobro</td>"+
             "</tr>";
          for(i=0; i<msg.length;i++)
          {
            if(msg[i].hasOwnProperty('saldoini'))
            {

            }
            else
            {
              if(msg[i].c_a=="-"){ color="bgcolor='#F5A9A9'"; }
              if(msg[i].c_a=="+"){ color="bgcolor='#BCF5A9'"; }
              tab_text=tab_text+"<tr>"+
              "<td>"+ msg[i].tipo_mov+"</td>"+
              "<td>"+ msg[i].no_banco+"</td>"+
              "<td>"+ msg[i].no_mov+"</td>"+
              "<td>"+ msg[i].fecha+"</td>"+
              "<td>"+ msg[i].beneficia+"</td>"+
              "<td>"+ msg[i].concepto+"</td>"+
              "<td "+color+">"+ msg[i].c_a+"</td>"+
              "<td>"+ msg[i].monto+"</td>"+
              "<td>"+ msg[i].cobrado+"</td>"+
              "<td>"+ msg[i].fechaCobro+"</td></tr>";
              tab_text=tab_text+"</tr>";
              color="";
            }
          }
            window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

          }
          else
          { swal("Error", 'Hubo un error al crear el archivo, por favor inténtelo de nuevo', "error"); }
     }
  });
}
function returnCambiofecha()
{
         var fecha = document.getElementById('fechacobrocambio').value
         var p = document.getElementById('numerofechacobro').value;
         var valor = 1;
         var tipo = document.getElementById('consiliacion').tBodies[0].rows[p-1].cells[0].innerHTML;
         var num_ban = document.getElementById('consiliacion').tBodies[0].rows[p-1].cells[1].innerHTML;
         var num_mov = document.getElementById('consiliacion').tBodies[0].rows[p-1].cells[2].innerHTML;
  
         document.getElementById('consiliacion').tBodies[0].rows[p-1].cells[9].innerHTML = fecha;
  
         jQuery.ajax({
           type:"POST",
           url: baseurl + "catalogos/Conciliacion/actualizarconci",
           data:{valor:valor,fecha:fecha,tipo:tipo,num_ban:num_ban,num_mov:num_mov},
           dataType:"html",
           success:function(response)
           {

           }
      });
}
function Reporteconci()
{
  var f = document.getElementById('reporte');
  f.action = "../../../Reportes/reporteConciliacion";
  f.submit();
}
function btnTransito(mosmo)
{
  var tipo = $('input:radio[name=tipoliza]:checked').val();
  var fechaini = document.getElementById('fechaini').value;
  var fechafin = document.getElementById('fechafin').value;
  var no_banco = '<?php echo $no_banco[0];?>';

  if(fechaini == '' || fechafin == '')
  {
     var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Elija la fecha inicial y final.'}); 
  }
  else
  {
        jQuery.ajax({
          url : baseurl + "catalogos/Conciliacion/getdatosconciliacion",
          type: "POST",
          data:{fechaini:fechaini,fechafin:fechafin,tipo:tipo,no_banco:no_banco,mosmo:mosmo},
          dataType:"html",
          success:function(response)
          {
                response=JSON.parse(response);
                $('#consiliacion tbody').empty();
                document.getElementById('cargossinconciliar').value = 0.00;
                document.getElementById('abonossinconciliar').value = 0.00;
                document.getElementById('abonoconciliado').value = 0.00;
                document.getElementById('cargoconciliado').value = 0.00;
                document.getElementById('saldoinicial').value = 0.00;
                document.getElementById('saldolibros').value = 0.00;
                //console.log(response);
                for(var i in response)
                {

                  if(response[i].hasOwnProperty('saldoini'))
                  {
                    document.getElementById('saldoinicial').value = response[i].saldoini;
                  }
                  else
                  {

                      var tbody = document.getElementById('consiliacion').getElementsByTagName("TBODY")[0];
                      var row = document.createElement("TR")
                      var td1 = document.createElement("TD")
                      td1.appendChild(document.createTextNode(response[i].tipo_mov))
                      var td2 = document.createElement("TD")
                      td2.appendChild(document.createTextNode(response[i].no_banco))
                      var td3 = document.createElement("TD")
                      td3.appendChild(document.createTextNode(response[i].no_mov))
                      var td4 = document.createElement("TD")
                      td4.appendChild(document.createTextNode(response[i].fecha))
                      var td5 = document.createElement("TD")
                      td5.appendChild(document.createTextNode(response[i].beneficia))
                      var td6 = document.createElement("TD")
                      td6.appendChild(document.createTextNode(response[i].concepto))

                      if(response[i].c_a == '-')
                      {
                          var td7 = document.createElement("TD")
                          td7.style.backgroundColor = "#FF6969";
                          td7.appendChild(document.createTextNode(response[i].c_a))
                          var td8 = document.createElement("TD")
                          td8.style.backgroundColor = "#FF6969";
                          td8.appendChild(document.createTextNode(response[i].monto))
                      }
                      else
                      {
                          var td7 = document.createElement("TD")
                          td7.style.backgroundColor = "#87FF69";
                          td7.appendChild(document.createTextNode(response[i].c_a))
                          var td8 = document.createElement("TD")
                          td8.style.backgroundColor = "#87FF69";
                          td8.appendChild(document.createTextNode(response[i].monto))
                      }


                      if(response[i].cobrado == 0)
                      {

                        var element1 = document.createElement("input");
                        element1.type = "checkbox";
                        element1.name="chkbox[]";         
                        element1.setAttribute('onChange','myfunction(this)');
                        var td9 = document.createElement("TD")
                        td9.style.textAlign = 'center';
                        td9.appendChild(element1)

                          var td10 = document.createElement("TD")
                          td10.appendChild(document.createTextNode(''))

                          var btn = document.createElement("input");
                           btn.type = 'button';
                           btn.setAttribute('onclick','myfunctionbutton(this)');
                           btn.setAttribute('disabled',true);
                           btn.className = 'btn btn-primary';
                           btn.value = 'Cambiar fecha cobro';
                           var btn2 = document.createElement("TD");
                           btn2.appendChild(btn);

                          if(response[i].c_a == '-')
                          {
                            var abonosin = parseFloat(document.getElementById('abonossinconciliar').value);
                            var totalabonosin = abonosin + parseFloat(response[i].monto);
                            document.getElementById('abonossinconciliar').value = totalabonosin.toFixed(2);
                          }
                          else
                          {
                            var cargosin = parseFloat(document.getElementById('cargossinconciliar').value);
                            var totalcargosin = cargosin + parseFloat(response[i].monto);
                            document.getElementById('cargossinconciliar').value = totalcargosin.toFixed(2);
                          }
                      }
                      else
                      {
                        var element1 = document.createElement("input");
                        element1.type = "checkbox";
                        element1.name="chkbox[]";
                        element1.setAttribute('onChange','myfunction(this)');
                        element1.checked = true;
                        var td9 = document.createElement("TD")
                        td9.style.textAlign = 'center';
                        td9.appendChild(element1)

                        var td10 = document.createElement("TD")
                        td10.appendChild(document.createTextNode(response[i].fechaCobro))

                        var btn = document.createElement("input");
                           btn.type = 'button';
                           btn.setAttribute('onclick','myfunctionbutton(this)');
                           btn.className = 'btn btn-primary';
                           btn.value = 'Cambiar fecha cobro';
                           var btn2 = document.createElement("TD");
                           btn2.appendChild(btn);

                          if(response[i].c_a == '-')
                          {
                            var abono = parseFloat(document.getElementById('abonoconciliado').value);
                            var totalabono = abono + parseFloat(response[i].monto);
                            document.getElementById('abonoconciliado').value = totalabono.toFixed(2);
                          }
                          else
                          {
                            var cargo = parseFloat(document.getElementById('cargoconciliado').value);
                            var totalcargo = cargo + parseFloat(response[i].monto);
                            document.getElementById('cargoconciliado').value = totalcargo.toFixed(2);
                          }
                      }

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
                      row.appendChild(btn2);
                      tbody.appendChild(row);
                   }

                }

                var saldoini = parseFloat(document.getElementById('saldoinicial').value);
                var cargocon = parseFloat(document.getElementById('cargoconciliado').value);
                var abonocon = parseFloat(document.getElementById('abonoconciliado').value);


                var total1 = ((saldoini + cargocon) - abonocon);
                document.getElementById('saldobancos').value = total1.toFixed(2);

                var saldoban = parseFloat(document.getElementById('saldobancos').value);
                var cargosin = parseFloat(document.getElementById('cargossinconciliar').value);
                var abonosin = parseFloat(document.getElementById('abonossinconciliar').value);

                var total2 = ((saldoban  + cargosin) - abonosin);
                document.getElementById('saldolibros').value = total2.toFixed(2);

                var saldoesta = parseFloat(document.getElementById('saldoestado').value);
                var saldoba = parseFloat(document.getElementById('saldobancos').value);
                var difere = saldoba + saldoesta;
                document.getElementById('diferenciaestado').value = difere.toFixed(2);
          }
      });
  }
}
function btnConciliacion(tipo)
{

  var fechaini = document.getElementById('fechaini').value;
  var fechafin = document.getElementById('fechafin').value;

  var no_banco = '<?php echo $no_banco[0];?>';
  var mosmo = $('input:radio[name=mosmo]:checked').val();

  if(fechaini == '' || fechafin == '')
  {
     var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Elija la fecha inicial y final.'}); 
  }
  else
  {
        jQuery.ajax({
          url : baseurl + "catalogos/Conciliacion/getdatosconciliacion",
          type: "POST",
          data:{fechaini:fechaini,fechafin:fechafin,tipo:tipo,no_banco:no_banco,mosmo:mosmo},
          dataType:"html",
          success:function(response)
          {
                response=JSON.parse(response);
                $('#consiliacion tbody').empty();
                document.getElementById('cargossinconciliar').value = 0.00;
                document.getElementById('abonossinconciliar').value = 0.00;
                document.getElementById('abonoconciliado').value = 0.00;
                document.getElementById('cargoconciliado').value = 0.00;
                document.getElementById('saldoinicial').value = 0.00;
                document.getElementById('saldolibros').value = 0.00;
                //console.log(response);
                for(var i in response)
                {

                  if(response[i].hasOwnProperty('saldoini'))
                  {
                    document.getElementById('saldoinicial').value = response[i].saldoini;
                  }
                  else
                  {

                      var tbody = document.getElementById('consiliacion').getElementsByTagName("TBODY")[0];
                      var row = document.createElement("TR")
                      var td1 = document.createElement("TD")
                      td1.appendChild(document.createTextNode(response[i].tipo_mov))
                      var td2 = document.createElement("TD")
                      td2.appendChild(document.createTextNode(response[i].no_banco))
                      var td3 = document.createElement("TD")
                      td3.appendChild(document.createTextNode(response[i].no_mov))
                      var td4 = document.createElement("TD")
                      td4.appendChild(document.createTextNode(response[i].fecha))
                      var td5 = document.createElement("TD")
                      td5.appendChild(document.createTextNode(response[i].beneficia))
                      var td6 = document.createElement("TD")
                      td6.appendChild(document.createTextNode(response[i].concepto))

                      if(response[i].c_a == '-')
                      {
                          var td7 = document.createElement("TD")
                          td7.style.backgroundColor = "#FF6969";
                          td7.appendChild(document.createTextNode(response[i].c_a))
                          var td8 = document.createElement("TD")
                          td8.style.backgroundColor = "#FF6969";
                          td8.appendChild(document.createTextNode(response[i].monto))
                      }
                      else
                      {
                          var td7 = document.createElement("TD")
                          td7.style.backgroundColor = "#87FF69";
                          td7.appendChild(document.createTextNode(response[i].c_a))
                          var td8 = document.createElement("TD")
                          td8.style.backgroundColor = "#87FF69";
                          td8.appendChild(document.createTextNode(response[i].monto))
                      }


                      if(response[i].cobrado == 0)
                      {

                        var element1 = document.createElement("input");
                        element1.type = "checkbox";
                        element1.name="chkbox[]";         
                        element1.setAttribute('onChange','myfunction(this)');
                        var td9 = document.createElement("TD")
                        td9.style.textAlign = 'center';
                        td9.appendChild(element1)

                          var td10 = document.createElement("TD")
                          td10.appendChild(document.createTextNode(''))

                          var btn = document.createElement("input");
                           btn.type = 'button';
                           btn.setAttribute('onclick','myfunctionbutton(this)');
                           btn.setAttribute('disabled',true);
                           btn.className = 'btn btn-primary';
                           btn.value = 'Cambiar fecha cobro';
                           var btn2 = document.createElement("TD");
                           btn2.appendChild(btn);

                          if(response[i].c_a == '-')
                          {
                            var abonosin = parseFloat(document.getElementById('abonossinconciliar').value);
                            var totalabonosin = abonosin + parseFloat(response[i].monto);
                            document.getElementById('abonossinconciliar').value = totalabonosin.toFixed(2);
                          }
                          else
                          {
                            var cargosin = parseFloat(document.getElementById('cargossinconciliar').value);
                            var totalcargosin = cargosin + parseFloat(response[i].monto);
                            document.getElementById('cargossinconciliar').value = totalcargosin.toFixed(2);
                          }
                      }
                      else
                      {
                        var element1 = document.createElement("input");
                        element1.type = "checkbox";
                        element1.name="chkbox[]";
                        element1.setAttribute('onChange','myfunction(this)');
                        element1.checked = true;
                        var td9 = document.createElement("TD")
                        td9.style.textAlign = 'center';
                        td9.appendChild(element1)

                        var td10 = document.createElement("TD")
                        td10.appendChild(document.createTextNode(response[i].fechaCobro))

                        var btn = document.createElement("input");
                           btn.type = 'button';
                           btn.setAttribute('onclick','myfunctionbutton(this)');
                           btn.className = 'btn btn-primary';
                           btn.value = 'Cambiar fecha cobro';
                           var btn2 = document.createElement("TD");
                           btn2.appendChild(btn);

                          if(response[i].c_a == '-')
                          {
                            var abono = parseFloat(document.getElementById('abonoconciliado').value);
                            var totalabono = abono + parseFloat(response[i].monto);
                            document.getElementById('abonoconciliado').value = totalabono.toFixed(2);
                          }
                          else
                          {
                            var cargo = parseFloat(document.getElementById('cargoconciliado').value);
                            var totalcargo = cargo + parseFloat(response[i].monto);
                            document.getElementById('cargoconciliado').value = totalcargo.toFixed(2);
                          }
                      }

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
                      row.appendChild(btn2);
                      tbody.appendChild(row);
                   }

                }

                var saldoini = parseFloat(document.getElementById('saldoinicial').value);
                var cargocon = parseFloat(document.getElementById('cargoconciliado').value);
                var abonocon = parseFloat(document.getElementById('abonoconciliado').value);


                var total1 = ((saldoini + cargocon) - abonocon);
                document.getElementById('saldobancos').value = total1.toFixed(2);

                var saldoban = parseFloat(document.getElementById('saldobancos').value);
                var cargosin = parseFloat(document.getElementById('cargossinconciliar').value);
                var abonosin = parseFloat(document.getElementById('abonossinconciliar').value);

                var total2 = ((saldoban  + cargosin) - abonosin);
                document.getElementById('saldolibros').value = total2.toFixed(2);

                var saldoesta = parseFloat(document.getElementById('saldoestado').value);
                var saldoba = parseFloat(document.getElementById('saldobancos').value);
                var difere = saldoba + saldoesta;
                document.getElementById('diferenciaestado').value = difere.toFixed(2);
          }
      });
  }


}
function myfunctionbutton(r)
{

  var p = r.parentNode.parentNode.rowIndex;

   document.getElementById('numerofechacobro').value = p;

   $("#myModalFechacobro").modal('show');
}
function myfunction(r)
{
       var p = r.parentNode.parentNode.rowIndex;
 
       var id = document.getElementById("consiliacion").getElementsByTagName("tr")[p].cells[8].getElementsByTagName('input')[0].checked;
      
      if(id == true)
      {
         document.getElementById('consiliacion').tBodies[0].rows[p-1].cells[9].innerHTML = document.getElementById('consiliacion').tBodies[0].rows[p-1].cells[3].innerHTML;
         var valor = 1;
         var fecha = document.getElementById('consiliacion').tBodies[0].rows[p-1].cells[9].innerHTML;
         var tipo = document.getElementById('consiliacion').tBodies[0].rows[p-1].cells[0].innerHTML;
         var num_ban = document.getElementById('consiliacion').tBodies[0].rows[p-1].cells[1].innerHTML;
         var num_mov = document.getElementById('consiliacion').tBodies[0].rows[p-1].cells[2].innerHTML;
         
         if(document.getElementById('consiliacion').tBodies[0].rows[p-1].cells[6].innerHTML == '-')
         {
            var monto = document.getElementById('consiliacion').tBodies[0].rows[p-1].cells[7].innerHTML;
            var abonos = parseFloat(document.getElementById('abonoconciliado').value);
            var totalabo = abonos + parseFloat(monto);
            document.getElementById('abonoconciliado').value = totalabo.toFixed(2);

            var abonosin = parseFloat(document.getElementById('abonossinconciliar').value);
            var totalabosin = abonosin - parseFloat(monto);
            document.getElementById('abonossinconciliar').value = totalabosin.toFixed(2);
         }
         else
         {
            var monto = document.getElementById('consiliacion').tBodies[0].rows[p-1].cells[7].innerHTML;
            var cargos = parseFloat(document.getElementById('cargoconciliado').value);
            var totalcar = cargos + parseFloat(monto);
            document.getElementById('cargoconciliado').value = totalcar.toFixed(2);

            var cargosin = parseFloat(document.getElementById('cargossinconciliar').value);
            var totalcarsin = cargosin - parseFloat(monto);
            document.getElementById('cargossinconciliar').value = totalcarsin.toFixed(2);
         }

         document.getElementById("consiliacion").getElementsByTagName("tr")[p].cells[10].getElementsByTagName('input')[0].disabled = false;

      }
      else
      {
         document.getElementById('consiliacion').tBodies[0].rows[p-1].cells[9].innerHTML = '';
         var valor = 0;
         var fecha = '';
         var tipo = document.getElementById('consiliacion').tBodies[0].rows[p-1].cells[0].innerHTML;
         var num_ban = document.getElementById('consiliacion').tBodies[0].rows[p-1].cells[1].innerHTML;
         var num_mov = document.getElementById('consiliacion').tBodies[0].rows[p-1].cells[2].innerHTML;

         if(document.getElementById('consiliacion').tBodies[0].rows[p-1].cells[6].innerHTML == '-')
         {
            var monto = document.getElementById('consiliacion').tBodies[0].rows[p-1].cells[7].innerHTML;
            var abonos = parseFloat(document.getElementById('abonoconciliado').value);
            var totalabo = abonos - parseFloat(monto);
            document.getElementById('abonoconciliado').value = totalabo.toFixed(2);

            var abonosin = parseFloat(document.getElementById('abonossinconciliar').value);
            var totalabosin = abonosin + parseFloat(monto);
            document.getElementById('abonossinconciliar').value = totalabosin.toFixed(2);
         }
         else
         {
            var monto = document.getElementById('consiliacion').tBodies[0].rows[p-1].cells[7].innerHTML;
            var cargos = parseFloat(document.getElementById('cargoconciliado').value);
            var totalcar = cargos - parseFloat(monto);
            document.getElementById('cargoconciliado').value = totalcar.toFixed(2);

            var cargosin = parseFloat(document.getElementById('cargossinconciliar').value);
            var totalcarsin = cargosin + parseFloat(monto);
            document.getElementById('cargossinconciliar').value = totalcarsin.toFixed(2);
         }

         document.getElementById("consiliacion").getElementsByTagName("tr")[p].cells[10].getElementsByTagName('input')[0].disabled = true;
      }

      var saldoini = parseFloat(document.getElementById('saldoinicial').value);
      var cargocon = parseFloat(document.getElementById('cargoconciliado').value);
      var abonocon = parseFloat(document.getElementById('abonoconciliado').value);


      var total1 = ((saldoini + cargocon) - abonocon);
      document.getElementById('saldobancos').value = total1.toFixed(2);

      var saldoban = parseFloat(document.getElementById('saldobancos').value);
      var cargosin = parseFloat(document.getElementById('cargossinconciliar').value);
      var abonosin = parseFloat(document.getElementById('abonossinconciliar').value);

      var total2 = ((saldoban  + cargosin) - abonosin);
      document.getElementById('saldolibros').value = total2.toFixed(2);

      var saldolib = parseFloat(document.getElementById('saldolibros').value);

      var saldoesta = parseFloat(document.getElementById('saldoestado').value);
      var saldoba = parseFloat(document.getElementById('saldobancos').value);
      var difere = saldoba + saldoesta;
      document.getElementById('diferenciaestado').value = difere.toFixed(2);


      jQuery.ajax({
           type:"POST",
           url: baseurl + "catalogos/Conciliacion/actualizarconci",
           data:{valor:valor,fecha:fecha,tipo:tipo,num_ban:num_ban,num_mov:num_mov},
           dataType:"html",
           success:function(response)
           {

           }
      });

}

function resat()
{
      var saldoesta = parseFloat(document.getElementById('saldoestado').value);
      var saldoba = parseFloat(document.getElementById('saldobancos').value);
      var difere = saldoba - saldoesta;
      document.getElementById('diferenciaestado').value = difere.toFixed(2);
}


</script>