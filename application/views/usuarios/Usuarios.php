<?php if (!defined('BASEPATH')) exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');?>
<div class="container" >
<?php
  echo validation_errors();
  echo form_open($accion,'name="f1" id="f1"');
  if (isset($errores)){
    for($i= 0; $i<count($errores); $i++)
    { echo "<script> var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: '".$errores[$i]."'});</script>"; }
  }
      if(!isset($tUsuario)){ $tUsuario="";}
      $atributos = array('class' => 'form-control');
?>
Los campos marcados con * son obligatorios.<br><br>
<div class="col-sm-8">
<div class="form-group">
  <input class="form-control"  id="id" name ="id" value="<?php echo isset($datos[0]['id']) ? $datos[0]['id']: set_value('id') ?>" type="hidden">
  <label class="control-label col-sm-4" for="nombreU">Nombre Usuario:*</label>
  <div class="col-sm-8"> <?php echo form_input('nombre',set_value('nombre',isset($datos[0]['name']) ? $datos[0]['name'] : ''),$atributos); ?></div>
</div><div class="col-sm-12"><br></div>
<div class="form-group" >
    <label class="control-label col-sm-4"type="email" for="usuario">Usuario:*<span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Debe ser un correo electrónico válido"></span></label>
  <div class="col-sm-8"> <?php  echo form_input('correo',set_value('correo',isset($datos[0]['email']) ? $datos[0]['email'] : ''),$atributos); ?></div><div class="col-sm-12"><br></div></div>
  <div class="form-group" >
    <label class="control-label col-sm-4" for="password">Contraseña:*<span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Debe de contener al menos 5 caracteres"></span></label>
    <div class="col-sm-8"> <?php echo form_input(array('name'=>'contrasena','id'=>'contrasena','type' => 'password'),set_value('contrasena',isset($datos[0]['pass']) ? 'password': ''),$atributos); ?>
    </div></div><div class="col-sm-12"><br></div>
  <div class="form-group" >
    <label class="control-label col-sm-4" for="repassword">Re-escribir Contraseña:*</label>
    <div class="col-sm-8">
      <input type = "password" id="recontrasena" onblur="compararContras()" value="<?php echo isset($datos[0]['pass']) ? 'password': set_value('contrasena') ?>" name="recontrasena" class="form-control" >
    </div></div><div class="col-sm-12"><br></div>
      <div class="form-group"><label  class="control-label col-sm-4"  for="tUsuario">Tipo Usuario:</label>
          <div class="col-sm-8">
            <select class="form-control " id="tUsuario" name="tUsuario" onchange="Permisos();">
            <?php
            if($_SESSION['tipo']=="SU")
            {
              echo '<option value="SU"';  if($tUsuario=='SU') echo 'selected'; echo '>Super Usuario</option>';
              echo '<option value="admin"';  if($tUsuario=='admin') echo 'selected'; echo '>Administrativo</option>';
              echo '<option value="hegar"';  if($tUsuario=='hegar') echo 'selected'; echo '>Administrativo Hegarss</option>';
            }
            else if($datos[0]['id']==$_SESSION['id'])
            {
              echo '<option value="admin"';  if($tUsuario=='admin') echo 'selected'; echo '>Administrativo</option>';
            }
            ?>
              <option value="usuario" <?php if($tUsuario=='usuario') echo 'selected' ?>>Usuario Default</option>
            </select><br>
          </div>
      </div>
  
  <!-- <div class="form-group"  <?php echo !isset($datos)?'style="visibility:hidden; display:none;"':''; ?>>
    <label class="control-label col-sm-4" for="series">Correo Envío: </label>
    <div class="col-sm-8">
       <select name = "correos" class="form-control" id="correos">
         <option value=""></option>
          <?php foreach($correos as $correo): ?>
          <option value="<?php echo $correo['idCorreo'];?>"
          <?php echo isset($correoD) && $correoD == $correo['idCorreo'] ? ' selected':'';?>>
          <?php echo $correo['from1'];?></option>
          <?php endforeach; ?>
        </select>
    </div>
  </div> -->
          </div>
<div class="col-sm-4">
<div class="form-group">
  <label class="control-label col-sm-2" for="updates">Foto: </label>
  <textarea id="base64textarea" name="base64textarea" placeholder="Base64 will appear here" cols="50" rows="15" hidden></textarea>
  <div class="col-sm-6"><img id="blah" src="<?php echo isset($img) && $img!="0" ? "data:image/jpeg;base64,$img": base_url().'public/img/defaultUser.png'?>" alt="your image" width="150px" height="170px" /></div>
    <input id="imgInp" name="imgInp" type="file" >
