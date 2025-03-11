<?php
class Migration_Add_marca_pagos extends CI_Migration
{
    public function up()
    {
       $campo = array('marca_pago' => array(
          'type' => 'char',
          'constraint' => 2,
          'null' => true
       ));
       $this->dbforge->add_column('pagos',$campo);
    }
    public function down()
    {
        $this->dbforge->drop_column('pagos','marca_pago');
    }
}