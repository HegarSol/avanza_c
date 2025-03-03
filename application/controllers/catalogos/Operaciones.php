<?php
class Operaciones extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('menuModel');
        $items=$this->menuModel->menus($_SESSION['tipo']);
        $this->multi_menu->set_items($items);
        $this->load->view('templates/header');
        $this->load->model('OperacionesModel','opera');
        $this->load->model('BitacoraModel','bitacora');
        $this->load->model('ConfigCuentasModel','conficta');
        $this->load->helper('hegarss');

    }

    public function agruparcuentas()
    {
        $datos = [];
        $da = $this->input->post('as');
        
        foreach($da as $as)
        {
            $datos[] = [
                'cuenta' => $as[0],
                'subcuenta' => $as[1],
                'prov' => $as[2],
                'refe' => $as[3],
                'nombre_cuenta' => $as[4],
                'concep' => $as[5],
                'importe' => $as[6],
                'c_a' => $as[7]
            ];
        }

        $result = array();
                    foreach($datos as $t) {
                        $repeat=false;
                        for($i=0;$i<count($result);$i++)
                        {

                            if($result[$i]['cuenta']==$t['cuenta'] && $result[$i]['subcuenta']==$t['subcuenta'])
                            {
                                $result[$i]['importe']+=$t['importe'];
                                $repeat=true;
                                break;
                            }
                        }
                        if($repeat==false)
                            $result[] = array('cuenta' => $t['cuenta'], 
                                              'subcuenta' => $t['subcuenta'],
                                              'prov' => $t['prov'],
                                              'refe' => $t['refe'],
                                              'nombre_cuenta' => $t['nombre_cuenta'],
                                              'concep' => $t['concep'],
                                              'importe' => $t['importe'],
                                              'c_a' => $t['c_a']
                                            );
                    }

          $response = array('status' => true, 'data' => $result);
          $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function buildAcientoContable()
    {
        $uuid = $this->input->post('uuid');
        $nom_prov = $this->input->post('nom_prov');
        $deta = $this->input->post('datos');

        $datosprevi = get_factura_poliza($uuid,$nom_prov,$deta);

        $response = array('status' => true,'data' => $datosprevi);
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function buildAcientoContableContra()
    {
        $uuid = $this->input->post('uuid');
        $nom_prov = $this->input->post('nom_prov');
        $deta = $this->input->post('datos');
        $poli = $this->input->post('poli');
        $porpaga = $this->input->post('porpaga');


        $datosprevi = get_factura_poliza($uuid,$nom_prov,$deta,$porpaga,$poli);

        
        $datas = [];

        foreach($datosprevi as $valor)
        {
            $algo = $this->conficta->getcuenta_sub($valor['cuenta'],$valor['sub_cta'],$valor['ssub_cta']);

               if(isset($algo[0]['idcuentaconfi']) == 28)
               {
                   $contra = $this->conficta->getidcuentaconfi(6);
                   $datas[] = [
                         'cuenta' => $valor['cuenta'],
                         'sub_cta' => $valor['sub_cta'],
                         'ssub_cta' => $valor['ssub_cta'],
                         'nombre_cta' => $valor['nombre_cta'],
                         'importe' => $valor['importe'],
                         'c_a' => $valor['c_a']
                   ];
                   if($poli != '')
                   {
                   $cosas = array(
                       'cuenta' => $contra[0]['cuenta'],
                                  'sub_cta' => $contra[0]['sub_cta'],
                                  'ssub_cta' => $contra[0]['ssub_cta'],
                                'nombre_cta' => $contra[0]['descrip'],
                                 'importe' => $valor['importe'],
                                 'c_a' => $valor['c_a'] == '+' ? '-' : '+'
                                );
                  
                    array_push($datas,$cosas);
                   }
               }
               else if(isset($algo[0]['idcuentaconfi']) == 38)
               {
                  $contra = $this->conficta->getidcuentaconfi(37);
                  $datas[] = [
                      'cuenta' => $valor['cuenta'],
                      'sub_cta' => $valor['sub_cta'],
                      'ssub_cta' => $valor['ssub_cta'],
                      'nombre_cta' => $valor['nombre_cta'],
                      'importe' => $valor['importe'],
                      'c_a' => $valor['c_a']
                  ];
                  if($poli != '')
                  {
                  $cosas = array(
                       'cuenta' => $contra[0]['cuenta'],
                                 'sub_cta' => $contra[0]['sub_cta'],
                                 'ssub_cta' => $contra[0]['ssub_cta'],
                                 'nombre_cta' => $contra[0]['descrip'],
                                 'importe' => $valor['importe'],
                                'c_a' => $valor['c_a'] == '+' ? '-' : '+'
                            );
                  
                   array_push($datas,$cosas);
                  }
               }
               else if(isset($algo[0]['idcuentaconfi']) == 33)
               {
                    $contra = $this->conficta->getidcuentaconfi(30);
                    $datas[] = [
                        'cuenta' => $valor['cuenta'],
                        'sub_cta' => $valor['sub_cta'],
                        'ssub_cta' => $valor['ssub_cta'],
                        'nombre_cta' => $valor['nombre_cta'],
                        'importe' => $valor['importe'],
                        'c_a' => $valor['c_a']
                    ];
                    if($poli != '')
                    {
                    $cosas = array(
                        'cuenta' => $contra[0]['cuenta'],
                                'sub_cta' => $contra[0]['sub_cta'],
                                'ssub_cta' => $contra[0]['ssub_cta'],
                                 'nombre_cta' => $contra[0]['descrip'],
                                'importe' => $valor['importe'],
                                'c_a' => $valor['c_a'] == '+' ? '-' : '+'
                            );
                    
                    array_push($datas,$cosas);
                    }
               }
               else if(isset($algo[0]['idcuentaconfi']) == 46)
               {
                   $contra = $this->conficta->getidcuentaconfi(41);
                   $data[] = [
                       'cuenta' => $valor['cuenta'],
                       'sub_cta' => $valor['sub_cta'],
                       'ssub_cta' => $valor['ssub_cta'],
                       'nombre_cta' => $valor['nombre_cta'],
                       'importe' => $valor['importe'],
                       'c_a' => $valor['c_a']
                   ];
                   if($poli != '')
                   {
                   $cosas = array(
                       'cuenta' => $contra[0]['cuenta'],
                                'sub_cta' => $contra[0]['sub_cta'],
                                'ssub_cta' => $contra[0]['ssub_cta'],
                            'nombre_cta' => $contra[0]['descrip'],
                             'importe' => $valor['importe'],
                            'c_a' => $valor['c_a'] == '+' ? '-' : '+'
                        );
                   
                     array_push($datas,$cosas);
                   }
               }
               else if(isset($algo[0]['idcuentaconfi']) == 34)
               {
                   $contra = $this->conficta->getidcuentaconfi(31);
                   $datas[] = [
                         'cuenta' => $valor['cuenta'],
                         'sub_cta' => $valor['sub_cta'],
                         'ssub_cta' => $valor['ssub_cta'],
                         'nombre_cta' => $valor['nombre_cta'],
                         'importe' => $valor['importe'],
                         'c_a' => $valor['c_a']
                   ];
                   if($poli != '')
                   {
                   $cosas = array(
                       'cuenta' => $contra[0]['cuenta'],
                              'sub_cta' => $contra[0]['sub_cta'],
                              'ssub_cta' => $contra[0]['ssub_cta'],
                              'nombre_cta' => $contra[0]['descrip'],
                              'importe' => $valor['importe'],
                            'c_a' => $valor['c_a'] == '+' ? '-' : '+'
                        );

                   array_push($datas,$cosas);
                   }
               }
               else if(isset($algo[0]['idcuentaconfi']) == 42)
               {
                   $contra = $this->conficta->getidcuentaconfi(40);
                   $datas[] = [
                       'cuenta' => $valor['cuenta'],
                       'sub_cta' => $valor['sub_cta'],
                       'ssub_cta' => $valor['ssub_cta'],
                       'nombre_cta' => $valor['nombre_cta'],
                       'importe' => $valor['importe'],
                       'c_a' => $valor['c_a']
                   ];

                   if($poli != '')
                   {
                   $cosas = array(
                       'cuenta' => $contra[0]['cuenta'],
                                 'sub_cta' => $contra[0]['sub_cta'],
                                 'ssub_cta' => $contra[0]['ssub_cta'],
                                  'nombre_cta' => $contra[0]['descrip'],
                                'importe' => $valor['importe'],
                                'c_a' => $valor['c_a'] == '+' ? '-' : '+');

                    array_push($datas,$cosas);
                   }
               }
               else
               {

                    if($poli != '')
                    {
                        
                    }
                    else
                    {
                        $datas[] = [
                            'cuenta' => $valor['cuenta'],
                            'sub_cta' => $valor['sub_cta'],
                            'ssub_cta' => $valor['ssub_cta'],
                            'nombre_cta' => $valor['nombre_cta'],
                            'importe' => $valor['importe'],
                            'c_a' => $valor['c_a'] == '+' ? '-' : '+'
                        ];
                    }

               }            
        }

        $this->opera->CrearTablaTemporal($datas);
       // $response = array('status' => true, 'data' => $datas);
       // $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function eliminartablatemporal()
    {
        $this->opera->borrarTablaTemporal();
    }
    public function getAttribute($query)
    {
        $xpath = $this->getXpathObj();
        $nodeset = $xpath->query($query, $this->xmlDom);
            if($regresa = $nodeset[0])
            {
               return $regresa->value;
            }
         return "";
    }

    public function getXpathObj()
    {
        if(empty($this->xpath) && !empty($this->xmlDom))
        {
            $this->xpath = new DOMXPath($this->xmlDom);
            $this->xpath->registerNamespace('cfdi', 'http://www.sat.gob.mx/cfd/4');
            $this->xpath->registerNamespace('tfd', 'http://www.sat.gob.mx/TimbreFiscalDigital');
        }
        return $this->xpath;
    }
    public function guardarpoliza()
    {
        date_default_timezone_set("America/Mexico_City");
        setlocale(LC_TIME, 'es_ES.UTF-8');
        $correcto = false;
        //cabezera poliza
        $id = $this->input->post('id');
        $tipo_movimento = $this->input->post('tipo_movimiento');
        $numero_banco = $this->input->post('numero_banco');
        $numero_movimento = $this->input->post('numero_movimiento');
        $fechapoli = $this->input->post('fechapoli');
        $beneficariopoli = $this->input->post('beneficiariopoli');
        $conceptopoli = $this->input->post('conceptopoli');
        $montopoli = $this->input->post('montopoli');
        $ca_poli = $this->input->post('ca_poli');
        $cobrado_poli = $this->input->post('cobrado_poli');
        $cerrado_poli = $this->input->post('cerrado_poli');
        $no_prove = $this->input->post('no_prove');
        $fechaCobro = $this->input->post('fechaCobro');
        $cobro = $this->input->post('cobro');
        $impresopoli = $this->input->post('impresopoli');
        $afectar = $this->input->post('afectar');
        $bancosat = $this->input->post('bancosat');
        $bene_ctaban = $this->input->post('bene_ctaban');
        $tieneCxP_pagos = $this->input->post('tieneCxP_pagos');
        $cta_banco = $this->input->post('cta_banco');
        $tipoproveedor = $this->input->post('tipoproveedor');

        $uuidpoliza = $this->input->post('uuidpoliza');
        $poliza_contble = $tipo_movimento.'  '.$numero_banco.'        '.$numero_movimento;

        $uuidsep = substr($uuidpoliza, 0, -1);

        $uuidsep = explode(',',$uuidsep);


       $datos = array(
           'tipo_mov' => $tipo_movimento,
           'no_banco' => $numero_banco,
           'no_mov' => $numero_movimento,
           'fecha' => $fechapoli,
           'beneficia' => $beneficariopoli,
           'concepto' => $conceptopoli,
           'monto' => $montopoli,
           'c_a' => $ca_poli,
           'cobrado' => $cobro,
           'cerrado' => $cerrado_poli,
           'no_prov' => $no_prove,
           'fechaCobro' => $fechaCobro == '' ? NULL : $fechaCobro,
           'impreso' => $impresopoli,
           'afectar' => $afectar,
           'bancosat' => $bancosat,
           'bene_ctaban' => $bene_ctaban,
           'tieneCxP_pagos' => $tieneCxP_pagos,
           'cta_banco' => $cta_banco,
           'tipo_proveedor' => $tipoproveedor
       );

       if($tipo_movimento == 'T')
       {
           $tipo_mo = 'Transferencia';
       }
       else if($tipo_movimento == 'D')
       {
           $tipo_mo = 'Deposito';
       }
       else
       {
           $tipo_mo = 'Chequera';
       }

       if($id > 0)
       {
           $correcto = $this->opera->editarPoliza($id,$datos);
           $crearopera = array('usuario' => $_SESSION['nombreU'],
                               'tipo_mov' => $tipo_movimento,
                               'no_banco' => $numero_banco,
                               'no_mov' => $numero_movimento,
                               'accion' => 'Modificar', 
                               'cuando' => date('Y-m-d H:i:s'), 
                               'comentario' => 'Edito la operacion de tipo: '.$tipo_movimento.' del numero de banco: '.$numero_banco.' del movimiento: '.$numero_movimento,
                               'modulo' => 'Catalogos -> Bancos -> '.$tipo_mo);
           $this->bitacora->operacion($crearopera);

       }
       else
       {
           $id = $this->opera->crearPoliza($datos);
           if($id>0)
           {
               $crearopera = array('usuario' => $_SESSION['nombreU'],
                                   'tipo_mov' => $tipo_movimento,
                                   'no_banco' => $numero_banco,
                                   'no_mov' => $numero_movimento, 
                                   'accion' => 'Agregar', 
                                   'cuando' => date('Y-m-d H:i:s'), 
                                   'comentario' => 'Creo la operacion de tipo: '.$tipo_movimento.' del numero de banco: '.$numero_banco.' del movimiento: '.$numero_movimento,
                                   'modulo' => 'Catalogos -> Bancos -> '.$tipo_mo);
               $this->bitacora->operacion($crearopera);
               $correcto = true;

               $this->opera->actualizarmovimiento($numero_banco,$tipo_movimento,$numero_movimento);
     
                if($uuidpoliza =! '' && $ca_poli == '-' && $tipo_movimento == 'T' || $tipo_movimento == 'C')
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
            
           //detalle poliza
            $tipo_mov = $this->input->post('tipo_mov');

            $no_banco = $this->input->post('no_banco');

            $no_mov = $this->input->post('no_mov');

            $ren = $this->input->post('ren');

            $cuenta = $this->input->post('cuenta');

            $sub_cta = $this->input->post('sub_cta');

            $ssub_cta = $this->input->post('ssub_cta');

            $monto = $this->input->post('monto');

            $c_a = $this->input->post('c_a');

            $fecha = $this->input->post('fechapoli');

            $concepto = $this->input->post('concepto');

            $referencia = $this->input->post('referencia');

            $factrefe = $this->input->post('factrefe');

            $no_prov = $this->input->post('no_prov');

            $nombre_cuenta = $this->input->post('nombre_cuenta');

            $mensaje=array();

            for($i=1; $i<count($tipo_mov); $i++)
            {

                $monto[$i] = str_replace(',', '', $monto[$i]);
                 $detalle = array(
                       'id_encabezado' => $id,
                       'tipo_mov' => $tipo_mov[$i],
                       'no_banco' => $no_banco[$i],
                       'no_mov' => $no_mov[$i],
                       'ren' => $ren[$i],
                       'cuenta' => $cuenta[$i],
                       'sub_cta' => $sub_cta[$i],
                       'monto' => $monto[$i],
                       'c_a' => $c_a[$i],
                       'fecha' => $fecha,
                       'concepto' => $concepto[$i],
                       'referencia' => $referencia[$i],
                       'no_prov' => $no_prov[$i],
                       'factrefe' => $factrefe[$i],
                       'nombre_cuenta' => $nombre_cuenta[$i],
                       'ssub_cta' => $ssub_cta[$i]
                    );
                    $detalle= $this->opera->guardarDetalle($detalle);               
                    
            }
             
            if($detalle > 0)
            {
                $mensaje[]=array('mensaje' => "Insertado Correctamente");
            }
            else
            {
                $mensaje[]=array('mensaje' => "Hubo un error insertando el detalle de la poliza.");
            }
       }
       else
       { 
            $mensaje[]=array('mensaje'=>"Error agregando la poliza.");
       }
       $this->output->set_content_type('application/json')->set_output(json_encode($mensaje));
    }
    public function ajax_list($tipo,$id)
    {

        if($tipo == 1)
        {
           $letra = 'T';
           $title = 'Transferencia';
        }
        else if($tipo == 2)
        {
           $letra = 'C';
           $title = 'Cheque';
        }
        else
        {
           $letra = 'D';
           $title = 'Depósito';
        }

        $where=array('tipo_mov' => $letra,'no_banco' => $id);
        $list = $this->opera->get_datatables($where);
      
        $data = array();
        foreach($list as $opera)
        {

               $row = array();
               $row[] = $opera->no_mov;
               $row[] = date('d-m-Y',strtotime($opera->fecha));
               $row[] = $opera->beneficia.' - '.$opera->concepto;
               $row[] = '$'.number_format($opera->monto,2,'.',',');
               $row[] = '<a href="'.base_url().'catalogos/Bancos/editaroperacion/'.$opera->id.'/'.$opera->tipo_mov.'/'.$opera->no_banco.'" class="btn btn-primary" title="Editar '.$title.'"><i class="fa fa-pencil-square-o"></i></a>
               <a href="#"  onClick="EliminarPoliza(\''.$opera->id.'\',\''.$id.'\',\''.$tipo.'\')" class="btn btn-danger" title="Eliminar '.$title.'"><i class="fa fa-times"></i></a>
               <a href="'.base_url().'Reportes/ReportePoliza/'.$opera->id.'/'.$opera->tipo_mov.'" target="_blank" class="btn btn-info" title="Imprimir"> <i class="fa fa-print"></i></a>';
               $data[] = $row;

        }
        $output = array(
            'draw' => $this->input->post('draw'),
            'recordsTotal' =>  $this->opera->count_all(),
            'recordsFiltered' => $this->opera->count_filtered(),
            'data' => $data
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function checarpolizas()
    {
        $id = $this->input->post('id');
        $polizas = $this->opera->checarPolizas($id);

        if(count($polizas) > 0)
        {
            $this->output->set_content_type('application/json')->set_output(json_encode(1));
        }
        else
        {
            $this->output->set_content_type('application/json')->set_output(json_encode(0));
        }
    } 
    public function eliminar($id,$n_banco,$tipo)
    {
        if($this->aauth->is_loggedin())
        {

            date_default_timezone_set("America/Mexico_City");
            
            $datosope = $this->opera->datosOpera($id);

            if($datosope[0]['tipo_mov'] == 'T')
            {
                $tipo_mo = 'Transferencia';
            }
            else if($datosope[0]['tipo_mov'] == 'D')
            {
                $tipo_mo = 'Deposito';
            }
            else
            {
                $tipo_mo = 'Chequera';
            }

             $res = $this->opera->borrarPoliza($id);
             $res2 = $this->opera->borrarDetalle($id);
             if($res == true && $res2 == true)
             {
                $crearopera = array('usuario' => $_SESSION['nombreU'],
                                    'tipo_mov' => $datosope[0]['tipo_mov'],
                                    'no_banco' => $datosope[0]['no_banco'],
                                    'no_mov' => $datosope[0]['no_mov'], 
                                    'accion' => 'Eliminar', 
                                    'cuando' => date('Y-m-d H:i:s'), 
                                    'comentario' => 'Elimino la operacion de tipo: '.$datosope[0]['tipo_mov'].' del numero de banco: '.$datosope[0]['no_banco'].' del movimiento: '.$datosope[0]['no_mov'],
                                    'modulo' => 'Catalogos -> Bancos -> '.$tipo_mo);
                $this->bitacora->operacion($crearopera);

                header('Location:'.base_url()."catalogos/bancos/operaciones/".$tipo."/".$n_banco,301);
                exit();
             }
        }
        else
        {
            redirect('/inicio/login','refresh');
        }
    }
}