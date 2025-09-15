<?php

defined('BASEPATH') or exit("No se permite el acceso direco al archivo");
class ConfigCuentasModel extends MY_Model
{
    private $db2;

    public function __construct()
    {
        parent::__construct(true);
        $this->table = 'configuracion_cuentas';
        $this->column_order = array('idcuentaconfi','cuenta','descrip','sub_cta');
        $this->column_search = array('idcuentaconfi','cuenta','descrip','sub_cta');
        if(isset($_SESSION['idEmpresa'])){
            $this->db2 = $this->hegardb->getDatabase($_SESSION['idEmpresa']);
            if(!$this->db2){show_error('No se puede establecer conexion con la base de datos');}
        }
    }

    public function getidcuentaconfi($id)
    {
        $row = $this->db2->select('*')
        ->from('configuracion_cuentas')
        ->where('idcuentaconfi',$id)
        ->get();
        return $row->result_array();
    }
    public function getcuenta_sub($cta,$sub_cta,$ssub_cta)
    {
        $row = $this->db2->select('*')
        ->from('configuracion_cuentas')
        ->where('cuenta',$cta)
        ->where('sub_cta',$sub_cta)
        ->where('ssub_cta',$ssub_cta)
        ->get();
        return $row->result_array();
    }
    public function getniveles($cta)
    {
        if($cta >= 400 && $cta <= 498)
        {
             return 1;
        }
        else if($cta >= 501 && $cta <= 501)
        {
             return 2;
        }
        else if($cta >= 502 && $cta <= 531)
        {
             return 3;
        }
        else if($cta >= 532 && $cta <= 532)
        {
            return 4;
        }
        else
        {
             return 0;
        }
    }

    public function getnaturaleza($cta)
    {
      $row = $this->db2->select('natur')
        ->from('configuracion_cuentas')
        ->where('natur IS NOT NULL', null, false)
       ->where('cuenta <=',$cta)
       ->where('sub_cta >=',$cta)
        ->get();

        return $row->result_array();
    }

}