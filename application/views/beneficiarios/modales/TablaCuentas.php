<div class="modal fade" id="myModalCuentas" role="dialog" >
<div class="modal-dialog modal-lg" id="mdialTamanio">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <input type="hidden" id="renglon" name="renglon">
            <h1 class="modal-title">Busqueda Cuentas</h1>
        </div>
        <div class="modal-body" >
          <table id="tblCuentas2" class="stripe row-border responsive nowrap" cellspacing="0" width="90%">
              <thead>
                <th>Accion</th>
                <!-- <th>Id</th> -->
                <th>Cuenta</th>
                <th>Sub Cuenta</th>
                <th>Nombre</th>
                <th>Ssub cuenta</th>
              </thead>
          </table>
            <!-- <button class="btn btn-success" onclick="returnIdCliente()" data-dismiss="modal" aria-hidden="true" ><span class="glyphicon glyphicon-ok"></span> Seleccionar</button> -->
        </div>
    </div>
    <script>
    $(function ()
    {
      $("#tblCuentas2").dataTable({
        responsive: true, filter:true,
             processing: true, serverSide: true,
             ajax: { "url": baseurl + "catalogos/Cuentas/ajax_cuentaselejir", "type": "POST" },
             "language" : {"url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
       })
     });

    </script>
</div></div>