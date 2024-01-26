<?php
class Migration_Crear_tabla_banco_benefe extends CI_Migration{
    public function up()
    {
        $query = "CREATE TABLE `bancobenefi` (
            `no_prov` int(10) UNSIGNED NOT NULL,
            `ctaBan` char(20) NOT NULL,
            `bancoSat` char(4) NOT NULL,
            `ctaClabe` char(19) NULL,
            `nombre` text NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->db->query($query);
    }
    public function down()
    {
        $this->dbforge->drop_table('bancobenefi',TRUE);
    }
}