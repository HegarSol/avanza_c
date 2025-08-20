<?php
if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
  $desabilitado="";
  if (isset($errores) && $errores!=""){
    for($i= 0; $i<count($errores); $i++)
    { echo "<script> var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: '".$errores[$i]."'});</script>"; }
  }
 
?>

<div class="container-fluid">
   <div class="panel panel-default">
        <div class="panel-heading">
           <form action="form-horizontal">
             <div class="form-group">
             <label class="control-label col-md-1" for="series">Serie</label>
               <div class="col-md-2">
                  <select name = "series" class="form-control" id="series" onchange="cargarSerie()">
                    <?php foreach($series as $serie): ?>
                    <option value="<?php echo $serie;?>"
                    <?php echo $serie == 'O' ? ' selected':'';?>>
                    <?php echo $serie;?></option>
                    <?php endforeach; ?>
                   </select>
               </div>
               <br>
             </div>
           </form>
        </div>
        <div class="panel-body">
           <table id="polizas" class="stripe row-border responsive nowrap" cellspacing="0" width="100%">
              <thead style="background-color:#5a5a5a; color:white;">
                 <tr>
                    <th>#Poliza</th>
                    <th>tipo_mov</th>
                    <th>Serie</th>
                    <th>Fecha</th>
                    <th>Concepto</th>
                    <th>Acciones</th>
                 </tr>
              </thead>
           </table>
        </div>
        <div class="panel-footer">
            <button onclick="btnCrear()" class="btn btn-success btn-lg" role="button"><span class="glyphicon glyphicon-plus"></span> Agregar poliza diaria</button>
        </div>
   </div>
   <div class="col-md-2 col-ls-2 col-sm-3" align="center">
    <br>
   </div><br>
   <div class="col-md-10 col-lg-10 col-sm-9">
   </div><div class="col-sm-1"></div>
</div>

<script>

   var original_link = "<?php echo base_url();?>catalogos/Polizasdiarias/agregar/";
    $(document).ready(function(){cargarSerie();});
   
    var table = $('#polizas').DataTable({
      responsive: true, filter:true, columnDefs:
      [ { responsivePriority: 1, targets: 1, name: 'tipo_mov'}, { responsivePriority: 2, targets: -1}, { responsivePriority: 3, targets: 2 }, { targets: [1], visible: false } ],
      order: [[1, 'desc']],
      processing: true, serverSide: true,
      ajax: { "url":baseurl + "catalogos/Polizasdiarias/ajax_list", "type": "POST"},  
      "language" : {"url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
    })
 
    function cargarSerie(){
        id = $("#series").val();
       // console.log(id);
       table.columns(1).search(id).draw();
      //  $.ajax({
      //    url: "<?php echo base_url();?>inicio/actualizarSerie/"+id,
      //    type: 'POST',
      //    dataType: 'json',
      //    success: function (response){},
      //  });
    };
    function btnCrear()
    {
      id = $('#series').val();
      var new_href = original_link + id;
      location.href=new_href;
      // $('#btnCrear').attr('href', new_href);
    }

</script>