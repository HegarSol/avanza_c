<?php

class Migration_Agregar_reporte_auxiliar_cliente extends CI_Migration {
    public function up()
    {
         $data = array(
            'id' => 20,
            'parent' => 19,
            'name' => 'Reporte auxiliar cliente',
            'icon' => '',
            'slug' => 'reportesm/ReporteAuxiliarCliente/index',
            'number' => 1,
            'nivel' => 1,
            'tipo' => null
         );
            $this->db->insert('menus',$data);
    }
    public function down()
    {
        $this->db->delete('menus',array('id' => 20));
    }
}