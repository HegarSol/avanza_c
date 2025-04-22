<?php

if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
echo validation_errors();
echo form_open_multipart($accion);

?>


<div class="container">
      
<div class="panel-heading"><input type="hidden" class="form-control" readonly id="id" name="id" value="<?php echo isset($datos[0]['id']) ? $datos[0]['id'] : '0'?>"></div>

                   <div class="row">
                       <div class="col-sm-2">
                         <label for="">Clave:</label>
                         <input type="text"  class="form-control" value="<?php echo isset($datos) ? $datos[0]['clave'] : '' ?>" id="clave" name="clave">
                       </div>
                          <div class="col-sm-5">
                             <label for="">Descripcion:</label>
                             <input type="text"  class="form-control" value="<?php echo isset($datos) ? $datos[0]['descripcion'] : '' ?>" id="descripcion" name="descripcion">
                          </div>
                          <div class="col-sm-2">
                             <label for="">Matriz:</label>
                             <input type="text"  class="form-control" value="<?php echo isset($datos) ? $datos[0]['matriz'] : '' ?>" id="matriz" name="matriz">
                          </div>   
                   </div>

</div>

<br>
<br>
<br>

<div class="form-group">
    <center>
        <button type="button" class="btn btn-success btn-lg" onclick="guardardatos()"><span class="fa fa-floppy-o"></span> Guardar</button>
        <a href="<?php echo base_url().'catalogos/DeptosCostos/index'?>" class="btn btn-danger btn-lg" role="button"><span class="fa fa-times"></span> Cancelar</a>
    </center>
</div>

<script>
    function guardardatos()
    {
         var id = document.getElementById('id').value;
         var clave = document.getElementById('clave').value;
         var des = document.getElementById('descripcion').value;
         var matriz = document.getElementById('matriz').value;

         $.ajax({
                type:"POST",
                url:"<?php echo base_url();?>catalogos/DeptosCostos/guardarcostos",
                data:{id:id,clave:clave,descripcion:des,matriz:matriz},
                dataType:"html",
                success:function(data)
                {
                    if(data == "1")
                    {
                        swal('Correcto','guardado correctamente','success');
                        setTimeout(function(){ window.location.href=baseurl+'catalogos/DeptosCostos/index'; }, 500);
                    }
                    else
                    {
                        noty({layout:'topRight',type: 'warning',  theme: 'relax',text: 'Error al guardar el departamento costos'});
                    }
                }
         })
    }
</script>