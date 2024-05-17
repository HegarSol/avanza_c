<?php
if(!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
$desabilitado="";
if(isset($errores) && $errores!=""){
    for($i=0; $i<count($errores); $i++){
        echo "<script> var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: '".$errores[$i]."'});</script>";
    }
}

$img = $datosbanco[0]['logo'];

?>

<form class="form-horizontal">

<div class="panel-group">
   <div class="panel panel-default">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="row">
                 <input type="hidden" id="idbanco" name="idbanco" value="<?php echo $no_banco[0];?>" readonly>
                 <div class="col-sm-3">
                    <img id="blah" src="<?php echo isset($img) && $img!="0" ? "data:image/jpeg;base64,$img": base_url().'public/img/logo.png'?>" alt="your image" width="220px" height="110px" />
                </div>
                <div class="col-sm-2">
                    <br>
                    <br>
                    <b>Cuenta: <?php echo $datosbanco[0]['cuenta'] ?></b>
                    <br>
                    <b>Banco: <?php echo $datosbanco[0]['banco'] ?></b>
                </div>
                <div class="col-sm-2">
                    <br>
                    <label for="">Fecha pago:</label>
                    <input type="date" class="form-control" id="fechapago" name="fechapago">
                </div>
                <div class="col-sm-1">
                    <br>
                    <br>
                    <button type="button" class="btn btn-primary" onclick="buscarnominas()"><span class="glyphicon glyphicon-search"></span> Buscar</button>
                </div>
                <div class="col-sm-1">
                    <br>
                    <br>
                    <a href="<?php echo base_url().'catalogos/Bancos/index'?>" class="btn btn-info" role="button"><span class="fa fa-arrow-left"></span> Atras</a>
                </div>
                <div class="col-sm-1">
                    <br>
                    <br>
                    <button type="button" class="btn btn-success" onclick="polizarnomina()"> <span class="fa fa-check"></span> Polizar</button>
                </div>
            </div>
        </div>
   </div>
</div>

<div class="panel-group">
<div class="panel panel-default">
<div class="panel-heading"></div>
   <div class="panel-body">
     <div class="row">
           <div class="col-sm-6">
                <label for="">Concepto:</label>
                <input type="text" class="form-control" id="concepto" name="concepto" >
           </div>
           <div class="col-sm-4">
                <label for="">Referencia:</label>
                <input type="text" class="form-control" id="referencia" name="referencia">
           </div>
     </div>
  </div>
</div>
</div>
</div>

</form>

<div class="panel-group">
<div class="panel panel-default">
<div class="panel-heading"></div>
   <div class="panel-body">
    <div id="div1">
       <table id="tablaimporta" class="table table-bordered table-hover"  cellspacing="0" width="100%">
             <thead style="background-color:#5a5a5a; color:white;">
                 <tr>
                    <th>Seleccionar</th>
                    <th>Tipo operacion</th>
                    <th>Nombre</th>
                    <th>Sueldo</th>
                    <th>Vacaciones</th>
                    <th>Aguinaldo</th>
                    <th>PTU</th>
                    <th>Otras percep</th>
                    <th>Prima vacacional</th>
                    <th>ISR</th>
                    <th>IMSS</th>
                    <th>Infonavit</th>
                    <th>Total</th>
                 </tr>
             </thead>
             <tbody>
            </tbody>
      </table>
    </div>
   </div>
</div>
</div>


<script>
    function checar()
   {
         var detallereci = [];
          $("input[type=checkbox]:checked").each(function(){
                var recibo = [];
                var tipo = $(this).parent().parent().find('td:eq(1)').find('select').val();
                var nombre = $(this).parent().parent().find('td').eq(2).html();
                var sueldo = $(this).parent().parent().find('td').eq(3).html();
                var vacaciones = $(this).parent().parent().find('td').eq(4).html();
                var aguinaldo = $(this).parent().parent().find('td').eq(5).html();
                var ptu = $(this).parent().parent().find('td').eq(6).html();
                var otraperce = $(this).parent().parent().find('td').eq(7).html();
                var primavaca = $(this).parent().parent().find('td').eq(8).html();
                var isr = $(this).parent().parent().find('td').eq(9).html();
                var imss = $(this).parent().parent().find('td').eq(10).html();
                var infonavit = $(this).parent().parent().find('td').eq(11).html();
                var total = $(this).parent().parent().find('td').eq(12).html();
                recibo = [tipo,nombre,sueldo,vacaciones,aguinaldo,ptu,otraperce,primavaca,isr,imss,infonavit,total];
                detallereci.push(recibo);
            });
            return detallereci;
   }
    function polizarnomina()
    {
        var chek = checar();
        var concep = document.getElementById('concepto').value;
        var refe = document.getElementById('referencia').value;
        var id = document.getElementById('idbanco').value;

        jQuery.ajax({
            type:"POST",
            url: baseurl+"catalogos/Importan/insertpolizar",
            data:{chek:chek,concep:concep,refe:refe,id:id},
            dataType:"html",
            success:function(response)
            {

            }
        });
    }
    function buscarnominas()
    {


        var id = document.getElementById('idbanco').value;
        var fechap = document.getElementById('fechapago').value;

            jQuery.ajax({
                type:"POST",
                url: baseurl+"catalogos/Importan/getNomina",
                data:{id:id,fechap:fechap},
                dataType:"html",
                success:function(response)
                {
                    $("#tablaimporta tbody").empty();
                    response=JSON.parse(response);
                    if(response.length == 0)
                    {
                        swal("Sin datos", "No hay datos con esta fecha de pago o puede que si haya, pero no esten timbrados.", "warning");
                    }
                    else
                    {
                        for(var i in response)
                        {
                            var nombre = response[i].nombre;
                            var sueldo = response[i].sueldo;
                            var vacaciones = response[i].vacaciones;
                            var aguinaldo = response[i].aguinaldo;
                            var ptu = response[i].ptu;
                            var otras_perce = response[i].otras_percepciones;
                            var prima_vacacional = response[i].prima_vacacional;
                            var isr = response[i].isr;
                            var imss = response[i].imss;
                            var infonavit = response[i].infonavit;

                            var total = parseFloat(sueldo) + parseFloat(vacaciones) + parseFloat(aguinaldo) + parseFloat(ptu) + parseFloat(otras_perce) + parseFloat(prima_vacacional) - parseFloat(isr) - parseFloat(imss) - parseFloat(infonavit);

                            var tbody = document.getElementById('tablaimporta').getElementsByTagName("TBODY")[0];
                            var row = document.createElement("TR")

                            var element1 = document.createElement("input");
                            element1.type = "checkbox";
                            element1.name="chkbox[]";     
                            element1.checked = true;    
                            element1.setAttribute('onChange','');
                            var td1 = document.createElement("TD")
                            td1.style.textAlign = 'center';
                            td1.appendChild(element1)

                            var element2 = document.createElement("select");
                            var td2 = document.createElement("TD")

                            var array = ["Transferencia","Cheque"];
                            
                            for (var i = 0; i < array.length; i++) 
                            {
                                    var option = document.createElement("option");
                                    option.value = array[i];
                                    option.text = array[i];
                                    element2.appendChild(option);
                                    td2.appendChild(element2);
                            }

                            td2.style.textAlign = 'center';
                            element2.className = 'form-control';
                            

                            var td3 = document.createElement("TD")
                            td3.appendChild(document.createTextNode(nombre))
                            var td4 = document.createElement("TD")
                            td4.appendChild(document.createTextNode(sueldo.toFixed(2)))
                            var td5 = document.createElement("TD")
                            td5.appendChild(document.createTextNode(vacaciones.toFixed(2)))
                            var td6 = document.createElement("TD")
                            td6.appendChild(document.createTextNode(aguinaldo.toFixed(2)))
                            var td7 = document.createElement("TD")
                            td7.appendChild(document.createTextNode(ptu.toFixed(2)))
                            var td8 = document.createElement("TD")
                            td8.appendChild(document.createTextNode(otras_perce.toFixed(2)))
                            var td9 = document.createElement("TD")
                            td9.appendChild(document.createTextNode(prima_vacacional.toFixed(2)))
                            var td10 = document.createElement("TD")
                            td10.appendChild(document.createTextNode(isr.toFixed(2)))
                            var td11 = document.createElement("TD")
                            td11.appendChild(document.createTextNode(imss.toFixed(2)))
                            var td12 = document.createElement("TD")
                            td12.appendChild(document.createTextNode(infonavit.toFixed(2)))
                            var td13 = document.createElement("TD")
                            td13.appendChild(document.createTextNode(total.toFixed(2)))
                            
                            
                            row.appendChild(td1);
                            row.appendChild(td2);
                            row.appendChild(td3);
                            row.appendChild(td4);
                            row.appendChild(td5);
                            row.appendChild(td6);
                            row.appendChild(td7);
                            row.appendChild(td8);
                            row.appendChild(td9);
                            row.appendChild(td10);
                            row.appendChild(td11);
                            row.appendChild(td12);
                            row.appendChild(td13);


                            tbody.appendChild(row);
                        }
                    }
                }
            });

        
    }
</script>