<?php
defined("BASEPATH") or exit("No se permite el acceso directo al script");

class Migration_Crear_tabla_correos extends CI_Migration
{
    public function up()
    {
      $script = "CREATE TABLE `correos` (
                    `idCorreo` int(11) NOT NULL AUTO_INCREMENT,
                    `host` varchar(255) DEFAULT NULL,
                    `SMTPAuth` char(1) DEFAULT NULL,
                    `puerto` varchar(255) DEFAULT NULL,
                    `userName` varchar(255) DEFAULT NULL,
                    `password` varchar(255) DEFAULT NULL,
                    `from1` varchar(255) DEFAULT NULL,
                    `fromName` varchar(255) DEFAULT NULL,
                    `replyTo` varchar(255) DEFAULT NULL,
                    `replyToName` varchar(255) DEFAULT NULL,
                    `subject` longtext,
                    `SMTPSecure` varchar(255) DEFAULT NULL,
                    `body` text,
                    `default` char(1) DEFAULT '0',
                    PRIMARY KEY (`idCorreo`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
      $this->db->query($script);
    }

  public function down()
  {
    $this->dbforge->drop_table('correos',true);
  }
}
?>
