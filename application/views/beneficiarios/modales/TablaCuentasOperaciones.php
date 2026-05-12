<div class="modal fade" id="myModalCuentasOperaciones" role="dialog" >
<div class="modal-dialog modal-lg" id="mdialTamanio">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <input type="hidden" id="renglon" name="renglon">
            <h1 class="modal-title">Busqueda Cuentas</h1>
        </div>
        <div class="modal-body" >
          <table id="tblCuentas23" class="stripe row-border responsive nowrap" cellspacing="0" width="90%">
              <thead>
                <th>Accion</th>
                <!-- <th>Id</th> -->
                <th>Cuenta</th>
                <th>Sub Cuenta</th>
                <th>Ssub cuenta</th>
                <th>Nombre</th>
              </thead>
          </table>
            <!-- <button class="btn btn-success" onclick="returnIdCliente()" data-dismiss="modal" aria-hidden="true" ><span class="glyphicon glyphicon-ok"></span> Seleccionar</button> -->
        </div>
    </div>
    <script>

      var table3;

    $(function ()
    {
      table3 = $("#tblCuentas23").DataTable({
        responsive: true, filter:true,
        columnDefs:
        [ { responsivePriority: 1, targets: 1, name:'cuenta' }, { responsivePriority: 2, targets: -1 }, { responsivePriority: 3, targets: 2 },{ targets: [0], visible: true } ],
             processing: true, serverSide: true,
             ajax: { "url": baseurl + "catalogos/Cuentas/ajax_cuentaselejiroperaciones", "type": "POST" },
             "language" : {"url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
       })
     });
     function abrirModalCuentasOperaciones(tipo)
{
    if (tipo == 1) {
    $('#myModalCuentasOperaciones').modal('show');
     $('#tipo').val(tipo);
    } else if (tipo == 2) {
         $('#tipo').val(tipo);
       let id = document.getElementById('cuenta').value;
       console.log(id);
          table3.column(1).search(id).draw();
        $('#myModalCuentasOperaciones').modal('show');
    }
    
       

}

    </script>
</div></div>