<?php
class Migration_Agregar_herramienta_forma extends CI_Migration{
    public function up()
    {
        $data = array(
            'idForma' => 15,
            'nombrForma' => 'herramientas',
            'descripcion' => 'Herramientas',
            'tipo' => 1
        );

        $this->db->insert('formas',$data);
    }
    public function down()
    {
        $this->db->delete('formas',array('idForma' => 15));
    }
}