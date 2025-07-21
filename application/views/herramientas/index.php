<?php
if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
?>

<br>

<div class="container">
   <div class="row">
         <form enctype="multipart/form-data" action="#" id="formularioComprobante">
		      <div class="col-md-6">	
                <div class="form-group">
				  <label for="xml">Archivo Excel</label>
				  <input id="xml" class="form-control" type="file" name="excel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
				  <p class="help-block">Seleccione el archivo Excel a almacenar</p>
			     </div>
              </div>
              <div class="col-md-4">
                <br>
                  <button type="button" onclick="almacenarexcel()" class="btn btn-success">Aceptar</button>
              </div>
         </form>
   </div>
</div>

<div class ="modal fade" id ="ventanaspinptu" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class ="modal-dialog ">
      <div class ="modal-content">
          <div class ="modal-header" style="background-color:#222222; color:white;">
             <h4 class ="modal-title">Importando información</h4>
          </div>
        <div class ="modal-body">
            <center><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></center>
            <br>
            <br>
            <center><h2>POR FAVOR ESPERE.....</h2></center>
        </div>
      </div>
    </div>
</div>


<script>
    function almacenarexcel()
    {

      $('#ventanaspinptu').modal('show');

        var formElement = document.getElementById("formularioComprobante");
	    var formData = new FormData(formElement);
        $.ajax({
		 url : baseurl+"Herramientas/upload",
		 type : "POST",
		 data : formData,
		 processData : false,
		 contentType : false,
		 success : function (data){
            data = JSON.parse(data);
            if(data.status == false)
            {
              $('#ventanaspinptu').modal('hide');
                var n = noty({
                     text : data.data,
                     theme : 'relax',
                     type : 'error'
                  }).show();
            }
            else
            {
              $('#ventanaspinptu').modal('hide');
              var n = noty({
                     text : data.data,
                     theme : 'relax',
                     type : 'success'
                  }).show();
    		    }
	       }
       })
  }
</script>