<?php

class Migration_Alter_table_add_clave_pagos extends CI_Migration
{
    public function up()
    {
        $campo = array('clave_cliente' => array(
             'type' => 'varchar',
             'constraint' => 255,
             'null' => TRUE
        ));
        $this->dbforge->add_column('pagos',$campo);
    }
    public function down()
    {
        $this->dbforge->drop_column('pagos','clave_cliente');
    }
}