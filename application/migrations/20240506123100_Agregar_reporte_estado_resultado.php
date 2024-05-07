<?php

class Migration_Agregar_reporte_estado_resultado extends CI_Migration
{
    public function up()
    {
        $data = array(
            'id' => 16,
            'parent' => 2,
            'name' => 'Reporte estado de resultado',
            'icon' => '',
            'slug' => 'reportesm/ReporteEstadoResultado/index',
            'number' => 1,
            'nivel' => 1,
            'tipo' => null
        );
        $this->db->insert('menus',$data);
    }
    public function down()
    {
        $this->db->delete('menus',array('id'=>16));
    }
}