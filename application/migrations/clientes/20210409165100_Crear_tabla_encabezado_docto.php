<?php
class Migration_Crear_tabla_encabezado_docto extends CI_Migration{
    public function up()
    {
        $query = "CREATE TABLE `encabe_doctos`(
            `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `tipo_mov` char(3) DEFAULT NULL,
            `no_banco` smallint(3) DEFAULT NULL,
            `no_mov` int(11) DEFAULT NULL,
            `path` text DEFAULT NULL,
            PRIMARY KEY (`id`) 
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
        $this->db->query($query);
    }
    public function down()
    {
        $this->dbforge->drop_table('encabe_doctos',TRUE);
    }
}