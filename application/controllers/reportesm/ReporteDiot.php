<?php

class ReporteDiot extends MY_Controller
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
            $data=array('titulo'=>'Reporte de Diot','rfc' => $rfc[0]['rfc'],'razon' => $this->validaempresas->get_razon($_SESSION['idEmpresa']),'errores'=>$errores,'permisosGrupo'=>$permisos);
            $items=$this->menuModel->menus($_SESSION['tipo']);
            $this->multi_menu->set_items($items);
            $this->load->view('templates/header');
            $this->load->view('templates/navigation',$data);
            $this->load->view('reportes/reportediot');
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

        $data = $this->cuentas->getdiot($fechaini,$fechafin);

        header("Content-Type: text/html;charset=utf-8");
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment;filename="diot.xls"');
        header('Cache-Control: max-age=0');
       

        $objsheet = $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:K1');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:K2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:K3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:K4');

        $objsheet->setCellValue('A1',$this->rowc[0]['nombreEmpresa']);
        $objsheet->setCellValue('A2','Reporte de Diot');
        $objsheet->setCellValue('A3','Del: '.date('d-m-Y',strtotime($fechaini)).' Al: '.date('d-m-Y',strtotime($fechafin)));
       // $objsheet->setCellValue('A4','Tipo de póliza: '.$tipopoliza);

       $objsheet->setCellValue('A5','No prov');
       $objsheet->setCellValue('B5','RFC');
       $objsheet->setCellValue('C5','Nombre');
       $objsheet->setCellValue('D5','Gasto TG');
       $objsheet->setCellValue('E5','Gasto Estimulo');
       $objsheet->setCellValue('F5','IVA TG');
       $objsheet->setCellValue('G5','IVA Estimulo');
       $objsheet->setCellValue('H5','Ret. IVA');
       $objsheet->setCellValue('I5','Ret ISR');
       $objsheet->setCellValue('J5','Ret FL');
       $objsheet->setCellValue('K5','Ret Resico');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);

        $numero3=5;
        $numero4=6;

        $gasto_tgtotal=0;
        $gasto_estimtotal=0;
        $iva_tgtotal=0;
        $iva_estimtotal=0;
        $ret_ivatotal=0;
        $ret_isrtotal=0;
        $ret_fltotal=0;
        $isr_resicototal=0;

        for($i=0;$i<count($data); $i++)
        {
            $numero3++;
            $numero4++;

                $objsheet->setCellValue('A'.$numero3,$data[$i]->no_prov);
                $objsheet->setCellValue('B'.$numero3,$data[$i]->rfc);
                $objsheet->setCellValue('C'.$numero3,$data[$i]->nombre);
                $objsheet->setCellValue('D'.$numero3,number_format($data[$i]->gasto_tg,2,'.',','));
                $objsheet->setCellValue('E'.$numero3,number_format($data[$i]->gasto_estim,2,'.',','));
                $objsheet->setCellValue('F'.$numero3,number_format($data[$i]->iva_tg,2,'.',','));
                $objsheet->setCellValue('G'.$numero3,number_format($data[$i]->iva_estim,2,'.',','));
                $objsheet->setCellValue('H'.$numero3,number_format($data[$i]->ret_iva,2,'.',','));
                $objsheet->setCellValue('I'.$numero3,number_format($data[$i]->ret_isr,2,'.',','));
                $objsheet->setCellValue('J'.$numero3,number_format($data[$i]->ret_fl,2,'.',','));
                $objsheet->setCellValue('K'.$numero3,number_format($data[$i]->isr_resico,2,'.',','));

                $gasto_tgtotal = $gasto_tgtotal + $data[$i]->gasto_tg;
                $objsheet->setCellValue('D'.$numero4,number_format($gasto_tgtotal,2,'.',','));

                $gasto_estimtotal= $gasto_estimtotal+$data[$i]->gasto_estim;
                $objsheet->setCellValue('E'.$numero4,number_format($gasto_estimtotal,2,'.',','));

                $iva_tgtotal=$iva_tgtotal+$data[$i]->iva_tg;
                $objsheet->setCellValue('F'.$numero4,number_format($iva_tgtotal,2,'.',','));

                $iva_estimtotal=$iva_estimtotal+$data[$i]->iva_estim;
                $objsheet->setCellValue('G'.$numero4,number_format($iva_estimtotal,2,'.',','));

                $ret_ivatotal=$ret_ivatotal+$data[$i]->ret_iva;
                $objsheet->setCellValue('H'.$numero4,number_format($ret_ivatotal,2,'.',','));

                $ret_isrtotal=$ret_isrtotal+$data[$i]->ret_isr;
                $objsheet->setCellValue('I'.$numero4,number_format($ret_isrtotal,2,'.',','));

                $ret_fltotal=$ret_fltotal+$data[$i]->ret_fl;
                $objsheet->setCellValue('J'.$numero4,number_format($ret_fltotal,2,'.',','));

                $isr_resicototal=$isr_resicototal+$data[$i]->isr_resico;
                $objsheet->setCellValue('K'.$numero4,number_format($isr_resicototal,2,'.',','));
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
}