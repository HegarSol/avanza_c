<script src="<?php echo base_url('public/js');?>/versiones.js"></script>
<?php $data=array('titulo'=>"Bienvenido a Avanza F");?>
<?php $this->load->view('templates/header');?>
<?php $this->load->view('templates/navigation');?>
  <b><font size= "8" style="font-family:Calibri,'Helvetica Neue',Helvetica,Arial,sans-serif;"> <p align="center">Bienvenido a Avanza C</p></font></b>
<div class="col-sm-10 col-sm-offset-1">
  <button class="btn btnGrande" onclick="window.location.href=baseurl+'catalogos/bancos/index'">
    <span style="font-size:150px;" class="fa fa-university"></span><br>
    <b>Bancos</b>
  </button>
  <button class="btn btnGrande" onclick="window.location.href=baseurl+'catalogos/cuentas/index'">
    <span style="font-size:150px;" class="glyphicon glyphicon-list-alt"></span><br>
    <b>Cuentas</b>
  </button>
  <button class="btn btnGrande" onclick="window.location.href=baseurl+'catalogos/beneficiarios/index'">
    <span style="font-size:150px;" class="fa fa-user"></span><br>
    <b>Beneficiarios</b>
  </button>
</div>
<div class="col-sm-10 col-sm-offset-1" style="max-height:100vh; overflow:auto;">
  <br>
  <b style="font-family:Calibri,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:30px">Registro de cambios de la aplicacion</b>
</div>
<div class="col-sm-10 col-sm-offset-1" style="font-size:18px;">
 <div class="col-sm-7">
 <div class="panel panel-default" style="padding:10px; height:300px; text-align:center;
  background: rgba(128,128,128, 0.65);">
  <b style="font-size:22px; color:white;  text-shadow: .5px .5px 5px black;">Versión Actual</b>
  <b id="versionActual" style="color:white;  text-shadow: .5px .5px 5px black;"></b>
  <div class="panel panel-default" style="padding:10px; height:90%; text-align:left !important;" id="VACar">
</div>
 </div>
 </div>
 <div class="col-sm-5">
 <div class="panel panel-default" style="padding:10px; height:300px; text-align:center;
  background: rgba(128,128,128, 0.65);">
  <b style="font-size:22px; color:white; text-shadow: .5px .5px 5px black;">Otras versiones</b>
  <div id="versiones" style="overflow-y:auto; height:90%;"></di>
 </div>
 </div>
</div>
</form>

<!---Modal para mostrar las características por versión-->
<div class="modal fade" id="myModalCaracteristicas" role="dialog" >
<div class="modal-dialog modal-lg" >
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Características de la versión</h1>
        </div>
        <div class="modal-body" >
          <div id="carModal">
          </div>
        </div>
    </div>
</div></div>
<style>
.btnC {
    font-size:16px;
    width:30%;
    white-space: nowrap;
    height:28%;
    margin-left:5px;
    background-color: #e6e6e6;
    text-shadow: .5px .5px 5px white;
    margin-bottom:5px;
    overflow: hidden;
    text-overflow: ellipsis;
    border:1px solid;
    border-color:#999999;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
}
.btnC:hover {
    background-color: #c0c0c0 !important;
    border:1px solid;
    border-color:#909090;
}
.btnC:focus {
  outline:1px !important;
}
.btnGrande {
    background-color: #303030 !important;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
    color:white;
    border:1px solid;
    border-color:#101010;
    display:inline;
    width:32%;
    height:35%;
    padding:14px 28px;
    cursor:pointer;
    font-size:33px;
    text-align:bottom;
    border-radius:10px;
    margin-right:10px;
}
.btnGrande:hover {
    background-color: #202020 !important;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
    color:#FFF733;
}
body {
   background-image: url("<?php echo base_url('public/img');?>/Presentacion2.jpg");
   background-color: #808080;
   background-repeat: no-repeat;
   background-position: center; /* Center the image */
   background-size: cover; /* Resize the background image to cover the entire container */
}
</style>
<script>
$(document).ready(function(){llenarVersiones();});
 function llenarVersiones(){
   console.log(versiones);
   $("#versionActual").html('(Versión '+versiones[versiones.length-1].id+ ' <i>'+
                          versiones[versiones.length-1].fecha+'</i>)');
   var htmlCVA='<p style="font-size:16px;"><ul>';
   for (var i = 0; i < versiones[versiones.length-1].caracteristicas.length; i++){
     htmlCVA+='<li>'+versiones[versiones.length-1].caracteristicas[i].caracteristica+'</li>';
   }
   htmlCVA+='</ul></p>';
  $("#VACar").html(htmlCVA);
   html="";
   for(var i=versiones.length-2; i>=0; i--){
     html+='<button class="btn btnC btn-default" onclick="verCaracteristicas('+i+')">'+
          '<b>Versión '+versiones[i].id+'<br>'+
          '<i>'+versiones[i].fecha+'</i></b>'+
        '</button>';
   }
   $("#versiones").html(html);
 }

 function verCaracteristicas(id){
   var html='<b style="font-size:22px">Versión '+versiones[id].id+'</b><br>';
   html+='<p style="font-size:16px;"><ul>';
   for (var i = 0; i < versiones[id].caracteristicas.length; i++){
     html+='<li>'+versiones[id].caracteristicas[i].caracteristica+'</li>';
   }
   html+='</ul></p>';
   $("#carModal").html(html);
   $("#myModalCaracteristicas").modal('show');
 }
</script>
