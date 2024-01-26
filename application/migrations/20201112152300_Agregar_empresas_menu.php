<?php

 class Migration_Agregar_empresas_menu extends CI_Migration{
    public function up()
    {
      $data = array(
        'id' => 6,
        'parent' => 4,
        'name' => 'Empresas',
        'icon' => '',
        'slug' => 'empresas/index',
        'number' => 2,
        'nivel' => 4,
        'tipo' => null
      );
      $this->db->insert('menus', $data);
    }

    public function down()
    {
      $this->db->delete('menus', array('id' => 6));
    }
 }