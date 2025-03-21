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
    function get_factura_poliza($uuid,$nom_prov,$deta = 0,$porpaga = 0,$poli = '')
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
        $conceptos = [];
        $completo = [];

          //$totalfactu = $CI->getAttribute('cfdi:Comprobante/@Total');
          $totalfactu = (string) $xml2->attributes()->Total;
          $rfcReceptors = $CI->xmlDom->getElementsBytagName('Receptor');
          $rfcEmisor = $CI->xmlDom->getElementsBytagName('Emisor');
          foreach($rfcReceptors as $rfc)
          {
                $rfcReceptor = $rfc->getAttribute('Rfc');
          }
          foreach($rfcEmisor as $rfc)
          {
                $rfcEmisor = $rfc->getAttribute('Rfc');
          }

          $emisordatos = $CI->beneficiario->datosbenerfc($rfcEmisor);
  
                 $conceplist = $CI->xmlDom->getElementsBytagName('Concepto');
                foreach($conceplist as $concepto)
                {
                    if($concepto->getAttribute('Descuento'))
                    {
                       $sumadescu = $sumadescu + $concepto->getAttribute('Descuento');
                    }
                        $conceptos[] = [
                                        'clave' => $concepto->getAttribute('ClaveProdServ'),
                                        'descripcion' => $concepto->getAttribute('Descripcion'),
                                        'importe' => $concepto->getAttribute('Importe')
                                        ];
                }
      
                  $retenList = $CI->xmlDom->getElementsByTagName('Retencion');
                  foreach($xml2->children('cfdi',TRUE)->Conceptos->Concepto as $concepto)
                  {
                    if(isset($concepto->Impuestos->Retenciones->Retencion))
                    {
                        for($j=0;$j <= count($concepto->Impuestos->Retenciones); $j++)
                        {
                            if(isset($concepto->Impuestos->Retenciones->Retencion[$j]))
                            {
                                if($concepto->Impuestos->Retenciones->Retencion[$j]->attributes()->Impuesto == 002)
                                {
                                     if($concepto->Impuestos->Retenciones->Retencion[$j]->attributes()->TasaOCuota == '0.053334' || $concepto->Impuestos->Retenciones->Retencion[$j]->attributes()->TasaOCuota == '0.053333')
                                     {
                                        $sumareteniva = $sumareteniva + (double) $concepto->Impuestos->Retenciones->Retencion[$j]->attributes()->Importe;
                                     }
                                     else if($concepto->Impuestos->Retenciones->Retencion[$j]->attributes()->TasaOCuota == '0.106667' || $concepto->Impuestos->Retenciones->Retencion[$j]->attributes()->TasaOCuota == '0.106666')
                                     {
                                        $sumareteniva = $sumareteniva + (double) $concepto->Impuestos->Retenciones->Retencion[$j]->attributes()->Importe;
                                     }
                                     else if($concepto->Impuestos->Retenciones->Retencion[$j]->attributes()->TasaOCuota == '0.040000')
                                     {
                                        $sumaretenisr4porflete = $sumaretenisr4porflete + (double) $concepto->Impuestos->Retenciones->Retencion[$j]->attributes()->Importe;
                                     }
                                }
                                if($concepto->Impuestos->Retenciones->Retencion[$j]->attributes()->Impuesto == 001)
                                {
                                    $sumaretenisr = $sumaretenisr + (double) $concepto->Impuestos->Retenciones->Retencion[$j]->attributes()->Importe;
                                }
                            }
                        }
                    }
                  }

                 $trasladoList = $CI->xmlDom->getElementsByTagName('Concepto');

                foreach($xml2->children('cfdi',TRUE)->Conceptos->Concepto as $concepto)
                  {
                                if(isset($concepto->Impuestos->Traslados->Traslado))
                                {
                                    for($j=0;$j <= count($concepto->Impuestos->Traslados); $j++)
                                    {
                                        if(isset($concepto->Impuestos->Traslados->Traslado[$j]))
                                        {
                                            if($concepto->Impuestos->Traslados->Traslado[$j]->attributes()->Impuesto == 002)
                                            {
                                                if($concepto->Impuestos->Traslados->Traslado[$j]->attributes()->TasaOCuota == '0.160000')
                                                {
                                                   $sumaimpueiva16 = $sumaimpueiva16 + (double) $concepto->Impuestos->Traslados->Traslado[$j]->attributes()->Importe;  
                                                }
                                                else if($concepto->Impuestos->Traslados->Traslado[$j]->attributes()->TasaOCuota == '0.080000')
                                                {
                                                    $sumaimpueiva8 = $sumaimpueiva8 + (double) $concepto->Impuestos->Traslados->Traslado[$j]->attributes()->Importe;                                           
                                                }                                                                    
                                            }                                           
                                            if($concepto->Impuestos->Traslados->Traslado[$j]->attributes()->Impuesto == 003)
                                            {
                                                $sumaimpueeips = $sumaimpueeips + (double) $concepto->Impuestos->Traslados->Traslado[$j]->attributes()->Importe;
                                            }
                                        }
                                       
                                    }
                                 }
                  }


                  $sumatotalimpuestos = $sumaimpueiva16 + $sumaimpueiva8 + $sumaimpueeips;
                  $sumatotalretenciones = $sumareteniva + $sumaretenisr + $sumaretenisr4porflete;
                  $totalrealproacre = $sumatotalimpuestos - $sumatotalretenciones;


                for($i = 0; $i< count($conceptos); $i++)
                {
                   // var_dump($conceptos);
                     $completo[] = [
                          'clave' => $conceptos[$i]['clave'],
                          'importe' => $conceptos[$i]['importe'],
                          'descripcion' => $conceptos[$i]['descripcion']
                     ];
                }

                foreach ($completo as $key => $row) 
                {
                    $aux[$key] = $row['clave'];

                }

                array_multisort($aux, SORT_ASC, $completo);

                foreach ($completo as $key => $row) 
                {
                    $ordenado[] = ['clave' => $row['clave'],
                               'importe' => $row['importe'],
                               'descripcion' => $row['descripcion']

                        ];
                }

                 $result = array();
                    foreach($ordenado as $t) {
                        $repeat=false;
                        for($i=0;$i<count($result);$i++)
                        {
                            if($result[$i]['clave']==$t['clave'])
                            {
                                $result[$i]['importe']+=$t['importe'];
                                $repeat=true;
                                break;
                            }
                        }
                        if($repeat==false)
                            $result[] = array('clave' => $t['clave'], 
                                              'importe' => doubleval($t['importe']),
                                              'c_a' => '+'
                                            );
                    }
                 $datosprevi = [];
                 $gastos = $CI->conficue->getidcuentaconfi(15);
                 $compras = $CI->conficue->getidcuentaconfi(16);
                 $totalgastos = 0;
                 $totalcompras = 0;
                    foreach($result as $resultante)
                    {
                       $row =  $CI->dicuentas->buscariguales($resultante['clave']);

                
                       if($deta == 0)
                       {

                        $datosprevi[] = ['clave' => $resultante['clave'],
                                          'importe' => $emisordatos[0]['traslada_ieps'] == 1 ?  $resultante['importe']-$sumadescu :($resultante['importe']-$sumadescu)+$sumaimpueeips,
                                          'c_a' => $result[$i]['c_a'],
                                          'cuenta' => $row[0]['cuenta'],
                                          'sub_cta' => $row[0]['sub_cta'],
                                          'nombre_cta' => '',
                                          'ssub_cta' => $row[0]['ssub_cta'],
                                         ];

                                         if($row[0]['cuenta'] == $gastos[0]['cuenta'])
                                         {
                                            $totalgastos= $totalgastos+ $resultante['importe'];
                                         }
                                         if($row[0]['cuenta'] == $compras[0]['cuenta'])
                                         {

                                            $totalcompras= $totalcompras + $resultante['importe'];

                                         }

                       }
                       else
                       {

                         $datosprevi[] = ['clave' => $resultante['clave'],
                            'importe' => $emisordatos[0]['traslada_ieps'] == 1 ? $resultante['importe']-$sumadescu : ($resultante['importe']-$sumadescu)+$sumaimpueeips,
                            'c_a' => $result[$i]['c_a'],
                            'cuenta' => $row[0]['cuenta'],
                            'sub_cta' => $row[0]['sub_cta'],
                            'nombre_cta' => '',
                            'ssub_cta' => $row[0]['ssub_cta'],
                        ];

                        if($row[0]['cuenta'] == $gastos[0]['cuenta'])
                        {
                           $totalgastos= $totalgastos + $resultante['importe'];
                        }
                        if($row[0]['cuenta'] == $compras[0]['cuenta'])
                        {

                           $totalcompras= $totalcompras + $resultante['importe'];
                        }

                       }
                    }

                    $datosresul = [];
                    foreach($datosprevi as $cu)
                    {
                        $nom_cuen = $CI->cuentas->get_cuenta($cu['cuenta'],$cu['sub_cta'],$cu['ssub_cta']);

                        $datosresul[] = ['clave' => $cu['clave'],
                                        'importe' => $cu['importe'],
                                        'c_a' => $cu['c_a'],
                                        'cuenta' => $cu['cuenta'],
                                        'sub_cta' => $cu['sub_cta'],
                                        'nombre_cta' =>  $nom_cuen[0]['nombre'],
                                        'ssub_cta' => $cu['ssub_cta'],
                                      ];
                    }

                    //SI LA FACTURA TIENE IVA al 8%

                    if($porpaga == 1 && $poli == '')
                    {
                        if($sumaimpueiva8 != 0)
                        {
                            $iva8 = $CI->conficue->getidcuentaconfi(37);
                            $ivaesti = array('importe' => number_format($sumaimpueiva8,2,'.',''), 'c_a' => '-','cuenta' => $iva8[0]['cuenta'],'sub_cta' => $iva8[0]['sub_cta'],'nombre_cta' => $iva8[0]['descrip'],'ssub_cta' => $iva8[0]['ssub_cta']);
                            array_push($datosresul, $ivaesti);
                        }
                    }
                    else
                    {
                        if($sumaimpueiva8 != 0)
                        {
                            $iva8 = $CI->conficue->getidcuentaconfi(38);
                            $ivaesti = array('importe' => number_format($sumaimpueiva8,2,'.',''), 'c_a' => '+','cuenta' => $iva8[0]['cuenta'],'sub_cta' => $iva8[0]['sub_cta'],'nombre_cta' => $iva8[0]['descrip'],'ssub_cta' => $iva8[0]['ssub_cta']);
                            array_push($datosresul, $ivaesti);
                        }
                    }

                    //SI LA FACTURA TIENE IVA al 16%
                    if($porpaga == 1 && $poli == '')
                    {
                        if($sumaimpueiva16 != 0)
                        {
                            $iva16 = $CI->conficue->getidcuentaconfi(6);
                            $ivaesti = array('importe' => $sumaimpueiva16, 'c_a' => '-','cuenta' => $iva16[0]['cuenta'],'sub_cta' => $iva16[0]['sub_cta'],'nombre_cta' => $iva16[0]['descrip'],'ssub_cta' => $iva16[0]['ssub_cta']);
                            array_push($datosresul, $ivaesti);
                        }
                    }
                    else
                    {
                        if($sumaimpueiva16 != 0)
                        {
                            $iva16 = $CI->conficue->getidcuentaconfi(28);
                            $ivaesti = array('importe' => $sumaimpueiva16, 'c_a' => '+','cuenta' => $iva16[0]['cuenta'],'sub_cta' => $iva16[0]['sub_cta'],'nombre_cta' => $iva16[0]['descrip'],'ssub_cta' => $iva16[0]['ssub_cta']);
                            array_push($datosresul, $ivaesti);
                        }
                    }


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
                                array_push($datosresul, $eip);
                            }
                        }
                        else
                        {
                            if($sumaimpueeips != 0)
                            {
                                $ieps = $CI->conficue->getidcuentaconfi(42);
                                $eip = array('importe' => $sumaimpueeips, 'c_a' => '+','cuenta' => $ieps[0]['cuenta'],'sub_cta' => $ieps[0]['sub_cta'],'nombre_cta' => $ieps[0]['descrip'],'ssub_cta' => $ieps[0]['ssub_cta']);
                                array_push($datosresul, $eip);
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
                            array_push($datosresul, $reteisr);
                        }
                    }
                    else
                    {
                        if($sumaretenisr != 0)
                        {
                            $isrrete = $CI->conficue->getidcuentaconfi(34);
                            $reteisr = array('importe' => $sumaretenisr, 'c_a' => '-','cuenta' => $isrrete[0]['cuenta'],'sub_cta' => $isrrete[0]['sub_cta'],'nombre_cta' => $isrrete[0]['descrip'],'ssub_cta' => $isrrete[0]['ssub_cta']);
                            array_push($datosresul, $reteisr);
                        }
                    }

                    //SI LA FACTURA TIENE RETENCION DEL IVA FLETE
                    if($porpaga == 1 && $poli == '')
                    {
                        if($sumaretenisr4porflete != 0)
                        {
                            $flete = $CI->conficue->getidcuentaconfi(41);
                            $ivafle = array('importe' => $sumaretenisr4porflete, 'c_a' => '+','cuenta' => $flete[0]['cuenta'],'sub_cta' => $flete[0]['sub_cta'],'nombre_cta' => $flete[0]['descrip'],'ssub_cta' => $flete[0]['ssub_cta']);
                            array_push($datosresul, $ivafle);
                        }
                    }
                    else
                    {
                        if($sumaretenisr4porflete != 0)
                        {
                            $flete = $CI->conficue->getidcuentaconfi(46);
                            $ivafle = array('importe' => $sumaretenisr4porflete, 'c_a' => '-','cuenta' => $flete[0]['cuenta'],'sub_cta' => $flete[0]['sub_cta'],'nombre_cta' => $flete[0]['descrip'],'ssub_cta' => $flete[0]['ssub_cta']);
                            array_push($datosresul, $ivafle);
                        }
                    }


                    //SI LA FACTURA TIENE RETENCION DEL IVA
                    if($porpaga == 1 && $poli == '')
                    {
                        if($sumareteniva != 0)
                        {
                            $ivarete = $CI->conficue->getidcuentaconfi(30);
                            $reteiva = array('importe' => $sumareteniva, 'c_a' => '+','cuenta' => $ivarete[0]['cuenta'],'sub_cta' => $ivarete[0]['sub_cta'],'nombre_cta' => $ivarete[0]['descrip'],'ssub_cta' => $ivarete[0]['ssub_cta']);
                            array_push($datosresul, $reteiva);
                        }
                    }
                    else
                    {
                        if($sumareteniva != 0)
                        {
                            $ivarete = $CI->conficue->getidcuentaconfi(33);
                            $reteiva = array('importe' => $sumareteniva, 'c_a' => '-','cuenta' => $ivarete[0]['cuenta'],'sub_cta' => $ivarete[0]['sub_cta'],'nombre_cta' => $ivarete[0]['descrip'],'ssub_cta' => $ivarete[0]['ssub_cta']);
                            array_push($datosresul, $reteiva);
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
                     //   var_dump($totalcompras);
                     //   var_dump($totalgastos);
                        // if($activo[0]['valor'] == 1 && $activo[0]['inactiva'] == 0)
                        // {
                        //     $sub_cuenta = $propios[0]['sub_cta'];
                        //     $ssub_cuenta = $propios[0]['ssub_cta'];
                        // }
                        // else
                        // {
                        //       $sub_cuenta = $propios[0]['sub_cta'];
                        //       $ssub_cuenta = $propios[0]['ssub_cta'];
                        // }
                         //SI EL RFC DE LA EMPRESA ES LA MISMA AL RFC DEL RECEPTOR DE LA FACTURA ENTONCES EN PROVEEDOR PROPIO
                         //var_dump($totalfactu);
                        if($totalgastos > 0)
                        {

                            $total = array('importe' => ($totalgastos-$sumadescu)+$totalrealproacre, 'c_a' => '-',
                            'cuenta' => $acreedor[0]['cuenta'],
                            'sub_cta' => $acreedor[0]['sub_cta'],
                            'nombre_cta' => $acreedor[0]['descrip'],
                            'ssub_cta' => $acreedor[0]['ssub_cta']
                            
                          );
                        }
                        if($totalcompras > 0)
                        {

                            $total = array('importe' => ($totalcompras-$sumadescu)+$totalrealproacre, 'c_a' => '-',
                            'cuenta' => $propios[0]['cuenta'],
                            'sub_cta' => $propios[0]['sub_cta'],
                            'nombre_cta' => $propios[0]['descrip'],
                            'ssub_cta' => $propios[0]['ssub_cta']
                            
                          );
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

                    array_push($datosresul, $total);
                }
                    //SI LA FACTURA TIENE DESCUENTO , YA NO LLEVA DESCEUNTO A NIVEL GLOBAL SOLO A CONCEPTO
                    // if($sumadescu != 0)
                    // {
                    //     $DAtos = $CI->conficue->getidcuentaconfi(39);
                    //     $des = array('importe' => $sumadescu,'c_a' => '-' , 'cuenta' => $DAtos[0]['cuenta'],'sub_cta' => $DAtos[0]['sub_cta'],'nombre_cta' => $DAtos[0]['descrip'],'ssub_cta' => $DAtos[0]['ssub_cta']);

                    //     array_push($datosresul, $des);
                    // }

                     return $datosresul;
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