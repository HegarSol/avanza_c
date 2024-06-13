<?php

class Migration_Add_cuenta_nomina_puntualidad extends CI_Migration
{
    public function up()
    {
        $data['cuenta'] = '601';
        $data['descrip'] = 'BONO POR PUNTUALIDAD';
        $data['sub_cta'] = '100';
        $data['ssub_cta'] = '0';

        $this->db->insert('configctanomina', $data);
    }
}