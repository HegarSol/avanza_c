<?php

class Migration_Add_referencia_campo extends CI_Migration
{
    public function up()
    {
        $campo = array('referenciamarca' => array(
           'type' => 'char',
           'constraint' => 5,
           'null' => TRUE
        ));
        $this->dbforge->add_column('empresas',$campo);
    }
    public function down()
    {
        $this->dbforge->drop_column('empresas','referenciamarca');
    }
}