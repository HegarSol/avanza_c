<table class="table table-striped table-bordered" id="tabla_comparativo">
   <thead>
      <tr>
          <th>Cuenta </th>
          <th>Sub cuenta </th>
          <th>Nombre </th>
      <?php foreach($meses as $mes):?>
            <th><?php echo $mes ;?></th>
        <?php endforeach;?>     
      </tr>
   </thead>
   <tbody>
     <?php foreach($comparativos as $comparativo):?>
        <tr>
           <td><?php echo $comparativo->cuenta ;?></td>
           <td><?php echo $comparativo->sub_cta ;?></td>
           <td><?php echo $comparativo->nombre ;?></td>

            <?php foreach($meses as $mes):?>
                <td><?php echo $comparativo->periodo ;?></td>
            <?php endforeach;?>
        </tr>
      <?php endforeach;?>
   </tbody>
</table>