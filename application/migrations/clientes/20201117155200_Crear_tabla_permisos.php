<?php

   class Migration_Crear_tabla_permisos extends CI_Migration{
       public function up()
       {
           $query = "CREATE TABLE `permisos`(
               `idForma` int(12) NOT NULL,
               `idUsuario` int(11) NOT NULL,
               `leer` char(1) DEFAULT NULL,
               `agregar` char(1) DEFAULT NULL,
               `editar` char(1) DEFAULT NULL,
               `borrar` char(1) DEFAULT NULL,
               `print` char(1) DEFAULT '0',
               PRIMARY KEY (`idForma`,`idUsuario`),
               KEY `fkIdUsuario1` (`idUsuario`)
           ) ENGINE=InnDB DEFAULT CHARSET=utf8;";
           $this->db->query($query);
       }
       public function down()
       {
           $this->dbforge->drop_table('permisos',TRUE);
       }
   }