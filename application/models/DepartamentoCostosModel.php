<?php

defined('BASEPATH') or exit("No se permite el acceso directo al archivo");

class DepartamentoCostosModel extends MY_Model
{
    private $db2;

    public function __construct()
    {
        parent::__construct(true);
        $this->table = 'deptos_costos';
        $this->column_order = array('id','clave','descripcion','matriz');
        $this->column_search = array('id','clave','descripcion','matriz');
        if(isset($_SESSION['idEmpresa'])){
            $this->db2 = $this->hegardb->getDatabase($_SESSION['idEmpresa']);
            if(!$this->db2){show_error('No se puede establecer conexion con la base de datos');}
        }
    }
    public function getalldepartamento()
    {
        $row = $this->db2->select('*')->from('deptos_costos')->get();
        return $row->result_array();
    }
    public function datosDepartamento($id)
    {
        $row = $this->db2->select('*')->from('deptos_costos')->where('id',$id)->get();
        return $row->result_array();
    }
    public function insert($data)
    {
        $this->dbEmpresa->insert('deptos_costos', $data);
        return $this->dbEmpresa->insert_id();
    }
    public function update($id, $data)
    {
        $this->db2->where('id', $id);
        return $this->db2->update('deptos_costos', $data);
    }
}