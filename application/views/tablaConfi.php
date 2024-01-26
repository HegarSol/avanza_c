<table class="table table-striped table-bordered" id="tabla_conf_gene">
  <thead>
     <tr>
       <th>ID configuración</th>
       <th>Descripción</th>
       <th>Tipo</th>
       <th>Valor</th>
       <th>Parent</th>
       <th>Inactiva</th>
       <th>Accion</th>
     </tr>
  </thead>
  <tbody>
     <?php foreach($configuragene as $gene): ?>
       <tr>
          <th><?php echo $gene['idConfiguracion']; ?></th>
          <th><?php echo $gene['descripcion']; ?></th>
          <th><?php echo $gene['tipo']; ?></th>
          <th><?php echo $gene['valor']; ?></th>
          <th><?php echo $gene['parent']; ?></th>
          <th><?php echo $gene['inactiva']; ?></th>
          <th><button type="button" class="btn btn-primary" onclick="elegirconfge(<?php echo $gene['id'] ?>,<?php echo $gene['valor'] ?>,<?php echo $gene['inactiva'] ?>)" title="Modificar"><span class="fa fa-pencil"></span></button></th>
       </tr>
     <?php endforeach; ?>
  </tbody>
</table>

