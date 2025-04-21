<?php

class Migration_Agregar_deptos_menu extends CI_Migration{
    public function up()
    {
        $data = array(
            'id' => 21,
            'parent' => 3,
            'name' => 'Deptos de costos',
            'icon' => '',
            'slug' => 'catalogos/DeptosCostos/index',
            'number' => 6,
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