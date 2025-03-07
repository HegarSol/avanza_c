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
        $this->load->model('PagosModel','pagos');
    }
    public function traerpagos_post()
    {
        $clv = $_POST['clv'];
        $idempre = $_POST['idempre'];

        $this->pagos->set_database($idempre);

        $datos = $this->pagos->get_pagos_by_clv($clv);

        $this->response(array('status' => true, 'data' => $datos));
    }
    public function traerpagosrelacionados_post()
    {
        $idpago = $_POST['idpago'];
        $idempre = $_POST['idempre'];

        $this->pagos->set_database($idempre);

        $datos = $this->pagos->get_docto_relacionados_by_pago($idpago);

        if(count($datos) > 0)
        {
            $this->response(array('status' => true, 'data' => $datos));
        }
        else
        {
            $this->response(array('status' => false, 'data' => $datos));
        }

    }
    public function buscarcuentaextranjera_post()
    {
        $idempre = $_POST['idempre'];
        $cuentasat = $_POST['cuentasat'];

        $this->cuentas->set_database($idempre);

        $datos = $this->cuentas->MaxCuentaExNa($cuentasat);

        $this->response(array('status' => true, 'data' => $datos));  
    }
    public function tienecontabilidad_post()
    {
        $idempre = $_POST['idempre'];

       //  $this->cuentas->set_database($idempre);

        $valor = $this->cuentas->datosEmpresa2($idempre);

        if(count($valor) > 0)
        {
            $resul = 1;
        }
        else
        {
            $resul = 0;
        }

        $this->response($resul);  
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

        $dat = $this->cuentas->get_cuenta_existe_empresa($cuenta,$subcuenta);

        if(count($dat) > 0)
        {

        }
        else
        {
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
}