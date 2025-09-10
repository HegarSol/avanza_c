<?php
if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
?>

<br>
  <div class= "contairner-fluid">
   <div class="panel panel-default">
      <div class="panel-heading">

      </div>
      <div class="panel-body">
          <div class="col-md-12">
            <table id="cuentas" class="stripe row-border responsive nowrap"  cellspacing="0" width="100%">
              <thead style="background-color:#5a5a5a; color:white;">
                <th>Id</th>
                <th>Cuenta</th>
                <th>Sub cuenta</th>
                <th>Sub sub cuenta</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Cta SAT</th>
                <th>Naturaleza</th>
                <th>Cve Cobro</th>
                <th>Acciones</th>
              </thead>
            </table>
          </div>
      </div>
      <div class="panel-footer">
            <a href="<?php echo base_url();?>catalogos/Cuentas/agregar" class="btn btn-success btn-lg" role="button" ><span class="glyphicon glyphicon-plus" ></span> Agregar cuenta</a>
            <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modalGroupcuentas"><span class="fa fa-clone"></span> Agrupar cuentas</button>         
            <button type="button" onclick="imprimir()" <?php echo $permisosGrupo['print']==1 ? '':'disabled'?> class="btn btn-success btn-lg"><span class="fa fa-print"></span> Imprimir</button>                      
            <button type="button" class="btn btn-success btn-lg" <?php echo $permisosGrupo['print']==1 ? '':'disabled'?> onclick="ReporteExcel()"><span class="fa fa-file-excel-o"></span> Exportar excel</button>            
            <button type="button" class="btn btn-success btn-lg" onclick="generalcuentaxml()"><span class="fa fa-file-code-o"></span> XML SAT</button>
            <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modalConfig"><span class="fa fa-gear"></span> Configuración</button>
            <a href="https://www.sat.gob.mx/personas/iniciar-sesion" class="btn btn-primary btn-lg" target="_blank"><span class="fa fa-qrcode"></span> Buzón SAT</a>
      </div>
  </div>
  </div>
  <div class="col-md-2 col-lg-2 col-sm-3" align="center">
    <br>
     </div><br>
  <div class="col-md-10 col-lg-10 col-sm-9">
  </div><div class="col-sm-1"></div>
</div>

<div class="modal fade" id="modalGroupcuentas"  role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-blue" style="background-color:#222222; color:white;">           
            <h4 class="modal-title" id="myModalLabel">Agrupar cuentas</h4>
          </div>
              <div class="modal-body">
                   <div class="row">
                        <div class="col-md-2">
                            <label for="">Cuenta</label>
                            <input type="text" class="form-control" onblur="buscarcuentas()" id="grupocuentas">
                        </div>
                        <div class="col-md-2">
                            <label for="">Sub cuenta</label>
                            <input type="text" class="form-control" onblur="buscarsubcuenta()" id="gruposubcuentas">
                        </div>
                        <div class="col-md-2">
                            <label for="">Sub cta destino</label>
                            <input type="text" class="form-control" id="gruposubcuentadestino">
                        </div>
                        <div class="col-md-3">
                            <label for="">Nombre</label>
                            <input type="text" class="form-control" id="nombredestino">
                        </div>
                        <div class="col-md-2">
                          <br>
                            <button type="button" class="btn btn-success" onclick="insertsubcuenta()" id="gruposubcuentas">Aceptar</button>
                        </div>
                   </div>
                   <br>
                   <br>
                  <table id="groupcuentas1" class="table table-bordered table-hover" cellspacing="0" widht="100%">
                    <thead style="background-color:#5a5a5a; color:white;">
                          <th>Seleccionar</th>
                          <th>id</th>
                          <th>Cuenta</th>
                          <th>Sub cuenta</th>
                          <th>Sub sub cuenta</th>
                          <th>Nombre</th>
                    </thead>
                    <tbody></tbody>
                  </table>
              </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
</div>

<div class="modal fade" id="modalConfig" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-blue" style="background-color:#222222; color:white;">           
            <h4 class="modal-title" id="myModalLabel">Configuración Cuentas</h4>
          </div>
              <div class="modal-body">
                  <table id="configcuentas" class="stripe row-border responsive nowrap" cellspacing="0" widht="100%">
                    <thead style="background-color:#5a5a5a; color:white;">
                         
                        <th>Descripcion</th>
                        <th>Cuenta</th>
                        <th>Sub Cuenta</th>
                        <th>Ssub Cuenta</th>
                        <th>Acciones</th>
                    </thead>
                  </table>
              </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
</div>


