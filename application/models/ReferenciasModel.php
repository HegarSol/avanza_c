<?php

defined('BASEPATH') or exit("No se permite el acceso directo al archivo");

class ReferenciasModel extends MY_Model
{
    private $db2;

    public function __construct()
    {
        parent::__construct(true);
        $this->table = 'referencias';
        $this->column_order = array('id','referencia','descripcion');
        $this->column_search = array('id','referencia','descripcion');
        if(isset($_SESSION['idEmpresa'])){
            $this->db2 = $this->hegardb->getDatabase($_SESSION['idEmpresa']);
            if(!$this->db2){show_error('No se puede establecer conexion con la base de datos');}
        }
    }
    public function getallreferencia()
    {
        $row = $this->db2->select('*')->from('referencias')->get();
        return $row->result_array();
    }
    public function datosReferencia($id)
    {
        $row = $this->db2->select('*')->from('referencias')->where('id',$id)->get();
        return $row->result_array();
    }
    public function insert($data)
    {
        $this->dbEmpresa->insert('referencias', $data);
        return $this->dbEmpresa->insert_id();
    }
    public function update($id, $data)
    {
        $this->db2->where('id', $id);
        return $this->db2->update('referencias', $data);
    }
}