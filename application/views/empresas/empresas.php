<?php
if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
  $this->load->view('empresas/configuracion');
 $atributos = array('class' => 'form-control');
 $atributos2 = array('class' =>'form-control', 'rows'=>'4', 'style'=>'');
 echo validation_errors();
 echo form_open($accion);

?>
<div class="container">
  <h3>Datos Generales</h3>
  <br>
  <br>
  <div class="row">
  <div class="form-group" >
    <?php echo form_input(array('name'=>'idEmpresa','id'=>'idEmpresa','type'=>"hidden"),set_value('idEmpresa',isset($datos[0]['idEmpresa']) ? $datos[0]['idEmpresa'] : '0'),$atributos); ?>
    <label class="control-label col-sm-3" for="nombre">Nombre:</label>
    <div class="col-sm-7"><?php echo form_input(array('name'=>'nombre','id'=>'nombre'),set_value('nombre',isset($datos[0]['razon']) ? $datos[0]['razon'] : ''),$atributos); ?><br>
    </div>
    <div class="col-sm-2">
      <a class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modalEditUsuarios">Ver Usuarios</a>
    </div>
  </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="rfc">R.F.C.:*</label>
      <div class="col-sm-7"><?php
       $atributos1= array('class'=>'form-control', 'onblur'=>'ValidaRFC(\'rfc\')','size'=>'15');
       echo form_input(array('name'=>'rfc','id'=>'rfc'),set_value('rfc',isset($datos[0]['rfcEmpresa']) ? $datos[0]['rfcEmpresa'] : ''),$atributos1); ?><br>
     </div><div class="col-sm-2"></div>
      <label class="control-label col-sm-3" for="curp">C.U.R.P.:*</label>
      <div class="col-sm-7"><?php
       $atributos1= array('class'=>'form-control','size'=>'20');
       echo form_input(array('name'=>'curp','id'=>'curp'),set_value('curp',isset($datos[0]['curp']) ? $datos[0]['curp'] : ''),$atributos1); ?><br>
      </div>
      <label class="control-label col-sm-3" for="telefono">Teléfono:</label>
      <div class="col-sm-7"><?php echo form_input(array('name'=>'telefono','id'=>'telefono'),set_value('telefono',isset($datos[0]['tel']) ? $datos[0]['tel'] : ''),$atributos); ?><br>
      </div><div class="col-sm-2"></div>
      <label class="control-label col-sm-3" for="admin">Administrador:<a class="glyphicon glyphicon-search" data-toggle="modal" data-target="#listaUsuarios"></a></label>
      <div class="col-sm-7">
       <input class="form-control"  id="idU" name ="idU" value="<?php echo isset($datos[0]['idAdmin']) ? $datos[0]['idAdmin']: set_value('idU') ?>" type="hidden">
       <input class="form-control"  id="pass" name ="pass" value="0" type="hidden">
       <?php echo form_input(array('name'=>'admin','id'=>'admin','class' => 'form-control'),set_value('admin',isset($datos[0]['correoAdmin']) ? $datos[0]['correoAdmin'] : ''),'readOnly'); ?><br>
      </div>

      <div class="col-sm-7">
       
     </div><div class="col-sm-12"><br>
    
     <div class="col-sm-2">
            <label class="control-label" for="controlInventario"></label>
            <div class="checkbox" ><?php echo form_checkbox('autorizacion', '1',  $datos[0]['autorizacion'] != 0 ? TRUE:  FALSE); ?>Autorizacion</div>
          </div>
               <div class="col-sm-2">
            <label class="control-label" for="controlInventario"></label>
            <div class="checkbox" ><?php echo form_checkbox('referenciamarca', '1',  $datos[0]['referenciamarca'] != 0 ? TRUE:  FALSE); ?>Referencia</div>
          </div>

    </div>
     

    </div><div class="col-sm-12"><br></div>
  </div>
    <!-- <div class="panel-group" id="accordion">
      <div class="panel panel-default">
      <a data-toggle="collapse" data-parent="#accordion" href="#domicilio"><div class="panel-heading"><label for="serie">Domicilio</label></div></a>
      <div id="domicilio" class="panel-collapse collapse">
      <div class="panel-body">
         <div class="row">
               &nbsp; &nbsp;  Los datos con * en esta sección con <b>requeridos</b> al momento de realizar una factura con <b>Complemento de Comercio Exterior</b><div class="col-sm-12"><br></div>
                <div class="col-sm-4"><label class="control-label" for="paisCE">País:*</label><select name = "pais" class="form-control " id="pais" ></option>
               <?php foreach ($paises as $rowp1){if($rowp1['c_Pais'] == 'MEX'){echo"<option value='"; echo $rowp1['c_Pais']; echo "'";
                 echo "selected>"; echo $rowp1['c_Pais']." - ".$rowp1['Descripcion']; echo "</option>"; } }?>
               </select></div>
               <div class="col-sm-4"><label class="control-label" for="estadoCE">Estado:*</label><select name  = "estado" class="form-control" id="estado"  onchange="LlenarCiudad('estado','ciudad','localidad')"><option value=0></option>
                 <?php foreach ($resest as $rowe1) {echo "<option value='"; echo $rowe1['c_Estado']; echo "'";
                   if(isset($datos)){if($rowe1['c_Estado']==$row['estado']){echo " selected";}}echo ">"; echo $rowe1['c_Estado']." - ".$rowe1['nombreEstado']; echo "</option>";  }?>
               </select></div>
              <div class="col-sm-4"><label class="control-label" for="ciudadCE">Municipio:</label><select name = "ciudad" class="form-control" id="ciudad"  onchange="LlenarCP('estado','ciudad','cp')"><option value=""></option>
              </select></div>
             <div class="col-sm-12"></div>
              <div class="col-sm-4"><label class="control-label" for="localidadCE">Localidad:</label><select name = "localidad" class="form-control" id="localidad"><option value=""></option>
              </select></div>
              <div class="col-sm-4"><label class="control-label" for="codigoPostalCE">Código Postal:*</label><select name = "cp" class="form-control" id="cp" onchange="LlenarColonias('cp','colonia')"><option value=""></option>
              </select></div>
              <div class="col-sm-4"><label class="control-label" for="coloniaCE">Colonia:</label><select name="colonia"  class="form-control" id="colonia"><option value="-"></option></select></div>
              <div class="col-sm-12"></div>
              <div class="col-sm-4"><label for="nombreC">Calle:*</label><?php echo form_input(array('name'=>'calle','id'=>'calle'),set_value('calle',isset($datos[0]['calle']) ? $datos[0]['calle'] : ''),$atributos); ?></div>
              <div class="col-sm-2"><label for="nombreC">Num Ext:*</label><?php echo form_input(array('name'=>'noExt','id'=>'noExt'),set_value('noExt',isset($datos[0]['no_ext']) ? $datos[0]['no_ext'] : ''),$atributos); ?></div>
              <div class="col-sm-2"><label for="nombreC">Num Ext:*</label><?php echo form_input(array('name'=>'noInt','id'=>'noInt'),set_value('noInt',isset($datos[0]['no_int']) ? $datos[0]['no_int'] : ''),$atributos); ?></div>
              <div class="col-sm-12"><label class="control-label" for="referenciaCE">Referencia:</label><?php echo form_textarea(array('name'=>'referencia','id'=>'referencia','rows'=>'2'),set_value('referencia',isset($datos[0]['referencia']) ? $datos[0]['referencia'] : ''),$atributos); ?></div>
       </div></div></div></div> -->
      <div class="panel panel-default">
      <a data-toggle="collapse" data-parent="#accordion" href="#configCorreo"><div class="panel-heading"><label for="serie">Base de Datos</label></div></a>
      <div id="configCorreo" class="panel-collapse collapse">
      <div class="panel-body">
         <div class="row">
            <div class="form-group">
              <div class="col-sm-3"><label>Base de Datos:</label><?php echo form_input(array('name'=>'basedeDatos','id'=>'basedeDatos'),set_value('basedeDatos',isset($datos[0]['basedeDatos']) ? $datos[0]['basedeDatos'] : ''),$atributos); ?></div>
              <div class="col-sm-3"><label>Usuario:</label><?php echo form_input(array('name'=>'usuario','id'=>'usuario'),set_value('usuario',isset($datos[0]['usuario']) ? $datos[0]['usuario'] : ''),$atributos); ?></div>
              <div class="col-sm-3"><label>Contraseña:</label><?php echo form_input(array('name'=>'contrasena','id'=>'contrasena'),set_value('contrasena',isset($datos[0]['contrasena']) ? $datos[0]['contrasena'] : ''),$atributos); ?></div>
              <div class="col-sm-3"><label>Host:</label><?php echo form_input(array('name'=>'host','id'=>'host'),set_value('host',isset($datos[0]['host']) ? $datos[0]['host'] : ''),$atributos); ?></div>
            </div>  <div class="col-sm-12"><br></div>
          </div></div></div></div></div>
        </div>

       <center>
       <button type="submit"  class="btn btn-success btn-lg"><span class="fa fa-floppy-o"></span> Guardar</button>
       <a href="<?php echo base_url().'empresas/index'?>" class="btn btn-danger btn-lg" role="button"><span class="fa fa-times"></span> Cancelar</a>
       </center>
     </div>
    </div>
  <script>
         $(document).ready(function(){ $('.combobox').combobox(); });
         $(document).ready(function(){
           var pais=x("pais").value;
           if(pais=="MEX")
           {
             $("#estadoE").append('<div id="estadoC"><select name="estado" class="form-control" id="estado" onchange="LlenarCiudad(\'estado\',\'ciudad\',\'localidad\')"><option value="-"></option></select></div>');
             $("#ciudadE").append('<div id="ciudadC"><select name="ciudad" class="form-control" id="ciudad" onchange="LlenarCP(\'estado\',\'ciudad\',\'cp\')"><option value="-"></option></select></div>');
             $("#localidadE").append('<div id="localidadC"><select name="localidad"  class="form-control" id="localidad"><option value="-"></option></select></div>');
             $("#cpE").append('<div id="cpC"><select name="cp"  class="form-control" id="cp" onchange="LlenarColonias(\'cp\',\'colonia\')"<option value="-"></option>></select></div>');
             $("#colE").append('<div id="colC"><select name="colonia"  class="form-control" id="colonia"><option value="-"></option></select></div>');
             LlenarEstado('pais','estado');
             Selec();
           }});

         function Selec()
         {
           x("estado").value="<?php echo $datos[0]['estado']?>";
           if(x("estado").value!="-")
           {
             LlenarCiudad('estado','ciudad','localidad');
             x("ciudad").value="<?php echo $datos[0]['municipio']?>";
             x("localidad").value="<?php echo $datos[0]['localidad']?>";
             if(x("ciudad").value!="-")
             {
               LlenarCP('estado','ciudad','cp');
               x("cp").value="<?php echo $datos[0]['codigoPostal']?>";
               if(x("cp").value!="-")
               {
                 LlenarColonias('cp','colonia')
                 x("colonia").value="<?php echo $datos[0]['colonia']?>";
               }
             }
           }
         }
    </script>
    <?php
    function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++)
        {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
    $contraseña=randomPassword();
     ?>
    <div class="modal fade" id="listaUsuarios" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-blue" style="background-color:#222222; color:white;">
              <button type="button" class="close" onClick="ClearData()" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Listado Usuarios</h4>
            </div>
            <div class="modal-body">
      	      <form class="form-horizontal">
      	      	<!-- parametros ocultos -->
      			<div class="box-body">
              <div class="col-md-12">
                <table id="users1" class="table table-strippered responsive nowrap"  cellspacing="0" width="100%">
                  <thead style="background-color:#222222; color:white;"><th>Id</th><th>Nombre</th><th>Correo</th> </thead>
                </table>
              </div>
      			</div>
      		  </form>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn btn-success" data-toggle="modal" data-dismiss="modal" data-target="#agregarUsuario" onClick="randomPassword()">Agregar Usuario</a>
              <button type="button" class="btn btn-info" id="mbtnCerrarModal" onClick="returnIdUsuario()" data-dismiss="modal">Seleccionar</button>
            </div>
          </div>
        </div>
      </div>

    <div class="modal fade" id="agregarUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-blue" style="background-color:#222222; color:white;">
              <button type="button" class="close" onClick="ClearData()" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Nuevo Usuarios</h4>
            </div>

            <div class="modal-body">
              <form class="form" id="formaUsuariosE" name="formaUsuariosE">
              <div class="col-sm-12">
                Los campos marcados con * son obligatorios.<br><br>
                <div class="row">
                  <div class="col-sm-12">
                  <div class="form-group">
                    <input class="form-control"  id="id" name ="id" value="<?php echo isset($datos[0]['id']) ? $datos[0]['id']: set_value('id') ?>" type="hidden">
                    <label class="control-label col-sm-4" for="nombreU">Nombre Usuario:*</label>
                    <div class="col-sm-8"> <?php echo form_input('nombre','Administrador',$atributos); ?></div>
                  </div><div class="col-sm-12"><br></div>
                  <div class="form-group" >
                      <label class="control-label col-sm-4"type="email" for="usuario">Usuario:*<span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Debe ser un correo electrónico válido"></span></label>
                    <div class="col-sm-8"> <?php  echo form_input('correo',set_value('correo',isset($datos[0]['email']) ? $datos[0]['email'] : ''),$atributos); ?></div><div class="col-sm-12"><br></div></div>
                    <div class="form-group" >
                      <label class="control-label col-sm-4" for="password">Contraseña:*</label>
                      <div class="col-sm-8"><input class="form-control" value="<?php echo $contraseña; ?>" id="contrasena" name="contrasena" >
                      </div></div><div class="col-sm-12"><br></div>
                        <div class="form-group"><label  class="control-label col-sm-4"  for="tUsuario">Tipo Usuario:</label>
                            <div class="col-sm-8">
                              <select class="form-control " id="tUsuario" name="tUsuario" >
                                <option value="admin" <?php if($tUsuario='admin') echo 'selected' ?>>Administrativo</option>
                              </select><br>
                            </div>
                        </div>
                  </div>
                  </div>
            </div>
            <div class="col-sm-4"></div>
            <div class="modal-footer">
              <div class= "pull-right">
                <a href="#" class="btn btn-success" onclick="agregarUsuarioE()">Guardar</a>
                <a href="#" class="btn btn-danger" data-toggle="modal" data-dismiss="modal" data-target="#listaClientes">Cancelar</a>
             </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--MODAL PARA MOSTRAR LOS USUARIOS QUE PERTENECEN AL GRUPO Y PODER AGREGAR O ELIMINARLOS-->
    <div class="modal fade" id="modalEditUsuarios" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-blue" style="background-color:#222222; color:white;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Usuarios</h4>
          </div>
          <div class="modal-body">
    	      <form class="form-horizontal">
    	      	<!-- parametros ocultos -->
            <div class="col-sm-5">
            <div class="form-group" ><br>
              <label class="control-label col-sm-12" type="email" for="usuario">Todos los Usuarios:</label>
              <div class="col-sm-12">
              <select class="form-control" height= "140px" name="todosUs" id="todosUs" size="7">
           <?php
                foreach ($usuariosT as $row)
                { echo '<option value="'.$row['id'].'">'.$row['name']."</option>"; }
               ?>
              </select>
              </div></div><div class="col-sm-12"><br></div>
            </div>
            <div class="col-sm-2"><br>
              <div class="col-sm-12"><br><br><br></div>
              <div class="col-sm-12">
              <a href="#" class="btn btn-info btn-sm" role="button" onclick="AgregarAEmpresa()">Agregar>></i> </a></div>
              <div class="col-sm-12"><br></div>
              <div class="col-sm-12">
              <a href="#" class="btn btn-info btn-sm" role="button" onClick="RemoverDeEmpresa()"><< Quitar&nbsp;&nbsp;&nbsp;  </a></div>
            </div>
            <div class="col-sm-5"><br>
            <div class="form-group" >
              <label class="control-label col-sm-12"type="email" for="usuario">Usuarios en la Empresa:</label>
              <div class="col-sm-12">
              <select class="form-control" height= "140px" name="perteneceU" id="perteneceU" size="7">
                <?php
                     foreach ($pertenece as $row1)
                     { echo '<option value="'.$row1['id'].'">'.$row1['name']."</option>"; }
                    ?>
              </select>
              </div></div><div class="col-sm-12"><br></div>
            </div>
    		  </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" id="mbtnCerrarModal" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>

    <script>
    function AgregarAEmpresa()
    {
     var idE = $('#idEmpresa').val();
     var idU = $('#todosUs').val();
     $.post(baseurl+"empresas/AgregarUsuario",
     { idEmpresa:idE, idUsuario:idU },
     function(data)
     {
       var leftlist = document.getElementById("todosUs");
       var selItem = leftlist.selectedIndex;

       if (selItem == -1)
       { swal("Selecciona el usuario que deseas agregar"); }
       else
       {
           var rightlist = document.getElementById("perteneceU");
           var newOption = leftlist[selItem].cloneNode(true);

           leftlist.removeChild(leftlist[selItem]);
           rightlist.appendChild(newOption);
       }
     });
    };

    function RemoverDeEmpresa()
    {
      var idE = $('#idEmpresa').val();
      var idU = $('#perteneceU').val();
      $.post(baseurl+"empresas/RemoverUsuario",
      { idEmpresa:idE, idUsuario:idU },
     function(data)
     {
       var leftlist = document.getElementById("perteneceU");
       var selItem = leftlist.selectedIndex;

       if (selItem == -1)
       { swal("Selecciona el usuario que deseas remover."); }
       else
       {
           var rightlist = document.getElementById("todosUs");
           var newOption = leftlist[selItem].cloneNode(true);
           leftlist.removeChild(leftlist[selItem]);
           rightlist.appendChild(newOption);
       }
     });
    };
    </script>
