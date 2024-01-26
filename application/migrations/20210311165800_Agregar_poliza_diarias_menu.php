<?php

class Migration_Agregar_poliza_diarias_menu extends CI_Migration{
    public function up()
    {
        $data = array(
            'id' => 9,
            'parent' => 3,
            'name' => 'Polizas diarias',
            'icon' => '',
            'slug' => 'catalogos/Polizasdiarias/index',
            'number' => 4,
            'nivel' => 1,
            'tipo' => null
        );
        $this->db->insert('menus',$data);
    }
    public function down()
    {
        $this->db->delete('menu',array('id' => 9));
    }
}