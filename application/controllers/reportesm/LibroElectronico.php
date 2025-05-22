<?php

class LibroElectronico extends MY_Controller
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
           $data=array('titulo'=>'Reporte libro diario','rfc'=>$rfc[0]['rfc'],'razon'=>$this->validaempresas->get_razon($_SESSION['idEmpresa']),'errores'=>$errores,'permisosGrupo'=>$permisos);
           $items=$this->menuModel->menus($_SESSION['tipo']);
           $this->multi_menu->set_items($items);
           $this->load->view('templates/header');
           $this->load->view('templates/navigation',$data);
           $this->load->view('reportes/reportelibroelectronico');
           $this->load->view('templates/footer');
        }
        else
        {
            redirect('inicio/login','refresh');
        }
    }
    public function libro()
    {
        date_default_timezone_set("America/Mexico_City");
        setlocale(LC_TIME,"spanish");

        $tipo = $this->input->post('tipopo');
        $fechaini = $this->input->post('fechaini');
        $fechafin = $this->input->post('fechafin');

        $datos = $this->operaciones->libro($tipo,$fechaini,$fechafin);

        $data['libro'] = $datos;

        $this->load->view('reportes/libro/table_libro',$data);
    }
    public function imprimir()
    {
        date_default_timezone_set("America/Mexico_City");
        setlocale(LC_TIME,"spanish");

        $tipopoliza = $this->input->post('tipopoliza');
        $fechaini = $this->input->post('fechaini');
        $fechafin = $this->input->post('fechafin');

        $this->rowc = $this->configModel->getConfig();

        $this->datos = $this->operaciones->libro($tipopoliza,$fechaini,$fechafin);

        $this->pdf->SetAutoPageBreak(true,10);
        $this->pdf->AddPage();
        $this->pdf->SetTitle(utf8_decode('Reporte libro diario'));
        $this->pdf->SetFillColor(220,220,220);
        $this->pdf->SetDrawColor(220,220,220);

        $this->encabezado($fechaini,$fechafin,$tipopoliza);



        $this->pdf->SetFont('Helvetica','B',9);
        $this->pdf->Ln(15);
        $this->pdf->Cell(30,5,utf8_decode('Póliza'),0,1,'',true);
        $this->pdf->SetY(55);
        $this->pdf->SetCol(0.4);
        $this->pdf->Cell(20,5,'Fecha',0,1,'',true);
        $this->pdf->SetY(55);
        $this->pdf->SetCol(0.7);
        $this->pdf->Cell(70,5,'Beneficiario y concepto',0,1,'',true);
        $this->pdf->SetY(55);
        $this->pdf->SetCol(1.4);
        $this->pdf->Cell(30,5,'Cuenta',0,1,'',true);
        $this->pdf->SetY(55);
        $this->pdf->SetCol(1.8);
        $this->pdf->Cell(35,5,'Nombre',0,1,'',true);
        $this->pdf->SetY(55);
        $this->pdf->SetCol(2.3);
        $this->pdf->Cell(30,5,'Cargo',0,1,'',true);
        $this->pdf->SetY(55);
        $this->pdf->SetCol(2.7);
        $this->pdf->Cell(20,5,'Abono',0,1,'',true);
        $this->pdf->SetCol(0);
        $this->pdf->Ln(5);
        $this->pdf->SetWidths(array(12,30,50,20,30,27,25));
        $this->pdf->SetFont('Helvetica','',8);


        $anterior = null;
        $str = count($this->datos);
        $i = 0;
        
        while($i < $str-1)
        {
            $valors = $this->datos[$i]['tipo_mov'].'-'.$this->datos[$i]['no_banco'].'-'.$this->datos[$i]['no_mov'];

            $vf = $this->datos[$i];

             $renglon = $this->Rowpdf(array(
                            $vf['tipo_mov'].'-'.$vf['no_banco'].'-'.$vf['no_mov'],
                            date('d-m-Y',strtotime($vf['fecha'])),
                            utf8_decode($vf['beneficia'].' - '. $vf['concepto']),
             ));
              $this->pdf->SetY($renglon-3.5);
              $this->pdf->Ln(4);


            $totalcargo = 0;
            $totalabono = 0;
            while($valors == $this->datos[$i]['tipo_mov'].'-'.$this->datos[$i]['no_banco'].'-'.$this->datos[$i]['no_mov'] AND $i < $str-1)
            {
                $vf = $this->datos[$i];
                    $this->pdf->SetX(30);
                    if($vf['c_a'] == '+')
                    {

                         $this->pdf->Cell(15,5,$vf['cuenta'].'-'.$vf['sub_cta'].'-'.$vf['ssub_cta'],0,0,'',false);
                         $this->pdf->Cell(90,5,utf8_decode($vf['nombre_cuenta']),0,0,'',false);
                         $this->pdf->Cell(10,5,utf8_decode($vf['referencia']),0,0,'L',false);
                         $this->pdf->Cell(28,5,number_format($vf['monto'],2,'.',','),0,0,'R',false);
                         $this->pdf->Cell(120,5,'',0,0,'',false);

                         $this->pdf->Ln(4);

                         $totalcargo = $totalcargo + $vf['monto'];
                    }
                    else
                    {
                         $this->pdf->Cell(15,5,$vf['cuenta'].'-'.$vf['sub_cta'].'-'.$vf['ssub_cta'],0,0,'',false);
                         $this->pdf->Cell(90,5,utf8_decode($vf['nombre_cuenta']),0,0,'',false);
                         $this->pdf->Cell(10,5,utf8_decode($vf['referencia']),0,0,'L',false);
                         $this->pdf->Cell(28,5,'',0,0,'',false);
                         $this->pdf->Cell(25,5,number_format($vf['monto'],2,'.',','),0,0,'R',false);

                         $this->pdf->Ln(4);

                         $totalabono = $totalabono + $vf['monto'];
                    }
                

                $i = $i + 1;

              
            }
             $this->pdf->Ln(6);
                      $this->pdf->SetCol(0);
                      $this->pdf->Cell(140,0);
                      $this->pdf->Cell(10,-7,'____________________________________');
                      $this->pdf->SetCol(0);
                      $this->pdf->Cell(162,0,number_format($totalcargo,2,'.',','),0,0,'R');
                      $this->pdf->Cell(25,0,number_format($totalabono,2,'.',','),0,0,'R');
                      $this->pdf->Ln(6);


                      
        }

        // for($i=0;$i<count($this->datos);$i++)
        // {
        //     $anterior = $this->datos[$i]['tipo_mov'].'-'.$this->datos[$i]['no_banco'].'-'.$this->datos[$i]['no_mov'];
        //       if($anterior == $this->datos[$i]['tipo_mov'].'-'.$this->datos[$i]['no_banco'].'-'.$this->datos[$i]['no_mov'])
        //       {
        //             if($this->datos[$i]['c_a'] == '+')
        //             {
        //                 $renglon = $this->Rowpdf(array(
        //                     $this->datos[$i]['tipo_mov'].'-'.$this->datos[$i]['no_banco'].'-'.$this->datos[$i]['no_mov'],
        //                     date('d-m-Y',strtotime($this->datos[$i]['fecha'])),
        //                     utf8_decode($this->datos[$i]['beneficia']),
        //                     $this->datos[$i]['cuenta'].' - '.$this->datos[$i]['sub_cta'].' - '.$this->datos[$i]['ssub_cta'],
        //                     utf8_decode($this->datos[$i]['nombre_cuenta']),
        //                     number_format($this->datos[$i]['monto'],2,'.',','),
        //                     ''
        //                 ));
        //                 $this->pdf->SetY($renglon-3.5);
        //                 $this->pdf->Ln(4);
        //             }
        //             else
        //             {
        //                 $renglon = $this->Rowpdf(array(
        //                     $this->datos[$i]['tipo_mov'].'-'.$this->datos[$i]['no_banco'].'-'.$this->datos[$i]['no_mov'],
        //                     date('d-m-Y',strtotime($this->datos[$i]['fecha'])),
        //                     utf8_decode($this->datos[$i]['beneficia']),
        //                     $this->datos[$i]['cuenta'].' - '.$this->datos[$i]['sub_cta'].' - '.$this->datos[$i]['ssub_cta'],
        //                     utf8_decode($this->datos[$i]['nombre_cuenta']),
        //                     '',
        //                     number_format($this->datos[$i]['monto'],2,'.',',')
        //                 ));
        //                 $this->pdf->SetY($renglon-3.5);
        //                 $this->pdf->Ln(4);
        //             }
        //       }
        //       else
        //       {

        //         $this->pdf->Ln(5);
        //         $y =$this->pdf->GetY();
        //         $this->pdf->Line(5,$y+3,212,$y+3);

        //       }           


        //     $anterior = $this->datos[$i]['tipo_mov'].'-'.$this->datos[$i]['no_banco'].'-'.$this->datos[$i]['no_mov'];
        // }

        
        $this->pdf->footer2();
        $this->pdf->Output('I','ReporteBalanzaComprobacion.pdf');
    }
    public function Excelexport()
    {
        $objPHPExcel = new PHPExcel();

        $this->rowc = $this->configModel->getConfig();

        $tipopoliza = $this->input->post('tipopoliza');
        $fechaini = $this->input->post('fechaini');
        $fechafin = $this->input->post('fechafin');

        $this->datos = $this->operaciones->libro($tipopoliza,$fechaini,$fechafin);

        header("Content-Type: text/html;charset=utf-8");
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment;filename="libro.xls"');
        header('Cache-Control: max-age=0');

        $objsheet = $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:G2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:G3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:G4');

        $objsheet->setCellValue('A1',$this->rowc[0]['nombreEmpresa']);
        $objsheet->setCellValue('A2','Reporte libro diario');
        $objsheet->setCellValue('A3','Del: '.date('d-m-Y',strtotime($fechaini)).' Al: '.date('d-m-Y',strtotime($fechafin)));
        $objsheet->setCellValue('A4','Tipo de póliza: '.$tipopoliza);

        $objsheet->setCellValue('A5','Póliza');
        $objsheet->setCellValue('B5','Fecha');
        $objsheet->setCellValue('C5','Beneficiario  concepto');
        $objsheet->setCellValue('D5','Cuenta');
        $objsheet->setCellValue('E5','Nombre');
        $objsheet->setCellValue('F5','Cargo');
        $objsheet->setCellValue('G5','Abono');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

        $numero3=7;
        $numero4=12;

        $str = count($this->datos);
        $i = 0;

        $styleArray = array(
            'borders' => array(
              'bottom' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              )
            )
          );

        // $totalcargo = 0;
        // $totalabono = 0;

        while($i < $str-1)
        {
            $valors = $this->datos[$i]['tipo_mov'].'-'.$this->datos[$i]['no_banco'].'-'.$this->datos[$i]['no_mov'];

            $vf = $this->datos[$i];
            $numero3++;
            $objsheet->setCellValue('A'.$numero3,$vf['tipo_mov'].'-'.$vf['no_banco'].'-'.$vf['no_mov']);
            $objsheet->setCellValue('B'.$numero3,date('d-m-Y',strtotime($vf['fecha'])));
            $objsheet->setCellValue('C'.$numero3,$vf['beneficia'].' - '. $vf['concepto']);

            $totalcargo = 0;
            $totalabono = 0;

            while($valors == $this->datos[$i]['tipo_mov'].'-'.$this->datos[$i]['no_banco'].'-'.$this->datos[$i]['no_mov'] AND $i < $str-1)
            {
                $vf = $this->datos[$i];

                  $numero3++;
                  $numero4++;

                if($vf['c_a'] == '+')
                {
                    $objsheet->setCellValue('D'.$numero3,$vf['cuenta'].'-'.$vf['sub_cta'].'-'.$vf['ssub_cta']);
                    $objsheet->setCellValue('E'.$numero3,$vf['nombre_cuenta']);
                    $objsheet->setCellValue('F'.$numero3,number_format($vf['monto'],2,'.',','));
                    $objsheet->setCellValue('G'.$numero3,'');

                    $totalcargo = $totalcargo + $vf['monto'];
                }
                else
                {
                    $objsheet->setCellValue('D'.$numero3,$vf['cuenta'].'-'.$vf['sub_cta'].'-'.$vf['ssub_cta']);
                    $objsheet->setCellValue('E'.$numero3,$vf['nombre_cuenta']);
                    $objsheet->setCellValue('F'.$numero3,'');
                    $objsheet->setCellValue('G'.$numero3,number_format($vf['monto'],2,'.',','));

                    $totalabono = $totalabono + $vf['monto'];
                }

                $i = $i + 1;
                
            }
                $objPHPExcel->getActiveSheet()->getStyle('A'.$numero3.':G'.$numero3)->applyFromArray($styleArray);
                $numero3++;

                $objsheet->setCellValue('F'.$numero3,number_format($totalcargo,2,'.',','));
                $objsheet->setCellValue('G'.$numero3,number_format($totalabono,2,'.',','));

                $objPHPExcel->getActiveSheet()->getStyle('F'.$numero3.':G'.$numero3)->applyFromArray($styleArray);

        }

                // echo '<pre>';
                // print_r($this->datos[$i]);
                // echo '</pre>';

                // echo '<pre>';
                // print_r($valors);
                // echo '</pre

        // for($i=0;$i<count($this->datos); $i++)
        // {
        //     $numero3++;
        //     $numero4++;

        //     if($this->datos[$i]['c_a'] == '+')
        //     {
        //         $objsheet->setCellValue('A'.$numero3,$this->datos[$i]['tipo_mov'].'-'.$this->datos[$i]['no_banco'].'-'.$this->datos[$i]['no_mov']);
        //         $objsheet->setCellValue('B'.$numero3,date('d-m-Y',strtotime($this->datos[$i]['fecha'])));
        //         $objsheet->setCellValue('C'.$numero3,$this->datos[$i]['beneficia']);
        //         $objsheet->setCellValue('D'.$numero3,$this->datos[$i]['cuenta'].' - '.$this->datos[$i]['sub_cta']);
        //         $objsheet->setCellValue('E'.$numero3,$this->datos[$i]['nombre_cuenta']);
        //         $objsheet->setCellValue('F'.$numero3,number_format($this->datos[$i]['monto'],2,'.',','));
        //         $objsheet->setCellValue('G'.$numero3,'');

        //         $totalcargo += $this->datos[$i]['monto'];
        //     }
        //     else
        //     {
        //         $objsheet->setCellValue('A'.$numero3,$this->datos[$i]['tipo_mov'].'-'.$this->datos[$i]['no_banco'].'-'.$this->datos[$i]['no_mov']);
        //         $objsheet->setCellValue('B'.$numero3,date('d-m-Y',strtotime($this->datos[$i]['fecha'])));
        //         $objsheet->setCellValue('C'.$numero3,$this->datos[$i]['beneficia']);
        //         $objsheet->setCellValue('D'.$numero3,$this->datos[$i]['cuenta'].' - '.$this->datos[$i]['sub_cta']);
        //         $objsheet->setCellValue('E'.$numero3,$this->datos[$i]['nombre_cuenta']);
        //         $objsheet->setCellValue('F'.$numero3,'');
        //         $objsheet->setCellValue('G'.$numero3,number_format($this->datos[$i]['monto'],2,'.',','));

        //         $totalabono += $this->datos[$i]['monto'];
        //     }

        // }

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
        $objPHPExcel->getActiveSheet()->getStyle('D1:D'.$lastrow)->applyFromArray($styleleft);
        $objPHPExcel->getActiveSheet()->getStyle('E1:E'.$lastrow)->applyFromArray($styleleft);
        $objPHPExcel->getActiveSheet()->getStyle('F1:F'.$lastrow)->applyFromArray($styleright);
        $objPHPExcel->getActiveSheet()->getStyle('G1:G'.$lastrow)->applyFromArray($styleright);
       

        // $style = array(
        //     'alignment' => array(
        //         'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        //     )
        // );

        // $objPHPExcel->getDefaultStyle()->applyFromArray($style);

        $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
    }
    public function encabezado($fechaini,$fechafin,$tipo)
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
          $this->pdf->Image(APPPATH . 'public'.DIRECTORY_SEPARATOR.'Logo_' . $this->rowc[0]['rfc'] .'.'.$formato[1],2,2,70,50);
        }
        $this->pdf->SetFont('Helvetica','B',15);
        $this->pdf->Cell(70);
        $this->pdf->Cell(10,0,$this->rowc[0]['nombreEmpresa'],0,0,'L');
        $this->pdf->Ln(20);
        $this->pdf->Cell(70);
        $this->pdf->SetFont('Helvetica','B',10);
        $this->pdf->Cell(10,0,utf8_decode('Reporte libro diario'));
        $this->pdf->Ln(5);
        $this->pdf->Cell(70);
        $this->pdf->Cell(10,0,'Del: '.date('d-m-Y',strtotime($fechaini)).' Al :'.date('d-m-Y',strtotime($fechafin)));
        $this->pdf->Ln(5);
        $this->pdf->Cell(70);
        $this->pdf->Cell(10,0,utf8_decode('Tipo de póliza: '.$tipo));
        $this->pdf->SetFont('Helvetica','B',10);

        $this->pdf->Line(200,70,200,70);
        
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