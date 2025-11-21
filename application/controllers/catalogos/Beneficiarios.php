<?php
class Beneficiarios extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('menuModel');
        $items=$this->menuModel->menus($_SESSION['tipo']);
        $this->multi_menu->set_items($items);
        $this->load->view('templates/header');
        $this->load->model('BeneficiarioModel','benefi');
        $this->load->model('BancoBenefeModel','banben');
        $this->load->model('Configuraciones_model','configModel');
        $this->load->model('BitacoraModel','bitacora');
        $this->load->model('OperacionesModel','operaciones');
        $this->load->model('DicCuentasModel','dicuentas');
        $this->load->model('CatalogosModel','catalogos');
        $this->load->model('EmpresasModel','empresas');
        $this->load->model('DepartamentoCostosModel','deparcostos');
        $this->load->model('ConfigCuentasModel','configcuentas');
        $this->load->model('CuentasModel','cuentas');
    }
    public function index()
    {
        $permisos = $this->permisosForma($_SESSION['id'],8);
        if(isset($permisos) && $permisos['leer'] == "1")
        {
           if($this->aauth->is_loggedin())
           {
               $errores=array();
               $rfc = $this->configModel->getConfig();
               $CXP = 'bene';
               $tipopermiso = $_SESSION['tipo'];
               $permisos=$this->permisosforma($_SESSION['id'],8);
               $data = array('titulo' => 'Beneficiario','tipo_letra' => '','permisotipo' => $tipopermiso,'CXP' => $CXP,'rfc' => $rfc[0]['rfc'], 'razon' => $this->validaempresas->get_razon($_SESSION['idEmpresa']),'errores' => $errores, 'permisosGrupo' => $permisos);
               $items=$this->menuModel->menus($_SESSION['tipo']);
               $this->multi_menu->set_items($items);
               $this->load->view('templates/header');
               $this->load->view('templates/navigation',$data);
               $this->load->view('beneficiarios/index');
               $this->load->view('templates/footer');
           }
           else
           {
               redirect('inicio/login','refresh');
           }
        }
        else
        {
            show_error('No tiene permisos para entrar a beneficiarios');
        }
    }
    public function leerxml()
    {
        $xml = $_FILES['xml']['name'];
        $archivo = $_FILES['xml']['tmp_name'];

        $xmlData = file_get_contents($archivo);

        $this->xmlDom = new DOMDocument();
        $this->xmlDom->loadXML($xmlData);

        $this->rfcemisor=$this->getAttribute('cfdi:Comprobante/cfdi:Emisor/@Rfc');
        $this->nombreemisor=$this->getAttribute('cfdi:Comprobante/cfdi:Emisor/@Nombre');
        $this->cp=$this->getAttribute('cfdi:Comprobante/@LugarExpedicion');


        $rfcemisor = $this->benefi->datosbenerfc($this->rfcemisor);

        if(count($rfcemisor) > 0)
        {

        }
        else
        {
            $noprov = $this->benefi->getNoProv();
            $datas = $noprov[0]['no_prov'] + 1;

            $datos = array(
                'no_prov' => $datas,
                'nombre' => $this->nombreemisor,
                'cp' => $this->cp,
                'rfc' => $this->rfcemisor,
            );

            $correcto=$this->benefi->crearBeneficiario($datos);
        }
        

    }
    public function estafeta()
    {
        if($this->aauth->is_loggedin())
        {

            $rfc = $this->configModel->getConfig();
          //  $informabene = $this->benefi->datosBenefi($id);
          $departa = $this->deparcostos->getalldepartamento();
            $estoyenestafeta = 1;    
            // $conse = $this->operaciones->maxidPro();

            // if(count($conse) > 0)
            // {
            //     $conesucu = $conse[0]['no_mov'] + 1;
            // }
            // else
            // {
            //     $conesucu = 1;
            // }

            $errores=array();
            $data = array('titulo' => 'Listado de comprobantes pendientes','departamentos' => $departa,'estoyenestafeta' => $estoyenestafeta,'rfc' => $rfc[0]['rfc'],'razon' => $this->validaempresas->get_razon($_SESSION['idEmpresa']),'errores' => $errores);
            $items=$this->menuModel->menus($_SESSION['tipo']);
            $this->multi_menu->set_items($items);
            $this->load->view('templates/header');
            $this->load->view('templates/navigation',$data);
            $this->load->view('beneficiarios/estafeta');
            $this->load->view('templates/footer');
        }
        else
        {
            redirect('inicio/login','refresh');
        }
    }
    public function descargarxml()
    {
        $this->load->helper('download');
         $uuid = $this->input->get('uuid');

        // if(ENVIRONMENT == 'development')
        // {
        //   $ch = curl_init("http://localhost:85/git_hub_repo/avanza_buzon_github/api/Comprobantes/archivos?uuid=".$uuid);
        // }
        // else
        // {
          $ch = curl_init("http://avanzab.hegarss.com/api/Comprobantes/archivos?uuid=".$uuid);
        //}

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $resu = curl_exec($ch);
        $response = json_decode($resu);


       header('Content-Type: application/xml;');

       $valor = $response->xmlContent;
    
       force_download($uuid.'.xml',$valor);   


    }
    public function descargarpdf()
    {
        $this->load->helper('download');
         $uuid = $this->input->get('uuid');

        // if(ENVIRONMENT == 'development')
        // {
        //   $ch = curl_init("http://localhost:85/git_hub_repo/avanza_buzon_github/api/Comprobantes/archivos?uuid=".$uuid);
        // }
        // else
        // {
          $ch = curl_init("http://avanzab.hegarss.com/api/Comprobantes/archivos?uuid=".$uuid);
        //}

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $resu = curl_exec($ch);
        $response = json_decode($resu);

      //  var_dump($response);

      header('Content-Type: application/pdf; base64');

      $valor = base64_decode($response->pdfContent);
    
       force_download($uuid.'.pdf',$valor);   


    }
    public function buscarconcurso()
    {
        // Inicializar cURL
        $ch = curl_init();

        // Establecer URL y opciones
        curl_setopt($ch, CURLOPT_URL, "https://api.asfaltosyconcretos.com:7894/api/concurso/verConcursosFacturacion/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        // Establecer encabezados
        $headers = [
            "Content-Type: application/json",
            "Authorization: Token 28521d432ded2eb20e1787a362e36ea4939a503b"
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Ejecutar la petición
        $resu = curl_exec($ch);

        $response = json_decode($resu);

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function getpolizacuenta()
    {
        $poliza = $this->input->post('poliza');
       // var_dump($poliza);
       $partes = preg_replace('/\s+/', '', $poliza);
        // $tipo_mov = substr($partes,0, 1);
        // $banco_mov = substr($partes,-3, 1);

        $letra = substr($partes,-1);
        $resultado = strlen($partes);
        $resultado2 = $resultado - 1;
        $numeros = substr($partes,2,$resultado2);

        $detal = $this->operaciones->traerpolizaprovisiondetalle($numeros);

        $this->output->set_content_type('application/json')->set_output(json_encode($detal));

    }
    public function getupdateAutorizacion()
    {
        $rfc = $this->input->post('rfc');
        $check = $this->input->post('chek');

         foreach($check as $uuid)
         {
            if(ENVIRONMENT == 'development')
            {
            $ch = curl_init("http://localhost:85/git_hub_repo/avanza_buzon_github/api/Comprobantes/update_autorizacion");
            }
            else
            {
            $ch = curl_init("http://avanzab.hegarss.com/api/Comprobantes/update_autorizacion");
            }
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                                curl_setopt($ch, CURLOPT_POSTFIELDS, "empresa=".$rfc."&uuid=".$uuid[0].'&id_usu='.$_SESSION['id']);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                $resu = curl_exec($ch);
                                $response = json_decode($resu);
                                var_dump($resu);
         }

        
    }
    public function getAutorizacion()
    {
        $rfc = $this->input->post('rfc');
        $autoriza = 1;

        if(ENVIRONMENT == 'development')
        {
          $ch = curl_init("http://localhost:85/git_hub_repo/avanza_buzon_github/api/Comprobantes/reporte_autorizacion?empresa=".$rfc."&autoriza=".$autoriza);
        }
        else
        {
          $ch = curl_init("http://avanzab.hegarss.com/api/Comprobantes/reporte_autorizacion?empresa=".$rfc."&autoriza=".$autoriza);
        }

       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
       $resu = curl_exec($ch);
       $response = json_decode($resu);

       $arr = [];
       $date2 = new DateTime(date('d-m-Y'));

       $datos = $response->data;

       $tajos = [];
       $ordenado = [];

       for($j=0;$j<count($datos); $j++)
                        {
                             $tajos[] = [
                                 'rfc_emisor' => $datos[$j]->rfc_emisor,
                                 'nombre_emisor' => $datos[$j]->nombre_emisor
                             ];
                        }
    
                        foreach($tajos as $key => $row)
                        {
                            $aux[$key] = $row['rfc_emisor'];
                        }
    
                        array_multisort($aux,SORT_ASC,$tajos);
    
                        foreach($tajos as $key => $row)
                        {
                            $ordenado[] = ['rfc_emisor' => $row['rfc_emisor'],'nombre_emisor' => $row['nombre_emisor']];
                        }
    
    
                        $datosr = array_unique($ordenado, SORT_REGULAR);

                        foreach($datosr as $lai)
                        {

                            $arr[] = [
                                'rfcpro' => $lai['rfc_emisor'].' - '.$lai['nombre_emisor'],
                                'folio' => '',
                                'fecha' => '',
                                'fecha_pago' => '',
                                'total' => '',
                                'metodo_pago' => '',
                                'uuid' => '',
                                'antiguedad' => '',
                                'marca' => 1
                              ];

                            for($i=0; $i<count($datos); $i++)
                            {    
                                if($lai['rfc_emisor'] == $datos[$i]->rfc_emisor)
                                {

                                          $date1 = new DateTime(date('d-m-Y',strtotime($datos[$i]->fecha)));
                                          $diff = $date1->diff($date2);

                                          $arr[] = [
                                            'rfcpro' => '',
                                            'folio' => $datos[$i]->folio,
                                            'fecha' => $datos[$i]->fecha,
                                            'fecha_pago' => $datos[$i]->fecha_pago,
                                            'total' => $datos[$i]->total,
                                            'metodo_pago' => $datos[$i]->metodo_pago,
                                            'uuid' => $datos[$i]->uuid,
                                            'antiguedad' => $diff->days,
                                            'marca' => 0
                                          ];
                                }
                            }
                        }
   
      if($response->status == true)
      {
        $data = $arr;
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
      }
      else
      {
        $data = $response->error;
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
      }
    }
    public function getpendientesPagar()
    {
        $conf = $this->empresas->datosEmpresa($_SESSION['idEmpresa']);
        $rfc = $this->input->post('rfc');
        $rfcemisor = $this->input->post('rfcemisor');
        $historico = $this->input->post('historico');
        $formaDePago = $this->input->post('formapago');
        $autorizado = $conf[0]['autorizacion'];

        $tipo = $this->input->post('tipo');
        $no_banco = $this->input->post('no_banco');
        $no_mov = $this->input->post('mov');


        if($tipo == null && $no_banco == null && $no_mov == null)
        {
            $poliza = '';
        }
        else
        {
            $poliza = $tipo.'  '.$no_banco.'        '.$no_mov;
        }
       

      //  var_dump($autorizado);

        // if(ENVIRONMENT == 'development')
        // {
        //   $ch = curl_init("http://localhost:85/git_hub_repo/avanza_buzon_github/api/Comprobantes/list_by_proveedor_poliza?empresa=".$rfc."&proveedor=".$rfcemisor."&poliza=".$poliza."&historico=".$historico."&formaDePago=".$formaDePago."&autorizado=".$autorizado);
        // }
        // else
        // {
          $url = str_replace(' ', '%20',"http://avanzab.hegarss.com/api/Comprobantes/list_by_proveedor_poliza?empresa=".$rfc."&proveedor=".$rfcemisor."&poliza=".$poliza."&historico=".$historico."&formaDePago=".$formaDePago."&autorizado=".$autorizado); 

          $ch = curl_init($url);
       // }

       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
       $resu = curl_exec($ch);
       $response = json_decode($resu);

   
      if($response->status == true)
      {
        $data['comprobantes'] = $response->data;
        $data['poliza'] = $poliza;
        $this->load->view('beneficiarios/comprobantes_pendientes_pago/tabla',$data);
      }
      else
      {
        $data = $response->error;
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
      }
    }
    public function ajax_clientes()
    {

       $rfc = $this->configModel->getConfig();

       if(ENVIRONMENT == 'development')
        {
            $ch = curl_init("http://localhost:85/avanza_facturacion_github/api/Conta/buscar_cliente?rfc=".$rfc[0]['rfc']);
        }
        else
        {
            $ch = curl_init("http://avanzaf.hegarss.com/api/Conta/buscar_cliente?rfc=".$rfc[0]['rfc']);
        }


       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
       $resu = curl_exec($ch);
       $response = json_decode($resu);

       $data = array();
      // var_dump($rfc[0]['rfc']);
       foreach($response->data as $cli)
       {
           $row = array();
           $row[] = '<button type="button" class="btn btn-primary" onclick="returnIdCliente(\''.$cli->nombreC.'\',\''.$cli->clave.'\',\''.$cli->rfc.'\',\''.$cli->id_cliente.'\')" data-dismiss="modal" aria-hidden="true" >Seleccione</button>';
           $row[] = $cli->id_cliente;
           $row[] = $cli->clave;
           $row[] = $cli->nombreC;
           $row[] = $cli->rfc;
           $row[] = $cli->calle;
           $row[] = $cli->eMail;
           $row[] = $cli->telefono;
           $data[] = $row;
       }
      $output =  array(
       'draw' => $this->input->post('draw'),       
       'data' => $data
     );
     $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function getpendientes()
    {
        $rfc =  $this->input->post('rfc');
        $pendiente = 0;
        
    //     if(ENVIRONMENT == 'development')
    //    {
    //         $ch = curl_init("http://localhost:85/git_hub_repo/avanza_buzon_github/api/Comprobantes/pendientes?empresa=".$rfc."&pendiente=".$pendiente);
    //     }
    //     else
    //     {
            $ch = curl_init("http://avanzab.hegarss.com/api/Comprobantes/pendientes?empresa=".$rfc."&pendiente=".$pendiente);
       // }


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $resu = curl_exec($ch);
        $response = json_decode($resu);
        if($response->status == false)
        {
             $data['comprobantes'] = [];    
        }
        else
        {
        $data['comprobantes'] = $response->data;
        }
        $this->load->view('beneficiarios/comprobantes_pendientes/tabla',$data);
           
       

        
    }
    public function guardarasientoprovicion()
    {
        date_default_timezone_set("America/Mexico_City");
        setlocale(LC_TIME, 'es_ES.UTF-8');

        $tipo = $this->input->post('tm');
        $no_banco = $this->input->post('nob');
        $no_mov = $this->input->post('nom');
        $cta = $this->input->post('ct');
        $sub_cta = $this->input->post('su_cta');
        $monto = $this->input->post('mon');
        $ren = $this->input->post('re');
        $c_a = $this->input->post('ca');
        $fecha = $this->input->post('fec');
        $conce = $this->input->post('conce');
        $refe = $this->input->post('refe');
        $factref = $this->input->post('factre');
        $no_prov = $this->input->post('nopro');
        $ssub_cta = $this->input->post('ssu_cta');
        $idsiento = $this->input->post('idasiento');
        $tipoasiento = $this->input->post('tipoasiento');
        $bancoasiento = $this->input->post('bancoid');
        $moovasiento = $this->input->post('movid');
        $fechacon = $this->input->post('fechacon');
        $nombre_cuenta = $this->input->post('nombre_cuenta');

        $this->operaciones->borrarDetalle($idsiento);

        for($i=1; $i<count($tipo); $i++)
        {
            $monto[$i] = str_replace(',', '', $monto[$i]);
             $detalle = array(
                   'id_encabezado' => $idsiento,
                   'tipo_mov' => $tipo[$i],
                   'no_banco' => $no_banco[$i],
                   'no_mov' => $no_mov[$i],
                   'ren' => $ren[$i],
                   'cuenta' => $cta[$i],
                   'sub_cta' => $sub_cta[$i],
                   'monto' => $monto[$i],
                   'c_a' => $c_a[$i],
                   'fecha' => $fecha[$i],
                   'concepto' => $conce[$i],
                   'referencia' => $refe[$i],
                   'no_prov' => $no_prov[$i],
                   'factrefe' => $factref[$i],
                   'nombre_cuenta' => $nombre_cuenta[$i],
                   'ssub_cta' => $ssub_cta[$i]
                );

                $detalles= $this->operaciones->guardarDetalle($detalle);               
        }
        if($detalles > 0)
        {
            $this->output->set_content_type('application/json')->set_output(json_encode(1));
        }
        else
        {
            $this->output->set_content_type('application/json')->set_output(json_encode(0));
        }
    }
    public function insert_poliza_provision()
    {

        date_default_timezone_set("America/Mexico_City");
        setlocale(LC_TIME, 'es_ES.UTF-8');
        
        $tipo = $this->input->post('tipo');
       // $mov = $this->input->post('mov');
        $uuid = $this->input->post('uuid');
        $fecha = $this->input->post('fecha');
        $provee = $this->input->post('provee');
        $pago = $this->input->post('pago');
        $num_fa = $this->input->post('num_fact');
        $serie_pro = $this->input->post('serie_provisi');
        $referencia = $this->input->post('referencia');
        $total = $this->input->post('total');
        $benefinombre = $this->benefi->datosBenefi($provee);

         $conse = $this->operaciones->maxidPro();

         if(count($conse) > 0)
         {
            $mov = $conse[0]['no_mov'] + 1;
         }
         else
         {
            $mov = 1;
         }

        $poliza = $tipo.' '.' 0 '.'       '.$mov;

        $detalla = $this->input->post('detalle');

             $cuenta = $this->input->post('cuenta');
             $sub_cta = $this->input->post('sub_cta');
             $ssub_cta = $this->input->post('ssub_cta');
             $nom = $this->input->post('nom');
             $conce = $this->input->post('conce');
             $refe = $this->input->post('refe');
             $mon = $this->input->post('mon');
             $c_a = $this->input->post('c_a');

             $datos = array(
                 'tipo_mov' => $tipo,
                 'no_banco' => 0,
                 'no_mov' => $mov,
                 'fecha' => $fecha,
                 'beneficia' => $benefinombre[0]['nombre'],
                 'concepto' => '',
                 'monto' => 0.00,
                 'c_a' => '',
                 'cobrado' => 0,
                 'cerrado' => 0,
                 'no_prov' => $provee,
                 'fechaCobro' => NULL,
                 'impreso' => 0,
                 'afectar' => 0,
                 'bancosat' => '',
                 'bene_ctaban' => '',
                 'tieneCxP_pagos' => 0,
                 'cta_banco' => '',
                 'tipo_proveedor' => '',
                 'factura_provi' => $num_fa,
                 'serie_prov' => $serie_pro,
                 'uuid_provi' => $uuid
             );

             $mensaje=array();
             
             $id = $this->operaciones->crearPoliza($datos);
             if($id>0)
             {
                    for($i=1; $i<count($cuenta); $i++)
                    {
    
                        $detalle = array(
                            'id_encabezado' => $id,
                            'tipo_mov' => $tipo,
                            'no_banco' => 0,
                            'no_mov' => $mov,
                            'ren' => 0,
                            'cuenta' => $cuenta[$i],
                            'sub_cta' => $sub_cta[$i],
                            'monto' => $mon[$i],
                            'c_a' => $c_a[$i],
                            'fecha' => $fecha,
                            'concepto' => $conce[$i],
                            'referencia' => $refe[$i],
                            'no_prov' => $provee,
                            'factrefe' => 0,
                            'nombre_cuenta' => $nom[$i],
                            'ssub_cta' => $ssub_cta[$i]
                        );
                        
                        $detalle = $this->operaciones->guardarDetalle($detalle);
                    }

                    if($detalle > 0)
                    {
                        $mensaje[]=array('mensaje' => "Insertado Correctamente");

                        
                        if(ENVIRONMENT == 'development')
                        {
                            $ch = curl_init("http://localhost:85/git_hub_repo/avanza_buzon_github/api/Comprobantes/contabiliza");
                        }
                        else
                        {
                            $ch = curl_init("http://avanzab.hegarss.com/api/Comprobantes/contabiliza");
                        }

                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                            curl_setopt($ch, CURLOPT_POSTFIELDS, "uuid=".$uuid."&fecha=".$fecha."&poliza=".$poliza."&referencia=".$referencia);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                            $resu = curl_exec($ch);
                            $response = json_decode($resu);

                            $crearopera = array('usuario' => $_SESSION['nombreU'],
                                                'tipo_mov' => $tipo,
                                                'no_banco' => 0,
                                                'no_mov' => $mov,
                                                'accion' => 'Agregar',
                                                'cuando' => date('Y-m-d H:i:s'),
                                                'comentario' => 'Agrego poliza de provision con tipo: '.$tipo.' numero de movimiento: '.$mov,
                                                'modulo' => 'Catalogos -> Beneficiario -> Estafeta');
                              $this->bitacora->operacion($crearopera);
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

    public function getarchivos()
    {
        $uuid = $this->input->post('uuid');

       //  if(ENVIRONMENT == 'development')
        // {
        //      $ch = curl_init("http://localhost:85/git_hub_repo/avanza_buzon_github/api/Comprobantes/archivos?uuid=".$uuid);
        //  }
        //  else
        //  {
            $ch = curl_init("http://avanzab.hegarss.com/api/Comprobantes/archivos?uuid=".$uuid);
        // }


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $resu = curl_exec($ch);
        $response = json_decode($resu);

        $noEstan = [];
              if($response->xml == false)
              {
                 $response= array('status' => false,'error' => 'El archivo no existe.');
                 $this->output->set_content_type('application/json')->set_output(json_encode($response));
              }
              else
              {
                  $this->xmlDom = new DOMDocument();
                  $this->xmlDom->loadXML($response->xmlContent);

                  $sumaimporte = 0;
                  $sumatrasla = 0;
                  $clave = [];
                  $completo = [];
                  $combinados = [];

                  $ConceotList = $this->xmlDom->getElementsByTagName('Concepto');
                  foreach($ConceotList as $concepto)
                  {
                     $completo[] = [
                           'clave' => $concepto->getAttribute('ClaveProdServ'),
                           //'importe' => $concepto->getAttribute('Importe')
                           'descripcion' => $concepto->getAttribute('Descripcion')
                        ];

                         $sumaimporte = $sumaimporte + $concepto->getAttribute('Importe');
                  }


                  //ORDENAR
                foreach ($completo as $key => $row) 
                {
                    $aux[$key] = $row['clave'];
                }

                array_multisort($aux, SORT_ASC, $completo);

                foreach ($completo as $key => $row) 
                {
                    $ordenado[] = ['clave' => $row['clave'],'descripcion' => $row['descripcion']];
                }

                 //ELIMINAR
                $arraySinDuplicados = [];

                foreach($ordenado as $elemento) 
                {
                    if (!in_array($elemento, $arraySinDuplicados)) 
                    {
                        $arraySinDuplicados[] = $elemento;
                    }
                }



                $noEstan = [];
                 //BUSCAR NO EXISTEN
                foreach($arraySinDuplicados as $clave)
                {
                  //  var_dump($clave['clave']);
                   $row =  $this->dicuentas->buscariguales($clave['clave']);
                   $descrip = $this->catalogos->selectprodser($clave['clave']);
                    //var_dump($descrip);
                   if(count($row) > 0)
                   {

                   }
                   else
                   {

                       $noEstan[] = [ 
                                       'clave' => $clave['clave'],
                                       'descripcionxml' => strlen($clave['descripcion']) <= 40 ? substr($clave['descripcion'],0,25) : substr($clave['descripcion'],0,25),
                                       'descripcionSAT' => $descrip[0]['descripcion']
                                    ];

                   }
                }

              }

            //  var_dump($noEstan);

              $response = array('status' => true,'data' => $noEstan);

              $this->output->set_content_type('application/json')->set_output(json_encode($response));

    }
    public function insertdic()
    {
        $datos = $this->input->post('datos');

        for ($i=0; $i < count($datos) ; $i++) 
        {
            var_dump($datos[$i]);
            $data = array('codigoSAT' => $datos[$i][4],'cuenta' => $datos[$i][0],'sub_cta' => $datos[$i][1],'ssub_cta' => $datos[$i][2]); 
            $this->dicuentas->insertdiccionario($data);
        }

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
    public function getPolizasPagoProveedor()
    {
        $nom_prov = $this->input->post('nom_prov');
  
        $benfeno = $this->benefi->datosbenerfc($nom_prov);

        $data = $this->operaciones->getpolizapagoproveedor($benfeno[0]['no_prov']);

        $datas['getpolizaspagoprove'] = $data;

        $this->load->view('beneficiarios/polizas_pagos_proveedor/tabla',$datas);
    }
    public function update_poliza()
    {
        $uuid = $this->input->post('uuid');
        $fecha_poliza = $this->input->post('fecha_poliza');
        $poliza = $this->input->post('poliza');

        if(ENVIRONMENT == 'development')
        {
            $ch = curl_init("http://localhost:85/git_hub_repo/avanza_buzon_github/api/Comprobantes/poliza_pago");
        }
        else
        {
            $ch = curl_init("http://avanzab.hegarss.com/api/Comprobantes/poliza_pago");
        }


        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "uuid=".$uuid."&fecha=".$fecha_poliza."&poliza=".$poliza);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $resu = curl_exec($ch);
        $response = json_decode($resu);

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function getaceptar()
    {

        date_default_timezone_set("America/Mexico_City");

        $uuid = $this->input->post('uuid');
        $estado = '';

        if(ENVIRONMENT == 'development')
        {
            $ch = curl_init("http://localhost:85/git_hub_repo/avanza_buzon_github/api/Comprobantes/acepta");            
        }
        else
        {
            $ch = curl_init("http://avanzab.hegarss.com/api/Comprobantes/acepta");
        }


        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "uuid=".$uuid."&estado=".$estado);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $resu = curl_exec($ch);
        $response = json_decode($resu);

        if($response->status == true)
        {
            $opera = array('usuario' => $_SESSION['nombreU'],
            'tipo_mov' => '',
            'no_banco' => '',
            'no_mov' => '',
            'accion' => 'Aceptar',
            'cuando' => date('Y-m-d H:i:s'),
            'comentario' => 'Acepto el comprobante pendiente con UUID: '.$uuid,
            'modulo' => 'Catalogos -> Beneficiario -> Estafeta');
             $this->bitacora->operacion($opera);
        }

       $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function insertardatoscorreo()
    {
        // date_default_timezone_set("America/Mexico_City");

        // $tipo_com = $this->input->post('tip_com');
        // $versio = $this->input->post('vers');
        // $uuid = $this->input->post('uuid');
        // $foli = $this->input->post('foli');
        // $seri = $this->input->post('seri');
        // $fecha = $this->input->post('fecha');
        // $fom_pa = $this->input->post('fom_pa');
        // $met_pa = $this->input->post('met_pa');
        // $cta = $this->input->post('cta');
        // $est = $this->input->post('est');
        // $cod_sat = $this->input->post('cod_sat');
        // $mone = $this->input->post('mone');
        // $tipo_cam = $this->input->post('tipo_cam');
        // $rfc = $this->input->post('rfc');
        // $nom = $this->input->post('nom');
        // $recep = $this->input->post('recep');
        // $subto = $this->input->post('subto');
        // $tasaiva = $this->input->post('tasaiva');
        // $iva = $this->input->post('iva');
        // $retiva = $this->input->post('retiva');
        // $reisar = $this->input->post('reisar');
        // $tasaiep = $this->input->post('tasaiep');
        // $ieps = $this->input->post('ieps');
        // $total = $this->input->post('total');

        // if(ENVIRONMENT == 'development')
        // {
        //             $ch = curl_init("http://localhost:85/git_hub_repo/avanza_buzon_github/api/Comprobantes/uploadpdf");
        // }
        // else
        // {
        //     $ch = curl_init("http://avanzab.hegarss.com/api/Comprobantes/uploadpdf");
        // }


        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($ch, CURLOPT_POSTFIELDS, "empresa=".$recep.
        // "&tipo_com=".$tipo_com.
        // "&versio=".$versio.
        // "&foli=".$foli.
        // "&seri=".$seri.
        // "&fecha=".$fecha.
        // "&fom_pa=".$fom_pa.
        // "&met_pa=".$met_pa.
        // "&cta=".$cta.
        // "&est=".$est.
        // "&cod_sat=".$cod_sat.
        // "&mone=".$mone.
        // "&tipo_cam=".$tipo_cam.
        // "&rfc=".$rfc.
        // "&nom=".$nom.
        // "&recep=".$recep.
        // "&subto=".$subto.
        // "&tasaiva=".$tasaiva.
        // "&iva=".$iva.
        // "&retiva=".$retiva.
        // "&reisar=".$reisar.
        // "&tasaiep=".$tasaiep.
        // "&ieps=".$ieps.
        // "&total=".$total);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // $resu = curl_exec($ch);
        // $response = json_decode($resu);

        // if($response->status == true)
        // {
        //     $opera = array('usuario' => $_SESSION['nombreU'],
        //     'tipo_mov' => '',
        //     'no_banco' => '',
        //     'no_mov' => '',
        //     'accion' => 'Agregar',
        //     'cuando' => date('Y-m-d H:i:s'),
        //     'comentario' => 'Agrego el registro manualmente con UUID: '.$uuid,
        //     'modulo' => 'Catalogos -> Beneficiario -> Estafeta');
        //      $this->bitacora->operacion($opera);
        // }

      //  $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function getrechazo()
    {

        date_default_timezone_set("America/Mexico_City");

        $uuid = $this->input->post('uuid');

        if(ENVIRONMENT == 'development')
        {
            $ch = curl_init("http://localhost:85/git_hub_repo/avanza_buzon_github/api/Comprobantes/rechaza");
        }
        else
        {
            $ch = curl_init("http://avanzab.hegarss.com/api/Comprobantes/rechaza");
        }


        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "uuid=".$uuid);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $resu = curl_exec($ch);
        $response = json_decode($resu);

        if($response->status == true)
        {
            $opera = array('usuario' => $_SESSION['nombreU'],
            'tipo_mov' => '',
            'no_banco' => '',
            'no_mov' => '',
            'accion' => 'Rechazar',
            'cuando' => date('Y-m-d H:i:s'),
            'comentario' => 'Rechazo el comprobante pendiente con UUID: '.$uuid,
            'modulo' => 'Catalogos -> Beneficiario -> Estafeta');
             $this->bitacora->operacion($opera);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function borrarpoliza()
    {
        date_default_timezone_set("America/Mexico_City");

        $uuid = $this->input->post('uuid');
        $poliza = $this->input->post('poliza');

        $int = (int) filter_var($poliza, FILTER_SANITIZE_NUMBER_INT);
        
        if(ENVIRONMENT == 'development')
        {
             $ch = curl_init("http://localhost:85/git_hub_repo/avanza_buzon_github/api/Comprobantes/borrarpoliza");
        }
        else
        {
            $ch = curl_init("http://avanzab.hegarss.com/api/Comprobantes/borrarpoliza");
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "uuid=".$uuid);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $resu = curl_exec($ch);
        $response = json_decode($resu);

        if($response->status == true)
        {

            $this->operaciones->borrarprovisiondetalle($int);
            $opera = array('usuario' => $_SESSION['nombreU'],
            'tipo_mov' => '',
            'no_banco' => '',
            'no_mov' => '',
            'accion' => 'Borra póliza',
            'cuando' => date('Y-m-d H:i:s'),
            'comentario' => 'Borro la póliza del uuid: '.$uuid,
            'modulo' => 'Catalogos -> Beneficiario -> Cuentas por pagar');
             $this->bitacora->operacion($opera);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function quitaraceptacion()
    {
        date_default_timezone_set("America/Mexico_City");

        $uuid = $this->input->post('uuid');
        
        if(ENVIRONMENT == 'development')
        {
             $ch = curl_init("http://localhost:85/git_hub_repo/avanza_buzon_github/api/Comprobantes/desacepta");
        }
        else
        {
            $ch = curl_init("http://avanzab.hegarss.com/api/Comprobantes/desacepta");
        }        

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "uuid=".$uuid);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $resu = curl_exec($ch);
        $response = json_decode($resu);

        if($response->status == true)
        {
            $opera = array('usuario' => $_SESSION['nombreU'],
            'tipo_mov' => '',
            'no_banco' => '',
            'no_mov' => '',
            'accion' => 'Des-aceptar',
            'cuando' => date('Y-m-d H:i:s'),
            'comentario' => 'Des-acepto la factura con UUID: '.$uuid,
            'modulo' => 'Catalogos -> Beneficiario -> Cuentas por pagar');
             $this->bitacora->operacion($opera);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function eliminarfactura()
    {

        date_default_timezone_set("America/Mexico_City");

        $uuid = $this->input->post('uuid');
        
        if(ENVIRONMENT == 'development')
        {
             $ch = curl_init("http://localhost:85/git_hub_repo/avanza_buzon_github/api/Comprobantes/delete");
        }
        else
        {
            $ch = curl_init("http://avanzab.hegarss.com/api/Comprobantes/delete");
        }


        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "uuid=".$uuid);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $resu = curl_exec($ch);
        $response = json_decode($resu);

        if($response->status == true)
        {
            $opera = array('usuario' => $_SESSION['nombreU'],
            'tipo_mov' => '',
            'no_banco' => '',
            'no_mov' => '',
            'accion' => 'Eliminar',
            'cuando' => date('Y-m-d H:i:s'),
            'comentario' => 'Elimino la factura con UUID: '.$uuid,
            'modulo' => 'Catalogos -> Beneficiario -> Cuentas por pagar');
             $this->bitacora->operacion($opera);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function quitarpago()
    {
        date_default_timezone_set("America/Mexico_City");

        $uuid = $this->input->post('uuid');
        $poliza = $this->input->post('poliza');
        $empresa = $this->input->post('empresa');

        if(ENVIRONMENT == 'development')
        {
            $ch = curl_init("http://localhost:85/git_hub_repo/avanza_buzon_github/api/Comprobantes/quita_poliza_pago");
        }
        else
        {
            $ch = curl_init("http://avanzab.hegarss.com/api/Comprobantes/quita_poliza_pago");
        }


        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "uuid=".$uuid."&poliza=".$poliza."&empresa=".$empresa);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $resu = curl_exec($ch);
        $response = json_decode($resu);

        if($response->status == true)
        {
           $opera = array('usuario' => $_SESSION['nombreU'],
                          'tipo_mov' => '',
                          'no_banco' => '',
                          'no_mov' => '',
                          'accion' => 'Liberar',
                          'cuando' => date('Y-m-d H:i:s'),
                          'comentario' => 'Quito el pago de la poliza: '.$poliza.' con el UUID: '.$uuid,
                          'modulo' => 'Catalogos -> Beneficiario -> Cuentas por pagar');
                          $this->bitacora->operacion($opera);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function bitacoraalmacena()
    {

        $xml = file_get_contents($_FILES['xml']['tmp_name']);

          $this->xmlDom = new DOMDocument();
          $this->xmlDom->loadXML($xml);

          $uuid=$this->getAttribute('cfdi:Comprobante/cfdi:Complemento/tfd:TimbreFiscalDigital/@UUID');


        $opera = array('usuario' => $_SESSION['nombreU'],
                    'tipo_mov' => '',
                    'no_banco' => '',
                    'no_mov' => '',
                    'accion' => 'Cargar',
                    'cuando' => date('Y-m-d H:i:s'),
                    'comentario' => 'Almaceno comprobante con UUID: '.$uuid,
                    'modulo' => 'Catalogos -> Beneficiario -> Estafeta');
                    
        $this->bitacora->operacion($opera);
    }
    public function ajax_list_bancos()
    {
        $list = $this->banben->get_datatables();

        $data = array();

        foreach($list as $banc)
        {
            $row = array();
            $row[] = '<button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-primary" onclick="seleccionarbanco(\''.$banc->no_prov.'\',\''.$banc->bancoSat.'\',\''.$banc->nombre.'\',\''.$banc->ctaBan.'\')">Seleccione</button>';
            $row[] = $banc->no_prov;
            $row[] = $banc->bancoSat;
            $row[] = $banc->nombre;
            $row[] = $banc->ctaBan;
            $data[] = $row;
        }

        $output =  array(
            'draw' => $this->input->post('draw'),
            'recordsTotal' => $this->banben->count_all(),
            'recordsFiltered' => $this->banben->count_filtered(),
            'data' => $data
         );
         $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function ajax_list_beneficiarios2()
    {
        $list = $this->benefi->get_datatables();

        $data = array();

        foreach($list as $banc)
        {
            $row = array();
            $row[] = '<button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-primary" onclick="selectbenefi2(\''.$banc->no_prov.'\',\''.$banc->nombre.'\')">Seleccione</button>';
            $row[] = $banc->no_prov;
            $row[] = $banc->nombre;
            $row[] = $banc->rfc;
            $row[] = $banc->direccion;
            $row[] = $banc->telefono;
            $row[] = $banc->tipo_prov;
            $data[] = $row;
        }

        $output =  array(
            'draw' => $this->input->post('draw'),
            'recordsTotal' => $this->benefi->count_all(),
            'recordsFiltered' => $this->benefi->count_filtered(),
            'data' => $data
         );
         $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function ajax_list_beneficiarios()
    {
        $list = $this->benefi->get_datatables();

        $data = array();

        foreach($list as $banc)
        {
            $row = array();
            $row[] = '<button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-primary" onclick="selectbenefi(\''.$banc->no_prov.'\',\''.$banc->nombre.'\',\''.$banc->rfc.'\',\''.$banc->direccion.'\',\''.$banc->telefono.'\',\''.$banc->tipo_prov.'\')">Seleccione</button>';
            $row[] = $banc->no_prov;
            $row[] = $banc->nombre;
            $row[] = $banc->rfc;
            $row[] = $banc->direccion;
            $row[] = $banc->telefono;
            $row[] = $banc->tipo_prov;
            $data[] = $row;
        }

        $output =  array(
            'draw' => $this->input->post('draw'),
            'recordsTotal' => $this->benefi->count_all(),
            'recordsFiltered' => $this->benefi->count_filtered(),
            'data' => $data
         );
         $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function ajax_list()
    {
        $permisos = $this->permisosForma($_SESSION['id'],8);
        $edit = $permisos['edit'];
        $del = $permisos['del'];
        if($edit == "0"){$edit='class="disabled"';}else{$edit="";}
        if($del == "0"){$del='class="disabled"';}else{$del="";}

        $list = $this->benefi->get_datatables();
        $rfc = $this->configModel->getConfig();



        $data = array();
        foreach($list as $bene)
        {
            $row = array();
            $row[] = $bene->no_prov;
            $row[] = $bene->nombre;
            $row[] = $bene->rfc;
            $row[] = $bene->direccion.' '.$bene->no_interior;
            $row[] = $bene->telefono;
            $row[] = $bene->tipo_prov;
            $row[] = '<a href="'.base_url().'/catalogos/Beneficiarios/editar/'.$bene->no_prov.'" '.$edit.' class="btn btn-primary" title="Editar Beneficiario"><i class="fa fa-pencil-square-o"></i></a>
            <a href="#" onClick="EliminarBenefici(\''.$bene->no_prov.'\')" '.$del.' class="btn btn-danger" title="Eliminar Beneficiario"><i class="fa fa-times"></i></a>
             <button type="button" title="Cuentas por Pagar" onclick="abrircuentaspagar(\''.$rfc[0]['rfc'].'\',\''.$bene->no_prov.'\',\''.$bene->nombre.'\',\''.$bene->rfc.'\',\''.$bene->direccion.'\',\''.$bene->tipo_prov.'\')" class="btn btn-success"><i class="fa fa-dollar"></i>
            </button>';
            
            $data[] = $row;
        }

        $output =  array(
           'draw' => $this->input->post('draw'),
           'recordsTotal' => $this->benefi->count_all(),
           'recordsFiltered' => $this->benefi->count_filtered(),
           'data' => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function agregar($mensaje = null)
    {
        if($this->aauth->is_loggedin())
        {
            $permisos = $this->permisosforma($_SESSION['id'],8);

            $noprov = $this->benefi->getNoProv();
            $datas = $noprov[0]['no_prov'] + 1;

            if(isset($permisos) && $permisos['add'] == "1")
            {
                $emp = $this->empresas->datosEmpresa($_SESSION['idEmpresa']);
                if($emp[0]['usactacontable'] == 1)
                {
                  $configcta = $this->configcuentas->getidcuentaconfi(29);
                  $cuentactabene = $configcta[0]['cuenta'].'-'.$configcta[0]['sub_cta'].'-';
                }
                else
                {
                  $cuentactabene = '';
                }

                 $rfc = $this->input->get('rfc');
                 $nombre = $this->input->get('nombre');
                 $data = array('titulo' => 'Nuevo beneficiario','datas' => $datas,'configcta' => $cuentactabene,'rfc' => $rfc,'nombre' => $nombre,'accion' => 'catalogos/Beneficiarios/guardarbenefi','permisosGrupo' => $permisos, 'mensaje' => $mensaje);
                 $this->load->view('templates/navigation',$data);
                 $this->load->view('beneficiarios/beneficiarios');
                 $this->load->view('templates/footer');
            }
            else
            {
                redirect('catalogos/beneficiarios/index','refresh');
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
            $permisos = $this->permisosForma($_SESSION['id'],8);
             if(isset($permisos) && $permisos['add'] == "1")
             {
                $emp = $this->empresas->datosEmpresa($_SESSION['idEmpresa']);
                if($emp[0]['usactacontable'] == 1)
                {
                  $configcta = $this->configcuentas->getidcuentaconfi(29);
                  $cuentactabene = $configcta[0]['cuenta'].'-'.$configcta[0]['sub_cta'].'-';
                }
                else
                {
                  $cuentactabene = '';
                }

                  $datos=$this->benefi->datosBenefi($id);
                  $detalle = $this->benefi->detallebene($datos[0]['no_prov']);
                  $data = array('titulo' => 'Editar beneficiario','configcta' => $cuentactabene, 'accion' => 'catalogos/Beneficiarios/guardarbenefi','permisosGrupo' => $permisos, 'datos' => $datos, 'detalle' => $detalle);
                  $this->load->view('templates/navigation',$data);
                  $this->load->view('beneficiarios/beneficiarios');
                  $this->load->view('templates/footer');
             }
             else
             {
                 redirect('catalogos/beneficiarios/index','refresh');
             }
        }
        else
        {
            redirect('/inicio/login','refresh');
        }
    }
    public function guardatosbenefi($id)
    {
               $correcto = false;
                        $datos = array(
                            'no_prov' => $this->input->post('no_prov'),
                            'nombre' => $this->input->post('nombre'),
                            'direccion' => $this->input->post('direccion'),
                            'no_interior' => $this->input->post('no_inte'),
                            'no_exterior' => $this->input->post('no_ext'),
                            'ciudad' => $this->input->post('ciudad'),
                            'colonia' => $this->input->post('colonia'),
                            'municipio' => $this->input->post('municipio'),
                            'estado' => $this->input->post('estado'),
                            'pais' => $this->input->post('pais'),
                            'cp' => $this->input->post('cp') ? $this->input->post('cp') : 0,
                            'curp' => $this->input->post('curp'),
                            'rfc' => $this->input->post('rfc'),
                            'telefono' => $this->input->post('telefono'),
                            'email' => $this->input->post('email'),
                            'solo_credito' => 0,
                            'no_cta' => $this->input->post('no_cta') ? $this->input->post('no_cta') : 0,
                            'sub_cta' => $this->input->post('sub_cta') ? $this->input->post('sub_cta') : 0,
                            'ctacom' => $this->input->post('cta_com') ? $this->input->post('cta_com') : 0,
                            'subcom' => $this->input->post('sub_com') ? $this->input->post('sub_com') : 0,
                            'vencim' => $this->input->post('venci') ? $this->input->post('venci') : 0,
                            'concepto' => $this->input->post('concep') ? $this->input->post('concep') : '',
                            'tipo_prov' => $this->input->post('tipo'),
                            'centro_costos' => $this->input->post('cen_cos'),
                            'no_cta3' => $this->input->post('no_cta3') ? $this->input->post('no_cta3') : 0,
                            'sub_cta3' => $this->input->post('sub_cta3') ? $this->input->post('sub_cta3') : 0,
                            'traslada_ieps' => $this->input->post('trasieps'),
                            'conciliado' => $this->input->post('concilia1'),
                            'cta_contable' => $this->input->post('cta_contable') != '' ? $this->input->post('cta_contable') : null,
                        );

                        if($id>0)
                        {
                            $opera = array('usuario' => $_SESSION['nombreU'],
                                            'tipo_mov' => '',
                                            'no_banco' => '',
                                            'no_mov' => '',
                                            'accion' => 'Modificar',
                                            'cuando' => date('Y-m-d H:i:s'),
                                            'comentario' => 'Modifico el proveddor numero: '.$this->input->post('no_prov'),
                                            'modulo' => 'Catalogos -> Beneficiario');
                                $this->bitacora->operacion($opera);
                            $correcto=$this->benefi->EditarBeneficiario($id,$datos);
                            $tra = 0;
                        }
                        else
                        {
                            $checar = $this->benefi->verificarsiexiste($this->input->post('no_prov'));

                            if(count($checar) > 0)
                            {
                               return $mensaje = array('status' => 0,'mensage' => 'Ya existe este numero de beneficiario.');
                                $tra = 1;
                            }
                            else
                            {
                                $opera = array('usuario' => $_SESSION['nombreU'],
                                            'tipo_mov' => '',
                                            'no_banco' => '',
                                            'no_mov' => '',
                                            'accion' => 'Agregar',
                                            'cuando' => date('Y-m-d H:i:s'),
                                            'comentario' => 'Agrego la beneficiario ó proveedor: '.$this->input->post('nombre'). ' con numero: '.$this->input->post('no_prov'),
                                            'modulo' => 'Catalogos -> Beneficiario');
                                $this->bitacora->operacion($opera);

                                $correcto=$this->benefi->crearBeneficiario($datos);
                                $tra = 0;

                            }
                        }

                        if($tra == 0)
                        {
                            if($correcto == true)
                            {

                                $this->benefi->borrarbancoDetalle($this->input->post('no_prov'));
                    
                                $clav = $this->input->post('clave');
                                $nomb = $this->input->post('nomb');
                                $no_cu = $this->input->post('no_cuent');
                                
                                if(isset($clav[1]))
                                {
                                    $vr = 1;
                                }
                                else
                                {
                                    $vr = 0;
                                }
                                if($vr == 1)
                                {
                                    if(count($clav) > 0)
                                    {
                                        for($i=1; $i<count($clav); $i++)
                                        {
                                            $detalle = array(
                                                'no_prov' => $this->input->post('no_prov'),
                                                'ctaBan' => $no_cu[$i],
                                                'bancoSat' => $clav[$i],
                                                'ctaClabe' => '',
                                                'nombre' => $nomb[$i]
                                            );
                                            $detalle = $this->benefi->guardarDetalle($detalle);
                                        }

                                        if($detalle > 0)
                                        {
                                              return $mensaje = array('status' => 1,'mensage' => 'Insertado correctamente.');
                                        
                                        }
                                        else
                                        {
                                           return $mensaje = array('status' => 2,'mensage' => 'Hubo un error al insertar el banco del beneficiario.');
                                        }
                                    }
                                    else
                                    {
                                        return $mensaje = array('status' => 1,'mensage' => 'Insertado correctamente.');
                                    }
                                }
                                else
                                {
                                    return $mensaje = array('status' => 1,'mensage' => 'Insertado correctamente.');
                                }

                            }
                            else
                            {
                                return $mensaje = array('status' => 2,'mensage' => 'Hubo un error la insertar los datos, intentelo mas tarde.');
                            
                            }
                        }
    }
    public function guardarbenefi()
    {
        date_default_timezone_set("America/Mexico_City");
        $id = $this->input->post('id');


         $emp = $this->empresas->datosEmpresa($_SESSION['idEmpresa']);

          if($emp[0]['usactacontable'] == 1 && $this->input->post('cta_contable') == '')
         {
                    $mensaje = array('status' => 3,'mensage' => 'Su empresa esta configurada para que agregue una cuenta contable a su beneficiario o proveedor.');
         }
         else
         {
                if($this->input->post('cta_contable') != '')
                {
                    $cta = explode('-',$this->input->post('cta_contable'));
                    $ctaexis = $this->cuentas->verificarsiexiste($cta[0],$cta[1],$cta[2]);
                    if(count($ctaexis) == 0)
                    {
                        $mensaje = array('status' => 2,'mensage' => 'La cuenta contable que registro, no existe en el catalogo de cuentas.');
                    }
                    else
                    {
                        $mensaje = $this->guardatosbenefi($id);
                    }
                }
                else 
                {
                   $mensaje = $this->guardatosbenefi($id);
                }
         }

      $this->output->set_content_type('application/json')->set_output(json_encode($mensaje));
    }
    public function eliminar($id)
    {
        date_default_timezone_set("America/Mexico_City");
        if($this->aauth->is_loggedin())
        {
            $datos = $this->benefi->datosBenefi($id);
             $permisos = $this->permisosForma($_SESSION['id'],8);
             if(isset($permisos) && $permisos['del'] == "1")
             {
                 $res=$this->benefi->borrarBenefi($id);
                 if($res==true)
                 {
                    $opera = array('usuario' => $_SESSION['nombreU'],
                    'tipo_mov' => '',
                    'no_banco' => '',
                    'no_mov' => '',
                    'accion' => 'Eliminar',
                    'cuando' => date('Y-m-d H:i:s'),
                    'comentario' => 'Elimino al proveedor : '.$datos[0]['nombre']. ' RFC: '.$datos[0]['rfc'].' con numero: '.$datos[0]['no_prov'],
                    'modulo' => 'Catalogos -> Beneficiario');
                     $this->bitacora->operacion($opera);
                     
                     header('Location:'.base_url()."catalogos/beneficiarios/index",301);
                     exit();
                 }
             }
             else
             {
                 redirect('catalogos/beneficiarios/index','refresh');
             }
        }
        else
        {
            redirect('/inicio/login','refresh');
        }
    }
    public function getbeneficiario()
    {
        $id = $this->input->post('id'); 

        $ben = $this->benefi->datosBenefi($id);

        $this->output->set_content_type('application/json')->set_output(json_encode($ben));
    }
    public function getbeneficirfc()
    {
        $rfc = $this->input->post('rfc');

        $ben = $this->benefi->datosbenerfc($rfc);

        $this->output->set_content_type('application/json')->set_output(json_encode($ben));
    }
}