<?php
 if (!defined('BASEPATH'))
 exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
 echo validation_errors();

$img = $datos[0]['logo'];

$this->load->view('beneficiarios/modales/CuentasPagar');
$this->load->view('beneficiarios/modales/Contrarecibos');
$this->load->view('beneficiarios/modales/RegistroPagos');
$this->load->view('beneficiarios/modales/TablaClientes');
$this->load->view('beneficiarios/modales/ModalXML');
$this->load->view('beneficiarios/modales/TablaCuentas');
$this->load->view('beneficiarios/modales/TablaCuentasOperaciones');
$this->load->view('beneficiarios/modales/TablaClasifica');
$this->load->view('beneficiarios/modales/ModalClientes');
$this->load->view('beneficiarios/modales/TablaBancos');


//var_dump($datos[0]);
?>


<!-- <div class="container"> -->
<input type="hidden" id="identi" name="identi" readonly value="<?php echo isset($datospoliza[0]['id']) ? $datospoliza[0]['id'] : '0' ?>">
<div class="panel-group">
<div class="panel panel-default">
<div class="panel-heading"></div>
<div class="panel-body">

    <div class="row">
            <div class="col-sm-3">
            <img id="blah" src="<?php echo isset($img) && $img!="0" ? "data:image/jpeg;base64,$img": base_url().'public/img/logo.png'?>" alt="your image" width="220px" height="110px" />
            </div>
            <div class="col-sm-3">
                    <br>
                    <br> 
                    <b>Cuenta: <?php echo $datos[0]['cuenta']?></b>
                    <br>
                    <b>Banco: <?php echo $datos[0]['banco']?></b>
                    <br>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-2">
            <b><?php if($tipo == 1){echo 'Transferencia:';}else if($tipo == 2){ echo 'Cheque:'; }else{echo 'Depósito:';}?></b>
            <input readonly type="text" id="no_mov" name="no_mov" class="form-control" value="<?php echo isset($datospoliza[0]['no_mov']) ? $datospoliza[0]['no_mov'] : $consecu ?>"> 
            </div>
            <div class="col-sm-2">
            <b>Fecha:</b><input type="date" id="fechatrabajo" name="fechatrabajo" value="<?php echo isset($datospoliza[0]['fecha']) ? $datospoliza[0]['fecha'] : date('Y-m-d')?>" class="form-control">
            </div>
    </div>
    <br>
        <div class="row">
        <?php
        if($tipo != 3)
        {
        ?>
             <?php
             if($bc == 'min' || $tipo == 2)
             {
             ?>
                <div class="col-sm-1">
                    <br>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-default" data-toggle="modal" data-target="#myModalBenefi" type="button"><span class="fa fa-search"></span></button>
                        </span>
                        <input type="text" class="form-control" id="noprov" name="noprov"  value="<?php echo isset($datospoliza[0]['no_prov']) ? $datospoliza[0]['no_prov'] : '' ?>" onblur="buscarprov()">
                    </div>
                </div>
                <div class="col-sm-6">
                <label for="">Ingresar numero de beneficiario o proveedor y hacer TAB</label>
                    <input type="text" class="form-control" id="nombre" readonly name="nombre" value="<?php echo isset($datospoliza[0]['beneficia']) ? $datospoliza[0]['beneficia'] : ''?>">
                    <input type="hidden" value="<?php echo isset($datosprove[0]['rfc']) ? $datosprove[0]['rfc'] : '' ?>" id="rfcproveedor" name="rfcproveedor">
                    <input type="hidden" value="<?php echo isset($datosprove[0]['direccion']) ? $datosprove[0]['direccion'] : '' ?>" id="rfcdireccion" name="rfcdireccion">
                    <input type="hidden" value="<?php echo isset($datosprove[0]['tipoproveedor']) ? $datosprove[0]['tipoproveedor'] : '' ?>" id="tipoproveedor" name="tipoproveedor">
                </div>
              <?php
              }
              else
              {
              ?>
                         <div class="col-sm-1"></div>
                         <div class="col-sm-6"></div>
              <?php
              }
              ?>
        <?php
          }
          else
          {
         ?>
          <div class="col-sm-1"></div>
          <div class="col-sm-6"></div>
        <?php
          }
        ?>   




            <div class="col-sm-2">
                <br>
               <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input type="text" id="montopoli"  name="montopoli" onkeypress="return soloNumeros(event,this)" onblur="agregarcuentaautomatica('asiento_conta')" class="form-control" value="<?php echo isset($datospoliza[0]['monto']) ? $datospoliza[0]['monto'] : '' ?>">               
               </div>
            </div>


        <?php
        if($tipo == 1)
        {           
        ?>
             
                <div class="col-sm-1">
                    <div class="input-group">
                            <span class="input-group-addon">+/-</span>
                            <input type="text" id="signopoli" name="signopoli" readonly onkeypress="return soloSignos(event)" maxlength="1" value="<?php echo $bc == "plu" ? '+' : '-'?>" class="form-control">
                    </div>
                </div>
        
        <?php
        }
        ?>
       
       
       <?php
        if($tipo == 2 || $bc == 'min')
        {
        ?>
            <div class="col-sm-1">
                <button type="button" tabindex="10" class="btn btn-primary" onclick="abrircuentaspagar()"><span class="fa fa-usd"></span> <br>X pagar</button>
            </div>
        <?php
        }
        else
        {
        ?>
            <div class="col-sm-1">
               <button type="button" tabindex="9" class="btn btn-primary" onclick="abrirregistropago()"><span class="fa fa-usd"></span> Reg. Pago</button>
            </div>
        <?php
        }
        ?>
 

        <?php
        if($tipo == 1)
        {
        ?>
     
        <br>
        <br>
        <br>

        <div class="row">
            <div class="col-sm-1">
            </div>
           <div class="col-sm-2">
             <div class="input-group">
                    <span class="input-group-btn">
                        <button class="btn btn-default" onclick="abrirbancobene()" <?php echo $bc == "plu" ? 'disabled' : ''?> type="button"><span class="fa fa-search"></span></button>
                    </span>
               <input type="text" id="no_cuenta_banco" name="no_cuenta_banco" value="<?php echo isset($datospoliza[0]['cta_banco']) ? $datospoliza[0]['cta_banco'] : '' ?>" readonly class="form-control">
             </div>
           </div>

           <div class="col-sm-1">
               <input type="text" id="bancosat" readonly name="bancosat" value="<?php echo isset($datospoliza[0]['bancosat']) ? $datospoliza[0]['bancosat'] : ''?>" class="form-control">
           </div>
           <div class="col-sm-5">
               <input type="text" id="bene_ctaban" readonly name="bene_ctaban" value="<?php echo isset($datospoliza[0]['bene_ctaban']) ? $datospoliza[0]['bene_ctaban'] : ''?>" class="form-control">
           </div>
        </div>

        <?php
        }
        ?>

        </div>
        <?php
        if($tipo == 2)
        {
        ?>
            <br>
            <div class="row">
                <label class="control-label col-sm-6" for="cuenta"><b>Paguese este cheque a:</b></label>
            </div>
        <?php
            }
        ?>
    <br>
    <div class="row">
        <div class="col-sm-6">
            <b>Concepto:</b>
            <textarea name="concepto"  id="concepto" cols="10" rows="3" class="form-control" ><?php echo isset($datospoliza[0]['concepto']) ? $datospoliza[0]['concepto'] : '' ?></textarea>
        </div>
        <div class="col-sm-2">
            <b>Fecha Conc:</b>
            <input type="date" readonly tabindex="8" id="fechaconcep" name="fechaconcep"  class="form-control">
        </div>
        <div class="col-sm-1">
        <br>
            <button type="button" tabindex="7" class="btn btn-primary" onclick="fechaconci()"><span class="fa fa-lock"></span> </button>
        </div>

        <div class="col-sm-2">
        <br>
            <button type="button" tabindex="6" class="btn btn-primary" onclick="abrircargaarchivos()"><span class="fa fa-eye"></span> Ver docs</button>
        </div>

    </div>


