<?php

defined('BASEPATH') or exit("No se permite el acceso directo al archivo");

class PagosModel extends MY_Model
{
    private $db2;

    public function __construct()
    {
        parent::__construct(true);
        $this->table = 'pagos';
        $this->column_order = array('idPago','no_cte','fechaPago','formaDepagoP','moendaP','monto');
        $this->column_search = array('idPago','no_cte','fechaPago','formaDepagoP','moendaP','monto');
        if(isset($_SESSION['idEmpresa'])){
            $this->db2 = $this->hegardb->getDatabase($_SESSION['idEmpresa']);
            if(!$this->db2){show_error('No se puede establecer conexion con la base de datos');}
        }
    }
    public function add_pago($datos)
    {
        $this->dbEmpresa->insert('pagos',$datos);
        return $this->dbEmpresa->insert_id();
    }
    public function get_pagos_by_clv($clv)
    {
         return $this->dbEmpresa->from('pagos')
         ->where('clave_cliente',$clv)
         ->get()
         ->result();
    }
    public function update_pago($idPago,$datos)
    {
        return $this->dbEmpresa->where('idPago',$idPago)
        ->update('pagos',$datos);
    }
    public function delete_pago($id_pago)
    {
        $this->dbEmpresa->where('idPago', $id_pago)
        ->delete('pagos');
        $this->dbEmpresa->where('idPago', $id_pago)
        ->delete('pagos_relacion');
        return $this->dbEmpresa->affected_rows();
    }
    public function get_pagos_by_movi($no_mov,$tipo_mov)
    {
        return $this->dbEmpresa->from('pagos')
        ->where('ban_no_mov', $no_mov)
        ->where('tipo_mov',$tipo_mov)
        ->get()
        ->result();
    }
    public function get_pagos_detalle($id)
    {
       return $this->dbEmpresa->from('pagos_relacion')
       ->where('idPago',$id)
       ->get()
       ->result();
    }
    public function insert_pago_rela($datos)
    {
        $this->dbEmpresa->insert('pagos_relacion', $datos);
        return $this->dbEmpresa->insert_id();
    }
    public function get_docto_relacionados_by_pago($id_pago)
    {
        return $this->dbEmpresa->from('pagos_relacion')
        ->where('idPago', $id_pago)
        ->get()
        ->result();
    }
    public function guardardetalle($datos)
    {
        $this->dbEmpresa->insert('pagos_relacion', $datos);
        return $this->dbEmpresa->insert_id();
    }
    public function borradetalle($id)
    {
        $this->db2->where('idPago',$id);
        return $this->db2->delete('pagos_relacion');
    }
    public function get_pago_by_id($id_pago)
    {
        return $this->dbEmpresa->from('pagos')
        ->where('idPago',$id_pago)
        ->get()
        ->row();
    }
}