<?php
 if (!defined('BASEPATH'))
 exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
 echo validation_errors();
 echo form_open($accion);

?>

<br>
<br>
<?php
if(isset($mensaje))
{
    echo '<strong>'.$mensaje['mensaje'].'</strong>';
}
?>
<br>

<div class="container">

<div class="row"></div>
<div class="form-group">
<div class="col-sm-12">
<div class="panel-group">
<div class="panel panel-default">
<div class="panel-heading"><b>Cuentas</b></div>
<div class="panel-body">
  <input type="hidden" class="form-control" readonly id="idcuenta" name="idcuenta" value="<?php echo isset($datos[0]['idcuenta']) ? $datos[0]['idcuenta'] : '0'?>">
    <div class="row">
    <label class="control-label col-sm-1" for="cuenta">Cuenta:</label>
        <div class="col-sm-2">
            <input type="text" class="form-control" id="cuenta" onblur="elegirTipo()" name="cuenta" <?php echo isset($datos[0]['cuenta']) ? 'readonly' : '' ?> value="<?php echo isset($datos[0]['cuenta']) ? $datos[0]['cuenta'] : '' ?>">
        </div>
    <label class="control-label col-sm-1" for="sub_cta">Sub Cuenta:</label>
        <div class="col-sm-2">
            <input type="text" class="form-control" id="sub_cta" name="sub_cta" <?php echo isset($datos[0]['sub_cta']) ? 'readonly' : '' ?> value="<?php echo isset($datos[0]['sub_cta']) ? $datos[0]['sub_cta'] : '' ?>">
        </div>
    <label class="control-label col-sm-1" for="ssub_cta">Ssub cuenta:</label>
       <div class="col-sm-2">
           <input type="text" class="form-control" id="ssub_cta" name="ssub_cta" <?php echo isset($datos[0]['ssub_cta']) ? 'readonly' : ''?> value="<?php echo isset($datos[0]['ssub_cta']) ? $datos[0]['ssub_cta'] : ''?>">
        </div>
    </div>
    <br>
    <div class="row">
    <label class="control-label col-sm-2" for="nombre">Nombre:</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo isset($datos[0]['nombre']) ? $datos[0]['nombre'] : '' ?>">
        </div>       
    </div>
    <br>
    <div class="row">
    <label class="control-label col-sm-2" for="ctasat">Cuenta SAT:</label>
        <div class="col-sm-6">
        <select name="ctasat" id="ctasat" class="form-control">
        <option value="-" selected></option>
             <!-- <option value="-" selected ></option> -->
              <?php foreach($cuentas as $cuenta)
              {
                  echo "<option value='".$cuenta['clave']."'";
                  if(isset($datos))
                  {
                      if($cuenta['clave'] == $datos[0]['ctasat'])
                      {
                         echo "selected";
                      }
                  }
                  echo '>'.$cuenta['clave']. ' - ' .$cuenta['descrip'];
                  echo "</option>";
              }
              ?>
              <!-- <option value="A">A</option>
              <option value="D">D</option> -->
            </select>
           <!-- <input type="text" class="form-control" id="ctasat" name="ctasat" value="<?php echo isset($datos[0]['ctasat']) ? $datos[0]['ctasat'] : '' ?>"> -->
        </div>
    <label class="control-label col-sm-1" for="natur">Naturaleza:</label>
         <div class="col-sm-2">
            <select name="natur" id="natur" class="form-control">
               <?php
               if(isset($datos[0]['natur']))
               {

                   if($datos[0]['natur'] == 'A')
                   {
                        echo "<option> -Seleccione- </option>";
                        echo "<option value='".$datos[0]['natur']."' selected> A </option>";
                        echo "<option value='D'> D </option>";
                   }
                   else
                   {
                        echo "<option> -Seleccione- </option>";
                        echo "<option value='".$datos[0]['natur']."' selected> D </option>";
                        echo "<option value='A'> A </option>";
                   }
               }
               else
               {
                ?>      
                        <option value=""> -Seleccione- </option>             
                        <option value="A">A</option>
                        <option value="D">D</option>
                <?php
                }                
                ?>

              

            </select>
         </div>
    </div>
    <br>
    <div class="row">
      <label class="control-label col-sm-2" for="cvecobro">Clave cobro:</label>
         <div class="col-sm-2">
             <input type="text" class="form-control" id="cvecobro" name="cvecobro" value="<?php echo isset($datos[0]['cvecobro']) ? $datos[0]['cvecobro'] : ''?>">
         </div>
         <label class="control-label col-sm-1" for="tipo">Tipo:</label>
        <div class="col-sm-2">
            <select name="tipo" id="tipo"  class="form-control">
                <?php
                if($datos[0]['tipo'] == 1)
                {
                ?>
                    <option value=""> -Seleccione- </option>
                    <option value="1" selected>1- Ingreso</option>
                    <option value="2">2- Costos/Compras</option>
                    <option value="3">3- Gastos Generales</option>
                    <option value="4">4- Gastos Financieros</option>
                <?php
                }
                else if($datos[0]['tipo'] == 2)
                {
                ?>
                    <option value=""> -Seleccione- </option>
                    <option value="1">1- Ingreso</option>
                    <option value="2" selected>2- Costos/Compras</option>
                    <option value="3">3- Gastos Generales</option>
                    <option value="4">4- Gastos Financieros</option>
                <?php
                }
                else if($datos[0]['tipo'] == 3)
                {
                ?>
                    <option value=""> -Seleccione- </option>
                    <option value="1">1- Ingreso</option>
                    <option value="2">2- Costos/Compras</option>
                    <option value="3" selected>3- Gastos Generales</option>
                    <option value="4">4- Gastos Financieros</option>
                <?php
                }
                else if($datos[0]['tipo'] == 4)
                {
                ?>
                    <option value=""> -Seleccione- </option>
                    <option value="1">1- Ingreso</option>
                    <option value="2">2- Costos/Compras</option>
                    <option value="3">3- Gastos Generales</option>
                    <option value="4" selected>4- Gastos Financieros</option>
                <?php
                }
                else
                {
                ?>
                    <option value="" selected> -Seleccione- </option>
                    <option value="1">1- Ingreso</option>
                    <option value="2">2- Costos/Compras</option>
                    <option value="3">3- Gastos Generales</option>
                    <option value="4" >4- Gastos Financieros</option>
                <?php
                }
                ?>


            </select>
        </div>
    </div>

    </div>
</div>
</div>
</div>
</div>


</div>

<br>
<br>

<div clas= "form-group">
  <center>
    <button type="submit" class="btn btn-success btn-lg"><span class="fa fa-floppy-o"></span> Guardar</button>
    <a href="<?php echo base_url().'catalogos/Cuentas/index'?>" class="btn btn-danger btn-lg" role="button"><span class="fa fa-times"></span> Cancelar</a>
 </center>
 </div>

</form>


<script>
    function elegirTipo()
    {
        var cta = document.getElementById('cuenta').value;

        jQuery.ajax({
              type:"POST",
              url: '<?php echo base_url() ?>catalogos/Cuentas/getSubCuentas',
              data:{cta:cta},
              dataType:"html",
              success:function(data)
              {
                document.getElementById('tipo').value = data;
              }
        });
    }
</script>