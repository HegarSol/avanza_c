<?php

  class Migration_Agregar_balance_general_menu extends CI_Migration{
      public function up()
      {
          $data = array(
              'id' => 25,
              'parent' => 2,
              'name' => 'Balanze general',
              'icon' => '',
              'slug' => 'reportesm/BalanceGeneral/index',
              'number' => 1,
              'nivel' => 1,
              'tipo' => null
          );
          $this->db->insert('menus',$data);
      }
      public function down()
      {
          $this->db->delete('menus',array('id' => 25));
      }
  }