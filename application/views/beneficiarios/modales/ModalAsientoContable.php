<div class="modal fade" id="myModalasientoContable" role="dialog" >
<div class="modal-dialog modal-lg" id="mdialTamanio">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" id="cerrarclick2" name="cerrarclick2" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <center><h1 class="modal-title">Asiento contable</h1></center>

            <h2>Póliza: <span id="polizacientocontable" name="polizacientocontable"></span></h2>
          <div class="row">
            <div class="col-md-2">
               <input type="date" id="fechacontable" name="fechacontable" class="form-control">
            </div>
            </div>
        </div>
        <div class="modal-body">
             <input type="text" id="id_asiento_contable" readonly name="id_asiento_contable" hidden>
             <input type="text" id="tipo_asiento_contable" readonly name="tipo_asiento_contable" hidden>
             <input type="text" id="banco_asiento_contable" readonly name="banco_asiento_contable" hidden>
             <input type="text" id="mov_asiento_contable" readonly name="mov_asiento_contable" hidden>
            <div class="row">
                <div class="col-sm-2">
                    <label for="">Cuenta</label>&nbsp;&nbsp;<a class="glyphicon glyphicon-search" onclick="abrircuentasprovision()"></a>
                    <input type="text" maxlength="3" class="form-control" id="cuenta_provision">
                </div>
                <div class="col-sm-2">
                    <label for="">Sub Cuenta</label>
                    <input type="text" class="form-control" id="sub_cuenta_provision">
                </div>
                <div class="col-sm-2">
                    <label for="">Ssub Cuenta</label>
                    <input type="text" class="form-control" onblur="agregarcuentas_provision()" id="ssub_cuenta_provision">
                </div>
                <div class="col-sm-2">
                    <label for="">No prov</label>
                    <!-- &nbsp;&nbsp;<a class="glyphicon glyphicon-search" data-toggle="modal" data-target="#myModalBenefi3"></a> -->
                    <input type="text" class="form-control" id="no_prov_factu_provision">
                </div>
                <div class="col-sm-2">
                    <label for="">Referencia</label>
                    <input type="text" class="form-control" id="referen_provision">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-5">
                    <label for="">Nombre cuenta</label>
                    <input type="text" class="form-control" tabindex="3" id="nom_cuenta_provision" readonly>
                </div>
                <div class="col-sm-3">
                    <label for="">Concepto</label>
                    <input type="text" class="form-control" id="concep_provision">
                </div>
                <div class="col-sm-2">
                    <label for="">Monto</label>
                    <input type="text" class="form-control" id="monto_provision" onkeypress="return soloNumeros(event,this)">
                </div>
                <div class="col-sm-1">
                    <label for="">+/-</label>
                    <input type="text" class="form-control" onblur="agregarasiento_provision()" id="signo_provision" onkeypress="return soloSignos(event)" maxlength="1">
                </div>
                <div class="col-sm-1">
                <br>
                    <button type="button" class="btn btn-success" title="Agregar" onclick="agregarasiento_provision()"><span class="fa fa-plus"></span></button>
                </div>
            </div>

            <br>

            <table id="asiento_conta_provision" class="table table-bordered table-hover"  cellspacing="0" width="100%">
             <thead style="background-color:#5a5a5a; color:white;">
                <tr>
                    <th>
                     <center>
                        <button type="button"  class="btn btn-danger btn-sm" value="Delete Row" onclick="deleteRowprovision('asiento_conta_provision');"><span class="fa fa-times"></span></button>
                        <button type="button" class="btn btn-success btn-sm" onclick="editRowprovision('asiento_conta_provision');" ><span class="fa fa-pencil"></span></button>
                     </center>
                    </th>
                    <th>Cuenta</th>
                    <th>Sub cta</th>
                    <th>Ssub cta</th>
                    <th>No. prov</th>
                    <th>Referencia</th>
                    <th>Nombre cuenta</th>
                    <th>Concepto</th>
                    <th>Monto</th>
                    <th>+/-</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
         </table>

        </div>
        <div class="modal-footer">
        <div class="row">
               <div class="col-sm-8"></div>
                <div class="col-sm-1">
                   <label for="">+</label>
                   <input type="text" readonly class="form-control" value="0" id="positivo_provision" name="positivo_provsion">
                </div>
                <div class="col-sm-1">
                   <label for="">-</label>
                   <input type="text" readonly class="form-control" value="0" id="negativo_provision" name="negativo_provision">
                </div>
                <div class="col-sm-1">
                   <label for="">=</label>
                   <input type="text" readonly class="form-control" value="0" id="totalpoliza_provision" name="totalpoliza_provision">
                </div>
            </div>
            <br>
            <br>
            <button type="button" class="btn btn-success" onclick="guardarasientoprovicion('asiento_conta_provision')">Guardar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>
