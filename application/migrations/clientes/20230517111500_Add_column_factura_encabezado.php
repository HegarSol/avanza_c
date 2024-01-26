<?php

class Migration_Add_column_factura_encabezado extends CI_Migration
{
    public function up()
    {
        $campo = array('factura_provi' => array(
              'type' => 'varchar',
              'constraint' => 100,
              'null' => TRUE
             ),
            'serie_prov' => array(
                'type' => 'varchar',
                'constraint' => 50,
                'null' => TRUE
            ));
        $this->dbforge->add_column('opera_banco_encabe',$campo);
    }
    public function down()
    {
       // $this->dbforge->drop_column('opera_banco_encabe','factura');
    }
}