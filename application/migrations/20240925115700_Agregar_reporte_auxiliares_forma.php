<?php
class Migration_Agregar_reporte_auxiliares_forma extends CI_Migration{
    public function up()
    {
        $data = array(
            'idForma' => 12,
            'nombrForma' => 'Reportes_auxiliares',
            'descripcion' => 'Reportes auxiliares',
            'tipo' => 1
        );

        $this->db->insert('formas',$data);
    }
    public function down()
    {
        $this->db->delete('formas',array('idForma' => 12));
    }
}