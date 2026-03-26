<?php

class Migration_Agregar_estadocuenta_menu extends CI_Migration{
    public function up()
    {
        $data = array(
            'id' => 28,
            'parent' => 27,
            'name' => 'Estado de cuenta',
            'icon' => '',
            'slug' => 'reporteespe/EstadoCuenta/index',
            'number' => 1,
            'nivel' => 1,
            'tipo' => null
        );
        $this->db->insert('menus',$data);
    }
    public function down()
    {
        $this->db->delete('menus',array('id' => 28));
    }
}

?>