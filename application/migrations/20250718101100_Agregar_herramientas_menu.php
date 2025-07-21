<?php

  class Migration_Agregar_herramientas_menu extends CI_Migration{
      public function up()
      {
          $data = array(
              'id' => 23,
              'parent' => null,
              'name' => 'Herramientas',
              'icon' => '',
              'slug' => '',
              'number' => 6,
              'nivel' => 1,
              'tipo' => null
          );
          $this->db->insert('menus',$data);
      }
      public function down()
      {
          $this->db->delete('menus',array('id' => 23));
      }
  }