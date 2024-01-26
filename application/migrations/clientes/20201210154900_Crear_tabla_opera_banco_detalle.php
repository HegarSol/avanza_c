<?php
class Migration_Crear_tabla_opera_banco_detalle extends CI_Migration{
    public function up()
    {
        $query = "CREATE TABLE `opera_banco_detalle` (
            `id_encabezado` int(20) DEFAULT NULL,
            `tipo_mov` char(3) DEFAULT NULL,
            `no_banco` tinyint(4) DEFAULT NULL,
            `no_mov` int(11) DEFAULT NULL,
            `ren` bigint(20) DEFAULT NULL,
            `cuenta` smallint(6) DEFAULT NULL,
            `sub_cta` smallint(6) DEFAULT NULL,
            `monto` decimal(11,2) DEFAULT NULL,
            `c_a` char(3) DEFAULT NULL,
            `fecha` date,
            `concepto` varchar(90) DEFAULT NULL,
            `referencia` varchar(16) DEFAULT NULL,
            `no_prov` smallint(6) DEFAULT NULL,
            `factrefe` mediumint(8) DEFAULT NULL,
            `num_reg` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            PRIMARY KEY (`num_reg`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
        $this->db->query($query);
    }
    public function down()
    {
        $this->dbforge->drop_table('opera_banco_detalle',TRUE);
    }
}