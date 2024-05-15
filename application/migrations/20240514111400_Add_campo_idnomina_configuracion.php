<?php

class Migration_Add_campo_idnomina_configuracion extends CI_Migration
{
    public function up()
    {
        $campo = array('idNomina' => array(
           'type' => 'varchar',
           'constraint' => 10,
           'null' => TRUE
        ));
        $this->dbforge->add_column('empresas',$campo);
    }
    public function down()
    {
        $this->dbforge->drop_column('empresas','idNomina');
    }
}