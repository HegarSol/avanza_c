<div class="modal fade" id="myModalCliente" role="dialog" >
<div class="modal-dialog modal-lg" id="mdialTamanio">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h1 class="modal-title">Busqueda Clientes</h1>
        </div>
        <div class="modal-body" >
          <table id="tblClientes" class="stripe row-border responsive nowrap" cellspacing="0" width="90%">
              <thead style="background-color:#3C7A78; color:white;">
                <th>Accion</th>
                <th>Id</th>
                <th>Clave</th>
                <th>Nombre</th>
                <th>RFC</th>
                <th>Dirección</th>
                <th>Correo Electrónico</th>
                <th>Teléfono</th>
              </thead>
          </table>
            <!-- <button class="btn btn-success" onclick="returnIdCliente()" data-dismiss="modal" aria-hidden="true" ><span class="glyphicon glyphicon-ok"></span> Seleccionar</button> -->
        </div>
    </div>
    <script>
    $(function ()
    {
      $("#tblClientes").dataTable({
        responsive: true, filter:true,
             processing: true, 
              ajax: { "url": baseurl + "catalogos/Beneficiarios/ajax_clientes", "type": "POST" },
             "language" : {"url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
               ,"sDom": 'T<"clear">lfrtip', "oTableTools": {  "sRowSelect": "single","aButtons": ""}
       })
     });

        function returnIdCliente(nombre,clave,rfc,idcliente)
        {
               $("#clave").val(clave);
               $('#nombre_cliente_pago').val(nombre);
               $('#rfc_pago').val(rfc);
               $("#id_cliente_pago").val(idcliente);
               $("#clave").focus();
        }
    </script>
</div></div>