<?php

 class Migration_Agregar_usuarios_menu extends CI_Migration{
    public function up()
    {
      $data = array(
        'id' => 5,
        'parent' => 4,
        'name' => 'Usuarios',
        'icon' => '',
        'slug' => 'usuarios/index',
        'number' => 1,
        'nivel' => 4,
        'tipo' => null
      );
      $this->db->insert('menus', $data);
    }

    public function down()
    {
      $this->db->delete('menus', array('id' => 5));
    }
 }