</div>

<script>
     function editRowprovision(tableID)
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
           x("cuenta_provision").value = table.rows[i].cells[1].innerHTML;
           x("sub_cuenta_provision").value = table.rows[i].cells[2].innerHTML;
           x("ssub_cuenta_provision").value = table.rows[i].cells[3].innerHTML;
           x("no_prov_factu_provision").value = table.rows[i].cells[4].innerHTML;
           x("referen_provision").value = table.rows[i].cells[5].innerHTML;
           x("nom_cuenta_provision").value = table.rows[i].cells[6].innerHTML;
           x("concep_provision").value = table.rows[i].cells[7].innerHTML;
           x("monto_provision").value = table.rows[i].cells[8].innerHTML;
           x("signo_provision").value = table.rows[i].cells[9].innerHTML;
           
          var signo = row.cells[9].innerHTML;
          var posit = parseFloat(document.getElementById('positivo_provision').value);
          var nega = parseFloat(document.getElementById('negativo_provision').value);
          
          var monto = parseFloat(row.cells[8].innerHTML);          
          
          if(signo == '+')
          {
              var total = posit - monto;
              document.getElementById('positivo_provision').value = total.toFixed(2);
          }
          else
          {
              var total = nega - monto;
              document.getElementById('negativo_provision').value = total.toFixed(2);
          }

          var posit2 = parseFloat(document.getElementById('positivo_provision').value);
          var nega2 = parseFloat(document.getElementById('negativo_provision').value);

          var total2 = posit2-nega2;
                      
          document.getElementById('totalpoliza_provision').value = total2.toFixed(2);
        
          table.deleteRow(i);

      }}}  catch(e) { alert(e); }
  }
