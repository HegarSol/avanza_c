<?php
class Migration_Agregar_usuariosE_forma extends CI_Migration{
    public function up()
    {
        $data = array(
            'idForma' => 4,
            'nombrForma' => 'UsuariosE',
            'descripcion' => 'Usuarios',
            'tipo' => 2
        );

        $this->db->insert('formas',$data);
    }
    public function down()
    {
        $this->db->delete('formas',array('idForma' => 4));
    }
}