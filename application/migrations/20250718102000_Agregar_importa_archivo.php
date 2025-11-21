<?php

class Migration_Agregar_importa_archivo extends CI_Migration {
    public function up()
    {
         $data = array(
            'id' => 24,
            'parent' => 23,
            'name' => 'Importa información de facturas desde Excel',
            'icon' => '',
            'slug' => 'Herramientas/index',
            'number' => 1,
            'nivel' => 1,
            'tipo' => null
         );
            $this->db->insert('menus',$data);
    }
    public function down()
    {
        $this->db->delete('menus',array('id' => 24));
    }
}