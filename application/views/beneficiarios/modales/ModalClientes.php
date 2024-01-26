

<div class="modal fade" id="myModalClientes" role="dialog">
    <div class="modal-dialog modal-lg" id="mdialTamanio">
         <div class="modal-content">
             <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <!-- <input type="hidden" id="renglon" name="renglon"> -->
                    <h1 class="modal-title">Registrar beneficiario o proveedor</h1>
             </div>
             <div class="modal-body">
                    <div class="row">
                       <div class="col-sm-2">
                         <label for="">No Prov:</label>
                         <input type="text" required class="form-control" value="<?php echo $datas;?>" readonly id="no_prov2" name="no_prov2">
                       </div>
                    </div>
                    <br>
                    <div class="col-sm-10">
                         <div class="panel-group">
                              <div class="panel panel-default">
                                   <div class="panel-heading"><b>Datos Personales</b></div>
                                        <div class="panel-body">
                                             <div class="row">
                                                  <div class="col-sm-8">
                                                       <label for="">Nombre:</label>
                                                       <input type="text" class="form-control"  id="nombre2" name="nombre2">
                                                  </div>
                                             </div>
                                             <br>
                                             <div class="row">
                                                  <div class="col-sm-3">
                                                       <label for="">CURP:</label>
                                                       <input type="text" class="form-control"  id="curp2" name="curp2">
                                                  </div>
                                                  <div class="col-sm-3">
                                                       <label for="">RFC:</label>
                                                       <input type="text" class="form-control"  id="rfc2" name="rfc2">
                                                  </div>
                                                  <div class="col-sm-2">
                                                       <label for="">Telefono: </label>
                                                       <input type="text" class="form-control"  id="telefono2" name="telefono2">
                                                  </div>
                                             </div>
                                             <br>
                                             <div class="row">
                                                  <div class="col-sm-4">
                                                       <label for="">Email: </label>
                                                       <input type="text" class="form-control"  id="email2" name="email2">
                                                  </div>
                                             </div>
                                             <br>
                                             <div class="row">
                                                <div class="col-sm-2">
                                                   <input type="radio" name="tipoprove" id="radiogastos"  value="radiogastos">Gastos
                                                </div>
                                                <div class="col-sm-2">
                                                   <input type="radio" name="tipoprove" id="radiocompras"  value="radiocompras">Compras
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="radio" name="tipoprove" id="radiogascom"  value="radiogascom">Gasto y Compra
                                                 </div>
                                                 <div class="col-sm-2">
                                                    <input type="radio" name="tipoprove" id="radiobene"  value="radiobene">Beneficiario
                                                  </div>
                                                  <div class="col-sm-2">
                                                    <input type="radio" name="tipoprove" id="radiocorre"  value="radiocorre">Corresponsal
                                                 </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    <br>
                    <div class="container">
                                        <div class="col-sm-10">
                                             <div class="panel-group">
                                                  <div class="panel panel-default">
                                                       <div class="panel-heading"><b>Datos Domicilio</b></div>
                                                            <div class="panel-body">
                                                                 <div class="row">
                                                                      <div class="col-sm-6">
                                                                           <label for="">Direccion:</label>
                                                                           <input type="text" class="form-control"  id="direccion2" name="direccion2">
                                                                      </div>
                                                                      <div class="col-sm-2">
                                                                           <label for="">No Interior:</label>
                                                                           <input type="text" class="form-control"  id="no_inte2" name="no_inte2">
                                                                      </div>
                                                                      <div class="col-sm-2">
                                                                           <label for="">No Exterior:</label>
                                                                           <input type="text" class="form-control"  id="no_ext2" name="no_ext2">
                                                                      </div>
                                                                 </div>
                                                                 <br>
                                                                 <div class="row">
                                                                      <div class="col-sm-2">
                                                                           <label for="">Ciudad:</label>
                                                                           <input type="text" class="form-control"  id="ciudad2" name="ciudad2">
                                                                      </div>
                                                                      <div class="col-sm-3">
                                                                           <label for="">Colonia:</label>
                                                                           <input type="text" class="form-control"  id="colonia2" name="colonia2">
                                                                      </div>
                                                                      <div class="col-sm-3">
                                                                                <label for="">Municipio: </label>
                                                                                <input type="text" class="form-control"  id="municipio2" name="municipio2">
                                                                      </div>
                                                                      <div class="col-sm-2">
                                                                           <label for="">Estado: </label>
                                                                           <input type="text" class="form-control"  id="estado2" name="estado2">
                                                                      </div>
                                                                      <div class="col-sm-2">
                                                                           <label for="">Pais:</label>
                                                                           <input type="text" class="form-control"  id="pais2" name="pais2">
                                                                      </div>
                                                                 </div>
                                                                 <br>
                                                                 <div class="row">
                                                                    <div class="col-sm-2">
                                                                            <label for="">Codigo Postal:</label>
                                                                            <input type="text" class="form-control"  id="cp2" name="cp2">
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
</div>
                                        <br>
                    <div class="container">
                                        <div class="col-sm-10">
                                             <div class="panel-group">
                                                  <div class="panel panel-default">
                                                       <div class="panel-heading"><b>Datos Contables</b></div>
                                                            <div class="panel-body">
                                                                 <!-- <div class="row">
                                                                      <div class="col-sm-2">
                                                                           <label for="">Solo Credito: </label>
                                                                           <input type="text" class="form-control" value="<?php echo isset($datos[0]['solo_credito']) ? $datos[0]['solo_credito'] : '' ?>" id="solo_credi" name="solo_credi">
                                                                      </div>
                                                                 </div>
                                                                 <br> -->
                                                                 <div class="row">

                                                                 <label class="control-label col-sm-2" for="cta cont. gato">Cta Cont. Gato:</label>
                                                                      <div class="col-sm-2">
                                                                           <input type="text" class="form-control"  id="no_cta2" name="no_cta2">     
                                                                      </div>
                                                                      <div class="col-sm-2"> 
                                                                           <input type="text" class="form-control"  id="sub_cta2" name="sub_cta2">
                                                                      </div>
                                                                      <label class="control-label col-sm-2" for="cta cont. gato">Cta Cont. Compra:</label>
                                                                      <div class="col-sm-2">
                                                                           <input type="text" class="form-control"  id="cta_com2" name="cta_com2">
                                                                      </div>
                                                                      <div class="col-sm-2">
                                                                           <input type="text" class="form-control" id="sub_com2" name="sub_com2">
                                                                      </div>

                                                                 </div>
                                                                 <br>
                                                                 <div class="row">
                                                                 <label class="control-label col-sm-2" for="cta cont. gato">Cta Cont. Terc:</label>
                                                                      <div class="col-sm-2">
                                                                      <input type="text" class="form-control"  id="no_cta3" name="no_cta3">
                                                                      </div>
                                                                      <div class="col-sm-2">
                                                                           <input type="text" class="form-control"  id="sub_cta3" name="sub_cta3">
                                                                      </div>
                                                                 </div>
                                                                 <br>
                                                                 <div class="row">
                                                                      <div class="col-sm-2">
                                                                           <label for="">Vencimiento:</label>
                                                                           <input type="text" class="form-control"  id="venci2" name="venci2">
                                                                      </div>
                                                                      <div class="col-sm-8">
                                                                           <label for="">Concepto: </label>
                                                                           <input type="text" class="form-control" id="concep2" name="concep2">
                                                                      </div>
                                                                 </div>
                                                                 <br>
                                                                 <div class="row">
                                                                      <div class="col-sm-1"></div>
                                                                      <div class="col-sm-4">
                                                                      <div><input type="checkbox" id="cen_cos2" name="cen_cos2"  > Sus facturas son para centro de costos</div>
                                                                      </div>
                                                                 </div>
                                                                 <div class="row">
                                                                 <div class="col-sm-1"></div>
                                                                 <div class="col-sm-6">
                                                                      <div><input type="checkbox" id="trasieps2" name="trasieps2"  > Sus facturas tienen IEPS para trasladar y/o provisionar</div>
                                                                 </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <br>


                    <div class="row">
                    <center>
                    <font size="6"><b>Bancos para pago con transferencia</b></font>
                    </center>
                    </div>
                    <br>
                    <div class="row">
                         <div class="col-sm-3">
                         </div>
                         <div class="col-sm-1">
                              <label for="">Clave:</label>&nbsp;&nbsp;<a class="glyphicon glyphicon-search" data-toggle="modal" data-target="#myModalBancos"></a>
                              <input type="text" class="form-control" readonly id="clavebanco2" name="clavebanco2">
                         </div>
                         <div class="col-sm-3">
                              <label for="">Nombre</label>
                              <input type="text" class="form-control" readonly id="nombrebanco2" name="nombrebanco2">
                         </div>
                         <div class="col-sm-2">
                              <label for="">No. Cuenta</label>
                              <input type="text" class="form-control" id="cuentabanco2" name="cuentabanco2">
                         </div>
                         <div>
                         <br>
                         <button type="button" class="btn btn-primary" onclick="agregarbanco()"><span class="fa fa-plus"></span></button>
                         </div>
                    </div>
                    <br> 
                     <div class="container">
                            <table id="pagos_transfe" class="table table-bordered table-hover"  cellspacing="0" width="100%">
                                    <thead style="background-color:#5a5a5a; color:white;">
                                        <tr>
                                                <th>
                                                <center>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="deletepagos('pagos_transfe')"><span class="fa fa-times"></span> </button>
                                                </center>
                                                </th>
                                                <th>Clave</th>
                                                <th>Nombre</th>
                                                <th>No. Cuenta</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                            </table>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-success btn-lg" onclick="guardardatos('pagos_transfe')"><span class="fa fa-floppy-o"></span> Guardar</button>
                        <button type="button" class="btn btn-danger btn-lg"  data-dismiss="modal" aria-hidden="true">Cancelar</button>

                    </div>
                    </div>
             </div>
    </div>

    <script>
        function guardardatos(tableID)
        {
            var id = 0;
            var no_prov = document.getElementById('no_prov2').value;
            var nombre = document.getElementById('nombre2').value;
            var curp = document.getElementById('curp2').value;
            var rfc = document.getElementById('rfc2').value;
            var telefono = document.getElementById('telefono2').value;
            var email = document.getElementById('email2').value;
            var tipoprove = $("input:radio[name=tipoprove]:checked").val();

            switch (tipoprove){
                case 'radiogastos':
                        var tipo2 = 1;          
                        break;
                        case 'radiocompras':
                        var tipo2 = 2;
                        break;
                        case 'radiogascom': 
                        var tipo2 = 3;
                        break;
                        case 'radiobene': 
                        var tipo2 = 4;
                        break;
                        case 'radiocorre': 
                        var tipo2 = 5;
                        break;  
            }

            var direccion = document.getElementById('direccion2').value;
            var no_inte = document.getElementById('no_inte2').value;
            var no_ext = document.getElementById('no_ext2').value;
            var ciudad = document.getElementById('ciudad2').value;
            var colonia = document.getElementById('colonia2').value;
            var municipio = document.getElementById('municipio2').value;
            var estado = document.getElementById('estado2').value;
            var pais = document.getElementById('pais2').value;
            var cp = document.getElementById('cp2').value;
            var no_cta = document.getElementById('no_cta2').value;
            var sub_cta = document.getElementById('sub_cta2').value;
            var cta_com = document.getElementById('cta_com2').value;
            var sub_com = document.getElementById('sub_com2').value;
            var no_cta3 = document.getElementById('no_cta3').value;
            var sub_cta3 = document.getElementById('sub_cta3').value;
            var venci = document.getElementById('venci2').value;
            var concep = document.getElementById('concep2').value;
            var cen_cos = document.getElementById("cen_cos2");
            if(cen_cos.checked == true)
            {
                var cen_cos1 = 1;
            }
            else
            {
                var cen_cos1 = 0;
            }
            var tranieps = document.getElementById('trasieps2');
            if(tranieps.checked == true)
            {
                var tranieso1 = 1;
            }
            else
            {
                var tranieso1 = 0;
            }

                var xyz = false; var table = x(tableID); 
                var clave = []; var nomb = []; var no_cuent = [];
                var rowCount = table.rows.length;

                for(var i = 0; i<rowCount; i++)
                {
                    clave[i] = table.rows[i].cells[1].innerHTML;
                    nomb[i] = table.rows[i].cells[2].innerHTML;
                    no_cuent[i] = table.rows[i].cells[3].innerHTML;
                }

            //     if(rowCount==1)
            //     {
            //        var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'El beneficiario debe tener por lo menos un banco.'}); 
            //        xyz=true;
            //     }

                if(no_prov != '')
                {
                
                    if(tipo == 1 && ((no_cta == '' && sub_cta == '') || (cta_com != '' && sub_com != '')  || (no_cta3 != '' && sub_cta3 != '')))
                    {
                         var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Cuando el tipo de beneficiario o proveedor sea GASTOS, entonces debe existir la cuenta contable de gasto.'});
                    }
                    else if(tipo == 2 && ((no_cta != '' && sub_cta != '') || (cta_com == '' && sub_com == '') || (no_cta3 != '' && sub_cta3 != '')))
                    {
                         var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Cuando el tipo de beneficiario o proveedor sea COMPRAS, entonces debe existir la cuenta contable de compra.'});
                    }
                    else if(tipo == 3 && ((no_cta == '' && sub_cta == '') || (cta_com == '' && sub_com == '') || (no_cta3 != '' && sub_cta3 != '')))
                    {
                         var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Cuando el tipo de beneficiario o proveedor sea GASTOS y COMPRAS, entonces debe existir la cuenta contable de gatos y compra.'});
                    }
                    else if(tipo == 4 && ((no_cta != '' && sub_cta != '') || (cta_com != '' && sub_com != '') || (no_cta3 != '' && sub_cta3 != '')))
                    {
                         var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Cuando el tipo de beneficiario o proveedor sea BENEFICIARIO, entonces no debe existir la cuenta contable de gatos , compra y tercero.'});
                    }
                    else if(tipo == 5 && ((no_cta != '' && sub_cta != '') || (cta_com != '' && sub_com != '') || (no_cta3 == '' && sub_cta3 == '')))
                    {
                         var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Cuando el tipo de beneficiario o proveedor sea CORRESPONSAL, entonces debe existir la cuenta contable de tercero.'});
                    }
                    else
                    {
                    if(nombre == '')
                    {
                        var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Ingrese el nombre del beneficiario.'});
                    }
                    // else if(rfc == '')
                    // {
                    //     var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Ingrese el RFC del beneficiario.'});
                    // }
                    else if(xyz == false)
                    {
                        var clv = JSON.stringify(clave);  var nom = JSON.stringify(nomb);
                        var nocun = JSON.stringify(no_cuent);

                        $.ajax({
                                type: "POST",
                                url: baseurl+"catalogos/Beneficiarios/guardarbenefi",
                                data:{id:id,no_prov:no_prov,nombre:nombre,direccion:direccion,no_inte:no_inte,
                                no_ext:no_ext,ciudad:ciudad,colonia:colonia,municipio:municipio,estado:estado,
                                pais:pais,cp:cp,curp:curp,rfc:rfc,telefono:telefono,email:email,no_cta:no_cta,
                                sub_cta:sub_cta,cta_com:cta_com,sub_com:sub_com,venci:venci,concep:concep,
                                tipo:tipo2,cen_cos:cen_cos1,trasieps:tranieso1,no_cta3:no_cta3,sub_cta3:sub_cta3,
                                clave:clave,nomb:nomb,no_cuent:no_cuent},
                                success:function(msg)
                                {
                                    if(msg.status == 0)
                                    {
                                        swal('Advertencia',msg.mensage,'warning');
                                    }
                                    else if(msg.status == 1)
                                    {
                                        // swal('Correcto',msg.mensage,'success');
                                        $("#noprov").val(no_prov);
                                        $("#nombre").val(nombre);
                                        $('#rfcproveedor').val(rfc);
                                        $('#rfcdireccion').val(direccion);
                                        $('#tipoproveedor').val(tipo2);

                                        if('<?php echo $tipo?>' == 2)
                                        {
                                            document.getElementById('no_prov_factu').value = no_prov;
                                            document.getElementById('concep').value = nombre;
                                        }
                                        document.getElementById('montopoli').focus();
                                        $("#myModalClientes").modal('hide');
                                        
                                        // setTimeout(function(){ window.location.href=baseurl+'catalogos/Beneficiarios/index'; }, 500);
                                    }
                                    else
                                    {
                                        swal('Error',msg.mensage,'error');
                                    }

                                }
                        });
                    }
                }
                }
                else
                {
                    var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Agregue un numero a su beneficiario ó proveedor.'}); 
                }
        }
        function deletepagos(tableID)
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
                table.deleteRow(i);
            }
            }
        } catch(e) { alert(e); }
        }
        function agregarbanco()
        {

            if(document.getElementById('clavebanco').value == '' || document.getElementById('cuentabanco').value == '')
            {
                    swal('Advertencia','No ha seleccionado el banco o ingresado el numero de cuenta','warning');
            }
            else
            {
                    var tbody = document.getElementById('pagos_transfe').getElementsByTagName("TBODY")[0];
                    var row = document.createElement("TR")

                    var element = document.createElement("input");
                    element.type = "checkbox";
                    element.name="chkbox[]";

                    var td0 = document.createElement("TD")
                    td0.style.textAlign = 'center';
                    td0.appendChild(element)
                    var td1 = document.createElement("TD")
                    td1.appendChild(document.createTextNode(document.getElementById('clavebanco').value))
                    var td2 = document.createElement("TD")
                    td2.appendChild(document.createTextNode(document.getElementById('nombrebanco').value))
                    var td3 = document.createElement("TD")
                    td3.appendChild(document.createTextNode(document.getElementById('cuentabanco').value))


                    row.appendChild(td0);
                    row.appendChild(td1);
                    row.appendChild(td2);
                    row.appendChild(td3);


                    tbody.appendChild(row);

                    document.getElementById('clavebanco').value = '';
                    document.getElementById('nombrebanco').value = '';
                    document.getElementById('cuentabanco').value = '';
            }
        }
    </script>

</div>