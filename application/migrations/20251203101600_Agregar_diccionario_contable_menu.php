<?php

  class Migration_Agregar_diccionario_contable_menu extends CI_Migration{
      public function up()
      {
          $data = array(
              'id' => 26,
              'parent' => 23,
              'name' => 'Diccionario Contable',
              'icon' => '',
              'slug' => 'Herramientas/Diccionarioconta',
              'number' => 1,
              'nivel' => 1,
              'tipo' => null
          );
          $this->db->insert('menus',$data);
      }
      public function down()
      {
          $this->db->delete('menus',array('id' => 26));
      }
  }