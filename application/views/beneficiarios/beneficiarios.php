<?php
 if (!defined('BASEPATH'))
 exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
 echo validation_errors();
 echo form_open_multipart($accion);


 $this->load->view('beneficiarios/modales/TablaBancos');
 $this->load->view('beneficiarios/modales/ModalCuentasBeneficiario');

?>

<?php
if(isset($mensaje))
{
   echo '<strong>'.$mensaje['mensaje'].'</strong>';
}
?>


<div class="container">

                 <div class="panel-heading"><input type="hidden" class="form-control" readonly id="id" name="id" value="<?php echo isset($datos[0]['id']) ? $datos[0]['id'] : '0'?>"></div>

                    <div class="row">
                       <div class="col-sm-2">
                         <label for="">No Prov:</label>
                         <input type="text" required class="form-control" readonly value="<?php echo isset($datos) ? $datos[0]['no_prov'] : $datas ?>" id="no_prov" name="no_prov">
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
                                                       <input type="text" class="form-control" value="<?php echo isset($datos[0]['nombre']) ? $datos[0]['nombre'] : (isset($nombre) ? $nombre : '') ?>" id="nombre" name="nombre">
                                                  </div>
                                             </div>
                                             <br>
                                             <div class="row">
                                                  <div class="col-sm-3">
                                                       <label for="">CURP:</label>
                                                       <input type="text" class="form-control" value="<?php echo isset($datos[0]['curp']) ? $datos[0]['curp'] : '' ?>" id="curp" name="curp">
                                                  </div>
                                                  <div class="col-sm-3">
                                                       <label for="">RFC:</label>
                                                       <input type="text" class="form-control" value="<?php echo isset($datos[0]['rfc']) ? $datos[0]['rfc'] : (isset($rfc) ? $rfc : '') ?>" id="rfc" name="rfc">
                                                  </div>
                                                  <div class="col-sm-2">
                                                       <label for="">Telefono: </label>
                                                       <input type="text" class="form-control" value="<?php echo isset($datos[0]['telefono']) ? $datos[0]['telefono'] : '' ?>" id="telefono" name="telefono">
                                                  </div>
                                             </div>
                                             <br>
                                             <div class="row">
                                                  <div class="col-sm-4">
                                                       <label for="">Email: </label>
                                                       <input type="text" class="form-control" value="<?php echo isset($datos[0]['email']) ? $datos[0]['email'] : '' ?>" id="email" name="email">
                                                  </div>
                                             </div>
                                             <br>
                                             <?php
                                              $tipo_pre = 0;
                                              if(isset($datos))
                                              {
                                                 $tipo_pre = $datos[0]['tipo_prov'];
                                              }

                                             ?>
                                             <div class="row">
                                                <div class="col-sm-2">
                                                   <input type="radio" name="tipoprove" id="radiogastos" <?php echo $tipo_pre == 1 ? 'checked' : ''?> value="radiogastos">Gastos
                                                </div>
                                                <div class="col-sm-2">
                                                   <input type="radio" name="tipoprove" id="radiocompras" <?php echo $tipo_pre == 2 ? 'checked' : '' ?> value="radiocompras">Compras
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="radio" name="tipoprove" id="radiogascom" <?php echo $tipo_pre == 3 ? 'checked' : '' ?> value="radiogascom">Gasto y Compra
                                                 </div>
                                                 <div class="col-sm-2">
                                                    <input type="radio" name="tipoprove" id="radiobene" <?php echo $tipo_pre == 4 ? 'checked' : ''?> value="radiobene">Beneficiario
                                                  </div>
                                                  <div class="col-sm-2">
                                                    <input type="radio" name="tipoprove" id="radiocorre" <?php echo $tipo_pre == 5 ? 'checked' : ''?> value="radiocorre">Corresponsal
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
                                                       <div class="panel-heading"><b>Datos Domicilio</b></div>
                                                            <div class="panel-body">
                                                                 <div class="row">
                                                                      <div class="col-sm-6">
                                                                           <label for="">Direccion:</label>
                                                                           <input type="text" class="form-control" value="<?php echo isset($datos[0]['direccion']) ? $datos[0]['direccion'] : '' ?>" id="direccion" name="direccion">
                                                                      </div>
                                                                      <div class="col-sm-2">
                                                                           <label for="">No Interior:</label>
                                                                           <input type="text" class="form-control" value="<?php echo isset($datos[0]['no_interior']) ? $datos[0]['no_interior'] : '' ?>" id="no_inte" name="no_inte">
                                                                      </div>
                                                                      <div class="col-sm-2">
                                                                           <label for="">No Exterior:</label>
                                                                           <input type="text" class="form-control" value="<?php echo isset($datos[0]['no_exterior']) ? $datos[0]['no_exterior'] : '' ?>" id="no_ext" name="no_ext">
                                                                      </div>
                                                                 </div>
                                                                 <br>
                                                                 <div class="row">
                                                                      <div class="col-sm-2">
                                                                           <label for="">Ciudad:</label>
                                                                           <input type="text" class="form-control" value="<?php echo isset($datos[0]['ciudad']) ? $datos[0]['ciudad'] : '' ?>" id="ciudad" name="ciudad">
                                                                      </div>
                                                                      <div class="col-sm-3">
                                                                           <label for="">Colonia:</label>
                                                                           <input type="text" class="form-control" value="<?php echo isset($datos[0]['colonia']) ? $datos[0]['colonia'] : '' ?>" id="colonia" name="colonia">
                                                                      </div>
                                                                      <div class="col-sm-3">
                                                                                <label for="">Municipio: </label>
                                                                                <input type="text" class="form-control" value="<?php echo isset($datos[0]['municipio']) ? $datos[0]['municipio'] : '' ?>" id="municipio" name="municipio">
                                                                      </div>
                                                                      <div class="col-sm-2">
                                                                           <label for="">Estado: </label>
                                                                           <input type="text" class="form-control" value="<?php echo isset($datos[0]['estado']) ? $datos[0]['estado'] : '' ?>" id="estado" name="estado">
                                                                      </div>
                                                                      <div class="col-sm-2">
                                                                           <label for="">Pais:</label>
                                                                           <input type="text" class="form-control" value="<?php echo isset($datos[0]['pais']) ? $datos[0]['pais'] : '' ?>" id="pais" name="pais">
                                                                      </div>
                                                                 </div>
                                                                 <br>
                                                                 <div class="row">
                                                                 <div class="col-sm-2">
                                                                           <label for="">Codigo Postal:</label>
                                                                           <input type="text" class="form-control" value="<?php echo isset($datos[0]['cp']) ? $datos[0]['cp'] : '' ?>" id="cp" name="cp">
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
                                                                      <label class="control-label col-sm-3" for="cta cont. gato">Cta Cont. Gato: &nbsp;&nbsp;<a class="glyphicon glyphicon-search" data-toggle="modal" data-target="#myModalCuentasBeneficiario"></a></label>
                                                                           <div class="col-sm-2">
                                                                                <input type="text" class="form-control"  value="<?php echo isset($datos[0]['no_cta']) ? $datos[0]['no_cta'] : '' ?>" id="no_cta" name="no_cta">     
                                                                           </div>
                                                                           <div class="col-sm-2"> 
                                                                                <input type="text" class="form-control"  value="<?php echo isset($datos[0]['sub_cta']) ? $datos[0]['sub_cta'] : '' ?>" id="sub_cta" name="sub_cta">
                                                                           </div>
                                                                           <div class="col-sm-3">
                                                                                <input type="text" class="form-control" readonly id="nombre_sub_cta" name="nombre_sub_cta">
                                                                           </div>
                                                                 <div>
                                                                      <br>
                                                                      <br>
                                                                  <br>
                                                                 </div class="row">
                                                                      <label class="control-label col-sm-3" for="cta cont. gato">Cta Cont. Compra: &nbsp;&nbsp;<a class="glyphicon glyphicon-search" data-toggle="modal" data-target="#myModalCuentasBeneficiario"></a></label>
                                                                      <div class="col-sm-2">
                                                                           <input type="text" class="form-control"  value="<?php echo isset($datos[0]['ctacom']) ? $datos[0]['ctacom'] : '' ?>" id="cta_com" name="cta_com">
                                                                      </div>
                                                                      <div class="col-sm-2">
                                                                           <input type="text" class="form-control"  value="<?php echo isset($datos[0]['subcom']) ? $datos[0]['subcom'] : '' ?>" id="sub_com" name="sub_com">
                                                                      </div>
                                                                      <div class="col-sm-3">
                                                                           <input type="text" class="form-control" readonly id="nombre_sub_com" name="nombre_sub_com">
                                                                     </div>
                                                                 </div>
                                                                 <br>
                                                                 <div class="row">
                                                                 <label class="control-label col-sm-3" for="cta cont. gato">Cta Cont. Terc: &nbsp;&nbsp;<a class="glyphicon glyphicon-search" data-toggle="modal" data-target="#myModalCuentasBeneficiario"></a></label>
                                                                      <div class="col-sm-2">
                                                                           <input type="text" class="form-control"  value="<?php echo isset($datos[0]['no_cta3']) ? $datos[0]['no_cta3'] : '' ?>" id="no_cta3" name="no_cta3">
                                                                      </div>
                                                                      <div class="col-sm-2">
                                                                           <input type="text" class="form-control"  value="<?php echo isset($datos[0]['sub_cta3']) ? $datos[0]['sub_cta3'] : '' ?>" id="sub_cta3" name="sub_cta3">
                                                                      </div>
                                                                      <div class="col-sm-3">
                                                                           <input type="text" class="form-control" readonly id="nombre_sub_cta3" name="nombre_sub_cta3">
                                                                     </div>
                                                                 </div>
                                                                 <br>
                                                                 <div class="row">
                                                                      <div class="col-sm-2">
                                                                           <label for="">Vencimiento:</label>
                                                                           <input type="text" class="form-control" value="<?php echo isset($datos[0]['venci']) ? $datos[0]['venci'] : '' ?>" id="venci" name="venci">
                                                                      </div>
                                                                      <div class="col-sm-8">
                                                                           <label for="">Concepto: </label>
                                                                           <input type="text" class="form-control" value="<?php echo isset($datos[0]['concepto']) ? $datos[0]['concepto'] : '' ?>" id="concep" name="concep">
                                                                      </div>
                                                                 </div>
                                                                 <br>
                                                                 <?php
                                                                 $costos = 0;
                                                                 $ieps = 0;
                                                                 if(isset($datos))
                                                                 {
                                                                 $costos = $datos[0]['centro_costos'];
                                                                 $ieps = $datos[0]['traslada_ieps'];
                                                                 }

                                                                 ?>
                                                                 <div class="row">
                                                                      <div class="col-sm-1"></div>
                                                                      <div class="col-sm-4">
                                                                      <div><input type="checkbox" id="cen_cos" name="cen_cos" <?php echo $costos == 1 ? 'checked':  '' ?> > Sus facturas son para centro de costos</div>
                                                                      </div>
                                                                 </div>
                                                                 <div class="row">
                                                                 <div class="col-sm-1"></div>
                                                                 <div class="col-sm-6">
                                                                      <div><input type="checkbox" id="trasieps" name="trasieps" <?php echo $ieps == 1 ? 'checked':  '' ?> > Sus facturas tienen IEPS para trasladar y/o provisionar</div>
                                                                 </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <br>
                    </div>

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
                              <input type="text" class="form-control" readonly id="clavebanco" name="clavebanco">
                         </div>
                         <div class="col-sm-3">
                              <label for="">Nombre</label>
                              <input type="text" class="form-control" readonly id="nombrebanco" name="nombrebanco">
                         </div>
                         <div class="col-sm-2">
                              <label for="">No. Cuenta</label>
                              <input type="text" class="form-control" id="cuentabanco" name="cuentabanco">
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
                              <?php
                              if(isset($datos) && count($datos) > 0)
                              {
                                   foreach($detalle as $row)
                                   {
                                        echo ('<tr><td align="center"><input type="checkbox"></td>');
                                        echo ('<td>'.$row['bancoSat'].'</td>');
                                        echo ('<td>'.$row['nombre'].'</td>');
                                        echo ('<td>'.$row['ctaBan'].'</td>');
                                        echo ('</tr>');
                                   }
                              }
                              ?>
                              <tbody>
                              </tbody>
                    </table>
                    </div>

