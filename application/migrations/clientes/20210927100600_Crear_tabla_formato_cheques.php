<?php
class Migration_Crear_tabla_formato_cheques extends CI_Migration{
    public function up()
    {
       $query = "CREATE TABLE `formato_cheques` (
           `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
           `nombre_formato` varchar(200) NULL,
           `path` text NULL,
           `tipo` varchar(20) NULL,
           `banco` varchar(20) NULL,
           PRIMARY KEY (`id`)
       ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
       $this->db->query($query);
    }
    public function down()
    {
        $this->dbforge->drop_table('formato_cheques',TRUE);
    }
}