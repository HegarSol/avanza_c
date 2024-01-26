/**
 * Clase para el manejo de los complementos de pago
 */

function ComplementoPago(){
  var _id_complemento_pago = 0;

  this.Nuevo = function(serie){
    window.location.href = "complementoPagos/nuevo/" + serie;
  }

  this.Edita = function (id_complemento) {
    window.location.href = "complementoPagos/edita/" + id_complemento;
  }

  this.CrearSustitucion = function (id_complemento) {
    window.location.href = "complementoPagos/creaSustitucion/" + id_complemento;
  }

  this.SustitucionPeso =function(id_complemento){
    window.location.href = "complementoPagos/sustitucionPeso/" + id_complemento;
  }

  this.Timbrar = function (id_complemento,serie) {
    $.ajax({
      url: baseurl+"facturas/TimbrarFactura",
      type: 'POST',
      dataType: 'json',
      data: {id:id_complemento, serie:serie},
      success: function (response){
        if(response=="Se timbró exitosamente la factura.")
        {
          swal('Correcto','se ha timbrado Correctamente la factura', 'success');
          table.draw();
        }
        else{
          swal("Error", response, "error");
        }
      }
    });
  }

  this.Imprimir = function (id_complemento,serie) {
    window.open(baseurl+"pdfs/ArrendamientoDefault/"+id_complemento+"/"+serie+"/Imprimir");
  }

  this.Imprimirticket = function (id_complemento,serie){
    window.open(baseurl+"pdfs/Tickets/"+id_complemento+"/"+serie+"/Imprimir");
  }

  this.Elimina = function (id_complemento) {
    _id_complemento_pago = id_complemento;
    swal({
      title : 'Deseas Eliminar el complemento de Pago?',
      text : 'No se podra recuperar la informacion',
      type : 'warning',
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Borrar",
      cancelButtonText: "No, Cancelar",
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm){
      if(isConfirm){
        _elimina_complemento()
      }
    })
  }

  this.visualizarXML= function (uuid) {
    window.open(baseurl+"welcome/xml/"+uuid, '_blank');
  }

  function _elimina_complemento(){
    $.ajax({
      url : "complementoPagos/elimina",
      type : 'POST',
      dataType : 'json',
      data : { id_complemento : _id_complemento_pago},
      success : function (response){
        if(response.success){
          location.reload(true);
        } else {
          swal('Error', response.error, 'error');
        }
      },
      error : function () {
        swal('Error', 'Ocurrion un error interno al tratar de eliminar el complemento', 'error');
      }
    });
  }
}

function get_selected_row(table_id, callback){
  var oTT = $.fn.dataTable.TableTools.fnGetInstance(table_id);
  var aData = oTT.fnGetSelectedData();
  if (aData.length == 0){
    callback(false, "No se ha seleccionado un registro de la tabla");
  }
  if(aData.length > 1) {
    callback(false, "Solo se puede seleccionar un registro de la tabla");
  }
  callback(true, aData);
 }
