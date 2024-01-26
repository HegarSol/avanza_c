<?php

class Migration_Crear_tabla_moneda extends CI_Migration{
    public function up()
    {
        $script = "CREATE TABLE `c_moneda` (
            `c_Moneda` varchar(255) NOT NULL,
            `descripcion` varchar(255) NULL,
            `decimales` varchar(255) NULL,
            `usar` char(1) NULL
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
       $this->db->query($script);

       $data['c_Moneda'] = 'EUR';
       $data['descripcion'] = 'Euro';
       $data['decimales'] = '2';
       $data['usar'] = '1';

       $this->db->insert('c_moneda', $data);

       $data2['c_Moneda'] = 'JPY';
       $data2['descripcion'] = 'Yen';
       $data2['decimales'] = '0';
       $data2['usar'] = '1';

       $this->db->insert('c_moneda', $data2);

       $data3['c_Moneda'] = 'MXN';
       $data3['descripcion'] = 'Peso Mexicano';
       $data3['decimales'] = '2';
       $data3['usar'] = '1';

       $this->db->insert('c_moneda', $data3);

       $data4['c_Moneda'] = 'MXV';
       $data4['descripcion'] = 'Mexico Unidad de Inversion';
       $data4['decimales'] = '2';
       $data4['usar'] = '1';

       $this->db->insert('c_moneda', $data4);

       $data5['c_Moneda'] = 'USD';
       $data5['descripcion'] = 'Dolar americano';
       $data5['decimales'] = '2';
       $data5['usar'] = '1';

       $this->db->insert('c_moneda', $data5);
    } 
    public function down()
    {
        $this->dbforge->drop_table('c_moneda',TRUE);
    } 
}