<?php

class Migration_Agregar_reporte_pagado extends CI_Migration
{
    public function up()
    {
        $data = array(
            'id' => 17,
            'parent' => 2,
            'name' => 'Reporte pagado',
            'icon' => '',
            'slug' => 'reportesm/ReportePagado/index',
            'number' => 1,
            'nivel' => 1,
            'tipo' => null
        );
        $this->db->insert('menus',$data);
    }
    public function down()
    {
        $this->db->delete('menus',array('id'=>17));
    }
}