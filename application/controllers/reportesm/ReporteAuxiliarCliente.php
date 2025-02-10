<?php


class ReporteAuxiliarCliente extends MY_Controller
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
            $permisos=$this->permisosForma($_SESSION['id'],12);
            $data=array('titulo'=>'Reporte Auxiliar Cliente','rfc' => $rfc[0]['rfc'],'razon' => $this->validaempresas->get_razon($_SESSION['idEmpresa']),'errores'=>$errores,'permisosGrupo'=>$permisos);
            $items=$this->menuModel->menus($_SESSION['tipo']);
            $this->multi_menu->set_items($items);
            $this->load->view('templates/header');
            $this->load->view('templates/navigation',$data);
            $this->load->view('reportes/reportesauxiliarcliente');
            $this->load->view('templates/footer');
        }
        else
        {
            redirect('inicio/login','refresh');
        }
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
         $this->pdf->Cell(10,0,'Reporte: Auxiliar cliente');
         $this->pdf->Ln(5);
         $this->pdf->Cell(70);
         $this->pdf->SetFont('Helvetica','B',10);
         $this->pdf->Cell(10,0,'Periodo del: '.date('d-m-Y',strtotime($this->fechaini)).' Al '.date('d-m-Y',strtotime($this->fechafin)));
         $this->pdf->Ln(5);
         $this->pdf->Cell(70);
         $this->pdf->SetFont('Helvetica','B',10);
         $this->pdf->Cell(10,0,'108 - '.$this->subcun.': '.utf8_decode($this->cuentacliente[0]['nombre']) );
     }
     public function Excelexport()
     {

      $objPHPExcel = new PHPExcel();

      $this->rowc = $this->configModel->getConfig();

      $this->subcun = $this->input->post('subcuenta');

      $this->fechaini = $this->input->post('fechaini');
      $this->fechafin = $this->input->post('fechafin');

      $this->no_pagado = $this->input->post('no_pagado');

      $this->datosdetalle = $this->operaciones->auxiliarcliente($this->subcun,$this->fechaini.' 00:00:00',$this->fechafin.' 23:59:59');

      $this->cuentacliente = $this->cuentas->get_cuenta_existe(108,$this->subcun);

      header("Content-Type: text/html;charset=utf-8");
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="auxliar_cliente.xls"');
      header('Cache-Control: max-age=0');

      $objsheet = $objPHPExcel->setActiveSheetIndex(0);
      $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
      $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:G2');
      $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:G3');
      $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:G4');

      $objsheet->setCellValue('A1',$this->rowc[0]['nombreEmpresa']);
      $objsheet->setCellValue('A2','Reporte Auxiliar Cliente');
      $objsheet->setCellValue('A3','Corte del: '.date('d-m-Y',strtotime($this->fechaini)).' Al '.date('d-m-Y',strtotime($this->fechafin)));
      $objsheet->setCellValue('A4','Cuenta: 108-'.$this->subcun.': '.utf8_decode($this->cuentacliente[0]['nombre']));

      $objsheet->setCellValue('A5','Fecha');
      $objsheet->setCellValue('B5','');
      $objsheet->setCellValue('C5','Referencia');
      $objsheet->setCellValue('D5','Concepto');
      $objsheet->setCellValue('E5','Cargo');
      $objsheet->setCellValue('F5','Abono');
      $objsheet->setCellValue('G5','Saldo');

      $totregs = count($this->datosdetalle);

      $saldo2 = 0;

      $numero=6;

      for($i=0;$i<$totregs;$i++)
        {
               $numero++;
              $lrefe = $this->datosdetalle[$i]->referencia;
              $napu = $i;
              $x = $i;
              $cargo = 0;
              $abono = 0;
              $saldo = 0;
              $saldoacum = 0;
            do{
                  if($this->datosdetalle[$x]->c_a == '+')
                  {
                     $cargo = $cargo + $this->datosdetalle[$x]->monto;
                    $saldoacum = $saldoacum + $this->datosdetalle[$x]->monto;
                  }
                    else
                    {
                     $abono = $abono + $this->datosdetalle[$x]->monto;
                     $saldoacum = $saldoacum - $this->datosdetalle[$x]->monto;
                    }
                   if($this->no_pagado == 0)
                  {
                      $saldo2 = $saldo2 + $saldoacum;
            					$this->imprimeRegistroexcel($x,$saldoacum);
                  } 
                  $x = $x + 1;
                	        if($x == $totregs)
                {
                  break;
                }        
              }
            while($lrefe == $this->datosdetalle[$x]->referencia );
           
		            	$apuf = $x-1;
                  $saldo = $cargo - $abono;
                  $saldo2 = $saldo2 + $saldo;
                  if($this->no_pagado == 1 && $saldo <> 0)
                  {
                      $this->muestraPendienteexcel($napu,$apuf,$saldo);
                  }
                    $i = $apuf;


   }


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

    // $styleleft = array(
    //     'alignment' => array(
    //         'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //     )
    // );

    // $styleright = array(
    //     'alignment' => array(
    //         'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
    //     )
    // );

    // $lastrow = $objPHPExcel->getActiveSheet()->getHighestRow();

    // $objPHPExcel->getActiveSheet()->getStyle('D1:D'.$lastrow)->applyFromArray($styleleft);

    // $objPHPExcel->getActiveSheet()->getStyle('E1:E'.$lastrow)->applyFromArray($styleright);
    // $objPHPExcel->getActiveSheet()->getStyle('F1:F'.$lastrow)->applyFromArray($styleright);
    // $objPHPExcel->getActiveSheet()->getStyle('G1:G'.$lastrow)->applyFromArray($styleright);

    

    $objPHPExcel->getDefaultStyle()->applyFromArray($style);
    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
    $objWriter->save('php://output');

     }

     public function muestraPendienteexcel($napu,$apuf,$saldo)
     {
       for($j=$napu;$j<=$apuf;$j++)
       {
         $valor = 0;
         if ($j==$apuf)
         {
           $valor = $saldo;
         }
         $this->imprimeRegistroexcel($j,$valor);
       }
     }
   
     public function imprimeRegistroexcel($x,$saldo)
     {
      var_dump($saldo);
     //  $objsheet->setCellValue('A'.$numero,date('d-m-Y',strtotime($this->datosdetalle[$x]->fecha)));
      //  $objsheet->setCellValue('B'.$numero,$this->datosdetalle[$x]->tipo_mov.'-'.$this->datosdetalle[$x]->no_banco.'-'.$this->datosdetalle[$x]->no_mov);
      //  $objsheet->setCellValue('C'.$numero,$this->datosdetalle[$x]->referencia);
      //  $objsheet->setCellValue('D'.$numero,$this->datosdetalle[$x]->concepto);

      //  if ($this->datosdetalle[$x]->c_a == '+')
      //  {  
      //     $objsheet->setCellValue('E'.$numero,number_format($this->datosdetalle[$x]->monto,2,'.',','));
      //  }
      //  else
      //  {
      //    $objsheet->setCellValue('F'.$numero,number_format($this->datosdetalle[$x]->monto,2,'.',','));
      //  }
   
      //  $objsheet->setCellValue('G'.$numero,number_format($saldo,2,'.',','));
     }

     public function imprimir()
     {
        $this->rowc = $this->configModel->getConfig();

        $this->subcun = $this->input->post('subcuenta');

        $this->fechaini = $this->input->post('fechaini');
        $this->fechafin = $this->input->post('fechafin');

        $this->no_pagado = $this->input->post('no_pagado');

        $this->datosdetalle = $this->operaciones->auxiliarcliente($this->subcun,$this->fechaini.' 00:00:00',$this->fechafin.' 23:59:59');

        $this->cuentacliente = $this->cuentas->get_cuenta_existe(108,$this->subcun);

      //  var_dump($this->datosdetalle);

        $this->pdf->SetAutoPageBreak(true,10);
        $this->pdf->AddPAge();
        $this->pdf->SetTitle('Reporte Auxiliar Cliente');
        $this->pdf->SetFillColor(220,220,220);
        $this->pdf->SetDrawColor(220,220,220);

        $this->encabezado();

        $this->pdf->Ln(15);

        $this->pdf->Cell(20,5,'Fecha',0,1,'',true);
        $this->pdf->SetY(55);
        $this->pdf->SetCol(0.3);
        $this->pdf->Cell(20,5,'',0,1,'',true);
        $this->pdf->SetY(55);
        $this->pdf->SetCol(0.6);
        $this->pdf->Cell(15,5,'Refe',0,1,'',true);
        $this->pdf->SetY(55);
        $this->pdf->SetCol(0.8);
        $this->pdf->Cell(78,5,'Concepto',0,1,'',true);
        $this->pdf->SetY(55);
        $this->pdf->SetCol(2);
        $this->pdf->Cell(20,5,'Cargo',0,1,'',true);
        $this->pdf->SetY(55);
        $this->pdf->SetCol(2.3);
        $this->pdf->Cell(20,5,'Abono',0,1,'',true);
        $this->pdf->SetY(55);
        $this->pdf->SetCol(2.6);
        $this->pdf->Cell(25,5,'Saldo',0,1,'',true);
        $this->pdf->Ln(5);
      //   $this->pdf->SetCol(0);
      //   $this->pdf->SetFont('Helvetica','',10);
      //   $this->pdf->Cell(10,0,'Cuenta: '.$this->datosbanco[0]['cuenta'].' - '.$this->datosbanco[0]['sub_cta']);
      //   $this->pdf->Cell(50);
      //   $this->pdf->Cell(60,0,$this->datosbanco[0]['nombre']);
      //   $this->pdf->Cell(10,0,'Saldo Inicial: '.number_format($saldo,2,'.',','));
      //  $this->pdf->Ln(5);
      //  $this->pdf->SetWidths(array(20,20,15,74,20,20,25));
        $this->pdf->SetFont('Helvetica','',8);

        $totregs = count($this->datosdetalle);

        
        $saldo2 = 0;
for($i=0;$i<$totregs;$i++)
        {
		$lrefe = $this->datosdetalle[$i]->referencia;
		$napu = $i;
		$x = $i;
    $cargo = 0;
    $abono = 0;
    $saldo = 0;
    $saldoacum = 0;
            do{
                  if($this->datosdetalle[$x]->c_a == '+')
                  {
                     $cargo = $cargo + $this->datosdetalle[$x]->monto;
                    $saldoacum = $saldoacum + $this->datosdetalle[$x]->monto;
                  }
                    else
                    {
                     $abono = $abono + $this->datosdetalle[$x]->monto;
                     $saldoacum = $saldoacum - $this->datosdetalle[$x]->monto;
                    }
                   if($this->no_pagado == 0)
                  {
                      $saldo2 = $saldo2 + $saldoacum;
            					$this->imprimeRegistro($x,$saldoacum);
                  } 
                  $x = $x + 1;
                	        if($x == $totregs)
                {
                  break;
                }        
              }
            while($lrefe == $this->datosdetalle[$x]->referencia );
           
		            	$apuf = $x-1;
                  $saldo = $cargo - $abono;
                  $saldo2 = $saldo2 + $saldo;
                  if($this->no_pagado == 1 && $saldo <> 0)
                  {
                      $this->muestraPendiente($napu,$apuf,$saldo);
                  }
                    $i = $apuf;


   }

   $this->totalsaldo($saldo2);
  


        $this->pdf->footer2();

        $this->pdf->Output('I','ReporteAuxiliarCliente.pdf');
     }

  


