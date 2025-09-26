<?php


class Migration_Crear_indice_referencia extends CI_Migration{
    public function up()
    {
        $this->db->query('CREATE INDEX idx_referencia ON opera_banco_detalle (referencia);');
    }
    public function down()
    {

    }

}