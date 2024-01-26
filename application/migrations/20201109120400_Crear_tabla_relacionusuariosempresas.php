<?php

class Migration_Crear_tabla_relacionusuariosempresas extends CI_Migration{
    public function up()
    {
        $script = "CREATE TABLE `relusuarioempresa` (
            `idUsuario` int(11) NOT NULL,
            `idEmpresa` int(11) NOT NULL,
            `tUsuario` varchar(20) DEFAULT NULL,
            `serieDefault` varchar(25) DEFAULT NULL,
            `correoDefault` varchar(10) DEFAULT NULL,
            PRIMARY KEY (`idUsuario`,`idEmpresa`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
        $this->db->query($script);
    }
    public function down()
    {
        $this->dbforge->drop_table('relusuarioempresa', TRUE);
    }
}