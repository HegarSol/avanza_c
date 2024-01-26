<?php

class Migration_Agregar_cuentas_menu extends CI_Migration{
    public function up()
    {
        $data = array(
            'id' => 7,
            'parent' => 3,
            'name' => 'Cuentas',
            'icon' => '',
            'slug' => 'catalogos/Cuentas/index',
            'number' => 4,
            'nivel' => 1,
            'tipo' => null
        );
        $this->db->insert('menus',$data);
    }
    public function down()
    {
        $this->db->delete('menus',array('id' => 7));
    }
}