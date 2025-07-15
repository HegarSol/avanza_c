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
      </div>
      <div class="panel-body">
         <table id="Bancos" class="stripe row-border responsive nowrap"  cellspacing="0" width="100%">
            <thead style="background-color:#5a5a5a; color:white;">
               <tr>
                
                  <th>#Banco</th>
                  <th>Cuenta</th>
                  <th>Nombre</th>
                  <th>Acciones</th>
            </tr>
         </thead>
         </table>
      </div>
      <div class="panel-footer">
         <a href="<?php echo base_url();?>catalogos/Bancos/agregar" class="btn btn-success btn-lg" role="button"><span class="glyphicon glyphicon-plus"></span> Agregar Banco</a>
         <button type="button" class="btn btn-success btn-lg" <?php echo $permisosGrupo['print']==1 ? '':'disabled'?> onclick="ReporteExcelBancos()"><span class="fa fa-file-excel-o"></span> Exportar Excel </button>
      </div>
   </div>
  <div class="col-md-2 col-lg-2 col-sm-3" align="center">
    <br>
     </div><br>
  <div class="col-md-10 col-lg-10 col-sm-9">
  </div><div class="col-sm-1"></div>
</div>

<div class="modal fade" id="modaloperaciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

               <div class="modal-body">

                  <div class="panel-group">
                  <div class="panel panel-default">
                  <div class="panel-heading"><b>Operaciones Bancarias de:</b></div>
                  <div class="panel-body">
                  
                     <img id="blah" src="" width="200px" height="100px" />
                    
                      <div class="col-sm-6">
                        <b>Cuenta: <span id="no_cuenta" name="no_cuenta"></span></b>
                        <br>
                        <b>Nombre: <span id="nombre" name="nombre"></span></b>
                        <br>
                        <b><label for="">URL: </label> <a rel="nofollow" id="url2" href="#" class="automatic" target="_blank"><span id="url" name="url"></span></a></b>
                      </div>
                  </div>
                  </div>
                  </div>

                  <div class="panel-group">
                  <div class="panel panel-default">
                  <div class="panel-heading"><b>Seleccione la operación bancaria a realizar</b></div>
                  <div class="panel-body">
                    <div class="row">
                    
                        <a href="#" id="urlope1" rel="nofollow" class="btn btnGrande" type="button">
                        <span class="fa fa-share fa-4x"></span>
                        <br>
                        <br>
                        <b><font size="5">Transfer</font></b>
                        </a>

                        <a href="#" id="urlope2" rel="nofollow" class="btn btnGrande" type="button">
                        <span class="fa fa-credit-card fa-4x"></span>
                        <br>
                        <br>
                        <b><font size="5">Chequera</font></b>
                        </a>

                        <a href="#" id="urlope3" rel="nofollow" class="btn btnGrande" type="button">
                        <span class="fa fa-usd fa-4x"></span> &nbsp;&nbsp; <span class="fa fa-arrow-right fa-3x"></span> &nbsp;&nbsp; <span class="fa fa-university fa-4x"></span>
                        <br>
                        <br>
                        <b><font size="5">Depósitos</font></b>
                        </a>
                   </div>
 
              

                  </div>
                  </div>
                  </div>

                  <div class="panel-group">
                  <div class="panel panel-default">
                  <div class="panel-heading"><b>Seleccione el reporte a realizar</b></div>
                  <div class="panel-body">

                      <div class="row">
                          <a href="#" id="urlconci" class="btn btnGrande" type="button" class="btn btn-primary">
                             <span class="fa fa-files-o fa-4x"></span>
                              <br>
                              <br>
                              <b><font size="5">Conciliación</font></b>
                          </a>

                          <button class="btn btnGrande" type="button" class="btn btn-primary">
                             <span class="fa fa-usd fa-4x"></span>
                              <br>
                              <br>
                              <b><font size="5">Saldos</font></b>
                          </button>

                          <a href="#" id="urlimport" class="btn btnGrande" type="button" class="btn btn-primary">
                             <span class="fa fa-upload fa-4x"></span>
                              <br>
                              <br>
                              <b><font size="5">Importar Info</font></b>
                          </a>
                      </div>

                  </div>
                  </div>
                  </div>

               </div>
          
              <div class="modal-footer">

                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-times"></span> Cerrar</button>
              </div>

        </div>
      </div>
</div>

<script>
function ReporteExcelBancos()
{
    try
    {
        var xyz=false;
        var url = '<?php echo base_url();?>reportes/ReporteExcelBancos';
        $.ajax({
             type: "POST",
             url:url,
             data:{algo:1},
             success:function(msg)
             {
                 var i=0;
                 if(msg != '')
                 {
                     var tab_text="<h1>Reporte de Bancos</h1>"+
                     "<table border='2px'> <tr><td bgcolor='#D7D7D7'>#Banco</td><td bgcolor='#D7D7D7'>Cuenta</td><td bgcolor='#D7D7D7'>Nombre</td>";
                     for(i=0;i<msg.length;i++)
                     {
                         tab_text=tab_text+"<tr><td>"+msg[i].no_banco+"</td>"+
                         "<td>"+msg[i].cuenta+"</td>"+
                         "<td>"+msg[i].banco+"</td>";
                         tab_text=tab_text+"</tr>";
                     }

                     window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

                 }
                 else
                 {
                     swal("Error","Hubo un error al crear el archivo, por favor inténtelo de nuevo","error");
                 }
             }
        });
    }
    catch(e)
    {
        alert(e);
    }
}
function abriroperaciones(id)
{

   jQuery.ajax({
      type:"POST",
      url:"<?php echo base_url();?>catalogos/Bancos/getoperacionesbanco",
      data:{id:id},
      dataType:"html",
      success:function(response)
      {
         response=JSON.parse(response);
         document.getElementById("no_cuenta").innerHTML = response[0].cuenta;
         document.getElementById("nombre").innerHTML = response[0].banco;
         document.getElementById("url").innerHTML = response[0].url;

         if(response[0].logo == '')
         {
           document.getElementById('blah').setAttribute('src','data:image/png;base64,<?php echo base_url(); ?>public/img/logo.png');
         }
         else
         {
           document.getElementById('blah').setAttribute('src','data:image/png;base64,'+response[0].logo+'');
         }
         document.getElementById('url2').setAttribute('href','/././'+response[0].url);

         document.getElementById('urlope1').setAttribute('href','<?php echo base_url();?>catalogos/Bancos/operaciones/1/'+response[0].no_banco);
         document.getElementById('urlope2').setAttribute('href','<?php echo base_url();?>catalogos/Bancos/operaciones/2/'+response[0].no_banco);
         document.getElementById('urlope3').setAttribute('href','<?php echo base_url();?>catalogos/Bancos/operaciones/3/'+response[0].no_banco);

         document.getElementById('urlconci').setAttribute('href','<?php echo base_url();?>catalogos/Conciliacion/index/'+response[0].no_banco);
         document.getElementById('urlimport').setAttribute('href','<?php echo base_url();?>catalogos/Importan/index/'+response[0].no_banco);
         
         $('#modaloperaciones').modal('show');
      }
   });

}


</script>

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
