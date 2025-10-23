<?php
class Migration_Agregar_balance_general_forma extends CI_Migration{
    public function up()
    {
        $data = array(
            'idForma' => 16,
            'nombrForma' => 'balance_general',
            'descripcion' => 'Balance general',
            'tipo' => 1
        );

        $this->db->insert('formas',$data);
    }
    public function down()
    {
        $this->db->delete('formas',array('idForma' => 16));
    }
}