<?php

class ReporteAuxiliarContable extends MY_Controller
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
            $data=array('titulo'=>'Reporte auxiliar contable','rfc' => $rfc[0]['rfc'],'razon' => $this->validaempresas->get_razon($_SESSION['idEmpresa']),'errores'=>$errores,'permisosGrupo'=>$permisos);
            $items=$this->menuModel->menus($_SESSION['tipo']);
            $this->multi_menu->set_items($items);
            $this->load->view('templates/header');
            $this->load->view('templates/navigation',$data);
            $this->load->view('reportes/reportesauxiliarcontable');
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
          $this->pdf->Image(APPPATH . 'public'.DIRECTORY_SEPARATOR.'Logo_' . $this->rowc[0]['rfc'] .'.'.$formato[1],2,2,50,30);
        }
        $this->pdf->SetFont('Helvetica','B',15);
        $this->pdf->SetCol (0.7);
        $this->pdf->Cell(10,0,$this->rowc[0]['nombreEmpresa'],0,0,'L');
        $this->pdf->Ln(10);
        $this->pdf->SetCol (0.7);
        $this->pdf->SetFont('Helvetica','B',10);
        $this->pdf->Cell(10,0,'Reporte: Auxiliar contable');
        $this->pdf->Ln(5);
        //$this->pdf->Cell(70);
        //$this->pdf->SetFont('Helvetica','B',10);
        $this->pdf->Cell(10,0,'Corte del: '.date('d-m-Y',strtotime($this->fechaini)).' Al '.date('d-m-Y',strtotime($this->fechafin)));
        $this->pdf->Ln(7);
        $this->pdf->SetCol (0);
    }
    public function detail_header($tipo,$numero = 0,$objsheet = null)
    {
        if($tipo == 'PDF')
        {
        $this->pdf->SetFillColor(220,220,220);
        $this->pdf->Cell(20,5,'Fecha',0,0,'L',true);
        $this->pdf->Cell(20,5,utf8_decode('Póliza'),0,0,'L',true);
        $this->pdf->Cell(15,5,'Refe',0,0,'L',true);
        $this->pdf->Cell(78,5,'Concepto',0,0,'L',true);
        $this->pdf->Cell(20,5,'Cargo',0,0,'R',true);
        $this->pdf->Cell(20,5,'Abono',0,0,'R',true);
        $this->pdf->Cell(25,5,'Saldo',0,0,'R',true);
    }
    else
    {
         $stylecolor = array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'D4D2D2')
        )
        ,
        'font' => array(
            'bold' => true
        )
        );

         $objsheet->getStyle('A'.$numero.':G'.$numero)->applyFromArray($stylecolor);
        $objsheet->setCellValue('A'.$numero,'Fecha');
        $objsheet->setCellValue('B'.$numero,'Póliza');
        $objsheet->setCellValue('C'.$numero,'Referencia');
        $objsheet->setCellValue('D'.$numero,'Concepto');
        $objsheet->setCellValue('E'.$numero,'Cargo');
        $objsheet->setCellValue('F'.$numero,'Abono');
        $objsheet->setCellValue('G'.$numero,'Saldo');

    }
    }
    public function imprimir()
    {
        $this->rowc = $this->configModel->getConfig();

        $this->cuenta = $this->input->post('cuenta');
        $this->subcun = $this->input->post('subcuenta');
        $this->ssubcun = $this->input->post('ssubcuenta');
        $this->subcun2 = $this->input->post('subcuenta2');
        $this->ssubcun2 = $this->input->post('ssubcuenta2');
        $this->fechaini = $this->input->post('fechaini');
        $this->fechafin = $this->input->post('fechafin');

        $this->agrupa = $this->input->post('agrupado');

        $this->saldoini = $this->operaciones->saldoinicial($this->cuenta,$this->subcun,$this->ssubcun,$this->subcun2,$this->ssubcun2,$this->fechaini);
        
        $this->datosdetalle = $this->operaciones->auxiliardetalle($this->cuenta,$this->subcun,$this->ssubcun,$this->subcun2,$this->ssubcun2,$this->fechaini,$this->fechafin,$this->agrupa);

        $this->datosbanco = $this->cuentas->verificarreportecuenta($this->cuenta,$this->subcun,$this->ssubcun,$this->subcun2,$this->ssubcun2);

        $saldo = 0;


        $this->pdf->SetAutoPageBreak(true,10);
        $this->pdf->AddPAge();
        $this->pdf->SetTitle('Reporte auxiliar contable');
        //$this->pdf->SetDrawColor(220,220,220);

        $this->encabezado();

        $this->pdf->Ln(5);
        $this->detail_header('PDF');
        
        $this->pdf->Ln(8);
        $this->pdf->SetFont('Helvetica','',10);
        $i = 0;
        for($j=0;$j<count($this->datosdetalle);$j++)
        { 
        $cta = $this->datosdetalle[$j]->cuenta;
        $scta = $this->datosdetalle[$j]->sub_cta;
        $sscta = $this->datosdetalle[$j]->ssub_cta;
        foreach($this->datosbanco as $valor => $key)      
              {
                //var_dump($this->datosbanco);
            if($cta == $this->datosbanco[$valor]['cuenta'] &&
            $scta == $this->datosbanco[$valor]['sub_cta'] &&
            $sscta == $this->datosbanco[$valor]['ssub_cta'])
            {
                break;
            }   
        }
        foreach($this->saldoini as $valor2 => $key2)
        {
            if($cta == $this->saldoini[$valor2]['cuenta'] &&
            $scta == $this->saldoini[$valor2]['sub_cta'] &&
            $sscta == $this->saldoini[$valor2]['ssub_cta'])
            {
                $saldo = ($this->saldoini[$valor2]['saldo']);
                break;
            }   
        }

        $this->pdf->SetFont('Helvetica','',10);
        $this->pdf->SetCol(0);
        $this->pdf->Cell(10,0,'Cuenta: '.$this->datosbanco[$valor]['cuenta'].'-'.$this->datosbanco[$valor]['sub_cta'].'-'.$this->datosbanco[$valor]['ssub_cta'].': '.$this->datosbanco[$valor]['nombre']);
        $this->pdf->Cell(130);
        $this->pdf->Cell(10,0,'Saldo Inicial: '.number_format($saldo,2,'.',','));
        $this->pdf->Ln(5);
        $this->pdf->SetCol(0);
      //  $this->pdf->SetWidths(array(20,20,15,74,20,20,25));
        $this->pdf->SetFont('Helvetica','',8);
        $totalcargo = 0;
        $totalabono = 0;
        $totalsaldo = $saldo;
        //for($i=0;$i<count($this->datosdetalle);$i++)
      
        while($i<count($this->datosdetalle) && $cta == $this->datosdetalle[$i]->cuenta && $scta == $this->datosdetalle[$i]->sub_cta && $sscta == $this->datosdetalle[$i]->ssub_cta)
        {

                        $this->pdf->SetCol(0);
                         if($i%2==0)
                        {
                        $this->pdf->SetFillColor(245,245,245);      
                        //$this->pdf->Cell(196,0,'',0,0,'',true);
                        //$this->pdf->SetCol(0);
                        }
                        else
                        {
                        $this->pdf->SetFillColor(255,255,255);
                        }
                        $this->pdf->Cell(20,4,date('d-m-Y',strtotime($this->datosdetalle[$i]->fecha)),0,0,'C',true);
                        $this->pdf->SetCol(0.3);
                        $this->pdf->Cell(22,4,$this->datosdetalle[$i]->tipo_mov.'-'.$this->datosdetalle[$i]->no_banco.'-'.$this->datosdetalle[$i]->no_mov,0,0,'',true);
                        $this->pdf->SetCol(0.6);
                        $this->pdf->Cell(17,4,$this->datosdetalle[$i]->rece,0,0,'L',true);
                        $this->pdf->SetCol(0.8);
                        $this->pdf->SetFont('Helvetica','',6);
                        $this->pdf->Cell(115,4,substr(trim($this->datosdetalle[$i]->beneficia).' '.trim($this->datosdetalle[$i]->conceenca).' '.trim($this->datosdetalle[$i]->concedeta),0,63),0,0,'L',true);
                        $this->pdf->SetFont('Helvetica','',8);
                        if($this->datosdetalle[$i]->signo == '+')
                        {
                        $this->pdf->SetCol(2.1);    
                         $totalcargo=$totalcargo + $this->datosdetalle[$i]->monto;
                         $totalsaldo= $totalsaldo + $this->datosdetalle[$i]->monto;
                        }
                        else
                        {
                        $this->pdf->SetCol(2.4);    
                         $totalabono=$totalabono - $this->datosdetalle[$i]->monto;
                         $totalsaldo=$totalsaldo - $this->datosdetalle[$i]->monto;
                        }
                        $this->pdf->Cell(30,4,number_format($this->datosdetalle[$i]->monto,2,'.',','),0,0,'R',true);
                        $this->pdf->SetCol(2.8);
                        //$this->pdf->Cell(17,4,'',0,1,'R');
                        //$this->pdf->SetCol(2.7);
                        $this->pdf->Cell(20,4,number_format($totalsaldo,2,'.',','),0,0,'R',true);
                        $this->pdf->Ln(3.5);
                            $i++;
        }           
        $j= $i;
        $this->pdf->Ln(5);
        $this->pdf->SetCol(0);
        $totales = $totalcargo + $totalabono;
        $this->pdf->Cell(120);
        $this->pdf->Cell(10,0,'Totales: '.' + '.number_format($totalcargo,2,'.',','),0,0,'L');
        $this->pdf->Cell(22);
        $this->pdf->Cell(10,0,number_format($totalabono,2,'.',',').' =',0,0,'L');
        $this->pdf->Cell(12);
        $this->pdf->Cell(10,0,number_format($totales,2,'.',','),0,0,'L');
        //$this->pdf->Ln(5);
        //$this->pdf->Cell(158);
        //$this->pdf->Cell(10,0,'Saldo Inicial: '.number_format($saldo,2,'.',','),0,0,'L');
       // $this->pdf->Line(170,105,200,105);
        $this->pdf->Ln(6);
        //$this->pdf->Cell(173);
        //$this->pdf->Cell(10,0,number_format($totales+$saldo,2,'.',','),0,0,'L');
        $this->pdf->SetCol(0);
        if ($j<count($this->datosdetalle))
        {
        $this->detail_header('PDF');
        }
        $this->pdf->Ln(8);
        }
         $this->pdf->footer2();

        $this->pdf->Output('I','ReporteAuxiliarContable.pdf');
    }
    public function Excelexport()
    {

        $objPHPExcel = new PHPExcel();

        $this->rowc = $this->configModel->getConfig();

        $this->cuenta = $this->input->post('cuenta');
        $this->subcun = $this->input->post('subcuenta');
        $this->ssubcun = $this->input->post('ssubcuenta');
        $this->subcun2 = $this->input->post('subcuenta2');
        $this->ssubcun2 = $this->input->post('ssubcuenta2');

        $this->fechaini = $this->input->post('fechaini');
        $this->fechafin = $this->input->post('fechafin');

        $this->agrupa = $this->input->post('agrupado');

        $this->saldoini = $this->operaciones->saldoinicial($this->cuenta,$this->subcun,$this->ssubcun,$this->subcun2,$this->ssubcun2,$this->fechaini);

        $this->datosdetalle = $this->operaciones->auxiliardetalle($this->cuenta,$this->subcun,$this->ssubcun,$this->subcun2,$this->ssubcun2,$this->fechaini,$this->fechafin,$this->agrupa);

        $this->datosbanco = $this->cuentas->verificarreportecuenta($this->cuenta,$this->subcun,$this->ssubcun,$this->subcun2,$this->ssubcun2);

        $saldo = 0;

        


        header("Content-Type: text/html;charset=utf-8");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="auxliar_contable.xls"');
        header('Cache-Control: max-age=0');

        $objsheet = $objPHPExcel->setActiveSheetIndex(0);
        $styleheader = array(
            'font' => array(
                'bold' => true,
                'size' => 12
            )
        );
        //$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:C6');
        //$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D6:G6');
        $numero=6;
        $objsheet->setCellValue('A1',$this->rowc[0]['nombreEmpresa']);
        $objsheet->setCellValue('A2','Reporte Auxiliar Contable');
        $objsheet->setCellValue('A3','Corte del: '.date('d-m-Y',strtotime($this->fechaini)).' Al '.date('d-m-Y',strtotime($this->fechafin)));
        $objsheet->getStyle('A1:A3')->applyFromArray($styleheader);
        $this->detail_header('Excel', $numero, $objsheet);
        $numero++;
        $i = 0;
        for($j=0; $j<count($this->datosdetalle); $j++)
        {
        $totalcargo = 0;
        $totalabono = 0;
            $cta = $this->datosdetalle[$j]->cuenta;
            $scta = $this->datosdetalle[$j]->sub_cta;
            $sscta = $this->datosdetalle[$j]->ssub_cta;
            foreach($this->datosbanco as $valor => $key)
            {
                if($cta == $this->datosbanco[$valor]['cuenta'] &&
                $scta == $this->datosbanco[$valor]['sub_cta'] &&
                $sscta == $this->datosbanco[$valor]['ssub_cta'])
                {
                    break;
                }   
            }
            foreach($this->saldoini as $valor2 => $key2)
            {
                if($cta == $this->saldoini[$valor2]['cuenta'] &&
                $scta == $this->saldoini[$valor2]['sub_cta'] &&
                $sscta == $this->saldoini[$valor2]['ssub_cta'])
                {
                    $saldo = ($this->saldoini[$valor2]['saldo']);
                    break;
                }   
            }
           
          $objsheet->setCellValue('A'.$numero,'Cuenta: '.$this->datosbanco[$valor]['cuenta'].'-'.$this->datosbanco[$valor]['sub_cta'].'-'.$this->datosbanco[$valor]['ssub_cta'].': '.$this->datosbanco[$valor]['nombre']);
          $objsheet->setCellValue('E'.$numero,'Saldo Inicial: ');
          $objsheet->setCellValue('F'.$numero,number_format($saldo,2,'.',','));
             $numero++;

                          $totalsaldo=$saldo;
                          while($i<count($this->datosdetalle) && $cta == $this->datosdetalle[$i]->cuenta && $scta == $this->datosdetalle[$i]->sub_cta && $sscta == $this->datosdetalle[$i]->ssub_cta)
                          {
                          
                            //var_dump($this->datosdetalle[$i]->tipo_mov.'-'.$this->datosdetalle[$i]->no_banco.'-'.$this->datosdetalle[$i]->no_mov);
                            $objsheet->setCellValue('A'.$numero,date('d-m-Y',strtotime($this->datosdetalle[$i]->fecha)));
                            $objsheet->setCellValue('B'.$numero,$this->datosdetalle[$i]->tipo_mov.'-'.$this->datosdetalle[$i]->no_banco.'-'.$this->datosdetalle[$i]->no_mov);
                            $objsheet->setCellValue('C'.$numero,$this->datosdetalle[$i]->rece);
                            $objsheet->setCellValue('D'.$numero,trim($this->datosdetalle[$i]->beneficia).' '.trim($this->datosdetalle[$i]->conceenca).' '.trim($this->datosdetalle[$i]->concedeta));
                            if($this->datosdetalle[$i]->signo == '+')
                            {
                            $objsheet->setCellValue('E'.$numero,number_format($this->datosdetalle[$i]->monto,2,'.',',')); 
                            $totalcargo = $totalcargo + $this->datosdetalle[$i]->monto;
                            $totalsaldo= $totalsaldo + $this->datosdetalle[$i]->monto;
                            }
                            else
                            {
                              $objsheet->setCellValue('F'.$numero,number_format($this->datosdetalle[$i]->monto,2,'.',',')); 
                              $totalabono = $totalabono + $this->datosdetalle[$i]->monto;
                              $totalsaldo= $totalsaldo - $this->datosdetalle[$i]->monto;
                            }
                           
                            $objsheet->setCellValue('G'.$numero,number_format($totalsaldo,2,'.',','));
                              $i++;
                            $numero++;
                              
                           }
                            
          $j= $i;
      //      $numero++;
           $objsheet->setCellValue('D'.($numero),'Totales: ');
           $objsheet->setCellValue('E'.($numero),'+ '.number_format($totalcargo,2,'.',','));
           $objsheet->setCellValue('F'.($numero),'- '.number_format($totalabono,2,'.',','));
           $objsheet->setCellValue('G'.($numero),'= '.number_format($totalcargo-$totalabono,2,'.',','));
           $numero++;
        //    $objsheet->setCellValue('F'.($numero),'Saldo Final :');
        //    $objsheet->setCellValue('G'.($numero),number_format($totalcargo-$totalabono,2,'.',','));
           
        if ($j<count($this->datosdetalle))
        {
        $numero++;
        $this->detail_header('Excel', $numero, $objsheet);
        $numero++;
        }

 }       


//        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
 //       $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
  //      $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
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
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:G2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:G3');

        $lastrow = $objPHPExcel->getActiveSheet()->getHighestRow();

        $objPHPExcel->getActiveSheet()->getStyle('D1:D'.$lastrow)->applyFromArray($styleleft);

        $objPHPExcel->getActiveSheet()->getStyle('E1:E'.$lastrow)->applyFromArray($styleright);
        $objPHPExcel->getActiveSheet()->getStyle('F1:F'.$lastrow)->applyFromArray($styleright);
        $objPHPExcel->getActiveSheet()->getStyle('G1:G'.$lastrow)->applyFromArray($styleright);

        //$objPHPExcel->getDefaultStyle()->applyFromArray($style);
        $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
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