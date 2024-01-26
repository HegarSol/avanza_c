<?php

class Migration_Agregar_poliza_diarias_forma extends CI_Migration{
    public function up()
    {
        $data = array(
            'idForma' => 9,
            'nombrForma' => 'polizasdiarias',
            'descripcion' => 'Polizas diarias',
            'tipo' => 1
        );
        $this->db->insert('formas',$data);
    }
    public function down()
    {
        $this->db->delete('formas',array('idForma' => 9));
    }
}