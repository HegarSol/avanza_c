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
           $data=array('titulo'=>'Reporte libro electrónico','rfc'=>$rfc[0]['rfc'],'razon'=>$this->validaempresas->get_razon($_SESSION['idEmpresa']),'errores'=>$errores,'permisosGrupo'=>$permisos);
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
        $this->pdf->SetTitle(utf8_decode('Reporte Libro Electrónico'));
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

        for($i=0;$i<count($this->datos);$i++)
        {
              if($anterior == $this->datos[$i]['tipo_mov'].'-'.$this->datos[$i]['no_banco'].'-'.$this->datos[$i]['no_mov'])
              {
                    if($this->datos[$i]['c_a'] == '+')
                    {
                        $renglon = $this->Rowpdf(array(
                            $this->datos[$i]['tipo_mov'].'-'.$this->datos[$i]['no_banco'].'-'.$this->datos[$i]['no_mov'],
                            date('d-m-Y',strtotime($this->datos[$i]['fecha'])),
                            utf8_decode($this->datos[$i]['beneficia']),
                            $this->datos[$i]['cuenta'].' - '.$this->datos[$i]['sub_cta'],
                            utf8_decode($this->datos[$i]['nombre_cuenta']),
                            number_format($this->datos[$i]['monto'],2,'.',','),
                            ''
                        ));
                        $this->pdf->SetY($renglon-3.5);
                        $this->pdf->Ln(4);
                    }
                    else
                    {
                        $renglon = $this->Rowpdf(array(
                            $this->datos[$i]['tipo_mov'].'-'.$this->datos[$i]['no_banco'].'-'.$this->datos[$i]['no_mov'],
                            date('d-m-Y',strtotime($this->datos[$i]['fecha'])),
                            utf8_decode($this->datos[$i]['beneficia']),
                            $this->datos[$i]['cuenta'].' - '.$this->datos[$i]['sub_cta'],
                            utf8_decode($this->datos[$i]['nombre_cuenta']),
                            '',
                            number_format($this->datos[$i]['monto'],2,'.',',')
                        ));
                        $this->pdf->SetY($renglon-3.5);
                        $this->pdf->Ln(4);
                    }
              }
              else
              {
                $this->pdf->Ln(5);
                $y =$this->pdf->GetY();
                $this->pdf->Line(5,$y+3,212,$y+3);

              }           

            $anterior = $this->datos[$i]['tipo_mov'].'-'.$this->datos[$i]['no_banco'].'-'.$this->datos[$i]['no_mov'];
        }

        
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
        $objsheet->setCellValue('A2','Reporte Libro Electrónico');
        $objsheet->setCellValue('A3','Del: '.date('d-m-Y',strtotime($fechaini)).' Al: '.date('d-m-Y',strtotime($fechaini)));
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

        $numero3=5;

        for($i=0;$i<count($this->datos); $i++)
        {
            $numero3++;

            if($this->datos[$i]['c_a'] == '+')
            {
                $objsheet->setCellValue('A'.$numero3,$this->datos[$i]['tipo_mov'].'-'.$this->datos[$i]['no_banco'].'-'.$this->datos[$i]['no_mov']);
                $objsheet->setCellValue('B'.$numero3,date('d-m-Y',strtotime($this->datos[$i]['fecha'])));
                $objsheet->setCellValue('C'.$numero3,$this->datos[$i]['beneficia']);
                $objsheet->setCellValue('D'.$numero3,$this->datos[$i]['cuenta'].' - '.$this->datos[$i]['sub_cta']);
                $objsheet->setCellValue('E'.$numero3,$this->datos[$i]['nombre_cuenta']);
                $objsheet->setCellValue('F'.$numero3,number_format($this->datos[$i]['monto'],2,'.',''));
                $objsheet->setCellValue('G'.$numero3,'');
            }
            else
            {
                $objsheet->setCellValue('A'.$numero3,$this->datos[$i]['tipo_mov'].'-'.$this->datos[$i]['no_banco'].'-'.$this->datos[$i]['no_mov']);
                $objsheet->setCellValue('B'.$numero3,date('d-m-Y',strtotime($this->datos[$i]['fecha'])));
                $objsheet->setCellValue('C'.$numero3,$this->datos[$i]['beneficia']);
                $objsheet->setCellValue('D'.$numero3,$this->datos[$i]['cuenta'].' - '.$this->datos[$i]['sub_cta']);
                $objsheet->setCellValue('E'.$numero3,$this->datos[$i]['nombre_cuenta']);
                $objsheet->setCellValue('F'.$numero3,'');
                $objsheet->setCellValue('G'.$numero3,number_format($this->datos[$i]['monto'],2,'.',''));
            }

        }

        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $objPHPExcel->getDefaultStyle()->applyFromArray($style);
        $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
    }
    public function encabezado($fechaini,$fechafin,$tipo)
    {
        date_default_timezone_set("America/Mexico_City");
        $img = $this->rowc[0]['imgName'];
        $formato = explode(".",$this->rowc[0]['imgName']);
        $imagen = $this->rowc[0]['img'];
        if(isset($imagen)){$this->pdf->Image("data:image/$formato[1];base64,$imagen");}
        $this->pdf->SetFont('Helvetica','B',15);
        $this->pdf->Cell(70);
        $this->pdf->Cell(10,0,$this->rowc[0]['nombreEmpresa'],0,0,'L');
        $this->pdf->Ln(20);
        $this->pdf->Cell(70);
        $this->pdf->SetFont('Helvetica','B',10);
        $this->pdf->Cell(10,0,utf8_decode('Reporte: Libro Electrónico'));
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