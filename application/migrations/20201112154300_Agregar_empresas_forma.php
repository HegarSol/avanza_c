<?php
class Migration_Agregar_empresas_forma extends CI_Migration{
    public function up()
    {
        $data = array(
            'idForma' => 5,
            'nombrForma' => 'empresas',
            'descripcion' => 'Empresas',
            'tipo' => 3
        );

        $this->db->insert('formas',$data);
    }
    public function down()
    {
        $this->db->delete('formas',array('idForma' => 4));
    }
}