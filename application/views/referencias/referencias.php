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
                         <label for="">Referencia:</label>
                         <input type="text"  class="form-control" value="<?php echo isset($datos) ? $datos[0]['referencia'] : '' ?>" id="referencia" name="referencia">
                       </div>
                          <div class="col-sm-5">
                             <label for="">Descripcion:</label>
                             <input type="text"  class="form-control" value="<?php echo isset($datos) ? $datos[0]['descripcion'] : '' ?>" id="descripcion" name="descripcion">
                          </div>
                   </div>

</div>

<br>
<br>
<br>

<div class="form-group">
    <center>
        <button type="button" class="btn btn-success btn-lg" onclick="guardardatos()"><span class="fa fa-floppy-o"></span> Guardar</button>
        <a href="<?php echo base_url().'catalogos/Referencias/index'?>" class="btn btn-danger btn-lg" role="button"><span class="fa fa-times"></span> Cancelar</a>
    </center>
</div>

<script>
    function guardardatos()
    {
         var id = document.getElementById('id').value;
         var referencia = document.getElementById('referencia').value;
         var des = document.getElementById('descripcion').value;

         $.ajax({
                type:"POST",
                url:"<?php echo base_url();?>catalogos/Referencias/guardarrefe",
                data:{id:id,referencia:referencia,descripcion:des},
                dataType:"html",
                success:function(data)
                {
                    if(data == "1")
                    {
                        swal('Correcto','guardado correctamente','success');
                        setTimeout(function(){ window.location.href=baseurl+'catalogos/Referencias/index'; }, 500);
                    }
                    else
                    {
                        noty({layout:'topRight',type: 'warning',  theme: 'relax',text: 'Error al guardar la referencia'});
                    }
                }
         })
    }
</script>