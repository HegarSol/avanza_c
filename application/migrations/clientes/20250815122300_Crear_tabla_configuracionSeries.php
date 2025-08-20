<?php
      class Migration_Crear_tabla_configuracionSeries extends CI_Migration{
        public function up()
        {
          $script = "CREATE TABLE `configctaseries` (
            `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `serie` varchar(10) DEFAULT NULL,
            `cuenta` varchar(10) DEFAULT NULL,
            `descrip` varchar(200) DEFAULT NULL,
            `sub_cta` varchar(10) DEFAULT NULL,
            `ssub_cta` varchar(10) DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
        $this->db->query($script);
        }

        public function down()
        {
          $this->dbforge->drop_table('configctaseries', TRUE);
        }
      }