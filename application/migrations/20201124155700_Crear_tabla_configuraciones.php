<?php


class Migration_Crear_tabla_configuraciones extends CI_Migration{
    public function up()
    {
          $script = "CREATE TABLE `configuraciones_general` (
              `idConfiguracion` VARCHAR(105) DEFAULT NULL,
              `descripcion` blob DEFAULT NULL,
              `tipo` char(3) DEFAULT NULL,
              `valor` blob DEFAULT NULL,
              `parent` char(75) DEFAULT NULL,
              `inactiva` tinyint(1) DEFAULT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
          $this->db->query($script);
    }
    public function down()
    {
        $this->dbforge->drop_table('configuraciones',TRUE);
    }
}