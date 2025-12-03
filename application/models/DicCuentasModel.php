<?php
defined('BASEPATH') or exit("No se permite el acceso directo al archivo");
class DicCuentasModel extends MY_model
{
    private $db2;

    public function __construct()
    {
        parent::__construct(true);
        $this->table = 'dicconta';
        $this->column_order = array('cuenta','sub_cta','ssub_cta');
        $this->column_search = array('codigoSAT','cuenta','sub_cta','ssub_cta');
        if(isset($_SESSION['idEmpresa'])){
            $this->db2 = $this->hegardb->getDatabase($_SESSION['idEmpresa']);
            if(!$this->db2){show_error('No se puede establecer conexion con la base de datos');}
        }
    }

    public function buscariguales($cuenta)
    {
        $row = $this->db2->select('*')->from('dicconta')->where('codigoSAT',$cuenta)->get();
        return $row->result_array();
    }
    public function insertdiccionario($datos)
    {
        $this->dbEmpresa->insert('dicconta',$datos);
        return $this->dbEmpresa->insert_id();
    }
    public function editarCuenta($id,$datos)
    {
        $this->dbEmpresa->where('id',$id);
        $this->dbEmpresa->update('dicconta',$datos);
    }
}