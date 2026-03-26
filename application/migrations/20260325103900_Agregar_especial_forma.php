<?php

class Migration_Agregar_especial_forma extends CI_Migration{
    public function up()
    {
        $data = array(
            'idForma' => 17,
            'nombrForma' => 'reporte_especial',
            'descripcion' => 'Reporte especial',
            'tipo' => 1
        );
    }
}


?>