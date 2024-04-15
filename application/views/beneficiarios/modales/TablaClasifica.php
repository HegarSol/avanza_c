<div class="modal fade" id="myClasifica" role="dialog" >
<div class="modal-dialog modal-lg" id="mdialTamanio">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <input type="hidden" id="renglonclasi" name="renglonclasi">
            <h1 class="modal-title">Verificar facturas</h1>
        </div>
            <div class="modal-body" >
               <div id="div1">
               <table cellspacing="0" width="100%" class="table table-bordered table-hover" id="tableclasifica">
               
                  <thead style="background-color:#222222; color:white;">
                     <th>UUID</th>
                     <th>Poliza</th>
                     <th>No proveedor</th>
                     <th>Accion</th>
                  </thead>
                 
                  <tbody>
                     
                  </tbody>
                  
               </table>
               </div>

            </div>
        <div class="modal-footer">
           <button type="button" class="btn btn-success"  data-dismiss="modal" aria-hidden="true" onclick="cuentaautomaticabanco('asiento_conta')" >Aceptar</button>
        </div>
    </div>
</div>
</div>
<script>
function cuentaautomaticabanco(tableID)
{
   var table = x(tableID);
   
   var monto = document.getElementById('montopoli').value;
   var nom_prov = document.getElementById('noprov').value;
 
  // console.log(poli);
   var clasi = 1;

   if(monto == '')
   {
       // console.log('aquies');
   }
   else
   {

       var no_banco = '<?php echo $datos[0]["no_banco"]; ?>';

       jQuery.ajax({
          type:"POST",
          url: baseurl+"catalogos/bancos/getbanco",
          data:{id:no_banco,clasi:clasi},
          dataType:"html",
          success:function(response)
          {
             response=JSON.parse(response);
         

             if(response.length > 1)
             {

                        
                  $('#asiento_conta tbody').empty();
                  document.getElementById('positivo').value = 0;
                  document.getElementById('negativo').value = 0;
                  document.getElementById('totalpoliza').value = 0;

                 for(var i in response)
                 {
                      if(response[i].val == 1)
                      {
                          var monto = parseFloat(document.getElementById('montopoli').value);
                      }
                      else
                      {
                          var monto = parseFloat(response[i].monto);
                      }

                        var tbody = document.getElementById('asiento_conta').getElementsByTagName("TBODY")[0];
                        var row = document.createElement("TR")

                        var element1 = document.createElement("input");
                        element1.type = "checkbox";
                        element1.name = "chkbox[]";

                        var td0 = document.createElement("TD")
                        td0.style.textAlign = 'center';
                        td0.appendChild(element1)
                        var td1 = document.createElement("TD")
                        td1.appendChild(document.createTextNode(response[i].cta))
                        var td2 = document.createElement("TD")
                        td2.appendChild(document.createTextNode(response[i].sub_cta))
                        var td3 = document.createElement("TD")
                        td3.appendChild(document.createTextNode(nom_prov))
                        var td4 = document.createElement("TD")
                        td4.appendChild(document.createTextNode(''))
                        var td5 = document.createElement("TD")
                        td5.appendChild(document.createTextNode(response[i].banco))
                        var td6 = document.createElement("TD")
                        td6.appendChild(document.createTextNode(''))
                        var td7 = document.createElement("TD")
                        td7.appendChild(document.createTextNode(monto))

                        if(response[i].c_a == '+')
                        {
                            var signo = '-';
                        }
                        else
                        {
                            var signo = '+';
                        }
                        var td8 = document.createElement("TD")
                        td8.appendChild(document.createTextNode(signo))
                         

                        row.appendChild(td0);
                        row.appendChild(td1);
                        row.appendChild(td2);
                        row.appendChild(td3);
                        row.appendChild(td4);
                        row.appendChild(td5);
                        row.appendChild(td6);
                        row.appendChild(td7);
                        row.appendChild(td8);

                       // console.log(response[i].banco);

                       // $(row).insertBefore(tbody);

                        tbody.appendChild(row);

                        var posit = parseFloat(document.getElementById('positivo').value);
                        var nega = parseFloat(document.getElementById('negativo').value);

                        if(signo == '+')
                        {
                           var total = posit + monto;
                           document.getElementById('positivo').value = total.toFixed(2);
                        }
                        else
                        {
                          
                           var total = nega + monto;
                           document.getElementById('negativo').value = total.toFixed(2);
                        }

                        var posit2 = parseFloat(document.getElementById('positivo').value);
                        var nega2 = parseFloat(document.getElementById('negativo').value);

                        var total2 = posit2-nega2;

                        document.getElementById('totalpoliza').value = total2.toFixed(2);
                 }

                 jQuery.ajax({
                                 type:"POST",
                                 url: baseurl + "catalogos/Operaciones/eliminartablatemporal",
                                 data:{valor:1},
                                 dataType:"html",
                                 success:function(response)
                                 {
                                 }
                         });
             }
             else
             {

                  var monto = parseFloat(document.getElementById('montopoli').value);

                  var tbody = document.getElementById('asiento_conta').rows[1];
                  var row = document.createElement("TR")

                  var element1 = document.createElement("input");
                  element1.type = "checkbox";
                  element1.name = "chkbox[]";

                  var td0 = document.createElement("TD")
                  td0.style.textAlign = 'center';
                  td0.appendChild(element1)
                  var td1 = document.createElement("TD")
                  td1.appendChild(document.createTextNode(response[0].cta))
                  var td2 = document.createElement("TD")
                  td2.appendChild(document.createTextNode(response[0].sub_cta))
                  var td3 = document.createElement("TD")
                  td3.appendChild(document.createTextNode(nom_prov))
                  var td4 = document.createElement("TD")
                  td4.appendChild(document.createTextNode(''))
                  var td5 = document.createElement("TD")
                  td5.appendChild(document.createTextNode(response[0].banco))
                  var td6 = document.createElement("TD")
                  td6.appendChild(document.createTextNode(''))
                  var td7 = document.createElement("TD")
                  td7.appendChild(document.createTextNode(monto))
                  var td8 = document.createElement("TD")
                  if('<?php echo $tipo;?>' == 3)
                  {
                     td8.appendChild(document.createTextNode('+'))
                     var signo = '+';
                  }
                  else if('<?php echo $tipo; ?>' == 1)
                  {
                     var signo = document.getElementById('signopoli').value;
                     td8.appendChild(document.createTextNode(signo))
                  }
                  else
                  {
                     td8.appendChild(document.createTextNode('-'))
                     var signo = '-';
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

                  $(row).insertBefore(tbody);

                  //tbody.appendChild(row);

                  var posit = parseFloat(document.getElementById('positivo').value);
                  var nega = parseFloat(document.getElementById('negativo').value);

                  if(signo == '+')
                  {
                     var total = posit + monto;
                     document.getElementById('positivo').value = total.toFixed(2);
                  }
                  else
                  {
                     var total = nega + monto;
                     document.getElementById('negativo').value = total.toFixed(2);
                  }

                  var posit2 = parseFloat(document.getElementById('positivo').value);
                  var nega2 = parseFloat(document.getElementById('negativo').value);

                  var total2 = posit2-nega2;

                  document.getElementById('totalpoliza').value = total2.toFixed(2);
            }

            // agruparcuentas();
          }
       });
   }
}
</script>