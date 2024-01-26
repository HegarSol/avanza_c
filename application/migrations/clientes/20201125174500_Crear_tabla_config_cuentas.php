<?php
class Migration_Crear_tabla_config_cuentas extends CI_Migration{
    public function up()
    {
         $script = "CREATE TABLE `configuracion_cuentas` (
             `idcuentaconfi` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
             `cuenta` int(10) DEFAULT NULL,
             `descrip` varchar(255) DEFAULT NULL,
             `sub_cta` smallint(5) DEFAULT NULL,
             `ssub_cta` smallint(5) DEFAULT NULL,
             PRIMARY KEY (`idcuentaconfi`)
         ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
         $this->db->query($script);
    }
    public function down()
    {
        $this->dbforge->drop_table('configuracion_cuentas',TRUE);
    }
}