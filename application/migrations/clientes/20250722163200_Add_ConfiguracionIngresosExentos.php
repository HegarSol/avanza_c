<?php

class Migration_Add_ConfiguracionIngresosExentos extends CI_Migration{
    public function up()
    {
        $data['idcuentaconfi'] = 59;
        $data['descrip'] = 'INGRESOS EXENTOS A CRÉDITO';
        $data['cuenta'] = 0;
        $data['sub_cta'] = 0;
        $data['ssub_cta'] = 0;
        $this->db->insert('configuracion_cuentas',$data);
        
        $data2['idcuentaconfi'] = 60;
        $data2['descrip'] = 'INGRESOS GRAVADOS TASA GENERAL DE CONTADO';
        $data2['cuenta'] = 0;
        $data2['sub_cta'] = 0;
        $data2['ssub_cta'] = 0;
        $this->db->insert('configuracion_cuentas',$data2);

          $data3['idcuentaconfi'] = 61;
        $data3['descrip'] = 'INGRESOS TASA CERO DE CONTADO';
        $data3['cuenta'] = 0;
        $data3['sub_cta'] = 0;
        $data3['ssub_cta'] = 0;
        $this->db->insert('configuracion_cuentas',$data3);
          $data4['idcuentaconfi'] = 62;
        $data4['descrip'] = 'INGRESOS EXENTOS DE CONTADO';
        $data4['cuenta'] = 0;
        $data4['sub_cta'] = 0;
        $data4['ssub_cta'] = 0;
        $this->db->insert('configuracion_cuentas',$data4);
    }
}