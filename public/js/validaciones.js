function ExisteClave()
{
  var clave=$("#clave").val();
  if(clave!=$("#claveA").val())
{  jQuery.ajax({
      type: "POST",
      url: baseurl+"index.php/catalogos/Clientes/ExisteClave/"+clave,
      dataType:'json',
      success:function(response)
      {
        if(response ==1){
            x("clave").value = "";
            x("clave").focus();
            var n = noty({ layout:'center',type: 'warning',  theme: 'relax',text: 'Ya existe un cliente con la misma clave. Inténte con una nueva'});
  }}});}}
  var x = function(id) { return document.getElementById(id);}

    function ValidarConfiguracion()
    {
      try{
      var xyz = false;        var form=$("#inputForm");
      var SMTPAuth=0;
      if (x("rfc").value == "")       {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Verifique RFC.'}); xyz=true;}
      if (x("iva").value == "")       {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Asigne valor de I.V.A.'}); xyz=true;}
      if (x("ieps").value == "")      {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Asigne valor I.E.P.S.'}); xyz=true;}
      if (x("retIeps").value == "")   {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Asigne valor de Retención I.E.P.S.'}); xyz=true;}
      if (x("retIsr").value == "")    {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Asigne Retención de I.S.R.'}); xyz=true;}
      if (x("isr").value == "")       {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Asigne valor de I.S.R.'}); xyz=true;}
      if (x("retiva").value == "")    {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Agregue Retención de I.V.A.'}); xyz=true;}
      if($("#SMTPAuth").is(':checked')) {SMTPAuth=1; } else {SMTPAuth=0;}
      if (xyz==false){ $.ajax({
          type: "POST",
          url: "Configuracion0.php",
          data: {forma:form.serialize(),SMTPAuth:SMTPAuth},
          success: function(msg){
              if (msg) { alert("Se configuró correctamente"); window.location.href='Principal.php'; }
              else {alert(msg);}
          }
        });}} catch(err) {alert(err);}
    }
  function ValidaSerie()
  {
   try{
     var xyz= false;
       var consecutivo ="";    var regimen = ""; var tipo= "";
       var form=$("#inputForm");
       if (x("consecutivo").value == "")   {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Complete el campo consecutivo.'}); xyz=true;}
       if (x("regimenFiscal").value == "") {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Complete el campo Regimen Fiscal.'}); xyz=true;}
       if (x("tipo").value == " ")         {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Seleccione un Tipo.'}); xyz=true;}
       if (xyz==false)
       { $.ajax({
                type: "POST",
                url: "../../php/valida.php",
                data: {forma:form.serialize()},
                success: function(msg){
                if (msg == "Insertado Correctamente" || msg=="Actualizado Correctamente")
                {
                  window.alert(msg)
                  window.location.href='Series.php';
                }
                else {alert(msg);}
                    }});}} catch(err) {alert(err);}
    }
    function ValidaDestino()
    {
     try{
          var desNum ="";    var rfc = ""; var des= ""; var xyz=false;
          var form=$("#inputForm");
          if (x("rfc").value == "")   {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Complete el campo RFC.'}); xyz=true;}
          if (x("des").value == "")   {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Complete el campo Destino.'}); xyz=true;}
          if (x("desNum").value == ""){var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Complete el campo Número de Destino.'}); xyz=true;}
          if (xyz==false)
          {  $.ajax({
              type: "POST",
              url: "../../php/valida.php",
              data: { forma:form.serialize()},
              success: function(msg){
                  if (msg == "Insertado Correctamente" || msg=="Actualizado Correctamente")
                  {
                    window.alert(msg)
                    window.location.href='Destinos.php';
                  } else {alert(msg);} }});
          }
        } catch(err) {alert(err);}
      }

      function ValidaOrigen()
      {
       try{
         var xyz=false;
            var remOr ="";    var rfc = ""; var or= "";
            var form=$("#inputForm");
            if (x("remOr").value == "") {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Complete el campo Remitente.'}); xyz=true;}
            if (x("rfc").value == "")   {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Complete el campo RFC.'}); xyz=true;}
            if (x("or").value == "")    {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Complete el campo Origen.'}); xyz=true;}
        if (xyz==false){  $.ajax({
            type: "POST",
            url: "../../php/valida.php",
            data: { forma:form.serialize()},
            success: function(msg){
                if (msg == "Insertado Correctamente" || msg=="Actualizado Correctamente")
                {
                  window.alert(msg)
                  window.location.href='Origen.php';
                } else {alert(msg);}}});}
          } catch(err) {alert(err);}
      }

  function ValidaProducto()
  {
   try{
     var xyz=false;
        var iva=0;     var ieps=0;  var form=$("#inputForm");
        if($("#aplicaIva").is(':checked')) { iva =1; } else {iva=0;}
        if($("#aplicaIeps").is(':checked')){ ieps=1; } else {ieps=0;}
        if (x("unidadMedida").value == "")     {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Ingrese una Unidad de Medida.'}); xyz=true;}
        if (x("descripcion").value == "")      {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Agregue una Descripción.'}); xyz=true;}
        if (x("precioUnitario").value == "")   {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Asigne precio del producto.'}); xyz=true;}
        if (xyz==false){  $.ajax({
            type: "POST",
            url: "../../php/valida.php",
            data: { forma:form.serialize(), aIva:iva, aIeps:ieps},
            success: function(msg){
                if (msg == "Insertado Correctamente" || msg=="Actualizado Correctamente")
                {
                  window.alert(msg)
                  window.location.href='Productos.php';
                } else {alert(msg);}}});}
          } catch(err) {alert(err);}
}

function ValidaCliente()
{
 try{
      var xyz=false;
      var retISR="";         var retIva="";
      var activo="";         var form=$("#inputForm");
      if($("#activo").is(':checked'))   { activo=1; } else { activo=0; }
      if($("#retIva").is(':checked'))   { retIva=1; } else { retIva=0; }
      if($("#retISR").is(':checked'))   { retISR=1; } else { retISR=0; }
      if (x("rfc").value == "")         {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Verifique RFC.'}); xyz=true;}
      if (x("usoCFDi").value == "")     {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'El campo Uso del CFDi es requerido.'}); xyz=true;}
      if (x("clave").value == "")       {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Complete el campo clave.'}); xyz=true;}
      if (x("correoE").value == "")     {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Asigne un correo'}); xyz=true;}
      if (xyz==false)
      {  $.ajax({
          type: "POST",
          url: "../../php/valida.php",
          data: { forma:form.serialize(), retIva:retIva, retISR:retISR,activo:activo},
          success: function(msg){
              if (msg == "Insertado Correctamente" || msg=="Actualizado Correctamente")
              {
                swal("Listo!", msg, "success");
                var myVar = setInterval(ble, 1000);
                function ble(){window.location.href='Clientes.php';}
              } else {swal("Error", msg, "error");}}});
      }
    } catch(err) {alert(err);}
 }
 function ValidaDestinatario()
 {
  try{
      var xyz = false;
       var form=$("#destinatario");
       if (x("cp").value == "")    {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Verifique campo CP.'}); xyz=true;}
       if (x("calle").value == "") {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Verifique campo Calle.'}); xyz=true;}
       if (x("estado").value == ""){var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Verifique campo Estado.'}); xyz=true;}
       if (x("pais").value == "00"){var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Verifique País.'}); xyz=true;}
       if (xyz==false)
       {$.ajax({
           type: "POST",
           url: "../../php/valida.php",
           data: { forma:form.serialize()},
           success: function(msg){
               if (msg == "Insertado Correctamente" || msg=="Actualizado Correctamente")
               {
                 window.alert(msg)
                 window.location.href='Destinatario.php';
               } else {alert(msg);}}});
        }
    } catch(err) {alert(err);}
  }
 function ValidaEmpresa()
 {
  try{var xyz=false;
      var form=$("#inputForm");
      var empresa1=1;
       if(x("host").value=="")      {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Es necesario que asigne una dirección de host.'}); xyz=true;}
       if(x("pais").value=="")      {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Complete el campo País.'}); xyz=true;}
       if(x("calle").value=="")     {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Complete el campo Calle.'}); xyz=true;}
       if(x("estado").value=="")    {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Complete el campo Estado.'}); xyz=true;}
       if(x("usuario").value=="")   {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Se requiere el campo Usuario.'}); xyz=true;}
       if(x("municipio").value=="") {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Complete el campo Municipio.'}); xyz=true;}
       if(x("contrasena").value==""){var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Es necesario que especifique la contraseña.'}); xyz=true;}
       if(x("database").value=="")  {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Agregue el nombre de la base de datos.'}); xyz=true;}
       if (xyz==false){  $.ajax({
           type: "POST",
           url: "../../php/valida.php",
           data: { forma:form.serialize(),empresa:empresa1},
           success: function(msg){
               if (msg == "Insertado Correctamente" || msg=="Actualizado Correctamente")
               {
                   document.getElementById("loader2").style.display = "block";
                 window.alert(msg)
                 window.location.href='Empresas.php';
               } else {document.getElementById("loader2").style.display = "none"; alert(msg);}}});}
         }
      catch(err) {alert(err);}
  }

  function ValidaUsuarios()
  {
   try{
          var xyz=false;
        var email=x("usuario").value; var coinciden="";    var form=$("#inputForm");
        if(x("tipo").value==" ")      {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Seleccione tipo de Usuario.'}); xyz=true;}
        if(x("empresa").value==" ")   {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Seleccione una Empresa.'}); xyz=true;}
        if (x("nombreU").value == "") {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Teclee el nombre de Usuario.'}); xyz=true;}
        if (x("usuario").value == "") {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Es necesario que asigne un correo al usuario.'}); xyz=true;}
        if (x("password").value == ""){var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Ingrese una contraseña.'}); xyz=true;}
        if(x("password").value!= x("password2").value) {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Las Contraseñas no coinciden.'}); xyz=true;}
        if (xyz==false){  $.ajax({
            type: "POST",
            url: "../../php/valida.php",
            data: { forma:form.serialize()},
            success: function(msg){
                if (msg == "Insertado Correctamente" || msg=="Actualizado Correctamente")
                {
                  window.alert(msg)
                  window.location.href='Usuarios.php';
                } else {alert(msg);}}});}
          } catch(err) {alert(err);}
}

function ComprobarConexion()
{
 try{
      var xyz=false;
      var email=x("usuario").value; var coinciden="";    var form=$("#inputForm");
      if(x("host").value=="")      {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Es necesario que asigne un host.'}); xyz=true;}
      if(x("usuario").value=="")   {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Incluya un usuario.'}); xyz=true;}
      if (x("contrasena").value == "") {var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Teclee la contraseña.'}); xyz=true;}
      if (xyz==false){
        document.getElementById("loader2").style.display = "block";
         $.ajax({
          type: "POST",
          url: "../../php/valida.php",
          data: { forma:form.serialize(),comprueba:1},
          success: function(msg){document.getElementById("loader2").style.display = "none";alert(msg);}});}
        } catch(err) {alert(err);}
}
//VALIDANDO PATRONES DE CAMPOS
function ValidaRFC(nombre)
{
  var m = document.getElementById(nombre).value;
  var expreg = /^[A-Z]{3,4}[0-9]{2}[0-1][0-9][0-3][0-9]([A-Z]|[0-9])([A-Z]|[0-9])([A-Z]|[0-9])?$/;
  if(m != "")
  {
    if(expreg.test(m)){}
    else
    {
     x(nombre).value = "";
     var n = noty({ layout:'center',type: 'warning',  theme: 'relax',text: 'El RFC no tiene el formato correcto.'});
    }
 }
}

function ValidaSerie()
{
  var m = document.getElementById("nombreSerie").value;
  var expreg = /^([A-Z]|[a-z]|[0-9]| |Ñ|ñ|!|&quot;|%|&amp;|&apos;| ́|-|:|;|&gt;|=|&lt;|@|_|,|\{|\}|`|~|á|é|í|ó|ú|Á|É|Í|Ó|Ú|ü|Ü){1,25}?$/;
  if(m != "")
  {
    if(expreg.test(m)){}
    else
    {
      $("#nombreSerie").focus();
     x("nombreSerie").value = "";
     var n = noty({ layout:'center',type: 'warning',  theme: 'relax',text: 'La SERIE no tiene el formato correcto.'});
    }
 }
}

function ValidaCondicionesPago()
{
  var m = document.getElementById("nombreSerie").value;
  var expreg = /^([A-Z]|[a-z]|[0-9]|Ñ|ñ|!|&quot;|%|&amp;|&apos;| ́|-|:|;|&gt;|=|&lt;|@|_|,|\{|\}|`|~|á|é|í|ó|ú|Á|É|Í|Ó|Ú|ü|Ü){1,1000}?$/;
  if(m != "")
  {
    if(expreg.test(m)){}
    else
    {
      $("#nombreSerie").focus();
     x("nombreSerie").value = "";
     var n = noty({ layout:'center',type: 'warning',  theme: 'relax',text: 'La SERIE no tiene el formato correcto.'});
    }
 }
}

function ValidaNRIT(nombre)
{
  var m = document.getElementById(nombre).value;
  if(m != "")
  {
    if(m.length < 6 )
    {
      x(nombre).value = "";
    	var n = noty({ layout:'center',type: 'warning',  theme: 'relax',text: 'El Núm. de Identificación o Registro Fiscal debe contener al menos 6 caracteres.'});
    }
  }
}

function ValidaNCO(nombre)
{
  var m = document.getElementById(nombre).value;
  if(m != "")
  {
    if(m.length < 6 )
    {
      x(nombre).value = "";
    	var n = noty({ layout:'center',type: 'warning',  theme: 'relax',text: 'El Núm. de Certificado de Origen debe contener al menos 6 caracteres.'});
    }
  }
}
function ValidaCURP(nombre)
{
  var m = document.getElementById(nombre).value;
  var expreg = /^[A-Z][AEIOUX][A-Z]{2}[0-9]{2}[0-1][0-9][0-3][0-9][MH]([ABCMTZ]S|[BCJMOT]C|[CNPST]L|[GNQ]T|[GQS]R|C[MH]|[MY]N|[DH]G|NE|VZ|DF|SP)([B-D]|[F-H]|[J-N]|[P-T]|[V-Z]){3}([A-Z]|[0-9]){2}?$/;
  if(m != "")
  {
    if(expreg.test(m)){}
    else
    {
     x(nombre).value = "";
     var n = noty({ layout:'center',type: 'warning',  theme: 'relax',text: 'El CURP no tiene el formato correcto.'});
    }
  }
}
