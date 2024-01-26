<?php

class Migration_Add_campo_ctabanco_encabezado extends CI_Migration 
{
    public function up()
    {
       $campo = array('cta_banco' => array(
          'type' => 'varchar',
          'constraint' => 20,
          'null' => TRUE
       ));
       $this->dbforge->add_column('opera_banco_encabe',$campo);
    }
    public function down()
    {
       $this->dbforge->drop_column('opera_banco_encabe','cta_banco');
    }
}