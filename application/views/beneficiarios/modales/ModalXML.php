<div class="modal fade" id="myModalxml" role="dialog" >
<div class="modal-dialog modal-lg" id="mdialTamanio">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Complemento de claves</h1>
        </div>
            <div class="modal-body" >
               <div id="div1">
               <table cellspacing="0" width="100%" class="table table-bordered table-hover" id="table">
               
                  <thead style="background-color:#222222; color:white;">
                     <th>Acción</th>
                     <th>Cuenta</th>
                     <th>Sub cuenta</th>
                     <th>Ssub cuenta</th>
                     <th>Nombre cuenta</th>
                     <th>Clave</th>
                     <th>Descripción SAT</th>
                     <th>Descripción XML</th>
                  </thead>
                 
                  <tbody>
                  </tbody>
                  
               </table>
               </div>
               <font size="10"><span id="estadocol" name="estadocol" ></span></font>
            </div>
        <div class="modal-footer">
       <div class="col-md-1"></div>
       <div class="col-md-3"></div>
       <div class="col-md-3"></div>
       <div class="col-md-1">

 
           <div style="<?php echo $_SESSION['referenciamarca'] == 1 ? '' : 'display:none' ?>" >
            <label for="">Referencia</label> <a class="glyphicon glyphicon-search" onclick="nomas()"></a>
           <input type="text" class="form-control" readonly id="referencia" name="referencia">
          </div>
           
       </div>
        <div class="col-md-2">
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
        <div class="col-md-1">
           <button type="button" class="btn btn-success" onclick="recorrercuentas()" >Aceptar</button>
        </div>
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

</div></div>

<script>
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
  function myfunctionconcurso(r)
  {
       var p = r.parentNode.parentNode.rowIndex;
       var id = document.getElementById('tblConcursos').tBodies[0].rows[p-1].cells[0].innerHTML;
       document.getElementById('referencia').value = id;
       $('#myModalConcurso').modal('hide');
  }
</script>