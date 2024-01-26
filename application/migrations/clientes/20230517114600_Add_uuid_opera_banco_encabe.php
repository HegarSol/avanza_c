<?php 

class Migration_Add_uuid_opera_banco_encabe extends CI_Migration
{
    public function up()
    {
        $campo = array('uuid_provi' => array(
             'type' => 'varchar',
             'constraint' => 40,
             'null' => TRUE
        ));
        $this->dbforge->add_column('opera_banco_encabe',$campo);
    }
    public function down()
    {
        $this->dbforge->drop_column('opera_banco_encabe','uuid_provi');
    }
}