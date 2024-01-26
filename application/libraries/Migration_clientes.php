<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Libreria para ejecutar las actualizaciones en las bases de datos de los 
 * clientes de manera automatica
 * 
 * Autor: Eduardo Reyes Cuevas
 * Fecha: 06-11-2020
 * 
 */
class Migration_clientes{

    protected $CI;

    public function __construct(){
        $this->CI =& get_instance();

        $id_empresa = $this->CI->session->userdata('idEmpresa');
        if(!$id_empresa){
            return;
        }

        $this->CI->config->load('migration_clientes',TRUE);
        $config = $this->CI->config->item('migration_clientes');

        $configDB = $this->CI->hegardb->getConfig($id_empresa);
        unset($this->CI->db);
        $this->CI->load->database($configDB);
        unset($this->CI->migration);
        $this->CI->load->library('migration',$config,'migration');
        unset($this->CI->db);
        $this->CI->load->database('default');
    }
}