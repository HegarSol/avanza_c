<?php
  defined('BASEPATH') or exit("No se permite el acceso directo al archivo");
class CatalogosModel extends CI_Model
{
    public function selectcatcuentas()
    {
        $this->db->select('*');
        $this->db->from('sat_ctg_cuentas');
        $this->db->order_by('descrip','ASC');
        $query=$this->db->get();
        return $query->result_array();
    }
    public function selectctabancos()
    {
        $this->db->select('*');
        $this->db->from('sat_ctg_bancos');
        $query=$this->db->get();
        return $query->result_array();
    }
    public function getctabancos($clavesatbanco)
    {
        $this->db->select('*');
        $this->db->from('sat_ctg_bancos');
        $this->db->where('clave',$clavesatbanco);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function selectformapago()
    {
        $this->db->select('*');
        $this->db->from('sat_formapago');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function selectmoneda()
    {
        $this->db->select('*');
        $this->db->from('c_moneda');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function SelecFormasPagoById($id)
    {
        $this->db->select('*');
        $this->db->from('sat_formapago');
        $this->db->where('c_FormaPago',$id);
        $query=$this->db->get();
        return $query->result_array();
    }
    public function selectprodser($id)
    {
        $this->db->select('*');
        $this->db->from('c_claveprodserv');
        $this->db->where('c_claveProdServ',$id);
        $query=$this->db->get();
        return $query->result_array();
    }
}