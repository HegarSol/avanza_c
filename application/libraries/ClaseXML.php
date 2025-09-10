<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

class ClaseXML
{

    public $CI;

     function __construct()
     {
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->model('CuentasModel','cuentas');
     }

     function CrearXMLbalanza($mes,$ano,$feche,$rfc,$datos,$tipoenvio)
     {
          $root = '';
          $xml = new DOMdocument('1.0','UTF-8');
          $root = $xml->createElement('BCE:Balanza');
          $xml->formatOutput = TRUE;
          $root = $xml->appendChild($root);
          $this->satxmlsv32_cargaAtt($root, array(
              'xsi:schemaLocation'=>'http://www.sat.gob.mx/esquemas/ContabilidadE/1_3/BalanzaComprobacion http://www.sat.gob.mx/esquemas/ContabilidadE/1_3/BalanzaComprobacion/BalanzaComprobacion_1_3.xsd',
              'xmlns:xsi'=>'http://www.w3.org/2001/XMLSchema-instance',
              'xmlns:BCE'=>'http://www.sat.gob.mx/esquemas/ContabilidadE/1_3/BalanzaComprobacion',
          ));

          $this->satxmlsv32_cargaAtt($root,array(
              'Version'=>1.3,
              'RFC'=>$rfc,
              'Mes'=>$mes,
              'Anio'=>$ano,
              'TipoEnvio'=>$tipoenvio,
            )
          );

          if($tipoenvio == 'C')
          {
            $this->satxmlsv32_cargaAtt($root,array(
                'FechaModBal'=>date('Y-m-d',strtotime($feche))
              )
            );  
          }

          for($i=0;$i<count($datos);$i++)
          {
                $ctn = $xml->createElement('BCE:Ctas');
                $cnt = $root->appendChild($ctn);
                $this->satxmlsv32_cargaAtt(
                    $cnt,
                    array(
                        'NumCta'=> str_pad($datos[$i]['cuenta'],4,"0",STR_PAD_LEFT).str_pad($datos[$i]['sub_cta'],4,"0",STR_PAD_LEFT).str_pad($datos[$i]['ssub_cta'],4,"0",STR_PAD_LEFT),
                        'SaldoIni'=>number_format($datos[$i]['sini'],2,'.',''),
                        'Debe'=>number_format($datos[$i]['cargos'],2,'.',''),
                        'Haber'=>number_format($datos[$i]['abonos'],2,'.',''),
                        'SaldoFin'=>number_format(($datos[$i]['sini']+$datos[$i]['cargos'])-$datos[$i]['abonos'],2,'.','')
                    )
                );
          }


          $xml->formatOutput = true;
          //$xml->save('XMLPruebas.xml');
          return $xml->saveXML();
     }
     function CrearXMLCuentas($mes, $anio, $rfc)
     {

         $cuentas = $this->CI->cuentas->getCuentas();
             

         $root = '';
         $xml = new DOMdocument('1.0','UTF-8');
         $root = $xml->createElement('catalogocuentas:Catalogo');
         $xml->formatOutput = TRUE;
         $root = $xml->appendChild($root);
         $this->satxmlsv32_cargaAtt($root, array(
            'xsi:schemaLocation'=>'http://www.sat.gob.mx/esquemas/ContabilidadE/1_3/CatalogoCuentas http://www.sat.gob.mx/esquemas/ContabilidadE/1_3/CatalogoCuentas/CatalogoCuentas_1_3.xsd',
             'xmlns:xsi'=>'http://www.w3.org/2001/XMLSchema-instance',
             'xmlns:catalogocuentas'=>'http://www.sat.gob.mx/esquemas/ContabilidadE/1_3/CatalogoCuentas',

         )
        );

        $this->satxmlsv32_cargaAtt(
            $root,
            array(
                'Version'=>1.3,
                'RFC' => $rfc,
                'Mes' => $mes,
                'Anio' => $anio
            ));

           for($i=0; $i<count($cuentas); $i++)
           {
               $ctacuentas = $xml->createElement('catalogocuentas:Ctas');
               $ctacuentas = $root->appendChild($ctacuentas);
               $this->satxmlsv32_cargaAtt(
                   $ctacuentas,
                   array(
                    'CodAgrup' => $cuentas[$i]['ctasat'],
                   )
               );

               $this->satxmlsv32_cargaAtt(
                   $ctacuentas,
                   array(
                    'NumCta' => str_pad($cuentas[$i]['cuenta'],4,"0",STR_PAD_LEFT).str_pad($cuentas[$i]['sub_cta'],4,"0",STR_PAD_LEFT).str_pad($cuentas[$i]['ssub_cta'],4,"0",STR_PAD_LEFT) ,
                   )
               );


               $this->satxmlsv32_cargaAtt(
                   $ctacuentas,
                   array(
                    'Desc' => $cuentas[$i]['nombre'],
                   )
                );

                if(strlen($cuentas[$i]['ctasat']) > 3)
                    {
                        $this->satxmlsv32_cargaAtt(
                            $ctacuentas,
                            array(
                            'SubCtaDe' => str_pad($cuentas[$i]['cuenta'],4,"0",STR_PAD_LEFT).'0000',
                            )
                        );   
                    }

                 
                    $this->satxmlsv32_cargaAtt(
                        $ctacuentas,
                        array(
                         'Nivel' => (strlen($cuentas[$i]['ctasat']) > 3)?2:1,
                        )
                     );
                 
                 $this->satxmlsv32_cargaAtt(
                    $ctacuentas,
                    array(
                      'Natur' => $cuentas[$i]['natur']
                    )
                 );
           }
            
            
            $xml->formatOutput = true;
            //$xml->save('XMLPruebas.xml');
            //$oData = array('error' =>  $xml->saveXML(), 'estatus' => true);
            return $xml->saveXML();

     }
     function satxmlsv32_cargaAtt(&$nodo, $attr)
     {
        global $xml, $sello;
        foreach ($attr as $key => $val)
        {
            $val = preg_replace('/\s\s+/', ' ', $val);   // Regla 5a y 5c
            $val = trim($val);                           // Regla 5b
            if (strlen($val)>0) {   // Regla 6
            //$val = utf8_encode(str_replace('|','/',$val)); // Regla 1
            $val = str_replace('|','/',$val);
            $nodo->setAttribute($key,$val);
        }
        }
     }
}