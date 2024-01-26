<?php
class Migration_Crear_tabla_contrarecibos extends CI_Migration{
    public function up()
    {
         $query = "CREATE TABLE `contrarecibos` (
             `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
             `proveedor` varchar(50) NULL,
             `fact` varchar(60) NULL,
             `serie` varchar(20) NULL,
             `no_contra` varchar(20) NULL,
             `fecha` datetime,
             `cheque` varchar(30) NULL,
             `fechacreacion` datetime NULL,
             PRIMARY KEY(`id`)
         ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
         $this->db->query($query);
    }
    public function down()
    {
         $this->dbforge->drop_table('contrarecibos',TRUE);
    }
}