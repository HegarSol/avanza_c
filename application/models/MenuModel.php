<?php

class menuModel extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->db2 = $this->hegardb->getDatabase($_SESSION['idEmpresa']);
    }

    public function menus($tipo)
    {
        if($tipo=="SU")
        {
            $nivel = 4;
        }
        if($tipo=="hegar")
        {
            $nivel = 3;
        }
        if($tipo=="admin")
        {
            $nivel = 2;
        }
        if($tipo=="usuario")
        {
            $nivel = 1;
        }

        $this->db->select('*');
        $this->db->from('menus');
        $this->db->where('nivel<=',$nivel);
        $this->db->where('tipo',null);
        $this->db->or_where('tipo','');
        $query=$this->db->get();
        return $query->result_array();
    }
}