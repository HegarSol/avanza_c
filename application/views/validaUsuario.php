<?php
if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Avanza C</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url('public/css');?>/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="<?php echo base_url('public/css');?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('public/css');?>/style.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <!-- Theme CSS -->
    <link href="<?php echo base_url('public/css');?>/grayscale.css" rel="stylesheet">
    <link href="<?php echo base_url('public/css');?>/dashboard.css" rel="stylesheet">
    <link href="<?php echo base_url('public/css');?>/index.css" rel="stylesheet">
</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="#" data-toggle="modal" data-target="#myModalLogin">
                    <i class="glyphicon glyphicon-user"></i> <span class="light"><label style= "font-family:Calibri,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:20">Iniciar sesión </label></span>
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li >
                        <a class="page-scroll" href="#page-top"><label style= "font-family:Calibri,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:20">Inicio</label></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#about"><label style= "font-family:Calibri,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:20">Características</label></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact"><label style= "font-family:Calibri,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:20">Contáctanos</label></a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <!-- Intro Header -->
    <header class="intro">     <!--  <div id="particles-js"><canvas></canvas></div> -->
        <div class="intro-body">
          <?php
            if(isset($errores))
            {
              for($i= 0; $i<count($errores); $i++)
              { echo "<div class='alert alert-danger' role='alert'>".$errores[$i]."</div>"; }
            }
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                    <!-- <center><label style= "font-family:Calibri,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:100">AVANZA C</label></center><br><br> -->
                        <center><img src="<?php echo base_url('public/img');?>/AVANZAC.png" class="img-responsive" alt="Responsive image"></center><br><br>                        
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid">
    <!-- About Section -->
    <section id="about" class="container content-section text-center">
        <div class="row">
                <h2>Características de Avanza C</h2>
                <div class="row">
            <div class="col-md-4 ">
                <h4>Arrendamiento</h4>
                <p class="indexa">Puedes realizar facturas de arrendamiento con todos los requerimientos del SAT.</p>
            </div>

            <div class="col-md-4" style="border-left: thick solid #000; border-right: thick solid #000;">
                <h4>Carta Porte</h4>
                <p>Si el giro de tu negocio son los transportes, contamos con el formato de Carta Porte, donde podr&aacute;s especificar los valores de la mercanc&iacute;a transportada.
                Llevar el control de tus choferes, camiones y destinos.</p>
            </div>

            <div class="col-md-4 ">
                <h4>Facturaci&oacute;n en General</h4>
                <p>Tambi&eacute;n contamos con otros m&oacute;dulos que se pueden adaptar a tus necesidades como lo es la facturaci&oacute;n detallista y de honorarios.</p>
              </div></div>
          </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="container content-section text-center">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>Ponte en contacto</h2>
                <p>Para m&aacute;s informaci&oacute;n acerca de nuestro sistema de contabilidad puedes comunicarte al tel&eacute;fono: (867) 712-36-16 o escribirnos a:</p>
                <p> <a href="mailto:pagos@hegarss.com">pagos@hegarss.com</a>
                </p>
                <ul class="list-inline banner-social-buttons">
                    <li> <a href="https://hegarss.com" target="_blank" class="btn btn-default btn-lg"><i class="fa fa-globe fa-fw"></i> <span class="network-name">Página Web</span></a> </li>
                    <li> <a href="https://facebook.com" target="_blank" class="btn btn-default btn-lg"><i class="fa fa-facebook fa-fw"></i> <span class="network-name">Facebook</span></a> </li>
                </ul>
            </div>
        </div>
    </section>
</div>

    <!-- Map Section -->
    <div id="map" class="container content-section text-center">
    </div>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
        <label style= "font-family:Calibri,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:20">&copy; HEGAR Soluciones en Sistemas S. de R.L. 2021-<?php echo date('Y')?></label>
        </div>
    </footer>

<!-- The Modal -->
<div class="modal fade" id="myModalLogin" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
  <!-- Modal Content -->
<?php
$attributes = array('class' => 'modala-content animate', 'style' => "font-family:Montserrat,'Helvetica Neue',Helvetica,Arial,sans-serif;");
echo form_open('inicio/iniciarSesion', $attributes);
?>
    <!-- <div class="hidden-lg"><div class="imgcontainer"><img src="<?php echo base_url('public/img');?>/usuario-logo.png" class="avatar" alt="Responsive image"></div></div> -->
    <!-- <div class="hidden-md hidden-xs hidden-sm"><div class="imgcontainer"><img src="<?php echo base_url('public/img');?>/user.jpg" style="width:200px; height:200px;"class="avatar" alt="Responsive image"></div></div> -->
<br>
<div class="row">
     <div class="col-md-2">
     </div>
     <div class="col-md-8">
           <center><label ><b>Usuario</b></label></center>
           <input class="form-control" type="text" placeholder="correo electronico" name="correo" id="correo" required>
     </div>
</div>
<br>
<div class="row">
      <div class="col-md-2">
      </div>
      <div class="col-md-8">
           <center><label ><b>Contraseña</b></label></center>
           <input class="form-control" type="password" placeholder="**********" name="contrasena" id="contrasena" required>
      </div>
</div>
<br>
<div class="row">
      <div class="col-md-2">
      </div>
      <div class="col-md-8">
        <input type="checkbox" value="remember-me" name="remember" text="" align="right" >  Recordar mi correo
      </div>
</div>
<br>
<div class="row">
     <div class="col-md-2">
     </div>
      <div class="col-md-8">
          <button type="submit" class="btn btn-primary btn-lg btn-block">Ingresar</button>
      </div>
</div>
<br>
  </form>
    </div>
  </div>
</div>


 <div id="id02" class="modala">
   <form class="modala-content1 animate" >
   <h5>Error al conectar con la base de datos.</h5>
   No se pudo acceder correctamente a su base de datos. Favor de intentarlo nuevamente más tarde. Si el problema persiste ponerse en contacto con el equipo de soporte disponible en el teléfono: <a href="mailto:info@hegarss.com">(867) 712-3616</a>
 </div>
</form>

    <script src="<?php echo base_url('public/js');?>/jquery.js"></script>
    <script src="<?php echo base_url('public/js');?>/bootstrap.min.js"></script>
    <script>
      var modal = document.getElementById('id01');
      var modal1= document.getElementById('id02');
      window.onclick = function(event) { if (event.target == modal || event.target==modal1) { modal.style.display = "none"; modal1.style.display = "none"; }};

      function modalError()
      {document.getElementById('id02').style.display='block';}
    </script>
    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Theme JavaScript -->
    <script src="<?php echo base_url('public/js');?>/grayscale.min.js"></script>
</body>

</html>