function deleteRowprovision(tableID)
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
          var posit = parseFloat(document.getElementById('positivo_provision').value);
          var nega = parseFloat(document.getElementById('negativo_provision').value);
          
          var monto = parseFloat(row.cells[8].innerHTML);          
          
          if(signo == '+')
          {
              var total = posit - monto;
              document.getElementById('positivo_provision').value = total.toFixed(2);
          }
          else
          {
              var total = nega - monto;
              document.getElementById('negativo_provision').value = total.toFixed(2);
          }

          var posit2 = parseFloat(document.getElementById('positivo_provision').value);
          var nega2 = parseFloat(document.getElementById('negativo_provision').value);

          var total2 = posit2-nega2;
                      
          document.getElementById('totalpoliza_provision').value = total2.toFixed(2);
        
          table.deleteRow(i);

      }
    }
  } catch(e) { alert(e); }
}
    function agregarasiento_provision()
    {
        var monto = document.getElementById('cuenta_provision').value;
    var sub_cue = document.getElementById('sub_cuenta_provision').value;
    var ssub_cue = document.getElementById('ssub_cuenta_provision').value;
    if(monto == '' || sub_cue == '' || ssub_cue == '')
    {
        swal('Advertencia','Agregue la cuenta, sub cuenta y ssub cuenta','warning');
    }
    else
    {
        var tbody = document.getElementById('asiento_conta_provision').getElementsByTagName("TBODY")[0];
                        var row = document.createElement("TR")
                        
                        var element1 = document.createElement("input");
                        element1.type = "checkbox";
                        element1.name="chkbox[]"; 
                        
                        if(document.getElementById('monto_provision').value == '' || document.getElementById('monto_provision').value == 0)
                        {
                            var posit = parseFloat(document.getElementById('positivo_provision').value);
                            var nega = parseFloat(document.getElementById('negativo_provision').value);
                            if(posit > nega)
                            {
                                var neu = document.getElementById('totalpoliza_provision').value;
                                var sig = '-';
                            }
                            else
                            {
                                var neu = (-1) * document.getElementById('totalpoliza_provision').value;
                                var sig = '+';
                            }
                        }
                        
                        var td0 = document.createElement("TD")
                        td0.style.textAlign = 'center';
                        td0.appendChild(element1)
                        var td1 = document.createElement("TD")
                        td1.appendChild(document.createTextNode(document.getElementById('cuenta_provision').value))
                        var td2 = document.createElement("TD")
                        td2.appendChild(document.createTextNode(document.getElementById('sub_cuenta_provision').value))
                        var td9 = document.createElement("TD")
                        td9.appendChild(document.createTextNode(document.getElementById('ssub_cuenta_provision').value))
                        var td3 = document.createElement("TD")
                        td3.appendChild(document.createTextNode(document.getElementById('no_prov_factu_provision').value))
                        var td4 = document.createElement("TD")
                        td4.appendChild(document.createTextNode(document.getElementById('referen_provision').value))
                        var td5 = document.createElement("TD")
                        td5.appendChild(document.createTextNode(document.getElementById('nom_cuenta_provision').value))
                        var td6 = document.createElement("TD")
                        td6.setAttribute("contenteditable","true");
                        td6.appendChild(document.createTextNode(document.getElementById('concep_provision').value))
                        var td7 = document.createElement("TD")
                        td7.appendChild(document.createTextNode(document.getElementById('monto_provision').value == '' ? neu : document.getElementById('monto_provision').value))
                        var td8 = document.createElement("TD")
                        td8.appendChild(document.createTextNode(document.getElementById('signo_provision').value == '' ? sig : document.getElementById('signo_provision').value))

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

                        var signo = document.getElementById('signo_provision').value == '' ? sig : document.getElementById('signo_provision').value;
                        var posit = parseFloat(document.getElementById('positivo_provision').value);
                        var nega = parseFloat(document.getElementById('negativo_provision').value);
                        
                        var monto = document.getElementById('monto_provision').value == '' ? parseFloat(neu) : parseFloat(document.getElementById('monto_provision').value);
       
                            if(signo == '+')
                            {
                                var total = posit + monto;
                                document.getElementById('positivo_provision').value = total.toFixed(2);
                            }
                            else
                            {
                                var total = nega + monto;
                                document.getElementById('negativo_provision').value = total.toFixed(2);
                            }

                            var posit2 = parseFloat(document.getElementById('positivo_provision').value);
                            var nega2 = parseFloat(document.getElementById('negativo_provision').value);

                            var total2 = posit2-nega2;
                            
                            document.getElementById('totalpoliza_provision').value = total2.toFixed(2);
                        

                        document.getElementById('cuenta_provision').value = '';
                        document.getElementById('sub_cuenta_provision').value = '';
                        document.getElementById('ssub_cuenta_provision').value = '';
                        document.getElementById('no_prov_factu_provision').value = '0';
                        document.getElementById('referen_provision').value = '';
                        document.getElementById('nom_cuenta_provision').value = '';
                        document.getElementById('concep_provision').value = '';
                        document.getElementById('monto_provision').value = '';
                        document.getElementById('signo_provision').value = '';

                        document.getElementById('cuenta_provision').focus();
    }
    }
    function agregarcuentas_provision()
    {
        var cuen = document.getElementById('cuenta_provision').value;
    var subcuen = document.getElementById('sub_cuenta_provision').value;
    var ssubcuen = document.getElementById('ssub_cuenta_provision').value;

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
                    document.getElementById('nom_cuenta_provision').value = response[0].nombre;
                    
                    var posit = parseFloat(document.getElementById('positivo_provision').value);
                    var nega = parseFloat(document.getElementById('negativo_provision').value);
                    if(posit > nega)
                    {
                    var neu = document.getElementById('totalpoliza_provision').value;
                    var sig = '-';
                    }
                    else
                    {
                    var neu = (-1) * document.getElementById('totalpoliza_provision').value;
                    var sig = '+';
                    }
                    document.getElementById('monto_provision').value = neu;
                    document.getElementById('signo_provision').value = sig;
                    document.getElementById('no_prov_factu_provision').value = document.getElementById('noprov_provision').value;
                    document.getElementById('concep_provsion').value = document.getElementById('nombre_provision').value;
                }
                else
                {
                    swal("Advertencia","No existe la cuenta",'warning');
                }
            }
        });
    }
    }
    function abrircuentasprovision()
    {
        $('#myModalasientoContable').modal('hide');
        $('#myModalCuentasOperacionesProvision').modal('show');
    }
    function guardarasientoprovicion(tableID)
    {
            var xyz = false;   var table = x(tableID);  
            var tipo_mov = []; var no_banco = [];      var no_mov = [];
            var ren = [];      var cuenta = [];        var sub_cta = []; var ssub_cta = [];
            var monto = [];    var c_a = [];           var fecha = [];
            var concepto = []; var referencia = [];    var no_prov = [];
            var factrefe = []; var nombre_cuenta = [];
            var rowCount = table.rows.length;

            var totalpasivo = document.getElementById('totalpoliza_provision').value;

            for(var i = 0; i < rowCount; i++)
            {
                tipo_mov[i] = document.getElementById('tipo_asiento_contable').value;
                no_banco[i] = document.getElementById('banco_asiento_contable').value;
                no_mov[i] = document.getElementById('mov_asiento_contable').value;
                ren[i] = 0;
                cuenta[i] = table.rows[i].cells[1].innerHTML;
                sub_cta[i] = table.rows[i].cells[2].innerHTML;
                ssub_cta[i] = table.rows[i].cells[3].innerHTML;
                monto[i] = table.rows[i].cells[8].innerHTML;
                c_a[i] = table.rows[i].cells[9].innerHTML;
                fecha[i] = document.getElementById('fechacontable').value;
                concepto[i] = table.rows[i].cells[7].innerHTML;
                referencia[i] = table.rows[i].cells[5].innerHTML;
                factrefe[i] = 0;  
                no_prov[i] = table.rows[i].cells[4].innerHTML;
                nombre_cuenta[i] = table.rows[i].cells[6].innerHTML;
            }

            if(rowCount==2) 
            {
                var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'La poliza debe contener al menos 2 asiento.'}); 
                xyz=true;
            }
            else if(document.getElementById('fechacontable').value == '')
            {
                var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'La poliza debe contener al menos 2 asiento.'}); 
                xyz=true;              
            }
            else if(totalpasivo != 0)
            {
                swal("Advertencia","No cuadra el asiento","warning");
            }
            else
            {
                var tm = JSON.stringify(tipo_mov);      var nob = JSON.stringify(no_banco);
                var nom = JSON.stringify(no_mov);       var re = JSON.stringify(ren);
                var ct = JSON.stringify(cuenta);        var su_cta = JSON.stringify(sub_cta);
                var mon = JSON.stringify(monto);        var ca = JSON.stringify(c_a);
                var fec = JSON.stringify(fecha);        var conce = JSON.stringify(concepto);
                var refe = JSON.stringify(referencia);  var factre = JSON.stringify(factrefe);
                var nopro = JSON.stringify(no_prov);    var ssu_cta = JSON.stringify(ssub_cta);
                var idasiento = document.getElementById('id_asiento_contable').value;
                var tipoasiento = document.getElementById('tipo_asiento_contable').value;
                var bancoid = document.getElementById('banco_asiento_contable').value;
                var movid = document.getElementById('mov_asiento_contable').value;
                var fechacon = document.getElementById('fechacontable').value;


                $.ajax({
                    type: "POST",
                    url: baseurl+"catalogos/Beneficiarios/guardarasientoprovicion",
                    dataType:'json',
                    data: {tm: tipo_mov, nob: no_banco, nom: no_mov, re: ren,
                        ct: cuenta, su_cta: sub_cta, mon: monto, ca: c_a,nombre_cuenta: nombre_cuenta
                        , fec: fecha, conce: concepto, refe: referencia, factre: factrefe
                        , nopro: no_prov, ssu_cta: ssub_cta, idasiento: idasiento
                        , tipoasiento: tipoasiento, bancoid: bancoid, movid: movid, fechacon: fechacon},
                    success: function (data)
                    {
                        if(data == 1)
                        {
                            var n = noty({ layout:'topRight',type: 'success',  theme: 'relax',text: 'Asiento guardado correctamente.'}); 
                            $('#myModalasientoContable').modal('hide');
                        }
                        else
                        {
                            var n = noty({ layout:'topRight',type: 'error',  theme: 'relax',text: 'Error al guardar el asiento.'});
                        }
                    }
                })
            }
    }
    function seleccionarcunetaoperacionesprovision(cuenta,subcta,nombre,ssubcta)
    {
        document.getElementById('cuenta_provision').value = cuenta;
        document.getElementById('sub_cuenta_provision').value = subcta;
        document.getElementById('nom_cuenta_provision').value = nombre;
        document.getElementById('ssub_cuenta_provision').value = ssubcta;

        document.getElementById('no_prov_factu_provision').value = document.getElementById('numprov').innerHTML;
        document.getElementById('concep_provision').value = document.getElementById('nomprov').innerHTML;
        
        document.getElementById('no_prov_factu_provision').focus();
        $('#myModalCuentasOperacionesProvision').modal('hide');
        $('#myModalasientoContable').modal('show');
    }
</script>