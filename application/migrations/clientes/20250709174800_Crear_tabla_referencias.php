<?php
class Migration_Crear_tabla_referencias extends CI_Migration{
    public function up()
    {
         $query = "CREATE TABLE `referencias` (
             `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
             `referencia` varchar(15) NOT NULL,
             `descripcion` varchar(45) NULL,
             PRIMARY KEY(`id`)
         ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
         $this->db->query($query);
    }
    public function down()
    {
         $this->dbforge->drop_table('referencias',TRUE);
    }
}