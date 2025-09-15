/************METODOS ELIMINAR*****************/
//Eliminar Usuario
 function EliminarUsuario(id)
 {   swal({
   title: "¿Desea eliminar al usuario?",
   text: "No se podrá recuperar la infomación.",
   type: "warning",
   showCancelButton: true,
   confirmButtonColor: "#DD6B55",
   confirmButtonText: "Borrar",
   cancelButtonText: "No, Cancelar",
   closeOnConfirm: false,
   closeOnCancel: false
 },
 function(isConfirm){
   if (isConfirm)
   { location.href=baseurl+"usuarios/eliminar/"+id;  }
   else {
 	    swal("Cancelado", "No se eliminó el usuario.", "error");
   }
 });
};

//Eliminar Usuario
 function EliminarEmpresa(id)
 {   swal({
   title: "¿Desea eliminar la Empresa?",
   text: "No se podrá recuperar la infomación.",
   type: "warning",
   showCancelButton: true,
   confirmButtonColor: "#DD6B55",
   confirmButtonText: "Borrar",
   cancelButtonText: "No, Cancelar",
   closeOnConfirm: false,
   closeOnCancel: false
 },
 function(isConfirm){
   if (isConfirm)
   { location.href=baseurl+"/Empresas/eliminar/"+id;  }
   else {
 	    swal("Cancelado", "No se eliminó la empresa.", "error");
   }
 });
};

//Eliminar Cuenta
 function EliminarCuenta(id)
 {   swal({
   title: "¿Desea eliminar la Cuenta?",
   text: "No se podrá recuperar la infomación.",
   type: "warning",
   showCancelButton: true,
   confirmButtonColor: "#DD6B55",
   confirmButtonText: "Borrar",
   cancelButtonText: "No, Cancelar",
   closeOnConfirm: false,
   closeOnCancel: false
 },
 function(isConfirm){
   if (isConfirm)
   {
   //  location.href=baseurl+"/catalogos/cuentas/eliminar/"+id;  
   jQuery.ajax({
                 type: "POST",
                  url: baseurl+"catalogos/cuentas/eliminar",
                  dataType: 'html',
                  data: {id:id},
                  success:function(response)
                  {
                      response = JSON.parse(response);
                      if(response.status)
                      {
                          swal("Eliminado", "La Cuenta ha sido eliminada.", "success");
                          setTimeout(function(){ location.reload(); }, 2000);
                      }
                      else
                      {
                          swal("Error", response.msg, "error");
                      }
                  }});
    }
   else {
 	    swal("Cancelado", "No se eliminó la Cuenta.", "error");
   }
 });
};

//Eliminar Banco
function EliminarBanco(id)
{
  swal({
    title: "¿Desea eliminar el Banco?",
    text: "No se podrá recuperar la información.",
    type:"warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Borrar",
    cancelButtonText: "No, Cancelar",
    closeOnConfirm: false,
    closeOnCancel: false
  },
  function(isConfirm){
     if(isConfirm)
     {
        jQuery.ajax({
            type:"POST",
            url: baseurl+"catalogos/operaciones/checarpolizas",
            data:{id:id},
            dataType:"html",
            success:function(response)
            {
                response=JSON.parse(response);
                if(response == 1)
                {
                    swal("Error","No se puede eliminar el banco por que ya tiene polizas","error");
                }
                else
                {
                    location.href=baseurl+"/catalogos/bancos/eliminar/"+id;
                }
            }
        });

     }
     else
     {
       swal("Cancelado","No se eliminó el Banco.","error");
     }
  });
}
//Eliminar Beneficiario
function EliminarBenefici(id)
{
   swal({
       title: "¿Desea eliminar el Beneficiario?",
       text: "No se podrá recuperar la información.",
       type: "warning",
       showCancelButton: true,
       confirmButtonColor: "#DD6B55",
       confirmButtonText: "Borrar",
       cancelButtonText: "No, Cancelar",
       closeOnConfirm: false,
       closeOnCancel: false
   },
   function(isConfirm)
   {
      if(isConfirm)
      {
         location.href=baseurl+"/catalogos/beneficiarios/eliminar/"+id;
      }
      else
      {
        swal("Cancelado","No se eliminó el Beneficiario","error");
      }
   
   });
}
//
function EliminarPolizaDiaria(id)
{
   swal({
        title: "¿Desea eliminar la Poliza diaria?",
        text: "No se podrá recuperar la información.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Borrar",
        cancelButtonText: "no, Cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
   },
   function(isConfirm)
   {
      if(isConfirm)
      {
        location.href=baseurl+"/catalogos/Polizasdiarias/eliminar/"+id;
      }
      else
      {
        swal("Cancelado","No se elimino al Poliza diaria","error");
      }
   });
}
//Eliminar Poliza
function EliminarPoliza(id,n_banco,tipo)
{
   swal({
       title: "¿Desea cancelar la Poliza?",
       text: "No se podrá recuperar la información.",
       type: "warning",
       showCancelButton: true,
       confirmButtonColor: "#DD6B55",
       confirmButtonText: "Cancelar",
       cancelButtonText: "No",
       closeOnConfirm: false,
       closeOnCancel: false
   },
   function(isConfirm)
   {
      if(isConfirm)
      {
         location.href=baseurl+"/catalogos/operaciones/eliminar/"+id+'/'+n_banco+'/'+tipo;
      }
      else
      {
         swal("Cancelado","No se cancelado la Poliza","error");
      }

   });
}

