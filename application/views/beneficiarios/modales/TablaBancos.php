<div class="modal fade" id="myModalBancos" role="dialog">
    <div class="modal-dialog modal-lg" id="mdialTamanio">
        <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <!-- <input type="hidden" id="renglon" name="renglon"> -->
                <h1 class="modal-title">Tabla bancos</h1>
             </div>
             <div class="modal-body">
                 <table id="tblbancos" class="stripe row-border responsive nowrap" cellspacing="0" width="90%">
                      <thead>
                        <th>Accion</th>
                        <th>Clave</th>
                        <th>Nombre</th>
                      </thead>
                 </table>
             </div>
        </div>
        <script>
        $(function ()
        {
          $("#tblbancos").dataTable({
            responsive: true, filter:true,
                 processing: true,
                 ajax: { "url": baseurl + "catalogos/Bancos/ajax_bancos", "type": "POST" },
                 "language" : {"url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
           })
         });
         function returnIdBanco(clabe,nombre)
         {
             document.getElementById('clavebanco').value = clabe;
             document.getElementById('nombrebanco').value = nombre;
         }
        </script>
    </div>
</div>