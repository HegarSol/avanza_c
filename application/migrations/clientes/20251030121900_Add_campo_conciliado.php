<?php

class Migration_Add_campo_conciliado extends CI_Migration
{
    public function up()
    {
         $campo = array('conciliado' => array(
               'type' => 'char',
               'constraint' => 1,
               'null' => TRUE
         ));
         $this->dbforge->add_column('beneficiario',$campo);
    }
    public function down()
    {
        $this->dbforge->drop_column('beneficiario','conciliado');
    }
}