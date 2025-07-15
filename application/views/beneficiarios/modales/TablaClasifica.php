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
         <div class= "col-md-5"></div>
         <div class= "col-md-2">
         <div style="<?php echo $_SESSION['referenciamarca'] == 1 ? '' : 'display:none' ?>" >
            <label for="">Referencia</label> <a class="glyphicon glyphicon-search" onclick="nomas()"></a>
           <input type="text" class="form-control" readonly id="referencia" name="referencia">
          </div>
          </div>
          <div class= "col-md-2">
            <div style="<?php echo $_SESSION['referenciamarca'] == 2 ? '' : 'display:none' ?>" >
            <label for="">Referencia:</label> <a class="glyphicon glyphicon-search" onclick="reflocal()"></a>
           <input type="text" class="form-control" readonly id="refe" name="refe">
          </div>
            </div>
         <div class= "col-md-2">
          <label for="">Departamento</label>
            <select class="form-control" id="departamentos" name="departamentos">
                <option value="-" selected></option>
            <?php foreach ($departamentos as $rowDC)
                {
                    echo"<option value='".$rowDC['clave']."'";
                    echo '>'.$rowDC['clave'].' - '.$rowDC['descripcion']; 
                    echo "</option>";
                }
                ?>
            </select>
         </div>
           <button type="button" class="btn btn-success"  data-dismiss="modal" aria-hidden="true" onclick="cuentaautomaticabanco('asiento_conta')" >Aceptar</button>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="myModalConcurso" role="dialog" >
        <div class="modal-dialog modal-lg" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Conscursos</h1>
         </div>
        <div class="modal-body" >
          <table id="tblConcursos" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                  <tr>
                    <th>Id</th>
                    <th>Codigo</th>
                    <th>Concepto</th>
                    <th>Accion</th>
                  </tr>
              </thead>
              <tbody></tbody>
          </table>

        </div>
        </div>

        </div>
        </div>

        <div class="modal fade" id="myModalReferencia" role="dialog" >
        <div class="modal-dialog modal-lg" >
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Referencias</h1>
        </div>
        <div class="modal-body" >
          <table id="tblReferencias" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                  <tr>
                    <th>Id</th>
                    <th>Referencia</th>
                    <th>Descripcion</th>
                    <th>Accion</th>
                  </tr>
              </thead>
              <tbody></tbody>
          </table>

        </div>
    </div>

    </div>
    </div>



<script>
function cuentaautomaticabanco(tableID)
{
   var table = x(tableID);
   var tipomovs = '<?php echo $tipo;?>';
   if('<?php echo $tipo;?>' == '4')
      {
         var monto = 1;
         var nom_prov = '';
      }
      else
      {
           var monto = document.getElementById('montopoli').value;
           var nom_prov = document.getElementById('noprov').value;
           
      }

      var uuid = [];
      var tableuuid = x('tableclasifica');  
       var rowCount = tableuuid.rows.length;
         for(var i = 0; i < rowCount; i++)
            {
                uuid[i] = tableuuid.rows[i].cells[0].innerHTML;
            }

                          var uud = JSON.stringify(uuid);

   var referencia = document.getElementById('referencia').value == '' ? document.getElementById('refe').value : document.getElementById('referencia').value;
  // console.log(poli);
   var clasi = 1;

   if(monto == '')
   {
       // console.log('aquies');
   }
   else
   {

       var no_banco = '<?php echo isset($datos[0]["no_banco"]) ? $datos[0]["no_banco"] : '' ?>';

       jQuery.ajax({
          type:"POST",
          url: baseurl+"catalogos/bancos/getbanco",
          data:{id:no_banco,clasi:clasi,tipomovs:tipomovs,referencia:referencia,uuid:uuid},
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
                        var td9 = document.createElement("TD")
                        td9.appendChild(document.createTextNode(response[i].ssub_cta))
                        var td3 = document.createElement("TD")
                        td3.appendChild(document.createTextNode(nom_prov))
                        var td4 = document.createElement("TD")
                        td4.appendChild(document.createTextNode(referencia))
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
                        row.appendChild(td9);
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
                  var td9 = document.createElement("TD")
                  td9.appendChild(document.createTextNode(response[0].ssub_cta))
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
                  row.appendChild(td9);
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
function nomas()
  {
     jQuery.ajax({
                     type: "POST",
                     url: baseurl+"catalogos/Beneficiarios/buscarconcurso",
                     data:{id:1},
                     dataType:'json',
                     success:function(response)
                     {
                          $('#tblConcursos tbody').empty();
                          for(var i in response)
                          {              
                            var btn = document.createElement("button");
                            btn.type = 'button';
                            btn.setAttribute('onclick','myfunctionconcurso(this)');
                            btn.className = 'btn btn-primary';
                            var btn2 = document.createTextNode("Seleccionar");
                            btn.appendChild(btn2);

                              var tbody = document.getElementById('tblConcursos').getElementsByTagName("TBODY")[0];
                              var row = document.createElement("TR")
                              var td1 = document.createElement("TD")
                              td1.appendChild(document.createTextNode(response[i].id))
                              var td2 = document.createElement("TD")
                              td2.appendChild(document.createTextNode(response[i].codigo))
                              var td3 = document.createElement("TD")
                              td3.appendChild(document.createTextNode(response[i].concepto))
                              var td4 = document.createElement("TD")
                              td4.appendChild(btn)

                              row.appendChild(td1);
                              row.appendChild(td2);
                              row.appendChild(td3);
                              row.appendChild(td4);
                              tbody.appendChild(row);
                          }
                           $('#myModalConcurso').modal('show');
                          
                     }
     });
  }

  function reflocal()
  {
     jQuery.ajax({
                     type: "POST",
                     url: baseurl+"catalogos/Referencias/buscarreferencia",
                     data:{id:1},
                     dataType:'json',
                     success:function(response)
                     {
                          $('#tblReferencias tbody').empty();
                          for(var i in response)
                          {          
                            
                            var btn = document.createElement("button");
                            btn.type = 'button';
                            btn.setAttribute('onclick','myfunctionreferencia(this)');
                            btn.className = 'btn btn-primary';
                            var btn2 = document.createTextNode("Seleccionar");
                            btn.appendChild(btn2);

                              var tbody = document.getElementById('tblReferencias').getElementsByTagName("TBODY")[0];
                              var row = document.createElement("TR")
                              var td1 = document.createElement("TD")
                              td1.appendChild(document.createTextNode(response[i].id))
                              var td2 = document.createElement("TD")
                              td2.appendChild(document.createTextNode(response[i].referencia))
                              var td3 = document.createElement("TD")
                              td3.appendChild(document.createTextNode(response[i].descripcion))
                              var td4 = document.createElement("TD")
                              td4.appendChild(btn)

                              row.appendChild(td1);
                              row.appendChild(td2);
                              row.appendChild(td3);
                              row.appendChild(td4);
                              tbody.appendChild(row);
                          }
                           $('#myModalReferencia').modal('show');
                          
                     }
     });
  }
  function myfunctionconcurso(r)
  {
       var p = r.parentNode.parentNode.rowIndex;
       var id = document.getElementById('tblConcursos').tBodies[0].rows[p-1].cells[0].innerHTML;
       document.getElementById('referencia').value = id;
       $('#myModalConcurso').modal('hide');
  }
    function myfunctionreferencia(r)
  {
       var p = r.parentNode.parentNode.rowIndex;
       var id = document.getElementById('tblReferencias').tBodies[0].rows[p-1].cells[1].innerHTML;
       document.getElementById('refe').value = id;
       $('#myModalReferencia').modal('hide');
  }
</script>