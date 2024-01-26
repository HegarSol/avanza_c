

//Si el atributo checked del checkbox leer = false hace false los demás permisos
function DesLeer(nombre)
{
  var agregar= "agregar"+nombre;
  var editar= "editar"+nombre;
  var borrar= "borrar"+nombre;
  var leer= "leer"+nombre;
  var print= "print"+nombre;
  if(x(leer).checked==false)
  {
    document.getElementById(agregar).checked = false;
    document.getElementById(editar).checked = false;
    document.getElementById(borrar).checked = false;
    document.getElementById(print).checked = false;
  }
}
//Si se selecciona cualquier permiso y el checked del checkbox leer es false esta función lo convierte en true
function SelecLeer(nombre)
{
  var agregar= "agregar"+nombre;
  var editar= "editar"+nombre;
  var borrar= "borrar"+nombre;
  var leer= "leer"+nombre;
  var print= "print"+nombre;
  if(x(agregar).checked==true || x(editar).checked==true || x(borrar).checked==true || x(print).checked==true)
  {document.getElementById(leer).checked = true;}
  else {document.getElementById(leer).checked = false;}
}

//Función que regresa el id del usuario al momento de seleccionar uno como Administrador de un a empresa
function returnIdUsuario()
{
  var oTT = $.fn.dataTable.TableTools.fnGetInstance("users1");
  var aData = oTT.fnGetSelectedData();
  if (aData.length !== 1) { alert("No seleccionó ningún registro");}
  else
  {
    console.log(aData);
    var id= aData[0][0];
    $("#idU").val(aData[0][0]);
    $("#admin").val(aData[0][2]);
  }
}

function date_time(id)
{
   date = new Date;
   year = date.getFullYear();
   month = date.getMonth();
   month ++;
   if(month<10) { month = "0"+month; }
   d = date.getDate(); if(d<10) { d = "0"+d; }
   h = date.getHours(); if(h<10) {  h = "0"+h; }
   m = date.getMinutes(); if(m<10) {  m = "0"+m; }
   s = date.getSeconds(); if(s<10) {  s = "0"+s; }
   result = ''+year+'/'+month+'/'+d+' '+h+':'+m+':'+s;
   document.getElementById(id).value = result;
   setTimeout('date_time("'+id+'");','1000');
   return true;
}


/******Agregar un usuario desde el catálogo de empresas************/
function agregarUsuarioE()
{
  try
   {
    var xyz=false;
    var url1= baseurl+"index.php/usuarios/crearUsuarioAjax";
    var form=$("#formaUsuariosE");
    $.ajax({
      type: "POST",
      url: url1,
      data: {forma:form.serialize()},
      success: function(msg)
      {
        if (msg[0].mensaje== "Insertado Correctamente" || msg[0].mensaje=="Actualizado Correctamente")
        {
           swal("Listo!", msg[0].mensaje, "success");
           x("idU").value=msg[0].id;
           x("admin").value=msg[0].correo;
           x("pass").value=msg[0].pass;
           $('#agregarUsuario').modal('hide');
        }
        else
        { swal("Error", msg[0].errores, "error"); }
     }
    });
 } catch(e) { alert(e); }
}
