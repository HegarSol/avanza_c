<?php

defined('BASEPATH') or exit("No se permite el acceso directo");

class BitacoraModel extends MY_Model
{
    public function  __construct()
    {
        parent::__construct(true);
        $this->table = 'bitacora';
        $this->column_order = array('usuario','tipo_mov','no_banco','no_mov','accion','cuando','comentario','modulo');
        $this->column_search = array('usuario','tipo_mov','no_banco','no_mov','accion','cuando','comentario','modulo');
        if(isset($_SESSION['idEmpresa'])){
            $this->db2 = $this->hegardb->getDatabase($_SESSION['idEmpresa']);
            if(!$this->db2){show_error('No se puede establecer conexion con las base de datos');}
        }
    }

    public function operacion($datos)
    {
        $this->dbEmpresa->insert('bitacora',$datos);
        return $this->dbEmpresa->insert_id();
    }
}