</div>

</div>
</div>


<!-- </div> -->

<!-- <div class="container"> -->

    <div class="panel-group">
    <div class="panel panel-default">
    <div class="panel-heading"><center><b><font size="5">Asiento contable</font></b></center></div>
    <div class="panel-body">
<input type="hidden" class="form-control" id="valorporpagar" name="valorporpagar" readonly value="1">
    <div class="row">
        <div class="col-sm-2">
            <label for="">Cuenta</label>&nbsp;&nbsp;<a class="glyphicon glyphicon-search" data-toggle="modal" data-target="#myModalCuentasOperaciones"></a>
            <input type="text" maxlength="3" class="form-control" id="cuenta">
        </div>
        <div class="col-sm-2">
             <label for="">Sub Cuenta</label>
             <input type="text" class="form-control" onblur="agregarcuentas()" id="sub_cuenta">
        </div>
        <div class="col-sm-2">
            <?php
            if($tipo == 2)
            {
            ?>
             <label for="">No prov</label>
             <input type="text" class="form-control" id="no_prov_factu">
             <?php
            }
            else
            {
            ?>
            <label for="">Factura</label>
            <input type="text" class="form-control" id="no_prov_factu" value="0">
            <?php
             }
            ?>
        </div>
        <div class="col-sm-2">
             <label for="">Referencia</label>
             <input type="text" class="form-control" id="referen">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-5">
             <label for="">Nombre cuenta</label>
             <input type="text" class="form-control" tabindex="3" id="nom_cuenta" readonly>
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
          <table id="asiento_conta" class="table table-bordered table-hover"  cellspacing="0" width="100%">
             <thead style="background-color:#5a5a5a; color:white;">
                <tr>
                    <th>
                     <center>
                        <button type="button"  class="btn btn-danger btn-sm" value="Delete Row" onclick="deleteRow('asiento_conta');"><span class="fa fa-times"></span></button>
                        <button type="button" class="btn btn-success btn-sm" onclick="editRow('asiento_conta');" ><span class="fa fa-pencil"></span></button>
                     </center>
                    </th>
                    <th>Cuenta</th>
                    <th>Sub cta</th>
                    <?php
                     if($tipo == 2)
                     {
                    ?>
                     <th>No. prov</th>
                    <?php
                     }
                     else
                     {
                     ?>
                     <th>Factura</th>
                     <?php
                     }
                    ?>

                    <th>Referencia</th>
                    <th>Nombre cuenta</th>
                    <th>Concepto</th>
                    <th>Monto</th>
                    <th>+/-</th>
                </tr>
            </thead>
            <?php
                if(isset($datospoliza) && count($datospoliza) > 0)
                {
                    foreach($detalle as $row)
                    {
                        echo ('<tr><td align="center"><input type="checkbox"></td>');
                        echo ('<td>'.$row['cuenta'].'</td>');
                        echo ('<td>'.$row['sub_cta'].'</td>');
                        if($tipo == 2)
                        {
                            echo ('<td>'.$row['no_prov'].'</td>');
                        }
                        else
                        {
                            echo ('<td>'.$row['factrefe'].'</td>');
                        }
                        echo ('<td>'.$row['referencia'].'</td>');
                        echo ('<td>'.$row['nombre_cuenta'].'</td>');
                        echo ('<td>'.$row['concepto'].'</td>');
                        echo ('<td>'.$row['monto'].'</td>');
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
<!-- </div> -->

<center>
<button type="button" class="btn btn-success btn-lg" onclick="recogerDatosPoliza('asiento_conta')" ><span class="fa fa-floppy-o"></span> Guardar</button>
<a href="<?php echo base_url().'catalogos/Bancos/operaciones/'.$tipo.'/'.$id.''?>" class="btn btn-danger btn-lg" role="button"><span class="fa fa-times"></span> Cancelar</a>
</center>

<div class="modal fade" id="myModalCargarArchivos" role="dialog" >
<div class="modal-dialog modal-lg" >
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Cargar Archivos</h1>
        </div>
        <div class="modal-body" >
        <form enctype="multipart/form-data" action="#" id="formularioarchivos">
            <label for="archivo">Archivo</label>
		    <input id="archivo" class="form-control" type="file" name="archivo">
			<p class="help-block">Seleccione el archivo a almacenar</p>
       </form>
        </div>
        <div class="modal-footer">
           <button type="button" class="btn btn-success" onclick="almacenaarchivo()">Aceptar</button>
           <button type="button" class="btn btn-danger" onclick="cerrarcargaarchivos()">Cerrar</button>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="myModalBenefi" role="dialog" >
<div class="modal-dialog modal-lg" >
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Busqueda Beneficiario</h1>
        </div>
        <div class="modal-body" >
          <table id="Beneficiarios2" class="stripe row-border responsive nowrap" cellspacing="0" width="90%">
              <thead style="background-color:#5a5a5a; color:white;">
                    <th>Accion</th>
                    <th>No Prov</th>
                    <th>Nombre</th>
                    <th>RFC</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>tipo_proveedor</th>
              </thead>
          </table>
            <!-- <button class="btn btn-success" aria-hidden="true" onclick="selectbenefi()" ><span class="glyphicon glyphicon-ok"></span> Seleccionar</button> -->
        </div>
    </div>
</div>
</div>

<style>
#mdialTamanio{
      width: 80% !important;
}
</style>

<div class="modal fade" id="myModalBancoBenef" role="dialog" >
<div class="modal-dialog modal-lg" >
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Bancos del Beneficiario</h1>
        </div>
        <div class="modal-body" >
          <table id="BancoBenef" class="stripe row-border responsive nowrap" cellspacing="0" width="90%">
              <thead style="background-color:#5a5a5a; color:white;"> 
                    <th>Accion</th>
                    <th>No Proveedor</th>
                    <th>Clave Banco</th>
                    <th>Nombre</th>
                    <th>Cuenta Banco</th>
              </thead>
          </table>
        </div>
        <div class="modal-footer">
           <!-- <button type="button" class="btn btn-success" onclick="seleccionarbanco()">Aceptar</button> -->
        </div>
    </div>
</div>
</div>
<script>

$('#Beneficiarios2').DataTable({
    responsive: true, 
    filter:true, 
    processing: true, 
    serverSide: true,
      ajax: {
          url : baseurl + "catalogos/Beneficiarios/ajax_list_beneficiarios",
          type : "POST"
          },
          "language" : {"url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
         ,"sDom": 'T<"clear">lfrtip', "oTableTools": {  "sRowSelect": "single","aButtons": ""},
         columnDefs: [ 
             { responsivePriority: 1, targets: 1, name : 'no_prov' }, 
        ]
   })

   var tablebancobenefi = $('#BancoBenef').DataTable({
    responsive: true, 
    filter:true, 
    processing: true, 
    serverSide: true,
      ajax: {
          url : baseurl + "catalogos/Beneficiarios/ajax_list_bancos",
          type : "POST"
          },
          "language" : {"url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
         ,"sDom": 'T<"clear">lfrtip', "oTableTools": {  "sRowSelect": "single","aButtons": ""},
         columnDefs: [ 
             { responsivePriority: 1, targets: 1, name : 'no_prov' }, 
        ]
   })
   function almacenaarchivo()
   {
       var nom_mov = document.getElementById('no_mov').value;
       var formElement = document.getElementById('formularioarchivos');
       var formData = new FormData(formElement);
       formData.append('tipo_mov','<?php if($tipo == 1){echo 'T';}else if($tipo == 2){ echo 'C'; }else{echo 'D';}?>');
       formData.append('no_banco','<?php echo $datos[0]["no_banco"];?>');
       formData.append('no_mov',nom_mov);
       jQuery.ajax({
         url : "<?php echo base_url('Configuracion/upload'); ?>",
         type : "POST",
         data : formData,
         processData : false,
         contentType  : false,
         success : function (data){
             if(data == 1)
             {
                var n = noty({ layout:'topRight',type: 'success',  theme: 'relax',text: 'Archivo Registrado Correctamente.'});
                $('#myModalCargarArchivos').modal('hide');
             }
             else
             {
                var n = noty({ layout:'topRight',type: 'error',  theme: 'relax',text: 'El archivo no es soportado.'});
                $('#myModalCargarArchivos').modal('hide');
             }
         }
       });
   }
   function abrircargaarchivos()
   {
     $('#myModalCargarArchivos').modal('show');
   }
   function cerrarcargaarchivos()
   {
     $('#myModalCargarArchivos').modal('hide');
   }
    function seleccionarcunetaoperaciones(cuenta,subcta,nombre)
    {
        document.getElementById('cuenta').value = cuenta;
        document.getElementById('sub_cuenta').value = subcta;
        document.getElementById('nom_cuenta').value = nombre;

        document.getElementById('no_prov_factu').value = document.getElementById('noprov').value;
        document.getElementById('concep').value = document.getElementById('nombre').value;
        
        document.getElementById('no_prov_factu').focus();
        $('#myModalCuentasOperaciones').modal('hide');
    }
  function seleccionarcuneta(cuenta,subcta,nombre)
  {
        $('#myModalCuentas').modal('hide');

        var p = document.getElementById('renglon').value;
        document.getElementById('table').tBodies[0].rows[p-1].cells[1].innerHTML = cuenta;
        document.getElementById('table').tBodies[0].rows[p-1].cells[2].innerHTML = subcta;
        document.getElementById('table').tBodies[0].rows[p-1].cells[3].innerHTML = nombre;  

        $('#myModalxml').modal('show');
  }
function abrirbancobene()
{
    var id = document.getElementById('noprov').value;
    tablebancobenefi.columns(1).search(id).draw();
    $('#myModalBancoBenef').modal('show');
}
function seleccionarbanco(no_prov,bancosat,nombre,ctaban)
{
   $("#no_cuenta_banco").val(ctaban);
   $("#bancosat").val(bancosat);
   $('#bene_ctaban').val(nombre);
   $('#myModalBancoBenef').modal('hide');
}
</script>

<style>
#div1{
  max-height: 400px;
  overflow: scroll;
}
</style>

<script>
function fechaconci()
{
    $('#fechaconcep').prop('readonly',false);
}
function abrircuentaspagar()
{

    if(document.getElementById('noprov').value == '')
    {
        var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Seleccione a su proveedor.'}); 
    }
    else
    {
               document.getElementById('numprov').innerHTML = document.getElementById('noprov').value;
               document.getElementById('nomprov').innerHTML = document.getElementById('nombre').value;
               document.getElementById('rfcprov').innerHTML = document.getElementById('rfcproveedor').value;
               document.getElementById('direprov').innerHTML = document.getElementById('rfcdireccion').value;
               document.getElementById('total_pagar').value = '0.00';
               document.getElementById('total_deuda').value = '0.00';

               verTabla('<?php echo $rfc ?>','<?php echo $tipo_letra?>');

              $('#myModalCuentasPagar').modal('show');
    }     
}
function abrirregistropago()
{
    document.getElementById('monto_pago').value = document.getElementById('montopoli').value;
    document.getElementById('fechapago').value = document.getElementById('fechatrabajo').value;
    $('#myModalregistroPagos').modal('show');
}
function agregarcuentas()
{
    var cuen = document.getElementById('cuenta').value;
    var subcuen = document.getElementById('sub_cuenta').value;

    if(cuen == '')
    {
        var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Falto de agregar la cuenta.'});
    }
    else if(subcuen == '')
    {
        var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Falto agregar la Sub cuenta.'});
    }
    else
    {
        jQuery.ajax({
            type:"POST",
            url: baseurl + 'catalogos/Cuentas/get_cuenta',
            data: {cuen:cuen,subcuen:subcuen},
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

function recogerDatosPoliza(tableID)
{
    var tol = document.getElementById('totalpoliza').value;
    var mes = '<?php echo $_SESSION["mes"];?>';
    var ano = '<?php echo $_SESSION["ano"];?>';
    var fecha = document.getElementById('fechatrabajo').value;
    var fechadivi = fecha.split('-');
    var fechaano = fechadivi[0];
    var fechames = fechadivi[1];

    if(mes == fechames && ano == fechaano)
    {
        if(tol == 0)
        {
           //cabezera poliza
            var id = document.getElementById('identi').value;
            var tipo_movimiento = '<?php if($tipo == 1){echo 'T';}else if($tipo == 2){ echo 'C'; }else{echo 'D';}?>';
            var numero_banco = '<?php echo $datos[0]["no_banco"];?>';
            if('<?php echo $tipo;?>' == 3 || '<?php echo $tipo;?>' == 1)
            {
                var tipoproveedor = '';
            }
            else
            {
                var tipoproveedor = document.getElementById('tipoproveedor').value;
            }

            var numero_movimiento = document.getElementById('no_mov').value;
            var fechapoli = document.getElementById('fechatrabajo').value;
            if('<?php echo $tipo;?>' == 3)
            {
                var beneficiariopoli = '';
            }
            else
            {
                if('<?php echo $bc ?>' == 'plu')
                {
                   var beneficiariopoli = '';
                }
                else
                {
                    var beneficiariopoli = document.getElementById('nombre').value;
                }
            }
            var conceptopoli = document.getElementById('concepto').value;
            var montopoli = document.getElementById('montopoli').value;
            if('<?php echo $tipo;?>' == 1)
            {
                var ca_poli = document.getElementById('signopoli').value;
            }
            else
            {
                if('<?php echo $tipo;?>' == 3)
                {
                    var ca_poli = '+';
                }
                else
                {
                    var ca_poli = '-';
                }
            }
            var cobrado_poli = 0;
            var cerrado_poli = 0;
            if('<?php echo $tipo;?>' == 3)
            {
                var no_prove = 0;
            }
            else
            {
                if('<?php echo $bc ?>' == 'plu')
                {
                   var no_prove = 0;
                }
                else
                {
                    var no_prove = document.getElementById('noprov').value;
                }
            }
            var fechaCobro = document.getElementById('fechaconcep').value;
            if(fecha == "")
            {
               var cobro = 0;
            }
            else
            {
               var cobro = 1;
            }
            var impresopoli = 0;
            var afectar = 0;
            if('<?php echo $tipo;?>' == 1)
            {
                var bancosat = document.getElementById('bancosat').value;
                var bene_ctaban = document.getElementById('bene_ctaban').value;
                var cta_banco = document.getElementById('no_cuenta_banco').value;
            }
            else
            {
                var bancosat = '';
                var bene_ctaban = '';
                var cta_banco = '';
            }
            var tieneCxP_pagos = 0;

            // detalle poliza
            var xyz = false;   var table = x(tableID);  
            var tipo_mov = []; var no_banco = [];      var no_mov = [];
            var ren = [];      var cuenta = [];        var sub_cta = [];
            var monto = [];    var c_a = [];           var fecha = [];
            var concepto = []; var referencia = [];    var no_prov = [];
            var factrefe = []; var nombre_cuenta = [];
            var rowCount = table.rows.length;

            for(var i = 0; i < rowCount; i++)
            {
                tipo_mov[i] = '<?php if($tipo == 1){echo 'T';}else if($tipo == 2){ echo 'C'; }else{echo 'D';}?>';
                no_banco[i] = '<?php echo $datos[0]["no_banco"];?>';
                no_mov[i] = document.getElementById('no_mov').value;
                ren[i] = 0;
                cuenta[i] = table.rows[i].cells[1].innerHTML;
                sub_cta[i] = table.rows[i].cells[2].innerHTML;
                monto[i] = table.rows[i].cells[7].innerHTML;
                c_a[i] = table.rows[i].cells[8].innerHTML;
                fecha[i] = document.getElementById('fecha').value;
                concepto[i] = table.rows[i].cells[6].innerHTML;
                referencia[i] = table.rows[i].cells[4].innerHTML;
                if('<?php echo $tipo;?>' != 2)
                {
                    factrefe[i] = table.rows[i].cells[3].innerHTML;
                    no_prov[i] = 0;
                }
                else
                {
                    factrefe[i] = 0;  
                    no_prov[i] = table.rows[i].cells[3].innerHTML;
                }
                nombre_cuenta[i] = table.rows[i].cells[5].innerHTML;
            }
            if(rowCount==2) 
            {
                var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'La poliza debe contener al menos 2 asiento.'}); 
                xyz=true;
            }

            if(xyz == false)
            {
                var tm = JSON.stringify(tipo_mov);      var nob = JSON.stringify(no_banco);
                var nom = JSON.stringify(no_mov);       var re = JSON.stringify(ren);
                var ct = JSON.stringify(cuenta);        var su_cta = JSON.stringify(sub_cta);
                var mon = JSON.stringify(monto);        var ca = JSON.stringify(c_a);
                var fec = JSON.stringify(fecha);        var conce = JSON.stringify(concepto);
                var refe = JSON.stringify(referencia);  var factre = JSON.stringify(factrefe);
                var nopro = JSON.stringify(no_prov);

                $.ajax({
                    type: "POST",
                    url: baseurl+"catalogos/Operaciones/guardarpoliza",
                    data: {id:id,tipo_movimiento:tipo_movimiento,tipoproveedor:tipoproveedor,numero_banco:numero_banco,numero_movimiento:numero_movimiento,
                    fechapoli:fechapoli,beneficiariopoli:beneficiariopoli,conceptopoli:conceptopoli,montopoli:montopoli,ca_poli:ca_poli,
                    cobrado_poli:cobrado_poli,cerrado_poli:cerrado_poli,no_prove:no_prove,fechaCobro:fechaCobro,cobro:cobro,impresopoli:impresopoli,
                    afectar:afectar,bancosat:bancosat,bene_ctaban:bene_ctaban,cta_banco:cta_banco,tieneCxP_pagos:tieneCxP_pagos,
                    tipo_mov:tipo_mov,no_banco:no_banco,no_mov:no_mov,ren:ren,cuenta:cuenta,sub_cta:sub_cta,monto:monto,
                    c_a:c_a,fecha:fecha,concepto:concepto,referencia:referencia,factrefe:factrefe,no_prov:no_prov,nombre_cuenta:nombre_cuenta},
                    success:function(msg)
                    {
                        if (msg[0].mensaje== "Insertado Correctamente" || msg=="Actualizado Correctamente")
                            {
                                var agre_pag = document.getElementById('agregar_pago').checked;
                                if(agre_pag == true)
                                {
                                   var valor_pago = guardar_pago_regi('docto_relacionado');
                                   response=JSON.parse(valor_pago);
                                   if(response.success == true)
                                   {
                                    var tipo = '<?php if($tipo == 1){echo 'T';}else if($tipo == 2){ echo 'C'; }else{echo 'D';}?>';
                                    swal('Tipo: '+tipo+' Consecutivo: '+numero_movimiento,msg[0].mensaje , "success");
                                    setTimeout(function(){ window.location.href=baseurl+'catalogos/Bancos/operaciones/'+'<?php echo $tipo;?>/'+'<?php echo $id;?>';},500);
                                   }
                                   else
                                   {
                                       swal("Advertencia",response.mensaje,'warning');
                                   }
                                }
                                else
                                {
                                    var tipo = '<?php if($tipo == 1){echo 'T';}else if($tipo == 2){ echo 'C'; }else{echo 'D';}?>';
                                    swal('Tipo: '+tipo+' Consecutivo: '+numero_movimiento,msg[0].mensaje , "success");
                                    setTimeout(function(){ window.location.href=baseurl+'catalogos/Bancos/operaciones/'+'<?php echo $tipo;?>/'+'<?php echo $id;?>'; }, 500);
                                }
                            }
                            else 
                            {
                                swal("Error", msg[0].mensaje, "error");
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
        var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'No esta dentro del mismo ejercicio de trabajo'});
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
           x("no_prov_factu").value = table.rows[i].cells[3].innerHTML;
           x("referen").value = table.rows[i].cells[4].innerHTML;
           x("nom_cuenta").value = table.rows[i].cells[5].innerHTML;
           x("concep").value = table.rows[i].cells[6].innerHTML;
           x("monto").value = table.rows[i].cells[7].innerHTML;
           x("signo").value = table.rows[i].cells[8].innerHTML;
           
          var signo = row.cells[8].innerHTML;
          var posit = parseFloat(document.getElementById('positivo').value);
          var nega = parseFloat(document.getElementById('negativo').value);
          
          var monto = parseFloat(row.cells[7].innerHTML);          
          
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
          
          var monto = parseFloat(row.cells[7].innerHTML);          
          
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

function buscarprov()
{
    var id = document.getElementById('noprov').value;
    jQuery.ajax({
         type:"POST",
         url: baseurl + "catalogos/Beneficiarios/getbeneficiario",
         data: {id:id},
         dataType:"html",
         success:function(response)
         {
             response=JSON.parse(response);
              if(response == 0)
              {
                $("#myModalClientes").modal('show');                
                 //swal("Advertencia","No hay registro con ese numero","warning");
                 $("#noprov").val('');
                 $("#nombre").val('');
                 $('#rfcproveedor').val('');
                 $('#rfcdireccion').val('');
                 $('#tipoproveedor').val('');
              }
              else
              {
                document.getElementById('nombre').value = response[0].nombre;
                document.getElementById('rfcproveedor').value = response[0].rfc;
                document.getElementById('rfcdireccion').value = response[0].direccion;
                document.getElementById('tipoproveedor').value = response[0].tipo_prov;

                if('<?php echo $tipo?>' == 2)
                {
                    document.getElementById('no_prov_factu').value = id;
                    document.getElementById('concep').value = response[0].nombre;
                }
              }
         }
    });
}
function selectbenefi(no_prov,nombre,rfc,direccion,telefono,tipo_proveedor)
        {
               $("#noprov").val(no_prov);
               $("#nombre").val(nombre);
               $('#rfcproveedor').val(rfc);
               $('#rfcdireccion').val(direccion);
               $('#tipoproveedor').val(tipo_proveedor);
               $('#myModalBenefi').modal('hide');
        }
        function agregarcuentaautomatica(tableID)
        {
            var table = x(tableID);
            var rowCount = table.rows.length;

            var monto = document.getElementById('montopoli').value;
            
            if('<?php echo $tipo;?>' == 3)
            {
                var no_prove = 0;
            }
            else
            {
                if('<?php echo $bc ?>' == 'plu')
                {
                   var no_prove = 0;
                }
                else
                {
                   var no_prove = document.getElementById('noprov').value;
                }
            }
            if(monto == '')
            {

            } 
            else
            {
                if(rowCount==1) 
                {

                    var nu_banco = '<?php echo $datos[0]["no_banco"];?>';

                    jQuery.ajax({
                        type:"POST",
                        url: baseurl+"catalogos/bancos/getbanco",
                        data:{id:nu_banco},
                        dataType:"html",
                        success:function(response)
                        {
                            response=JSON.parse(response);

                            var monto = parseFloat(document.getElementById('montopoli').value);

                            var tbody = document.getElementById('asiento_conta').getElementsByTagName("TBODY")[0];
                            var row = document.createElement("TR")
                            
                            var element1 = document.createElement("input");
                            element1.type = "checkbox";
                            element1.name="chkbox[]"; 
                            
                            
                            var td0 = document.createElement("TD")
                            td0.style.textAlign = 'center';
                            td0.appendChild(element1)
                            var td1 = document.createElement("TD")
                            td1.appendChild(document.createTextNode(response[0].cta))
                            var td2 = document.createElement("TD")
                            td2.appendChild(document.createTextNode(response[0].sub_cta))
                            var td3 = document.createElement("TD")
                            td3.appendChild(document.createTextNode(no_prove))
                            var td4 = document.createElement("TD")
                            td4.appendChild(document.createTextNode(''))
                            var td5 = document.createElement("TD")
                            td5.appendChild(document.createTextNode(response[0].banco))
                            var td6 = document.createElement("TD")
                            td6.appendChild(document.createTextNode(''))
                            var td7 = document.createElement("TD")
                            td7.appendChild(document.createTextNode(monto))
                            var td8 = document.createElement("TD")
                            if('<?php echo $tipo;?>' == 3)
                            {
                                td8.appendChild(document.createTextNode('+'))
                                var signo = '+';
                            }
                            else if('<?php echo $tipo;?>' == 1)
                            {
                                var signo = document.getElementById('signopoli').value;
                                td8.appendChild(document.createTextNode(signo))
                            }
                            else
                            {
                                td8.appendChild(document.createTextNode('-'))
                                var signo = '-';
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
                            tbody.appendChild(row);


                            var posit = parseFloat(document.getElementById('positivo').value);
                            var nega = parseFloat(document.getElementById('negativo').value);
                            
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

                        } 
                    });
                    
                }
                else
                {
                    if(document.getElementById('asiento_conta').tBodies[0].rows[1-1].cells[8].innerHTML == '-')
                    {
                        var nega = parseFloat(document.getElementById('negativo').value);
                        var valor = document.getElementById('asiento_conta').tBodies[0].rows[1-1].cells[7].innerHTML;

                        var total = nega - valor;
                        document.getElementById('negativo').value = total.toFixed(2);

                        var nuevonega = parseFloat(document.getElementById('negativo').value);


                        document.getElementById('asiento_conta').tBodies[0].rows[1-1].cells[7].innerHTML = monto;

                        var total2 = nuevonega + parseFloat(monto);
                        document.getElementById('negativo').value = total2.toFixed(2);

                       
                        var posit2 = parseFloat(document.getElementById('positivo').value);
                        var nega2 = parseFloat(document.getElementById('negativo').value);

                        var total3 = posit2-nega2;
                            
                        document.getElementById('totalpoliza').value = total3.toFixed(2);



                    }
                    else
                    {
                        var nega = parseFloat(document.getElementById('positivo').value);
                        var valor = document.getElementById('asiento_conta').tBodies[0].rows[1-1].cells[7].innerHTML;

                        var total = nega - valor;
                        document.getElementById('positivo').value = total.toFixed(2);

                        var nuevonega = parseFloat(document.getElementById('positivo').value);


                        document.getElementById('asiento_conta').tBodies[0].rows[1-1].cells[7].innerHTML = monto;

                        var total2 = nuevonega + parseFloat(monto);
                        document.getElementById('positivo').value = total2.toFixed(2);

                       
                        var posit2 = parseFloat(document.getElementById('positivo').value);
                        var nega2 = parseFloat(document.getElementById('negativo').value);

                        var total3 = posit2-nega2;
                            
                        document.getElementById('totalpoliza').value = total3.toFixed(2);

                    }
                    

                    console.log('si tiene');
                }
            }
        }
function agregarasiento()
{

    var monto = document.getElementById('cuenta').value;
    var sub_cue = document.getElementById('sub_cuenta').value;
    if(monto == '' || sub_cue == '')
    {
        swal('Advertencia','Agregue la cuenta y sub cuenta','warning');
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
                        var td3 = document.createElement("TD")
                        td3.appendChild(document.createTextNode(document.getElementById('no_prov_factu').value))
                        var td4 = document.createElement("TD")
                        td4.appendChild(document.createTextNode(document.getElementById('referen').value))
                        var td5 = document.createElement("TD")
                        td5.appendChild(document.createTextNode(document.getElementById('nom_cuenta').value))
                        var td6 = document.createElement("TD")
                        td6.appendChild(document.createTextNode(document.getElementById('concep').value))
                        var td7 = document.createElement("TD")
                        td7.appendChild(document.createTextNode(document.getElementById('monto').value == '' ? neu : document.getElementById('monto').value))
                        var td8 = document.createElement("TD")
                        td8.appendChild(document.createTextNode(document.getElementById('signo').value == '' ? sig : document.getElementById('signo').value))

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
                        document.getElementById('no_prov_factu').value = '0';
                        document.getElementById('referen').value = '';
                        document.getElementById('nom_cuenta').value = '';
                        document.getElementById('concep').value = '';
                        document.getElementById('monto').value = '';
                        document.getElementById('signo').value = '';

                        document.getElementById('cuenta').focus();
    }

}
</script>