function InicicializaDataTable(){
  $('#tblInfOrdenTrabajo').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": "/Cobranza/php/TablaOrdenTrabajo.php",
      "columns": [
          {"data": "idOrden"},
          {"data": "idCompania"},
          {"data": "Compania"},
          {"data": "movimientoSolicitado"},
          {"data": "idCliente"},
          {"data": "Cliente"},
          {"data": "fecha"}
      ],
      "language": {
          "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
      },
      "sDom": 'T<"clear">lfrtip',
      "oTableTools": {
          "sRowSelect": "single",
          "aButtons": ""
      },
      "order":{
        "column":"6",
        "dir":"desc"
    }
  });
}

function InicializaComponentesEdicion(){
  $("#inputVigenciaInicio").datetimepicker({
      lang: 'es',
      timepicker: false,
      format: 'Y-m-d'
  });

  $("#inputVigenciaFin").datetimepicker({
      lang: 'es',
      timepicker: false,
      format: 'Y-m-d'
  });

  $("#inputFecha").datetimepicker({
      lang: 'es',
      timepicker: false,
      format: 'Y-m-d'
  });
}

function GuardaOrdenTrabajo(){
  var postData = $("#inputForm").serialize();
  $.ajax({
      type: 'POST',
      url: '/Cobranza/php/GuardaOrdenTrabajo.php',
      data: postData,
      cache: false,
      dataType: 'json',
      beforeSend: function () {
          $("#progress").show();
      },
      success: function (data) {
          $("#progress").hide();
          if (data.correcto) {
              muestraMensaje(data.mensaje, "success");
          } else {
              muestraMensaje("<span style='color:#cc0000'>Error:</span> " + data.mensaje, "warning");
          }
      },
      error: function () {
          $("#progress").hide();
          muestraMensaje("<span style='color:#cc0000'>Error Interno en el servidor, vuelva a intentarlo</span> ", "error");
      }
  });
}

function BuscarCliente(evt){
  evt.preventDefault();
  MuestraModal.mostrar("/Cobranza/php/BuscaCliente.php");
}

function GetDatosOrdenDeTrabajo(){
  $.ajax({
      type: 'POST',
      url: "/Cobranza/php/Funciones.php",
      data: "function=getOrdenById&idOrden=" + $("#inputIdOrden").val(),
      cache: false,
      dataType: 'json',
      success: function (data) {
          $("#selCompania").val(data.idCompania);
          $("#inputMovimientoSolicitado").val(data.movimientoSolicitado);
          $("#inputIdOrden").val(data.idOrden);
          $("#inputEjecutivo").val(data.ejecutivo);
          $("#inputRamo").val(data.ramo);
          $("#inputFecha").val(data.fecha);
          $("#inputAgente").val(data.agente);
          $("#inputClave").val(data.clave);
          $("#inputFormaPago").val(data.formaPago);
          $("#inputMoneda").val(data.moneda);
          $("#inputVigenciaInicio").val(data.vigenciaInicio);
          $("#inputVigenciaFin").val(data.vigenciaFin);
          $("#inputIdCliente").val(data.idCliente);
          DatosClienteText();
          $("#inputMarca").val(data.marca);
          $("#inputModelo").val(data.modelo);
          $("#inputAmis").val(data.amis);
          $("#inputPlacas").val(data.placas);
          $("#inputNoSerie").val(data.noSerie);
          $("#inputNoMotor").val(data.noMotor);
          $("#inputColor").val(data.color);
          $("#inputConductor").val(data.conductor);
          $("#inputEdad").val(data.edad);
          $("#inputEdoCivilConductor").val(data.edoCivilConductor);
          $("#inputUbicacion").val(data.ubicacion);
          $("#inputTipoCarga").val(data.tipoCarga);
          $("#inputDescripcionCarga").val(data.descripcionCarga);
          $("#selPaquete").val(data.paquete);
          $("#inputObservaciones").val(data.observaciones);
          TablaSelPaqueteSumaAsegurada();
      },
      error: function (error) {
          muestraMensaje("<span style='color:#cc0000'>Error Interno en el servidor, vuelva a intentarlo: </span>" + error.status + ": " + error.responseText, "error");
      }
  });
}

function SeleccionaPaquete(){
  $("#tblOrdenTrabajoDetalle").find("tr:gt(0)").remove();
  $.ajax({
      type: 'POST',
      url: "/Cobranza/php/Funciones.php",
      data: "function=getDetallePaquete&idPaquete=" + $("#selPaquete").val() + "&tipoPoliza=AUTOMOVIL",
      cache: false,
      dataType: 'json',
      success: function (data) {
          for (var i = 0; i < data.length; i++) {
              var table = document.getElementById("tblOrdenTrabajoDetalle");
              var rowCount = table.rows.length;
              var row = table.insertRow(rowCount);
              var cell1 = row.insertCell(0);
              var cell2 = row.insertCell(1);
              var cell3 = row.insertCell(2);
              cell1.innerHTML = '<input type="text" name="cobertura[]" id="txtCobertura" readonly class="form-control input-sm" value="' + data[i] + '">';//data[i];
              cell2.innerHTML = '<input type="text" name="sumaAsegurada[]" id="txtSumaAsegurada" class="form-control input-sm">';
              cell3.innerHTML = '<input type="text" name="deducible[]" id="txtDeducible" class="form-control input-sm">';
          }
      },
      error: function () {
          muestraMensaje("<span style='color:#cc0000'>Error Interno en el servidor, vuelva a intentarlo</span> ", "error");
      }
  });
}
