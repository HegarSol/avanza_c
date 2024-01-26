<?php

defined('BASEPATH') or exit("No se permite el acceso directo al archivo");

class ConfiguracionesGenemodel extends MY_Model
{
    private $db2;

    public function __construct()
    {
        parent::__construct(true);
        $this->table = 'configuraciones_general';
        $this->column_order = array('idConfiguracion','descripcion','tipo','valor','parent','inactiva');
        $this->column_search = array('idConfiguracion','descripcion','tipo','valor','parent','inactiva');
        if(isset($_SESSION['idEmpresa']))
        {
           $this->db2 = $this->hegardb->getDatabase($_SESSION['idEmpresa']);
           if(!$this->db2){show_error('No se puede establecer conexion con la base de datos');}
        }
    }

    public function getparent()
    {
        $row = $this->db2->select('*')
        ->from('configuraciones_general')
        ->group_by('parent')
        ->get();
        
        return $row->result_array();
    }

    public function buscarparent($con)
    {
        $row = $this->db2->select('*')
        ->from('configuraciones_general')
        ->where('parent',$con)
        ->get();

        return $row->result_array();
    }
    public function editconf($id,$datos)
    {
        $this->db2->where('id',$id);
        return $this->db2->update('configuraciones_general',$datos);
    }
    public function getcxpprovpropios()
    {
        $row = $this->db2->select('*')
        ->from('configuraciones_general')
        ->where('idConfiguracion','cxp_ManejarSubcuentaXProv')
        ->get();

        return $row->result_array();
    }
    public function getcxpprovterceros()
    {
        $row = $this->db2->select('*')
        ->from('configuraciones_general')
        ->where('idConfiguracion','cxp_ManejarsubcuentaXProvTerc')
        ->get();

        return $row->result_array();
    }
}