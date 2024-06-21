<?php

class Migration_Add_campo_ssub_cuenta_detalle extends CI_Migration 
{
    public function up()
    {
       $campo = array('ssub_cta' => array(
          'type' => 'varchar',
          'constraint' => 10,
          'null' => TRUE
       ));
       $this->dbforge->add_column('opera_banco_detalle',$campo);
    }
    public function down()
    {
       $this->dbforge->drop_column('opera_banco_detalle','ssub_cta');
    }
}