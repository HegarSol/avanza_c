<?php
if(!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
echo validation_errors();


$this->load->view('beneficiarios/modales/CuentasPagar');
$this->load->view('beneficiarios/modales/RegistroPagos');
$this->load->view('beneficiarios/modales/TablaCuentas');
$this->load->view('beneficiarios/modales/TablaClientes');
?>

<input type="hidden" id="identi" name="identi" readonly value="<?php echo isset($datos[0]['id']) ? $datos[0]['id'] : '0'?>">
<div class="panel-group">
  <div class="panel panel-default">
     <div class="panel-heading"></div>
     <div class="panel-body">

           <div class="row">
              <div class="col-sm-7">
              </div>
              <div class="col-sm-1">
                 <b>Tipo:</b>
                 <input type="text" id="tipo" name="tipo" class="form-control" readonly value="O">
              </div>
              <div class="col-sm-2">
                <b>Consecutivo: </b>
                <input type="text" id="no_mov" name="no_mov" class="form-control" readonly value="<?php echo isset($datos[0]['no_mov']) ? $datos[0]['no_mov'] : $concecutivo ?>">
              </div>
              <div class="col-sm-2">
                <b>Fecha:</b>
                <input type="date" id="fechatrabajo" name="fechatrabajo" value="<?php echo isset($datos[0]['fecha']) ? $datos[0]['fecha'] : date('Y-m-d')?>" class="form-control" >
              </div>
           </div>
           <br>
           <div class="row">
                <div class="col-sm-7">
                </div>
                <div class="col-sm-1">
                     <button type="button" disabled class="btn btn-primary">Poliza Cortes</button>
                </div>
                <div class="col-sm-1">
                     <button type="button" class="btn btn-primary" onclick="abrircuentaspagar()"><span class="fa fa-usd"></span> X pagar</button>
                </div>
                <div class="col-sm-1">
                     <button type="button" class="btn btn-primary" onclick="abrirregistropago()"><span class="fa fa-usd"></span> Reg. Pago</button>
                </div>
           </div>
           <br>
           <div class="row">
                <div class="col-sm-6">
                    <b>Concepto:</b>
                    <textarea name="concepto" id="concepto" cols="10" rows="3" class="form-control" ><?php echo isset($datos[0]['concepto']) ? $datos[0]['concepto'] : '' ?></textarea>
                </div>
           </div>
     </div>
  </div>
</div>

<div class="panel-group">
    <div class="panel panel-default">
    <div class="panel-heading"><center><b><font size="5">Asiento Contable</font></b></center></div>
    <div class="panel-body">

    <div class="row">
        <div class="col-sm-2">
            <label for="">Cuenta</label>&nbsp;&nbsp;<a class="glyphicon glyphicon-search" data-toggle="modal" data-target="#myModalCuentas"></a>
            <input type="text" class="form-control" id="cuenta">
        </div>
        <div class="col-sm-2">
             <label for="">Sub Cuenta</label>
             <input type="text" class="form-control" id="sub_cuenta">
        </div>
        <div class="col-sm-2">
             <label for="">Ssub Cuenta</label>
             <input type="text" class="form-control" onblur="agregarcuentas()" id="ssub_cuenta">
        </div>
 
        
        <div class="col-sm-2">
             <label for="">Referencia</label>
             <input type="text" class="form-control" id="referen">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-5">
             <label for="">Nombre Cuenta</label>
             <input type="text" class="form-control" id="nom_cuenta">
        </div>
        <div class="col-sm-3">
             <label for="">Concepto</label>
             <input type="text" class="form-control" id="concep">
        </div>
        <div class="col-sm-2">
              <label for="">Monto</label>
              <input type="text" class="form-control" id="monto" onkeypress="return soloNumeros(event,this)">
        </div>
        <div class="col-sm-1">
              <label for="">+/-</label>
              <input type="text" class="form-control" onblur="agregarasiento()" id="signo" onkeypress="return soloSignos(event)" maxlength="1">
        </div>
        <div class="col-sm-1">
        <br>
            <button type="button" class="btn btn-success" title="Agregar" onclick="agregarasiento()"><span class="fa fa-plus"></span></button>
        </div>
    </div>

    <br>

    <div id="div1">
      <table id="asiento_conta" class="table table-bordered table-hover" cellspacing="0" width="100%">
         <thead style="background-color:#5a5a5a; color:white;">
              <tr>
                  <th>
                    <center>
                      <button type="button" class="btn btn-danger btn-sm" value="Delete Row" onclick="deleteRow('asiento_conta');"><span class="fa fa-times"></span></button>
                      <button type="button" class="btn btn-success btn-sm" onclick="editRow('asiento_conta');"><span class="fa fa-pencil"></span></button>
                    </center>
                  </th>
                  <th>Cuenta</th>
                  <th>Sub Cta</th>
                  <th>Ssub Cta</th>
                  <th>Referencia</th>
                  <th>Nombre Cuenta</th>
                  <th>Concepto</th>
                  <th>Monto</th>
                  <th>+/-</th>
              </tr>
         </thead>
         <?php
            if(isset($datos) && count($datos) > 0)
            {
                foreach($datospoliza as $row)
                {
                    echo ('<tr><td align="center"><input type="checkbox"></td>');
                    echo ('<td>'.$row['cuenta'].'</td>');
                    echo ('<td>'.$row['sub_cta'].'</td>');
                    echo ('<td>'.$row['ssub_cta'].'</td>');
                    echo ('<td>'.$row['referencia'].'</td>');
                    echo ('<td>'.$row['nombre_cuenta'].'</td>');
                    echo ('<td>'.$row['concepto'].'</td>');
                    echo ('<td>'.number_format($row['monto'],2,'.',',').'</td>');
                    echo ('<td>'.$row['c_a'].'</td>');
                    echo ('</tr>');
                }
            }
         ?>
         <tbody>
         </tbody>
      </table>
    </div>
</div>
    <div class="panel-footer">
                <div class="row">
                <div class="col-sm-8"></div>
                    <div class="col-sm-1">
                    <label for="">+</label>
                    <input type="text" readonly class="form-control" value="<?php echo isset($montopositivo) ? $montopositivo : '0.00' ?>" id="positivo" name="positivo">
                    </div>
                    <div class="col-sm-1">
                    <label for="">-</label>
                    <input type="text" readonly class="form-control" value="<?php echo isset($montonegativo) ? $montonegativo : '0.00' ?>" id="negativo" name="negativo">
                    </div>
                    <div class="col-sm-1">
                    <label for="">=</label>
                    <input type="text" readonly class="form-control" value="<?php echo isset($totalmontopoliza) ? $totalmontopoliza : '0.00' ?>" id="totalpoliza" name="totalpoliza">
                    </div>
                </div>
            </div>
        </div>
        </div>

<center>
    <button type="button" class="btn btn-success btn-lg" onclick="recogerDatosPoliza('asiento_conta')" ><span class="fa fa-floppy-o"></span> Guardar</button>
    <a href="<?php echo base_url().'catalogos/Polizasdiarias/index'?>" class="btn btn-danger btn-lg" role="button"><span class="fa fa-times"></span> Cancelar</a>
</center>

<script>
function seleccionarcuneta(cuenta,subcta,nombre,ssubcta)
{
    document.getElementById('cuenta').value = cuenta;
    document.getElementById('sub_cuenta').value = subcta;
    document.getElementById('nom_cuenta').value = nombre;
    document.getElementById('ssub_cuenta').value = ssubcta;
    $('#myModalCuentas').modal('hide');
    document.getElementById('ssub_cuenta').focus();
}
function abrircuentaspagar()
{
    verTabla('<?php echo $rfc ?>','<?php echo $tipo_letra?>');
    $('#myModalCuentasPagar').modal('show');
}
function abrirregistropago()
{
   // document.getElementById('monto_pago').value = document.getElementById('montopoli').value;
    document.getElementById('fechapago').value = document.getElementById('fechatrabajo').value;
    $('#myModalregistroPagos').modal('show');
}
function recogerDatosPoliza(tableID)
{
    var tol = document.getElementById('totalpoliza').value;
    var mes = '<?php echo $_SESSION["mes"]?>';
    var ano = '<?php echo $_SESSION["ano"]?>';
    var fecha = document.getElementById('fechatrabajo').value;
    var fechadivi = fecha.split('-');
    var fechaano = fechadivi[0];
    var fechames = fechadivi[1];

    if(mes == fechames && ano == fechaano)
    {
         if(tol == 0)
         {
                //cabezara poliza
                    var id = document.getElementById('identi').value;
                    var tipo_movimiento = 'O';
                    var numero_movimiento = document.getElementById('no_mov').value;
                    var fechapoli = document.getElementById('fechatrabajo').value;
                    var conceptopoli = document.getElementById('concepto').value;
                //   var ca_poli = document.getElementById('signopoli').value;
                //detalle poliza

                var xyz = false;    var table = x(tableID);
                var tipo_mov = [];  var no_banco = [];      var no_mov = [];
                var ren = [];       var cuenta = [];        var sub_cta = [];
                var monto = [];     var c_a = [];           var fecha = [];
                var concepto = [];  var referencia = [];    var nombre_cuenta = [];
                var rowCount = table.rows.length;           var ssub_cta = [];

                for(var i = 0; i < rowCount; i++)
                {
                    tipo_mov[i] = 'O';
                    no_banco[i] = 0;
                    no_mov[i] = document.getElementById('no_mov').value;
                    ren[i] = '';
                    cuenta[i] = table.rows[i].cells[1].innerHTML;
                    sub_cta[i] = table.rows[i].cells[2].innerHTML;
                    ssub_cta[i] = table.rows[i].cells[3].innerHTML;
                    monto[i] = table.rows[i].cells[7].innerHTML;
                    c_a[i] = table.rows[i].cells[8].innerHTML;
                    fecha[i] = fechapoli;
                    concepto[i] = table.rows[i].cells[6].innerHTML;
                    referencia[i] = table.rows[i].cells[4].innerHTML;
                    nombre_cuenta[i] = table.rows[i].cells[5].innerHTML;
                }
                if(rowCount==1)
                {
                    var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'La poliza debe contener al menos 2 asiento.'}); 
                        xyz=true;
                }

                if(xyz == false)
                {
                    $.ajax({
                        type:"POST",
                        url: baseurl+"catalogos/Polizasdiarias/guardarpoliza",
                        data: {id:id,tipo_movimiento:tipo_movimiento,numero_movimiento:numero_movimiento,fechapoli:fechapoli,
                        conceptopoli:conceptopoli,tipo_mov:tipo_mov,no_banco:no_banco,no_mov:no_mov,ren:ren,ssub_cta:ssub_cta,
                        cuenta:cuenta,sub_cta:sub_cta,monto:monto,c_a:c_a,fecha:fecha,concepto:concepto,referencia:referencia,nombre_cuenta:nombre_cuenta},
                        dataType:"html",
                        success:function(msg)
                        {
                            msg = JSON.parse(msg);
                           if(msg[0].mensaje == 'Insertado Correctamente' || msg[0].mensaje == 'Actualizado Correctamente')
                           {
                               var agre_pag = document.getElementById('agregar_pago').checked;
                               if(agre_pag == true)
                               {
                                   var valor_pago = guardar_pago_regi('docto_relacionado');
                                   response=JSON.parse(valor_pago);
                                   if(response.success == true)
                                   {
                                    swal('Tipo: '+tipo_movimiento+' Consecutivo: '+numero_movimiento,msg[0].mensaje,"success");
                                    setTimeout(function(){ window.location.href=baseurl+'catalogos/Polizasdiarias/index'; }, 500);
                                   }
                                   else
                                   {
                                       swal("Advertencia",response.mensaje,'warning');
                                   }
                               }
                               else
                               {
                                   swal('Tipo: '+tipo_movimiento+' Consecutivo: '+numero_movimiento,msg[0].mensaje,"success");
                                   setTimeout(function(){ window.location.href=baseurl+'catalogos/Polizasdiarias/index'; }, 500);
                               }
                           }
                           else
                           {
                               swal("Error",msg[0].mensaje,"error");
                           }
                        }
                    });
                }
         }
         else
         {
              swal("Advertencia","No cuadra el asiento","warning");
         }
    }
    else
    {
        var n = noty({ layout:'topRight',type: 'warning', theme: 'relax', text: 'No esta dentro del mismo ejersicio de trabajo'});
    }
}
function editRow(tableID)
  {
    try
    {
      var table = x(tableID);
      var rowCount = table.rows.length;
      for(var i=0; i<rowCount; i++)
      {
        var row = table.rows[i];
        var chkbox = row.cells[0].childNodes[0];
        if(null != chkbox && true == chkbox.checked)
        {
           x("cuenta").value = table.rows[i].cells[1].innerHTML;
           x("sub_cuenta").value = table.rows[i].cells[2].innerHTML;
           x("ssub_cuenta").value = table.rows[i].cells[3].innerHTML;
           x("referen").value = table.rows[i].cells[4].innerHTML;
           x("nom_cuenta").value = table.rows[i].cells[5].innerHTML;
           x("concep").value = table.rows[i].cells[6].innerHTML;
           x("monto").value = table.rows[i].cells[7].innerHTML.replaceAll(",", "");
           x("signo").value = table.rows[i].cells[8].innerHTML;
           
          var signo = row.cells[8].innerHTML;
          var posit = parseFloat(document.getElementById('positivo').value);
          var nega = parseFloat(document.getElementById('negativo').value);
          
          var monto = row.cells[7].innerHTML;
          var monto = parseFloat(monto.replaceAll(",", ""));     
        //  console.log(monto);     
          
          if(signo == '+')
          {
              var total = posit - monto;
              document.getElementById('positivo').value = total.toFixed(2);
          }
          else
          {

              var total = nega - monto;
              document.getElementById('negativo').value = total.toFixed(2);
          }

          var posit2 = parseFloat(document.getElementById('positivo').value);
          var nega2 = parseFloat(document.getElementById('negativo').value);

          var total2 = posit2-nega2;
                      
          document.getElementById('totalpoliza').value = total2.toFixed(2);
        
          table.deleteRow(i);

      }}}  catch(e) { alert(e); }
  }
