<?php

class Migration_Crear_tabla_sat_ctg_cuentas extends CI_Migration{
    public function up()
    {
        $script = "CREATE TABLE `sat_ctg_cuentas`(
            `nivel` tinyint(1) DEFAULT NULL,
            `clave` char(18) DEFAULT NULL,
            `descrip` varchar(600) DEFAULT NULL
        )ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->db->query($script);
    }
    public function down()
    {
        $this->dbforge->drop_table('sat_ctg_cuentas',TRUE);
    }
}