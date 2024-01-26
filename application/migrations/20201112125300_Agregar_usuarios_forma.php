<?php
class Migration_Agregar_usuarios_forma extends CI_Migration{
    public function up()
    {
        $data = array(
            'idForma' => 3,
            'nombrForma' => 'Usuarios',
            'descripcion' => 'UsuariosAdministrativos',
            'tipo' => 3
        );

        $this->db->insert('formas',$data);
    }
    public function down()
    {
        $this->db->delete('formas',array('idForma' => 3));
    }
}