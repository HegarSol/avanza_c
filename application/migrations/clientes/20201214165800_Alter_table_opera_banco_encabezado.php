<?php
class Migration_Alter_table_opera_banco_encabezado extends CI_Migration{
    public function up()
    {
        $campo = array('nombre_cuenta' => array(
                               'type' => 'longtext',
                               'null' => TRUE));
        $this->dbforge->add_column('opera_banco_detalle',$campo);
    }
    public function down()
    {
        $this->dbforge->drop_column('opera_banco_detalle','nombre_cuenta');
    }
}