<?php

class Migration_Agregar_deptos_forma extends CI_Migration{
    public function up()
    {
        $data = array(
            'idForma' => 13,
            'nombrForma' => 'departamentocostos',
            'descripcion' => 'Departamentos de costos',
            'tipo' => 1
        );
        $this->db->insert('formas',$data);
    }
    public function down()
    {
        $this->db->delete('formas',array('idForma' => 13));
    }
}