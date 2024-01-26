<?php
 if (!defined('BASEPATH'))
 exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
 echo validation_errors();
 echo form_open_multipart($accion);
 if(isset($datos[0]['logo'])){$img= $datos[0]['logo'];}
?>


<?php
if(isset($mensaje))
{
    echo '<strong>'.$mensaje['mensaje'].'</strong>';
}

?>

<div class="container">
<input type="hidden" class="form-control" readonly id="id_banco" name="id_banco" value="<?php echo isset($datos[0]['id_banco']) ? $datos[0]['id_banco'] : '0'?>">
<br>
<div class="row"></div>
<div class="form-group">
<div class="col-sm-12">
<div class="panel-group">
<div class="panel panel-default">
<div class="panel-heading"><b>Cuenta Bancaria</b></div>
<div class="panel-body">
  <div class="row">
  <textarea id="imgBase64" name="imgBase64" cols="50" rows="15" hidden><?php echo $img;?></textarea>
        <div class="col-sm-4"></div>
            <img id="blah" src="<?php echo isset($img) && $img!="0" ? "data:image/jpeg;base64,$img": base_url().'public/img/logo.png'?>" alt="your image" width="250px" height="110px" /><div class="col-sm-12"><br></div>
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
          <input type="file"  id="imgInp" name="imgInp" >
        </div>
        <input type="hidden" name="imgName" id="imgName" value="<?php echo isset($datos[0]['imgName']) ? $datos[0]['imgName'] : ''?>">
  </div>
  <br>
  <div class="row">
  <label for=""><strong>Campos con un * son obligatorios</strong></label>
  </div>
  <div class="row">
     <div class="col-sm-1">
        <label for="numero">Número: </label>
        <input type="text" <?php echo isset($datos[0]['no_banco']) ? 'readonly' : ''?> value="<?php echo isset($datos) ? $datos[0]['no_banco'] :  '' ?>" class="form-control" id="numero" name="numero">
     </div>
     <div class="col-sm-2">
        <label for="cuenta">Cuenta *: </label>
        <input type="text" value="<?php echo isset($datos[0]['cuenta']) ? $datos[0]['cuenta'] :  '' ?>" class="form-control" id="cuenta" name="cuenta">
     </div>
     <div class="col-sm-6">
        <label for="nombre">Nombre *: </label>
        <input type="text" value="<?php echo isset($datos[0]['banco']) ? $datos[0]['banco'] :  '' ?>" class="form-control" id="nombre" name="nombre">
     </div>
  </div>
  <br>
  <div class="row">
    <div class="col-sm-2">
       <label for="direccion">Dirección: </label>
       <input type="text" class="form-control" value="<?php echo isset($datos[0]['direccion']) ? $datos[0]['direccion'] : '' ?>" id="direccion" name="direccion">
    </div>
    <div class="col-sm-2">
       <label for="ciudad">Ciudad: </label>
       <input type="text" class="form-control" value="<?php echo isset($datos[0]['ciudad']) ? $datos[0]['ciudad'] : '' ?>" id="ciudad" name="ciudad">
    </div>
  </div>
  <br>
  <div class="row">
        <div class="col-sm-5">
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading"><b>Cuenta Contable</b></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="cuenta">Cuenta *: </label>
                                <input type="text" class="form-control" value="<?php echo isset($datos[0]['cta']) ? $datos[0]['cta'] :  '' ?>" id="cuenta_conta" name="cuenta_conta">
                            </div>
                           
                            <div class="col-sm-4">
                                <label for="subcuenta">Sub Cuenta *: </label>
                                <input type="text" class="form-control" value="<?php echo isset($datos[0]['sub_cta']) ? $datos[0]['sub_cta'] :  '' ?>" id="sub_cuenta_conta" name="sub_cuenta_conta">
                            </div>
                            <div class="col-sm-4">
                                <label for="subsubcuenta">Ssub Cuenta: </label>
                                <input type="text" class="form-control" value="<?php echo isset($datos[0]['ssub_cta']) ? $datos[0]['ssub_cta'] :  '' ?>" id="sub_sub_cuenta_conta" name="sub_sub_cuenta_conta">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
           <label for="bancosat">Banco SAT *:</label>
            <select name="bancosat" id="bancosat" onchange="mostrarbanco()" class="form-control">
             <option value="" selected> -Seleccione- </option>
             <?php
             foreach($bancos as $banco)
             {
                echo "<option value='".$banco['clave']."'";
                if(isset($datos))
                {
                    
                        if($banco['clave'] == $datos[0]['bancoSat'])
                        {
                            echo "selected";
                        }
                    
                }
                echo '>'.$banco['clave'].' - '.$banco['nombre_c'];
                echo "</option>";
             }
             ?>
            </select>
        </div>
        <div class="col-sm-6">
        <br>
          <input type="text" readonly class="form-control" value="<?php echo isset($datos[0]['bancoSatNom']) ? $datos[0]['bancoSatNom'] : '' ?>" id="bancosatdescripcion" name="bancosatdescripcion">
        </div>
  </div>
  <div class="row">
     <div class="col-sm-3">
         <label for="rfc">RFC *: </label>
         <input type="text" class="form-control" value="<?php echo isset($datos[0]['rfc']) ? $datos[0]['rfc'] :  '' ?>" id="rfc" name="rfc">
     </div>
     <div class="col-sm-4">
          <label for="clabe">CLABE *: </label>
          <input type="text" class="form-control" value="<?php echo isset($datos[0]['clabe']) ? $datos[0]['clabe'] :  ''  ?>" id="clabe" name="clabe">
     </div>
     <div class="col-sm-5">
           <label for="internet">Internet: </label>
           <input type="text" class="form-control" value="<?php echo isset($datos[0]['url']) ? $datos[0]['url'] :  ''  ?>" id="internet" name="internet">
     </div>
  </div>
