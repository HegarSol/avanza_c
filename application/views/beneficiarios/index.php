<?php
if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
  $desabilitado="";
  if (isset($errores) && $errores!=""){
    for($i= 0; $i<count($errores); $i++)
    { echo "<script> var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: '".$errores[$i]."'});</script>"; }
  }
 
  $this->load->view('beneficiarios/modales/CuentasPagar');
  $this->load->view('beneficiarios/modales/Autorizacion');
  $this->load->view('beneficiarios/modales/ModalAsientoContable');
  $this->load->view('beneficiarios/modales/TablaCuentasOperaciones');
  $this->load->view('beneficiarios/modales/TablaCuentasOperacionesProvision');


?>

<div class="container-fluid">
   <div class="panel panel-default">
       <div class="panel-heading">
           <form class="form-horizontal">
               <div class="form-group">
                  &nbsp;&nbsp;
                  <a href="<?php echo base_url();?>catalogos/Beneficiarios/agregar" class="btn btn-success btn-lg" role="button"><span class="glyphicon glyphicon-plus"></span> Agregar Beneficiario</a>
                  <!-- <a href="<?php echo base_url();?>catalogos/Beneficiarios/estafeta" class="btn btn-warning btn-lg"><span class="fa fa-folder-open-o"></span> Estafeta</a> -->
                  <button type="button" onclick="beneestafe()" class="btn btn-warning btn-lg"><span class="fa fa-folder-open-o"></span> Estafeta</button>

                  <?php
                  if($permisotipo == 'SU' || $permisotipo == 'admin')
                  {
                  ?>
                  <button type="button" onclick="abrirautorizacion()" class="btn btn-info btn-lg"><span class="fa fa-check"></span> Autorización</button>
                  <?php
                  }
                  ?>
               </div>
           </form>
       </div>
       <div class="panel-body">
         <table id="Beneficiarios" class="stripe row-border responsive nowrap" cellspacing="0" width="100%">
             <thead style="background-color:#5a5a5a; color:white;">
                <tr>
                    <th>No Prov</th>
                    <th>Nombre</th>
                    <th>RFC</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>Tipo Proveedor</th>
                    <th>Acciones</th>
                </tr>
             </thead>
         </table>
       </div>
       <div class="panel-footer">
       </div>
   </div>
</div>


