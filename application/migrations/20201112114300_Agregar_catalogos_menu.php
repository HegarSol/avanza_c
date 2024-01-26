<?php

 class Migration_Agregar_catalogos_menu extends CI_Migration{
    public function up()
    {
      $data = array(
        'id' => 3,
        'parent' => null,
        'name' => 'Catálogos',
        'icon' => '',
        'slug' => '',
        'number' => 3,
        'nivel' => 1,
        'tipo' => null
      );
      $this->db->insert('menus', $data);
    }

    public function down()
    {
      $this->db->delete('menus', array('id' => 3));
    }
 }