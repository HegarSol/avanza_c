<?php

 class Migration_Agregar_administrativo_menu extends CI_Migration{
    public function up()
    {
      $data = array(
        'id' => 4,
        'parent' => null,
        'name' => 'Administrativo',
        'icon' => '',
        'slug' => '',
        'number' => 4,
        'nivel' => 3,
        'tipo' => null
      );
      $this->db->insert('menus', $data);
    }

    public function down()
    {
      $this->db->delete('menus', array('id' => 4));
    }
 }