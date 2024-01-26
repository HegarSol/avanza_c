<?php
class Migration_Add_tipo_provedor_operacion_encabeza extends CI_Migration
{
    public function up()
    {
        $campo = array('tipo_proveedor' => array(
             'type' => 'varchar',
             'constraint' => 20,
             'null' => TRUE
        ));
        $this->dbforge->add_column('opera_banco_encabe',$campo);
    }
    public function down()
    {
        $this->dbforge->drop_column('opera_banco_encabe','tipo_proveedor');
    }
}