</div>
</div>
</div>
</div>
</div>
</div>

</div>

<div class="container">

<div class="row"></div>
<div class="form-group">
<div class="col-sm-12">
<div class="panel-group">
<div class="panel panel-default">
<div class="panel-heading"><b>Control Consecutivos</b></div>
           <div class="panel-body">
                 <div class="row">
                    <div class="col-sm-3">
                       <label for="cheques">Cheques: </label> <span class="fa fa-pencil" onclick="abilitarcheques()"></span>
                       <input type="text" class="form-control" readonly value="<?php echo isset($datos[0]['cheques']) ? $datos[0]['cheques'] : '0' ?>" onblur="desabilitarcheques()" id="cheques" name="cheques">
                    </div>
                    <div class="col-sm-3">
                        <label for="depositos">Depositos:</label> <span class="fa fa-pencil" onclick="abilitardepositos()"></span>
                        <input type="text" class="form-control" readonly value="<?php echo isset($datos[0]['depositos']) ? $datos[0]['depositos'] : '0' ?>" onblur="desabilitardepositos()" id="depositos" name="depositos">
                    </div>
                    <div class="col-sm-3">
                        <label for="movimientos">Movimientos: </label> <span class="fa fa-pencil" onclick="abilitarmovimientos()"></span>
                        <input type="text" class="form-control" readonly value="<?php echo isset($datos[0]['movimiento']) ? $datos[0]['movimiento'] : '0' ?>" onblur="desabilitarmovimientos()" id="movimientos" name="movimientos">
                    </div>
                 </div>
           </div>
</div>
</div>
</div>
</div>


</div>


<div class="container">


<div class="row"></div>
<div class="form-group">
<div class="col-sm-12">
<div class="panel-group">
<div class="panel panel-default">
<div class="panel-heading"><b>Formatos de Impresion para Cheques</b></div>
           <div class="panel-body">
                 <div class="row">
                    <div class="col-sm-3">
                       <label for="formato1">Formato 1: </label>
                       <input type="text" class="form-control" id="formato1" name="formato1">
                    </div>
                    <div class="col-sm-3">
                        <label for="formato12">Formato 2:</label>
                        <input type="text" class="form-control" id="formato12" name="formato12">
                    </div>
                 </div>
           </div>
