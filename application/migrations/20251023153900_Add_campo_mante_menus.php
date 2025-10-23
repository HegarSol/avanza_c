<?php

class Migration_Add_campo_mante_menus extends CI_Migration
{
    public function up()
    {
        $campo = array('mante' => array(
           'type' => 'char',
           'constraint' => 1,
           'null' => TRUE
        ));
        $this->dbforge->add_column('menus',$campo);
    }
    public function down()
    {
        $this->dbforge->drop_column('menus','mante');
    }
}