<?php

  class Migration_Agregar_repote_auxiliar_menu extends CI_Migration{
      public function up()
      {
          $data = array(
              'id' => 19,
              'parent' => null,
              'name' => 'Reportes Auxiliares',
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
          $this->db->delete('menus',array('id' => 19));
      }
  }