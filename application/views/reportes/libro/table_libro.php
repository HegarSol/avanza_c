<table class="table table-striped table-bordered" id="tabla_libro">
   <thead>
      <tr>
         <th>Tipo</th>
         <th>Banco</th>
         <th>Póliza</th>
         <th>Fecha</th>
         <th>Beneficiario</th>
         <th>Concepto</th>
         <th>Cuenta</th>
         <th>SubCta</th>
         <th>SsubCta</th>
         <th>Nombre cuenta</th>
         <th>Monto</th>
         <th>C/A</th>
      </tr>
   </thead>
   <tbody>
     <?php foreach($libro as $libros):?>
      <tr>
         <td><?php echo $libros['tipo_mov']; ?></td>
         <td><?php echo $libros['no_banco']; ?></td>
         <td><?php echo $libros['no_mov'];?></td>
         <td><?php echo $libros['fecha']; ?></td>
         <td><?php echo $libros['beneficia']; ?></td>
         <td><?php echo $libros['concepto']; ?></td>
         <td><?php echo $libros['cuenta']; ?></td>
         <td><?php echo $libros['sub_cta']; ?></td>
         <td><?php echo $libros['ssub_cta']; ?></td>
         <td><?php echo $libros['nombre_cuenta']; ?></td>
         <td style="text-align:right;"><?php echo number_format($libros['monto'],2,'.',''); ?></td>
         <td><?php echo $libros['c_a']; ?></td>
      </tr>
      <?php endforeach;?>
   </tbody>
</table>