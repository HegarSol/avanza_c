<?php
if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
$this->load->view('modalCorreo');

 $atributos = array('class' => 'form-control');
 $atributos2 = array('class' =>'form-control', 'rows'=>'4', 'style'=>'');
 echo validation_errors();
 echo form_open_multipart($accion);
 if(isset($datos[0]['img'])){$img= $datos[0]['img'];}
?>
<div class="container">
  <h3>Logo</h3>
  <div class="form-group">
    <textarea id="imgBase64" name="imgBase64" cols="50" rows="15" hidden><?php echo $img; ?></textarea>
    <label class="control-label col-sm-3" for="updates">Logo de la Empresa: </label>
    <img id="blah" src="<?php echo isset($img) && $img!="0" ? "data:image/jpeg;base64,$img": base_url().'public/img/logo.png'?>" alt="your image" width="250px" height="110px" /><div class="col-sm-12"><br></div>
    <div class="col-sm-3"></div><div class="col-sm-4"><input type="file"  id="imgInp" name="imgInp" ></div>
  </div>
  <div class="col-sm-12"></br></div>
  <div class="row">
    <h3>Datos Generales</h3>
  <div class="form-group" >
    <?php echo form_input(array('name'=>'idEmpresa','id'=>'idEmpresa','type'=>"hidden"),set_value('idEmpresa',isset($datos[0]['id_empresa']) ? $datos[0]['id_empresa'] : '0'),$atributos); ?>
    <?php echo form_input(array('name'=>'imgName','id'=>'imgName','type'=>"hidden"),set_value('idEmpresa',isset($datos[0]['imgName']) ? $datos[0]['imgName'] : '')); ?>
    <label class="control-label col-sm-2" for="nombreEmpresa">Nombre:</label>
    <div class="col-sm-9"><?php echo form_input(array('name'=>'nombre','id'=>'nombre'),set_value('nombre',isset($datos[0]['nombreEmpresa']) ? $datos[0]['nombreEmpresa'] : $esNueva[0]['razon']),$atributos); ?><br>
    </div></div>
    <div class="form-group">
      <div class="col-sm-4">
        <label class="control-label" for="rfc">R.F.C.:*</label>
        <?php
       $atributos1= array('class'=>'form-control', 'onblur'=>'ValidaRFC(\'rfc\')','size'=>'15');
       echo form_input(array('name'=>'rfc','id'=>'rfc'),set_value('rfc',isset($datos[0]['rfc']) ? $datos[0]['rfc'] : $esNueva[0]['rfcEmpresa']),$atributos1); ?><br>
     </div>
      
    </div><div class="col-sm-12"><br></div>
  </div>

  <div class="panel-group" id="accordion">
      <div class="panel panel-default">
      <a data-toggle="collapse" data-parent="#accordion" href="#domicilio"><div class="panel-heading"><label for="serie">Domicilio</label></div></a>
      <div id="domicilio" class="panel-collapse collapse">
      <div class="panel-body">
         <div class="row">
                <div class="col-sm-4">
                   <label class="control-label" for="paisCE">País:</label>
                   <Input type="text" name="pais" class="form-control" value="<?php echo isset($datos[0]['pais']) ? $datos[0]['pais'] : '' ?>" id="pais" >
              </div>
               <div class="col-sm-4">
                <label class="control-label" for="estadoCE">Estado:</label>
                <Input type="text" name="estado" class="form-control" value="<?php echo isset($datos[0]['estado']) ? $datos[0]['estado'] : '' ?>" id="estado">
               </div>
              <div class="col-sm-4">
                 <label class="control-label" for="ciudadCE">Municipio:</label>
                  <Input type="text" name="ciudad" class="form-control" value="<?php echo isset($datos[0]['ciudad']) ? $datos[0]['ciudad'] : '' ?>" id="ciudad">
             </div>
             <div class="col-sm-12">
             </div>
              <div class="col-sm-4">
                 <label class="control-label" for="localidadCE">Localidad:</label>
                 <Input type="text" name="localidad" class="form-control" value="<?php echo isset($datos[0]['localidad']) ? $datos[0]['localidad'] : '' ?>" id="localidad">
              </div>
              <div class="col-sm-4">
                <label class="control-label" for="codigoPostalCE">Código Postal:</label>
                 <Input type="text" name="cp" class="form-control" value="<?php echo isset($datos[0]['cp']) ? $datos[0]['cp'] : '' ?>" id="cp">
              </div>
              <div class="col-sm-4">
                <label class="control-label" for="coloniaCE">Colonia:</label>
                <Input type="text" name="colonia"  class="form-control" value="<?php echo isset($datos[0]['colonia']) ? $datos[0]['colonia'] : '' ?>" id="colonia">
              </div>
              <div class="col-sm-12"></div>
              <div class="col-sm-4">
                <label for="nombreC">Calle:</label>
                <Input type="text" name="calle"  class="form-control" value="<?php echo isset($datos[0]['calle']) ? $datos[0]['calle'] : '' ?>" id="calle">
              </div>
              <div class="col-sm-2">
                <label for="nombreC">Num Ext:</label>
                <Input type="text" name="noExt"  class="form-control" value="<?php echo isset($datos[0]['noExt']) ? $datos[0]['noExt'] : '' ?>" id="noExt">
              </div>
              <div class="col-sm-2">
                <label for="nombreC">Num Ext:</label>
                <Input type="text" name="noInt"  class="form-control" value="<?php echo isset($datos[0]['noInt']) ? $datos[0]['noInt'] : '' ?>" id="noInt">
              </div>
              <div class="col-sm-4">
                <label for="nombreC">Telefono y Fax:</label>
                <Input type="text" name="telefono"  class="form-control" value="<?php echo isset($datos[0]['telefono']) ? $datos[0]['telefono'] : '' ?>" id="telefono">
              </div>
              <div class="col-sm-12">
                <label class="control-label" for="referenciaCE">Referencia:</label>
                <Input type="textarea" name="referencia"  class="form-control" value="<?php echo isset($datos[0]['referencia']) ? $datos[0]['referencia'] : '' ?>" id="referencia">
              </div>
       </div>
      </div>
    </div>
  </div>

      <div class="panel panel-default">
      <a data-toggle="collapse" data-parent="#accordion" href="#configCorreo"><div class="panel-heading"><label for="serie">Configuración de Correo</label></div></a>
      <div id="configCorreo" class="panel-collapse collapse">
      <div class="panel-body">
        <div class="pull-right">
        <div class="col-sm-2">
          <button type="button" class="btn btn-success btn-sm" onclick="AddCorreo()" ><span class="glyphicon glyphicon-plus"></span>Agregar Correo</button>
        </div>
      </div>
      <div class="col-sm-12">
      <br>
      </div>
        <table id="tblCorreos" class="table table-stripped table-bordered" cellspacing="0" width="100%">
            <thead>
              <th>Id</th>
              <th>Nombre Correo</th>
              <th>Correo</th>
              <th>Host</th>
              <th>Puerto</th>
              <th>Default</th>
              <th alignt="center">Acciones</th>
            </thead>
        <?php
            if (isset($correos) && count($correos)> 0)
            {
              $count=1;
              foreach ($correos as $rowC)
              {
                echo ("<tr><td >".$rowC['idCorreo']."</td>");
                echo ("<td >".$rowC['fromName']."</td>");
                echo ("<td>".$rowC['from1']."</td>");
                echo ("<td>".$rowC['host']."</td>");
                echo ("<td>".$rowC['puerto']."</td>");
                echo ("<td>".$rowC['default']."</td>");
                echo '<td><button type="button"  class="btn btn-danger btn-sm" onclick="deleteCorreo(\'tblCorreos\','.$count.');"><span class="glyphicon glyphicon-erase"></span></button>
                <button type="button" class="btn btn-success btn-sm" onclick="editCorreos(\'tblCorreos\','.$count.');" ><span class="glyphicon glyphicon-edit"></span></button></td></tr>';
                $count++;
              }
            }
        ?>
  </table>
      </div></div></div>
     
      <br>

     <center>
       <button type="submit"  class="btn btn-success btn-lg">Guardar</button>
       <a href="<?php echo base_url().'Welcome'?>" class="btn btn-danger btn-lg" role="button">Cancelar</a>
       </center>
    
    </div>
  <script>
        

         function AddCorreo()
         {
           x("idCorreo").value=0;
           x("host").value='';
           x("SMTPSecure").value='';
           x("from1").value='';
           x("puerto").value='';
           x("userName").value='';
           x("fromName").value='';
           x("password").value='';
           x("replyTo").value='';
           x("replyToName").value='';
           x("subject").value='';
           x("body").value='';
           x("cc").value='';
           x("SMTPAuth").checked=false;
           x("default").checked=false;

           $('#modalCorreo').modal('show');
         }


         function editCorreos(tabla,id)
         {
           var table = x(tabla);
           var idC = table.rows[id].cells[0].innerHTML;
           $.ajax({
             type: "POST",
             url: baseurl+"index.php/configuracion/getDatosCorreo/"+idC,
             success: function(msg)
             {
               x("idCorreo").value=msg[0].idCorreo;
               x("host").value=msg[0].host;
               x("SMTPSecure").value=msg[0].SMTPSecure;
               x("from1").value=msg[0].from1;
               x("puerto").value=msg[0].puerto;
               x("userName").value=msg[0].userName;
               x("fromName").value=msg[0].fromName;
               x("password").value=msg[0].password;
               x("replyTo").value=msg[0].replyTo;
               x("replyToName").value=msg[0].replyToName;
               x("subject").value=msg[0].subject;
               x("body").value=msg[0].body;
               x("cc").value=msg[0].cc;
               if(msg[0].SMTPAuth==1){
                 x("SMTPAuth").checked=true;
               }
               else {
                 x("SMTPAuth").checked=false;
               }
               if(msg[0].default==1){
                 x("default").checked=true;
               }
               else {
                 x("default").checked=false;
               }
            }
           });
           $('#modalCorreo').modal('show');
         }

        

         function guardarCorreo()
         {
           try
            {
              var idCorreo = x("idCorreo").value;
              var host = x("host").value;
              var SMTPSecure = x("SMTPSecure").value;
              var from1 = x("from1").value;
              var puerto = x("puerto").value;
              var userName = x("userName").value;
              var fromName = x("fromName").value;
              var password = x("password").value;
              var replyTo =  x("replyTo").value;
              var replyToName = x("replyToName").value;
              var subject = x("subject").value;
              var body = x("body").value;
              var cc = x("cc").value;
              var SMTPAuth = x("SMTPAuth").value;
              var default1 = x("default").value;
             var url1= baseurl+"index.php/configuracion/guardarCorreo/"+idCorreo;
             $.ajax({
               type: "POST",
               url: url1,
               data: {host:host, SMTPSecure:SMTPSecure, from1:from1, puerto:puerto, userName:userName, fromName:fromName, password:password,
               replyTo:replyTo, replyToName:replyToName, subject:subject, body:body,SMTPAuth:SMTPAuth,default1:default1,cc:cc},
               success: function(msg)
               {
                 if (msg[0].mensaje== "Insertado Correctamente" || msg[0].mensaje== "Actualizado Correctamente")
                {
                  swal("Listo", msg[0].mensaje, "success");
                  var url1= baseurl+"configuracion/correos";
                  var table   = x("tblCorreos");
                  $.ajax({
                    type: "POST",
                    url: url1,
                    success: function(response)
                    {
                      while(table.rows.length > 1) { table.deleteRow(1);}
                      for(var i in response['correos'])
                      {
                        var rowCount = table.rows.length;
                        var row   = table.insertRow(rowCount);
                        var cell0 = row.insertCell(0);      cell0.innerHTML = response['correos'][i].idCorreo;
                        var cell1 = row.insertCell(1);      cell1.innerHTML = response['correos'][i].fromName;
                        var cell2 = row.insertCell(2);      cell2.innerHTML = response['correos'][i].from1;
                        var cell3 = row.insertCell(3);      cell3.innerHTML = response['correos'][i].host;
                        var cell4 = row.insertCell(4);      cell4.innerHTML = response['correos'][i].puerto;
                        var cell5 = row.insertCell(5);      cell5.innerHTML = response['correos'][i].default;
                        var cell6 = row.insertCell(6);      cell6.innerHTML = '<td><button type="button"  class="btn btn-danger btn-sm" onclick="deleteCorreo(\'tblCorreos\','+rowCount+');"><span class="glyphicon glyphicon-erase"></span></button>'+
                        '<button type="button" class="btn btn-success btn-sm" onclick="editCorreos(\'tblCorreos\','+rowCount+');" ><span class="glyphicon glyphicon-edit"></span></button></td></tr>';
                    }}});
                }
                 else
                 { swal("Error", msg[0].errores, "error"); }
              }
             });
          } catch(e) { alert(e); }
         }

         function readURL(input)
         {
             if (input.files && input.files[0])
             {
                 var reader = new FileReader();
                 reader.onload = function (e) { $('#blah').attr('src', e.target.result); }
                 reader.readAsDataURL(input.files[0]);
             }
         }

         function deleteCorreo(tableID,id)
         {
           var table = x(tableID);
           var idC = table.rows[id].cells[0].innerHTML;
           var default1=table.rows[id].cells[5].innerHTML;
           var url1= baseurl+"index.php/configuracion/borrarCorreo/"+idC;
            swal({
            title: "¿Desea eliminar el correo?",
            text: "No se podrá recuperar la infomación.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Borrar",
            cancelButtonText: "No, Cancelar",
            closeOnConfirm: true,
            closeOnCancel: false
            },
            function(isConfirm){
              if (isConfirm)
              {
                if(default1==0)
                {

                  $.ajax({
                    type: "POST",
                    url: url1,
                    success: function(msg)
                    { table.deleteRow(id);}
                  });
                }
                else
                { swal("Error", "No se puede eliminar el coreo por default", "error");}
              }
              else
              { swal("Cancelado", "No se eliminó el correo", "error"); }
            });
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
                     document.getElementById("imgBase64").value = btoa(binaryString);
                 };
                 reader.readAsBinaryString(file);
             }
         };
         if (window.File && window.FileReader && window.FileList && window.Blob) { document.getElementById('imgInp').addEventListener('change', handleFileSelect, false);}
    </script>
