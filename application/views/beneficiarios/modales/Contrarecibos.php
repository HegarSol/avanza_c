<div class="modal fade" id="myModalContrarecibos" role="dialog">
    <div class="modal-dialog" >
      <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="cerrarclick2" name="cerrarclick2" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h1 class="modal-title">Contra recibos</h1>
            </div>
            <div class="modal-body">
                <input type="hidden" id="contrarecibospor">
                <button type="button" class="btn btn-primary" onclick="buscarprocecontra()">Aceptar</button>
                <br> <br>
                <div id="contrarecibospendi"></div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<style>
#mdialTamanio{
      width: 50% !important;
}
</style>
<script>
  function buscarprocecontra()
  {
        var dat = document.getElementById('contrarecibospor').value;
    jQuery.ajax({
        url: baseurl+"Contrarecibos/obtenercontrare",
        type:"POST",
        data:{data:dat},
        dataType:"html",
        success:function(data)
        {
            $('#contrarecibospendi').html(data);
            $('#tblcontraRecibos').DataTable({
                language: { "url" : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
                "sDom": 'T<"clear">lfrtip', "oTableTools": {  "sRowSelect": "single","aButtons": ""},
                "columnDefs" : [
                    {
                        "targets" : [-1],
                        "orderable" : false
                    }
                ]
            });
        }
    });

  }
</script>