<?php

class Migration_Crear_tabla_forma_pago extends CI_Migration{
    public function up()
    {
        $script = "CREATE TABLE `sat_formapago` (
             `c_FormaPago` varchar(3) NOT NULL,
             `descripcion` varchar(100) NULL,
             `bancarizado` varchar(15) NULL,
             `numOperacion` varchar(15) NULL,
             `rfcEmisorCuentasOrdenante` varchar(15) NULL,
             `cuentaOrdenante` varchar(15) NULL,
             `patronCuentaOrdenante` varchar(100) NULL,
             `rfcEmisorCuentaBeneficiario` varchar(15) NULL,
             `cuentaBeneficiario` varchar(15) NULL,
             `patronCuentaBeneficiaria` varchar(100) NULL,
             `tipoCadenaPago` varchar(15) NULL,
             `bancoEmisor` varchar(255) NULL,
             PRIMARY KEY (`c_FormaPago`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->db->query($script);

          $data['c_FormaPago'] = '01';
          $data['descripcion'] = 'Efectivo';
          $data['bancarizado'] = 'No';
          $data['numOperacion'] = 'Opcional';
          $data['rfcEmisorCuentasOrdenante'] = 'No';
          $data['cuentaOrdenante'] = 'No';
          $data['patronCuentaOrdenante'] = 'No';
          $data['rfcEmisorCuentaBeneficiario'] = 'No';
          $data['cuentaBeneficiario'] = 'No';
          $data['patronCuentaBeneficiaria'] = 'No'; 
          $data['tipoCadenaPago'] = 'No'; 
          $data['bancoEmisor'] = 'No';

          $this->db->insert('sat_formapago', $data);

          $data2['c_FormaPago'] = '02';
          $data2['descripcion'] = 'Cheque nominativo';
          $data2['bancarizado'] = 'Si';
          $data2['numOperacion'] = 'Opcional';
          $data2['rfcEmisorCuentasOrdenante'] = 'Opcional';
          $data2['cuentaOrdenante'] = 'Opcional';
          $data2['patronCuentaOrdenante'] = '[0-9]{11}[0-9]{18}';
          $data2['rfcEmisorCuentaBeneficiario'] = 'Opcional';
          $data2['cuentaBeneficiario'] = 'Opcional';
          $data2['patronCuentaBeneficiaria'] = '[0-9]{10,11}|[0-9]{15,16}|[0-9]{18}|[A-Z0-9_]{10,50}'; 
          $data2['tipoCadenaPago'] = 'No'; 
          $data2['bancoEmisor'] = 'Si el RFC del emisor de la cuenta ordenante es XEXX010101000,es';

          $this->db->insert('sat_formapago', $data2);

          $data3['c_FormaPago'] = '03';
          $data3['descripcion'] = 'Transferencia electronica de fondos';
          $data3['bancarizado'] = 'Si';
          $data3['numOperacion'] = 'Opcional';
          $data3['rfcEmisorCuentasOrdenante'] = 'Opcional';
          $data3['cuentaOrdenante'] = 'Opcional';
          $data3['patronCuentaOrdenante'] = '[0-9]{10}|[0-9]{16}|[0-9]{18}';
          $data3['rfcEmisorCuentaBeneficiario'] = 'Opcional';
          $data3['cuentaBeneficiario'] = 'Opcional';
          $data3['patronCuentaBeneficiaria'] = '[0-9]{10}|[0-9]{18}'; 
          $data3['tipoCadenaPago'] = 'Opcional'; 
          $data3['bancoEmisor'] = 'Si el RFC del emisor de la cuenta ordenante es XEXX010101000, es';

          $this->db->insert('sat_formapago', $data3);

          $data4['c_FormaPago'] = '04';
          $data4['descripcion'] = 'Tarjeta de credito';
          $data4['bancarizado'] = 'Si';
          $data4['numOperacion'] = 'Opcional';
          $data4['rfcEmisorCuentasOrdenante'] = 'Opcional';
          $data4['cuentaOrdenante'] = 'Opcional';
          $data4['patronCuentaOrdenante'] = '[0-9]{16}';
          $data4['rfcEmisorCuentaBeneficiario'] = 'Opcional';
          $data4['cuentaBeneficiario'] = 'Opcional';
          $data4['patronCuentaBeneficiaria'] = '[0-9]{10,11}|[0-9]{15,16}|[0-9]{18}|[A-Z0-9_]{10.50}'; 
          $data4['tipoCadenaPago'] = 'No'; 
          $data4['bancoEmisor'] = 'Si el RFC del emisor d ela cuenta ordenante es XEXX010101000, es';

          $this->db->insert('sat_formapago', $data4);

          $data5['c_FormaPago'] = '05';
          $data5['descripcion'] = 'Monedero electronico';
          $data5['bancarizado'] = 'Si';
          $data5['numOperacion'] = 'Opcional';
          $data5['rfcEmisorCuentasOrdenante'] = 'Opcional';
          $data5['cuentaOrdenante'] = 'Opcional';
          $data5['patronCuentaOrdenante'] = '[0-9]{10,11}|[0-9]{18}[A-Z0-9_]{10,50}';
          $data5['rfcEmisorCuentaBeneficiario'] = 'Opcional';
          $data5['cuentaBeneficiario'] = 'Opcional';
          $data5['patronCuentaBeneficiaria'] = '[0-9]{10,11}|[0-9]{18}[A-Z0-9_]{10,50}'; 
          $data5['tipoCadenaPago'] = 'No'; 
          $data5['bancoEmisor'] = 'No';

          $this->db->insert('sat_formapago', $data5);

          $data6['c_FormaPago'] = '06';
          $data6['descripcion'] = 'Dinero electronico';
          $data6['bancarizado'] = 'Si';
          $data6['numOperacion'] = 'Opcional';
          $data6['rfcEmisorCuentasOrdenante'] = 'Opcional';
          $data6['cuentaOrdenante'] = 'Opcional';
          $data6['patronCuentaOrdenante'] = '[0-9]{10,11}';
          $data6['rfcEmisorCuentaBeneficiario'] = 'No';
          $data6['cuentaBeneficiario'] = 'No';
          $data6['patronCuentaBeneficiaria'] = 'No'; 
          $data6['tipoCadenaPago'] = 'No'; 
          $data6['bancoEmisor'] = 'No';

          $this->db->insert('sat_formapago', $data6);

          $data7['c_FormaPago'] = '08';
          $data7['descripcion'] = 'Vales de despensa';
          $data7['bancarizado'] = 'No';
          $data7['numOperacion'] = 'Opcional';
          $data7['rfcEmisorCuentasOrdenante'] = 'No';
          $data7['cuentaOrdenante'] = 'No';
          $data7['patronCuentaOrdenante'] = 'No';
          $data7['rfcEmisorCuentaBeneficiario'] = 'No';
          $data7['cuentaBeneficiario'] = 'No';
          $data7['patronCuentaBeneficiaria'] = 'No'; 
          $data7['tipoCadenaPago'] = 'No'; 
          $data7['bancoEmisor'] = 'No';

          $this->db->insert('sat_formapago', $data7);

          $data8['c_FormaPago'] = '12';
          $data8['descripcion'] = 'Dacion en pago';
          $data8['bancarizado'] = 'No';
          $data8['numOperacion'] = 'No';
          $data8['rfcEmisorCuentasOrdenante'] = 'Opcional';
          $data8['cuentaOrdenante'] = 'No';
          $data8['patronCuentaOrdenante'] = 'No';
          $data8['rfcEmisorCuentaBeneficiario'] = 'No';
          $data8['cuentaBeneficiario'] = 'No';
          $data8['patronCuentaBeneficiaria'] = 'No'; 
          $data8['tipoCadenaPago'] = 'No'; 
          $data8['bancoEmisor'] = 'No';

          $this->db->insert('sat_formapago', $data8);

          $data9['c_FormaPago'] = '13';
          $data9['descripcion'] = 'Pago por subrogacion';
          $data9['bancarizado'] = 'No';
          $data9['numOperacion'] = 'Opcional';
          $data9['rfcEmisorCuentasOrdenante'] = 'No';
          $data9['cuentaOrdenante'] = 'No';
          $data9['patronCuentaOrdenante'] = 'No';
          $data9['rfcEmisorCuentaBeneficiario'] = 'No';
          $data9['cuentaBeneficiario'] = 'No';
          $data9['patronCuentaBeneficiaria'] = 'No'; 
          $data9['tipoCadenaPago'] = 'No'; 
          $data9['bancoEmisor'] = 'No';

          $this->db->insert('sat_formapago', $data9);

          $data10['c_FormaPago'] = '14';
          $data10['descripcion'] = 'Pago por consignacion';
          $data10['bancarizado'] = 'No';
          $data10['numOperacion'] = 'Opcional';
          $data10['rfcEmisorCuentasOrdenante'] = 'No';
          $data10['cuentaOrdenante'] = 'No';
          $data10['patronCuentaOrdenante'] = 'No';
          $data10['rfcEmisorCuentaBeneficiario'] = 'No';
          $data10['cuentaBeneficiario'] = 'No';
          $data10['patronCuentaBeneficiaria'] = 'No'; 
          $data10['tipoCadenaPago'] = 'No'; 
          $data10['bancoEmisor'] = 'No';

          $this->db->insert('sat_formapago', $data10);

          $data11['c_FormaPago'] = '15';
          $data11['descripcion'] = 'Condonacion';
          $data11['bancarizado'] = 'No';
          $data11['numOperacion'] = 'Opcional';
          $data11['rfcEmisorCuentasOrdenante'] = 'No';
          $data11['cuentaOrdenante'] = 'No';
          $data11['patronCuentaOrdenante'] = 'No';
          $data11['rfcEmisorCuentaBeneficiario'] = 'No';
          $data11['cuentaBeneficiario'] = 'No';
          $data11['patronCuentaBeneficiaria'] = 'No'; 
          $data11['tipoCadenaPago'] = 'No'; 
          $data11['bancoEmisor'] = 'No';

          $this->db->insert('sat_formapago', $data11);

          $data12['c_FormaPago'] = '17';
          $data12['descripcion'] = 'Compensacion';
          $data12['bancarizado'] = 'No';
          $data12['numOperacion'] = 'Opcional';
          $data12['rfcEmisorCuentasOrdenante'] = 'No';
          $data12['cuentaOrdenante'] = 'No';
          $data12['patronCuentaOrdenante'] = 'No';
          $data12['rfcEmisorCuentaBeneficiario'] = 'No';
          $data12['cuentaBeneficiario'] = 'No';
          $data12['patronCuentaBeneficiaria'] = 'No'; 
          $data12['tipoCadenaPago'] = 'No'; 
          $data12['bancoEmisor'] = 'No';

          $this->db->insert('sat_formapago', $data12);

          $data13['c_FormaPago'] = '23';
          $data13['descripcion'] = 'Novacion';
          $data13['bancarizado'] = 'No';
          $data13['numOperacion'] = 'Opcional';
          $data13['rfcEmisorCuentasOrdenante'] = 'No';
          $data13['cuentaOrdenante'] = 'No';
          $data13['patronCuentaOrdenante'] = 'No';
          $data13['rfcEmisorCuentaBeneficiario'] = 'No';
          $data13['cuentaBeneficiario'] = 'No';
          $data13['patronCuentaBeneficiaria'] = 'No'; 
          $data13['tipoCadenaPago'] = 'No'; 
          $data13['bancoEmisor'] = 'No';

          $this->db->insert('sat_formapago', $data13);

          $data14['c_FormaPago'] = '24';
          $data14['descripcion'] = 'Confusion';
          $data14['bancarizado'] = 'No';
          $data14['numOperacion'] = 'Opcional';
          $data14['rfcEmisorCuentasOrdenante'] = 'No';
          $data14['cuentaOrdenante'] = 'No';
          $data14['patronCuentaOrdenante'] = 'No';
          $data14['rfcEmisorCuentaBeneficiario'] = 'No';
          $data14['cuentaBeneficiario'] = 'No';
          $data14['patronCuentaBeneficiaria'] = 'No'; 
          $data14['tipoCadenaPago'] = 'No'; 
          $data14['bancoEmisor'] = 'No';

          $this->db->insert('sat_formapago', $data14);
          
          $data15['c_FormaPago'] = '25';
          $data15['descripcion'] = 'Remision de deuda';
          $data15['bancarizado'] = 'No';
          $data15['numOperacion'] = 'Opcional';
          $data15['rfcEmisorCuentasOrdenante'] = 'No';
          $data15['cuentaOrdenante'] = 'No';
          $data15['patronCuentaOrdenante'] = 'No';
          $data15['rfcEmisorCuentaBeneficiario'] = 'No';
          $data15['cuentaBeneficiario'] = 'No';
          $data15['patronCuentaBeneficiaria'] = 'No'; 
          $data15['tipoCadenaPago'] = 'No'; 
          $data15['bancoEmisor'] = 'No';

          $this->db->insert('sat_formapago', $data15);

          $data16['c_FormaPago'] = '26';
          $data16['descripcion'] = 'Prescripcion o caducidad';
          $data16['bancarizado'] = 'No';
          $data16['numOperacion'] = 'Opcional';
          $data16['rfcEmisorCuentasOrdenante'] = 'No';
          $data16['cuentaOrdenante'] = 'No';
          $data16['patronCuentaOrdenante'] = 'No';
          $data16['rfcEmisorCuentaBeneficiario'] = 'No';
          $data16['cuentaBeneficiario'] = 'No';
          $data16['patronCuentaBeneficiaria'] = 'No'; 
          $data16['tipoCadenaPago'] = 'No'; 
          $data16['bancoEmisor'] = 'No';

          $this->db->insert('sat_formapago', $data16);

          $data17['c_FormaPago'] = '27';
          $data17['descripcion'] = 'A satisfaccion del acreedor';
          $data17['bancarizado'] = 'No';
          $data17['numOperacion'] = 'Opcional';
          $data17['rfcEmisorCuentasOrdenante'] = 'No';
          $data17['cuentaOrdenante'] = 'No';
          $data17['patronCuentaOrdenante'] = 'No';
          $data17['rfcEmisorCuentaBeneficiario'] = 'No';
          $data17['cuentaBeneficiario'] = 'No';
          $data17['patronCuentaBeneficiaria'] = 'No'; 
          $data17['tipoCadenaPago'] = 'No'; 
          $data17['bancoEmisor'] = 'No';

          $this->db->insert('sat_formapago', $data17);

          $data18['c_FormaPago'] = '28';
          $data18['descripcion'] = 'Tarjeta de debito';
          $data18['bancarizado'] = 'Si';
          $data18['numOperacion'] = 'Opcional';
          $data18['rfcEmisorCuentasOrdenante'] = 'Opcional';
          $data18['cuentaOrdenante'] = 'Opcional';
          $data18['patronCuentaOrdenante'] = '[0-9]{10,16}';
          $data18['rfcEmisorCuentaBeneficiario'] = 'Opcional';
          $data18['cuentaBeneficiario'] = 'Opcional';
          $data18['patronCuentaBeneficiaria'] = '[0-9]{10,11}|[0-9]{18}[A-Z0-9_]{10,50}'; 
          $data18['tipoCadenaPago'] = 'No'; 
          $data18['bancoEmisor'] = 'Si el RFC del emisor de la cuenta ordenante es XEXX0101000, es';

          $this->db->insert('sat_formapago', $data18);

          $data19['c_FormaPago'] = '29';
          $data19['descripcion'] = 'Tarjeta de servicios';
          $data19['bancarizado'] = 'Si';
          $data19['numOperacion'] = 'Opcional';
          $data19['rfcEmisorCuentasOrdenante'] = 'Opcional';
          $data19['cuentaOrdenante'] = 'Opcional';
          $data19['patronCuentaOrdenante'] = '[0-9]{10,16}';
          $data19['rfcEmisorCuentaBeneficiario'] = 'Opcional';
          $data19['cuentaBeneficiario'] = 'Opcional';
          $data19['patronCuentaBeneficiaria'] = '[0-9]{10,11}|[0-9]{18}[A-Z0-9_]{10,50}'; 
          $data19['tipoCadenaPago'] = 'No'; 
          $data19['bancoEmisor'] = 'Si el RFC del emisor de la cuenta ordenante es XEXX0101000, es';

          $this->db->insert('sat_formapago', $data19);

          $data20['c_FormaPago'] = '30';
          $data20['descripcion'] = 'Aplicacion de anticipos';
          $data20['bancarizado'] = 'No';
          $data20['numOperacion'] = 'Opcional';
          $data20['rfcEmisorCuentasOrdenante'] = 'No';
          $data20['cuentaOrdenante'] = 'No';
          $data20['patronCuentaOrdenante'] = 'No';
          $data20['rfcEmisorCuentaBeneficiario'] = 'No';
          $data20['cuentaBeneficiario'] = 'No';
          $data20['patronCuentaBeneficiaria'] = 'No'; 
          $data20['tipoCadenaPago'] = 'No'; 
          $data20['bancoEmisor'] = 'No';

          $this->db->insert('sat_formapago', $data20);

          $data21['c_FormaPago'] = '99';
          $data21['descripcion'] = 'Por definir';
          $data21['bancarizado'] = 'Opcional';
          $data21['numOperacion'] = 'Opcional';
          $data21['rfcEmisorCuentasOrdenante'] = 'Opcional';
          $data21['cuentaOrdenante'] = 'Opcional';
          $data21['patronCuentaOrdenante'] = 'Opcional';
          $data21['rfcEmisorCuentaBeneficiario'] = 'Opcional';
          $data21['cuentaBeneficiario'] = 'Opcional';
          $data21['patronCuentaBeneficiaria'] = 'Opcional'; 
          $data21['tipoCadenaPago'] = 'Opcional'; 
          $data21['bancoEmisor'] = 'Opcional';

          $this->db->insert('sat_formapago', $data21);
    }
    public function down()
    {
        $this->dbforge->drop_table('sat_formapago',TRUE);
    }
}