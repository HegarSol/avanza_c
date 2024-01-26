<?php

class Migration_Crear_tabla_empresas extends CI_Migration{
    public function up()
    {
        $script = "CREATE TABLE `empresas` (
            `idEmpresa` int(15) UNSIGNED NOT NULL AUTO_INCREMENT,
            `rfcEmpresa` varchar(15) NOT NULL,
            `razon` varchar(255) DEFAULT NULL,
            `curp` varchar(20) DEFAULT NULL,
            `calle` varchar(100) DEFAULT NULL,
            `no_ext` varchar(15) DEFAULT NULL,
            `no_int` varchar(15) DEFAULT NULL,
            `colonia` varchar(45) DEFAULT NULL,
            `codpost` varchar(10) DEFAULT NULL,
            `referencia` varchar(60) DEFAULT NULL,
            `localidad` varchar(60) DEFAULT NULL,
            `municipio` varchar(50) DEFAULT NULL,
            `estado` varchar(50) DEFAULT NULL,
            `pais` varchar(45) DEFAULT NULL,
            `tel` varchar(14) DEFAULT NULL,
            `basedeDatos` varchar(255) NOT NULL,
            `usuario` varchar(255) NOT NULL,
            `contrasena` varchar(255) NOT NULL,
            `host` varchar(255) NOT NULL, 
            `idAdmin` int(12) DEFAULT NULL,
            `correoAdmin` varchar(100) DEFAULT NULL,
            PRIMARY KEY (`idEmpresa`),
            KEY `idEmpresa` (`idEmpresa`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
        $this->db->query($script);
    }
    public function down()
    {
        $this->dbforge->drop_table('empresas',TRUE);
    }
}