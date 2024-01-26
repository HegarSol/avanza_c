<?php

class Migration_Add_configu_id_contra extends CI_Migration
{
    public function up()
    {
         $campo = array('id_contra' => array(
               'type' => 'varchar',
               'constraint' => 20,
               'null' => TRUE
         ));
         $this->dbforge->add_column('configuraciones',$campo);
    }
    public function down()
    {
        $this->dbforge->drop_column('configuraciones','id_contra');
    }
}