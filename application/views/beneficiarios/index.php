<?php
if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
  $desabilitado="";
  if (isset($errores) && $errores!=""){
    for($i= 0; $i<count($errores); $i++)
    { echo "<script> var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: '".$errores[$i]."'});</script>"; }
  }
 
  $this->load->view('beneficiarios/modales/CuentasPagar');
  $this->load->view('beneficiarios/modales/Autorizacion');

?>

<div class="container-fluid">
   <div class="panel panel-default">
       <div class="panel-heading">
           <form class="form-horizontal">
               <div class="form-group">
                  &nbsp;&nbsp;
                  <a href="<?php echo base_url();?>catalogos/Beneficiarios/agregar" class="btn btn-success btn-lg" role="button"><span class="glyphicon glyphicon-plus"></span> Agregar Beneficiario</a>
                  <!-- <a href="<?php echo base_url();?>catalogos/Beneficiarios/estafeta" class="btn btn-warning btn-lg"><span class="fa fa-folder-open-o"></span> Estafeta</a> -->
                  <button type="button" onclick="beneestafe()" class="btn btn-warning btn-lg"><span class="fa fa-folder-open-o"></span> Estafeta</button>

                  <?php
                  if($permisotipo == 'SU' || $permisotipo == 'admin')
                  {
                  ?>
                  <button type="button" onclick="abrirautorizacion()" class="btn btn-info btn-lg"><span class="fa fa-check"></span> Autorización</button>
                  <?php
                  }
                  ?>
               </div>
           </form>
       </div>
       <div class="panel-body">
         <table id="Beneficiarios" class="stripe row-border responsive nowrap" cellspacing="0" width="100%">
             <thead style="background-color:#5a5a5a; color:white;">
                <tr>
                    <th>No Prov</th>
                    <th>Nombre</th>
                    <th>RFC</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>Tipo Proveedor</th>
                    <th>Acciones</th>
                </tr>
             </thead>
         </table>
       </div>
       <div class="panel-footer">
       </div>
   </div>
</div>


