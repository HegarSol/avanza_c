<?php

class Migration_Agregar_reporte_estado_resultaod_comparativo extends CI_Migration {
    public function up()
    {
         $data = array(
            'id' => 18,
            'parent' => 2,
            'name' => 'Reporte estado resultado comparativo',
            'icon' => '',
            'slug' => 'reportesm/ReporteEstadoResultadoComparativo/index',
            'number' => 1,
            'nivel' => 1,
            'tipo' => null
         );
            $this->db->insert('menus',$data);
    }
    public function down()
    {
        $this->db->delete('menus',array('id' => 18));
    }
}