<?php
if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
if(isset($_SESSION['img']) && $_SESSION['img']!=""){ $foto=$_SESSION['img'];} else{$foto=0;}
?>
<nav class="navbar navbar-inverse navbar-static-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span><span class="icon-ls"></span><span class="icon-bar"></span><span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo base_url();?>Welcome"><span class=""></span> &nbsp;&nbsp; Avanza C</a>
      <?php
        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] != "usuario")
        {
          echo '<a class="navbar-brand" data-toggle="tooltip" title="Configuración" href="'.base_url().'configuracion"><span class="fa fa-cog"></span></a>';


       }
       if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'SU')
       {
         echo '<a class="navbar-brand" data-toggle="tooltip" title="Configuración general" href="'.base_url().'configuraciones"><span class="fa fa-cogs"></span></a>';
       }
       if(isset($_SESSION['tipo']) && $_SESSION['tipo'] != "usuario")
       {
        echo '<label class="navbar-brand" style="color:white">'.$_SESSION['mesletra'].' - '.$_SESSION['ano'].'</label>';
        echo '<label class="navbar-brand" onclick="abrirejercicio()">Cambiar ejercicio de trabajo</label>';
        // echo '<a class="navbar-brand" data-toggle="tooltip" title="Subir Logo y Certificados" href="'.base_url().'configuracion/certificados"><span class="glyphicon glyphicon-open-file"></span></a>';
        if($_SESSION['tipo']=="admin") {echo '<a class="navbar-brand" data-toggle="tooltip" title="Usuarios" href="'.base_url().'index.php/usuarios/index"><span class="glyphicon glyphicon-user"></span></a>';}
        echo '<div style="display:inline" id="notificacion"></div>';
       }
        else {echo '';}

      ?>
    </div>

    <div id="navbar" class="navbar-collapse collapse" data-hover="dropdown" data-animations="fadeInDown fadeInRight fadeInUp fadeInLeft">
       <ul class="nav navbar-nav navbar-right" >
          <?php
          if( isset($foto) && $foto!="0") { $src="data:image/jpeg;base64,$foto";} else {$src=base_url('public/img').'/bg.jpg';}
          $attributes = array('class' => 'navbar-form navbar-right');
          $additional_item1 = form_open('inicio/logout', $attributes).'<li class="dropdown"><img src="'.$src.'"class="img-circle" alt="Cinque Terre" width="35" height="35">
                            <font color = "white">Bienvenido, <b>'.$_SESSION['nombreU'].'</b></font><a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" href="#">
                            <span class="caret"></span></a><ul class="dropdown-menu"><li><a href="'.base_url().'usuarios/editarPerfil/'.$_SESSION['id'].'"><i class="fa fa-pencil-square-o" aria-hidden="true">
                            </i>Editar Perfil</a></li><li><a href="'.base_url().'inicio/logout"><i class="fa fa-sign-out" aria-hidden="true"></i>Cerrar Sesión</a></li> </ul></li></form>';
              // call inject_item() method before render() method called
              echo $this->multi_menu->inject_item($additional_item1)->render(array(
              'nav_tag_open'        => '',
              'parentl1_tag_open'   => '<li class="dropdown">',
              'parentl1_anchor'     => '<a href="%s">%s<span class="caret"></span></a>',
              'children_tag_open'   => '<ul class="dropdown-menu">',
              'children_anchor'     => '<a href="%s" data-toggle="dropdown">%s</a>'
          )); ?>
        </ul>
  </div></div>
</nav>

<script>
function abrirejercicio()
{
   $('#myModalCambioejerciciotrabajo').modal('show');
}
</script>
<script type="text/javascript"> var baseurl = "<?php echo base_url(); ?>";</script>
<script src="<?php echo base_url();?>public/js/jQuery.dtplugin.js"></script>
<script src="<?php echo base_url();?>public/js/tablas.js"></script>
<script type="text/javascript">
var edit = "<?php echo isset($permisosGrupo['edit'])?$permisosGrupo['edit']:''; ?>";
var del ="<?php echo isset($permisosGrupo['del'])?$permisosGrupo['del']:''; ?>";
if(edit=="0"){edit='class="disabled"';} else {edit="";}
if(del=="0"){del='class="disabled"';} else {del="";}
var idUsuarioActivo = "<?php echo isset($_SESSION['id'])?$_SESSION['id']:''; ?>";
var tipoUsuarioActivo="<?php echo isset($_SESSION['tipo'])?$_SESSION['tipo']:''; ?>";


</script>
<div id="main" class="container-fluid">
  <?php
  if(!isset($_SESSION['unica']) || $_SESSION['unica']==0 || $_SESSION['tipo']=="SU")
  {
    echo '<font size="3"><b>Trabajando como : </b>'.$_SESSION['razon'].'</font>&nbsp&nbsp&nbsp<a href="'.base_url().'index.php/inicio/VerSelecEmpresa" class="btn btn-danger btn-sm" role="button">Cambiar de empresa </a>';
  }
  else{ echo "";}
  ?>
  <b><font size= "7"> <p align="center"><?php echo isset($titulo) ? $titulo : ''; ?></p></font></b>