<script>
function abrirautorizacion()
{
         verTablaAutorizacion('<?php echo $rfc?>');
         $('#myModalAutorizacion').modal('show');  
}
function abrircuentaspagar(rfcReceptor,no_prov,nombre,rfcEmisor,direccion,tipo_prove)
{

               document.getElementById('numprov').innerHTML = no_prov;
               document.getElementById('nomprov').innerHTML = nombre;
               document.getElementById('rfcprov').innerHTML = rfcEmisor;
               document.getElementById('direprov').innerHTML = direccion;
               document.getElementById('tipoproveedor').value = tipo_prove;
               var forma2 = 'D';
               verTabla(rfcReceptor,forma2);

              $('#myModalCuentasPagar').modal('show');
          
}
function beneestafe()
{
// var oTT = $.fn.dataTable.TableTools.fnGetInstance("Beneficiarios");
//             var aData = oTT.fnGetSelectedData();
//             if (aData.length != 1) 
//                 { 
//                    var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Seleccione un registro.'});
//                 }
//             else
//             {
             // console.log(aData[0][0]);
              location.href="<?php echo base_url();?>catalogos/Beneficiarios/estafeta";
           // }
}
function verTablaAutorizacion(rfc)
{
  jQuery.ajax({
       url: baseurl+"catalogos/Beneficiarios/getAutorizacion",
       type:"POST",
       data:{rfc:rfc},
       dataType:"html",
       success:function(data)
       {
          if(data == 'No se encontraron registros')
          {
            $('#espacioEstafetaporpagar').innerHTML = 'No se encontraron registros';
          }
          else
          {
              data=JSON.parse(data);
              var totaldedua = 0;

              $('#tblAutorizacion tbody').empty();
              document.getElementById('total_pagar2').value = '';

              for(var i in data)
              {

                if(data[i].marca == 0)
                {
                   var btnp = document.createElement("INPUT");
                   btnp.setAttribute("type","button");
                   btnp.setAttribute('onclick',"descargarpdf('"+data[i].uuid+"')");
                   btnp.className = 'btn btn-danger';
                   btnp.value = 'PDF'
                }
                else
                {
                   var btnp = '';
                }

                if(data[i].marca == 0)
                {
                   var btn2 = document.createElement("INPUT");
                   btn2.setAttribute("type","button");
                   btn2.setAttribute('onclick',"descargarxml('"+data[i].uuid+"')");
                   btn2.className = 'btn btn-primary';
                   btn2.value = 'XML'
                }
                else
                {
                    var btn2 = '';
                }

                   if(data[i].marca == 0)
                   {
                    var btn3 = document.createElement('input');
                    btn3.type = 'checkbox';
                    btn3.id = 'check2';
                    btn3.setAttribute('onclick','checarsumar(this)');
                    btn3.className = 'form-control';
                   }
                   else
                   {
                      var btn3 = '';
                   }
                   var tbody = document.getElementById('tblAutorizacion').getElementsByTagName('TBODY')[0];
                   var row = document.createElement('TR')
                   var td0 = document.createElement('TD')
                   if(data[i].marca == 0)
                   {
                    td0.appendChild(btn3)
                   }
                   else
                   {
                    td0.appendChild(document.createTextNode(''))
                   }
                   var td1 = document.createElement('TD')
                   td1.appendChild(document.createTextNode(data[i].rfcpro))
                   var td2 = document.createElement('TD')
                   td2.appendChild(document.createTextNode(data[i].folio))
                   var td3 = document.createElement('TD')
                   td3.appendChild(document.createTextNode(data[i].fecha))
                   var td4 = document.createElement('TD')
                   td4.appendChild(document.createTextNode(data[i].fecha_pago))
                   var td5 = document.createElement('TD')
                   td5.appendChild(document.createTextNode(data[i].total))
                   var td6 = document.createElement('TD')
                   td6.appendChild(document.createTextNode(data[i].metodo_pago))
                   var td7 = document.createElement('TD')
                   td7.appendChild(document.createTextNode(data[i].uuid))
                   var td8 = document.createElement('TD')
                   if(data[i].marca == 0)
                   {
                     td8.appendChild(document.createTextNode(data[i].antiguedad+' días'))
                   }
                   else
                   {
                    td8.appendChild(document.createTextNode(''))
                   }
                   var td9 = document.createElement('TD')
                   
                   if(data[i].marca == 0)
                   {
                       td9.appendChild(btn2)
                   }
                   else
                   {
                       td9.appendChild(document.createTextNode(''))
                   }
                   var td10 = document.createElement('TD')
                   
                   if(data[i].marca == 0)
                   {
                       td10.appendChild(btnp)
                   }
                   else
                   {
                       td10.appendChild(document.createTextNode(''))
                   }
                   
                   if(data[i].marca == 0)
                   {
                     totaldedua = totaldedua + parseFloat(data[i].total);
                   }

                   row.appendChild(td0);
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
                   tbody.appendChild(row);
              }
              document.getElementById('total_deuda2').value = totaldedua.toFixed(2);
          }
       },
       error:function()
       {
        var n = noty({text: 'Error al recuperar la informacion', type: 'error', theme: 'relax'});
       }
    });
}
function checarsumar()
{

   var campos = '';
   var total = parseFloat(0);
          $("input[type=checkbox]:checked").each(function(){
                var recibo = [];

                var monto = parseFloat($(this).parent().parent().find('td').eq(5).html());
                total += monto;             

            });
            document.getElementById('total_pagar2').value = total.toFixed(2);
}
function descargarxml(uuid)
{
  window.open("https://avanzab.hegarss.com/comprobantes/descargarXML/" + uuid,'_blank');  
}
function descargarpdf(uuid)
{
  window.open("https://avanzab.hegarss.com/comprobantes/descargarPDF/" + uuid,'_blank');
}
</script>