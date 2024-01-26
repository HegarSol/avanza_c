<?php
class Migration_Agregar_libro_electronico_menu extends CI_Migration
{
    public function up()
    {
        $data = array(
            'id' => 14,
            'parent' => 2,
            'name' => 'Reporte libro electrónico',
            'icon' => '',
            'slug' => 'reportesm/LibroElectronico/index',
            'number' => 1,
            'nivel' => 1,
            'tipo' => null  
        );
        $this->db->insert('menus',$data);
    }
    public function down()
    {
       $this->db->delete('menus',array('id'=>14));
    }
}