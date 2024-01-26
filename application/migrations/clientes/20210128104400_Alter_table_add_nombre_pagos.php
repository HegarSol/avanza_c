<?php

class Migration_Alter_table_add_nombre_pagos extends CI_Migration
{
    public function up()
    {
       $campo = array('nombre_cliente' => array(
           'type' => 'varchar',
           'constraint' => 255,
           'null' => TRUE
       ));
       $this->dbforge->add_column('pagos',$campo);
    }
    public function down()
    {
        $this->dbforge->drop_column('pagos','nombre_cliente');
    }
}