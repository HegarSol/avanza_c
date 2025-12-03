<?php
class Migration_Agregar_diccionacontable_forma extends CI_Migration{
    public function up()
    {
        $data = array(
            'idForma' => 17,
            'nombrForma' => 'diccionacontable',
            'descripcion' => 'Diccionario Contable',
            'tipo' => 1
        );

        $this->db->insert('formas',$data);
    }
    public function down()
    {
        $this->db->delete('formas',array('idForma' => 17));
    }
}