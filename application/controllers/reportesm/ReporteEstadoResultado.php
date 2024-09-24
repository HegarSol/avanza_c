<?php

class ReporteEstadoResultado extends MY_Controller
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
            $data=array('titulo'=>'Reporte estado de resultado','rfc' => $rfc[0]['rfc'],'razon' => $this->validaempresas->get_razon($_SESSION['idEmpresa']),'errores'=>$errores,'permisosGrupo'=>$permisos);
            $items=$this->menuModel->menus($_SESSION['tipo']);
            $this->multi_menu->set_items($items);
            $this->load->view('templates/header');
            $this->load->view('templates/navigation',$data);
            $this->load->view('reportes/reportestadoresultado');
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

        $mese = $this->input->post('mese');
        $anol = $this->input->post('anol');

        $tf0 = $anol.'-01-01';

        $tfi = date($anol.'-'.$mese.'-01');

        $L = new DateTime( $tfi ); 
        $tff = $L->format( 'Y-m-t' );

        //$tff = date($anol.'-'.$mese.'-t');

        switch($mese)
        {
            case '01':
                $meseletra = 'Enero';
                break;
            case '02':
                $meseletra = 'Febrero';
                break;
            case '03':
                $meseletra = 'Marzo';
                break;
            case '04':
                $meseletra = 'Abril';
                break;
            case '05':
                $meseletra = 'Mayo';
                break;
            case '06':
                $meseletra = 'Junio';
                break;
            case '07':
                $meseletra = 'Julio';
                break;
            case '08':
                $meseletra = 'Agosto';
                break;
            case '09':
                $meseletra = 'Septiembre';
                break;
            case '10':
                $meseletra = 'Octubre';
                break;
            case '11':
                $meseletra = 'Noviembre';
                break;
            case '12':
                $meseletra = 'Diciembre';
                break;
        }

        $data = $this->cuentas->getestadoresultado($tf0,$tfi,$tff);

        header("Content-Type: text/html;charset=utf-8");
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment;filename="estadoresultado.xls"');
        header('Cache-Control: max-age=0');
       

        $objsheet = $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:I2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:I3');

        $objsheet->setCellValue('A1',$this->rowc[0]['nombreEmpresa']);
        $objsheet->setCellValue('A2','Reporte estado de resultado');
        $objsheet->setCellValue('A3','Periodo: '.$meseletra.' - Ejercicio: '.$anol);


        $objsheet->setCellValue('A5','Cuenta');
        $objsheet->setCellValue('B5','Subcuenta');
        $objsheet->setCellValue('C5','Nombre');
        $objsheet->setCellValue('D5','Inicial');
        $objsheet->setCellValue('E5','');
        $objsheet->setCellValue('F5','Debe');
        $objsheet->setCellValue('G5','Haber');
        $objsheet->setCellValue('H5','');
        $objsheet->setCellValue('I5','Ejercicio');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      //  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      //  $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

        $numero3=5;
        $numero4=6;

        $numero5=7;
        $numero6=8;

        $numero7=9;
        $numero8=10;

        $numero9=11;
        $numero10=12;

        $numero11=13;
        $numero12=14;

        $incialtotal1=0;
        $totalejercicio1=0;

        $incialtotal2=0;
        $totalejercicio2=0;

        $incialtotal3=0;
        $totalejercicio3=0;

        $incialtotal4=0;
        $totalejercicio4=0;

        $habertotal1=0;
        $debetotal1=0;

        $habertotal2=0;
        $debetotal2=0;

        $habertotal3=0;
        $debetotal3=0;

        $habertotal4=0;
        $debetotal4=0;

        $totalhaberdebe1=0;
        $totalhaberdebe2=0;
        $totalhaberdebe3=0;
        $totalhaberdebe4=0;



        for($i=0;$i<count($data); $i++)
        {
            $numero3++;
            $numero4++;
            $numero5++;
            $numero6++;
            $numero7++;
            $numero8++;
            $numero9++;
            $numero10++;
            $numero11++;
            $numero12++;


            switch($data[$i]->tipo)
            {
                case 1:

                    $objsheet->setCellValue('A'.$numero3,$data[$i]->cuenta);
                    $objsheet->setCellValue('A'.$numero4,'TOTAL INGRESOS');
    
                    $objsheet->setCellValue('B'.$numero3,$data[$i]->sub_cta);
                    $objsheet->setCellValue('C'.$numero3,$data[$i]->nombre);
                    $objsheet->setCellValue('D'.$numero3,number_format(abs($data[$i]->sini),2,'.',','));
    
                    $incialtotal1 = $incialtotal1 + abs($data[$i]->sini);
                    $objsheet->setCellValue('D'.$numero4,number_format(abs($incialtotal1),2,'.',','));

                    $objsheet->setCellValue('E'.$numero3,'');
    
                    $objsheet->setCellValue('F'.$numero3,number_format(abs($data[$i]->cargos),2,'.',','));
                    $objsheet->setCellValue('G'.$numero3,number_format(abs($data[$i]->abonos),2,'.',','));

                    $debetotal1=$debetotal1+abs($data[$i]->cargos);
                    $habertotal1=$habertotal1+abs($data[$i]->abonos);
                    $totalhaberdebe1=$debetotal1-abs($habertotal1);

                    $objsheet->setCellValue('G'.$numero4,number_format(abs($totalhaberdebe1),2,'.',','));

                    $objsheet->setCellValue('H'.$numero3,'');

                    $objsheet->setCellValue('I'.$numero3,number_format(abs($data[$i]->ejercicio),2,'.',','));
    
                    $totalejercicio1=$totalejercicio1+abs($data[$i]->ejercicio);
                    $objsheet->setCellValue('I'.$numero4,number_format(abs($totalejercicio1),2,'.',','));

                //    $objsheet->setCellValue('C'.$numero11,'UTILIDAD ENTA DEL EJERCICIO');

                   break;
                case 2:

                    $objsheet->setCellValue('A'.$numero5,$data[$i]->cuenta);
                    $objsheet->setCellValue('A'.$numero6,'UTILIDAD BRUTA');
    
                    $objsheet->setCellValue('B'.$numero5,$data[$i]->sub_cta);
                    $objsheet->setCellValue('C'.$numero5,$data[$i]->nombre);
                    $objsheet->setCellValue('C'.$numero6,'');
                    $objsheet->setCellValue('D'.$numero5,number_format($data[$i]->sini,2,'.',','));
    
                    $incialtotal2 = $incialtotal2 + $data[$i]->sini;
                    $objsheet->setCellValue('D'.$numero6,number_format($incialtotal1-$incialtotal2,2,'.',','));
    
                    $objsheet->setCellValue('E'.$numero5,'');

                    $objsheet->setCellValue('F'.$numero5,number_format($data[$i]->cargos,2,'.',','));
                    $objsheet->setCellValue('G'.$numero5,number_format($data[$i]->abonos,2,'.',','));

                    $debetotal2=$debetotal2+$data[$i]->cargos;
                    $habertotal2=$habertotal2+$data[$i]->abonos;
                    $totalhaberdebe2=$debetotal2-$habertotal2;

                    $objsheet->setCellValue('G'.$numero6,number_format(abs($totalhaberdebe1)-abs($totalhaberdebe2),2,'.',','));

                    $objsheet->setCellValue('H'.$numero5,'');

                    $objsheet->setCellValue('I'.$numero5,number_format($data[$i]->ejercicio,2,'.',','));
    
                    $totalejercicio2=$totalejercicio2+$data[$i]->ejercicio;
                    $objsheet->setCellValue('I'.$numero6,number_format($totalejercicio1-$totalejercicio2,2,'.',','));

                  //  $objsheet->setCellValue('C'.$numero11,'UTILIDAD ENTA DEL EJERCICIO');

                   break;
                case 3:

                    $objsheet->setCellValue('A'.$numero7,$data[$i]->cuenta);
                    $objsheet->setCellValue('A'.$numero8,'TOTAL GASTOS');
    
                    $objsheet->setCellValue('B'.$numero7,$data[$i]->sub_cta);
                    $objsheet->setCellValue('C'.$numero7,$data[$i]->nombre);
                    $objsheet->setCellValue('D'.$numero7,number_format($data[$i]->sini,2,'.',','));
    
                    $incialtotal3 = $incialtotal3 + $data[$i]->sini;
                    $objsheet->setCellValue('D'.$numero8,number_format($incialtotal3,2,'.',','));
    
                    $objsheet->setCellValue('E'.$numero7,'');

                    $objsheet->setCellValue('F'.$numero7,number_format($data[$i]->cargos,2,'.',','));
                    $objsheet->setCellValue('G'.$numero7,number_format($data[$i]->abonos,2,'.',','));

                    $debetotal3=$debetotal3+$data[$i]->cargos;
                    $habertotal3=$habertotal3+$data[$i]->abonos;
                    $totalhaberdebe3=$debetotal3-$habertotal3;

                    $objsheet->setCellValue('G'.$numero8,number_format($totalhaberdebe3,2,'.',','));

                    $objsheet->setCellValue('H'.$numero7,'');

                    $objsheet->setCellValue('I'.$numero7,number_format($data[$i]->ejercicio,2,'.',','));
    
                    $totalejercicio3=$totalejercicio3+$data[$i]->ejercicio;
                    $objsheet->setCellValue('I'.$numero8,number_format($totalejercicio3,2,'.',','));

                  //  $objsheet->setCellValue('C'.$numero11,'UTILIDAD ENTA DEL EJERCICIO');

                   break;
                case 4:

                    $objsheet->setCellValue('A'.$numero9,$data[$i]->cuenta);
                    $objsheet->setCellValue('A'.$numero10,'GASTOS FINANCIEROS');
    
                    $objsheet->setCellValue('B'.$numero9,$data[$i]->sub_cta);
                    $objsheet->setCellValue('C'.$numero9,$data[$i]->nombre);
                    $objsheet->setCellValue('D'.$numero9,number_format($data[$i]->sini,2,'.',','));
    
                    $incialtotal4 = $incialtotal4 + $data[$i]->sini;
                    $objsheet->setCellValue('D'.$numero10,number_format($incialtotal4,2,'.',','));
    
                    $objsheet->setCellValue('E'.$numero9,'');

                    $objsheet->setCellValue('F'.$numero9,number_format($data[$i]->cargos,2,'.',','));
                    $objsheet->setCellValue('G'.$numero9,number_format($data[$i]->abonos,2,'.',','));

                    $debetotal4=$debetotal4+$data[$i]->cargos;
                    $habertotal4=$habertotal4+$data[$i]->abonos;
                    $totalhaberdebe4=$debetotal4-$habertotal4;

                    $objsheet->setCellValue('G'.$numero10,number_format($totalhaberdebe4,2,'.',','));

                    $objsheet->setCellValue('H'.$numero9,'');

                    $objsheet->setCellValue('I'.$numero9,number_format($data[$i]->ejercicio,2,'.',','));
    
                    $totalejercicio4=$totalejercicio4+$data[$i]->ejercicio;
                    $objsheet->setCellValue('I'.$numero10,number_format($totalejercicio4,2,'.',','));

                  //  $objsheet->setCellValue('C'.$numero11,'UTILIDAD ENTA DEL EJERCICIO');

                   break;
            }              

        }

        $objsheet->setCellValue('C'.$numero11,'');
        $objsheet->setCellValue('C'.$numero12,'UTILIDAD NETA DEL EJERCICIO');
        $objsheet->setCellValue('D'.$numero12,number_format($incialtotal1-$incialtotal2-$incialtotal3-$incialtotal4,2,'.',','));
        $objsheet->setCellValue('G'.$numero12,number_format((((abs($totalhaberdebe1)-abs($totalhaberdebe2))-abs($totalhaberdebe3))-abs($totalhaberdebe4)),2,'.',','));
        $objsheet->setCellValue('I'.$numero12,number_format(((($totalejercicio1-$totalejercicio2)-$totalejercicio3)-$totalejercicio4),2,'.',','));

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

        $objPHPExcel->getActiveSheet()->getStyle('C1:C'.$lastrow)->applyFromArray($styleleft);

        $objPHPExcel->getActiveSheet()->getStyle('D6:D'.$lastrow)->applyFromArray($styleright);
        $objPHPExcel->getActiveSheet()->getStyle('F6:F'.$lastrow)->applyFromArray($styleright);
        $objPHPExcel->getActiveSheet()->getStyle('G6:G'.$lastrow)->applyFromArray($styleright);
        $objPHPExcel->getActiveSheet()->getStyle('I6:I'.$lastrow)->applyFromArray($styleright);

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

