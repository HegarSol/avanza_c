<?php

class Migration_Add_data_configuraciones_general extends CI_Migration{
    public function up()
    {
        $data['idConfiguracion'] = 'cxp_ManejarSubcuentaXProv';
        $data['descripcion'] = 'Cuando segenere un pasivo, no se enviara a la subcuenta que este configurada en config (32), sino en la subcuenta que le corresponde a cada proveedor.';
        $data['tipo'] = 'L';
        $data['valor'] = 1;
        $data['parent'] = 'cxp';
        $data['inactiva'] = 0;

        $this->db->insert('configuraciones_general',$data);

        $data2['idConfiguracion'] = 'cxp_ManejarSubcuentaXProvTerc';
        $data2['descripcion'] = 'Cuando se genere un pasivo, no se enviara a la subcuenta que este configurada en config (32), sino en la subcuenta que le corresponde a cada proveedor de PHCC';
        $data2['tipo'] = 'L';
        $data2['valor'] = 0;
        $data2['parent'] = 'cxp';
        $data2['inactiva'] = 0;

        $this->db->insert('configuraciones_general',$data2);
    }
}