</div>
</div>
</div>
</div>


</div>

<div class= "form-group">
  <center>
    <button type="submit" class="btn btn-success btn-lg"><span class="fa fa-floppy-o"></span> Guardar</button>
    <a href="<?php echo base_url().'catalogos/Bancos/index'?>" class="btn btn-danger btn-lg" role="button"><span class="fa fa-times"></span> Cancelar</a>
 </center>
 </div>

 <script>
 function abilitarcheques()
 {
     $('#cheques').prop('readonly',false);
 }
 function desabilitarcheques()
 {
     var cheque = document.getElementById('cheques').value;
     var id = document.getElementById('numero').value;

     $.ajax({
        type:"POST",
        url: "<?php echo base_url();?>catalogos/Bancos/consecutivoscheques",
        data:{cheque:cheque,id:id},
        dataType:"html",
        success:function(response)
        {
            $('#cheques').prop('readonly',true);
        },
        error:function(msg)
        {
            var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Hubo un problema al modificar el consecutivo.'});
            $('#cheques').prop('readonly',true);
        }
     });

 }
 function abilitardepositos()
 {
     $('#depositos').prop('readonly',false);
 }
 function desabilitardepositos()
 {
    var depo = document.getElementById('depositos').value;
    var id = document.getElementById('numero').value;

     $.ajax({
        type:"POST",
        url:"<?php echo base_url();?>catalogos/Bancos/consecutivosdepositos",
        data:{depo:depo,id:id},
        dataType:"html",
        success:function(response)
        {
            $('#depositos').prop('readonly',true);
        },
        error:function(msg)
        {
            var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Hubo un problema al modificar el consecutivo.'});
            $('#depositos').prop('readonly',true);
        }
     });

     
 }
 function abilitarmovimientos()
 {
     $('#movimientos').prop('readonly',false);
 }
 function desabilitarmovimientos()
 {
     var id = document.getElementById('numero').value;
     var movi = document.getElementById('movimientos').value;

    $.ajax({
       type:"POST",
       url:"<?php echo base_url();?>catalogos/Bancos/consecutivosmovimiento",
       data:{movi:movi,id:id},
       dataType:"html",
       success:function(response)
       {
         $('#movimientos').prop('readonly',true);
       },
       error:function(msg)
       {
         var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Hubo un problema al modificar el consecutivo.'});
         $('#movimientos').prop('readonly',true);
       }
    });


 }
 function mostrarbanco()
 {
    var bancosat = document.getElementById('bancosat').value;
    $.ajax({
        type:"POST",
        url: "<?php echo base_url();?>catalogos/Bancos/getbancodesc",
        data:{bancosat:bancosat},
        dataType:"html",
        success:function(response)
        {
            response=JSON.parse(response);
           document.getElementById('bancosatdescripcion').value = response[0].nombre_c;
        }
    });
 } 
 </script>

<SCRIPT LANGUAGE='JavaScript'>
function readURL(input)
{
    if (input.files && input.files[0])
    {
        var reader = new FileReader();
        reader.onload = function (e) { $('#blah').attr('src', e.target.result); }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp").change(function(){ readURL(this);});

var handleFileSelect = function(evt) {
    var files = evt.target.files;
    var file = files[0];

    if (files && file) {
        var reader = new FileReader();

        reader.onload = function(readerEvt) {
            var binaryString = readerEvt.target.result;
            document.getElementById("imgBase64").value = btoa(binaryString);
        };

        reader.readAsBinaryString(file);
    }
};

if (window.File && window.FileReader && window.FileList && window.Blob) {
    document.getElementById('imgInp').addEventListener('change', handleFileSelect, false);
}
</SCRIPT>