<div class="container" >
<?php
  echo validation_errors();
  echo form_open($accion);
  if (isset($errores)){
    for($i= 0; $i<count($errores); $i++)
    { echo "<script> var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: '".$errores[$i]."'});</script>"; }
  }
      if(!isset($tUsuario)){ $tUsuario="usuario";}
?>
Los campos marcados con * son obligatorios.<br>
<div class="col-sm-7">
<div class="form-group">
  <input class="form-control"  id="id" name ="id" value="<?php echo isset($datos[0]['id']) ? $datos[0]['id']: set_value('id') ?>" type="hidden">
  <label class="control-label col-sm-4" for="nombreU">Nombre:</label>
  <div class="col-sm-8"> <?php echo form_input(array('name'=>'nombre','class'=>'form-control'),set_value('nombre',isset($datos[0]['name']) ? $datos[0]['name'] : '')); ?></div>
</div><div class="col-sm-12"><br></div>
<div class="form-group" >
    <label class="control-label col-sm-4"type="email" for="usuario">Usuario:*<span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Debe ser un correo electrónico válido"></span></label>
  <div class="col-sm-8"> <?php echo form_input(array('name'=>'correo','class'=>'form-control'),set_value('correo',isset($datos[0]['email']) ? $datos[0]['email'] : '')); ?></div><div class="col-sm-12"><br></div></div>
  <div class="form-group" >
    <label class="control-label col-sm-4" for="password">Contraseña:*<span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Debe de contener al menos 5 caracteres"></span></label>
    <div class="col-sm-8"> <?php echo form_input(array('name'=>'contrasena','id'=>'contrasena','type' => 'password','class'=>'form-control'),set_value('contrasena',isset($datos[0]['pass']) ? 'password': '')); ?>
    </div></div><div class="col-sm-12"><br></div>
  <div class="form-group" >
    <label class="control-label col-sm-4" for="repassword">Re-escribir Contraseña:*</label>
    <div class="col-sm-8">
      <input type = "password" id="recontrasena" onblur="compararContras()" class="form-control" value="<?php echo isset($datos[0]['pass']) ? 'password': set_value('contrasena') ?>" name="recontrasena" >
    </div>
  </div>
</div>
<div class="col-sm-5">
  <div class="form-group">
    <label class="control-label col-sm-2" for="updates">Foto: </label>
    <textarea id="base64textarea" name="base64textarea" placeholder="Base64 will appear here" cols="50" rows="15" hidden></textarea>
    <div class="col-sm-6"><img id="blah" src="<?php echo isset($img) && $img!="0" ? "data:image/jpeg;base64,$img": base_url().'public/img/defaultUser.png'?>" alt="your image" width="150px" height="170px" /></div>
      <input id="imgInp" name="imgInp" type="file" >
  </div>
</div>

<div class="form-group">
  <div class="col-sm-offset-2 col-sm-10"><br>
  <button type="submit" name="submit" class="btn btn-lg btn-primary btn-signin">Guardar</button>
  <a href="<?php echo base_url();?>Welcome" class="btn btn-danger btn-lg" role="button">Cancelar</a>
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

$("#imgInp").change(function(){ readURL(this);});

var handleFileSelect = function(evt) {
    var files = evt.target.files;
    var file = files[0];

    if (files && file) {
        var reader = new FileReader();

        reader.onload = function(readerEvt) {
            var binaryString = readerEvt.target.result;
            document.getElementById("base64textarea").value = btoa(binaryString);
        };

        reader.readAsBinaryString(file);
    }
};

if (window.File && window.FileReader && window.FileList && window.Blob) {
    document.getElementById('imgInp').addEventListener('change', handleFileSelect, false);
}
</SCRIPT>
