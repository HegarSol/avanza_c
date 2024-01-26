<?php

class Migration_Agregar_configuraciones_general_forma extends CI_Migration{
    public function up()
    {
        $data = array(
            'idForma' => 10,
            'nombrForma' => 'configuraciones_general',
            'descripcion' => 'Configuraciones General',
            'tipo' => 2
        );
       $this->db->insert('formas',$data);
    }
    public function down()
    {
        $this->db->delete('formas',array('idForma' => 10));
    }
}