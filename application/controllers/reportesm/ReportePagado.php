<?php

class ReportePagado extends MY_Controller
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
            $data=array('titulo'=>'Reporte pagado','rfc' => $rfc[0]['rfc'],'razon' => $this->validaempresas->get_razon($_SESSION['idEmpresa']),'errores'=>$errores,'permisosGrupo'=>$permisos);
            $items=$this->menuModel->menus($_SESSION['tipo']);
            $this->multi_menu->set_items($items);
            $this->load->view('templates/header');
            $this->load->view('templates/navigation',$data);
            $this->load->view('reportes/reportepagado');
            $this->load->view('templates/footer');
        }
        else
        {
           redirect('inicio/login','refresh');   
        }
   }
   public function Excelexport()
   {
        $objPHPExcel = new PHPExcel();

        $this->rowc = $this->configModel->getConfig();

        $fechaini = $this->input->post('fechaini');
        $fechafin = $this->input->post('fechafin');

        $data = $this->cuentas->getpagado($fechaini,$fechafin);

        header("Content-Type: text/html;charset=utf-8");
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment;filename="pagado.xls"');
        header('Cache-Control: max-age=0');
       

        $objsheet = $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:I2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:I3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:I4');

        $objsheet->setCellValue('A1',$this->rowc[0]['nombreEmpresa']);
        $objsheet->setCellValue('A2','Reporte pagado');
        $objsheet->setCellValue('A3','Del: '.date('d-m-Y',strtotime($fechaini)).' Al: '.date('d-m-Y',strtotime($fechafin)));
       // $objsheet->setCellValue('A4','Tipo de póliza: '.$tipopoliza);

       $objsheet->setCellValue('A5','Referencia');
       $objsheet->setCellValue('B5','Cliente');
       $objsheet->setCellValue('C5','Ventas');
       $objsheet->setCellValue('D5','IVA 8');
       $objsheet->setCellValue('E5','IVA 16');
       $objsheet->setCellValue('F5','RET IVA');
       $objsheet->setCellValue('G5','RET ISR');
       $objsheet->setCellValue('H5','TOTAL');
       $objsheet->setCellValue('I5','PAGO');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

        $numero3=5;
        $numero4=6;

        $totalventas = 0;
        $totaliva8 = 0;
        $totaliva16 = 0;
        $totalretiva = 0;
        $totalretisr = 0;
        $totaltotal = 0;
        $totalpago = 0;

        for($i=0;$i<count($data); $i++)
        {
            $numero3++;
            $numero4++;

                $objsheet->setCellValue('A'.$numero3,$data[$i]->referencia);
                $objsheet->setCellValue('B'.$numero3,$data[$i]->cliente);
                $objsheet->setCellValue('C'.$numero3,number_format($data[$i]->ventas,2,'.',','));
                $objsheet->setCellValue('D'.$numero3,number_format($data[$i]->IVA_8,2,'.',','));
                $objsheet->setCellValue('E'.$numero3,number_format($data[$i]->IVA_16,2,'.',','));
                $objsheet->setCellValue('F'.$numero3,number_format($data[$i]->Ret_IVA,2,'.',','));
                $objsheet->setCellValue('G'.$numero3,number_format($data[$i]->Ret_ISR,2,'.',','));
                $objsheet->setCellValue('H'.$numero3,number_format($data[$i]->Total,2,'.',','));
                $objsheet->setCellValue('I'.$numero3,number_format($data[$i]->Pago,2,'.',','));

                $totalventas += $data[$i]->ventas;
                $totaliva8 += $data[$i]->IVA_8;
                $totaliva16 += $data[$i]->IVA_16;
                $totalretiva += $data[$i]->Ret_IVA;
                $totalretisr += $data[$i]->Ret_ISR;
                $totaltotal += $data[$i]->Total;
                $totalpago += $data[$i]->Pago;
        }

        $objsheet->setCellValue('B'.$numero4,'TOTALES');
        $objsheet->setCellValue('C'.$numero4,number_format($totalventas,2,'.',','));
        $objsheet->setCellValue('D'.$numero4,number_format($totaliva8,2,'.',','));
        $objsheet->setCellValue('E'.$numero4,number_format($totaliva16,2,'.',','));
        $objsheet->setCellValue('F'.$numero4,number_format($totalretiva,2,'.',','));
        $objsheet->setCellValue('G'.$numero4,number_format($totalretisr,2,'.',','));
        $objsheet->setCellValue('H'.$numero4,number_format($totaltotal,2,'.',','));
        $objsheet->setCellValue('I'.$numero4,number_format($totalpago,2,'.',','));

        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $objPHPExcel->getDefaultStyle()->applyFromArray($style);
        $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
   }
}