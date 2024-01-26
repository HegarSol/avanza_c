<?php

class Migration_Add_telefono_configuracion extends CI_Migration
{
    public function up()
    {
        $campo = array('telefono' => array(
           'type' => 'varchar',
           'constraint' => 100,
           'null' => TRUE
        ));
        $this->dbforge->add_column('configuraciones',$campo);
    }
    public function down()
    {
        $this->dbforge->drop_column('configuraciones','telefono');
    }
}