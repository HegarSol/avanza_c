<?php

class Migration_Add_campo_autorizacion_config extends CI_Migration
{
    public function up()
    {
        $campo = array('autorizacion' => array(
           'type' => 'char',
           'constraint' => 5,
           'null' => TRUE
        ));
        $this->dbforge->add_column('empresas',$campo);
    }
    public function down()
    {
        $this->dbforge->drop_column('empresas','autorizacion');
    }
}