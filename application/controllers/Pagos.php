<?php
class Pagos extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('menuModel');
        $items=$this->menuModel->menus($_SESSION['tipo']);
        $this->multi_menu->set_items($items);
        $this->load->view('templates/header');
        $this->load->model('PagosModel','pagos');
        $this->load->model('CatalogosModel','cat');
        $this->load->model('Configuraciones_model','configModel');
    }
    public function get_pagos_list()
    {
        $increme = $this->input->post('increme');
        $tipo_letra = $this->input->post('tipo_mov');
        if(!$this->input->is_ajax_request()){
            exit('No direct script access alloew');
          }
        $datos['pagos'] = $this->pagos->get_pagos_by_movi($increme,$tipo_letra);
        $this->load->view('beneficiarios/modales/TablaPagos',$datos);
    }
    public function agrega_docto()
    {
        $id_pago = $this->input->post('id_pago');
        $id_cliente_pago = $this->input->post('id_cliente_pago');
        $serie = $this->input->post('serie');
        $folio = $this->input->post('folio');

        $rfc = $this->configModel->getConfig();
       
       // $ch = curl_init("http://localhost:85/facturacioncfdi/api/Conta/get_docto?id_pago=".$id_pago.'&id_cliente_pago='.$id_cliente_pago.'&serie='.$serie.'&folio='.$folio.'&rfc='.$rfc[0]['rfc']);
        $ch = curl_init("https://avanzaf.hegarss.com/api/Conta/get_docto?id_pago=".$id_pago.'&id_cliente_pago='.$id_cliente_pago.'&serie='.$serie.'&folio='.$folio.'&rfc='.$rfc[0]['rfc']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $resu = curl_exec($ch);

        $response = json_decode($resu);

       if($response->status == false)
       {
           $data = array(
               'success' => FALSE,
               'error' => $response->data
           );
       }
       else
       {
            $data = array(
                'success' => TRUE,
                'data' => $response->data
            );
       }


        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    public function delete_pago()
    {
        $id_pago = $this->input->post('id_pago');
        if(!$this->input->is_ajax_request()){
            exit('No direct script access allowed');
          }
          $this->pagos->delete_pago($id_pago);
          echo json_encode([
                'success' => true
            ]);
            exit();
        //   echo json_encode(['success' => TRUE]);
    }
    public function edit_pago()
    {
        
        if(!$this->input->is_ajax_request()){
            exit('No direct script access allowed');
          }
          $id_pago = $this->input->post('id_pago');
          $pago = $this->pagos->get_pago_by_id($id_pago);
          if($pago){
            echo json_encode(['status' => TRUE, 'pago' => $pago]);
            exit();
          }
          echo json_encode([
            'status' => FALSE,
          ]);
    }
    public function get_doctos()
    {
        $id_pago = $this->input->get('id_pago');
        if(!$this->input->is_ajax_request()){
            exit('No direct script access allowed');
          }
//          var_dump($id_pago);
        $data['doctos'] = $this->pagos->get_docto_relacionados_by_pago($id_pago);
         $data['pago'] = $this->pagos->get_pago_by_id($id_pago);
         $this->load->view('beneficiarios/modales/TablaDoctos', $data);
    }
    public function insertpago()
    {
        if(!$this->input->is_ajax_request()){
            exit('No direct script access allowed');
          }
        date_default_timezone_set("America/Mexico_City");
         setlocale(LC_TIME, 'es_ES.UTF-8');

        $nombre = $this->input->post('nombre_cliente_pago');
        $clave = $this->input->post('clave');
        $id_cliente = $this->input->post('id_cliente_pago');
        $rfc_pago = $this->input->post('rfc_pago');
        $idPago = $this->input->post('id_pago');
        $fecha_pago = $this->input->post('fecha_pago');
        $forma_pago = $this->input->post('forma_pago');
        $moneda = $this->input->post('moneda');
        $tipocambio = $this->input->post('tipoCambio');
        $monto = $this->input->post('monto');
        $numopera = $this->input->post('numopera');
        $ctaordenante = $this->input->post('ctaOrdenante');
        $rfcemisorctaord = $this->input->post('rfcemisorctaord');
        $nombancoord = $this->input->post('nombancoord');
        $rfcemisorctaben = $this->input->post('rfcemisorctaben');
        $ctabenefici = $this->input->post('ctabenefici');
        $tipocadpago = $this->input->post('tipocadpago');
        $certpago = $this->input->post('certpago');
        $cadpago = $this->input->post('cadpago');
        $sellopago = $this->input->post('sellopago');
        $tipo_movimiento = $this->input->post('tipo_movimiento');
        $no_banco = $this->input->post('no_banco');
        $no_mov = $this->input->post('no_mov');


        $patrones=$this->cat->SelecFormasPagoById($forma_pago);


        if($fecha_pago == null)
        {
           echo json_encode(
               [
                    'success' => false,
                    'mensaje' => 'Introdusca la Fecha de Pago.'
               ]
               );
               exit();
        }
        if($forma_pago == null)
        {
            echo json_encode(
                [
                    'success' => false,
                    'mensaje' => 'Seleccione la forma de pago'
                ]
               );
               exit();
        }
        if($moneda != 'MXN')
        {
                    echo json_encode(
                   [
                       'success' => false,
                       'mensaje' => 'El Tipo de Cambio es obligatorio'
                   ]
               );
               exit();
        }
        if($monto == null)
        {
            echo json_encode(
                [
                'success' => false,
                'mensaje' => 'El campo Monto es obligatorio.'
                ]
              );
              exit();
        }
        if($ctaordenante != null)
        {
            if(!preg_match('/^'.$patrones[0]['patronCuentaOrdenante'].'$/',$ctaordenante))
            {
               $a = $patrones[0]['patronCuentaOrdenante'];
               if($patrones[0]['patronCuentaOrdenante']==0)
               {
                  $patrones[0]['patronCuentaOrdenante'] = "La cuenta no debe registrarse";
               }
               echo json_encode(
                   [
                       'success' => false,
                       'mensaje' => 'La cuenta ordenante no cuenta con el patrón correcto( Patrón:'.$patrones[0]['patronCuentaOrdenante'].')'
                   ]
               );
               exit();
            }
        }
        if($ctabenefici != null)
        {
            if(!preg_match('/^'.$patrones[0]['patronCuentaBeneficiaria'].'$/',$ctabenefici))
            {
                if($patrones[0]['patronCuentaBeneficiaria'] == 0)
                {
                   $patrones[0]['patronCuentaBeneficiaria'] = 'La cuenta no debe registrarse';
                }

                echo json_encode(
                    [
                        'success' => false,
                        'mensaje' => 'La cuenta beneficiaro no cuenta con el patrón correcto( Patrón:'.$patrones[0]['patronCuentaBeneficiaria'].')'
                    ]
                );
                exit();
            }
        }

        $datos['no_cte'] = $id_cliente;
        $datos['nombre_cliente'] = $nombre;
        $datos['fechaPago'] = date($fecha_pago.' H:i:s');
        $datos['rfc_pago'] = $rfc_pago;
        $datos['formaDepagoP'] = $forma_pago;
        $datos['monedaP'] = $moneda; 
        $datos['tipoCambioP'] = empty($tipocambio) ? '0.00' : $tipocambio;
        $datos['monto'] = $monto;
        $datos['numOperacion'] = $numopera;
        $datos['rfcEmisorCtaOrd'] = $rfcemisorctaord;
        $datos['nomBancoOrdExt'] = $nombancoord;
        $datos['ctaOrdenante'] = $ctaordenante;
        $datos['rfcEmisorCtaBen'] = $rfcemisorctaben;
        $datos['ctaBeneficiario'] = $ctabenefici;
        $datos['tipoCadPago'] = $tipocadpago;
        $datos['certPago'] = $certpago;
        $datos['cadPago'] = $cadpago;
        $datos['selloPago'] = $sellopago;
        $datos['serie'] = 'P';
        $datos['no_mov'] = 1;
        $datos['tipo_mov'] = $tipo_movimiento;
        $datos['no_banco'] = $no_banco;
        $datos['ban_no_mov'] = $no_mov;
        $datos['selec'] = 1;
        $datos['clave_cliente'] = $clave;

        if($idPago > 0)
        {
            $success = $this->pagos->update_pago($idPago,$datos);
            $correcto = true;
        }
        else
        {
            $idPago = $this->pagos->add_pago($datos);
            if($idPago>0)
            {
                $correcto = true;
            }
        }
        if($correcto == true)
        {

            $this->pagos->borradetalle($idPago);

            $tipo = $this->input->post('tipo');
            $serie = $this->input->post('serie');
            $folio = $this->input->post('folio');
            $referencia = $this->input->post('referencia');
            $uuid = $this->input->post('uuid');
            $monedaP = $this->input->post('monedaP');
            $tipo_cambio = $this->input->post('tipo_cambio');
            $metodo = $this->input->post('metodo');
            $saldo = $this->input->post('saldo');
            $parc = $this->input->post('parc');
            $pago = $this->input->post('pago');
            $difimporte = $this->input->post('difimporte');
            $total_pago = $this->input->post('total_pago');
            $saldo_inso = $this->input->post('saldo_inso');

    
            $mensaje=array();
    
            for($i=1;$i<count($tipo); $i++)
            {
               $detalle = array(
                   'idPago' => $idPago,
                   'uuid' => $uuid[$i],
                   'serie' => $serie[$i],
                   'folio' => $folio[$i],
                   'monedaDR' => $monedaP[$i],
                   'tipoCambioDR' => empty($tipo_cambio[$i]) ? 0.00 : $tipo_cambio[$i],
                   'metodoDePagoDR' => $metodo[$i],
                   'numParcialidad' => $parc[$i],
                   'impSaldoAnt' => $saldo[$i],
                   'impPagado' => $pago[$i],
                   'impSaldoInsoluto' => $saldo_inso[$i],
                   'referencia' => $referencia[$i],
                   'tipo' => $tipo[$i],
                   'c_aPorDiferencia' => $difimporte[$i],
                   'totalPago' => $total_pago[$i],
                   't_cFactura' => $tipo_cambio[$i],
                   'no_cte' => $id_cliente
               );
                $detalle2 = $this->pagos->guardardetalle($detalle);
            }

            if($detalle2 > 0)
            {
                echo json_encode(['success' => true, 'mensaje' => 'Insertado correctamente']);
                exit();
            }
            else
            {
                echo json_encode(['success' => false, 'mensaje' => 'Hubo un error insertando el detalle del pago']);
                exit();
            }
        }
        else
        {
            echo json_encode(['success' => false, 'mensaje' => 'Hubo un error al querer crear el pago']);
            exit();
        }

    }
}