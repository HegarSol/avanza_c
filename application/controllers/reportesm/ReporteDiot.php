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
        $this->load->model('ConfigCuentasModel','conficue');
        //$this->load->library('Pdf');
        $this->load->library('PHPExcel');
    }
    public function index()
    {
        if($this->aauth->is_loggedin())
        {
            $errores=array();
            $rfc = $this->configModel->getConfig();
            $permisos=$this->permisosForma($_SESSION['id'],1);
            $data=array('titulo'=>'Reporte de DIOT','rfc' => $rfc[0]['rfc'],'razon' => $this->validaempresas->get_razon($_SESSION['idEmpresa']),'errores'=>$errores,'permisosGrupo'=>$permisos);
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
    public function Txtexport()
    {

        $fechaini = $this->input->post('fechaini');
        $fechafin = $this->input->post('fechafin');

        $data = $this->cuentas->getdiot($fechaini,$fechafin);

       $to2 = $this->agrupacuentas($data);
        

        $texto = '';

        $fh = fopen("diot.txt", 'w') or die("Se produjo un error al crear el archivo");
  
        foreach($to2 as $dat)
        {

           $texto .=  ($dat['rfc'] != 'XEXX010101000'?"04|85|".$dat['rfc']."|||":"05|03||".trim($dat['curp'])."|".trim($dat['nombre'])."|".trim($dat['pais']))
           ."||".round($dat['gasto_estim'])."||||".round($dat['gasto_tg'])."||||||".round($dat['iva_estim'])."||||".round($dat['iva_tg'])."||||||||||||||||||||||||||"
           .round($dat['ret_iva'])."|||".($dat['rfc'] != 'XEXX010101000'?round($dat['gasto_coe']):"")
           ."||".($dat['rfc'] != 'XEXX010101000' ? "" : round($dat['gasto_coe']))."|01"."\n";
        }

        fwrite($fh, $texto) or die("No se pudo escribir en el archivo");

        fclose($fh);

        $file_example = "diot.txt";
        if (file_exists($file_example)) {
            header('Content-Description: File Transfer');
            header('Content-Type: text');
            header('Content-Disposition: attachment; filename='."diot.txt");
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_example));
            ob_clean();
            flush();
            readfile($file_example);
            unlink('diot.txt');
            exit;
        }
        else {
            echo 'Archivo no disponible.';
        }
        
    }
    public function Excelexport()
    {
        $objPHPExcel = new PHPExcel();

        $this->rowc = $this->configModel->getConfig();

        $fechaini = $this->input->post('fechaini');
        $fechafin = $this->input->post('fechafin');

        $data = $this->cuentas->getdiot($fechaini,$fechafin);
         $to2 = $this->agrupacuentas($data);

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
       $objsheet->setCellValue('F5','Gasto Cero/Exento');
       $objsheet->setCellValue('G5','IVA TG');
       $objsheet->setCellValue('H5','IVA Estimulo');
       $objsheet->setCellValue('I5','Ret. IVA');
       $objsheet->setCellValue('J5','Ret ISR');
       $objsheet->setCellValue('K5','Ret FL');
       $objsheet->setCellValue('L5','Ret Resico');

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
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);

        $numero3=5;
        $numero4=6;

        $gasto_tgtotal=0;
        $gasto_estimtotal=0;
        $gasto_cero_total=0;
        $iva_tgtotal=0;
        $iva_estimtotal=0;
        $ret_ivatotal=0;
        $ret_isrtotal=0;
        $ret_fltotal=0;
        $isr_resicototal=0;
        
        for($i=0;$i<count($to2); $i++)
        {
            $numero3++;
            $numero4++;

                $objsheet->setCellValue('A'.$numero3,$to2[$i]['no_prov']);
                $objsheet->setCellValue('B'.$numero3,trim($to2[$i]['rfc']));
                $objsheet->setCellValue('C'.$numero3,trim($to2[$i]['nombre']));
                $objsheet->setCellValue('D'.$numero3,number_format($to2[$i]['gasto_tg'],0,'.',','));
                $objsheet->setCellValue('E'.$numero3,number_format($to2[$i]['gasto_estim'],0,'.',','));
                $objsheet->setCellValue('F'.$numero3,number_format($to2[$i]['gasto_coe'],0,'.',','));
                $objsheet->setCellValue('G'.$numero3,number_format($to2[$i]['iva_tg'],0,'.',','));
                $objsheet->setCellValue('H'.$numero3,number_format($to2[$i]['iva_estim'],0,'.',','));
                $objsheet->setCellValue('I'.$numero3,number_format($to2[$i]['ret_iva'],0,'.',','));
                $objsheet->setCellValue('J'.$numero3,number_format($to2[$i]['ret_isr'],0,'.',','));
                $objsheet->setCellValue('K'.$numero3,number_format($to2[$i]['ret_fl'],0,'.',','));
                $objsheet->setCellValue('L'.$numero3,number_format($to2[$i]['isr_resico'],0,'.',','));

                $gasto_tgtotal = $gasto_tgtotal + $to2[$i]['gasto_tg'];
                $objsheet->setCellValue('D'.$numero4,number_format($gasto_tgtotal,0,'.',','));

                $gasto_estimtotal= $gasto_estimtotal+$to2[$i]['gasto_estim'];
                $objsheet->setCellValue('E'.$numero4,number_format($gasto_estimtotal,0,'.',','));
                $gasto_cero_total= $gasto_cero_total+$to2[$i]['gasto_coe'];
                $objsheet->setCellValue('F'.$numero4,number_format($gasto_cero_total,0,'.',','));

                $iva_tgtotal=$iva_tgtotal+$to2[$i]['iva_tg'];
                $objsheet->setCellValue('G'.$numero4,number_format($iva_tgtotal,0,'.',','));

                $iva_estimtotal=$iva_estimtotal+$to2[$i]['iva_estim'];
                $objsheet->setCellValue('H'.$numero4,number_format($iva_estimtotal,0,'.',','));

                $ret_ivatotal=$ret_ivatotal+$to2[$i]['ret_iva'];
                $objsheet->setCellValue('I'.$numero4,number_format($ret_ivatotal,0,'.',','));

                $ret_isrtotal=$ret_isrtotal+$to2[$i]['ret_isr'];
                $objsheet->setCellValue('J'.$numero4,number_format($ret_isrtotal,0,'.',','));

                $ret_fltotal=$ret_fltotal+$to2[$i]['ret_fl'];
                $objsheet->setCellValue('K'.$numero4,number_format($ret_fltotal,0,'.',','));

                $isr_resicototal=$isr_resicototal+$to2[$i]['isr_resico'];
                $objsheet->setCellValue('L'.$numero4,number_format($isr_resicototal,0,'.',','));
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
    public function agrupacuentas($datos)
    {
        $todistras = array();
        $ctaIva = $this->conficue->getidcuentaconfi(6); // IVA TRASLADADO
          $ctaIvae = $this->conficue->getidcuentaconfi(37); // IVA ESTIMULO
          $ctaRetIva = $this->conficue->getidcuentaconfi(30); // RET IVA
            $ctaRetIsr = $this->conficue->getidcuentaconfi(31); // RET ISR
            $ctaRetFl = $this->conficue->getidcuentaconfi(41); // RET FL
            $ctaIsrResico = $this->conficue->getidcuentaconfi(52); // ISR RESICO
        $i = 0;
        $flag = 0;
        foreach ($datos as $key => $value) {
          if($flag == 0) {
            $no_prov = $value->no_prov;
            $nombre = $value->nombre;
            $rfc = $value->rfc;
            $curp = $value->curp;
            $pais = $value->pais;
            $IVA_TG = 0;
            $IVA_ESTIM = 0;
            $RET_IVA = 0;
            $RET_ISR = 0;
            $RET_FL = 0;
            $ISR_RESICO = 0;
            $gasto = 0;
            $devo = 0;
            $gasto_estim = 0;
            $gasto_tg = 0;
            $gasto_coe = 0;
            $flag = 1;
          }
          
          
         switch(true){
            case ($value->cuenta == $ctaIva[0]['cuenta'] && $value->sub_cta == $ctaIva[0]['sub_cta'] && $value->ssub_cta == $ctaIva[0]['ssub_cta']):
                $IVA_TG = $IVA_TG + $value->cargos - $value->descuentos;
                break;
            case ($value->cuenta == $ctaIvae[0]['cuenta'] && $value->sub_cta == $ctaIvae[0]['sub_cta'] && $value->ssub_cta == $ctaIvae[0]['ssub_cta']):
                $IVA_ESTIM = $IVA_ESTIM + $value->cargos - $value->descuentos;
                break;
            case ($value->cuenta == $ctaRetIva[0]['cuenta'] && $value->sub_cta == $ctaRetIva[0]['sub_cta'] && $value->ssub_cta == $ctaRetIva[0]['ssub_cta']):
                $RET_IVA = $RET_IVA - $value->cargos + $value->descuentos;
                break;
            case ($value->cuenta == $ctaRetIsr[0]['cuenta'] && $value->sub_cta == $ctaRetIsr[0]['sub_cta'] && $value->ssub_cta == $ctaRetIsr[0]['ssub_cta']):
                $RET_ISR = $RET_ISR - $value->cargos + $value->descuentos;
                break;
            case ($value->cuenta == $ctaRetFl[0]['cuenta'] && $value->sub_cta == $ctaRetFl[0]['sub_cta'] && $value->ssub_cta == $ctaRetFl[0]['ssub_cta']):
                $RET_FL = $RET_FL - $value->cargos + $value->descuentos;
                break;
            case ($value->cuenta == $ctaIsrResico[0]['cuenta'] && $value->sub_cta == $ctaIsrResico[0]['sub_cta'] && $value->ssub_cta == $ctaIsrResico[0]['ssub_cta']):
                $ISR_RESICO = $ISR_RESICO - $value->cargos + $value->descuentos;
                break;
            case (isset($value->tipo)):
                $gasto = $gasto + $value->cargos;
                $devo = $devo + $value->descuentos;
                break;
            }
                 $nextvalue = isset($datos[$i+1]) ? $datos[$i+1] : null;
                 $valorprov = isset($nextvalue->no_prov) ? $nextvalue->no_prov : '';
                 if($no_prov != $valorprov){
                    switch(true){
                        case ($IVA_TG > 0):
                            $gasto_tg = $gasto_tg + $gasto;
                            break;
                        case ($IVA_ESTIM > 0):
                            $gasto_estim = $gasto_estim + $gasto;
                            break;
                    }
                    if($gasto_tg+ $gasto_estim != $gasto){
                        $gasto_coe = $gasto_coe + ($gasto-$gasto_tg - $gasto_estim);
                    }

                    $todistras[] = array(
                        'no_prov' => $no_prov,
                        'nombre' => $nombre,
                        'rfc' => $rfc,
                        'curp' => $curp,
                        'pais' => $pais,
                        'gasto_tg' => $gasto_tg,
                        'gasto_estim' => $gasto_estim,
                        'gasto_coe' => $gasto_coe,
                        'iva_tg' => $IVA_TG,
                        'iva_estim' => $IVA_ESTIM,
                        'ret_iva' => $RET_IVA,
                        'ret_isr' => $RET_ISR,
                        'ret_fl' => $RET_FL,
                        'isr_resico' => $ISR_RESICO
                    );
                    $IVA_TG = 0;
                    $IVA_ESTIM = 0;
                    $RET_IVA = 0;
                    $RET_ISR = 0;
                    $RET_FL = 0;
                    $ISR_RESICO = 0;
                    $gasto = 0;
                    $devo = 0;
                    $gasto_estim = 0;
                    $gasto_tg = 0;
                    $flag = 0;
                 } 
                   $i++;

         
        }

        return $todistras;
    }
}