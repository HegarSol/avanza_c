<?php

class BalanzaComprobacion extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('menuModel');
        $items=$this->menuModel->menus($_SESSION['tipo']);
        $this->multi_menu->set_items($items);
        $this->load->view('templates/header');
        $this->load->model('Configuraciones_model','configModel');
        $this->load->model('BeneficiarioModel','beneficiario');
        $this->load->model('OperacionesModel','operaciones');
        $this->load->model('CuentasModel','cuentas');
        $this->load->model('BancosModel','bancos');
        $this->load->library('Pdf');
        $this->load->library('PHPExcel');
    }
    public function index()
    {
        if($this->aauth->is_loggedin())
        {
            $errores=array();
            $rfc = $this->configModel->getConfig();
            $permisos=$this->permisosForma($_SESSION['id'],1);
            $data=array('titulo'=>'Reporte balanza de comprobación','rfc' => $rfc[0]['rfc'],'razon' => $this->validaempresas->get_razon($_SESSION['idEmpresa']),'errores'=>$errores,'permisosGrupo'=>$permisos);
            $items=$this->menuModel->menus($_SESSION['tipo']);
            $this->multi_menu->set_items($items);
            $this->load->view('templates/header');
            $this->load->view('templates/navigation',$data);
            $this->load->view('reportes/reportebalanzacomprobacion');
            $this->load->view('templates/footer');
        }
        else
        {
            redirect('inicio/login','refresh');
        }
    }
    public function xml()
    {

        $this->fecha = $this->input->post('fechaenvio');
        $this->perio = $this->input->post('periodo');
        $this->tipoenvio = $this->input->post('tipoenvio');
        $this->mes = $this->input->post('mese');
        $this->bim = $this->input->post('bimes');
        $this->fechaini = $this->input->post('fecha_ini');
        $this->fechafin = $this->input->post('fecha_fin');
        $this->ano = $this->input->post('anol');
        $this->radio = $this->input->post('radiocuenta');

        if($this->mes == '13')
        {
          $this->mes3 = '13';
          $this->mes = '12';
        }

        $rfc = $this->configModel->getConfig();

        switch($this->bim)
        {
            case '01':
                 $this->mes1 = '01';
                 $this->mes2 = '02';
              break;
            case '02':
                 $this->mes1 = '03';
                 $this->mes2 = '04';
              break;
            case '03':
                 $this->mes1 = '05';
                 $this->mes2 = '06';
              break;
            case '04':
                 $this->mes1 = '07';
                 $this->mes2 = '08';
              break;
            case '05':
                 $this->mes1 = '09';
                 $this->mes2 = '10';
              break;
            case '06':
                 $this->mes1 = '11';
                 $this->mes2 = '12';
              break;
        }
  
  
          if($this->perio == 'mensual' || $this->perio == 'bimestral')
          {
              if($this->perio == 'mensual')
              {
                  $fecha = new DateTime($this->ano.'-'.$this->mes);
                  $fecha->modify('first day of this month');
                  $inicial = $fecha->format('Y-m-d');
  
                  $fecha = new DateTime($this->ano.'-'.$this->mes);
                  $fecha->modify('last day of this month');
                  $final = $fecha->format('Y-m-d');
              }
              else
              {
                  $fecha = new DateTime($this->ano.'-'.$this->mes1);
                  $fecha->modify('first day of this month');
                  $inicial = $fecha->format('Y-m-d');
  
                  $fecha = new DateTime($this->ano.'-'.$this->mes2);
                  $fecha->modify('last day of this month');
                  $final = $fecha->format('Y-m-d');
              }
          }
          else
          {
              if($this->perio == 'anual')
              {
                 $inicial = date('Y-m-d',strtotime($this->ano.'-01-01'));
                 $final = date('Y-m-d',strtotime($this->ano.'-12-31'));
              }
              else
              {
                 $inicial = $this->fechaini;
                 $final = $this->fechafin;
              }
          }

        $this->datos = $this->operaciones->balanza($inicial,$final,$this->radio);

        if(isset($this->mes3) == '13')
        {
            $this->mes = '13';
        }

        $this->load->library('ClaseXML');
        $this->balanzaxml = NULL;
        $this->balanzaxml = new ClaseXML();
        $mensaje = $this->balanzaxml->CrearXMLbalanza($this->mes,$this->ano,$this->fecha,$rfc[0]['rfc'],$this->datos,$this->tipoenvio);

        $zip = new ZipArchive();
        $zip->open('XMLBalanza.zip',ZipArchive::CREATE);
        file_put_contents('Balanza.xml',$mensaje);
        $zip->addFile('Balanza.xml','Balanza.xml');
        $zip->close();

        header("Content-type: application/octet-stream");
        header("Content-disposition: attachment; filename=XMLBalanza.zip");

        readfile('XMLBalanza.zip');
        unlink('Balanza.xml');
        unlink('XMLBalanza.zip');


    }
    public function balanza()
    {
        date_default_timezone_set("America/Mexico_City");
        setlocale(LC_TIME,"spanish");

        $mes = $this->input->post('mes');
        $bim = $this->input->post('bim');
        $fechafi = $this->input->post('fechafin');
        $fechaini = $this->input->post('fechaini');
        $perio = $this->input->post('perio');
        $ano = $this->input->post('ano');
        $cuentasubmayor = $this->input->post('radiocuenta');

        if($mes == '13')
        {
          $mes = '12';
        }


      switch($bim)
      {
          case '01':
               $mes1 = '01';
               $mes2 = '02';
            break;
          case '02':
               $mes1 = '03';
               $mes2 = '04';
            break;
          case '03':
               $mes1 = '05';
               $mes2 = '06';
            break;
          case '04':
               $mes1 = '07';
               $mes2 = '08';
            break;
          case '05':
               $mes1 = '09';
               $mes2 = '10';
            break;
          case '06':
               $mes1 = '11';
               $mes2 = '12';
            break;
      }


        if($perio == 'mensual' || $perio == 'bimestral')
        {
            if($perio == 'mensual')
            {
                $fecha = new DateTime($ano.'-'.$mes);
                $fecha->modify('first day of this month');
                $inicial = $fecha->format('Y-m-d');

                $fecha = new DateTime($ano.'-'.$mes);
                $fecha->modify('last day of this month');
                $final = $fecha->format('Y-m-d');
            }
            else
            {
                $fecha = new DateTime($ano.'-'.$mes1);
                $fecha->modify('first day of this month');
                $inicial = $fecha->format('Y-m-d');

                $fecha = new DateTime($ano.'-'.$mes2);
                $fecha->modify('last day of this month');
                $final = $fecha->format('Y-m-d');
            }
        }
        else
        {
            if($perio == 'anual')
            {
               $inicial = date('Y-m-d',strtotime($ano.'-01-01'));
               $final = date('Y-m-d',strtotime($ano.'-12-31'));
            }
            else
            {
               $inicial = $fechaini;
               $final = $fechafi;
            }
        }

        $datos = $this->operaciones->balanza($inicial,$final,$cuentasubmayor);

        $data['balanzas'] = $datos;

        $this->load->view('reportes/balanza/table_balanza',$data);
    }
    public function imprimir()
    {

        date_default_timezone_set("America/Mexico_City");
        setlocale(LC_TIME,"spanish");

        $this->perio = $this->input->post('periodo');
        $this->mes = $this->input->post('mese');
        $this->bim = $this->input->post('bimes');
        $this->fechaini = $this->input->post('fecha_ini');
        $this->fechafin = $this->input->post('fecha_fin');
        $this->ano = $this->input->post('anol');
        $this->radio = $this->input->post('radiocuenta');


        if($this->mes == '13')
        {
          $this->mes = '12';
        }

        $this->rowc = $this->configModel->getConfig();

        switch($this->bim)
        {
            case '01':
                 $this->mes1 = '01';
                 $this->mes2 = '02';
              break;
            case '02':
                 $this->mes1 = '03';
                 $this->mes2 = '04';
              break;
            case '03':
                 $this->mes1 = '05';
                 $this->mes2 = '06';
              break;
            case '04':
                 $this->mes1 = '07';
                 $this->mes2 = '08';
              break;
            case '05':
                 $this->mes1 = '09';
                 $this->mes2 = '10';
              break;
            case '06':
                 $this->mes1 = '11';
                 $this->mes2 = '12';
              break;
        }
  
  
          if($this->perio == 'mensual' || $this->perio == 'bimestral')
          {
              if($this->perio == 'mensual')
              {
                  $fecha = new DateTime($this->ano.'-'.$this->mes);
                  $fecha->modify('first day of this month');
                  $inicial = $fecha->format('Y-m-d');
  
                  $fecha = new DateTime($this->ano.'-'.$this->mes);
                  $fecha->modify('last day of this month');
                  $final = $fecha->format('Y-m-d');
              }
              else
              {
                  $fecha = new DateTime($this->ano.'-'.$this->mes1);
                  $fecha->modify('first day of this month');
                  $inicial = $fecha->format('Y-m-d');
  
                  $fecha = new DateTime($this->ano.'-'.$this->mes2);
                  $fecha->modify('last day of this month');
                  $final = $fecha->format('Y-m-d');
              }
          }
          else
          {
              if($this->perio == 'anual')
              {
                 $inicial = date('Y-m-d',strtotime($this->ano.'-01-01'));
                 $final = date('Y-m-d',strtotime($this->ano.'-12-31'));
              }
              else
              {
                 $inicial = $this->fechaini;
                 $final = $this->fechafin;
              }
          }

          $this->datos = $this->operaciones->balanza($inicial,$final,$this->radio);

        //  var_dump($this->datos);

          $this->pdf->SetAutoPageBreak(true,10);
          $this->pdf->AddPage();
          $this->pdf->SetTitle('Reporte Balanza de Comprobacion');
          $this->pdf->SetFillColor(220,220,220);
          $this->pdf->SetDrawColor(220,220,220);

          $this->encabezado();

          $this->pdf->SetFont('Helvetica','B',8);
          $this->pdf->Ln(10);
          $this->pdf->Cell(40,5,'Cuenta-Sub Cta',0,1,'',true);
          // $this->pdf->SetY(55);
          // $this->pdf->SetCol(0.3);
          //$this->pdf->Cell(20,5,'Sub Cta',0,1,'',true);
          $this->pdf->SetY(55);
          $this->pdf->SetCol(0.6);
          $this->pdf->Cell(70,5,'Nombre',0,1,'',true);
          $this->pdf->SetY(55);
          $this->pdf->SetCol(1.4);
          $this->pdf->Cell(20,5,'Inicial',0,1,'',true);
          $this->pdf->SetY(55);
          $this->pdf->SetCol(1.7);
          $this->pdf->Cell(30,5,'Cargos',0,1,'',true);
          $this->pdf->SetY(55);
          $this->pdf->SetCol(2.1);
          $this->pdf->Cell(30,5,'Abonos',0,1,'',true);
          $this->pdf->SetY(55);
          $this->pdf->SetCol(2.4);
          $this->pdf->Cell(40,5,'Saldo mensual',0,1,'',true);
          $this->pdf->SetY(55);
          $this->pdf->SetCol(2.8);
          $this->pdf->Cell(17,5,'Final',0,1,'',true);
          $this->pdf->SetCol(0);
          $this->pdf->Ln(5);
//          $this->pdf->SetWidths(array(26,50,30,20,25,25,20));
          $this->pdf->SetFont('Helvetica','',8);
          

          $total_inicial = 0;
          $total_cargos = 0;
          $total_abonos = 0;
          $total_saldo_mensual = 0;
          $final = 0;

          $str = count($this->datos);
          $i = 0;

          while($i < $str)
          {

            $valors = $this->datos[$i]['cuenta'];


            $total_inicialsub = 0;
            $total_cargossub = 0;
            $total_abonossub = 0;
            $finalsub = 0;
            $algosub = 0;
            while($valors == $this->datos[$i]['cuenta'] AND $i < $str)
            {
              $cuen = $this->datos[$i];
                $this->pdf->SetCol(0);
                $this->pdf->Cell(17,0,$cuen['cuenta'].' - '.$cuen['sub_cta']. ' - ' .$cuen['ssub_cta'],0,1,'L');
                $this->pdf->SetCol(0.3);
                $this->pdf->Cell(17,0,utf8_decode($cuen['nombre']),0,1,'L');
                $this->pdf->SetCol(1.4);
                $this->pdf->Cell(17,0,number_format($cuen['sini'],2,'.',','),0,1,'R');
                $this->pdf->SetCol(1.7);
                $this->pdf->Cell(17,0,number_format($cuen['cargos'],2,'.',','),0,1,'R');
                $this->pdf->SetCol(2.1);
                $this->pdf->Cell(17,0,number_format($cuen['abonos'],2,'.',','),0,1,'R');
                $this->pdf->SetCol(2.4);
                $this->pdf->Cell(17,0,number_format($cuen['cargos']-$cuen['abonos'],2,'.',','),0,1,'R');
                $this->pdf->SetCol(2.8);
                $this->pdf->Cell(17,0,number_format(($cuen['sini'] + $cuen['cargos']) - $cuen['abonos'],2,'.',','),0,1,'R');
              

                $total_inicial = $total_inicial + $this->datos[$i]['sini']; 
                $total_cargos = $total_cargos + $this->datos[$i]['cargos'];
                $total_abonos = $total_abonos + $this->datos[$i]['abonos'];
                $nada = $this->datos[$i]['cargos'] - $this->datos[$i]['abonos'];
                $total_saldo_mensual = $total_saldo_mensual + $nada;
                $algo = ($this->datos[$i]['sini']+$this->datos[$i]['cargos'])-$this->datos[$i]['abonos'];
                $final = $final + $algo;

                $total_inicialsub = $total_inicialsub + $cuen['sini']; 
                $total_cargossub = $total_cargossub + $cuen['cargos'];
                $total_abonossub = $total_abonossub + $cuen['abonos'];
                $algosub = ($cuen['sini']+$cuen['cargos'])-$cuen['abonos'];
                $finalsub = $finalsub + $algosub;

                $this->pdf->Ln(4);
  

                $i = $i + 1;

                
            }

           
                          $this->pdf->SetCol(0);
                          $this->pdf->Cell(94,0);
                          $this->pdf->Cell(10,-7,'__________________________________________________________________');
                         
                          $cutsn = $this->cuentas->buscarcuentamayor($valors);
                          $this->pdf->SetCol(0);
                          $this->pdf->Cell(17,0,'',0,1,'C');
                          $this->pdf->SetCol(0.3);
                          $this->pdf->Cell(17,0,utf8_decode(isset($cutsn[0]['nombre']) ? $cutsn[0]['nombre'] : ''),0,1,'');
                          $this->pdf->SetCol(1.4);
                          $this->pdf->Cell(17,0,number_format($total_inicialsub,2,'.',','),0,1,'R');
                          $this->pdf->SetCol(1.7);
                          $this->pdf->Cell(17,0,number_format($total_cargossub,2,'.',','),0,1,'R');
                          $this->pdf->SetCol(2.1);
                          $this->pdf->Cell(17,0,number_format($total_abonossub,2,'.',','),0,1,'R');
                          $this->pdf->SetCol(2.4);
                          $this->pdf->Cell(17,0,number_format($total_cargossub-$total_abonossub,2,'.',','),0,1,'R');
                          $this->pdf->SetCol(2.8);
                          $this->pdf->Cell(17,0,number_format($finalsub,2,'.',','),0,1,'R');
            
                          $this->pdf->SetCol(0);
                          $this->pdf->Cell(10,1,'______________________________________________________________________________________________________________________________');
                          $this->pdf->Ln(4);

                         
          }

             
              $this->pdf->Ln(4);
              

         
          $this->pdf->Ln(5);
          $this->pdf->SetCol(0.0);
          $this->pdf->Line(7,260,210,260);
          $this->pdf->Cell(65);
          $this->pdf->Cell(25,0,'Totales: ');
          $this->pdf->Cell(20,0,number_format($total_inicial,2,'.',','));
          $this->pdf->Cell(25,0,number_format($total_cargos,2,'.',','));
          $this->pdf->Cell(27,0,number_format($total_abonos,2,'.',','));
          $this->pdf->Cell(25,0,number_format($total_saldo_mensual,2,'.',','));
          $this->pdf->Cell(25,0,number_format($final,2,'.',','));

          $this->pdf->footer2();
          $this->pdf->Output('I','ReporteBalanzaComprobacion.pdf');

    }
    public function Excelexport()
    {
        $objPHPExcel = new PHPExcel();

        $this->rowc = $this->configModel->getConfig();

        $this->perio = $this->input->post('periodo');
        $this->mes = $this->input->post('mese');
        $this->bim = $this->input->post('bimes');
        $this->fechaini = $this->input->post('fecha_ini');
        $this->fechafin = $this->input->post('fecha_fin');
        $this->ano = $this->input->post('anol');
        $this->radio = $this->input->post('radiocuenta');

        if($this->mes == '13')
        {
          $this->mes = '12';
        }

        switch($this->bim)
        {
            case '01':
                 $this->mes1 = '01';
                 $this->mes2 = '02';
              break;
            case '02':
                 $this->mes1 = '03';
                 $this->mes2 = '04';
              break;
            case '03':
                 $this->mes1 = '05';
                 $this->mes2 = '06';
              break;
            case '04':
                 $this->mes1 = '07';
                 $this->mes2 = '08';
              break;
            case '05':
                 $this->mes1 = '09';
                 $this->mes2 = '10';
              break;
            case '06':
                 $this->mes1 = '11';
                 $this->mes2 = '12';
              break;
        }
  
  
          if($this->perio == 'mensual' || $this->perio == 'bimestral')
          {
              if($this->perio == 'mensual')
              {
                  $fecha = new DateTime($this->ano.'-'.$this->mes);
                  $fecha->modify('first day of this month');
                  $inicial = $fecha->format('Y-m-d');
  
                  $fecha = new DateTime($this->ano.'-'.$this->mes);
                  $fecha->modify('last day of this month');
                  $final = $fecha->format('Y-m-d');
              }
              else
              {
                  $fecha = new DateTime($this->ano.'-'.$this->mes1);
                  $fecha->modify('first day of this month');
                  $inicial = $fecha->format('Y-m-d');
  
                  $fecha = new DateTime($this->ano.'-'.$this->mes2);
                  $fecha->modify('last day of this month');
                  $final = $fecha->format('Y-m-d');
              }
          }
          else
          {
              if($this->perio == 'anual')
              {
                 $inicial = date('Y-m-d',strtotime($this->ano.'-01-01'));
                 $final = date('Y-m-d',strtotime($this->ano.'-12-31'));
              }
              else
              {
                 $inicial = $this->fechaini;
                 $final = $this->fechafin;
              }
          }

          $this->datos = $this->operaciones->balanza($inicial,$final,$this->radio);

          header("Content-Type: text/html;charset=utf-8");
          header("Content-Type: application/vnd.ms-excel");
          header('Content-Disposition: attachment;filename="balanza.xls"');
          header('Cache-Control: max-age=0');

          $objsheet = $objPHPExcel->setActiveSheetIndex(0);
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:G2');
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:G3');
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:G4');

          $objsheet->setCellValue('A1',$this->rowc[0]['nombreEmpresa']);
          $objsheet->setCellValue('A2','Reporte Balanza de Comprobación');

          if($this->perio == 'mensual' || $this->perio == 'bimestral')
          {
              if($this->perio == 'mensual')
              {
                  switch($this->mes)
                  {
                      case '01':
                          $mesle = 'Enero';
                        break;
                      case '02':
                          $mesle = 'Febrero';
                        break;
                      case '03':
                          $mesle = 'Marzo';
                        break;
                      case '04':
                          $mesle = 'Abril';
                        break;
                      case '05':
                          $mesle = 'Mayo';
                        break;
                      case '06':
                          $mesle = 'Junio';
                        break;
                      case '07':
                          $mesle = 'Julio';
                        break;
                      case '08':
                          $mesle = 'Agosto';
                        break;
                      case '09':
                          $mesle = 'Septiembre';
                        break;
                      case '10':
                          $mesle = 'Octubre';
                        break;
                      case '11':
                          $mesle = 'Noviembre';
                        break;
                      case '12':
                          $mesle = 'Diciembre';
                        break;
                  }
                $objsheet->setCellValue('A3','Periodo: Mensual');
                $objsheet->setCellValue('A4',$mesle);
              }
              else
              {
                  switch($this->bim)
                  {
                      case '01':
                        $bisme = '1er. Bimestre';
                      break;
                      case '02':
                        $bisme = '2do. Bimestre';
                      break;
                      case '03':
                        $bisme = '3er. Bimestre';
                      break;
                      case '04':
                        $bisme = '4to. Bimestre';
                      break;
                      case '05':
                        $bisme = '5to. Bimestre';
                      break;
                      case '06':
                        $bisme = '6to. Bimestre';
                      break;
                  }
                  $objsheet->setCellValue('A3','Periodo: Bimestral');
                  $objsheet->setCellValue('A4',$bisme);
              }
          }
          else
          {
              if($this->perio == 'anual')
              {
                $objsheet->setCellValue('A3','Periodo: Anual');
                $objsheet->setCellValue('A4','Del: '.date('d-m-Y',strtotime($this->ano.'-01-01')).' Al: '.date('d-m-Y',strtotime($this->ano.'-12-31')));
              }
              else
              {
                $objsheet->setcellValue('A3','Periodo: Otro');
                $objsheet->SetCellValue('A4','Del: '.date('d-m-Y',strtotime($this->fechaini)).' Al: '.date('d-m-Y',strtotime($this->fechafin)));
              }
          }

          $objsheet->setCellValue('A6','Cuenta-Sub Cta');
          //$objsheet->setCellValue('B6','Sub Cta');
          $objsheet->setCellValue('B6','Nombre');
          $objsheet->setCellValue('C6','Inicial');
          $objsheet->setCellValue('D6','Cargos');
          $objsheet->setCellValue('E6','Abonos');
          $objsheet->setCellValue('F6','Saldo Mensual');
          $objsheet->setCellValue('G6','Final');

          
          $total_inicial = 0;
          $total_cargos = 0;
          $total_abonos = 0;
          $total_saldo_mensual = 0;
          $final = 0;

          $numero=7;
          $numero2=12;
         
          $str = count($this->datos);
          $i = 0;

          $maespa = (int) $str + (int) $str;

          $styleArray = array(
            'borders' => array(
              'bottom' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              )
            )
          );



          while($i < $str)
          {
              $valors = $this->datos[$i]['cuenta'];

            

              $total_inicialsub = 0;
              $total_cargossub = 0;
              $total_abonossub = 0;
              $total_saldo_mensualsub = 0;
              $finalsub = 0;
              $algosub = 0;
              $nadasub = 0;

              

              while($valors == $this->datos[$i]['cuenta'] AND $i < $str)
              {
                  $cuen = $this->datos[$i];

                  $numero++;
                  $numero2++;
               
                  $objsheet->setCellValue('A'.$numero,$cuen['cuenta'].' - '.$cuen['sub_cta'].' - '.$cuen['ssub_cta']);
                  $objsheet->setCellValue('B'.$numero,utf8_decode($cuen['nombre']));
                  $objsheet->setCellValue('C'.$numero,number_format($cuen['sini'],2,'.',','));
                  $objsheet->setCellValue('D'.$numero,number_format($cuen['cargos'],2,'.',','));
                  $objsheet->setCellValue('E'.$numero,number_format($cuen['abonos'],2,'.',','));
                  $objsheet->setCellValue('F'.$numero,number_format($cuen['cargos']-$cuen['abonos'],2,'.',','));
                  $objsheet->setCellValue('G'.$numero,number_format(($cuen['sini'] + $cuen['cargos']) - $cuen['abonos'],2,'.',','));
                  
                  $total_inicial = $total_inicial + $this->datos[$i]['sini']; 
                  $total_cargos = $total_cargos + $this->datos[$i]['cargos'];
                  $total_abonos = $total_abonos + $this->datos[$i]['abonos'];
                  $nada = $this->datos[$i]['cargos'] - $this->datos[$i]['abonos'];
                  $total_saldo_mensual = $total_saldo_mensual + $nada;
                  $algo = ($this->datos[$i]['sini']+$this->datos[$i]['cargos'])-$this->datos[$i]['abonos'];
                  $final = $final + $algo;

                  $total_inicialsub = $total_inicialsub + $cuen['sini']; 
                  $total_cargossub = $total_cargossub + $cuen['cargos'];
                  $total_abonossub = $total_abonossub + $cuen['abonos'];
                  $nadasub = $cuen['cargos'] - $cuen['abonos'];
                  $total_saldo_mensualsub = $total_saldo_mensualsub + $nadasub;
                  $algosub = ($cuen['sini']+$cuen['cargos'])-$cuen['abonos'];
                  $finalsub = $finalsub + $algosub;

                  $i = $i + 1;
              }

                $cutsn = $this->cuentas->buscarcuentamayor($valors);

                $objPHPExcel->getActiveSheet()->getStyle('C'.$numero.':G'.$numero)->applyFromArray($styleArray);
                
                $numero++;

                $objsheet->setCellValue('A'.$numero,'');
                $objsheet->setCellValue('B'.$numero,utf8_decode(isset($cutsn[0]['nombre']) ? $cutsn[0]['nombre'] : ''));
                $objsheet->setCellValue('C'.$numero,number_format($total_inicialsub,2,'.',','));
                $objsheet->setCellValue('D'.$numero,number_format($total_cargossub,2,'.',','));
                $objsheet->setCellValue('E'.$numero,number_format($total_abonossub,2,'.',','));
                $objsheet->setCellValue('F'.$numero,number_format($total_saldo_mensualsub,2,'.',','));
                $objsheet->setCellValue('G'.$numero,number_format($finalsub,2,'.',','));

                $objPHPExcel->getActiveSheet()->getStyle('A'.$numero.':G'.$numero)->applyFromArray($styleArray);


               
            
          }

              $objsheet->setCellValue('A'.$maespa,'');
              $objsheet->setCellValue('B'.$maespa,'Totales: ');
              $objsheet->setCellValue('C'.$maespa,number_format($total_inicial,2,'.',','));
              $objsheet->setCellValue('D'.$maespa,number_format($total_cargos,2,'.',','));
              $objsheet->setCellValue('E'.$maespa,number_format($total_abonos,2,'.',','));
              $objsheet->setCellValue('F'.$maespa,number_format($total_saldo_mensual,2,'.',','));
              $objsheet->setCellValue('G'.$maespa,number_format($final,2,'.',','));

          


          $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
          $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
          $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
          $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
          $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
          $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
          $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);


          $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $styleleft = array(
          'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
          )
      );
          $styleright = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            )
        );

        

      $lastrow = $objPHPExcel->getActiveSheet()->getHighestRow();



        $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($style); 
        $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->applyFromArray($style); 
        $objPHPExcel->getActiveSheet()->getStyle('A4:G4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('A5:G5')->applyFromArray($style);    

        $objPHPExcel->getActiveSheet()->getStyle('B1:B'.$lastrow)->applyFromArray($styleleft);
        $objPHPExcel->getActiveSheet()->getStyle('C1:C'.$lastrow)->applyFromArray($styleright);
        $objPHPExcel->getActiveSheet()->getStyle('D1:D'.$lastrow)->applyFromArray($styleright);
        $objPHPExcel->getActiveSheet()->getStyle('E1:E'.$lastrow)->applyFromArray($styleright);
        $objPHPExcel->getActiveSheet()->getStyle('F1:F'.$lastrow)->applyFromArray($styleright);
        $objPHPExcel->getActiveSheet()->getStyle('G1:G'.$lastrow)->applyFromArray($styleright);

        $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');

    }
    public function encabezado()
    {
        date_default_timezone_set("America/Mexico_City");
        // $img = $this->rowc[0]['imgName'];
        // $formato = explode(".",$this->rowc[0]['imgName']);
        // $imagen = $this->rowc[0]['img'];
        // base64_decode($imagen));
        if(!empty($this->rowc[0]['img']) || $this->rowc[0]['img']!='' ){

          
            $formato = explode(".", $this->rowc[0]['imgName']);
            $imagen =$this->rowc[0]['img'];
          
          // Guardamos la imagen
          file_put_contents(APPPATH . 'public'.DIRECTORY_SEPARATOR.'Logo_' . $this->rowc[0]['rfc'] .'.'.$formato[1] ,
            base64_decode($imagen));
            // if($this->rowSerie[0]['noLogo']!=1)
            // {$this->pdf->Image(APPPATH . 'public'.DIRECTORY_SEPARATOR.'Logo_' . $this->rowc[0]['rfc'] .'.'.$formato[1],2,2,90,30);}
        }
        if(isset($formato))
        {
          $this->pdf->Image(APPPATH . 'public'.DIRECTORY_SEPARATOR.'Logo_' . $this->rowc[0]['rfc'] .'.'.$formato[1],2,2,80,50);
        }

        $this->pdf->SetFont('Helvetica','B',15);
        $this->pdf->Cell(70);
        $this->pdf->Cell(10,0,$this->rowc[0]['nombreEmpresa'],0,0,'L');
        $this->pdf->Ln(20);
        $this->pdf->Cell(70);
        $this->pdf->SetFont('Helvetica','B',10);
        $this->pdf->Cell(10,0,'Reporte: Balanza de Comprobacion');
        $this->pdf->Ln(5);
        $this->pdf->Cell(70);
        $this->pdf->SetFont('Helvetica','B',10);
        if($this->perio == 'mensual' || $this->perio == 'bimestral')
        {
            if($this->perio == 'mensual')
            {
                switch($this->mes)
                {
                    case '01':
                        $mesle = 'Enero';
                      break;
                    case '02':
                        $mesle = 'Febrero';
                      break;
                    case '03':
                        $mesle = 'Marzo';
                      break;
                    case '04':
                        $mesle = 'Abril';
                      break;
                    case '05':
                        $mesle = 'Mayo';
                      break;
                    case '06':
                        $mesle = 'Junio';
                      break;
                    case '07':
                        $mesle = 'Julio';
                      break;
                      case '08':
                        $mesle = 'Agosto';
                      break;
                      case '09':
                        $mesle = 'Septiembre';
                      break;
                      case '10':
                        $mesle = 'Octubre';
                      break;
                      case '11':
                        $mesle = 'Noviembre';
                      break;
                      case '12':
                        $mesle = 'Diciembre';
                      break;
                }
               $this->pdf->Cell(10,0,'Periodo: Mensual');
               $this->pdf->Ln(10);
               $this->pdf->Cell(70);
               $this->pdf->Cell(10,0,$mesle);
            }
            else
            {
                switch($this->bim)
                {
                    case '01':
                      $bisme = '1er. Bimestre';
                    break;
                    case '02':
                      $bisme = '2do. Bimestre';
                    break;
                    case '03':
                      $bisme = '3er. Bimestre';
                    break;
                    case '04':
                      $bisme = '4to. Bimestre';
                    break;
                    case '05':
                      $bisme = '5to. Bimestre';
                    break;
                    case '06':
                      $bisme = '6to. Bimestre';
                    break;
                }
                $this->pdf->Cell(10,0,'Periodo: Bimestral');
                $this->pdf->Ln(10);
                $this->pdf->Cell(70);
                $this->pdf->Cell(10,0,$bisme);
            }
        }
        else
        {
            if($this->perio == 'anual')
            {
                $this->pdf->Cell(10,0,'Periodo: Anual');
                $this->pdf->Ln(10);
                $this->pdf->Cell(70);
                $this->pdf->Cell(10,0,'Del: '.date('d-m-Y',strtotime($this->ano.'-01-01')).' Al: '.date('d-m-Y',strtotime($this->ano.'-12-31')));
            }
            else
            {
                $this->pdf->Cell(10,0,'Periodo: Otro');
                $this->pdf->Ln(10);
                $this->pdf->Cell(70);
                $this->pdf->Cell(10,0,'Del: '.date('d-m-Y',strtotime($this->fechaini)).' Al: '.date('d-m-Y',strtotime($this->fechafin)));
            }
        }
    }
    function Rowpdf($data,$align='C',$height1=5,$h2='2.5')
    {
        $nb=0;
        $yCell=0;$yEnviar=0;
        for($i=0;$i<count($data);$i++)
           $nb=max($nb,$this->pdf->NbLines($this->pdf->widths[$i],$data[$i]));
        $h=$height1*$nb;
        $pageB=$this->pdf->CheckPageBreak($h);
        $yAfuera=$this->pdf->GetY()+$h2;
        for($i=0;$i<count($data);$i++)
        {
         $w=$this->pdf->widths[$i];
         $a=isset($align) ? $align : 'C';
         $x=$this->pdf->GetX();
         $y=$this->pdf->GetY();
         $alturaCell=$this->pdf->MultiCell($w,$h2,$data[$i],0,$align);
         if($alturaCell+$h2>$yCell){$yCell=$alturaCell+$h2;}
         $this->pdf->SetXY($x+$w,$y);
       }
       return $yCell;
    }
}