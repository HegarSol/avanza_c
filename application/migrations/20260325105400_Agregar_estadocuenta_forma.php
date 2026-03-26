<?php
class Migration_Agregar_estadocuenta_forma extends CI_Migration{
    public function up()
    {
        $data = array(
            'idForma' => 18,
            'nombrForma' => 'estado_cuenta',
            'descripcion' => 'Estado cuenta',
            'tipo' => 1
        );

        $this->db->insert('formas',$data);
    }
    public function down()
    {
        $this->db->delete('formas',array('idForma' => 18));
    }
}