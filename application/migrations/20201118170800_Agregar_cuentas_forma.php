<?php

class Migration_Agregar_cuentas_forma extends CI_Migration{
    public function up()
    {
        $data = array(
            'idForma' => 7,
            'nombrForma' => 'cuentas',
            'descripcion' => 'Cuentas',
            'tipo' => 1
        );
        $this->db->insert('formas',$data);
    }
    public function down()
    {
        $this->db->delete('formas',array('idForma' => 7));
    }
}