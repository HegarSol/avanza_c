<div class="modal fade" id="modalConfig" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-blue" style="background-color:#222222; color:white;">
          <button type="button" class="close" onClick="ClearData()" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Listado Usuarios</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal">
            <!-- parametros ocultos -->
        <div class="box-body">
          <div class="col-md-12">
            <table class="table table-strippered responsive nowrap"  id="config1" name="config1" cellspacing="0" width="100%">
              <thead style="background-color:#222222; color:white;"><th>Id Configuración</th><th>Descripción</th><th>Tipo</th><th>Valor</th><th>Editar</th></thead>
              <?php
                  if (isset($configuraciones) && count($configuraciones)> 0)
                  {
                    $count=1;
                    foreach ($configuraciones as $rowC1)
                    {
                      echo ('<tr><td >'.$rowC1['idConfiguracion']."</td>");
                      echo ("<td>".$rowC1['descripcion']."</td>");
                      echo ("<td>".$rowC1['tipo']."</td>");
                      echo ("<td>".$rowC1['valor']."</td>");
                      echo ("<td><button class='btn btn-sm btn-success' type='button'
                      onclick=\"editConfig(".$count.");\" value='".$rowC1['idConfiguracion']."'>Editar</button></td></tr>");
                      $count++;
                    }
                  }
              ?>
            </table>
          </div>
        </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="mbtnCerrarModal" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <script>
  var anterior="";
  function guardarConfig(count)
  {
    var table = x("config1");
    var elm= table.rows[count].cells[3];
    var value = x('editando'+count).value;
    var idE= x('idEmpresa').value;
    elm.innerHTML='';
    elm.innerHTML = value;
    if(value!=anterior)
    {
      var idConfig= table.rows[count].cells[0].innerHTML;
      jQuery.ajax({
          type: "POST",
          url: baseurl+"/empresas/guardarConfig/"+idConfig+'/'+value+'/'+idE,
          dataType:'json',
          success:function(response)
          {
            if(response==0)
            {
              var n = noty({ layout:'topRight',type: 'warning',  theme: 'relax',text: 'Hubo un error al guardar la configuración.'});
            }
         } });
    }
    table.rows[count].cells[4].innerHTML='';
    var button= document.createElement('button')
    button.setAttribute('type','button');
    button.setAttribute('class','btn btn-success btn-sm');
    button.setAttribute('onClick','editConfig('+count+')');
    button.innerHTML="Editar";
    table.rows[count].cells[4].appendChild(button);
}

function editConfig(count) {
    var table = x("config1");
    var elm= table.rows[count].cells[3];
    if (elm.getElementsByTagName('input').length > 0) return;

    var value = elm.innerHTML;
    anterior=value;
    elm.innerHTML = '';

    var input = document.createElement('input');
    input.setAttribute('type', 'text');
    input.setAttribute('value', value);
    input.setAttribute('id', 'editando'+count);
    input.setAttribute('onBlur', 'closeInput(this)');
    elm.appendChild(input);
    table.rows[count].cells[4].innerHTML='';
    var button= document.createElement('button')
    button.setAttribute('type','button');
    button.setAttribute('class','btn btn-default btn-sm');
    button.setAttribute('onClick','guardarConfig('+count+')');
    button.innerHTML="Guardar";
    table.rows[count].cells[4].appendChild(button);
    input.focus();
}
  </script>
