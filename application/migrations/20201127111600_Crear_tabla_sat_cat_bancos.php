<?php
class Migration_Crear_tabla_sat_cat_bancos extends CI_Migration{
    public function up()
    {
        $script = "CREATE TABLE `sat_ctg_bancos`(
            `clave` char(3) NOT NULL ,
            `nombre_c` varchar(40) DEFAULT NULL,
            `nombre` varchar(254) DEFAULT NULL,
            PRIMARY KEY (`clave`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->db->query($script);
    }
    public function down()
    {
        $this->dbforge->drop_table('sat_ctg_bancos',TRUE);
    }
}