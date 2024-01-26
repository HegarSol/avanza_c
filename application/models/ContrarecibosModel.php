<?php
defined('BASEPATH') or exit("No se permite el acceso directo al archivo");
class ContrarecibosModel extends MY_Model
{
    private $db2;

    public function __construct()
    {
        parent::__construct(true);
        $this->table = 'contrarecibos';
        $this->column_order = array('proveedor','fact','serie','no_contra','fecha','cheque');
        $this->column_search = array('oriveedor','fact','serie','no_contra','fecha','cheque');
        if(isset($_SESSION['idEmpresa'])){
            $this->db2 = $this->hegardb->getDatabase($_SESSION['idEmpresa']);
            if(!$this->db2){show_error('No se puede establecer conexion con la base de datos');}
        }
    }
    public function getall($data)
    {
        $row = $this->db2->select('*')
        ->from('contrarecibos')
        ->where('proveedor',$data)
        ->get();
        return $row->result_array();
    }
    public function getcontrarecbisoget($folio,$seri,$uuid)
    {
        $get = $this->db2->select('*')
        ->from('contrarecibos')
        ->where('fact',$folio)
        ->where('serie',$seri)
        ->where('uuid_contra',$uuid)
        ->get();
        return $get->result_array();
    }
    public function insertarcontra($datos)
    {
        $this->dbEmpresa->insert('contrarecibos',$datos);
        return $this->dbEmpresa->insert_id();
    }
    public function buscarcontrarecibo($foli,$seri,$numpro)
    {
        $row = $this->db2->select('*')
        ->from('contrarecibos')
        ->where('proveedor',$numpro)
        ->where('fact',$foli)
        ->where('serie',$seri)
        ->get();

        return $row->result_array();
    }
}