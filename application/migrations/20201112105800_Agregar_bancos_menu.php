<?php

 class Migration_Agregar_bancos_menu extends CI_Migration{
    public function up()
    {
      $data = array(
        'id' => 1,
        'parent' => 3,
        'name' => 'Bancos',
        'icon' => '',
        'slug' => 'catalogos/Bancos/index',
        'number' => 1,
        'nivel' => 1,
        'tipo' => null
      );
      $this->db->insert('menus', $data);
    }

    public function down()
    {
      $this->db->delete('menus', array('id' => 1));
    }
 }