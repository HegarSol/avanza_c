<?php

defined('BASEPATH') or exit("No se permite el acceso directo");

class BancoBenefeModel extends MY_Model
{
    private $db2;

    public function __construct()
    {
        parent::__construct(true);
        $this->table = 'bancobenefi';
        $this->column_order = array('no_prov','ctaBan','bancoSat','ctaClabe','nombre');
        $this->column_search = array('no_prov','ctaBan','bancoSat','ctaClabe','nombre');
        if(isset($_SESSION['idEmpresa'])){
            $this->db2 = $this->hegardb->getDatabase($_SESSION['idEmpresa']);
            if(!$this->db2){show_error('No se puede establecer conexion con la base de datos');}
        }
    }
    
}