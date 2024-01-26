<?php
      class Migration_Crear_tabla_configuracion extends CI_Migration{
        public function up()
        {
          $s = "CREATE TABLE `configuraciones` (
            `id_empresa` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `id_configuracion` int(10) NOT NULL DEFAULT '1',
            `nombreEmpresa` varchar(200) DEFAULT NULL,
            `rfc` varchar(15) DEFAULT '',
            `curp` varchar(19) DEFAULT NULL,
            `img` longblob,
            `imgName` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id_empresa`)
          ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
          $this->db->query($s);
        }

        public function down()
        {
          $this->dbforge->drop_table('configuracion', TRUE);
        }
      }