<?php
if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
  $desabilitado="";
  if (isset($errores) && $errores!=""){
    for($i= 0; $i<count($errores); $i++)
    { echo "<script> var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: '".$errores[$i]."'});</script>"; }
  }
 
?>

<div class= "contairner-fluid">
   <div class="panel panel-default">
      <div class="panel-heading">
         <form class="form-horizontal">
            <div class="form-group">
            </div>
         </form>
         <div class="col-sm-1"></div><label for=""><h4>Banco :  <?php echo $datos[0]['banco']; ?> </h4></label>
      </div>
      <div class="panel-body">      
         <table id="operaciones" class="stripe row-border responsive nowrap"  cellspacing="0" width="100%">
            <thead style="background-color:#5a5a5a; color:white;">
               <tr>                
                  <th>#Poliza</th>
                  <th>Fecha</th>
                  <th>Concepto</th>
                  <th>Monto</th>
                  <th>Acciones</th>
               </tr>
         </thead>
         </table>
      </div>
      <div class="panel-footer">
         <a href="<?php echo base_url().'catalogos/Bancos/index'?>" class="btn btn-info btn-lg" role="button"><span class="fa fa-arrow-left"></span> Atras</a>
         <?php 
         if($tipo == 1)
         {
        ?>
             <button type="button" class="btn btn-success btn-lg" role="button" data-toggle="modal" data-target="#myModaltransfe"><span class="glyphicon glyphicon-plus"></span> Nueva transferencia </button>
        <?php
         }
         else
         {
         ?>
             <a href="<?php echo base_url().'catalogos/Bancos/nuevaoperacion/'.$id.'/'.$tipo.''?>" class="btn btn-success btn-lg" role="button"><span class="glyphicon glyphicon-plus"></span> Nuevo <?php if($tipo == 2){ echo 'cheque'; }else{echo 'depósito';}?></a>    
         <?php
         }
         ?>

      </div>
   </div>
  <div class="col-md-2 col-lg-2 col-sm-3" align="center">
    <br>
     </div><br>
  <div class="col-md-10 col-lg-10 col-sm-9">
  </div><div class="col-sm-1"></div>
</div>

<div class="modal fade" id="myModaltransfe" role="dialog" >
<div class="modal-dialog" >
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title"> Tipo de Transferencia</h1>
        </div>
        <div class="modal-body" >
              <div class="row">
                        <div class="col-sm-2"></div>
                        <a href="<?php echo base_url().'catalogos/Bancos/nuevaoperacion/'.$id.'/'.$tipo.'/plu'?>" id="urlope1" rel="nofollow" class="btn btnGrande" type="button">
                        <span class="fa fa-plus fa-4x"></span>
                        <br>
                        <br>
                        <b><font size="5">Cargo</font></b>
                        </a>

                        <a href="<?php echo base_url().'catalogos/Bancos/nuevaoperacion/'.$id.'/'.$tipo.'/min'?>" id="urlope1" rel="nofollow" class="btn btnGrande" type="button">
                        <span class="fa fa-minus fa-4x"></span>
                        <br>
                        <br>
                        <b><font size="5">Abono</font></b>
                        </a>
              </div>
        </div>
    </div>
</div>
</div>


<style>
.btnGrande {
    background-color: #1C9C69;
    color:white;
    border:1px;
    width:31%;
    height:30%;
    font-size:10px;
    border-radius:10px;
    margin-right:10px;
}
</style>


<script>
  //OPERACIONES
  $(function(){
    $('#operaciones').dataTable({
      responsive: true, filter:true, columnDefs:
      [ { responsivePriority: 1, targets: 0 }, { responsivePriority: 2, targets: -1 }, { responsivePriority: 3, targets: 2 } ],
      processing: true, serverSide: true,
      ajax: { "url": baseurl + "catalogos/Operaciones/ajax_list/"+'<?php echo $tipo;?>/'+'<?php echo $id;?>',"type": "POST" },"language" : {"url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
    })
 });
</script>