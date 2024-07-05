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

                  <!-- <button type="button" onclick="abrirautorizacion()" class="btn btn-info btn-lg"><span class="fa fa-check"></span> Autorización</button> -->
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
              for(var i in data)
              {
                console.log(data[i]);
                   var btn3 = document.createElement('input');
                   btn3.type = 'checkbox';
                   btn3.id = 'check2';
                   btn3.className = 'form-control';

                   var tbody = document.getElementById('tblAutorizacion').getElementsByTagName('TBODY')[0];
                   var row = document.createElement('TR')
                   var td0 = document.createElement('TD')
                   td0.appendChild(btn3)
                   var td1 = document.createElement('TD')
                   td1.appendChild(document.createTextNode(data[i].version))
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
                   td8.appendChild(document.createTextNode(data[i].antiguedad+' días'))

                   row.appendChild(td0);
                   row.appendChild(td1);
                   row.appendChild(td2);
                   row.appendChild(td3);
                   row.appendChild(td4);
                   row.appendChild(td5);
                   row.appendChild(td6);
                   row.appendChild(td7);
                   row.appendChild(td8);
                   tbody.appendChild(row);
              }
          }
       },
       error:function()
       {
        var n = noty({text: 'Error al recuperar la informacion', type: 'error', theme: 'relax'});
       }
    });
}
</script>