<?php

   class Migration_Crear_tabla_catcuentas extends CI_Migration{
       public function up()
       {
           $script = "CREATE TABLE `catalogocta` (
               `idcuenta` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, 
               `cuenta` smallint(5) DEFAULT NULL,
               `sub_cta` smallint(5) DEFAULT NULL,
               `nombre` varchar(255) DEFAULT NULL,
               `tipo` char(3) DEFAULT NULL,
               `ctasat` char(30) DEFAULT NULL,
               `natur` char(3) DEFAULT NULL,
               `cvecobro` int(10) DEFAULT NULL,
               `ssub_cta` smallint(4) DEFAULT NULL,
               PRIMARY KEY (`idcuenta`)
           ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
           $this->db->query($script);
       }
       public function down()
       {
           $this->dbforge->drop_table('tocatcta', TRUE);
       } 
   }