<?php
class Migration_Crear_tabla_opera_banco_encabe extends CI_Migration{
    public function up()
    {
        $query = "CREATE TABLE `opera_banco_encabe`(
            `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `tipo_mov` char(3) DEFAULT NULL,
            `no_banco` smallint(3) DEFAULT NULL,
            `no_mov` int(11) DEFAULT NULL,
            `fecha` date,
            `beneficia` varchar(254) DEFAULT NULL,
            `concepto` text DEFAULT NULL,
            `monto` decimal(13,2) DEFAULT '0.00',
            `c_a` char(3) ,
            `cobrado` tinyint(1) DEFAULT NULL,
            `cerrado` tinyint(1) DEFAULT NULL,
            `no_prov` mediumint(5) DEFAULT '0',
            `fechaCobro` date,
            `impreso` tinyint(1) DEFAULT '0',
            `afectar` tinyint(1) DEFAULT '0',
            `bancosat` char(9),
            `bene_ctaban` text DEFAULT NULL,
            `tieneCxP_pagos` tinyint(1) DEFAULT '0',
            PRIMARY KEY (`id`) 
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
        $this->db->query($query);
    }
    public function down()
    {
        $this->dbforge->drop_table('opera_banco_encabe',TRUE);
    }
}