<div class="form-group">
    <center>
        <button type="button" class="btn btn-success btn-lg" onclick="guardardatos('pagos_transfe')"><span class="fa fa-floppy-o"></span> Guardar</button>
        <a href="<?php echo base_url().'catalogos/Beneficiarios/index'?>" class="btn btn-danger btn-lg" role="button"><span class="fa fa-times"></span> Cancelar</a>
    </center>
</div>

<script>
function guardardatos(tableID)
{
   var id = document.getElementById('id').value;
   var no_prov = document.getElementById('no_prov').value;
   var nombre = document.getElementById('nombre').value;
   var curp = document.getElementById('curp').value;
   var rfc = document.getElementById('rfc').value;
   var telefono = document.getElementById('telefono').value;
   var email = document.getElementById('email').value;
   var tipoprove = $("input:radio[name=tipoprove]:checked").val();

   switch (tipoprove){
     case 'radiogastos':
              var tipo = 1;          
               break;
            case 'radiocompras':
              var tipo = 2;
               break;
            case 'radiogascom': 
              var tipo = 3;
              break;
            case 'radiobene': 
              var tipo = 4;
              break;
            case 'radiocorre': 
              var tipo = 5;
              break;  
   }

   var direccion = document.getElementById('direccion').value;
   var no_inte = document.getElementById('no_inte').value;
   var no_ext = document.getElementById('no_ext').value;
   var ciudad = document.getElementById('ciudad').value;
   var colonia = document.getElementById('colonia').value;
   var municipio = document.getElementById('municipio').value;
   var estado = document.getElementById('estado').value;
   var pais = document.getElementById('pais').value;
   var cp = document.getElementById('cp').value;
   var no_cta = document.getElementById('no_cta').value == 0 ? '' : document.getElementById('no_cta').value;
   var sub_cta = document.getElementById('sub_cta').value == 0 ? '' : document.getElementById('sub_cta').value;
   var cta_com = document.getElementById('cta_com').value == 0 ? '' : document.getElementById('cta_com').value;
   var sub_com = document.getElementById('sub_com').value == 0 ? '' : document.getElementById('sub_com').value;
   var no_cta3 = document.getElementById('no_cta3').value == 0 ? '' : document.getElementById('no_cta3').value;
   var sub_cta3 = document.getElementById('sub_cta3').value == 0 ? '' : document.getElementById('sub_cta3').value;
   var venci = document.getElementById('venci').value;
   var concep = document.getElementById('concep').value;
   var cen_cos = document.getElementById("cen_cos");
   if(cen_cos.checked == true)
   {
       var cen_cos1 = 1;
   }
   else
   {
       var cen_cos1 = 0;
   }
   var tranieps = document.getElementById('trasieps');
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
                    tipo:tipo,cen_cos:cen_cos1,trasieps:tranieso1,no_cta3:no_cta3,sub_cta3:sub_cta3,
                    clave:clave,nomb:nomb,no_cuent:no_cuent},
                    success:function(msg)
                    {
                         if(msg.status == 0)
                         {
                              swal('Advertencia',msg.mensage,'warning');
                         }
                         else if(msg.status == 1)
                         {
                              swal('Correcto',msg.mensage,'success');
                               setTimeout(function(){ window.location.href=baseurl+'catalogos/Beneficiarios/index'; }, 500);
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
function seleccionarcunetabeneficiario(cuenta,subcta,nombre)
{

     var tipoprove = $("input:radio[name=tipoprove]:checked").val();
     console.log(tipoprove);

          switch (tipoprove){
          case 'radiogastos':
                    var tipo = 1;          
                    break;
               case 'radiocompras':
                    var tipo = 2;
                    break;
               case 'radiogascom': 
                    var tipo = 3;
                    break;
               case 'radiobene': 
                    var tipo = 4;
                    break;
               case 'radiocorre': 
                    var tipo = 5;
                    break;  
          }

          console.log(tipo);

          if(tipo == 1)
          {
              document.getElementById('no_cta').value = cuenta;
              document.getElementById('sub_cta').value = subcta;
              document.getElementById('nombre_sub_cta').value = nombre;
          }
          else if(tipo == 2)
          {
               document.getElementById('cta_com').value = cuenta;
               document.getElementById('sub_com').value = subcta;
               document.getElementById('nombre_sub_com').value = nombre;
          }
          else if(tipo == 3)
          {
               if(document.getElementById('no_cta').value == '')
               {
                    document.getElementById('no_cta').value = cuenta;
                    document.getElementById('sub_cta').value = subcta;
                    document.getElementById('nombre_sub_cta').value = nombre;
               }
               else
               {
                    document.getElementById('cta_com').value = cuenta;
                    document.getElementById('sub_com').value = subcta;
                    document.getElementById('nombre_sub_com').value = nombre;
               }
          }
          else if(tipo == 4)
          {

          }
          else
          {
               document.getElementById('no_cta3').value = cuenta;
               document.getElementById('sub_cta3').value = subcta;
               document.getElementById('nombre_sub_cta3').value = nombre;
          }
          $('#myModalCuentasBeneficiario').modal('hide');
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
function bancosat()
    {
        var ban = document.getElementById('clavebanco').value;

        jQuery.ajax({
            type:"POST",
            url: baseurl + "catalogos/Bancos/getbancodesc",
            data:{bancosat:ban},
            dataType:"html",
            success:function(response)
            {
                response=JSON.parse(response);
                if(response == 0)
                {
                    var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'No existe un banco con esa clave.'});
                    document.getElementById('clavebanco').value = '';
                    document.getElementById('clavebanco').focus();
                }
                else
                {
                    document.getElementById('nombrebanco').value = response[0].nombre;
                }

            }
        });

    }
</script>