<?php
class Migration_Crear_tabla_configuraciones extends CI_Migration{
    public function up()
    {
        $query = "CREATE TABLE `configuraciones_general` (
            `idConfiguracion` varchar(50) NOT NULL,
            `descripcion` text NULL,
            `tipo` char(1) NOT NULL DEFAULT '',
            `valor` text NULL,
            `parent` char(25) NOT NULL DEFAULT '',
            `inactiva` tinyint(1) NOT NULL DEFAULT 0,
            `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
        $this->db->query($query);
    }
    public function down()
    {
        $this->dbforge->drop_table('configuraciones_general',TRUE);
    }
}