<?php
class Migration_add_column_regname extends CI_Migration
{
    public function up()
    {
       $campo = array('ch_repName2' => array(
          'type' => 'varchar',
          'constraint' => 20,
          'null' => NULL
       ));
       $this->dbforge->add_column('catalogo_banco',$campo);
    }
    public function down()
    {
        $this->dbforge->drop_column('catalogo_banco','ch_repName2');
    }
}