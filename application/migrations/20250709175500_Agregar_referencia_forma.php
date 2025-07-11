<?php

class Migration_Agregar_referencia_forma extends CI_Migration{
    public function up()
    {
        $data = array(
            'idForma' => 14,
            'nombrForma' => 'referencias',
            'descripcion' => 'Referencias control de gastos',
            'tipo' => 1
        );
        $this->db->insert('formas',$data);
    }
    public function down()
    {
        $this->db->delete('formas',array('idForma' => 14));
    }
}