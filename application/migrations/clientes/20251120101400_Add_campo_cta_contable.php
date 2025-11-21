<?php

class Migration_Add_campo_cta_contable extends CI_Migration
{
    public function up()
    {
         $campo = array('cta_contable' => array(
               'type' => 'varchar',
               'constraint' => 20,
               'null' => TRUE
         ));
         $this->dbforge->add_column('beneficiario',$campo);
    }
    public function down()
    {
        $this->dbforge->drop_column('beneficiario','cta_contable');
    }
}