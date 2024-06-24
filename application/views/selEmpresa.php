<?php
if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');

?>
<body>
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-ls"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <ul class="nav navbar-nav navbar-left"> <li>
          <img src="<?php echo base_url();?>/public/img/bg.jpg" class="img-circle" alt="Cinque Terre" width="25" height="25">
          <font color = "white">Bienvenido, <b><?php echo $_SESSION['nombreU'];?> </b></font>
          <button type="button" id="logout" class="btn btn-success">Cerrar Sesión</button>
       </li></ul>
      </div></div></nav><br><br><br><br><br><br>
  <div class="container"><br><br>
     <div class="form-group">
      <h2>Bienvenido, <?php echo $_SESSION['nombreU']; ?>. </h12>
      <h2>Seleccione una Empresa:</h2>
      <?php
      if($_SESSION['tipo']=='SU')
      echo '<label class="col-sm-3">Filtrar Empresas:</label><div class="col-sm-9"><input id="buscar" name="buscar" class="form-control"></div><div class="col-sm-12"><br></div>';
      ?>

      <select <?php echo $_SESSION['tipo']=='SU'?'size="15"':'';?> class="form-control" id="empresas" name="empresas" >
      <?php
          for($i=0; $i<count($empresas);$i++)
          { echo '<option value="'.$empresas[$i]["idEmpresa"].'">'.$empresas[$i]['rfcEmpresa'].' - '.$empresas[$i]['razon'].'</option>';}
      ?>
      </select>
    </div>
    <div class="form-group" align="right">
      <button type="button" onclick="mostrarejercicio()" class="btn btn-success btn-lg">Continuar</button>
   </div>
 </div>

  <div class="modal fade" id="modalConfig" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-blue" style="background-color:#222222; color:white;">           
            <h4 class="modal-title" id="myModalLabel">Selecciona el ejercicio a trabajar</h4>
          </div>
            <?php
                echo form_open('inicio/SelecEmpresa');
              ?>
              <div class="modal-body">
                      <div class="row">
                       <div class="col-md-2">
                          <label for="">Mes</label>
                          <select name="mes2" id="mes2" class="form-control" onchange="cambiofecha2()">
                            <option value="" selected> -Seleccione- </option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                          </select>
                         </div>
                         <div class="col-md-5">
                         <br>
                           <input type="text" id="mesletra2" name="mesletra2" readonly class="form-control">
                         </div>
                         <div class="col-md-3">
                          <label for="">Año</label>
                          <select name="ano" id="ano" class="form-control">
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024" selected>2024</option>
                          </select>
                         </div>
                      </div>
                      <input type="hidden" id="empre" name="empre" readonly>
              </div>
          
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Aceptar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
          </form>
        </div>
      </div>
</div>
<script>
function mostrarejercicio()
{
  document.getElementById('empre').value = document.getElementById('empresas').value;
  //dsd();
  cambiofecha2();
   $('#modalConfig').modal('show');
   
}
function dsd()
    {
        var fecha = new Date();
        var hoy = fecha.getDate();
        var mesAnterior = fecha.getMonth(); 

        document.getElementById('mes2').value = '0'+mesAnterior;
    }
function cambiofecha2()
{
    var mes = document.getElementById('mes2').value;
         switch(mes) {
          case '01':
               document.getElementById('mesletra2').value = 'Enero';
            break;
          case '02':
               document.getElementById('mesletra2').value = 'Febrero';
            break;
          case '03':
               document.getElementById('mesletra2').value = 'Marzo';
            break;
          case '04':
               document.getElementById('mesletra2').value = 'Abril';
            break;
          case '05':
               document.getElementById('mesletra2').value = 'Mayo';
            break;
          case '06':
               document.getElementById('mesletra2').value = 'Junio';
            break;
          case '07':
               document.getElementById('mesletra2').value = 'Julio';         
            break;
          case '08':
               document.getElementById('mesletra2').value = 'Agosto';        
            break;
          case '09':
               document.getElementById('mesletra2').value = 'Septiembre';         
            break;
          case '10':
               document.getElementById('mesletra2').value = 'Octubre';         
            break;
          case '11':
               document.getElementById('mesletra2').value = 'Noviembre';         
            break;
          case '12':
               document.getElementById('mesletra2').value = 'Diciembre';         
            break;
        }

}
</script>

<script>
  $(document).ready(function() {
    const fecha = new Date();
    const mesActual = fecha.getMonth() + 1; 
    
    if (mesActual == 1)
    {
       document.getElementById('mes2').value = '01';
       cambiofecha2();
    }
    else if (mesActual == 2)
    {
       document.getElementById('mes2').value = '02';
       cambiofecha2();
    }
    else if (mesActual == 3)
    {
       document.getElementById('mes2').value = '03';
       cambiofecha2();
    }
    else if (mesActual == 4)
    {
       document.getElementById('mes2').value = '04';
       cambiofecha2();
    }
    else if (mesActual == 5)
    {
       document.getElementById('mes2').value = '05';
       cambiofecha2();
    }
    else if (mesActual == 6)
    {
       document.getElementById('mes2').value = '06';
       cambiofecha2();
    }
    else if (mesActual == 7)
    {
       document.getElementById('mes2').value = '07';
       cambiofecha2();
    }
    else if (mesActual == 8)
    {
       document.getElementById('mes2').value = '08';
       cambiofecha2();
    }
    else if (mesActual == 9)
    {
       document.getElementById('mes2').value = '09';
       cambiofecha2();
    }
    else if (mesActual == 10)
    {
       document.getElementById('mes2').value = '10';
       cambiofecha2();
    }
    else if (mesActual == 11)
    {
       document.getElementById('mes2').value = '11';
       cambiofecha2();
    }
    else if (mesActual == 12)
    {
       document.getElementById('mes2').value = '12';
       cambiofecha2();
    }
  });
</script>

  
  <script>
  //jQuery extension method:
jQuery.fn.filterByText = function(textbox) {
  return this.each(function() {
    var select = this;
    var options = [];
    $(select).find('option').each(function() {
      options.push({
        value: $(this).val(),
        text: $(this).text()
      });
    });
    $(select).data('options', options);

    $(textbox).bind('change keyup', function() {
      var options = $(select).empty().data('options');
      var search = $.trim($(this).val());
      var regex = new RegExp(search, "gi");

      $.each(options, function(i) {
        var option = options[i];
        if (option.text.match(regex) !== null) {
          $(select).append(
            $('<option>').text(option.text).val(option.value)
          );
        }
      });
    });
  });
};

$(function() {
  $('select').filterByText($('input'));
});

$("#btnXML").click(function ()
{
  var sel = x("empresas");
  var str=sel.options[sel.selectedIndex].text;
  var rfc= str.split(" - ",1);
  alert(rfc);
  window.open("<?php echo base_url();?>index.php/welcome/xml2/"+rfc, '_blank');
});


$("#logout").click(function (){
  location.href="<?php echo base_url();?>inicio/logout";
});
  </script>
