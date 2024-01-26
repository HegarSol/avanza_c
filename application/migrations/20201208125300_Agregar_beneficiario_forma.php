<?php
class Migration_Agregar_beneficiario_forma extends CI_Migration{
    public function up()
    {
        $data = array(
            'idForma' => 8,
            'nombrForma' => 'Beneficiarios',
            'descripcion' => 'Beneficiarios',
            'tipo' => 1
        );
        $this->db->insert('formas',$data);
    }
    public function down()
    {
        $this->db->delete('formas',array('idForma' => 8));
    }
}