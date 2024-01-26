<?php

class Migration_Add_uuid_contrarecibos extends CI_Migration
{
    public function up()
    {
          $campo = array('uuid_contra' => array(
                'type' => 'varchar',
                'constraint' => 40,
                'null' => TRUE
          ));
          $this->dbforge->add_column('contrarecibos',$campo);
    }
    public function down()
    {
         $this->dbforge->drop_column('contrarecibos','uuid_contra');
    }
}