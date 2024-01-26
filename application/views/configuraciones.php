<?php 

if(!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
  $desabilitado="";
  if (isset($errores) && $errores!=""){
    for($i= 0; $i<count($errores); $i++)
    { echo "<script> var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: '".$errores[$i]."'});</script>"; }
  }

?>


<br><br><br><br>
<div class="container">

<div class="col-md-3">
     Tipo:
      <select name="confige" id="confige" class="form-control">
        <option value="" selected> -Seleccione- </option>
          <?php foreach ($confige as $rowmoneda)
            {
                echo"<option value='".$rowmoneda['parent']."'";

                echo '>'.$rowmoneda['parent']; 
                
                echo "</option>";}
            ?>
      </select>
</div>

<div class="col-md-3">
    <br>
    <button type="button" class="btn btn-primary" onclick="buscarconfi()"><span class="fa fa-search"></span> Buscar</button>
</div>

</div>

<br>
<br>
<br>

<div class="modal fade" id="modalModificarConfi" role="dialog">
   <div class="modal-dialog" role="document">
	  <div class="modal-content">
		 <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
			   <span aria-hidden="true">&times;</span>
			</button>
			<h3 class="modal-title">Modificar Configuración</h3>
            <input type="hidden" id="idgene" readonly name="idgene">
		 </div>
		 <div class="modal-body">
            <div class="row">
                    <div class="col-md-7">
                        Valor:
                        <input type="text" class="form-control" id="valor" name="valor">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-7">
                        Inactiva
                        <input type="text" class="form-control" id="inactiva" name="inactiva">
                    </div>
              </div>
		 </div>
		 <div class="modal-footer">
            <button type="button" class="btn btn-success" onclick="guardareditadoconfig()">Guardar</button>
			<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
		 </div>
	  </div>
   </div>
</div>

<div id="espacioconfig"></div>

<script>
function guardareditadoconfig()
{
    var id = document.getElementById('idgene').value;
    var valor = document.getElementById('valor').value;
    var inac = document.getElementById('inactiva').value;

    if(valor == '' || inac == '')
    {
        var n = noty({text: 'No deje los campos vacios', type: 'warning', theme: 'relax'});
    }
    else
    {
       jQuery.ajax({
           type:"POST",
           url: baseurl + "Configuraciones/editconfig",
           data:{valor:valor,inac:inac,id:id},
           dataType:"html",
           success:function(response)
           {
               $('#modalModificarConfi').modal('hide');
             buscarconfi();
           }
       });
    }
}
function elegirconfge(id,valor,ina)
{
   document.getElementById('idgene').value = id;
   document.getElementById('valor').value = valor;
   document.getElementById('inactiva').value = ina;

   $('#modalModificarConfi').modal('show');
}
function buscarconfi()
{

   var confge = document.getElementById('confige').value;
   if(confge == '')
   {
      swal("Advertencia","Seleccione el tipo de configuración","warning");
   }
   else
   {
        jQuery.ajax({
            type:"POST",
            url: baseurl + "Configuraciones/getconfige",
            data:{confge:confge},
            datatype:"html",
            success:function(data)
            {
                $('#espacioconfig').html(data);
                $('#tabla_conf_gene').DataTable({
                language: { "url" : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
                "sDom": 'T<"clear">lfrtip', "oTableTools": {  "sRowSelect": "single","aButtons": ""},
                "columnDefs" : [
                    {
                        "targets" : [-1],
                        "orderable" : false
                    }
                ]
            });
            },
            error:function()
            {
                var n = noty({text: 'Error al recuperar la informacion', type: 'error', theme: 'relax'});
            }
        });
    }
}


</script>