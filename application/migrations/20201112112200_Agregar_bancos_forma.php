<?php
class Migration_Agregar_bancos_forma extends CI_Migration{
    public function up()
    {
        $data = array(
            'idForma' => 1,
            'nombrForma' => 'Bancos',
            'descripcion' => 'Bancos',
            'tipo' => 1
        );

        $this->db->insert('formas',$data);
    }
    public function down()
    {
        $this->db->delete('formas',array('idForma' => 1));
    }
}