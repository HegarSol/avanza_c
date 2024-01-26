<?php
class Migration_Agregar_configuracion_forma extends CI_Migration{
    public function up()
    {
        $data = array(
            'idForma' => 6,
            'nombrForma' => 'Configuracion',
            'descripcion' => 'Configuracion',
            'tipo' => 2
        );

        $this->db->insert('formas',$data);
    }
    public function down()
    {
        $this->db->delete('formas',array('idForma' => 3));
    }
}