function deleteRow(tableID)
{
  try
  {
    var table = x(tableID);
    var rowCount = table.rows.length;
    for(var i=1; i<rowCount; i++)
    {
      var row = table.rows[i];
      var chkbox = row.cells[0].childNodes[0];
      if(null != chkbox && true == chkbox.checked)
      {

          var signo = row.cells[8].innerHTML;
          var posit = parseFloat(document.getElementById('positivo').value);
          var nega = parseFloat(document.getElementById('negativo').value);
          
          var monto = row.cells[7].innerHTML;
          var monto = parseFloat(monto.replaceAll(",", ""));               
          
          if(signo == '+')
          {
              var total = posit - monto;
              document.getElementById('positivo').value = total.toFixed(2);
          }
          else
          {
              var total = nega - monto;
              document.getElementById('negativo').value = total.toFixed(2);
          }

          var posit2 = parseFloat(document.getElementById('positivo').value);
          var nega2 = parseFloat(document.getElementById('negativo').value);

          var total2 = posit2-nega2;
                      
          document.getElementById('totalpoliza').value = total2.toFixed(2);
        
          table.deleteRow(i);

      }
    }
  } catch(e) { alert(e); }
}
function agregarcuentas()
{
    var cuen = document.getElementById('cuenta').value;
    var subcuen = document.getElementById('sub_cuenta').value;
    var ssubcuen = document.getElementById('ssub_cuenta').value;

    if(cuen == '')
    {
        var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Falto de agregar la cuenta.'});
    }
    else if(subcuen == '')
    {
        var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Falto agregar la Sub cuenta.'});
    }
    else if(ssubcuen == '')
    {
        var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Falto agregar la Ssub cuenta.'});
    }
    else
    {
        jQuery.ajax({
            type:"POST",
            url: baseurl + 'catalogos/Cuentas/get_cuenta',
            data: {cuen:cuen,subcuen:subcuen,ssubcuen:ssubcuen},
            dataType:"html",
            success:function(response)
            {
                response=JSON.parse(response);
                if(response.length > 0)
                {
                    document.getElementById('nom_cuenta').value = response[0].nombre;
                    
                    var posit = parseFloat(document.getElementById('positivo').value);
                    var nega = parseFloat(document.getElementById('negativo').value);
                    if(posit > nega)
                    {
                    var neu = document.getElementById('totalpoliza').value;
                    var sig = '-';
                    }
                    else
                    {
                    var neu = (-1) * document.getElementById('totalpoliza').value;
                    var sig = '+';
                    }
                    document.getElementById('monto').value = neu;
                    document.getElementById('signo').value = sig;
                   // document.getElementById('no_prov_factu').value = document.getElementById('noprov').value;
                   // document.getElementById('concep').value = document.getElementById('nombre').value;
                }
                else
                {
                    swal("Advertencia","No existe la cuenta",'warning');
                    document.getElementById('cuenta').value = '';
                    document.getElementById('sub_cuenta').value = '';
                    document.getElementById('ssub_cuenta').value = '';
                    document.getElementById('cuenta').focus();
                }
            }
        });
    }
}
function agregarasiento()
{

    var monto = document.getElementById('monto').value;
    if(monto == '')
    {
        swal('Advertencia','Agregue una cuenta','warning');
    }
    else
    {
        var tbody = document.getElementById('asiento_conta').getElementsByTagName("TBODY")[0];
                        var row = document.createElement("TR")

                        let nf = new Intl.NumberFormat('en-US');
                        
                        var element1 = document.createElement("input");
                        element1.type = "checkbox";
                        element1.name="chkbox[]"; 
                        
                        
                        var td0 = document.createElement("TD")
                        td0.style.textAlign = 'center';
                        td0.appendChild(element1)
                        var td1 = document.createElement("TD")
                        td1.appendChild(document.createTextNode(document.getElementById('cuenta').value))
                        var td2 = document.createElement("TD")
                        td2.appendChild(document.createTextNode(document.getElementById('sub_cuenta').value))
                        var td3 = document.createElement("TD")
                        td3.appendChild(document.createTextNode(document.getElementById('ssub_cuenta').value))
                        var td4 = document.createElement("TD")
                        td4.appendChild(document.createTextNode(document.getElementById('referen').value))
                        var td5 = document.createElement("TD")
                        td5.appendChild(document.createTextNode(document.getElementById('nom_cuenta').value))
                        var td6 = document.createElement("TD")
                        td6.appendChild(document.createTextNode(document.getElementById('concep').value))
                        var td7 = document.createElement("TD")
                        td7.appendChild(document.createTextNode(document.getElementById('monto').value == '' ? nf.format(neu) : nf.format(document.getElementById('monto').value)))
                        var td8 = document.createElement("TD")
                        td8.appendChild(document.createTextNode(document.getElementById('signo').value))

                        row.appendChild(td0);
                        row.appendChild(td1);
                        row.appendChild(td2);
                        row.appendChild(td3);
                        row.appendChild(td4);
                        row.appendChild(td5);
                        row.appendChild(td6);
                        row.appendChild(td7);
                        row.appendChild(td8);
                        tbody.appendChild(row);

                        var signo = document.getElementById('signo').value;
                        var posit = parseFloat(document.getElementById('positivo').value);
                        var nega = parseFloat(document.getElementById('negativo').value);
                        
                        var monto = parseFloat(document.getElementById('monto').value);

                        if(signo == '+')
                        {
                            var total = posit + monto;
                            document.getElementById('positivo').value = total.toFixed(2);
                        }
                        else
                        {
                            var total = nega + monto;
                            document.getElementById('negativo').value = total.toFixed(2);
                        }

                        var posit2 = parseFloat(document.getElementById('positivo').value);
                        var nega2 = parseFloat(document.getElementById('negativo').value);

                        var total2 = posit2-nega2;
                        
                        document.getElementById('totalpoliza').value = total2.toFixed(2);
                        

                        document.getElementById('cuenta').value = '';
                        document.getElementById('sub_cuenta').value = '';
                        document.getElementById('ssub_cuenta').value = '';
                        document.getElementById('referen').value = '';
                        document.getElementById('nom_cuenta').value = '';
                        document.getElementById('concep').value = '';
                        document.getElementById('monto').value = '';
                        document.getElementById('signo').value = '';
    }

}
function soloNumeros(evt,input)
 {
    var key = window.Event ? evt.which : evt.keyCode;    
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter(tempValue)=== false){
            return false;
        }else{       
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {     
              return true;              
          }else if(key == 46){
                if(filter(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
          }else{
              return false;
          }
    }
 }
 function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }
    
}
    function soloSignos(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toUpperCase();
       letras = "+-";
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
    }
</script>