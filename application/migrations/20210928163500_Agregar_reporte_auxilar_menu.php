<?php
class Migration_Agregar_reporte_auxilar_menu extends CI_Migration
{
    public function up()
    {
        $data = array(
            'id' => 11,
            'parent' => 2,
            'name' => 'Reporte auxiliar contable',
            'icon' => '',
            'slug' => 'reportesm/ReporteAuxiliarContable/index',
            'number' => 1,
            'nivel' => 1,
            'tipo' => null
        );
        $this->db->insert('menus',$data);
    }
    public function down()
    {
        $this->db->delete('menus',array('id'=>11));
    }
}