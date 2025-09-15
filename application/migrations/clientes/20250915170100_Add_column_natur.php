<?php
class Migration_Add_column_natur extends CI_Migration
{
    public function up()
    {
       $campo = array('natur' => array(
          'type' => 'char',
          'constraint' => 1,
          'null' => NULL
       ));
       $this->dbforge->add_column('configuracion_cuentas',$campo);
       //update existing records to have a default value
         $this->db->query("UPDATE configuracion_cuentas SET natur = 'D' WHERE idcuentaconfi = 17");
         $this->db->query("UPDATE configuracion_cuentas SET natur = 'D' WHERE idcuentaconfi = 18");
         $this->db->query("UPDATE configuracion_cuentas SET natur = 'A' WHERE idcuentaconfi = 19");
         $this->db->query("UPDATE configuracion_cuentas SET natur = 'A' WHERE idcuentaconfi = 20");
         $this->db->query("UPDATE configuracion_cuentas SET natur = 'D' WHERE idcuentaconfi = 21");
         $this->db->query("UPDATE configuracion_cuentas SET natur = 'A' WHERE idcuentaconfi = 22");
         $this->db->query("UPDATE configuracion_cuentas SET natur = 'A' WHERE idcuentaconfi = 24");
         $this->db->query("UPDATE configuracion_cuentas SET natur = 'D' WHERE idcuentaconfi = 25");
         $this->db->query("UPDATE configuracion_cuentas SET natur = 'D' WHERE idcuentaconfi = 26");
         $this->db->query("UPDATE configuracion_cuentas SET natur = 'D' WHERE idcuentaconfi = 27");

    }
    public function down()
    {
        $this->dbforge->drop_column('configuracion_cuentas','natur');
    }
}