<?php

class Migration_Agregar_reporte_diot_menu extends CI_Migration
{
    public function up()
    {
        $data = array(
            'id' => 15,
            'parent' => 2,
            'name' => 'Reporte de diot',
            'icon' => '',
            'slug' => 'reportesm/ReporteDiot/index',
            'number' => 1,
            'nivel' => 1,
            'tipo' => null
        );
        $this->db->insert('menus',$data);
    }
    public function down()
    {
        $this->db->delete('menus',array('id'=>15));
    }
}