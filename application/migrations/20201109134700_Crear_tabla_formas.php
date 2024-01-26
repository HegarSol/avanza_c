<?php
class Migration_Crear_tabla_formas extends CI_Migration{
    public function up()
    {
        $script = "CREATE TABLE `formas` (
            `idForma` int(10) NOT NULL AUTO_INCREMENT,
            `nombrForma` varchar(150) DEFAULT NULL,
            `descripcion` varchar(150) DEFAULT NULL,
            `tipo` varchar(20) DEFAULT NULL,
            PRIMARY KEY (`idForma`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
        $this->db->query($script);
    }
    public function down()
    {
        $this->dbforge->drop_table('formas',TRUE);
    }
}