<?php

class Migration_Agregar_reporte_cuenta_pagar extends CI_Migration{
    public function up()
    {
        $data = array(
            'id' => 10,
            'parent' => 2,
            'name' => 'Reporte cuentas pagar',
            'icon' => '',
            'slug' => 'reportesm/ReporteCuentasPagar/index',
            'number' => 1,
            'nivel' => 1,
            'tipo' => null
        );
        $this->db->insert('menus',$data);
    }
    public function down()
    {
        $this->db->delete('menus',array('id' => 10));
    }
}