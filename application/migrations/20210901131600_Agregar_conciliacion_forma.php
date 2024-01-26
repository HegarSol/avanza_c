<?php
class Migration_Agregar_conciliacion_forma extends CI_Migration{
    public function up()
    {
        $data = array(
            'idForma' => 11,
            'nombrForma' => 'conciliacion',
            'descripcion' => 'Conciliacion',
            'tipo' => 1
        );

        $this->db->insert('formas',$data);
    }
    public function down()
    {
        $this->db->delete('formas',array('idForma' => 11));
    }
}