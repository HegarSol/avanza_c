<?php
class Migration_Crear_tabla_beneficiario extends CI_Migration{
    public function up()
    {
       $query = "CREATE TABLE `beneficiario`(
           `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
           `no_prov` smallint(4) NOT NULL,
           `nombre` varchar(240) NOT NULL,
           `direccion` varchar(240) DEFAULT NULL,
           `no_interior` varchar(90) DEFAULT NULL,
           `no_exterior` varchar(30) DEFAULT NULL,
           `ciudad` varchar(90) DEFAULT NULL,
           `colonia` varchar(150) DEFAULT NULL,
           `municipio` varchar(90) DEFAULT NULL,
           `estado` varchar(90) DEFAULT NULL,
           `pais` varchar(45) DEFAULT NULL,
           `cp` mediumint(6) DEFAULT NULL,
           `curp` varchar(57) DEFAULT NULL,
           `rfc` char(39) DEFAULT NULL,
           `telefono` varchar(36) DEFAULT NULL,
           `email` varchar(100) DEFAULT NULL,
           `solo_credito` tinyint(1) DEFAULT NULL,
           `no_cta` smallint(4) DEFAULT '0',
           `sub_cta` smallint(4) DEFAULT '0',
           `ctacom` smallint(4) DEFAULT '0',
           `subcom` smallint(4) DEFAULT '0',
           `vencim` tinyint(2) DEFAULT '0',
           `concepto` varchar(150) DEFAULT '',
           `tipo_prov` tinyint(1) DEFAULT '0',
           `centro_costos` tinyint(1) DEFAULT '0',
           `no_cta3` smallint(4) DEFAULT NULL,
           `sub_cta3` smallint(4) DEFAULT NULL,
           `traslada_ieps` tinyint(1) DEFAULT '0',
           PRIMARY KEY (`id`)
       ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
       $this->db->query($query);
    }
    public function down()
    {
        $this->dbforge->drop_table('beneficiario',TRUE);
    }
}