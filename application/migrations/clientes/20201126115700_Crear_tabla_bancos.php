<?php
class Migration_Crear_tabla_bancos extends CI_Migration{
    public function up()
    {
        $query = "CREATE TABLE `catalogo_banco` (
            `id_banco` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `no_banco` smallint(3) UNSIGNED DEFAULT NULL ,
            `cuenta` varchar(60) DEFAULT NULL,
            `banco` varchar(120) DEFAULT NULL,
            `direccion` varchar(60) DEFAULT NULL,
            `ciudad` varchar(60) DEFAULT NULL,
            `estado` varchar(60) DEFAULT NULL, 
            `cheques` int(11) DEFAULT NULL, 
            `depositos` int(11) DEFAULT NULL,
            `movimiento` int(11) DEFAULT NULL,
            `logo` longblob,
            `cta` smallint(4) DEFAULT NULL,
            `sub_cta` smallint(4) DEFAULT NULL,
            `ch_repName` varchar(120) DEFAULT NULL,
            `bancoSat` char(9) DEFAULT NULL,
            `bancoSatNom` varchar(150) DEFAULT NULL,
            `renglonesR` tinyint(3) DEFAULT NULL,
            `bancoSaai` char(9) DEFAULT NULL,
            `rfc` varchar(39) DEFAULT NULL,
            `clabe` varchar(54) DEFAULT NULL,
            `url` varchar(255) DEFAULT NULL,
            `ssub_cta` smallint(6) DEFAULT NULL,
            PRIMARY KEY (`id_banco`) 
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
        $this->db->query($query);
    }
    public function down()
    {
        $this->dbforge->drop_table('catalogo_banco',TRUE);
    }
}