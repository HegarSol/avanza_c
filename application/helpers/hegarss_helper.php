    <?php

defined('BASEPATH') or exit('No direct script access alloed');

/**
 * HEGAR HELPER
 * 
 * Funciones especificas de la empresa HEGAR Soluciones en Sistemas
 * 
 */

 if(! function_exists('get_configuracion_cliente'))
 {
     /**
      * GET CONFIGRUACION CLIENTE

      *Obtiene una configruacion de la base de datos del cliente especificado

      *@param id_empresa           Empresa de la cual se quiere recuperar la config
      *@param id_configruacion     Identiicador de la configuracion
      
      
      *@return mix
      */

      function get_configuracion_cliente($id_empresa, $id_configuracion)
      {
          $CI =& get_instance();
          $CI->load->library('hegardb');
          $CI->load->model('Configuracion_model');
          $CI->Configruaciones_model->set_database($id_empresa);
          $configuracion = $CI->Configuraciones_model->get_configuracion_by_id($id_configuracion);
          if( ! $configuracion){
              throw new RuntimeException('No se encuentra definida la configuracion: '. $id_empresa);
          }
          if($configuracion->tipo == 'C'){
              return $configuracion->value;
          }
          if($configuracion->tipo == 'N'){
              return floatval($configuracion->valor);
          }
          if($configuracion->valor == 'L'){
              return $configuracion->valor == '1' ? TRUE : FALSE;
          }
          throw new RuntimeException('El tipo de valor de la configuracion no es soportado');
      }
 }

 if(!function_exists('get_factura_poliza'))
{
    function get_factura_poliza($uuid,$nom_prov,$deta = 0,$porpaga = 0,$poli = '',$departa = 0)
    {

        $CI =& get_instance();

        $CI->load->model('DicCuentasModel','dicuentas');
        $CI->load->model('ConfigCuentasModel','conficue');
        $CI->load->model('Configuraciones_model','configcon');
        $CI->load->model('ConfiguracionesGenemodel','configene');
        $CI->load->model('CuentasModel','cuentas');
        $CI->load->model('BeneficiarioModel','beneficiario');

       $conf = $CI->configcon->getConfig();

       if(ENVIRONMENT == 'development')
       {
         $ch = curl_init("http://localhost:85/git_hub_repo/avanza_buzon_github/api/Comprobantes/archivos?uuid=".$uuid);
       }
       else
       {
         $ch = curl_init("http://avanzab.hegarss.com/api/Comprobantes/archivos?uuid=".$uuid);
       }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $resu = curl_exec($ch);
        $response = json_decode($resu);



        $CI->xmlDom = new DOMDocument();
        $CI->xmlDom->loadXML($response->xmlContent);
        $xml2 = simplexml_load_string($response->xmlContent);

        $sumaimpueiva16 = 0;
        $sumaimpueiva8 = 0;
        $sumareteniva = 0;
        $sumaretenisr = 0;
        $sumaretenisr4porflete = 0;
        $sumaimpueeips = 0;
        $sumatotalimpuestos = 0;
        $sumatotalretenciones = 0;
        $totalrealproacre = 0;
        $sumadescu = 0;

        $sumaimpueiva16c = 0;
        $sumaimpueiva8c = 0;
        $sumaretenivac = 0;
        $sumaretenisrc = 0;
        $sumaretenisr4porfletec = 0;
        $sumaimpueeipsc = 0;
        $sumatotalimpuestos8c = 0;
        $sumatotalretencionesc = 0;
        $totalrealproacrec = 0;
        $sumadescuc = 0;

        $sumatotalimpuestosg = 0;
        $sumatotalimpuestosc = 0;

        $sumaimpueiva16g = 0;
        $sumaimpueiva8g = 0;
        $sumaretenivag = 0;
        $sumaretenisrg = 0;
        $sumaretenisr4porfleteg = 0;
        $sumaimpueeipsg = 0;
        $sumatotalimpuestos8g = 0;
        $sumatotalretencionesg = 0;
        $totalrealproacreg = 0;
        $sumadescug = 0;

        $cimporteiva = 0;
        $ctasaiva = 0;
        $cimporteieps = 0;
        $ctasaieps = 0;
        $cimporteretiva = 0;
        $ctasaretiva = 0;
        $ctasaretisr = 0;
        $cimporteretisr = 0;
        $cimpuestoiva = 0;
        $cimpuestoieps = 0;
        $cimpuestoretiva = 0;
        $cimpuestoretisr = 0;
        
        $conceptos = [];
        $completo = [];
        $conceptos2 = [];

          //$totalfactu = $CI->getAttribute('cfdi:Comprobante/@Total');
          $totalfactu = (string) $xml2->attributes()->Total;
          $rfcReceptors = $CI->xmlDom->getElementsBytagName('Receptor');
          $rfcEmisor = $CI->xmlDom->getElementsBytagName('Emisor');
          $descuento = $CI->xmlDom->getElementsBytagName('Comprobante');
          foreach($rfcReceptors as $rfc)
          {
                $rfcReceptor = $rfc->getAttribute('Rfc');
          }
          foreach($rfcEmisor as $rfc)
          {
                $rfcEmisor = $rfc->getAttribute('Rfc');
          }
          foreach($descuento as $descu)
          {
                $descuent = $descu->getAttribute('Descuento') ? $descu->getAttribute('Descuento') : 0;
          }


          $emisordatos = $CI->beneficiario->datosbenerfc($rfcEmisor);
          $tieneieps = 0; 
          $iepss = [];
          $gastos = $CI->conficue->getidcuentaconfi(15);
          $compras = $CI->conficue->getidcuentaconfi(16);
                $conceplist = $CI->xmlDom->getElementsBytagName('Concepto');
                foreach($conceplist as $conceptod)
                {
                    
                                                 $cClave = $conceptod->getAttribute('ClaveProdServ');
                                                $cDescripcion = $conceptod->getAttribute('Descripcion');
                                                $cImporte = $conceptod->getAttribute('Importe');
                                                $cDescuento = $conceptod->getAttribute('Descuento') ? $conceptod->getAttribute('Descuento') : 0;
                                                
                                               
                                                foreach($conceptod->getElementsByTagName('Impuestos') as $impuesto)
                                                {
                                                    foreach($impuesto->getElementsByTagName('Traslados') as $traslado)
                                                    {
                                                        foreach($traslado->getElementsByTagName('Traslado') as $traslados)
                                                        {
                                                            if($traslados->getAttribute('Impuesto') == '002')
                                                            {                                                               
                                                                $cimporteiva =  (double) $traslados->getAttribute('Importe');
                                                                $ctasaiva = (double) $traslados->getAttribute('TasaOCuota');
                                                                $cimpuestoiva = $traslados->getAttribute('Impuesto');
                                                            }
                                                            else if($traslados->getAttribute('Impuesto') == '003')
                                                            {
                                                                $cimporteieps = (double) $traslados->getAttribute('Importe');
                                                                $ctasaieps = (double) $traslados->getAttribute('TasaOCuota');
                                                                $cimpuestoieps = $traslados->getAttribute('Impuesto');
                                                            }
                                                            
                                                        }
                                                    }
                                                    foreach($impuesto->getElementsByTagName('Retenciones') as $retencion)
                                                    {
                                                        foreach($retencion->getElementsByTagName('Retencion') as $retenciones)
                                                        {
                                                            if($retenciones->getAttribute('Impuesto') == '002')
                                                            {
                                                                $cimporteretiva = (double) $retenciones->getAttribute('Importe');
                                                                $ctasaretiva = (double) $retenciones->getAttribute('TasaOCuota');
                                                                $cimpuestoretiva = $retenciones->getAttribute('Impuesto');
                                                            }
                                                            else if($retenciones->getAttribute('Impuesto') == '001')
                                                            {
                                                                $cimporteretisr = (double) $retenciones->getAttribute('Importe');
                                                                $ctasaretisr = (double) $retenciones->getAttribute('TasaOCuota');
                                                                $cimpuestoretisr = $retenciones->getAttribute('Impuesto');
                                                            }
                                                        }
                                                    }
                                                    
                                                    
                                                  
                                                }

                                $row =  $CI->dicuentas->buscariguales($cClave);




                                $cCuenta = $row[0]['cuenta'];
                                $cSub_Cta = $row[0]['sub_cta'];
                                $cSsub_Cta = $row[0]['ssub_cta'];


                                $temsubcta =  isset($departa) && $departa > 0 ? $departa : 1;
                                $nom_cuen = $CI->cuentas->get_cuenta($cCuenta,$temsubcta,$cSsub_Cta);

                                $conceptos[] = [
                                    'clave' => $cClave,
                                    'importe' => $cImporte,
                                    'descuento' => $cDescuento,
                                    'descripcion' => $cDescripcion,
                                    'importeiva' => $cimporteiva,
                                    'tasaiva' => $ctasaiva,
                                    'importeieps' => $cimporteieps,
                                    'tasaieps' => $ctasaieps,
                                    'importeretiva' => $cimporteretiva,
                                    'tasaretiva' => $ctasaretiva,
                                    'tasaretisr' => $ctasaretisr,
                                    'importeretisr' => $cimporteretisr,
                                    'cuenta' => $cCuenta,
                                    'sub_cta' => isset($departa) && $departa > 0 ? $departa : 1,
                                    'ssub_cta' => $cSsub_Cta,
                                    'nombre_cta' =>  isset($nom_cuen[0]['nombre']) ? $nom_cuen[0]['nombre'] : 'No tiene esta cuenta',
                                    'impuestoiva' => $cimpuestoiva,
                                    'impuestoieps' => $cimpuestoieps,
                                    'impuestoretiva' => $cimpuestoretiva,
                                    'impuestoretisr' => $cimpuestoretisr,
                                ];

                }


                foreach ($conceptos as $key => $row) 
                {
                    $aux[$key] = $row['clave'];

                }

                array_multisort($aux, SORT_ASC, $conceptos);
                
                foreach ($conceptos as $key => $row) 
                {
                    $ordenado[] = ['clave' => $row['clave'],
                               'importe' => $row['importe'],
                               'descripcion' => $row['descripcion'],
                               'descuento' => $row['descuento'],
                               'importeiva' => $row['importeiva'],
                               'tasaiva' => $row['tasaiva'],
                               'tasaieps' => $row['tasaieps'],
                               'importeieps' => $row['importeieps'],
                               'importeretiva' => $row['importeretiva'],
                               'tasaretiva' => $row['tasaretiva'],
                               'tasaretisr' => $row['tasaretisr'],
                               'importeretisr' => $row['importeretisr'],
                               'cuenta' => $row['cuenta'],
                               'sub_cta' => $row['sub_cta'],
                               'ssub_cta' => $row['ssub_cta'],
                               'nombre_cta' =>  $row['nombre_cta'],
                               'impuestoiva' => $row['impuestoiva'],
                                 'impuestoieps' => $row['impuestoieps'],
                                    'impuestoretiva' => $row['impuestoretiva'],
                                    'impuestoretisr' => $row['impuestoretisr'],

                        ];
                }

//var_Dump($ordenado);

                $totalgastos = 0;
                $totalcompras = 0;

                $sumaieps = 0;
                
                $sumadescuento = 0;

                $cDescuento = 0;
                $gDescuento = 0;

                 $result = array();
                    foreach($ordenado as $t) {

                        $repeat=false;
                        // for($i=0;$i<count($result);$i++)
                        // {
                        //     if($result[$i]['clave']==$t['clave'])
                        //     {

                        //         $result[$i]['importe']+=$t['importe'];        
                        //         $repeat=true;
                        //         break;
                        //     }
                        // }
                                                      //  var_dump($result[$i]['importe']);
                       // if($repeat==false)

                            $result[] = array('clave' => $t['clave'], 
                                              'importe' => $emisordatos[0]['traslada_ieps'] == 1 ? number_format(doubleval($t['importe']),2,'.',''): number_format(doubleval($t['importe']),2,'.','')+ doubleval($t['importeieps']),
                                              'descuento' => doubleval($t['descuento']),
                                              'descripcion' => $t['descripcion'],
                                                'importeiva' => doubleval($t['importeiva']),
                                                'tasaiva' => doubleval($t['tasaiva']),
                                                'tasaieps' => doubleval($t['tasaieps']),
                                                'importeieps' => doubleval($t['importeieps']),
                                                'importeretiva' => doubleval($t['importeretiva']),
                                                'tasaretiva' => doubleval($t['tasaretiva']),
                                                'tasaretisr' => doubleval($t['tasaretisr']),
                                                'importeretisr' => doubleval($t['importeretisr']),
                                                'impuestoiva' => $t['impuestoiva'],
                                                'impuestoieps' => $t['impuestoieps'],
                                                'impuestoretiva' => $t['impuestoretiva'],
                                                'impuestoretisr' => $t['impuestoretisr'],
                                                'nombre_cta' => $t['nombre_cta'],
                                                'cuenta' => $t['cuenta'],
                                                'sub_cta' => $t['sub_cta'],
                                                'ssub_cta' => $t['ssub_cta'],
                                              'c_a' => '+'

                                            );
                                           
                    }

                    foreach($ordenado as $t)
                    {


                         if($t['impuestoiva'] == '002')
                                            {
                                                if($t['tasaiva'] == '0.080000')
                                                {
                                                    $sumaimpueiva8 = $sumaimpueiva8 + (double) $t['importeiva'];
                                                }
                                                else if($t['tasaiva'] == '0.160000')
                                                {
                                                    $sumaimpueiva16 = $sumaimpueiva16 + (double) $t['importeiva'];
                                                }
                                            }

                                            if($t['impuestoieps'] == '003')
                                            {
                                                $sumaimpueeips = $sumaimpueeips + (double) $t['importeieps'];
                                            }


                                            if($t['impuestoretiva'] == '002')
                                            {
                                                if($t['tasaretiva'] == '0.053334' || $t['tasaretiva'] == '0.053333')
                                                {
                                                    $sumareteniva = $sumareteniva + (double) $t['importeretiva'];
                                                }
                                                else if($t['tasaretiva'] == '0.106667' || $t['tasaretiva'] == '0.106666')
                                                {
                                                    $sumareteniva = $sumareteniva + (double) $t['importeretiva'];
                                                }
                                                else if($t['tasaretiva'] == '0.040000')
                                                {
                                                    $sumaretenisr4porflete = $sumaretenisr4porflete + (double) $t['importeretiva'];
                                                }
                                            }

                                            if($t['impuestoretisr'] == '001')
                                            {
                                                $sumaretenisr = $sumaretenisr + (double) $t['importeretisr'];
                                            }

                                          //-------------------------------------------------------------------------------------------------------------

                                            
                                            if($t['cuenta'] == $gastos[0]['cuenta'])
                                            {
                                               $totalgastos= $totalgastos+ $t['importe'];
                                               $gDescuento = $gDescuento + $t['descuento'];
                                            
                                                if($t['tasaiva'] ==  '0.080000')
                                                {
                                                    $sumaimpueiva8g = $sumaimpueiva8g + $t['importeiva'];
                                                 //   var_dump($sumaimpueiva8g);
                                                }
                                                else if($t['tasaiva'] == '0.160000')
                                                {
                                                    $sumaimpueiva16g = $sumaimpueiva16g + $t['importeiva'];
                                                }

                                                 if($t['impuestoieps'] == '003')
                                                 {
                                                   $sumaimpueeipsg = $sumaimpueeipsg + $t['importeieps'];
                                                 }

                                                if($t['tasaretiva'] == '0.053334' || $t['tasaretiva'] == '0.053333')
                                                {
                                                    $sumaretenivag = $sumaretenivag + $t['importeretiva'];
                                                }
                                                else if($t['tasaretiva'] == '0.106667' || $t['tasaretiva'] == '0.106666')
                                                {
                                                    $sumaretenivag = $sumaretenivag + $t['importeretiva'];
                                                }
                                                else if($t['tasaretiva'] == '0.040000')
                                                {
                                                    $sumaretenisr4porfleteg = $sumaretenisr4porfleteg +  $t['importeretiva'];
                                                }

                                                $sumaretenisrg = $sumaretenisrg + $t['importeretisr'];
                                            }
   
                                            if($t['cuenta'] == $compras[0]['cuenta'])
                                            {
                                               $totalcompras= $totalcompras + $t['importe'];
                                               $cDescuento = $cDescuento + $t['descuento'];
                                               if($t['tasaiva'] ==  '0.080000')
                                                {
                                                    $sumaimpueiva8c = $sumaimpueiva8c + $t['importeiva'];
                                                }
                                                else if($t['tasaiva'] == '0.160000')
                                                {
                                                    $sumaimpueiva16c = $sumaimpueiva16c + $t['importeiva'];
                                                }

                                                if($t['impuestoieps'] == '003')
                                                 {
                                                    $sumaimpueeipsc = $sumaimpueeipsc + $t['importeieps'];
                                                 }

                                                if($t['tasaretiva'] == '0.053334' || $t['tasaretiva'] == '0.053333')
                                                {
                                                    $sumaretenivac = $sumaretenivac + $t['importeretiva'];
                                                }
                                                else if($t['tasaretiva'] == '0.106667' || $t['tasaretiva'] == '0.106666')
                                                {
                                                    $sumaretenivac = $sumaretenivac + $t['importeretiva'];
                                                }
                                                else if($t['tasaretiva'] == '0.040000')
                                                {
                                                    $sumaretenisr4porfletec = $sumaretenisr4porfletec +  $t['importeretiva'];
                                                }

                                                $sumaretenisrc = $sumaretenisrc + $t['importeretisr'];
   
                                            }

                    }



                    $sumatotalimpuestosg = ($sumaimpueiva8g + ($sumaimpueiva16g + $sumaimpueeipsg));
                    $sumatotalretencionesg = $sumaretenivag + $sumaretenisrg + $sumaretenisr4porfleteg;
                    $totalrealproacreg = $sumatotalimpuestosg - $sumatotalretencionesg;


                    $sumatotalimpuestosc = ($sumaimpueiva8c + ($sumaimpueiva16c + $sumaimpueeipsc));
                    $sumatotalretencionesc = $sumaretenivac + $sumaretenisrc + $sumaretenisr4porfletec;
                    $totalrealproacrec = $sumatotalimpuestosc - $sumatotalretencionesc;

                    //SI LA FACTURA TIENE IVA al 8%

                    if($porpaga == 1 && $poli == '')
                    {
                        if($sumaimpueiva8 != 0)
                        {
                            $iva8 = $CI->conficue->getidcuentaconfi(37);
                            $ivaesti = array('importe' => number_format($sumaimpueiva8,2,'.',''), 'c_a' => '-','cuenta' => $iva8[0]['cuenta'],'sub_cta' => $iva8[0]['sub_cta'],'nombre_cta' => $iva8[0]['descrip'],'ssub_cta' => $iva8[0]['ssub_cta']);
                            array_push($result, $ivaesti);
                        }
                    }
                    else
                    {
                        if($sumaimpueiva8 != 0)
                        {
                            $iva8 = $CI->conficue->getidcuentaconfi(38);
                            $ivaesti = array('importe' => number_format($sumaimpueiva8,2,'.',''), 'c_a' => '+','cuenta' => $iva8[0]['cuenta'],'sub_cta' => $iva8[0]['sub_cta'],'nombre_cta' => $iva8[0]['descrip'],'ssub_cta' => $iva8[0]['ssub_cta']);
                            array_push($result, $ivaesti);
                        }
                    }

                    //SI LA FACTURA TIENE IVA al 16%
                    if($porpaga == 1 && $poli == '')
                    {
                        if($sumaimpueiva16 != 0)
                        {
                            $iva16 = $CI->conficue->getidcuentaconfi(6);
                            $ivaesti = array('importe' => $sumaimpueiva16, 'c_a' => '-','cuenta' => $iva16[0]['cuenta'],'sub_cta' => $iva16[0]['sub_cta'],'nombre_cta' => $iva16[0]['descrip'],'ssub_cta' => $iva16[0]['ssub_cta']);
                            array_push($result, $ivaesti);
                        }
                    }
                    else
                    {
                        if($sumaimpueiva16 != 0)
                        {
                            $iva16 = $CI->conficue->getidcuentaconfi(28);
                            $ivaesti = array('importe' => $sumaimpueiva16, 'c_a' => '+','cuenta' => $iva16[0]['cuenta'],'sub_cta' => $iva16[0]['sub_cta'],'nombre_cta' => $iva16[0]['descrip'],'ssub_cta' => $iva16[0]['ssub_cta']);
                            array_push($result, $ivaesti);
                        }
                    }

                    //SI LA FACTURA TIENE IEPS
                    // var_dump($emisordatos[0]['traslada_ieps']);
                   // var_dump($emisordatos[0]['traslada_ieps']);
                    if($emisordatos[0]['traslada_ieps'] == 1)
                    {
                        //SI LA FACTURA TIENE EIPS
                        if($porpaga == 1 && $poli == '')
                        {
                            if($sumaimpueeips != 0)
                            {
                                $ieps = $CI->conficue->getidcuentaconfi(40);
                                $eip = array('importe' => $sumaimpueeips, 'c_a' => '-','cuenta' => $ieps[0]['cuenta'],'sub_cta' => $ieps[0]['sub_cta'],'nombre_cta' => $ieps[0]['descrip'],'ssub_cta' => $ieps[0]['ssub_cta']);
                                array_push($result, $eip);
                            }
                        }
                        else
                        {
                            if($sumaimpueeips != 0)
                            {
                                $ieps = $CI->conficue->getidcuentaconfi(42);
                                $eip = array('importe' => $sumaimpueeips, 'c_a' => '+','cuenta' => $ieps[0]['cuenta'],'sub_cta' => $ieps[0]['sub_cta'],'nombre_cta' => $ieps[0]['descrip'],'ssub_cta' => $ieps[0]['ssub_cta']);
                                array_push($result, $eip);
                            }
                        }
                    }
                    // else
                    // {
                    //     $totalgastos = $totalgastos + $sumaimpueeips;
                    // }


                    //SI LA FACTURA TIENE RETENCION DEL ISR
                    if($porpaga == 1 && $poli == '')
                    {
                        if($sumaretenisr != 0)
                        {
                            $isrrete = $CI->conficue->getidcuentaconfi(31);
                            $reteisr = array('importe' => $sumaretenisr, 'c_a' => '+','cuenta' => $isrrete[0]['cuenta'],'sub_cta' => $isrrete[0]['sub_cta'],'nombre_cta' => $isrrete[0]['descrip'],'ssub_cta' => $isrrete[0]['ssub_cta']);
                            array_push($result, $reteisr);
                        }
                    }
                    else
                    {
                        if($sumaretenisr != 0)
                        {
                            $isrrete = $CI->conficue->getidcuentaconfi(34);
                            $reteisr = array('importe' => $sumaretenisr, 'c_a' => '-','cuenta' => $isrrete[0]['cuenta'],'sub_cta' => $isrrete[0]['sub_cta'],'nombre_cta' => $isrrete[0]['descrip'],'ssub_cta' => $isrrete[0]['ssub_cta']);
                            array_push($result, $reteisr);
                        }
                    }

                    //SI LA FACTURA TIENE RETENCION DEL IVA FLETE
                    if($porpaga == 1 && $poli == '')
                    {
                        if($sumaretenisr4porflete != 0)
                        {
                            $flete = $CI->conficue->getidcuentaconfi(41);
                            $ivafle = array('importe' => $sumaretenisr4porflete, 'c_a' => '+','cuenta' => $flete[0]['cuenta'],'sub_cta' => $flete[0]['sub_cta'],'nombre_cta' => $flete[0]['descrip'],'ssub_cta' => $flete[0]['ssub_cta']);
                            array_push($result, $ivafle);
                        }
                    }
                    else
                    {
                        if($sumaretenisr4porflete != 0)
                        {
                            $flete = $CI->conficue->getidcuentaconfi(46);
                            $ivafle = array('importe' => $sumaretenisr4porflete, 'c_a' => '-','cuenta' => $flete[0]['cuenta'],'sub_cta' => $flete[0]['sub_cta'],'nombre_cta' => $flete[0]['descrip'],'ssub_cta' => $flete[0]['ssub_cta']);
                            array_push($result, $ivafle);
                        }
                    }


                    //SI LA FACTURA TIENE RETENCION DEL IVA
                    if($porpaga == 1 && $poli == '')
                    {
                        if($sumareteniva != 0)
                        {
                            $ivarete = $CI->conficue->getidcuentaconfi(30);
                            $reteiva = array('importe' => $sumareteniva, 'c_a' => '+','cuenta' => $ivarete[0]['cuenta'],'sub_cta' => $ivarete[0]['sub_cta'],'nombre_cta' => $ivarete[0]['descrip'],'ssub_cta' => $ivarete[0]['ssub_cta']);
                            array_push($result, $reteiva);
                        }
                    }
                    else
                    {
                        if($sumareteniva != 0)
                        {
                            $ivarete = $CI->conficue->getidcuentaconfi(33);
                            $reteiva = array('importe' => $sumareteniva, 'c_a' => '-','cuenta' => $ivarete[0]['cuenta'],'sub_cta' => $ivarete[0]['sub_cta'],'nombre_cta' => $ivarete[0]['descrip'],'ssub_cta' => $ivarete[0]['ssub_cta']);
                            array_push($result, $reteiva);
                        }
                    }

                if($porpaga == 1 && $poli == '')
                {

                }
                else
                {

                    if($conf[0]['rfc'] == $rfcReceptor)
                    {

                      //  var_dump($sumaimpueeips);
                        $activo = $CI->configene->getcxpprovpropios();
                        $propios = $CI->conficue->getidcuentaconfi(29);
                        $acreedor = $CI->conficue->getidcuentaconfi(58);
                    
                         //SI EL RFC DE LA EMPRESA ES LA MISMA AL RFC DEL RECEPTOR DE LA FACTURA ENTONCES EN PROVEEDOR PROPIO
                         //var_dump($totalfactu);

                        if($totalgastos > 0)
                        {                            
                            $totalron = round($totalgastos,2);
                            $totaldescu = round($gDescuento,2);
                            $totalrealg = round($totalrealproacreg,2);

                            $total = array('importe' => ($totalron-$totaldescu)+$totalrealg, 'c_a' => '-',
                            'cuenta' => $acreedor[0]['cuenta'],
                            'sub_cta' => $acreedor[0]['sub_cta'],
                            'nombre_cta' => $acreedor[0]['descrip'],
                            'ssub_cta' => $acreedor[0]['ssub_cta']
                            
                          );

                          array_push($result, $total);
                        }
                        if($totalcompras > 0)
                        {
                            $totalron = round($totalcompras,2);
                            $totaldescu = round($cDescuento,2);
                            $totalrealc = round($totalrealproacrec,2);

                            $total = array('importe' => ($totalron-$totaldescu)+$totalrealc, 'c_a' => '-',
                            'cuenta' => $propios[0]['cuenta'],
                            'sub_cta' => $propios[0]['sub_cta'],
                            'nombre_cta' => $propios[0]['descrip'],
                            'ssub_cta' => $propios[0]['ssub_cta']
                            
                          );

                          array_push($result, $total);
                        }

                    }
                    else
                    {

                        
                        $activo = $CI->configene->getcxpprovterceros();
                        $terceros = $CI->conficue->getidcuentaconfi(35);
                        if($activo[0]['valor'] == 1 && $activo[0]['inactiva'] == 0)
                        {
                            $sub_cuenta = $terceros[0]['sub_cta'];
                            $ssub_cuenta = $terceros[0]['ssub_cta'];
                        }
                        else
                        {
                              $sub_cuenta = $terceros[0]['sub_cta'];
                              $ssub_cuenta = $terceros[0]['ssub_cta'];
                        }

                        //SI ES DIFERENTE AL DE LA FACTURA ENTONCES ES PROVEEDOR TERCEROS
                        $total = array('importe' => $totalfactu, 'c_a' => '-',
                                     'cuenta' => $terceros[0]['cuenta'],
                                     'sub_cta' => $sub_cuenta,
                                     'nombre_cta' => $terceros[0]['descrip'],
                                     'ssub_cta' => $ssub_cuenta
                                    );
                        //var_dump($total);
                    }


                }
                    //SI LA FACTURA TIENE DESCUENTO
                    if($descuent != 0)
                    {
                        $DAtos = $CI->conficue->getidcuentaconfi(39);
                        $des = array('importe' => $descuent,'c_a' => '-' , 'cuenta' => $DAtos[0]['cuenta'],'sub_cta' => $DAtos[0]['sub_cta'],'nombre_cta' => $DAtos[0]['descrip'],'ssub_cta' => $DAtos[0]['ssub_cta']);

                        array_push($result, $des);
                    }

                    $result2 = array();
                    foreach($result as $t) {
                        $repeat=false;
                        for($i=0;$i<count($result2);$i++)
                        {
                            if($result2[$i]['cuenta']==$t['cuenta'] && $result2[$i]['sub_cta']==$t['sub_cta'] && $result2[$i]['ssub_cta']==$t['ssub_cta'])
                            {
                                $result2[$i]['importe']+=$t['importe'];
                                $repeat=true;
                                break;
                            }
                        }
                        if($repeat==false)
                            $result2[] = array('importe' => $t['importe'],
                                            'cuenta' => $t['cuenta'],
                                            'sub_cta' => $t['sub_cta'],
                                            'nombre_cta' => $t['nombre_cta'],
                                            'ssub_cta' => $t['ssub_cta'], 
                                              'c_a' => $t['c_a'],
                                            );
                    }

                     return $result2;
    }
}

if(!function_exists('getAttribute'))
{
   function getAttribute($query)
    {
        $xpath = $this->getXpathObj();
        $nodeset = $xpath->query($query, $this->xmlDom);
            if($regresa = $nodeset[0])
            {
               return $regresa->value;
            }
         return "";
    }
}
if(!function_exists('getXpathObj'))
{
    function getXpathObj()
    {
        if(empty($this->xpath) && !empty($this->xmlDom))
        {
            $this->xpath = new DOMXPath($this->xmlDom);
            $this->xpath->registerNamespace('cfdi', 'http://www.sat.gob.mx/cfd/4');
            $this->xpath->registerNamespace('tfd', 'http://www.sat.gob.mx/TimbreFiscalDigital');
        }
        return $this->xpath;
    }
}