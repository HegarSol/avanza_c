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
}