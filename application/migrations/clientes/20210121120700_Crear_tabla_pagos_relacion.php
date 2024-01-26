<?php
class Migration_Crear_tabla_pagos_relacion extends CI_Migration{
    public function up()
    {
        $query = "CREATE TABLE `pagos_relacion`(
            `idPagos_uuid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `idPago` int(10) UNSIGNED NULL,
            `uuid` varchar(36) NULL,
            `serie` varchar(10) NULL,
            `folio` varchar(10) NULL,
            `monedaDR` varchar(3) NULL,
            `tipoCambioDR` decimal(9,6) NULL,
            `metodoDePagoDR` char(3) NULL,
            `numParcialidad` tinyint(4) NULL,
            `impSaldoAnt` decimal(11,2) NULL,
            `impPagado` decimal(11,2) DEFAULT '0.00',
            `impSaldoInsoluto` decimal(11,2) NULL,
            `referencia` varchar(15) NULL,
            `tipo` tinyint(1) default '1' NOT NULL,
            `c_aPorDiferencia` decimal(11,2) DEFAULT '0.00' NOT NULL,
            `totalPago` decimal(11,2) DEFAULT '0.00' NOT NULL,
            `t_cFactura` decimal(8,4) NULL,
            `no_cte` smallint(6) NULL,
            PRIMARY KEY (`idPagos_uuid`) 
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
        $this->db->query($query);
    }
    public function down()
    {
        $this->dbforge->drop_table('pagos_relacion',TRUE);
    }
}