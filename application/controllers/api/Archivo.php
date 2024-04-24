<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * API ARCHIVO
 * 
 * Para metodos desde facturacion
 * require la libreria REST_Controller
 */

require APPPATH . 'libraries/REST_Controller.php';

class Archivo extends REST_Controller
{

    public function __construct()
    {
        parent::__construct('rest_api');
        $this->load->model('CuentasModel','cuentas');
    }

    public function insertclientecuenta_post()
    {
        $idempre = $_POST['idempre'];
        $cuenta = $_POST['cuenta'];
        $subcuenta = $_POST['sub_cuenta'];
        $naturaleza = $_POST['naturaleza'];
        $cuentas_sat = $_POST['cuentas_sat'];
        $nombre = $_POST['nombre'];

        $this->cuentas->set_database($idempre);

        $datos = array('cuenta' => $cuenta,
        'sub_cta' => $subcuenta,
        'nombre'=> $nombre,
           'tipo' => $this->input->post('tipo'),
           'ctasat' => $cuentas_sat,
           'natur' => $naturaleza,
           'cvecobro'=> 0,
           'ssub_cta' => 0
        );

        $this->cuentas->crearCuenta($datos);
        
    }
}