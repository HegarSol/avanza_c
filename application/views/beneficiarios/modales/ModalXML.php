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
                     <!-- <th>Descripción XML</th> -->
                  </thead>
                 
                  <tbody>
                  </tbody>
                  
               </table>
               </div>
               <font size="10"><span id="estadocol" name="estadocol" ></span></font>

            </div>
        <div class="modal-footer">
           <button type="button" class="btn btn-success" onclick="recorrercuentas()" >Aceptar</button>
        </div>
    </div>
</div>
</div>