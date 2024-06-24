<?php
if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Pagina de presentacion e Inicio de Sesion de los usuarios">
  <link rel="shortcut icon" href="<?php echo base_url('public');?>/favicon.ico">
  <link href="<?php echo base_url('public/css');?>/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url('public/css');?>/dataTables.bootstrap.css" rel="stylesheet">
  <link href="<?php echo base_url('public/css');?>/dataTables.tableTools.css" rel="stylesheet">
  <link href="<?php echo base_url('public/css');?>/dashboard.css" rel="stylesheet">
  <link href="<?php echo base_url('public/css');?>/jquery.dataTables.min.css" rel="stylesheet">
  <link href="<?php echo base_url('public/css');?>/responsive.dataTables.min.css" rel="stylesheet">
  <link href="<?php echo base_url('public/css');?>/menuHover.css" rel="stylesheet">
  <link href="<?php echo base_url('public/css');?>/animate.css" rel="stylesheet">
  <link href="<?php echo base_url('public/css');?>/fullcalendar.css" rel="stylesheet">
  <link href="<?php echo base_url('public/css/font-awesome/css');?>/font-awesome.css" rel="stylesheet">
  <link href="<?php echo base_url('public/css/font-awesome/css');?>/font-awesome.min.css" rel="stylesheet">
  <!-- <script src="https://use.fontawesome.com/6da12c96db.js"></script> -->
  <!--<link href="<?php //echo base_url('piblic/css');?>/index.css" rel="stylesheet">-->
  <link href="<?php echo base_url('public/css');?>/jquery.datetimepicker.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url('public/css');?>/sweetalert.css">
  <link rel="stylesheet" href="<?php echo base_url('public/css');?>/jquery-ui.css">
  <script src="<?php echo base_url('public/js');?>/jquery-1.12.3.js"></script>
  <script src="<?php echo base_url('public/js');?>/bootstrap.min.js"></script>
  <script src="<?php echo base_url('public/js');?>/ventanaModal.js"></script>
  <script src="<?php echo base_url('public/js');?>/jquery-ui.js"></script>
  <script src="<?php echo base_url('public/js');?>/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url('public/js');?>/sweetalert.min.js"></script>
  <script src="<?php echo base_url('public/js');?>/dataTables.responsive.min.js"></script>
  <script src="<?php echo base_url('public/js');?>/dataTables.tableTools.js"></script>
  <script src="<?php echo base_url('public/js');?>/waitProcessing.js"></script>
  <script src="<?php echo base_url('public/js');?>/funciones.js"></script>
  <script src="<?php echo base_url('public/js');?>/menuHover.js"></script>
  <script src="<?php echo base_url('public/js');?>/hegarss.js"></script>
  <script src="<?php echo base_url('public/js');?>/validaciones.js"></script>
  <script src="<?php echo base_url('public/js');?>/jquery.datetimepicker.js"></script>
  <script src="<?php echo base_url('public/js');?>/funcionesEliminar.js"></script>
  <script src="<?php echo base_url('public/js');?>/moment.min.js"></script>
  <script src="<?php echo base_url('public/js');?>/fullcalendar.min.js"></script>
  <script src="<?php echo base_url('public/js');?>/es.js"></script>
  <script type="text/javascript" src="<?php echo base_url('public/js')?>/zjs.utils.js"></script>
  <script type="text/javascript" src="<?php echo base_url('public/js');?>/noty/packaged/jquery.noty.packaged.min.js"></script>
<!--  <script type="text/javascript" src="<?php //echo base_url('public/js');?>/js/noty/themes/bootstrap.js"></script>-->


  <title>Avanza C</title>
</head>
<body>

<div class="modal fade" id="myModalCambioejerciciotrabajo" role="dialog" >
<div class="modal-dialog modal-lg" >
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Selecciona el ejercicio a trabajar</h1>
        </div>
        <div class="modal-body" >
             <div class="row">
                       <div class="col-md-2">
                          <label for="">Mes</label>
                          <select name="mes" id="mes" class="form-control" onchange="cambiofecha()">
                          </select>
                         </div>
                         <div class="col-md-5">
                         <br>
                           <input type="text" id="mesletra" name="mesletra" readonly class="form-control">
                         </div>
                         <div class="col-md-3">
                          <label for="">Año</label>
                          <select name="ano" id="ano" class="form-control">
                          </select>
                         </div>
                     
              </div>
        </div>
        <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="cambiotrabajo()">Aceptar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>
