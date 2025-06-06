<?php
class Bancos extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('menuModel');
        $items=$this->menuModel->menus($_SESSION['tipo']);
        $this->multi_menu->set_items($items);
        $this->load->view('templates/header');
        $this->load->model('BancosModel','bancos');
        $this->load->model('CatalogosModel','cat');
        $this->load->model('PagosModel','pagos');
        $this->load->model('OperacionesModel','opera');
        $this->load->model('BeneficiarioModel','benefi');
        $this->load->model('Configuraciones_model','configModel');
        $this->load->model('BitacoraModel','bitacora');
        $this->load->model('ConfigCuentasModel','conficta');
        $this->load->model('CuentasModel','cuentas');
        //$this->load->helper('hegarss');
    }

    public function index()
    {
        $permisos = $this->permisosForma($_SESSION['id'],1);
        if(isset($permisos) && $permisos['leer']=="1")
        {
            if($this->aauth->is_loggedin())
            {
                $errores=array();
                $permisos=$this->permisosForma($_SESSION['id'],1);
                $data=array('titulo'=>'Bancos','razon'=>$this->validaempresas->get_razon($_SESSION['idEmpresa']),'errores'=>$errores,'permisosGrupo'=>$permisos);
                $items=$this->menuModel->menus($_SESSION['tipo']);
                $this->multi_menu->set_items($items);
                $this->load->view('templates/header');
                $this->load->view('templates/navigation',$data);
                $this->load->view('bancos/index');
                $this->load->view('templates/footer');
            }
            else
            {
                redirect('/inicio/login','refresh');
            }
        }
        else
        {
            show_error('No tiene permiso para entrar a bancos');
        }
    }
    public function buscar_factu()
    {
       
        $datos = $this->input->post('dato');
        $no_pro = $this->input->post('no_prov');
        $poli = $this->input->post('poli');
   
        $datas = [];

            if($poli != '')
            {
                $int = (int) filter_var($poli, FILTER_SANITIZE_NUMBER_INT);
             
                $valor = $this->opera->traerpolizaprovisiondetalle($int);

                foreach($valor as $as)
                {

                    $algo = $this->conficta->getcuenta_sub($as['cuenta'],$as['sub_cta'],$as['ssub_cta']);
                
                    if(count($algo) > 0)
                    {
                         if($algo[0]['idcuentaconfi'] == 28)
                         {
                             $contra = $this->conficta->getidcuentaconfi(6);
                             $datas[] = [
                                'cuenta' => $as['cuenta'],
                                'sub_cta' => $as['sub_cta'],
                                'ssub_cta' => $as['ssub_cta'],
                                'nombre_cta' => $as['nombre_cuenta'],
                                'importe' => $as['monto'],
                                'c_a' => $as['c_a'],

                            ];

                            $cosas = array('cuenta' => $contra[0]['cuenta'],
                                           'sub_cta' => $contra[0]['sub_cta'],
                                           'ssub_cta' => $contra[0]['ssub_cta'],
                                        'nombre_cta' => $contra[0]['descrip'],
                                        'importe' => $as['monto'],
                                          'c_a' => $as['c_a'] == '+' ? '-' : '+');

                            array_push($datas, $cosas);
                         }
                         else if($algo[0]['idcuentaconfi'] == 38)
                         {
                             $contra = $this->conficta->getidcuentaconfi(37);
                             $datas[] = [
                                'cuenta' => $as['cuenta'],
                                'sub_cta' => $as['sub_cta'],
                                'ssub_cta' => $as['ssub_cta'],
                                'nombre_cta' => $as['nombre_cuenta'],
                                'importe' => $as['monto'],
                                'c_a' => $as['c_a']
                            ];

                            $cosas = array('cuenta' => $contra[0]['cuenta'],
                                           'sub_cta' => $contra[0]['sub_cta'],
                                           'ssub_cta' => $contra[0]['ssub_cta'],
                                        'nombre_cta' => $contra[0]['descrip'],
                                        'importe' => $as['monto'],
                                          'c_a' => $as['c_a'] == '+' ? '-' : '+');

                            array_push($datas, $cosas);
                         }
                         else if($algo[0]['idcuentaconfi'] == 33)
                         {
                             $contra = $this->conficta->getidcuentaconfi(30);
                             $datas[] = [
                                'cuenta' => $as['cuenta'],
                                'sub_cta' => $as['sub_cta'],
                                'ssub_cta' => $as['sub_cta'],
                                'nombre_cta' => $as['nombre_cuenta'],
                                'importe' => $as['monto'],
                                'c_a' => $as['c_a']
                            ];

                            $cosas = array('cuenta' => $contra[0]['cuenta'],
                                           'sub_cta' => $contra[0]['sub_cta'],
                                           'ssub_cta' => $contra[0]['ssub_cta'],
                                        'nombre_cta' => $contra[0]['descrip'],
                                        'importe' => $as['monto'],
                                          'c_a' => $as['c_a'] == '+' ? '-' : '+');

                            array_push($datas, $cosas);
                            
                         }
                         else if($algo[0]['idcuentaconfi'] == 46)
                         {
                              $contra = $this->conficta->getidcuentaconfi(41);
                              $datas[] = [
                                'cuenta' => $as['cuenta'],
                                'sub_cta' => $as['sub_cta'],
                                'ssub_cta' => $as['ssub_cta'],
                                'nombre_cta' => $as['nombre_cuenta'],
                                'importe' => $as['monto'],
                                'c_a' => $as['c_a']
                            ];

                            $cosas = array('cuenta' => $contra[0]['cuenta'],
                                           'sub_cta' => $contra[0]['sub_cta'],
                                           'ssub_cta' => $contra[0]['ssub_cta'],
                                        'nombre_cta' => $contra[0]['descrip'],
                                        'importe' => $as['monto'],
                                          'c_a' => $as['c_a'] == '+' ? '-' : '+');

                            array_push($datas, $cosas);
                         }
                         else if($algo[0]['idcuentaconfi'] == 34)
                         {
                              $contra = $this->conficta->getidcuentaconfi(31);
                              $datas[] = [
                                'cuenta' => $as['cuenta'],
                                'sub_cta' => $as['sub_cta'],
                                'ssub_cta' => $as['ssub_cta'],
                                'nombre_cta' => $as['nombre_cuenta'],
                                'importe' => $as['monto'],
                                'c_a' => $as['c_a']
                            ];

                            $cosas = array('cuenta' => $contra[0]['cuenta'],
                                           'sub_cta' => $contra[0]['sub_cta'],
                                           'ssub_cta' => $contra[0]['ssub_cta'],
                                        'nombre_cta' => $contra[0]['descrip'],
                                        'importe' => $as['monto'],
                                          'c_a' => $as['c_a'] == '+' ? '-' : '+');

                            array_push($datas, $cosas);
                         }
                         else if($algo[0]['idcuentaconfi'] == 42)
                         {
                              $contra = $this->conficta->getidcuentaconfi(40);
                              $datas[] = [
                                'cuenta' => $as['cuenta'],
                                'sub_cta' => $as['sub_cta'],
                                'ssub_cta' => $as['ssub_cta'],
                                'nombre_cta' => $as['nombre_cuenta'],
                                'importe' => $as['monto'],
                                'c_a' => $as['c_a']
                            ];

                            $cosas = array('cuenta' => $contra[0]['cuenta'],
                                           'sub_cta' => $contra[0]['sub_cta'],
                                           'ssub_cta' => $contra[0]['ssub_cta'],
                                        'nombre_cta' => $contra[0]['descrip'],
                                        'importe' => $as['monto'],
                                          'c_a' => $as['c_a'] == '+' ? '-' : '+');

                            array_push($datas, $cosas);
                         }
                         else
                         {
                            $datas[] = [
                                'cuenta' => $as['cuenta'],
                                'sub_cta' => $as['sub_cta'],
                                'ssub_cta' => $as['ssub_cta'],
                                'nombre_cta' => $as['nombre_cuenta'],
                                'importe' => $as['monto'],
                                'c_a' => $as['c_a']
                            ];
                         }
                    }

                }

                $this->opera->CrearTablaTemporal($datas);
                //$cons = array('status' => true, 'data' => $datas);
            }
            else
            {
                $cons = array('status' => false,'data' => 0);
            }

         // $this->output->set_content_type('application/json')->set_output(json_encode($cons));

    }
    public function ajax_bancos()
    {
        $list = $this->cat->selectctabancos();

        $data = array();
        foreach($list as $bancos)
        {
            $row = array();
            $row[] = '<button type="button" data-dismiss="modal" onclick="returnIdBanco(\''.$bancos['clave'].'\',\''.$bancos['nombre_c'].'\')" class="btn btn-success" title="Seleccionar"><i class="fa fa-check"></i></button>';
            $row[] = $bancos['clave'];
            $row[] = $bancos['nombre_c'];
            $data[] = $row;
        }
        $output = array(
            'draw' => $this->input->post('draw'),
            // 'recordsTotal' =>  $this->cat->count_all(),
            // 'recordsFiltered' => $this->cat->count_filtered(),
            'data' => $data
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function ajax_list()
    {
        $permisos = $this->permisosForma($_SESSION['id'],1);
        $edit = $permisos['edit'];
        $del = $permisos['del'];
        $print = $permisos['print'];
        if($edit=="0"){$edit='class="disabled"';} else {$edit="";}
        if($del=="0"){$del='class="disabled"';} else {$del="";}
        if($print=="0"){$print='class="disabled"';} else{$print="";}
        $list = $this->bancos->get_datatables();

        $data = array();
        foreach($list as $bancos)
        {
            $row = array();
            $row[] = $bancos->no_banco;
            $row[] = $bancos->cuenta;
            $row[] = $bancos->banco;
            $row[] = '<a href="'.base_url().'catalogos/Bancos/editar/'.$bancos->no_banco.'" '.$edit.' class="btn btn-primary" title="Editar Banco"><i class="fa fa-pencil-square-o"></i></a>
            <a href="#"  onClick="EliminarBanco(\''.$bancos->no_banco.'\')" '.$del.' class="btn btn-danger" title="Eliminar Banco"><i class="fa fa-times"></i></a>
            <button onclick="abriroperaciones(\''.$bancos->no_banco.'\')" '.$print.' class="btn btn-success" title="Operaciones"><i class="fa fa-percent"></i></button>';
            $data[] = $row;
        }
        $output = array(
            'draw' => $this->input->post('draw'),
            'recordsTotal' =>  $this->bancos->count_all(),
            'recordsFiltered' => $this->bancos->count_filtered(),
            'data' => $data
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($output));
    } 
    public function agregar($mensaje = null)
    {
        if($this->aauth->is_loggedin())
        {
           $permisos = $this->permisosforma($_SESSION['id'],1);
           if(isset($permisos) && $permisos['add']=="1")
           {
               $bancos = $this->cat->selectctabancos();
               $data = array('titulo' => 'Nuevo banco','accion' => 'catalogos/Bancos/guardarbanco', 'permisosGrupo' => $permisos,'bancos' => $bancos, 'mensaje' => $mensaje);
               $this->load->view('templates/navigation',$data);
               $this->load->view('bancos/bancos');
               $this->load->view('templates/footer');
           }
           else
           {
               redirect('catalogos/bancos/index','refresh');
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
            $permisos = $this->permisosForma($_SESSION['id'],1);
            if(isset($permisos) && $permisos['add'] == "1")
            {
               $datos=$this->bancos->datosBancos($id);
               $bancos = $this->cat->selectctabancos();
               $data = array('titulo' => 'Editar banco', 'accion' => 'catalogos/bancos/guardarbanco','permisosGrupo' => $permisos,'datos' => $datos,'bancos' => $bancos);
               $this->load->view('templates/navigation',$data);
               $this->load->view('bancos/bancos');
               $this->load->view('templates/footer');
            }
            else
            {
                redirect('catalogos/bancos/index','refresh');
            }
        }
        else
        {
            redirect('/inicio/login','refresh');
        }
    }
    public function consecutivoscheques()
    {
        $che = $this->input->post('cheque');
        $id = $this->input->post('id');

        $datos = array('cheques' => $che);

        $correcto=$this->bancos->consecutivocheques($id,$datos);

    }
    public function consecutivosdepositos()
    {
        $depo = $this->input->post('depo');
        $id = $this->input->post('id');

        $datos = array('depositos' => $depo);

        $correcto = $this->bancos->consecutivodepositos($id,$datos);
    }
    public function consecutivosmovimiento()
    {
        $movi = $this->input->post('movi');
        $id = $this->input->post('id');

        $datos = array('movimiento' => $movi);

        $correcto = $this->bancos->consecutivosmovimiento($id,$datos);
    }
    public function operaciones($tipo,$id)
    {
        if($this->aauth->is_loggedin())
        {        
           $permisos = $this->permisosforma($_SESSION['id'],1);
           if(isset($permisos) && $permisos['add'] == "1")
           {
                if($tipo == 1){ $titulo = 'Transferencia';}else if($tipo == 2){ $titulo = 'Chequera';}else{$titulo = 'Depósitos';}


                $datos=$this->bancos->datosBancos($id);
                $data = array('titulo' => $titulo,'id' => $id,'tipo' => $tipo,'permisosGrupo' => $permisos,'datos' => $datos);
                $this->load->view('templates/navigation',$data);
                $this->load->view('bancos/operaciones/index');
                $this->load->view('templates/footer');
           }
           else
           {
              redirect('catalogos/bancos/index','refresh');
           }
        }
        else
        {
           redirect('/inicio/login','refresh');
        }
    }
    public function editaroperacion($id,$tipo,$no_banco)
    {
        if($this->aauth->is_loggedin())
        {
           $permisos = $this->permisosForma($_SESSION['id'],1);
           if(isset($permisos) && $permisos['add'] == "1")
           {
              $datos=$this->bancos->datosBancos($no_banco);
              $detalle = $this->opera->detallepoliza($id);
              $datospoliza = $this->opera->datosOpera($id);
              $datosprove = $this->benefi->verificarsiexiste($datospoliza[0]['no_prov']);

              $montoposito = 0;
              $montonegati = 0;
              $totalmontopoliza = 0;
              foreach($detalle as $dato)
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

              $totalmontopoliza = number_format($montoposito,2,'.','') - number_format($montonegati,2,'.','');
              if($datospoliza[0]['c_a'] == '+')
              {
                  $bc = 'plu';
              }
              else
              {
                  $bc = 'min';
              }

              if($tipo == 'T')
              {
                 $titulo = 'Editar transferencia';
                 $tipo = 1;
                 $letra = 'T';
              }
              else if($tipo == 'C')
              {
                 $titulo = 'Editar cheque';
                 $tipo = 2;
                 $letra = 'C';
              }
              else
              {
                 $titulo = 'Editar depósito';
                 $tipo = 3;
                 $letra = 'D';
              }

              $rfc = $this->configModel->getConfig();
              $formapago = $this->cat->selectformapago();
              $monedas = $this->cat->selectmoneda();

              $pagos = $this->pagos->get_pagos_by_movi($datospoliza[0]['no_mov'],$letra);
              
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

              $CXP = 'BAN';
              $editopera = 1;
              $data = array('titulo' => $titulo,'tipo_letra' => $letra,'datosprove' => $datosprove,'editopera' => $editopera,'totalmontopoliza' => $totalmontopoliza,'impPagado' => $imppagago,'impDife' => $impdife,'totalPago' => $totalPAgo,'saldoInso' => $saldoinso,'pagos_detalle' => $pagos_detalle,'pagos' => $pagos,'monedas' => $monedas,'formapago' => $formapago,'CXP' => $CXP,'rfc' => $rfc[0]['rfc'],'montonegativo' => $montonegati,'bc' => $bc ,'montopositivo' => $montoposito , 'id' => $no_banco, 'tipo' => $tipo , 'permisosGrupo' => $permisos , 'datos' => $datos, 'datospoliza' => $datospoliza,'detalle'=>$detalle);
              $this->load->view('templates/navigation',$data);
              $this->load->view('bancos/operaciones/operaciones');
              $this->load->view('templates/footer');
           }
           else
           {
               redirect('catalogos/bancos/index','refresh');
           }
        }
        else
        {
           redirect('/inicio/login','refresh');
        }
    }
    public function nuevaoperacion($id,$tipo,$bc = null)
    {
        if($this->aauth->is_loggedin())
        {        
           $permisos = $this->permisosforma($_SESSION['id'],1);
           if(isset($permisos) && $permisos['add'] == "1")
           {
                $datos=$this->bancos->datosBancos($id);
                if($tipo == 1)
                { 
                    $titulo = 'Nueva transferencia';
                    $increme = $datos[0]['movimiento'] + 1;
                    $tipo_letra = 'T';
                }
                else if($tipo == 2)
                { 
                    $titulo = 'Nuevo cheque';
                    $increme = $datos[0]['cheques'] + 1;
                    $tipo_letra = 'C';
                }
                else
                {
                    $titulo = 'Nuevo depósito';
                    $increme = $datos[0]['depositos'] + 1;
                    $tipo_letra = 'D';
                }
                $rfc = $this->configModel->getConfig();
                $formapago = $this->cat->selectformapago();
                $monedas = $this->cat->selectmoneda();
                $noprovb = $this->benefi->getNoProv();
                $datas = $noprovb[0]['no_prov'] + 1;
               // $pagos = $this->pagos->get_pagos_by_movi($increme,$tipo_letra);
                $CXP = 'BAN';
                $editopera = 0;
                $data = array('titulo' => $titulo,'tipo_letra' => $tipo_letra,'datas' => $datas,'id' => $id,'editopera' => $editopera,'monedas' => $monedas,'formapago' => $formapago,'consecu' => $increme,'CXP' => $CXP,'rfc' => $rfc[0]['rfc'],'tipo' => $tipo, 'permisosGrupo' => $permisos,'datos' => $datos,'bc' => $bc);
                $this->load->view('templates/navigation',$data);
                $this->load->view('bancos/operaciones/operaciones');
                $this->load->view('templates/footer');
           }
           else
           {
              redirect('catalogos/bancos/index','refresh');
           }
        }
        else
        {
           redirect('/inicio/login','refresh');
        }
    }
    public function getbancodesc()
    {
        $clavesatbanco = $this->input->post('bancosat');
        $valor = $this->cat->getctabancos($clavesatbanco);
        $this->output->set_content_type('application/json')->set_output(json_encode($valor));
    } 
    public function guardarbanco()
    {
        date_default_timezone_set("America/Mexico_City");
        $id = $this->input->post('id_banco');
        $correcto= false;
         $imgName = '';

         if($this->input->post('sub_cuenta_conta') <= 0)
        {
            $mensaje = array('mensaje' => "La sub cuenta contable tiene que ser mayor a 0",
            'numero' => $this->input->post('numero'),
            'cuenta' => $this->input->post('cuenta'),
            'nombre' => $this->input->post('nombre'),
            'cta' => $this->input->post('cuenta_conta'),
            'sub_cta' => $this->input->post('sub_cuenta_conta'),
            'ssub_cta' => $this->input->post('sub_sub_cuenta_conta'),
            'rfc' => $this->input->post('rfc'),
            'clabe' => $this->input->post('clabe'),
            'url' => $this->input->post('internet'),
            'bancosat' => $this->input->post('bancosat'),
            'bancosatdescripcion' => $this->input->post('bancosatdescripcion')
            );
            $this->agregar($mensaje);
        }
         else{
        if(isset($_FILES['imgInp']) && $_FILES['imgInp']['name'] != '')
        {
             $imgName = $_FILES['imgInp']['name'];
        }
        else
        {
             $imgName = $this->input->post('imgName');
        }
        $datos = array(
            'no_banco' => $this->input->post('numero'),
            'cuenta' => $this->input->post('cuenta'),
            'banco' => $this->input->post('nombre'),
            'direccion' => $this->input->post('direccion'),
            'ciudad' => $this->input->post('ciudad'),
            'estado' => '',
            'cheques' => $this->input->post('cheques'),
            'depositos' => $this->input->post('depositos'),
            'movimiento' => $this->input->post('movimientos'),
            'logo' => $this->input->post('imgBase64') ? $this->input->post('imgBase64') : '',
            'cta' => $this->input->post('cuenta_conta'),
            'sub_cta' => $this->input->post('sub_cuenta_conta'),
            'ch_repName' => $this->input->post('formato1'),
            'bancoSat' => $this->input->post('bancosat'),
            'bancoSatNom' => $this->input->post('bancosatdescripcion'),
            'renglonesR' => 0,
            'bancoSaai' => '',
            'rfc' => $this->input->post('rfc'),
            'clabe' => $this->input->post('clabe'),
            'url' => $this->input->post('internet'),
            'ssub_cta' => $this->input->post('sub_sub_cuenta_conta'),
            'imgName' => $imgName,
            'ch_repName2' => $this->input->post('formato12')
        );

        if($id>0)
        {
            $banco = array(
                'usuario' => $_SESSION['nombreU'],
                'tipo_mov' => '',
                'no_banco' => '',
                'no_mov' => '',
                'accion' => 'Modificar',
                'cuando' => date('Y-m-d H:i:s'),
                'comentario' => 'Modifico el banco numero: '.$this->input->post('numero'),
                'modulo' => 'Catalogos -> Bancos'
            );
            $this->bitacora->operacion($banco);
            $correcto=$this->bancos->editarBanco($id,$datos);

            // $datoscuenta = array('cuenta' => $this->input->post('cuenta'),
            //                   'sub_cta' => $this->input->post('sub_cuenta_conta'),
            //                   'nombre'=> $this->input->post('nombre'),
            //                   'tipo' => '',
            //                   'ctasat' => $this->input->post('cuenta').'.'.$this->input->post('sub_cuenta_conta'),
            //                   'natur' => 'D',
            //                   'cvecobro'=> 0,
            //                   'ssub_cta' => $this->input->post('sub_sub_cuenta_conta'));
           // $this->cuentas->editarCuenta($id,$datoscuenta);
        }
        else
        {

            $checar = $this->bancos->verificarsiexiste($this->input->post('numero'));

            if(count($checar) > 0)
            {
                 $mensaje = array('mensaje' => "Ya existe este numero de banco");
                 $this->agregar($mensaje);
            }
            else
            {
                $banco = array(
                      'usuario' => $_SESSION['nombreU'],
                      'tipo_mov' => '',
                      'no_banco' => '',
                      'no_mov' => '',
                      'accion' => 'Agregar',
                      'cuando' => date('Y-m-d H:i:s'),
                      'comentario' => 'Agrego el banco numero: '.$this->input->post('numero'). ' Cuenta: ' .$this->input->post('cuenta'). ' Nombre: ' .$this->input->post('nombre'),
                      'modulo' => 'Catalogos -> Bancos'
                ); 
                $this->bitacora->operacion($banco);
                $correcto=$this->bancos->crearBanco($datos);

                $datoscuenta = array('cuenta' => $this->input->post('cuenta_conta'),
                              'sub_cta' => $this->input->post('sub_cuenta_conta'),
                              'nombre'=> $this->input->post('nombre'),
                              'tipo' => '',
                              'ctasat' => $this->input->post('cuenta_conta').'.0'.$this->input->post('sub_cuenta_conta'),
                              'natur' => 'D',
                              'cvecobro'=>0,
                              'ssub_cta' => $this->input->post('sub_sub_cuenta_conta'));
                $this->cuentas->crearCuenta($datoscuenta);
            }

        }

        if($correcto == true)
        {
            redirect('catalogos/Bancos/index','refresh');
        }
    }

    } 
    public function getbanco()
    {
        $id = $this->input->post('id');
        //$clasi = 0;
        $clasi = $this->input->post('clasi');

        $tipomovs = $this->input->post('tipomovs');


        if($clasi == 1)
        {

                $datos=$this->bancos->datosBancos($id);


                 if($tipomovs == 4)
                 {

                 }
                 else
                 {
                     $data2 = array('cta'=>$datos[0]['cta'],'sub_cta'=>$datos[0]['sub_cta'],'ssub_cta'=>$datos[0]['ssub_cta'],'banco'=>$datos[0]['banco'],'c_a'=>'+','monto'=>0,'val'=>1);

                 }
                 $datostemporal = $this->opera->obtenerTablaTemporal();
                 $dats = [];
                 foreach($datostemporal as $dat)
                 {
                      $dast[] = array(
                           'cta' => $dat['cuenta'],
                           'sub_cta' => $dat['sub_cta'],
                           'ssub_cta' => $dat['ssub_cta'],
                           'banco' => $dat['nombre_cta'],
                           'c_a' => $dat['c_a'],
                           'monto' => $dat['importe'],
                           'val' => '0'
     
                      );
                 }

                 if($tipomovs == 4)
                 {

                 }
                 else
                 {                 
                    array_push($dast, $data2);

                    foreach ($dast as $key => $row) 
                    {
                        $aux[$key] = $row['cta'];

                    }

                    array_multisort($aux, SORT_ASC, $dast);
                }
        }
        else
        {
            $dast=$this->bancos->datosBancos($id);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($dast));
    }
    public function eliminar($id)
    {
        date_default_timezone_set("America/Mexico_City");
        if($this->aauth->is_loggedin())
        {
           $permisos = $this->permisosForma($_SESSION['id'],1);
           if(isset($permisos) && $permisos['del']=="1")
           {

            $datos = $this->bancos->datosBancos($id);

               $banco = array(
                   'usuario' => $_SESSION['nombreU'],
                   'tipo_mov' => '',
                   'no_banco' => '',
                   'no_mov' => '',
                   'accion' => 'Eliminar',
                   'cuando' => date('Y-m-d H:i:s'),
                   'comentario' => 'Elimino el banco del ID: '.$id. ' Numero: '.$datos[0]['no_banco']. ' Cuenta: '.$datos[0]['cuenta']. ' Nombre: '.$datos[0]['banco'],
                   'modulo' => 'Catalogos -> Bancos'
               );
               $this->bitacora->operacion($banco);

              $res=$this->bancos->borrarBanco($id);
              if($res==true)
              {
                  header('Location:'.base_url()."catalogos/bancos/index",301);
                  exit();
              }
           }
           else
           {
               redirect('catalogos/bancos/index','refresh');
           }
        }
        else
        {
            redirect('/inicio/login','refresh');
        }
    }
}