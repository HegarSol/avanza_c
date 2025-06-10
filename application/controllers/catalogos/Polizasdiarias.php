<?php

class Polizasdiarias extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('menuModel');
        $items=$this->menuModel->menus($_SESSION['tipo']);
        $this->multi_menu->set_items($items);
        $this->load->view('templates/header');
        $this->load->model('OperacionesModel','opera');
        $this->load->model('Configuraciones_model','configModel');
        $this->load->model('CatalogosModel','cat');
        $this->load->model('PagosModel','pagos');
        $this->load->model('BitacoraModel','bitacora');
    }

    public function index()
    {
        if($this->aauth->is_loggedin())
        {
           $permisos = $this->permisosForma($_SESSION['id'],9);
           if(isset($permisos) && $permisos['leer'] == "1")
           {
                     $data = array('titulo' => 'Pólizas diario', 'permisosGrupo' => $permisos);
                     $this->load->view('templates/navigation',$data);
                     $this->load->view('polizas/index');
                     $this->load->view('templates/footer');
           }
           else
           {
               redirect('welcome','refresh');
           }
        }
        else
        {
            redirect('inicio/login','refresh');
        }
    }
    public function ajax_list()
    {
        $where=array('tipo_mov' => 'O');
        $list = $this->opera->get_datatables($where);

        $data = array();
        foreach($list as $opera)
        {
            $row = array();
            $row[] = $opera->no_mov;
            $row[] = date('d-m-Y',strtotime($opera->fecha));
            $row[] = $opera->concepto;
            $row[] = '<a href="'.base_url().'catalogos/Polizasdiarias/editar/'.$opera->id.'" class="btn btn-primary" title="Editar póliza diaria"><i class="fa fa-pencil-square-o"></i></a>
            <a hrfe="#" onClick="EliminarPolizaDiaria(\''.$opera->id.'\')" class="btn btn-danger" title="Eliminar póliza diaria"><i class="fa fa-times"></i></a> <a href="'.base_url().'Reportes/ReportePolizaDiaria/'.$opera->id.'" target="_blank" class="btn btn-info" title="Imprimir"> <i class="fa fa-print"></i></a>';
            $data[] = $row;
        }
        $output = array(
            'draw' => $this->input->post('draw'),
            'recordsTotal' => $this->opera->count_all(),
            'recordsFiltered' => $this->opera->count_filtered(),
            'data' => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function agregar()
    {
        if($this->aauth->is_loggedin())
        {
            $permisos = $this->permisosForma($_SESSION['id'],9);
            if(isset($permisos) && $permisos['add'] == '1')
            {
                $rfc = $this->configModel->getConfig();
                $formapago = $this->cat->selectformapago();
                $monedas = $this->cat->selectmoneda();
                $max = $this->opera->maxid();
                //$count = $this->opera->existemesdiaria();

                $concecutivo = $max[0]['maxmov'];

              //  var_dump($count);

                $tipo = '4';
                $tipo_letra = 'O';
                $no_banco = 0;

                $CXP = 'BAN';

                // if(count($count) > 0)
                // {
                //     $concecutivo = $max[0]['no_mov'] + 1;
                // }
                // else
                // {
                //     $concecutivo = date('y').date('m').'0001';
                // }


                $data = array('titulo' => 'Nueva póliza diario','tipo_letra' => $tipo_letra,'concecutivo' => $concecutivo,'CXP' => $CXP,'monedas' => $monedas,'formapago' => $formapago,'id' => $no_banco,'tipo' => $tipo,'accion' => 'catalogos/Polizasdiarias/guardarpolizadiaria','permisosGrupo'=> $permisos,'rfc' => $rfc[0]['rfc']);
                $this->load->view('templates/navigation',$data);
                $this->load->view('polizas/polizas');
                $this->load->view('templates/footer');
            }
            else
            {
                redirect('catalogos/polizasdiarias/index','refresh');
            }
        }
        else
        {
            redirect('/inicio/login','refresh');
        }
    }
    public function editar($id)
    {
        if($this->aauth->is_loggedin())
        {
            $permisos = $this->permisosForma($_SESSION['id'],9);
            if(isset($permisos) && $permisos['add'] == '1')
            {
                 $datos=$this->opera->datosOpera($id);
                 $datospoliza=$this->opera->detallepoliza($id);
                 $rfc = $this->configModel->getConfig();
                 $formapago = $this->cat->selectformapago();
                 $monedas = $this->cat->selectmoneda();

                 $montoposito = 0;
                 $montonegati = 0;
                 $totalmontopoliza = 0;

                 $tipo = '4';
                 $letra = 'O';
                 $no_banco = 0;

                 $pagos = $this->pagos->get_pagos_by_movi($datos[0]['no_mov'],$letra);

                 if(count($pagos) > 0)
                 {
                   $pagos_detalle = $this->pagos->get_pagos_detalle($pagos[0]->idPago); 
                   $imppagago = 0;
                   $impdife = 0;
                   $totalPAgo = 0;
                   $saldoinso = 0;
     
                   foreach($pagos_detalle as $pago_row)
                   {
                      $imppagago = $imppagago + $pago_row->impPagado;
                      $impdife = $impdife + $pago_row->c_aPorDiferencia;
                      $totalPAgo = $totalPAgo + $pago_row->totalPago;
                      $saldoinso = $saldoinso + $pago_row->impSaldoInsoluto;
                   }               
                 }
                 else
                 {
                       $pagos_detalle = '';
                       $imppagago = 0;
                       $impdife = 0;
                       $totalPAgo = 0;
                       $saldoinso = 0;
                 }

                 foreach($datospoliza as $dato)
                 {
                    if($dato['c_a'] == '+')
                    {
                       $montoposito = $montoposito + $dato['monto'];
                    }
                    else
                    {
                       $montonegati = $montonegati + $dato['monto'];
                    }
                 }
                 $CXP = 'BAN';
                 $data = array('titulo' => 'Editar póliza diario','tipo_letra' => $letra,'impPagado' => $imppagago,'impDife' => $impdife,'totalPago' => $totalPAgo,'saldoInso' => $saldoinso,'pagos_detalle' => $pagos_detalle,'pagos' => $pagos,'CXP' => $CXP,'monedas' => $monedas,'formapago' => $formapago,'id' => $no_banco,'tipo' => $tipo,'rfc' => $rfc[0]['rfc'] ,'datospoliza' => $datospoliza, 'datos' => $datos,'montonegativo' => $montonegati,'montopositivo' => $montoposito,'totalmontopoliza' => $totalmontopoliza);
                 $this->load->view('templates/navigation',$data);
                 $this->load->view('polizas/polizas');
                 $this->load->view('templates/footer');
            }
            else
            {
                redirect('catalogos/Polizasdiarias/index','refresh');
            }
        }
        else
        {
            redirect('inicio/login','refresh');
        }
    }
    public function eliminar($id)
    {
         if($this->aauth->is_loggedin())
         {

            date_default_timezone_set("America/Mexico_City");

            $datosope = $this->opera->datosOpera($id);


              $res = $this->opera->borrarPoliza($id);
              $res2 = $this->opera->borrarDetalle($id);
              if($res == true && $res2 == true)
              {
                  $crearopera = array('usuario' => $_SESSION['nombreU'],
                                      'tipo_mov' => $datosope[0]['tipo_mov'],
                                      'no_banco' => 0,
                                      'no_mov' => $datosope[0]['no_mov'],
                                      'accion' => 'Eliminar',
                                      'cuando' => date('Y-m-d H:i:s'),
                                      'comentario' => 'Elimino la poliza diaria: '.$datosope[0]['tipo_mov'].' '.$datosope[0]['no_mov'],
                                      'modulo' => 'Catalogos -> Pólizas diarias');
                  $this->bitacora->operacion($crearopera);
                  header('Location: '.base_url()."catalogos/Polizasdiarias/index");
                  exit();
              }
         }
         else
         {
             redirect('/inicio/login','refresh');
         }
    }
    public function guardarpoliza()
    {

        date_default_timezone_set("America/Mexico_City");
        setlocale(LC_TIME, 'es_ES.UTF-8');
        $correcto = false;
        //cabezera poliza

        $id = $this->input->post('id');
        $uuidpoliza = $this->input->post('uuidpoliza');
        $tipo_movimiento = $this->input->post('tipo_movimiento');
        $numero_movimiento = $this->input->post('numero_movimiento');
        $fechapoli = $this->input->post('fechapoli');
        $conceptopoli = $this->input->post('conceptopoli');

        $poliza_contble = $tipo_movimiento.' '.$numero_movimiento;

        $uuidsep = substr($uuidpoliza, 0, -1);

        $uuidsep = explode(',',$uuidsep);

        if($id > 0)
        {
            
        }
        else
        {
            $numero_movimiento = $numero_movimiento;
        }

        
        $datos = array(
            'tipo_mov' => $tipo_movimiento,
            'no_banco' => 0,
            'no_mov' =>  $numero_movimiento,
            'fecha' => $fechapoli,
            'beneficia' => '',
            'concepto' => $conceptopoli,
            'monto' => 0.00,
            'c_a' => '',
            'cobrado' => 0,
            'cerrado' => 0,
            'no_prov' => 0,
            'fechaCobro' => null,
            'impreso' => 0,
            'afectar' => 0,
            'bancosat' => '',
            'bene_ctaban' => '',
            'tieneCxP_pagos' => 0
        );

        if($id > 0)
        {
            $correcto = $this->opera->editarPoliza($id,$datos);
            $crearopera = array('usuario' => $_SESSION['nombreU'],
                                'tipo_mov' => $tipo_movimiento,
                                'no_banco' => 0,
                                'no_mov' => $numero_movimiento,
                                'accion' => 'Modificar',
                                'cuando' => date('Y-m-d H:i:s'),
                                'comentario' => 'Edito la poliza diaria: '.$tipo_movimiento.' '.$numero_movimiento,
                                'modulo' => 'Catalogos -> Pólizas diarias');
             $this->bitacora->operacion($crearopera);
        }
        else
        {
            $id = $this->opera->crearPoliza($datos);
            if($id>0)
            {

                $crearopera = array('usuario' => $_SESSION['nombreU'],
                                    'tipo_mov' => $tipo_movimiento,
                                    'no_banco' => 0,
                                    'no_mov' => $numero_movimiento,
                                    'accion' => 'Agregar',
                                    'cuando' => date('Y-m-d H:i:s'),
                                    'comentario' => 'Creo la poliza diaria: '.$tipo_movimiento.' '.$numero_movimiento,
                                    'modulo' => 'Catalogos -> Pólizas diarias');
                $this->bitacora->operacion($crearopera);
                $correcto = true;

                if($uuidpoliza != '')
                {
                    foreach($uuidsep as $uid)
                    {
                     
                        if(ENVIRONMENT == 'development')
                        {
                            $ch = curl_init("http://localhost:85/git_hub_repo/avanza_buzon_github/api/Comprobantes/poliza_pago");
                        }
                        else
                        {
                            $ch = curl_init("http://avanzab.hegarss.com/api/Comprobantes/poliza_pago");
                        }
                
                
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($ch, CURLOPT_POSTFIELDS, "uuid=".$uid."&fecha=".$fechapoli."&poliza=".$poliza_contble);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        $resu = curl_exec($ch);
                        $response = json_decode($resu);
                     
                    }
                 
                }
            }
        }
        if($correcto == true)
        {
            $this->opera->borrarDetalle($id);

            $tipo_mov = $this->input->post('tipo_mov');

            $no_banco = $this->input->post('no_banco');

            $cuenta = $this->input->post('cuenta');

            $sub_cta = $this->input->post('sub_cta');

            $ssub_cta = $this->input->post('ssub_cta');

            $no_prov_fac = $this->input->post('no_prov_fac');

            $monto = $this->input->post('monto');

            $c_a = $this->input->post('c_a');

            $fecha = $this->input->post('fecha');

            $concepto = $this->input->post('concepto');

            $referencia = $this->input->post('referencia');

            $nombre_cuenta = $this->input->post('nombre_cuenta');

            $mensaje = array();

            for($i=1; $i<count($tipo_mov); $i++)
            {

                $monto[$i] = str_replace(',', '', $monto[$i]);
                $detalle = array(
                    'id_encabezado' => $id,
                    'tipo_mov' => $tipo_mov[$i],
                    'no_banco' => $no_banco[$i],
                    'no_mov' => $numero_movimiento,
                    'ren' => 0,
                    'cuenta' => $cuenta[$i],
                    'sub_cta' => $sub_cta[$i],
                    'monto' => $monto[$i],
                    'c_a' => $c_a[$i],
                    'fecha' => $fecha[$i],
                    'concepto' => $concepto[$i],
                    'referencia' => $referencia[$i],
                    'no_prov' => $no_prov_fac[$i] = '' ? $no_prov_fac[$i] : 0,
                    'factrefe' => 0,
                    'nombre_cuenta' => $nombre_cuenta[$i],
                    'ssub_cta' => $ssub_cta[$i]
                );
                $detalle = $this->opera->guardarDetalle($detalle);
            }

            if($detalle > 0)
            {
                $mensaje[] = array('mensaje' => "Insertado Correctamente");
            }
            else
            {
                $mensaje[] = array('mensaje' => "Hubo un error insertando el detalle de la poliza");
            }
        }
        else
        {
            $mensaje[] = array('mensaje' => 'Error agregando la póliza.');
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($mensaje));
    }
}