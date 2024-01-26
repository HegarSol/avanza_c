<?php

  class Migration_Crear_tabla_menus extends CI_Migration{
      public function up()
      {
          $script = "CREATE TABLE `menus` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `parent` int(11) DEFAULT NULL,
              `name` varchar(50) NOT NULL,
              `icon` varchar(30) NOT NULL,
              `slug` varchar(50) NOT NULL,
              `number` int(11) NOT NULL,
              `nivel` int(2) DEFAULT NULL,
              `tipo` varchar(10) DEFAULT NULL,
              PRIMARY KEY (`id`)
          )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
          $this->db->query($script);
      }
      public function down()
      {
          $this->dbforge->drop_table('menus', TRUE);
      }
  }