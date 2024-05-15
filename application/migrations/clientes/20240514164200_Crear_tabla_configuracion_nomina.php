<?php

class Migration_Crear_tabla_configuracion_nomina extends CI_Migration{
    public function up()
    {
        $script = "CREATE TABLE `configctanomina` (
            `idctanomina` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `cuenta` varchar(10) DEFAULT NULL,
            `descrip` varchar(200) DEFAULT NULL,
            `sub_cta` varchar(10) DEFAULT NULL,
            `ssub_cta` varchar(10) DEFAULT NULL,
            PRIMARY KEY (`idctanomina`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
        $this->db->query($script);

        $data['cuenta'] = '601';
        $data['descrip'] = 'SUELDOS';
        $data['sub_cta'] = '5';
        $data['ssub_cta'] = '0';

        $this->db->insert('configctanomina', $data);

        $data2['cuenta'] = '601';
        $data2['descrip'] = 'AGUINALDOS';
        $data2['sub_cta'] = '10';
        $data2['ssub_cta'] = '0';

        $this->db->insert('configctanomina', $data2);

        $data3['cuenta'] = '601';
        $data3['descrip'] = 'VACACIONES';
        $data3['sub_cta'] = '7';
        $data3['ssub_cta'] = '0';

        $this->db->insert('configctanomina', $data3);

        $data4['cuenta'] = '601';
        $data4['descrip'] = 'OTRAS PERCEPCIONES POR SUELDOS';
        $data4['sub_cta'] = '6';
        $data4['ssub_cta'] = '0';

        $this->db->insert('configctanomina', $data4);

        $data5['cuenta'] = '601';
        $data5['descrip'] = 'INDEMNIZACIONES';
        $data5['sub_cta'] = '8';
        $data5['ssub_cta'] = '0';

        $this->db->insert('configctanomina', $data5);

        $data6['cuenta'] = '601';
        $data6['descrip'] = 'P.T.U';
        $data6['sub_cta'] = '9';
        $data6['ssub_cta'] = '0';

        $this->db->insert('configctanomina', $data6);

        $data7['cuenta'] = '601';
        $data7['descrip'] = 'PRIMA VACACIONAL';
        $data7['sub_cta'] = '59';
        $data7['ssub_cta'] = '0';

        $this->db->insert('configctanomina', $data7);

        $data8['cuenta'] = '201';
        $data8['descrip'] = 'ISPT POR PAGAR';
        $data8['sub_cta'] = '1';
        $data8['ssub_cta'] = '0';

        $this->db->insert('configctanomina', $data8);

        $data9['cuenta'] = '201';
        $data9['descrip'] = 'IMSS POR PAGAR';
        $data9['sub_cta'] = '2';
        $data9['ssub_cta'] = '0';

        $this->db->insert('configctanomina', $data9);

        $data10['cuenta'] = '201';
        $data10['descrip'] = 'RETENCION INFONAVIT';
        $data10['sub_cta'] = '10';
        $data10['ssub_cta'] = '0';

        $this->db->insert('configctanomina', $data10);
    }
}