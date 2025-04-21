/*Funciones relacionadas con los datatables que se encuentran en
todos los catálogos */
/******************DATATABLES!************/
//DTUSUARIOS

$(function () {
  $("#users").DataTable({
    responsive: true, filter:true, columnDefs:
    [ { responsivePriority: 1, targets: 0 }, { responsivePriority: 2, targets: -1 }, { responsivePriority: 3, targets: 2 } ],
         processing: true, serverSide: true,
         ajax: { "url": baseurl+"Usuarios/dataTable", "type": "POST" },  "language": { "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" }
   })
 });
//DT USUARIOS (Se utiliza para mostrar los usuarios sin opciones de modificar, solamente para visualizar y seleccionar)
 $(function () {
   $("#users1").DataTable({
     responsive: true, filter:true, columnDefs:
     [ { responsivePriority: 1, targets: 0 }, { responsivePriority: 2, targets: -1 }, { responsivePriority: 3, targets: 2 } ],
          processing: true, serverSide: true,
          ajax: { "url": baseurl+"Usuarios/dataTableEmpresas", "type": "POST" }
          ,"sDom": 'T<"clear">lfrtip', "oTableTools": {  "sRowSelect": "single","aButtons": ""},  "language": { "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" }
    })
  });

 //DTEMPRESAS
 $(function () {
   $("#empresas").DataTable({
     responsive: true, filter:true, columnDefs:
     [ { responsivePriority: 1, targets: 0 }, { responsivePriority: 2, targets: -1 }, { responsivePriority: 3, targets: 2 } ],
          processing: true, serverSide: true,
          ajax: { "url": baseurl + "Empresas/dataTable", "type": "POST" },  "language": { "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" }
    })
  });
//CUENTAS
$(function () {
  $("#cuentas").DataTable({
    responsive: true, filter:true, columnDefs:
    [ { responsivePriority: 1, targets: 0 }, { responsivePriority: 2, targets: -1 }, { responsivePriority: 3, targets: 2 },{ targets: [0], visible: false } ],
         processing: true, serverSide: true,
         ajax: { "url": baseurl + "catalogos/Cuentas/ajax_list", "type": "POST" },  "language": { "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" }
   })
 });
//CONFIG CUENTAS
 $(function () {
   $('#configcuentas').DataTable({
      responsive: true, filter:true, columnDefs:
       [ { responsivePriority: 1, targets: 0 }, { responsivePriority: 2, targets: -1 }, { responsivePriority: 3, targets: 2 } ],
        processing: true, 
        ajax: { "url": baseurl + "Configuracion/ajax_list", "type": "POST" },  "language" : {"url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
    })
 });

 //BANCOS
 $(function (){
   $('#Bancos').DataTable({
    responsive: true, filter:true, columnDefs:
     [ { responsivePriority: 1, targets: 0 }, { responsivePriority: 2, targets: -1 }, { responsivePriority: 3, targets: 2 } ],
       processing: true, serverSide: true,
       ajax: { "url": baseurl + "catalogos/Bancos/ajax_list","type": "POST" },"language" : {"url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
   }) 
 });

// ASIENTO CONTABLE
 $(function(){
    $('#polizas').dataTable({
      responsive: true, filter:true, columnDefs:
      [ { responsivePriority: 1, targets: 0}, { responsivePriority: 2, targets: -1}, { responsivePriority: 3, targets: 2 } ],
      processing: true, serverSide: true,
      ajax: { "url":baseurl + "catalogos/Polizasdiarias/ajax_list", "type": "POST"},  "language" : {"url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
    })
 });

 //BENEFICIARIOS
 $(function(){
    $('#Beneficiarios').DataTable({
      responsive: true, filter:true, columnDefs:
      [ { responsivePriority: 1, targets: 0 }, { responsivePriority: 2, targets: -1 }, { responsivePriority: 3, targets: 2 } ],
      processing: true, serverSide: true,
      ajax: {"url": baseurl + "catalogos/Beneficiarios/ajax_list","type":"POST"}, "language" : {"url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
      ,"sDom": 'T<"clear">lfrtip', "oTableTools": {  "sRowSelect": "single","aButtons": ""},
    })
 });

  //DEPARTAMENTO DE COSTOS
  $(function(){
    $('#departamentocostos').DataTable({
      responsive: true, filter:true, columnDefs:
      [ { responsivePriority: 1, targets: 0 }, { responsivePriority: 2, targets: -1 }, { responsivePriority: 3, targets: 2 } ],
      processing: true, serverSide: true,
      ajax: {"url": baseurl + "catalogos/DeptosCostos/ajax_list","type":"POST"}, "language" : {"url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
      ,"sDom": 'T<"clear">lfrtip', "oTableTools": {  "sRowSelect": "single","aButtons": ""},
    })
 });





