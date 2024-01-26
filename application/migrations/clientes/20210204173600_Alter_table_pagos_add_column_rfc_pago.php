<?php

class Migration_Alter_table_pagos_add_column_rfc_pago extends CI_Migration 
{
    public function up()
    {
       $campo = array('rfc_pago' => array(
          'type' => 'varchar',
          'constraint' => 20,
          'null' => TRUE
       ));
       $this->dbforge->add_column('pagos',$campo);
    }
    public function down()
    {
       $this->dbforge->drop_column('pagos','rfc_pago');
    }
}