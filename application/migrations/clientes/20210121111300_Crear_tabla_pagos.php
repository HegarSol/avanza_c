<?php
class Migration_Crear_tabla_pagos extends CI_Migration{
    public function up()
    {
        $query = "CREATE TABLE `pagos` (
            `idPago` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `no_cte` mediumint(4) NULL,
            `fechaPago` datetime,
            `formaDepagoP` varchar(3) NULL,
            `monedaP` varchar(4) NULL,
            `tipoCambioP` decimal(10,6) NULL,
            `monto` decimal(13,4) NULL,
            `numOperacion` varchar(110) NULL,
            `rfcEmisorCtaOrd` varchar(13) NULL,
            `nomBancoOrdExt` text,
            `ctaOrdenante` varchar(60) NULL,
            `rfcEmisorCtaBen` varchar(13) NULL,
            `ctaBeneficiario` varchar(50) NULL,
            `tipoCadPago` varchar(3) NULL,
            `certPago` text,
            `cadPago` text,
            `selloPago` text,
            `serie` varchar(5),
            `no_mov` mediumint(8) NULL,
            `tipo_mov` char(1) NULL,
            `no_banco` tinyint(2) NULL,
            `ban_no_mov` int(8) NULL,
            `selec` tinyint(1) DEFAULT '0' NOT NULL,
            PRIMARY KEY (`idPago`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
        $this->db->query($query);
    }
    public function down()
    {
        $this->dbforge->drop_table('pagos',TRUE);
    }
}