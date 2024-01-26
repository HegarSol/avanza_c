<?php
class Migration_Agregar_beneficiario_menu extends CI_Migration{
    public function up()
    {
        $data = array(
            'id' => 8,
            'parent' => 3,
            'name' => 'Beneficiarios',
            'icon' => '',
            'slug' => 'catalogos/Beneficiarios/index',
            'number' => 5,
            'nivel' => 1,
            'tipo' => null
        );
        $this->db->insert('menus',$data);
    }
    public function down()
    {
        $this->db->delete('menus' ,array('id' => 8));
    }
}