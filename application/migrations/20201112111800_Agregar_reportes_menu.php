<?php

  class Migration_Agregar_reportes_menu extends CI_Migration{
      public function up()
      {
          $data = array(
              'id' => 2,
              'parent' => null,
              'name' => 'Reportes',
              'icon' => '',
              'slug' => 'reportes/index',
              'number' => 5,
              'nivel' => 1,
              'tipo' => null
          );
          $this->db->insert('menus',$data);
      }
      public function down()
      {
          $this->db->delete('menus',array('id' => 2));
      }
  }