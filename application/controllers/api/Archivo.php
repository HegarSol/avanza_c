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
    public function actuzaliarpago_post()
    {
        $idempre = $_POST['idempre'];
        $referecnia = $_POST['referencia'];
        
        $this->bancos->set_database($idempre);

        $datos = $this->bancos->actualizar_pagado($idempre,$referencia);
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
    public function getasientocontable_get()
    {
        $idempre = $this->get('idempre');
        $concurso = $this->get('concurso');

         if($idempre)
        {
            $this->bancos->set_database($idempre);
            $datos = $this->bancos->get_asientoByConcurso($idempre,$concurso);
            if(count($datos) > 0)
            {
                $this->response(array('status' => true, 'data' => $datos));
            }
            else
            {
                $this->response(array('status' => false, 'data' => 'No se encontraron asientos contables para el concurso proporcionado.'));
            }
        }
        else
        {
            $this->response(array('status' => false, 'data' => 'ID de empresa no proporcionado o no existe.'));
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
    public function traercuentas_get()
    {
        $idempre = $this->get('idempre');
        $cuentamyor = $this->get('cuentamayor');

        if($idempre)
        {
            $this->cuentas->set_database($idempre);
            $datos = $this->cuentas->getCuentastodosEmpresa($cuentamyor);
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

            $mov = $datosbanco[0]['depositos']+1;

                   $datos = array(
                        'tipo_mov' => 'D',
                        'no_banco' => $datosbanco[0]['no_banco'],
                        'no_mov' => $mov,
                        'fecha' => $valores->fecha,
                        'beneficia' => '',
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
                  //  $id= 1;
                  $id = $this->bancos->crearPoliza($datos);
                 if($id > 0)
                 {

                   $this->bancos->actualizarmovimiento($datosbanco[0]['no_banco'],'D',$mov);
                       $detalle = array(
                            'id_encabezado' => $id,
                            'tipo_mov' => 'D',
                            'no_banco' => $datosbanco[0]['no_banco'],
                            'no_mov' => $mov,
                            'ren' => 0,
                            'cuenta' => $datosbanco[0]['cta'],
                            'sub_cta' => $datosbanco[0]['sub_cta'],
                            'monto' => $valores->monto,
                            'c_a' => '+',
                            'fecha' => $valores->fecha,
                            'concepto' => '',
                            'referencia' => $valores->concurso,
                            'no_prov' => 0,
                            'factrefe' => 0,
                            'nombre_cuenta' => $datosbanco[0]['banco'],
                            'ssub_cta' => $datosbanco[0]['ssub_cta']
                        );

                     //   $detalle = 1;
                      $detalle= $this->bancos->guardarDetalle($detalle);

                     $detalle2 = array(
                            'id_encabezado' => $id,
                            'tipo_mov' => 'D',
                            'no_banco' => $datosbanco[0]['no_banco'],
                            'no_mov' => $mov,
                            'ren' => 0,
                            'cuenta' => 103,
                            'sub_cta' => 1,
                            'monto' => $valores->monto,
                            'c_a' => '-',
                            'fecha' => $valores->fecha,
                            'concepto' => '',
                            'referencia' => $valores->concurso,
                            'no_prov' => 0,
                            'factrefe' => 0,
                            'nombre_cuenta' => 'CLIENTES DIVERSOS',
                            'ssub_cta' => 9990
                        );
                    $detalle2= $this->bancos->guardarDetalle($detalle2);
                   //   $detalle2 = 1;

                      if($detalle > 0 && $detalle2 > 0)
                      {

                            $crearopera = array('usuario' => $valores->usuario,
                                   'tipo_mov' => 'D',
                                   'no_banco' => $datosbanco[0]['no_banco'],
                                   'no_mov' => $mov, 
                                   'accion' => 'Agregar', 
                                   'cuando' => date('Y-m-d H:i:s'), 
                                   'comentario' => 'Creo la operacion de tipo: '.$mov.' del numero de banco: '.$datosbanco[0]['no_banco'].' del movimiento: D',
                                   'modulo' => 'Api');
                            $this->bancos->operacion($crearopera);

                        $ret = 1;

                      }
                      else
                      {
                        $ret = 2;
                      }
                 }
                 else
                 {
                      $ret = 3;
                 }
                   
        }

        if($ret == 1)
        {
            $this->response(array('status' => true, 'data' => 'Póliza guardada correctamente.'));
        }
        else if($ret == 2)
        {
            $this->response(array('status' => false, 'data' => 'Error al crear la poliza detalle.'));
        }
        else if($ret == 3)
        {
            $this->response(array('status' => false, 'data' => 'Error al crear la poliza encabezado.'));
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
        $ssubcuenta = $_POST['ssub_cuenta'];
        $naturaleza = $_POST['naturaleza'];
        $cuentas_sat = $_POST['cuentas_sat'];
        $nombre = $_POST['nombre'];

        $this->cuentas->set_database($idempre);

        $dat = $this->cuentas->get_cuenta_existe_empresa($cuenta,$subcuenta,$ssubcuenta);

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
               'ssub_cta' => $ssubcuenta,
            );
    
            $this->cuentas->crearCuenta($datos);
        }
    }
}