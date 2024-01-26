<?php
class Migration_Agregar_reportes_forma extends CI_Migration{
    public function up()
    {
        $data = array(
            'idForma' => 2,
            'nombrForma' => 'Reportes',
            'descripcion' => 'Reportes',
            'tipo' => 1
        );

        $this->db->insert('formas',$data);
    }
    public function down()
    {
        $this->db->delete('formas',array('idForma' => 2));
    }
}