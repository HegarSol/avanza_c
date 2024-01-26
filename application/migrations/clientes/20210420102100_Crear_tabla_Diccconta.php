<?php
class Migration_Crear_tabla_Diccconta extends CI_Migration{
    public function up()
    {
        $query = "CREATE TABLE `dicconta` (
            `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
            `codigoSAT` char(15) DEFAULT NULL,
            `cuenta` mediumint DEFAULT NULL,
            `sub_cta` mediumint DEFAULT NULL,
            `ssub_cta` mediumint DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
        $this->db->query($query);
    }
    public function down()
    {
        $this->dbforge->drop_table('dicconta',TRUE);
    }
}