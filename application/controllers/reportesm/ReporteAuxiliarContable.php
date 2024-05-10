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
            $data=array('titulo'=>'Reporte Auxiliar Contable','rfc' => $rfc[0]['rfc'],'razon' => $this->validaempresas->get_razon($_SESSION['idEmpresa']),'errores'=>$errores,'permisosGrupo'=>$permisos);
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
          $this->pdf->Image(APPPATH . 'public'.DIRECTORY_SEPARATOR.'Logo_' . $this->rowc[0]['rfc'] .'.'.$formato[1],2,2,80,50);
        }
        $this->pdf->SetFont('Helvetica','B',15);
        $this->pdf->Cell(70);
        $this->pdf->Cell(10,0,$this->rowc[0]['nombreEmpresa'],0,0,'L');
        $this->pdf->Ln(20);
        $this->pdf->Cell(70);
        $this->pdf->SetFont('Helvetica','B',10);
        $this->pdf->Cell(10,0,'Reporte: Auxiliar contable');
        $this->pdf->Ln(5);
        $this->pdf->Cell(70);
        $this->pdf->SetFont('Helvetica','B',10);
        $this->pdf->Cell(10,0,'Corte del: '.date('d-m-Y',strtotime($this->fechaini)).' Al '.date('d-m-Y',strtotime($this->fechafin)));
    }
    public function imprimir()
    {
        $this->rowc = $this->configModel->getConfig();

        $this->cuenta = $this->input->post('cuenta');
        $this->subcun = $this->input->post('subcuenta');
        $this->subcun2 = $this->input->post('subcuenta2');

        $this->fechaini = $this->input->post('fechaini');
        $this->fechafin = $this->input->post('fechafin');

        $this->agrupa = $this->input->post('agrupado');

        $this->saldoini = $this->operaciones->saldoinicial($this->cuenta,$this->subcun,$this->subcun2,$this->fechaini);

        $this->datosdetalle = $this->operaciones->auxiliardetalle($this->cuenta,$this->subcun,$this->subcun2,$this->fechaini,$this->fechafin,$this->agrupa);

        $this->datosbanco = $this->cuentas->verificarreportecuenta($this->cuenta,$this->subcun);

        $saldo = 0;

        for($j=0;$j<count($this->saldoini);$j++)
        {
            $saldo = $saldo + ($this->saldoini[$j]['saldo']);
        }

        $this->pdf->SetAutoPageBreak(true,10);
        $this->pdf->AddPAge();
        $this->pdf->SetTitle('Reporte Auxiliar Contable');
        $this->pdf->SetFillColor(220,220,220);
        $this->pdf->SetDrawColor(220,220,220);

        $this->encabezado();

        $this->pdf->Ln(20);

        $this->pdf->Cell(20,5,'Fecha',0,1,'',true);
        $this->pdf->SetY(55);
        $this->pdf->SetCol(0.3);
        $this->pdf->Cell(20,5,utf8_decode('Póliza'),0,1,'',true);
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
        $this->pdf->SetCol(0);
        $this->pdf->SetFont('Helvetica','',10);
        $this->pdf->Cell(10,0,'Cuenta: '.$this->datosbanco[0]['cuenta'].' - '.$this->datosbanco[0]['sub_cta']);
        $this->pdf->Cell(50);
        $this->pdf->Cell(60,0,$this->datosbanco[0]['nombre']);
        $this->pdf->Cell(10,0,'Saldo Inicial: '.number_format($saldo,2,'.',','));
        $this->pdf->Ln(5);
      //  $this->pdf->SetWidths(array(20,20,15,74,20,20,25));
        $this->pdf->SetFont('Helvetica','',8);
        $totalcargo = 0;
        $totalabono = 0;
//        $totalsaldo = 0;
        for($i=0;$i<count($this->datosdetalle);$i++)
        {
            do{

                if($this->datosdetalle[0]->signo == '+')
                {
                    if($this->datosdetalle[$i]->signo == '+')
                    {
                        
                        $totalsaldo=$saldo+$this->datosdetalle[$i]->monto;
                        $this->pdf->SetCol(0);
                        $this->pdf->Cell(17,0,date('d-m-Y',strtotime($this->datosdetalle[$i]->fecha)),0,1,'C');
                        $this->pdf->SetCol(0.3);
                        $this->pdf->Cell(17,0,$this->datosdetalle[$i]->tipo_mov.'-'.$this->datosdetalle[$i]->no_banco.'-'.$this->datosdetalle[$i]->no_mov,0,1,'');
                        $this->pdf->SetCol(0.6);
                        $this->pdf->Cell(17,0,$this->datosdetalle[$i]->rece,0,1,'L');
                        $this->pdf->SetCol(0.8);
                        $this->pdf->Cell(17,0,$this->datosdetalle[$i]->concedeta,0,1,'L');
                        $this->pdf->SetCol(2.0);
                        $this->pdf->Cell(17,0,number_format($this->datosdetalle[$i]->monto,2,'.',','),0,1,'R');
                        $this->pdf->SetCol(2.4);
                        $this->pdf->Cell(17,0,'',0,1,'R');
                        $this->pdf->SetCol(2.7);
                        $this->pdf->Cell(17,0,number_format($totalsaldo,2,'.',','),0,1,'R');
                        // $renglon=$this->Rowpdf(array(
                        //     date('d-m-Y',strtotime($this->datosdetalle[$i]->fecha)),
                        //     $this->datosdetalle[$i]->tipo_mov.'-'.$this->datosdetalle[$i]->no_banco.'-'.$this->datosdetalle[$i]->no_mov,
                        //     $this->datosdetalle[$i]->rece,
                        //     $this->datosdetalle[$i]->concedeta,
                        //     number_format($this->datosdetalle[$i]->monto,2,'.',','),
                        //     '',
                        //     number_format($totalsaldo,2,'.',',')
                        //  ));                                               
                         $totalcargo=$totalcargo+$this->datosdetalle[$i]->monto;
                         //$this->pdf->SetY($renglon-3.5);
                         $this->pdf->Ln(5);
                         break;
                    }
                    else
                    {
                        
                       $totalsaldo=$totalsaldo-$this->datosdetalle[$i]->monto;

                        $this->pdf->SetCol(0);
                        $this->pdf->Cell(17,0,date('d-m-Y',strtotime($this->datosdetalle[$i]->fecha)),0,1,'C');
                        $this->pdf->SetCol(0.3);
                        $this->pdf->Cell(17,0,$this->datosdetalle[$i]->tipo_mov.'-'.$this->datosdetalle[$i]->no_banco.'-'.$this->datosdetalle[$i]->no_mov,0,1,'');
                        $this->pdf->SetCol(0.6);
                        $this->pdf->Cell(17,0,$this->datosdetalle[$i]->rece,0,1,'L');
                        $this->pdf->SetCol(0.8);
                        $this->pdf->Cell(17,0,$this->datosdetalle[$i]->concedeta,0,1,'L');
                        $this->pdf->SetCol(2.0);
                        $this->pdf->Cell(17,0,'',0,1,'R');
                        $this->pdf->SetCol(2.4);
                        $this->pdf->Cell(17,0,number_format($this->datosdetalle[$i]->monto,2,'.',','),0,1,'R');
                        $this->pdf->SetCol(2.7);
                        $this->pdf->Cell(17,0,number_format($totalsaldo,2,'.',','),0,1,'R');
                    //    $renglon=$this->Rowpdf(array(
                    //         date('d-m-Y',strtotime($this->datosdetalle[$i]->fecha)),
                    //         $this->datosdetalle[$i]->tipo_mov.'-'.$this->datosdetalle[$i]->no_banco.'-'.$this->datosdetalle[$i]->no_mov,
                    //         $this->datosdetalle[$i]->rece,
                    //         $this->datosdetalle[$i]->concedeta,
                    //         '',
                    //         '-'.number_format($this->datosdetalle[$i]->monto,2,'.',','),
                    //         number_format($totalsaldo,2,'.',',')
                        
                    //     ));                      
                        $totalabono=$totalabono-$this->datosdetalle[$i]->monto;
                        //$this->pdf->SetY($renglon-3.5);
                        $this->pdf->Ln(5);
                        break;
                    }
                }
                else
                {
                    if($this->datosdetalle[$i]->signo == '+')
                    {
                        
                        $totalsaldo=$totalsaldo+$this->datosdetalle[$i]->monto;
                        $this->pdf->SetCol(0);
                        $this->pdf->Cell(17,0,date('d-m-Y',strtotime($this->datosdetalle[$i]->fecha)),0,1,'C');
                        $this->pdf->SetCol(0.3);
                        $this->pdf->Cell(17,0,$this->datosdetalle[$i]->tipo_mov.'-'.$this->datosdetalle[$i]->no_banco.'-'.$this->datosdetalle[$i]->no_mov,0,1,'');
                        $this->pdf->SetCol(0.6);
                        $this->pdf->Cell(17,0,$this->datosdetalle[$i]->rece,0,1,'L');
                        $this->pdf->SetCol(0.8);
                        $this->pdf->Cell(17,0,$this->datosdetalle[$i]->concedeta,0,1,'L');
                        $this->pdf->SetCol(2.0);
                        $this->pdf->Cell(17,0,number_format($this->datosdetalle[$i]->monto,2,'.',','),0,1,'R');
                        $this->pdf->SetCol(2.4);
                        $this->pdf->Cell(17,0,'',0,1,'R');
                        $this->pdf->SetCol(2.7);
                        $this->pdf->Cell(17,0,number_format($totalsaldo,2,'.',','),0,1,'R');

                        // $renglon=$this->Rowpdf(array(
                        //     date('d-m-Y',strtotime($this->datosdetalle[$i]->fecha)),
                        //     $this->datosdetalle[$i]->tipo_mov.'-'.$this->datosdetalle[$i]->no_banco.'-'.$this->datosdetalle[$i]->no_mov,
                        //     $this->datosdetalle[$i]->rece,
                        //     $this->datosdetalle[$i]->concedeta,
                        //     number_format($this->datosdetalle[$i]->monto,2,'.',','),
                        //     '',
                        //     number_format($totalsaldo,2,'.',',')
                        //  ));             
                         $totalcargo=$totalcargo+$this->datosdetalle[$i]->monto;             
                         //$this->pdf->SetY($renglon-3.5);
                         $this->pdf->Ln(5);
                         break;
                    }
                    else
                    {
                        
                        $totalsaldo=$saldo-$this->datosdetalle[$i]->monto;

                        $this->pdf->SetCol(0);
                        $this->pdf->Cell(17,0,date('d-m-Y',strtotime($this->datosdetalle[$i]->fecha)),0,1,'C');
                        $this->pdf->SetCol(0.3);
                        $this->pdf->Cell(17,0,$this->datosdetalle[$i]->tipo_mov.'-'.$this->datosdetalle[$i]->no_banco.'-'.$this->datosdetalle[$i]->no_mov,0,1,'');
                        $this->pdf->SetCol(0.6);
                        $this->pdf->Cell(17,0,$this->datosdetalle[$i]->rece,0,1,'L');
                        $this->pdf->SetCol(0.8);
                        $this->pdf->Cell(17,0,$this->datosdetalle[$i]->concedeta,0,1,'L');
                        $this->pdf->SetCol(2.0);
                        $this->pdf->Cell(17,0,'',0,1,'R');
                        $this->pdf->SetCol(2.4);
                        $this->pdf->Cell(17,0,number_format($this->datosdetalle[$i]->monto,2,'.',','),0,1,'R');
                        $this->pdf->SetCol(2.7);
                        $this->pdf->Cell(17,0,number_format($totalsaldo,2,'.',','),0,1,'R');
                        // $renglon=$this->Rowpdf(array(
                        //     date('d-m-Y',strtotime($this->datosdetalle[$i]->fecha)),
                        //     $this->datosdetalle[$i]->tipo_mov.'-'.$this->datosdetalle[$i]->no_banco.'-'.$this->datosdetalle[$i]->no_mov,
                        //     $this->datosdetalle[$i]->rece,
                        //     $this->datosdetalle[$i]->concedeta,
                        //     '',
                        //     '-'.number_format($this->datosdetalle[$i]->monto,2,'.',','),
                        //     number_format($totalsaldo,2,'.',',')
                        
                        // ));                        
                        $totalabono=$totalabono-$this->datosdetalle[$i]->monto;
                        //$this->pdf->SetY($renglon-3.5);
                        $this->pdf->Ln(5);
                        break;
                    }
                }
            }while(0);
        }
        $this->pdf->Ln(10);
        $this->pdf->SetCol(0.0);
        $totales = $totalcargo + $totalabono;
        $this->pdf->Cell(120);
        $this->pdf->Cell(10,0,'Totales: '.' + '.number_format($totalcargo,2,'.',','),0,0,'L');
        $this->pdf->Cell(22);
        $this->pdf->Cell(10,0,number_format($totalabono,2,'.',',').' =',0,0,'L');
        $this->pdf->Cell(12);
        $this->pdf->Cell(10,0,number_format($totales,2,'.',','),0,0,'L');
        $this->pdf->Ln(5);
        $this->pdf->Cell(158);
        $this->pdf->Cell(10,0,'Saldo Inicial: '.number_format($saldo,2,'.',','),0,0,'L');
        $this->pdf->Line(170,105,200,105);
        $this->pdf->Ln(6);
        $this->pdf->Cell(173);
        $this->pdf->Cell(10,0,number_format($totales+$saldo,2,'.',','),0,0,'L');

         $this->pdf->footer2();

        $this->pdf->Output('I','ReporteAuxiliarContable.pdf');
    }
    public function Excelexport()
    {

        $objPHPExcel = new PHPExcel();

        $this->rowc = $this->configModel->getConfig();

        $this->cuenta = $this->input->post('cuenta');
        $this->subcun = $this->input->post('subcuenta');
        $this->subcun2 = $this->input->post('subcuenta2');

        $this->fechaini = $this->input->post('fechaini');
        $this->fechafin = $this->input->post('fechafin');

        $this->agrupa = $this->input->post('agrupado');

        $this->saldoini = $this->operaciones->saldoinicial($this->cuenta,$this->subcun,$this->subcun2,$this->fechaini);

        $this->datosdetalle = $this->operaciones->auxiliardetalle($this->cuenta,$this->subcun,$this->subcun2,$this->fechaini,$this->fechafin,$this->agrupa);

        $this->datosbanco = $this->cuentas->verificarreportecuenta($this->cuenta,$this->subcun);

        $saldo = 0;

        for($j=0;$j<count($this->saldoini);$j++)
        {
            $saldo = $saldo + ($this->saldoini[$j]['saldo']);
        }


        header("Content-Type: text/html;charset=utf-8");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="auxliar_contable.xls"');
        header('Cache-Control: max-age=0');

        $objsheet = $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:G2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:G3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:C6');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D6:G6');
        
        $objsheet->setCellValue('A1',$this->rowc[0]['nombreEmpresa']);
        $objsheet->setCellValue('A2','Reporte Auxiliar Contable');
        $objsheet->setCellValue('A3','Corte del: '.date('d-m-Y',strtotime($this->fechaini)).' Al '.date('d-m-Y',strtotime($this->fechafin)));

        $objsheet->setCellValue('A5','Fecha');
        $objsheet->setCellValue('B5','Póliza');
        $objsheet->setCellValue('C5','Referencia');
        $objsheet->setCellValue('D5','Concepto');
        $objsheet->setCellValue('E5','Cargo');
        $objsheet->setCellValue('F5','Abono');
        $objsheet->setCellValue('G5','Saldo');

        $objsheet->setCellValue('A6','Cuenta: '.$this->datosbanco[0]['cuenta'].' - '.$this->datosbanco[0]['sub_cta'].''.$this->datosbanco[0]['nombre']);
        $objsheet->setCellValue('D6','Saldo Inicial: '.number_format($saldo,2,'.',''));

        $totalcargo = 0;
        $totalabono = 0;

        $summon = 0;

        $numero=6;
        $numero2=7;
        $numero3=8;
        $numero4=9;
        for($i=0; $i<count($this->datosdetalle); $i++)
        {
           $numero++;
           $numero2++;
           $numero3++;
           $numero4++;
           do{
             if($this->datosdetalle[0]->signo == '+')
             {
                    if($this->datosdetalle[$i]->signo == '+')
                    {
                          $totalsaldo=$saldo+$this->datosdetalle[$i]->monto;
                            $objsheet->setCellValue('A'.$numero,date('d-m-Y',strtotime($this->datosdetalle[$i]->fecha)));
                            $objsheet->setCellValue('B'.$numero,$this->datosdetalle[$i]->tipo_mov.'-'.$this->datosdetalle[$i]->no_banco.'-'.$this->datosdetalle[$i]->no_mov);
                            $objsheet->setCellValue('C'.$numero,$this->datosdetalle[$i]->rece);
                            $objsheet->setCellValue('D'.$numero,$this->datosdetalle[$i]->concedeta);
                            $objsheet->setCellValue('E'.$numero,number_format($this->datosdetalle[$i]->monto,2,'.',''));
                            $objsheet->setCellValue('F'.$numero,'');
                            $objsheet->setCellValue('G'.$numero,number_format($totalsaldo,2,'.',''));

                            $totalcargo = $totalcargo + $this->datosdetalle[$i]->monto;
                    }
                    else
                    {
                          $totalsaldo=$totalsaldo-$this->datosdetalle[$i]->monto;
                            $objsheet->setCellValue('A'.$numero,date('d-m-Y',strtotime($this->datosdetalle[$i]->fecha)));
                            $objsheet->setCellValue('B'.$numero,$this->datosdetalle[$i]->tipo_mov.'-'.$this->datosdetalle[$i]->no_banco.'-'.$this->datosdetalle[$i]->no_mov);
                            $objsheet->setCellValue('C'.$numero,$this->datosdetalle[$i]->rece);
                            $objsheet->setCellValue('D'.$numero,$this->datosdetalle[$i]->concedeta);
                            $objsheet->setCellValue('E'.$numero,'');
                            $objsheet->setCellValue('F'.$numero,'-'.number_format($this->datosdetalle[$i]->monto,2,'.',''));
                            $objsheet->setCellValue('G'.$numero,number_format($totalsaldo,2,'.',''));

                            $totalabono = $totalabono + $this->datosdetalle[$i]->monto;
                    }
             }
             else
             {
                    if($this->datosdetalle[$i]->signo == '+')
                    {
                          $totalsaldo=$totalsaldo+$this->datosdetalle[$i]->monto;
                            $objsheet->setCellValue('A'.$numero,date('d-m-Y',strtotime($this->datosdetalle[$i]->fecha)));
                            $objsheet->setCellValue('B'.$numero,$this->datosdetalle[$i]->tipo_mov.'-'.$this->datosdetalle[$i]->no_banco.'-'.$this->datosdetalle[$i]->no_mov);
                            $objsheet->setCellValue('C'.$numero,$this->datosdetalle[$i]->rece);
                            $objsheet->setCellValue('D'.$numero,$this->datosdetalle[$i]->concedeta);
                            $objsheet->setCellValue('E'.$numero,number_format($this->datosdetalle[$i]->monto,2,'.',''));
                            $objsheet->setCellValue('F'.$numero,'');
                            $objsheet->setCellValue('G'.$numero,number_format($totalsaldo,2,'.',''));

                            $totalcargo = $totalcargo + $this->datosdetalle[$i]->monto;
                    }
                    else
                    {
                         $totalsaldo=$saldo-$this->datosdetalle[$i]->monto;
                            $objsheet->setCellValue('A'.$numero,date('d-m-Y',strtotime($this->datosdetalle[$i]->fecha)));
                            $objsheet->setCellValue('B'.$numero,$this->datosdetalle[$i]->tipo_mov.'-'.$this->datosdetalle[$i]->no_banco.'-'.$this->datosdetalle[$i]->no_mov);
                            $objsheet->setCellValue('C'.$numero,$this->datosdetalle[$i]->rece);
                            $objsheet->setCellValue('D'.$numero,$this->datosdetalle[$i]->concedeta);
                            $objsheet->setCellValue('E'.$numero,'');
                            $objsheet->setCellValue('F'.$numero,'-'.number_format($this->datosdetalle[$i]->monto,2,'.',''));
                            $objsheet->setCellValue('G'.$numero,number_format($totalsaldo,2,'.',''));

                            $totalabono = $totalabono + $this->datosdetalle[$i]->monto;
                    }
             }
           }while(0);

           $objsheet->setCellValue('D'.$numero2,'Totales: ');
           $objsheet->setCellValue('E'.$numero2,'+ '.number_format($totalcargo,2,'.',''));
           $objsheet->setCellValue('F'.$numero2,'- '.number_format($totalabono,2,'.',''));
           $objsheet->setCellValue('G'.$numero2,'= '.number_format($totalcargo-$totalabono,2,'.',''));
           $objsheet->setCellValue('F'.$numero3,'Saldo Inicial :');
           $objsheet->setCellValue('G'.$numero3,number_format($saldo,2,'.',''));
           $objsheet->setCellValue('G'.$numero4,number_format(($totalcargo-$totalabono) + $saldo,2,'.',''));
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

        $objPHPExcel->getDefaultStyle()->applyFromArray($style);
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