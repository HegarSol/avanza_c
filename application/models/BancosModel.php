<?php

defined('BASEPATH') or exit("No se permite el acceso directo al archivo");
class BancosModel extends MY_Model
{
    private $db2;

    public function __construct()
    {
        parent::__construct(true);
        $this->table = 'catalogo_banco';
        $this->column_order = array('id_banco','no_banco','cuenta','banco');
        $this->column_search = array('id_banco','no_banco','cuenta','banco');
        if(isset($_SESSION['idEmpresa'])){
            $this->db2 = $this->hegardb->getDatabase($_SESSION['idEmpresa']);
            if(!$this->db2){show_error('No se puede establecer conexion con la base de datos');}
        }
    }
    public function getBancos()
    {
        $row = $this->db2->select('*')->from('catalogo_banco')->get();
        return $row->result_array();
    }
    public function crearBanco($datos)
    {
        $this->dbEmpresa->insert('catalogo_banco',$datos);
        return $this->dbEmpresa->insert_id();
    }
    public function getbancoctasubcta($cta,$subcta)
    {
        $this->db2->select('*');
        $this->db2->from('catalogo_banco');
        $this->db2->where('cta',$cta);
        $this->db2->where('sub_cta',$subcta);
        $query = $this->db2->get();
        return $query->result_array();
    }
    public function getconciliacion($fechaini,$fechafin,$tipo,$no_banco,$mosmo)
    {
        $this->db2->select('*');
        $this->db2->from('opera_banco_encabe');
        $this->db2->where('fecha >=',$fechaini);
        $this->db2->where('fecha <=',$fechafin);
        $this->db2->where('no_banco',$no_banco);
        if($mosmo == 0)
        {
          $this->db2->where('cobrado',$mosmo);
        }
        if($tipo == 'C')
        {
            $this->db2->where('tipo_mov','C');
        }
        else if($tipo == 'D')
        {
            $this->db2->where('tipo_mov','D');
        }
        else
        {
            $this->db2->where_in('tipo_mov',['D','C','T']);
        }
        $query=$this->db2->get();
        $result = $query->result_array();

        $this->db2->select('SUM(monto) as saldopo');
        $this->db2->from('opera_banco_encabe');
        $this->db2->where('fecha <=',$fechaini);
        $this->db2->where('no_banco',$no_banco);
        $this->db2->where('c_a','+');
        if($tipo == 'C')
        {
            $this->db2->where('tipo_mov','C');
        }
        else if($tipo == 'D')
        {
            $this->db2->where('tipo_mov','D');
        }
        else
        {
            $this->db2->where_in('tipo_mov',['D','C','T']);
        }
        $querypos=$this->db2->get();
        $posito = $querypos->result_array();

        $this->db2->select('SUM(monto) as saldone');
        $this->db2->from('opera_banco_encabe');
        $this->db2->where('fecha <=',$fechaini);
        $this->db2->where('no_banco',$no_banco);
        $this->db2->where('c_a','-');
        if($tipo == 'C')
        {
            $this->db2->where('tipo_mov','C');
        }
        else if($tipo == 'D')
        {
            $this->db2->where('tipo_mov','D');
        }
        else
        {
            $this->db2->where_in('tipo_mov',['D','C','T']);
        }
        $queryneg=$this->db2->get();
        $negativo = $queryneg->result_array();

        $total = $posito[0]['saldopo'] - $negativo[0]['saldone'];

        $dato = array('tipo_mov'=>'','no_banco'=>'','no_mov'=>'','fecha'=>'','beneficia'=>'',
        'concepto'=>'','c_a'=>'','monto'=>'','cobrado'=>'','fechaCobro'=>'','saldoini' => $total);
        array_push($result,$dato);

         return $result;
    }
    public function datosBancos($id)
    {
        $row = $this->db2->select('*')->from('catalogo_banco')->where('no_banco',$id)->get();
        return $row->result_array();
    }
    public function updatepoliza($tipo,$num_ban,$num_mov,$datos)
    {
        $this->db2->where('tipo_mov',$tipo);
        $this->db2->where('no_banco',$num_ban);
        $this->db2->where('no_mov',$num_mov);
        return $this->db2->update('opera_banco_encabe',$datos);        
    }
    public function consecutivocheques($id,$che)
    {
        $this->db2->where('no_banco',$id);
        return $this->db2->update('catalogo_banco',$che);
    }
    public function consecutivodepositos($id,$datos)
    {
        $this->db2->where('no_banco',$id);
        return $this->db2->update('catalogo_banco',$datos);
    }
    public function consecutivosmovimiento($id,$datos)
    {
        $this->db2->where('no_banco',$id);
        return $this->db2->update('catalogo_banco',$datos);
    }
    public function editarBanco($id,$datos)
    {
        $this->db2->where('id_banco',$id);
        return $this->db2->update('catalogo_banco',$datos);
    }
    public function borrarBanco($id)
    {
        $this->db2->where('no_banco',$id);
        return $this->db2->delete('catalogo_banco');
    }
    public function verificarsiexiste($id)
    {
        $row = $this->db2->select('*')->from('catalogo_banco')->where('no_banco',$id)->get();
        return $row->result_array();
    }
    public function get_bancos()
    {
        $this->dbEmpresa->select('*');
        $this->dbEmpresa->from('catalogo_banco');
        $query = $this->dbEmpresa->get();
        return $query->result_array();
    }
    public function getIdbanco($id)
    {
        $this->dbEmpresa->select('*');
        $this->dbEmpresa->from('catalogo_banco');
        $this->dbEmpresa->where('id_banco',$id);
        $query = $this->dbEmpresa->get();
        return $query->result_array();
    }
    public function crearPoliza($datos)
    {
        $this->dbEmpresa->insert('opera_banco_encabe',$datos);
        return $this->dbEmpresa->insert_id();
    }
    public function operacion($datos)
    {
        $this->dbEmpresa->insert('bitacora',$datos);
        return $this->dbEmpresa->insert_id();
    }
    public function guardarDetalle($detalle)
    {
        $this->dbEmpresa->insert('opera_banco_detalle', $detalle);
        return $this->dbEmpresa->insert_id();
    }
    public function actualizarmovimiento($numero_banco,$tipo_movimento,$numero_movimento)
    {
        if($tipo_movimento == 'T')
        {
            $datos = array('movimiento' => $numero_movimento);

            $this->dbEmpresa->where('no_banco',$numero_banco);
            $this->dbEmpresa->update('catalogo_banco',$datos);
        }
        else if($tipo_movimento == "C")
        {
            $datos = array('cheques' => $numero_movimento);

            $this->dbEmpresa->where('no_banco',$numero_banco);
            $this->dbEmpresa->update('catalogo_banco',$datos);
        }
        else
        {
            $datos = array('depositos' => $numero_movimento);

            $this->dbEmpresa->where('no_banco',$numero_banco);
            $this->dbEmpresa->update('catalogo_banco',$datos);
        }
    }
}