<script>
function abrirautorizacion()
{
         verTablaAutorizacion('<?php echo $rfc?>');
         $('#myModalAutorizacion').modal('show');  
}
function abrircuentaspagar(rfcReceptor,no_prov,nombre,rfcEmisor,direccion,tipo_prove)
{

               document.getElementById('numprov').innerHTML = no_prov;
               document.getElementById('nomprov').innerHTML = nombre;
               document.getElementById('rfcprov').innerHTML = rfcEmisor;
               document.getElementById('direprov').innerHTML = direccion;
               document.getElementById('tipoproveedor').value = tipo_prove;
               var forma2 = 'D';
               verTabla(rfcReceptor,forma2);

              $('#myModalCuentasPagar').modal('show');
          
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

          var signo = row.cells[9].innerHTML;
          var posit = parseFloat(document.getElementById('positivo').value);
          var nega = parseFloat(document.getElementById('negativo').value);
          
          var monto = parseFloat(row.cells[8].innerHTML);          
          
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
           x("no_prov_factu").value = table.rows[i].cells[4].innerHTML;
           x("referen").value = table.rows[i].cells[5].innerHTML;
           x("nom_cuenta").value = table.rows[i].cells[6].innerHTML;
           x("concep").value = table.rows[i].cells[7].innerHTML;
           x("monto").value = table.rows[i].cells[8].innerHTML;
           x("signo").value = table.rows[i].cells[9].innerHTML;
           
          var signo = row.cells[9].innerHTML;
          var posit = parseFloat(document.getElementById('positivo').value);
          var nega = parseFloat(document.getElementById('negativo').value);
          
          var monto = parseFloat(row.cells[8].innerHTML);          
          
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
function agregarasiento()
{

    var monto = document.getElementById('cuenta').value;
    var sub_cue = document.getElementById('sub_cuenta').value;
    var ssub_cue = document.getElementById('ssub_cuenta').value;
    if(monto == '' || sub_cue == '' || ssub_cue == '')
    {
        swal('Advertencia','Agregue la cuenta, sub cuenta y ssub cuenta','warning');
    }
    else
    {
        var tbody = document.getElementById('asiento_conta').getElementsByTagName("TBODY")[0];
                        var row = document.createElement("TR")
                        
                        var element1 = document.createElement("input");
                        element1.type = "checkbox";
                        element1.name="chkbox[]"; 
                        
                        if(document.getElementById('monto').value == '' || document.getElementById('monto').value == 0)
                        {
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
                        }
                        
                        var td0 = document.createElement("TD")
                        td0.style.textAlign = 'center';
                        td0.appendChild(element1)
                        var td1 = document.createElement("TD")
                        td1.appendChild(document.createTextNode(document.getElementById('cuenta').value))
                        var td2 = document.createElement("TD")
                        td2.appendChild(document.createTextNode(document.getElementById('sub_cuenta').value))
                        var td9 = document.createElement("TD")
                        td9.appendChild(document.createTextNode(document.getElementById('ssub_cuenta').value))
                        var td3 = document.createElement("TD")
                        td3.appendChild(document.createTextNode(document.getElementById('no_prov_factu').value))
                        var td4 = document.createElement("TD")
                        td4.appendChild(document.createTextNode(document.getElementById('referen').value))
                        var td5 = document.createElement("TD")
                        td5.appendChild(document.createTextNode(document.getElementById('nom_cuenta').value))
                        var td6 = document.createElement("TD")
                        td6.setAttribute("contenteditable","true");
                        td6.appendChild(document.createTextNode(document.getElementById('concep').value))
                        var td7 = document.createElement("TD")
                        td7.appendChild(document.createTextNode(document.getElementById('monto').value == '' ? neu : document.getElementById('monto').value))
                        var td8 = document.createElement("TD")
                        td8.appendChild(document.createTextNode(document.getElementById('signo').value == '' ? sig : document.getElementById('signo').value))

                        row.appendChild(td0);
                        row.appendChild(td1);
                        row.appendChild(td2);
                        row.appendChild(td9);
                        row.appendChild(td3);
                        row.appendChild(td4);
                        row.appendChild(td5);
                        row.appendChild(td6);
                        row.appendChild(td7);
                        row.appendChild(td8);
                        tbody.appendChild(row);

                        var signo = document.getElementById('signo').value == '' ? sig : document.getElementById('signo').value;
                        var posit = parseFloat(document.getElementById('positivo').value);
                        var nega = parseFloat(document.getElementById('negativo').value);
                        
                        var monto = document.getElementById('monto').value == '' ? parseFloat(neu) : parseFloat(document.getElementById('monto').value);
       
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
                        document.getElementById('no_prov_factu').value = '0';
                        document.getElementById('referen').value = '';
                        document.getElementById('nom_cuenta').value = '';
                        document.getElementById('concep').value = '';
                        document.getElementById('monto').value = '';
                        document.getElementById('signo').value = '';

                        document.getElementById('cuenta').focus();
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
                    document.getElementById('no_prov_factu').value = document.getElementById('noprov').value;
                    document.getElementById('concep').value = document.getElementById('nombre').value;
                }
                else
                {
                    swal("Advertencia","No existe la cuenta",'warning');
                }
            }
        });
    }
}
function beneestafe()
{
// var oTT = $.fn.dataTable.TableTools.fnGetInstance("Beneficiarios");
//             var aData = oTT.fnGetSelectedData();
//             if (aData.length != 1) 
//                 { 
//                    var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Seleccione un registro.'});
//                 }
//             else
//             {
             // console.log(aData[0][0]);
              location.href="<?php echo base_url();?>catalogos/Beneficiarios/estafeta";
           // }
}
function verTablaAutorizacion(rfc)
{
  jQuery.ajax({
       url: baseurl+"catalogos/Beneficiarios/getAutorizacion",
       type:"POST",
       data:{rfc:rfc},
       dataType:"html",
       success:function(data)
       {
          if(data == 'No se encontraron registros')
          {
            $('#espacioEstafetaporpagar').innerHTML = 'No se encontraron registros';
          }
          else
          {
              data=JSON.parse(data);
              var totaldedua = 0;

              $('#tblAutorizacion tbody').empty();
              document.getElementById('total_pagar2').value = '';

              for(var i in data)
              {

                if(data[i].marca == 0)
                {
                   var btnp = document.createElement("INPUT");
                   btnp.setAttribute("type","button");
                   btnp.setAttribute('onclick',"descargarpdf('"+data[i].uuid+"')");
                   btnp.className = 'btn btn-danger';
                   btnp.value = 'PDF'
                }
                else
                {
                   var btnp = '';
                }

                if(data[i].marca == 0)
                {
                   var btn2 = document.createElement("INPUT");
                   btn2.setAttribute("type","button");
                   btn2.setAttribute('onclick',"descargarxml('"+data[i].uuid+"')");
                   btn2.className = 'btn btn-primary';
                   btn2.value = 'XML'
                }
                else
                {
                    var btn2 = '';
                }

                   if(data[i].marca == 0)
                   {
                    var btn3 = document.createElement('input');
                    btn3.type = 'checkbox';
                    btn3.id = 'check2';
                    btn3.setAttribute('onclick','checarsumar(this)');
                    btn3.className = 'form-control';
                   }
                   else
                   {
                      var btn3 = '';
                   }
                   var tbody = document.getElementById('tblAutorizacion').getElementsByTagName('TBODY')[0];
                   var row = document.createElement('TR')
                   var td0 = document.createElement('TD')
                   if(data[i].marca == 0)
                   {
                    td0.appendChild(btn3)
                   }
                   else
                   {
                    td0.appendChild(document.createTextNode(''))
                   }
                   var td1 = document.createElement('TD')
                   td1.appendChild(document.createTextNode(data[i].rfcpro))
                   var td2 = document.createElement('TD')
                   td2.appendChild(document.createTextNode(data[i].folio))
                   var td3 = document.createElement('TD')
                   td3.appendChild(document.createTextNode(data[i].fecha))
                   var td4 = document.createElement('TD')
                   td4.appendChild(document.createTextNode(data[i].fecha_pago))
                   var td5 = document.createElement('TD')
                   td5.appendChild(document.createTextNode(data[i].total))
                   var td6 = document.createElement('TD')
                   td6.appendChild(document.createTextNode(data[i].metodo_pago))
                   var td7 = document.createElement('TD')
                   td7.appendChild(document.createTextNode(data[i].uuid))
                   var td8 = document.createElement('TD')
                   if(data[i].marca == 0)
                   {
                     td8.appendChild(document.createTextNode(data[i].antiguedad+' días'))
                   }
                   else
                   {
                    td8.appendChild(document.createTextNode(''))
                   }
                   var td9 = document.createElement('TD')
                   
                   if(data[i].marca == 0)
                   {
                       td9.appendChild(btn2)
                   }
                   else
                   {
                       td9.appendChild(document.createTextNode(''))
                   }
                   var td10 = document.createElement('TD')
                   
                   if(data[i].marca == 0)
                   {
                       td10.appendChild(btnp)
                   }
                   else
                   {
                       td10.appendChild(document.createTextNode(''))
                   }
                   
                   if(data[i].marca == 0)
                   {
                     totaldedua = totaldedua + parseFloat(data[i].total);
                   }

                   row.appendChild(td0);
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
                   tbody.appendChild(row);
              }
              document.getElementById('total_deuda2').value = totaldedua.toFixed(2);
          }
       },
       error:function()
       {
        var n = noty({text: 'Error al recuperar la informacion', type: 'error', theme: 'relax'});
       }
    });
}
function checarsumar()
{

   var campos = '';
   var total = parseFloat(0);
          $("input[type=checkbox]:checked").each(function(){
                var recibo = [];

                var monto = parseFloat($(this).parent().parent().find('td').eq(5).html());
                total += monto;             

            });
            document.getElementById('total_pagar2').value = total.toFixed(2);
}
function descargarxml(uuid)
{
  window.open("https://avanzab.hegarss.com/comprobantes/descargarXML/" + uuid,'_blank');  
}
function descargarpdf(uuid)
{
  window.open("https://avanzab.hegarss.com/comprobantes/descargarPDF/" + uuid,'_blank');
}
</script>