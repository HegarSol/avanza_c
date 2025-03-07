<?php
class Migration_Add_campo_objimpdr extends CI_Migration
{
    public function up()
    {
       $campo = array('objimpdr' => array(
          'type' => 'varchar',
          'constraint' => 3,
          'null' => NULL
       ));
       $this->dbforge->add_column('pagos_relacion',$campo);
    }
    public function down()
    {
        $this->dbforge->drop_column('pagos_relacion','objimpdr');
    }
}