<div class="modal fade" id="modalXML" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header bg-blue" style="background-color:#222222; color:white;">
           
            <h4 class="modal-title" id="myModalLabel"></h4>
          </div>
              <div class="modal-body">
                 
                     <label for="">Elija el Mes:</label>
                     <select name="messat" id="messat" class="form-control">
                        <option value="" selected> -Seleccione- </option>
                        <option value="01">01 - Enero</option>
                        <option value="02">02 - Febrero</option>
                        <option value="03">03 - Marzo</option>
                        <option value="04">04 - Abril</option>
                        <option value="05">05 - Mayo</option>
                        <option value="06">06 - Junio</option>
                        <option value="07">07 - Julio</option>
                        <option value="08">08 - Agosto</option>
                        <option value="09">09 - Septiembre</option>
                        <option value="10">10 - Octubre</option>
                        <option value="11">11 - Noviembre</option>
                        <option value="12">12 - Diciembre</option>
                     </select>
                 
              </div>
          <div class="modal-footer">
            <button type="button" onclick="cambiarano()" class="btn btn-primary">Aceptar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalEditarCuenta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-blue" style="background-color:#222222; color:white;">
             
            <h4 class="modal-title" id="myModalLabel">Editar Cuenta</h4>
          </div>
              <div class="modal-body">
              <input type="hidden" readonly id="idcuentaconfi" name="idcuentaconfi">
                 <div class="row">
   
                    <label  class="control-label col-sm-2" for="">Cuenta:</label>
                     <div class="col-md-2">                  
                        <input type="text" class="form-control" id="cuenta" name="cuenta">
                     </div>

                     <label  class="control-label col-sm-2" for="">Sub Cuenta:</label>
                     <div class="col-md-2">                      
                        <input type="text" class="form-control" id="sub_cuenta" name="sub_cuenta">
                     </div>

                     <label  class="control-label col-sm-2" for="">Ssub Cuenta</label>
                     <div class="col-md-2">    
                         <input type="text" class="form-control" id="ssub_cuenta" name="ssub_cuenta">
                     </div>

                 </div>
              </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="guardacuenta()">Aceptar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalXMLano" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header bg-blue" style="background-color:#222222; color:white;">
           
            <h4 class="modal-title" id="myModalLabel"></h4>
          </div>
              <div class="modal-body">
                 
                     <label for="">Elija el Año:</label>
                     <input type="text" class="form-control" id="anio" name="anio">
                 
              </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="xmlcrear()">Aceptar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
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
                var id = $(this).parent().parent().find('td').eq(1).html();
                var sscta = $(this).parent().parent().find('td').eq(4).html();
                var eliminar = "Eliminar";
                recibo = [id,sscta,eliminar];
                detallereci.push(recibo);
            });
            return detallereci;
   }
      function insertsubcuenta()
      {
          var dessubcuenta = $("#gruposubcuentadestino").val();
          var cuenta = $("#grupocuentas").val();
          var nombredes = $('#nombredestino').val();
          if(dessubcuenta == "" || dessubcuenta == 0)
          {
            swal("Advertencia", "Escriba la Sub cuenta destino.", "warning");
          }
          else
          {

              jQuery.ajax({
                 type: "POST",
                  url: "<?php echo base_url(); ?>catalogos/cuentas/buscarsubcuentaexistente",
                  dataType: 'json',
                  data: {dessubcuenta: dessubcuenta,cuenta:cuenta},
                  success:function(response)
                  {
                      if(response.length > 0)
                      {
                          swal("Advertencia", "Ya éxiste una cuenta con la Sub cuenta destino.", "warning");
                      }
                      else
                      {
                        var chek = checar();
                          if(chek == '')
                          {
                              var n = noty({ layout:'topRight',type: 'warning', theme:'relax', text: 'No ha seleccionado las cuentas.'});
                          }
                          else
                          {

                              for(var i in chek)
                               {
                                   var id = chek[i][0];
                                   var ssbcta = chek[i][1];

                                   jQuery.ajax({
                                      type: "POST",
                                      url: "<?php echo base_url(); ?>catalogos/cuentas/insertsubcuentadestino",
                                      dataType: 'html',
                                      data: {dessubcuenta: dessubcuenta,cuenta:cuenta,id:id,ssbcta:ssbcta,nombredes:nombredes},
                                      success:function(response)
                                      {
                                        swal("Listo", "Creado(s) correctamente.", "success");
                                          $("#gruposubcuentadestino").val('');
                                          $("#grupocuentas").val('');
                                          $("#gruposubcuentas").val('');
                                          $("#groupcuentas1 tbody").empty();
                                      }
                                  });
                               }
                               $('modalGroupcuentas').modal('hide');
                          }
                      }
                  }
              });
          }
      }
      function generalcuentaxml()
      {
         jQuery.ajax({
                  type:'POST',
                  url: "<?php echo base_url();?>catalogos/cuentas/validarcatalogo",
                  data:{1:1},
                  dataType:'html',
                  success:function(response)
                  {
                      response=JSON.parse(response);
                      console.log(response);
                      if(response.estatus == false)
                      {
                         swal("Error", response.error, "error");

                      }
                      else
                      {
                        $('#modalXML').modal('show');
                      }
                  }
                });
      }
      function buscarsubcuenta()
      {
        var cuenta = $("#grupocuentas").val();
        var subcuenta = $("#gruposubcuentas").val();

        if(cuenta == "" || cuenta == 0)
        {
            swal("Advertencia", "Escriba una cuenta.", "warning");
        }
        else if(subcuenta == "" || subcuenta == 0)
        {
            swal("Advertencia", "Escriba una subcuenta.", "warning");
        }
        else
        {
              jQuery.ajax({
                type:'POST',
                url: "<?php echo base_url();?>catalogos/cuentas/buscarsubcuentas",
                data:{cuenta:cuenta,subcuenta:subcuenta},
                dataType:'html',
                success:function(response)
                {
                  $("#groupcuentas1 tbody").empty();
                    response=JSON.parse(response);
                    for(var i in response)
                    {
                        

                        var btn = document.createElement("INPUT");
                        btn.setAttribute("type","checkbox");
                        btn.className = 'form-control';

                        var tbody = document.getElementById
                        ('groupcuentas1').getElementsByTagName("TBODY")[0];
                        var row = document.createElement("TR")
                        var td1 = document.createElement("TD")
                        td1.appendChild(btn)
                        var td2 = document.createElement("TD")
                        td2.appendChild(document.createTextNode(response[i].idcuenta))
                        var td3 = document.createElement("TD")
                        td3.appendChild(document.createTextNode(response[i].cuenta))
                        var td4 = document.createElement("TD")
                        td4.appendChild(document.createTextNode(response[i].sub_cta))
                        var td5 = document.createElement("TD")
                        td5.appendChild(document.createTextNode(response[i].ssub_cta))
                        var td6 = document.createElement("TD")
                        td6.appendChild(document.createTextNode(response[i].nombre))



                        row.appendChild(td1);
                        row.appendChild(td2);
                        row.appendChild(td3);
                        row.appendChild(td4);
                        row.appendChild(td5);
                        row.appendChild(td6);
                        tbody.appendChild(row);
                    }

                

                }
              })
          }
      }
      function buscarcuentas()
      {
              var cuenta = $("#grupocuentas").val();

        if(cuenta == "" || cuenta == 0)
        {
            swal("Advertencia", "Escriba una cuenta.", "warning");
        }
        else
        {
               jQuery.ajax({
                  type:'POST',
                  url: "<?php echo base_url();?>catalogos/cuentas/buscarcuentas",
                  data:{cuenta:cuenta},
                  dataType:'html',
                  success:function(response)
                  {
                    $("#groupcuentas1 tbody").empty();
                     response=JSON.parse(response);
                     for(var i in response)
                     {
                          

                          var btn = document.createElement("INPUT");
                          btn.setAttribute("type","checkbox");
                          btn.className = 'form-control';

                          var tbody = document.getElementById
                          ('groupcuentas1').getElementsByTagName("TBODY")[0];
                          var row = document.createElement("TR")
                          var td1 = document.createElement("TD")
                          td1.appendChild(btn)
                          var td2 = document.createElement("TD")
                          td2.appendChild(document.createTextNode(response[i].idcuenta))
                          var td3 = document.createElement("TD")
                          td3.appendChild(document.createTextNode(response[i].cuenta))
                          var td4 = document.createElement("TD")
                          td4.appendChild(document.createTextNode(response[i].sub_cta))
                          var td5 = document.createElement("TD")
                          td5.appendChild(document.createTextNode(response[i].ssub_cta))
                          var td6 = document.createElement("TD")
                          td6.appendChild(document.createTextNode(response[i].nombre))



                          row.appendChild(td1);
                          row.appendChild(td2);
                          row.appendChild(td3);
                          row.appendChild(td4);
                          row.appendChild(td5);
                          row.appendChild(td6);
                          tbody.appendChild(row);
                     }

                  

                  }
               })
          }
      }
    function editarCuenta(valor)
    {

       document.getElementById('idcuentaconfi').value = valor;

       $.ajax({
            type:"POST",
            url:"<?php echo base_url();?>configuracion/getconfigcuenta",
            data:{valor:valor},
            dataType:"html",
            success:function(response)
            {
                response=JSON.parse(response);
                document.getElementById('cuenta').value = response[0]['cuenta'];
                document.getElementById('sub_cuenta').value = response[0]['sub_cta'];
                document.getElementById('ssub_cuenta').value = response[0]['ssub_cta'];
                $('#modalEditarCuenta').modal('show');
            }
       });
    }
    function guardacuenta()
    {
       var id = document.getElementById('idcuentaconfi').value;
       var cuen = document.getElementById('cuenta').value;
       var sub_cta = document.getElementById('sub_cuenta').value;
       var ssub_cta = document.getElementById('ssub_cuenta').value;

       $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>configuracion/guardaconfigcta",
            data:{id:id,cuen:cuen,sub_cta:sub_cta,ssub_cta:ssub_cta},
            dataType:"html",
            success:function(response)
            {
               $('#modalEditarCuenta').modal('hide');
               response = JSON.parse(response);
                if(response == true)
                {
                  $('#modalConfig').modal('hide');
                  swal('Correcto','Se guardo correctamente la configuración', 'success');
                }
                else
                {
                  $('#modalConfig').modal('hide');
                  swal("Error", "No se pudo guardar la configuración.", "error");
                }
            }
       });    
    }
    function cambiarano()
    {

        var mes = document.getElementById('messat').value;
        if(mes == '')
        {
          var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'No ha seleccionado el mes.'});
        }
        else
        {
           $('#modalXML').modal('hide');
           $('#modalXMLano').modal('show');
        }

    }
    function xmlcrear()
    {
      var mes = document.getElementById('messat').value;
      var anio = document.getElementById('anio').value;

      if(anio == '')
      {
        var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'No ha ingresado el año.'});
      }
      else if(anio < 2014)
      {
        var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'El año no puede ser menor al 2014.'});
      }
      else if(anio > '<?php echo date('Y');?>')
      {
        var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'El año no puede ser mayor al actual.'});
      }
      else
      {
          window.open('<?php echo base_url();?>catalogos/Cuentas/XMLCuentas/'+mes+'/'+anio,'_blank');

          $('#modalXMLano').modal('hide');
          document.getElementById('mes').value = '';
          document.getElementById('anio').value = '';
      }


    }
    function imprimir()
    {
      window.open("<?php echo base_url();?>reportes/Reportecuenta",'_blank');
    }
    function ReporteExcel()
    {
      try
      {
         var xyz=false;
         var url = '<?php echo base_url();?>reportes/ReporteExcelCuentas';
         $.ajax({
            type: "POST",
            url: url,
            data: {algo:1},
            success:function (msg)
            {
                var i=1;
                var nombre = '<?php echo $empresanombre[0]['nombreEmpresa']?>';
                if(msg != "")
                {
                   var tab_text="<h1>Reporte de Cuentas</h1>"+"<h1>"+nombre+"</h1>"+
                    "<table border='2px'> <tr><td bgcolor='#D7D7D7'>Cuenta</td><td bgcolor='#D7D7D7'>Sub Cuenta</td><td bgcolor='#D7D7D7'>Nombre</td><td bgcolor='#D7D7D7'>Tipo</td><td bgcolor='#D7D7D7'>"+
                    "Cuenta SAT</td><td bgcolor='#D7D7D7'>Naturaleza</td><td bgcolor='#D7D7D7'>Clave Cobro</td><td bgcolor='#D7D7D7'>Ssub Cuenta</td>";
                      for(i=0; i<msg.length; i++)
                      {
                        tab_text=tab_text+"<tr><td>"+msg[i].cuenta+'</td>'+
                        "<td>"+msg[i].sub_cta+"</td>"+
                        "<td>"+msg[i].nombre+"</td>"+
                        "<td>"+msg[i].tipo+"</td>"+
                        "<td>"+msg[i].ctasat+"</td>"+
                        "<td>"+msg[i].natur+"</td>"+
                        "<td>"+msg[i].cvecobro+"</td>"+
                        "<td>"+msg[i].ssub_cta+"</td></tr>";
                        tab_text=tab_text+"</tr>";
                      }

                      window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
                }
                else
                {
                   swal("Error",'Hubo un error al crear el archivo, por favor inténtelo de nuevo',"error");
                }
            }
         });
      }
      catch(e)
      {
         alert(e);
      }
    }
    </script>