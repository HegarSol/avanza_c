<?php

class Migration_Crear_tabla_bitacora extends CI_Migration{
    public function up()
    {
        $query = "CREATE TABLE `bitacora` (
            `usuario` char(150) NOT NULL,
            `tipo_mov` varchar(15) NULL,
            `no_banco` varchar(10) NULL,
            `no_mov` varchar(100) NULL,
            `accion` varchar(20) NOT NULL,
            `cuando` datetime NOT NULL,
            `comentario` text NULL ,
            `modulo` varchar(50) NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->db->query($query);
    }
    public function down()
    {
        $this->dbforge->drop_table('bitacora',TRUE);
    }
}