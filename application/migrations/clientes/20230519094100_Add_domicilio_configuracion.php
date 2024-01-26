<?php

class Migration_Add_domicilio_configuracion extends CI_Migration
{
    public function up()
    {
        $campo = array('pais' => array(
            'type' => 'varchar',
            'constraint' => 20,
            'null' => TRUE
        ),
        'estado' => array(
            'type' => 'varchar',
            'constraint' => 30,
            'null' => TRUE
        ),
        'ciudad' => array(
            'type' => 'varchar',
            'constraint' => 30,
            'null' => TRUE
        ),
        'localidad' => array(
            'type' => 'varchar',
            'constraint' => 30,
            'null' => TRUE
        ),
        'cp' => array(
            'type' => 'varchar',
            'constraint' => 10,
            'null' => TRUE
        ),
        'colonia' => array(
            'type' => 'varchar',
            'constraint' => 50,
            'null' => TRUE
        ),
        'calle' => array(
            'type' => 'varchar',
            'constraint' => 100,
            'null' => TRUE
        ),
        'noExt' => array(
            'type' => 'varchar',
            'constraint' => 10,
            'null' => TRUE
        ),
        'noInt' => array(
            'type' => 'varchar',
            'constraint' => 10,
            'null' => TRUE
        ),
        'referencia' => array(
            'type' => 'text',
            'null' => TRUE
        ));
        $this->dbforge->add_column('configuraciones',$campo);
    }
    public function down()
    {

    }
}