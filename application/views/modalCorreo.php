
<div class="modal fade" id="modalCorreo" role="dialog" >
<div class="modal-dialog modal-lg" >
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Configuración de Correo</h1>
        </div>
        <div class="modal-body" >
<div class="row">
   <div class="form-group">
     <div class="col-sm-1"></div>
     <?php echo form_input(array('name'=>'idCorreo','id'=>'idCorreo','type'=>"hidden"),'0'); ?>
     <div class="col-sm-5"><label>Host:</label><?php echo form_input(array('name'=>'host','id'=>'host','class' =>'form-control'),''); ?></div>
     <div class="col-sm-3"><label>Autenticacion SMTP:</label><div class="checkbox"><input class="form-control" type="checkbox" name="SMTPAuth" id="SMTPAuth" value="1"></div></div>
     <div class="col-sm-3"><label>Correo Default:</label><div class="checkbox"><input class="form-control" type="checkbox" name="default" id="default" value="1"></div>
   </div>  <div class="col-sm-12"><br></div>
   <div class="form-group">
     <div class="col-sm-1"></div>
     <div class="col-sm-5"><label>Nombre de Usuario:</label><?php echo form_input(array('name'=>'userName','id'=>'userName','class' =>'form-control'),''); ?></div>
     <div class="col-sm-5"><label>Contraseña:</label><?php echo form_input(array('name'=>'password','id'=>'password','type'=>'password','class' =>'form-control'),''); ?></div>
     <div class="col-sm-1"></div>
   </div>  <div class="col-sm-12"><br></div>
   <div class="form-group">
     <div class="col-sm-1"></div>
     <div class="col-sm-5"><label>Correo de Salida:</label><?php echo form_input(array('name'=>'from1','id'=>'from1','class' =>'form-control'),''); ?></div>
     <div class="col-sm-5"><label>Nombre del Correo:</label><?php echo form_input(array('name'=>'fromName','id'=>'fromName','class' =>'form-control'),''); ?></div>
     <div class="col-sm-1"></div>
   </div> <div class="col-sm-12"><br></div>
   <div class="form-group">
     <div class="col-sm-1"></div>
     <div class="col-sm-5"><label>Correo de Respuesta:</label><?php echo form_input(array('name'=>'replyTo','id'=>'replyTo','class' =>'form-control'),''); ?></div>
     <div class="col-sm-5"><label>Nombre Correo Respuesta:</label><?php echo form_input(array('name'=>'replyToName','id'=>'replyToName','class' =>'form-control'),''); ?></div>
     <div class="col-sm-1"></div>
   </div> <div class="col-sm-12"><br></div>
   <div class="form-group">
     <div class="col-sm-6">
       <div class="col-sm-2"></div>
     <div class="col-sm-10"><label>Asunto:</label><?php echo form_input(array('name'=>'subject','id'=>'subject','class' =>'form-control'),''); ?></div>
     <div class="col-sm-12"><br></div>
     <div class="col-sm-2"></div>
     <div class="col-sm-4"><label>Puerto:</label><?php echo form_input(array('name'=>'puerto','id'=>'puerto','class' =>'form-control'),''); ?></div>
     <div class="col-sm-6"><label>SMTPSecure:</label><?php echo form_input(array('name'=>'SMTPSecure','id'=>'SMTPSecure','class' =>'form-control'),''); ?></div>
     </div>
     <div class="col-sm-5"><label>CC:</label><?php echo form_textarea(array('name'=>'cc','id'=>'cc','rows'=>'3','class' =>'form-control','rows'=>'4'),''); ?></div>
     <div class="col-sm-12"><br></div>
     <div class="col-sm-1"></div>
     <div class="col-sm-10"><label>Cuerpo:</label><?php echo form_textarea(array('name'=>'body','id'=>'body','rows'=>'3','class' =>'form-control','rows'=>'4'),''); ?></div>
   </div> <div class="col-sm-12"><br></div>
 </div></div>
  </div>
  <div class="modal-footer">
  <div class= "pull-right">
                  <a href="#" class="btn btn-success" onclick="guardarCorreo()">Guardar</a>
                  <a href="#" class="btn btn-danger" data-toggle="modal" data-dismiss="modal" data-target="#listaClientes">Cancelar</a>
               </form>
                </div>
              </div></div> </div></div>
