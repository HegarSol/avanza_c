<?php

class Migration_Agregar_balansa_menu extends CI_Migration
{
    public function up()
    {
        $data = array(
            'id'=>13,
            'parent' => 2,
            'name' => 'Reporte balanza de comprobacion',
            'icon' => '',
            'slug' => 'reportesm/BalanzaComprobacion/index',
            'number' => 1,
            'nivel' => 1,
            'tipo' => null
        );
        $this->db->insert('menus',$data);
    }
    public function down()
    {
       $this->db->delete('menus',array('id'=>13));
    }
}