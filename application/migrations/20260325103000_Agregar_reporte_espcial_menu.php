<?php

class Migration_agregar_reporte_espcial_menu extends CI_Migration{
    public function up()
    {
        $data = array(
            'id' => 27,
            'parent' => null,
            'name' => 'Reportes especiales',
            'icon' => '',
            'slug' => '',
            'number' => 7,
            'nivel' => 1,
            'tipo' => null
        );
        $this->db->insert('menus',$data);
    }
    public function down()
    {
        $this->db->delete('menus',array('id' => 27));
    }
}

?>