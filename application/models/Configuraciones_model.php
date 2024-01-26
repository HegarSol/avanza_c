<?php
defined('BASEPATH') OR exit('No direct script acess allowed');

class Configuraciones_model extends MY_Model{

    private $db2;
    public function __construct()
    {
        parent::__construct(TRUE);
        if(isset($_SESSION['idEmpresa'])){
            $this->db2 = $this->hegardb->getDatabase($_SESSION['idEmpresa']);
            if(!$this->db2){show_error('No se puede establecer conexion con la base de datos');}
         }
    }
    public function get_configuracion_by_id($id_configuracion)
    {
        return $this->dbEmpresa->select(array('valor','tipo'))
        ->from('configuraciones')
        ->where('idConfiguracion',$id_configuracion)
        ->get()
        ->row();
    }
    public function getConfig()
	  {
		 $this->db2->where('id_configuracion',1);
		 $query = $this->db2->get('configuraciones');
		 return $query->result_array();
      }
      public function editConfig($id,$datos)
      {
          $this->db2->where('id_configuracion',1);
          return $this->db2->update('configuraciones',$datos);
      }
      public function setConfig($datos)
      {
          $this->db2->insert('configuraciones',$datos);
          return $this->db2->insert_id();
      }
      public function addPathFile($datos)
      {
          $this->db2->insert('encabe_doctos',$datos);
          return $this->db2->insert_id();
      }
    public function getCorreos()
    {
        $row= $this->dbEmpresa->select('*')->from('correos')->get();
        return $row->result_array();
    }
    public function getDatosCorreo($id)
    {
        $row=$this->dbEmpresa->select('*')->from('correos')->where('idCorreo',$id)->get();
        return $row->result_array();
    }
    public function crearCorreo($datos)
    {
        $this->dbEmpresa->insert('correos',$datos);
        return $this->dbEmpresa->insert_id();
    }
    public function getConfigCuentas()
    {
        $this->dbEmpresa->select('*');
        $this->dbEmpresa->from('configuracion_cuentas');
        $query=$this->dbEmpresa->get();
        return $query->result_array();
    }
    public function getconfigcuenta($valor)
    {
        $row=$this->dbEmpresa->select('*')->from('configuracion_cuentas')->where('idcuentaconfi',$valor)->get();
        return $row->result_array();
    }
    public function guardarconfigcuanta($id,$datos)
    {
           $this->db2->where('idcuentaconfi',$id);
          return $this->db2->update('configuracion_cuentas',$datos);
    }
    public function getConfiguraciones($where='')
    {
        $this->dbEmpresa->select('*');
        $this->dbEmpresa->from('configuraciones');
        if($where!='')
        {
            $this->dbEmpresa->where('idConfiguracion',$where);
        }
        $query=$this->dbEmpresa->get();
        return $query->result_array();
    } 
    public function editarCorreo($id,$datos)
    {
        $this->dbEmpresa->where('idCorreo',$id);
        return $this->dbEmpresa->update('correos',$datos);
    }
    public function updateDefault()
    {
        $datos=array('default'=>'0');
        return $this->dbEmpresa->update('correos',$datos);
    }
    public function borrarCorreo($id)
    {
        $this->dbEmpresa->where('idCorreo',$id);
        return $this->dbEmpresa->delete('correos');
    }
}