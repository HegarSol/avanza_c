<?php

class Migration_Add_campo_cta_contable_benefic extends CI_Migration
{
    public function up()
    {
        $campo = array('usactacontable' => array(
           'type' => 'char',
           'constraint' => 1,
           'null' => TRUE
        ));
        $this->dbforge->add_column('empresas',$campo);
    }
    public function down()
    {
        $this->dbforge->drop_column('empresas','usactacontable');
    }
}