<?php

class Migration_Agregar_referencias_menu extends CI_Migration{
    public function up()
    {
        $data = array(
            'id' => 22,
            'parent' => 3,
            'name' => 'Referencias de control de gastos',
            'icon' => '',
            'slug' => 'catalogos/referencias/index',
            'number' => 7,
            'nivel' => 1,
            'tipo' => null
        );
        $this->db->insert('menus',$data);
    }
    public function down()
    {
        $this->db->delete('menu',array('id' => 22));
    }
}