</div>

<script>
  $(document).ready(function() {
    const fecha = new Date();
    const mesActual = fecha.getMonth() + 1; 
    
    if (mesActual == 1)
    {
       document.getElementById('mes').value = '01';
       cambiofecha();
    }
    else if (mesActual == 2)
    {
       document.getElementById('mes').value = '02';
       cambiofecha();
    }
    else if (mesActual == 3)
    {
       document.getElementById('mes').value = '03';
       cambiofecha();
    }
    else if (mesActual == 4)
    {
       document.getElementById('mes').value = '04';
       cambiofecha();
    }
    else if (mesActual == 5)
    {
       document.getElementById('mes').value = '05';
       cambiofecha();
    }
    else if (mesActual == 6)
    {
       document.getElementById('mes').value = '06';
       cambiofecha();
    }
    else if (mesActual == 7)
    {
       document.getElementById('mes').value = '07';
       cambiofecha();
    }
    else if (mesActual == 8)
    {
       document.getElementById('mes').value = '08';
       cambiofecha();
    }
    else if (mesActual == 9)
    {
       document.getElementById('mes').value = '09';
       cambiofecha();
    }
    else if (mesActual == 10)
    {
       document.getElementById('mes').value = '10';
       cambiofecha();
    }
    else if (mesActual == 11)
    {
       document.getElementById('mes').value = '11';
       cambiofecha();
    }
    else if (mesActual == 12)
    {
       document.getElementById('mes').value = '12';
       cambiofecha();
    }
  });
</script>

<script>
function cambiotrabajo()
{
    var mes = document.getElementById('mes').value;
    var mesle = document.getElementById('mesletra').value;
    var ano = document.getElementById('ano').value;

    if(mes == '')
    {
      var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'No ha seleccionado el ejercicio de trabajo.'}); 
    }
    else if(mesle == '')
    {
      var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'No ha seleccionado el ejercicio de trabajo.'});
    }
    else
    {
        jQuery.ajax({
              type:"POST",
              url: baseurl + "Inicio/CambioEjercicio",
              data:{mes:mes,mesle:mesle,ano:ano},
              dataType:"html",
              success:function(response)
              {
                location.reload();
              },
              error:function(error)
              {
                var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'No se pudo cambiar el ejercicio de trabajo, Intentelo mas tarde.'});
              }
        });
    }
}
function populateMonth() {
         var select = document.getElementById("mes");
         var options = ["01","02","03","04","05","06","07","08","09","10","11","12"];
         for(var i = 0; i < options.length; i++) {
               var opt = options[i];
               var el = document.createElement("option");
               el.textContent = opt;
               el.value = opt;
               select.appendChild(el);
         }
      }

// generate function for last 7 years
function populateYear() {
         var select = document.getElementById("ano");
         var year = new Date().getFullYear();
         for(var i = 0; i < 7; i++) {
               var opt = year--;
               var el = document.createElement("option");
               el.textContent = opt;
               el.value = opt;
               select.appendChild(el);
         }
      } 
// analyze function cambiofecha


function cambiofecha()
{
    var mes = document.getElementById('mes').value;
         switch(mes) {
          case '01':
               document.getElementById('mesletra').value = 'Enero';
            break;
          case '02':
               document.getElementById('mesletra').value = 'Febrero';
            break;
          case '03':
               document.getElementById('mesletra').value = 'Marzo';
            break;
          case '04':
               document.getElementById('mesletra').value = 'Abril';
            break;
          case '05':
               document.getElementById('mesletra').value = 'Mayo';
            break;
          case '06':
               document.getElementById('mesletra').value = 'Junio';
            break;
          case '07':
               document.getElementById('mesletra').value = 'Julio';         
            break;
          case '08':
               document.getElementById('mesletra').value = 'Agosto';        
            break;
          case '09':
               document.getElementById('mesletra').value = 'Septiembre';         
            break;
          case '10':
               document.getElementById('mesletra').value = 'Octubre';         
            break;
          case '11':
               document.getElementById('mesletra').value = 'Noviembre';         
            break;
          case '12':
               document.getElementById('mesletra').value = 'Diciembre';         
            break;
        }
}



$(document).ready(function(){
  populateMonth();
  populateYear();
});

</script>