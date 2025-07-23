<?php


class Herramientas extends MY_Controller 
{
    public function __construct()
    {
       parent::__construct();
       $this->load->model('menuModel');
       $items=$this->menuModel->menus($_SESSION['tipo']);
       $this->multi_menu->set_items($items);
       $this->load->view('templates/header');
       $this->load->model('Configuraciones_model','configModel');
       $this->load->model('ConfigCuentasModel','conficue');
       $this->load->model('OperacionesModel','opera');
       $this->load->library('PHPExcel');
    }

    public function index()
    {
        if($this->aauth->is_loggedin())
        {
           $errores=array();
           $rfc = $this->configModel->getConfig();
           $permisos=$this->permisosForma($_SESSION['id'],15);
           $data=array('titulo'=>'Importa información de facturas desde Excel','rfc'=>$rfc[0]['rfc'],'razon'=>$this->validaempresas->get_razon($_SESSION['idEmpresa']),'errores'=>$errores,'permisosGrupo'=>$permisos);
           $items=$this->menuModel->menus($_SESSION['tipo']);
           $this->multi_menu->set_items($items);
           $this->load->view('templates/header');
           $this->load->view('templates/navigation',$data);
           $this->load->view('herramientas/index');
           $this->load->view('templates/footer');
        }
        else
        {
            redirect('inicio/login','refresh');
        }
    }
    public function upload()
    {
        date_default_timezone_set("America/Mexico_City");
            $excel = $_FILES['excel']['name'];
            $archivo = $_FILES['excel']['tmp_name'];
            if(!$archivo)
            {
                echo json_encode(array('status' => false, 'code' => 0 ,'data' => 'No ha seleccionado el archivo excel a cargar'));
                exit;
            }

            $objPHPExcel = PHPExcel_IOFactory::load($archivo);

            foreach($objPHPExcel->getWorksheetIterator() as $worksheet)
            {
                $worksheetTitle     = $worksheet->getTitle();
                $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

                for ($row = 2; $row <= $highestRow; ++ $row) 
                {
                    $tipo = $worksheet->getCellByColumnAndRow('0',$row)->getCalculatedValue(); //Serie
                    $folio = $worksheet->getCellByColumnAndRow('1',$row)->getCalculatedValue(); //Folio
                    $fecha = $worksheet->getCellByColumnAndRow('2',$row)->getCalculatedValue() ; //Fecha
                    $fecha = date('Y-m-d',strtotime($fecha)); //Convertir a formato Y-m-d
                    $rfc = $worksheet->getCellByColumnAndRow('3',$row)->getCalculatedValue(); //RFC
                    $cliente = $worksheet->getCellByColumnAndRow('4',$row)->getCalculatedValue(); //Cliente
                    $tc = $worksheet->getCellByColumnAndRow('5',$row)->getCalculatedValue(); //tc
                    $subtotal = $worksheet->getCellByColumnAndRow('6',$row)->getCalculatedValue(); //subtotal
                    $iva16 = $worksheet->getCellByColumnAndRow('7',$row)->getCalculatedValue(); //iva16
                    $retiva = $worksheet->getCellByColumnAndRow('8',$row)->getCalculatedValue(); //retiva
                    $ieps = $worksheet->getCellByColumnAndRow('9',$row)->getCalculatedValue(); //ieps
                    $retisr = $worksheet->getCellByColumnAndRow('10',$row)->getCalculatedValue(); //retisr
                    $total = $worksheet->getCellByColumnAndRow('11',$row)->getCalculatedValue(); //total
                    $metodo_pago = $worksheet->getCellByColumnAndRow('12',$row)->getCalculatedValue(); //metodo de pago
                    $objetoImp = $worksheet->getCellByColumnAndRow('13',$row)->getCalculatedValue(); //objeto de impuesto

                    $subtotalxtc = $tc * $subtotal;
                    $totalxtc = $tc * $total;

                    $max = $this->opera->maxid();
                    if($tipo == 'NC')
                    {
                        $serie = 'egreso';
                    }
                    else
                    {
                        $serie = 'ingreso';
                    }
                  //  var_dump($max);

                    $datos = array(
                        'tipo_mov' => 'I',
                        'no_banco' => 0,
                        'no_mov' => $folio,     //$max[0]['maxmov'],
                        'fecha' => $fecha, //date('Y-m-d H:i:s'),
                        'beneficia' => '',
                        'concepto' => 'Póliza de '.$serie .' de CFDI: '.$tipo.' '.$folio.' Cliente: '. $cliente,
                        'monto' => 0.00,
                        'c_a' => '',
                        'cobrado' => 0,
                        'cerrado' => 0,
                        'no_prov' => 0,
                        'fechaCobro' => null,
                        'impreso' => 1,
                        'afectar' => 0,
                        'bancosat' => '',
                        'bene_ctaban' => '',
                        'tieneCxP_pagos' => 0
                    );

                 $id = $this->opera->crearPoliza($datos);

                    //EL IVA DE LA FACTURA CON LA CONFIGURACION 10
                    if($iva16 > 0)
                    {
                        $cta = $this->conficue->getidcuentaconfi(10);
                        $detalle = array(
                            'id_encabezado' => $id,
                            'tipo_mov' => 'O',
                            'no_banco' => 0,
                            'no_mov' => $max[0]['maxmov'],
                            'ren' => 0,
                            'cuenta' => $cta[0]['cuenta'],
                            'sub_cta' => $cta[0]['sub_cta'],
                            'monto' => $iva16,
                            'c_a' => $serie == 'ingreso' ? '-' :'+',
                            'fecha' => $fecha,
                            'concepto' => $cliente,
                            'referencia' => $tipo.'-'.$folio,
                            'no_prov' =>  0,
                            'factrefe' => 0,
                            'nombre_cuenta' => $cta[0]['descrip'],
                            'ssub_cta' => $cta[0]['ssub_cta']
                        );
                        $detalle = $this->opera->guardarDetalle($detalle);
                    }
  
                    //LA RETIVA DE LA FACTURA CON LA CONFIGURACION 12
                    if($retiva > 0)
                    {
                        $cta = $this->conficue->getidcuentaconfi(12);
                        $detalle = array(
                            'id_encabezado' => $id,
                            'tipo_mov' => 'O',
                            'no_banco' => 0,
                            'no_mov' => $max[0]['maxmov'],
                            'ren' => 0,
                            'cuenta' => $cta[0]['cuenta'],
                            'sub_cta' => $cta[0]['sub_cta'],
                            'monto' => $retiva,
                            'c_a' => $serie == 'ingreso' ? '+' :'-',
                            'fecha' => $fecha,
                            'concepto' => $cliente,
                            'referencia' => $tipo.'-'.$folio,
                            'no_prov' => 0,
                            'factrefe' => 0,
                            'nombre_cuenta' => $cta[0]['descrip'],
                            'ssub_cta' => $cta[0]['ssub_cta']
                        );
                        $detalle = $this->opera->guardarDetalle($detalle);
                    }
  
                    // if($ieps > 0)
                    // {
                    //     $cta = $this->conficue->getidcuentaconfi(15);
                    //     $detalle = array(
                    //         'id_encabezado' => $id,
                    //         'tipo_mov' => 'O',
                    //         'no_banco' => 0,
                    //         'no_mov' => $max[0]['maxmov'],
                    //         'ren' => 0,
                    //         'cuenta' => $cuenta[$i],
                    //         'sub_cta' => $sub_cta[$i],
                    //         'monto' => $monto[$i],
                    //         'c_a' => '+',
                    //         'fecha' => $fecha,
                    //         'concepto' => $concepto[$i],
                    //         'referencia' => $referencia[$i],
                    //         'no_prov' => $no_prov_fac[$i] = '' ? $no_prov_fac[$i] : 0,
                    //         'factrefe' => 0,
                    //         'nombre_cuenta' => $nombre_cuenta[$i],
                    //         'ssub_cta' => $ssub_cta[$i]
                    //     );
                    //     $detalle = $this->opera->guardarDetalle($detalle);
                    // }
  
                    // if($retisr > 0)
                    // {
                    //     $cta = $this->conficue->getidcuentaconfi(15);
                    //     $detalle = array(
                    //         'id_encabezado' => $id,
                    //         'tipo_mov' => 'O',
                    //         'no_banco' => 0,
                    //         'no_mov' => $max[0]['maxmov'],
                    //         'ren' => 0,
                    //         'cuenta' => $cuenta[$i],
                    //         'sub_cta' => $sub_cta[$i],
                    //         'monto' => $monto[$i],
                    //         'c_a' => '+',
                    //         'fecha' => $fecha,
                    //         'concepto' => $concepto[$i],
                    //         'referencia' => $referencia[$i],
                    //         'no_prov' => $no_prov_fac[$i] = '' ? $no_prov_fac[$i] : 0,
                    //         'factrefe' => 0,
                    //         'nombre_cuenta' => $nombre_cuenta[$i],
                    //         'ssub_cta' => $ssub_cta[$i]
                    //     );
                    //     $detalle = $this->opera->guardarDetalle($detalle);
                    // }

                    //EL SUBTTOAL DE LA FACTURA SE IRA A LA CONFIGURACION 14
                    if($subtotal > 0)
                    {
                        if($objetoImp == '2' || $objetoImp == '3')
                        {
                            if($iva16 > 0)
                            {
                                if($metodo_pago == 'PPD')
                                {
                                   $cta = $this->conficue->getidcuentaconfi(14);
                                }
                                else
                                {
                                    $cta = $this->conficue->getidcuentaconfi(60);
                                }
                                
                            }
                            else
                            {
                                if($metodo_pago == 'PPD')
                                {
                                $cta = $this->conficue->getidcuentaconfi(13);
                                }
                                else
                                {
                                    $cta = $this->conficue->getidcuentaconfi(61);
                                }
                                
                            }
                            
                        }
                        else
                        {
                            if($metodo_pago == 'PPD')
                            {
                                $cta = $this->conficue->getidcuentaconfi(59);
                            }
                            else
                            {
                                $cta = $this->conficue->getidcuentaconfi(62);
                            }
                            
                        }
                       
                        $detalle = array(
                            'id_encabezado' => $id,
                            'tipo_mov' => 'O',
                            'no_banco' => 0,
                            'no_mov' => $max[0]['maxmov'],
                            'ren' => 0,
                            'cuenta' => $cta[0]['cuenta'],
                            'sub_cta' => $cta[0]['sub_cta'],
                            'monto' => $subtotalxtc,
                            'c_a' => $serie == 'ingreso' ? '-' :'+',
                            'fecha' => $fecha,
                            'concepto' => $cliente,
                            'referencia' => $tipo.'-'.$folio,
                            'no_prov' => 0,
                            'factrefe' => 0,
                            'nombre_cuenta' => $cta[0]['descrip'],
                            'ssub_cta' => $cta[0]['ssub_cta']
                        );
                        $detalle = $this->opera->guardarDetalle($detalle);                        
                    }
  
                    //TOTAL DE LA FACTURA CON LA CONFIGURACION 9 (CLIENTE MXN) O 57 CLIENTE USD
                    if($total > 0)
                    {
                        if($rfc == 'XEXX010101000')
                        {
                            $cta = $this->conficue->getidcuentaconfi(57);
                        }
                        else
                        {
                            $cta = $this->conficue->getidcuentaconfi(9);
                        }

                        $detalle = array(
                            'id_encabezado' => $id,
                            'tipo_mov' => 'O',
                            'no_banco' => 0,
                            'no_mov' => $max[0]['maxmov'],
                            'ren' => 0,
                            'cuenta' => $cta[0]['cuenta'],
                            'sub_cta' => $cta[0]['sub_cta'],
                            'monto' => $totalxtc,
                            'c_a' => $serie == 'ingreso' ? '+' :'-',
                            'fecha' => $fecha,
                            'concepto' => $cliente,
                            'referencia' => $tipo.'-'.$folio,
                            'no_prov' => 0,
                            'factrefe' => 0,
                            'nombre_cuenta' => $cta[0]['descrip'],
                            'ssub_cta' => $cta[0]['ssub_cta']
                        );
                        $detalle = $this->opera->guardarDetalle($detalle);
                    }
                }
            }

            echo json_encode(array('status' => true, 'code' => 0 ,'data' => 'Datos importados correctamente'));
            exit();
    }
}