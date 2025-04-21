<?php
class Migration_Crear_tabla_deptos_costos extends CI_Migration{
    public function up()
    {
         $query = "CREATE TABLE `deptos_costos` (
             `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
             `clave` varchar(3) NULL,
             `descripcion` varchar(40) NULL,
             `matriz` tinyint NULL,
             PRIMARY KEY(`id`)
         ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
         $this->db->query($query);
    }
    public function down()
    {
         $this->dbforge->drop_table('deptos_costos',TRUE);
    }
}