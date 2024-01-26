<?php

defined('BASEPATH') or exit("No se permite el acceso directo al archivo");

class BeneficiarioModel extends MY_Model
{
    private $db2;

    public function __construct()
    {
        parent::__construct(true);
        $this->table = 'beneficiario';
        $this->column_order = array('id','no_prov','nombre','rfc','direccion','telefono');
        $this->column_search = array('id','no_prov','nombre','rfc','direccion','telefono');
        if(isset($_SESSION['idEmpresa'])){
            $this->db2 = $this->hegardb->getDatabase($_SESSION['idEmpresa']);
            if(!$this->db2){show_error('No se puede establecer conexion con la base de datos');}
        }
    }
    public function datosBenefi($id)
    {
        $row = $this->db2->select('*')->from('beneficiario')->where('no_prov',$id)->get();
        return $row->result_array();
    }
    public function getNoProv()
    {
        $row = $this->db2->select('*')->from('beneficiario')->order_by('no_prov','desc')->get();
        return $row->result_array();
    }
    public function verificarsiexiste($id)
    {
       $row = $this->db2->select('*')->from('beneficiario')->where('no_prov',$id)->get();
       return $row->result_array();
    }
    public function crearBeneficiario($datos)
    {
        $this->dbEmpresa->insert('beneficiario',$datos);
        return $this->dbEmpresa->insert_id();
    }
    public function EditarBeneficiario($id,$datos)
    {
        $this->db2->where('id',$id);
        return $this->db2->update('beneficiario',$datos);
    }
    public function borrarBenefi($id)
    {
        $this->db2->where('no_prov',$id);
        return $this->db2->delete('beneficiario');
    }
    public function detallebene($id)
    {
        $row = $this->db2->select('*')->from('bancobenefi')->where('no_prov',$id)->get();
        return $row->result_array();
    }
    public function borrarbancoDetalle($id)
    {
        $this->db2->where('no_prov',$id);
        return $this->db2->delete('bancobenefi');
    }
    public function guardarDetalle($detalle)
    {
        $this->db2->insert('bancobenefi',$detalle);
        return 1;
    }
    public function datosbenerfc($rfc)
    {
        $row = $this->db2->select('*')->from('beneficiario')->where('rfc',$rfc)->get();
        return $row->result_array();
    }
}