public function muestraPendiente($napu,$apuf,$saldo)
{
  for($j=$napu;$j<=$apuf;$j++)
  {
    $valor = 0;
    if ($j==$apuf)
    {
      $valor = $saldo;
    }
    $this->imprimeRegistro($j,$valor);
  }
}




  public function imprimeRegistro($x,$saldo)
  {
                  $this->pdf->SetCol(0);
                      $this->pdf->Cell(17,0,date('d-m-Y',strtotime($this->datosdetalle[$x]->fecha)),0,1,'C');
                      $this->pdf->SetCol(0.3);
                      $this->pdf->Cell(17,0,$this->datosdetalle[$x]->tipo_mov.'-'.$this->datosdetalle[$x]->no_banco.'-'.$this->datosdetalle[$x]->no_mov,0,1,'');
                      $this->pdf->SetCol(0.6);
                      $this->pdf->Cell(17,0,$this->datosdetalle[$x]->referencia,0,1,'L');
                      $this->pdf->SetCol(0.8);
                      $this->pdf->Cell(17,0,$this->datosdetalle[$x]->concepto,0,1,'L');
                    
                      if ($this->datosdetalle[$x]->c_a == '+')
                      {
                        $this->pdf->SetCol(2.0);
                        $this->pdf->Cell(17,0,number_format($this->datosdetalle[$x]->monto,2,'.',','),0,1,'R');
                      }
                      else
                      {
                        $this->pdf->SetCol(2.4);
                        $this->pdf->Cell(17,0,number_format($this->datosdetalle[$x]->monto,2,'.',','),0,1,'R');
                      }
                        $this->pdf->SetCol(2.7);
                        $this->pdf->Cell(17,0,number_format($saldo,2,'.',','),0,1,'R');
                        $this->pdf->Ln(5);


                      // break;
  }
  public function totalsaldo($saldo)
  {
    $this->pdf->SetCol(2.2);
      $this->pdf->Cell(17,0,'_________________________________',0,1);
      $this->pdf->Ln(5);
      $this->pdf->Cell(50,0,'Total: $'.number_format($saldo,2,'.',','),0,1,'R');
  }
}

