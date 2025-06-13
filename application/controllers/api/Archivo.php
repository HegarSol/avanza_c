<?php

defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

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
        $this->load->model('BancosModel','bancos');
    }
    public function actualizarpago_post()
    {
        $idpago = $_POST['idpago'];
        $idempre = $_POST['idempre'];

        $this->pagos->set_database($idempre);

        $datos = array('marca_pago' => 1);

        $this->pagos->update_pago_marca($idpago,$datos);
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
    public function traerbancos_get()
    {
        $idempre = $this->get('idempre');

        if($idempre)
        {
            $this->bancos->set_database($idempre);
            $datos = $this->bancos->get_bancos();
            $this->response(array('status' => true, 'data' => $datos));
        }
        else
        {
            $this->response(array('status' => false, 'data' => 'ID de empresa no proporcionado o no existe.'));
        }

    }
    public function insertarapipoliza_post()
    {
        $body = file_get_contents('php://input');

        $object = json_decode($body);

        foreach($object->datos as $valores)
        {
            $this->bancos->set_database($valores->idempre);
            $datosbanco = $this->bancos->getIdbanco($valores->id_banco);
            // var_dump($valores->idempre);
            // var_dump($valores->id_banco);
            // var_dump($valores->fecha);
            // var_dump($valores->cuenta);
            // var_dump($valores->monto);
            // var_dump($valores->usuario);

                   $datos = array(
                        'tipo_mov' => 'D',
                        'no_banco' => $datosbanco[0]['no_banco'],
                        'no_mov' => $datosbanco[0]['depositos']+1,
                        'fecha' => $valores->fecha,
                        'beneficia' => 0,
                        'concepto' => '',
                        'monto' => number_format($valores->monto,2,'.',''),
                        'c_a' => '+',
                        'cobrado' => 1,
                        'cerrado' => 0,
                        'no_prov' => 0,
                        'fechaCobro' => date('Y-m-d'),
                        'impreso' => 0,
                        'afectar' => 0,
                        'bancosat' => '',
                        'bene_ctaban' => '',
                        'tieneCxP_pagos' => 0,
                        'cta_banco' => '',
                        'tipo_proveedor' => ''
                    );
                 // $id = $this->bancos->crearPoliza($datos);
                 if($id > 0)
                 {

                 }
                   
        }

        //$this->response(array('status' => true, 'data' => $object));     
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