</div>
</div>
<?php
 if($_SESSION['tipo']=="admin" || $_SESSION['tipo']=="SU")
 {
   echo " <script>$(document).ready(function(){Permisos()});</script>";
   echo '<div class="col-sm-12" style="display:none;" id="permisos" name="permisos"><b><font size= "5"> <p align="left">Permisos</p></font></b>
   <div class="col-md-12" style="overflow-x:auto;"> <div class="table-responsive">
   <table class="table table-striped" style="background-color:#d3d3d3;">
   <thead style="background-color:#222222; color:white;">
   <tr> <th width="350">Forma</th> <th width="50">Leer</th> <th width="50">Agregar</th> <th width="50">Editar</th> <th width="50">Borrar</th> <th width="50">Imprimir</th> </tr>
   </thead>
     <tbody>';
       for($i=0; $i<count($formas); $i++)
       {
         $nf=$formas[$i]['nombrForma'];
         $js = array('onClick' => 'SelecLeer(\''.$formas[$i]['nombrForma'].'\')');
         echo '<tr><td width="350" class="filterable-cell">'.$formas[$i]['descripcion'].'</td>';
         if(isset($permisos) && $i<count($permisos))
         {
           echo '<td width="70">';
           echo form_checkbox(array("name"=>"leer$nf","type"=>"checkbox","id"=>"leer$nf"),'1',set_checkbox("leer$nf",1,$permisos[$i]['leer']==1 ? TRUE : FALSE),array('onClick' => 'DesLeer(\''.$formas[$i]['nombrForma'].'\')'));
           echo 'Leer</td> <td width="70">';
           echo form_checkbox(array("name"=>"agregar$nf","type"=>"checkbox","id"=>"agregar$nf"),'1',set_checkbox("agregar$nf",1,$permisos[$i]['agregar']==1 ? TRUE : FALSE),$js);
           echo 'Agregar</td><td width="70">';
           echo form_checkbox(array("name"=>"editar$nf","type"=>"checkbox","id"=>"editar$nf"),'1',set_checkbox("editar$nf",1,$permisos[$i]['editar']==1 ? TRUE : FALSE),$js);
           echo 'Editar</td><td width="70">';
           echo form_checkbox(array("name"=>"borrar$nf","type"=>"checkbox","id"=>"borrar$nf"),'1',set_checkbox("borrar$nf",1,$permisos[$i]['borrar']==1 ? TRUE : FALSE),$js);
           echo 'Borrar</td><td width="70">';
           echo form_checkbox(array("name"=>"print$nf","type"=>"checkbox","id"=>"print$nf"),'1',set_checkbox("print$nf",1,$permisos[$i]['print']==1 ? TRUE : FALSE),$js);
        }
       else
       {
          echo '<td width="70">';
          echo form_checkbox(array("name"=>"leer$nf","type"=>"checkbox","id"=>"leer$nf"),'1',set_checkbox("leer$nf",1,FALSE),array('onClick' => 'DesLeer(\''.$formas[$i]['nombrForma'].'\')'));
          echo 'Leer</td> <td width="70">';
          echo form_checkbox(array("name"=>"agregar$nf","type"=>"checkbox","id"=>"agregar$nf"),'1',set_checkbox("agregar$nf",1,FALSE),$js);
          echo 'Agregar</td> <td width="70">';
          echo form_checkbox(array("name"=>"editar$nf","type"=>"checkbox","id"=>"editar$nf"),'1',set_checkbox("editar$nf",1,FALSE),$js);
          echo 'Editar</td> <td width="70">';
          echo form_checkbox(array("name"=>"borrar$nf","type"=>"checkbox","id"=>"borrar$nf"),'1',set_checkbox("borrar$nf",1,FALSE),$js);
          echo 'Borrar</td><td width="70">';
          echo form_checkbox(array("name"=>"print$nf","type"=>"checkbox","id"=>"print$nf"),'1',set_checkbox("print$nf",1,FALSE),$js);
        }
         echo 'Imprimir</td></tr>';
        }
        echo "</tbody></table></div></div></div>";
 }
?>
<div class="form-group">
  <div class="col-sm-offset-2 col-sm-10"><br><br>
    <button type="submit" name="submit" class="btn btn-lg btn-success btn-signin" value="upload"><span class="fa fa-floppy-o"></span> Guardar</button>
  <a href="<?php echo base_url();?>usuarios/index" class="btn btn-danger btn-lg" role="button"><span class="fa fa-times"></span> Cancelar</a>
  </div></form>
</div>

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

function Permisos()
{
  var tipo=x("tUsuario").value;
  if(tipo=="usuario")
  {
    $("#permisos").show();
  }
  else {
    $("#permisos").hide();
  }
}

$("#imgInp").change(function(){ readURL(this);});

var handleFileSelect = function(evt) {
    var files = evt.target.files;
    var file = files[0];
    if (files && file)
    {
      var reader = new FileReader();
      reader.onload = function(readerEvt)
      {
          var binaryString = readerEvt.target.result;
          document.getElementById("base64textarea").value = btoa(binaryString);
      };
      reader.readAsBinaryString(file);
    }
};
if (window.File && window.FileReader && window.FileList && window.Blob) { document.getElementById('imgInp').addEventListener('change', handleFileSelect, false);}
</SCRIPT>
