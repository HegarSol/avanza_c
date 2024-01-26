<?php
class ReporteCuentasPagar extends MY_Controller
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
            $data=array('titulo'=>'Reporte cuentas por pagar','rfc' => $rfc[0]['rfc'],'razon'=>$this->validaempresas->get_razon($_SESSION['idEmpresa']),'errores'=>$errores,'permisosGrupo'=>$permisos);
            $items=$this->menuModel->menus($_SESSION['tipo']);
            $this->multi_menu->set_items($items);
            $this->load->view('templates/header');
            $this->load->view('templates/navigation',$data);
            $this->load->view('reportes/reportescuentaspagar');
            $this->load->view('templates/footer');
        }
        else
        {
            redirect('/inicio/login','refresh');
        }
    }
    public function Excelexport()
    {

        $objPHPExcel = new PHPExcel();

        $summon = 0;

        $valor = $this->input->post('faccom');
        
        $rfcempresa = $this->input->post('rfcempresa');
        
        $valor2 = $this->input->post('topro');
        if($valor2 == 'todos')
        {
            $rfcprove = '';
        }
        else
        {
            $rfcprove = $this->input->post('rfcprove');
        }
        $valor3 = $this->input->post('pepaam');
        
        $valor4 = $this->input->post('gera');
        if($valor4 == 'gene')
        {
            $fechaini = '';
            $fechafin = '';
        }
        else
        {
            $fechaini = $this->input->post('fechaini');
            $fechafin = $this->input->post('fechafinal');
        }
        $valor5 = $this->input->post('acude');
        if($valor5 == 1)
        {
           $acude = true;
        }
        else
        {
           $acude = '';
        }

        if($valor == 'factu')
        {
            $ch = curl_init("http://avanzab.hegarss.com/api/Comprobantes/reporte?empresa=".$rfcempresa."&proveedor=".$rfcprove."&fecha_inicial=".$fechaini."&status=".$valor3."&fecha_final=".$fechafin."&acumulado=".$acude);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                $resu = curl_exec($ch);
                $response = json_decode($resu);

                header("Content-Type: text/html;charset=utf-8");

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="facturas.xls"');
                header('Cache-Control: max-age=0');

                $objsheet = $objPHPExcel->setActiveSheetIndex(0);
                if($valor5 == 1)
                {
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:D2');
                }
                else
                {
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:G2');    
                }

                if($valor3 == 1)
                {
                    $objsheet->setCellValue('A1','REPORTE CUENTAS POR PAGAR');
                }
                else
                {
                    $objsheet->setCellValue('A1','REPORTE FACTURAS PAGADAS');
                }
                if($valor4 == 'gene')
                {
                    $objsheet->setCellValue('A2','PERIODO GENERAL');
                }
                else
                {
                    $objsheet->setCellValue('A2','DEL: '.date('d-m-Y',strtotime($fechaini)). 'AL: '.date('d-m-Y',strtotime($fechafin)));
                }

                $numero=3;
                $numero2=4;

                if($valor5 == 1)
                {

                    $objsheet->setCellValue('A3','Proveedor');
                    $objsheet->setCellValue('B3','Deuda');
                    $objsheet->setCellValue('C3','Pagado');
                    $objsheet->setCellValue('D3','Monto');


                        if($response->status == true)
                        {
                            $datos = $response->data;

                            $deuda = 0;
                            $pagado = 0;
                            $toal = 0;

                            for($i=0; $i<count($datos); $i++)
                            {
                                $numero++;
                                $numero2++;

                                $datosrfc = $this->beneficiario->datosbenerfc($datos[$i]->rfc_emisor);

                                if(count($datosrfc) == 0)
                                {
                                    $objsheet->setCellValue('A'.$numero,'');

                                }
                                else
                                {
                                    $objsheet->setCellValue('A'.$numero,$datosrfc[0]['nombre']);
                                }

                                $objsheet->setCellValue('B'.$numero,'$ '.number_format($datos[$i]->deuda,2,'.',''));
                                $objsheet->setCellValue('C'.$numero,'$ '.number_format($datos[$i]->pagado,2,'.',''));
                                $objsheet->setCellValue('D'.$numero,'$ '.number_format($datos[$i]->total,2,'.',''));
                                $summon = $summon + $datos[$i]->total;
                                $objsheet->setCellValue('D'.$numero2,'TOTAL : $ ' .number_format($summon,2,'.',''));
                            }

                            $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
                            $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
                            $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
                            $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
                        }
                        else
                        {
                            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:D4');
                            $objsheet->setCellValue('A4',$response->error);
                            $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
                        }


    
                }
                else
                {
                    $objsheet->setCellValue('A3','Serie');
                    $objsheet->setCellValue('B3','Folio');
                    $objsheet->setCellValue('C3','Fecha');
                    $objsheet->setCellValue('D3','Descripcion');
                    $objsheet->setCellValue('E3','Poliza pago');
                    $objsheet->setCellValue('F3','Fecha pago');
                    $objsheet->setCellValue('G3','Importe');

                    $total = 0;
                    $summon2 = 0;
                    if($response->status == true)
                    {
                       $datos = $response->data;

                       $tajos = [];
                       $ordenado = [];

                       for($j=0;$j<count($datos); $j++)
                       {
                           $tajos[] = [
                               'rfc_emisor' => $datos[$j]->rfc_emisor
                           ];
                       }

                       foreach($tajos as $key => $row)
                       {
                           $aux[$key] = $row['rfc_emisor'];
                       }

                       array_multisort($aux,SORT_ASC,$tajos);

                       foreach($tajos as $key => $row)
                       {
                           $ordenado[] = ['rfc_emisor' => $row['rfc_emisor'] ];
                       }

                       $datosr = array_unique($ordenado, SORT_REGULAR);

                       $numerod = 4;
                       $numero2d = 5;

                       foreach($datosr as $lai)
                       {
                           $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$numerod.':G'.$numerod.'');

                           $datosrfc = $this->beneficiario->datosbenerfc($lai['rfc_emisor']);
                           if(count($datosrfc) == 0)
                           {
                             $objsheet->setCellValue('A'.$numerod,'');
                           }
                           else
                           {
                             $objsheet->setCellValue('A'.$numerod,$lai['rfc_emisor'].' - '.$datosrfc[0]['nombre']);
                           }

                           for($i=0; $i<count($datos); $i++)
                           {

                                if($lai['rfc_emisor'] == $datos[$i]->rfc_emisor)
                                {
                                    $numerod++;
                                    $numero2d++;
                                    $objsheet->setCellValue('A'.$numerod,$datos[$i]->serie);
                                    $objsheet->setCellValue('B'.$numerod,$datos[$i]->folio);
                                    $objsheet->setCellValue('C'.$numerod,date('d-m-Y',strtotime($datos[$i]->fecha)));
                                    $objsheet->setCellValue('D'.$numerod,$datos[$i]->descripcion);
                                    $objsheet->setCellValue('E'.$numerod,$datos[$i]->poliza_pago);
                                    if($datos[$i]->fecha_pago == '')
                                    {
                                        $objsheet->setCellValue('F'.$numerod,'');
                                    }
                                    else
                                    {
                                        $objsheet->setCellValue('F'.$numerod,date('d-m-Y',strtotime($datos[$i]->fecha_pago)));
                                    }

                                    $objsheet->setCellValue('G'.$numerod,'$ '.number_format($datos[$i]->total,2,'.',''));
                                    $summon2 = $summon2 + $datos[$i]->total;
                                }

                           }

                           $numerod++;
                           $numero2d++;

                       }
                       $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
                       $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
                       $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
                       $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
                       $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
                       $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
                       $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
                    }
                    else
                    {
                        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
                        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
                        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
                        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
                        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
                        $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
                        $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);

                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:G4');
                        $objsheet->setCellValue('A4',$response->error);
                        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
                    }

                    $objsheet->setCellValue('G'.$numero2d,'TOTAL : $ ' .number_format($summon2,2,'.',''));
                }

                     $style = array(
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            )
                        );

                $objPHPExcel->getDefaultStyle()->applyFromArray($style);
              //  $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleArray);
                $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
                $objWriter->save('php://output');
        }
        else
        {
            if($fechaini == '' && $fechafin == '')
            {
               $fechaini = '2018-09-01';
               $fechafin = date('Y-m-d');
            }

                $ch2 = curl_init("http://avanzab.hegarss.com/api/Comprobantes/reporte_pagos?empresa=".$rfcempresa."&proveedor=".$rfcprove."&fechaini=".$fechaini."&fechafin=".$fechafin);
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, 0);
                $resu2 = curl_exec($ch2);
                $response = json_decode($resu2);

                header("Content-Type: text/html;charset=utf-8");

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="complemento_pago.xls"');
                header('Cache-Control: max-age=0');

                $objsheet = $objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:G2');

                $objsheet->setCellValue('A1','REPORTE DE COMPLEMENTOS DE PAGO PENDIENTES POR RECIBIR');
                
                if($valor4 == 'gene')
                {
                    $objsheet->setCellValue('A2','PERIODO GENERAL');
                }
                else
                {
                    $objsheet->setCellValue('A2','DEL: '.date('d-m-Y',strtotime($fechaini)). ' AL: '.date('d-m-Y',strtotime($fechafin)));
                }

                    $objsheet->setCellValue('A3','Serie');
                    $objsheet->setCellValue('B3','Folio');
                    $objsheet->setCellValue('C3','Fecha');
                    $objsheet->setCellValue('D3','Descripcion');
                    $objsheet->setCellValue('E3','Poliza pago');
                    $objsheet->setCellValue('F3','Fecha pago');
                    $objsheet->setCellValue('G3','Importe');

                    $total = 0;
                    $summon2 = 0;
                    if($response->status == true)
                    {
                        $datos = $response->data;

                        $tajos = [];
                        $ordenado = [];

                        for($j=0;$j<count($datos);$j++)
                        {
                            $tajos[] = [
                                'rfc_emisor' => $datos[$j]->rfc_emisor
                            ];
                        }

                        foreach($tajos as $key => $row)
                        {
                            $aux[$key] = $row['rfc_emisor'];
                        }

                        array_multisort($aux,SORT_ASC,$tajos);

                        foreach($tajos as $key => $row)
                        {
                            $ordenado[] = ['rfc_emisor' => $row['rfc_emisor'] ];
                        }

                        $datosr = array_unique($ordenado, SORT_REGULAR);

                        $numerod = 4;
                        $numero2d = 5;

                        foreach($datosr as $lai)
                        {
                            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$numerod.':G'.$numerod.'');

                            $datosrfc = $this->beneficiario->datosbenerfc($lai['rfc_emisor']);
                            if(count($datosrfc) == 0)
                            {
                                $objsheet->setCellValue('A'.$numerod,'');
                            }
                            else
                            {
                                $objsheet->setCellValue('A'.$numerod,$lai['rfc_emisor'].' - '.$datosrfc[0]['nombre']);
                            }

                            for($i=0; $i<count($datos); $i++)
                            {

                                if($lai['rfc_emisor'] == $datos[$i]->rfc_emisor)
                                {

                                    $numerod++;
                                    $numero2d++;                                 
                                    $objsheet->setCellValue('A'.$numerod,$datos[$i]->serie);
                                    $objsheet->setCellValue('B'.$numerod,$datos[$i]->folio);
                                    $objsheet->setCellValue('C'.$numerod,date('d-m-Y',strtotime($datos[$i]->fecha)));
                                    $objsheet->setCellValue('D'.$numerod,$datos[$i]->descripcion);
                                    $objsheet->setCellValue('E'.$numerod,$datos[$i]->poliza_pago);
                                    if($datos[$i]->fecha_pago == '')
                                    {
                                        $objsheet->setCellValue('F'.$numerod,'');
                                    }
                                    else
                                    {
                                        $objsheet->setCellValue('F'.$numerod,date('d-m-Y',strtotime($datos[$i]->fecha_pago)));
                                    }

                                    $objsheet->setCellValue('G'.$numerod,'$ '.number_format($datos[$i]->total,2,'.',''));
                                    $summon2 = $summon2 + $datos[$i]->total;


                                }
                            }

                            $numerod++;
                            $numero2d++;   

                        }
                        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
                        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
                        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
                        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
                        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
                        $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
                        $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
                    }
                    else
                    {
                        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
                        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
                        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
                        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
                        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
                        $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
                        $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);

                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:G4');
                        $objsheet->setCellValue('A4',$response->error);
                        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
                    }

                   $objsheet->setCellValue('G'.$numero2d,'TOTAL : $ ' .number_format($summon2,2,'.',''));

                    $style = array(
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        )
                    );

            $objPHPExcel->getDefaultStyle()->applyFromArray($style);
          //  $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleArray)
            $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
            $objWriter->save('php://output');
        }
    }
    public function imprimir()
    {
        $valor = $this->input->post('faccom');
        
        $rfcempresa = $this->input->post('rfcempresa');
        
        $valor2 = $this->input->post('topro');
        if($valor2 == 'todos')
        {
            $rfcprove = '';
        }
        else
        {
            $rfcprove = $this->input->post('rfcprove');
        }
        $valor3 = $this->input->post('pepaam');
        
        $valor4 = $this->input->post('gera');
        if($valor4 == 'gene')
        {
            $fechaini = '';
            $fechafin = '';
        }
        else
        {
            $fechaini = $this->input->post('fechaini');
            $fechafin = $this->input->post('fechafinal');
        }
        $valor5 = $this->input->post('acude');
        if($valor5 == 1)
        {
           $acude = true;
        }
        else
        {
           $acude = '';
        }

        if($valor == 'factu')
        {
                $ch = curl_init("http://avanzab.hegarss.com/api/Comprobantes/reporte?empresa=".$rfcempresa."&proveedor=".$rfcprove."&fecha_inicial=".$fechaini."&status=".$valor3."&fecha_final=".$fechafin."&acumulado=".$acude);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                $resu = curl_exec($ch);
                $response = json_decode($resu);

                $this->pdf->SetAutoPageBreak(true,10);
                $this->pdf->AddPage();
                $this->pdf->SetTitle(utf8_decode('Reporte Cuentas por Pagar'));
                $this->pdf->SetFillColor(220,220,220);
                $this->pdf->SetDrawColor(220,220,220);        
                $this->pdf->SetFont('Helvetica','B',10);
                $this->pdf->Ln(10);
                if($valor3 == 1)
                {
                    $this->pdf->Cell(80);
                    $this->pdf->Cell(30,0,'Reporte Cuentas por Pagar',0,1,'C');
                }
                else if($valor3 == 2)
                {
                    $this->pdf->Cell(80);
                    $this->pdf->Cell(30,0,'Reporte Facturas Pagadas',0,1,'C');
                }
                else
                {
                    $this->pdf->Cell(80);
                    $this->pdf->Cell(30,0,'Pendientes y Pagadas',0,1,'C');
                }
                $this->pdf->Ln(5);
                if($valor4 == 'gene')
                {
                    $this->pdf->Cell(80);
                    $this->pdf->Cell(10,0,'Periodo General');
                }
                else
                {
                   $this->pdf->Cell(90);
                   $this->pdf->Cell(10,0,'Del: '.date('d-m-Y',strtotime($fechaini)). ' Al: '.date('d-m-Y',strtotime($fechafin)),0,1,'C');
                }
                $this->pdf->Ln(20);
                $y=$this->pdf->GetY();
                if($valor5 == 1)
                {
                    $this->pdf->SetWidths(array(105,30,30,30));
                    $this->Rowpdf(array('Proveedor','Deuda','Pagado','Monto'));
                    $this->pdf->Line(5,$y+3,250,$y+3);
                    $this->pdf->Ln(10);
                    $datos = $response->data;

                    $deuda =0;
                    $pagado= 0;
                    $toal = 0;

                    for($i=0; $i<count($datos); $i++)
                    {
    
                        $datosrfc = $this->beneficiario->datosbenerfc($datos[$i]->rfc_emisor);

                        if(count($datosrfc) == 0)
                        {
                            $rfc = '';
                        }
                        else
                        {
                            $rfc = $datosrfc[0]['nombre'];
                        }
                        $renglony = $this->Rowpdf(array($rfc,
                                                        number_format($datos[$i]->deuda,2,'.',''),
                                                        number_format($datos[$i]->pagado,2,'.',''),
                                                        number_format($datos[$i]->total,2,'.','')
                                                    ));

                                                    $deuda = $deuda + $datos[$i]->deuda;
                                                    $pagado = $pagado + $datos[$i]->pagado;
                                                    $toal = $toal + $datos[$i]->total;

                        $this->pdf->SetY($renglony-3.5);
                        
                        $this->pdf->Ln(5);
                   }

                   $this->pdf->Ln(5);

                   $this->pdf->Cell(110);
                   $this->pdf->Cell(20,0,'Totales: '.number_format($deuda,2,'.',''),0,0,'R');
                   $this->pdf->Cell(25,0,number_format($pagado,2,'.',''),0,0,'R');
                   $this->pdf->Cell(35,0,number_format($toal,2,'.',''),0,0,'R');
                }
                else
                {
                    $this->pdf->SetFont('Helvetica','B',9.5);
                    $this->pdf->Cell(15,1,'Serie',0,0,'C',0);
                    $this->pdf->Cell(20,1,'Folio',0,0,'C',0);
                    $this->pdf->Cell(20,1,'Fecha',0,0,'C',0);
                    $this->pdf->Cell(60,1,utf8_decode('Descripción'),0,0,'C',0);
                    $this->pdf->Cell(25,1,utf8_decode('Póliza pago'),0,0,'C',0);
                    $this->pdf->Cell(30,1,'Fecha pago',0,0,'C',0);
                    $this->pdf->Cell(30,1,'Importe',0,0,'C',0);
                    $this->pdf->Line(5,$y+3,250,$y+3);
                    $this->pdf->Ln(5);

                    $total = 0;
                    if($response->status == true)
                    {
                        $datos = $response->data;


                        $tajos = [];
                        $ordenado = [];
    
                        for($j=0;$j<count($datos); $j++)
                        {
                             $tajos[] = [
                                 'rfc_emisor' => $datos[$j]->rfc_emisor
                             ];
                        }
    
                        foreach($tajos as $key => $row)
                        {
                            $aux[$key] = $row['rfc_emisor'];
                        }
    
                        array_multisort($aux,SORT_ASC,$tajos);
    
                        foreach($tajos as $key => $row)
                        {
                            $ordenado[] = ['rfc_emisor' => $row['rfc_emisor'] ];
                        }
    
    
                        $datosr = array_unique($ordenado, SORT_REGULAR);
    
                        foreach($datosr as $lai)
                        {
    
                            $this->pdf->Cell(200,7,$lai['rfc_emisor'].' - ',0,0,'L',1);
                            $this->pdf->Ln(10);
    
                            for($i=0; $i<count($datos); $i++)
                            {
    
                                if($lai['rfc_emisor'] == $datos[$i]->rfc_emisor)
                                {
                                    $this->pdf->Cell(15,1,$datos[$i]->serie,0,0,'C');
                                    $this->pdf->Cell(20,1,$datos[$i]->folio,0,0,'R');
                                    $this->pdf->Cell(22,1,date('d-m-Y',strtotime($datos[$i]->fecha)),0,0,'R');
                                    $this->pdf->Cell(60,1,$datos[$i]->descripcion,0,0,'L');
                                    $this->pdf->Cell(25,1,$datos[$i]->poliza_pago,0,0,'C');
                                    if($datos[$i]->fecha_pago == '')
                                    {
                                        $this->pdf->Cell(30,1,'',0,0,'C');
                                    }
                                    else
                                    {
                                        $this->pdf->Cell(30,1,date('d-m-Y',strtotime($datos[$i]->fecha_pago)),0,0,'C');
                                    }
    
                                    $this->pdf->Cell(25,1,'$ '.number_format($datos[$i]->total,2,'.',''),0,0,'R');
        
        
                                    $total = $total + $datos[$i]->total;
                                    
                                    $this->pdf->Ln(5);
                                }
    
                            }
                        }
                    }
                    else
                    {
                        $this->pdf->Cell(200,7,$response->error,0,0,'C',1);
                        $this->pdf->Ln(5);
                    }



                   $this->pdf->Ln(5);

                   $this->pdf->Cell(165);
                   $this->pdf->Cell(20,0,'Totales: '.number_format($total,2,'.',''),0,0,'R');
                }

        }
        else
        {
            if($fechaini == '' && $fechafin == '')
            {
               $fechaini = '2018-09-01';
               $fechafin = date('Y-m-d');
            }


                $ch2 = curl_init("http://avanzab.hegarss.com/api/Comprobantes/reporte_pagos?empresa=".$rfcempresa."&proveedor=".$rfcprove."&fechaini=".$fechaini."&fechafin=".$fechafin);
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, 0);
                $resu2 = curl_exec($ch2);
                $response = json_decode($resu2);

                $this->pdf->SetAutoPageBreak(true,10);
                $this->pdf->AddPage();
                $this->pdf->SetTitle(utf8_decode('Reporte Cuentas por pagar'));
                $this->pdf->SetFillColor(220,220,220);
                $this->pdf->SetDrawColor(220,220,220);
                $this->pdf->SetFont('Helvetica','B',10);
                $this->pdf->Ln(10);
                $this->pdf->Cell(45);
                $this->pdf->Cell(30,0,'Reporte de Complementos de pago pendientes por recibir');
                $this->pdf->Ln(5);
                if($valor4 == 'gene')
                {
                    $this->pdf->Cell(80);
                    $this->pdf->Cell(10,0,'Periodo General');
                }
                else
                {
                    $this->pdf->Cell(90);
                    $this->pdf->Cell(10,0,'Del: '.date('d-m-Y',strtotime($fechaini)). ' Al: '.date('d-m-Y',strtotime($fechafin)),0,1,'C');
                }
                $this->pdf->Ln(20);
                $y=$this->pdf->GetY();
                $this->pdf->SetFont('Helvetica','B',9.5);
                $this->pdf->Cell(15,1,'Serie',0,0,'C',0);
                $this->pdf->Cell(20,1,'Folio',0,0,'C',0);
                $this->pdf->Cell(20,1,'Fecha',0,0,'C',0);
                $this->pdf->Cell(60,1,utf8_decode('Descripción'),0,0,'C',0);
                $this->pdf->Cell(25,1,utf8_decode('Póliza pago'),0,0,'C',0);
                $this->pdf->Cell(30,1,'Fecha pago',0,0,'C',0);
                $this->pdf->Cell(30,1,'Importe',0,0,'C',0);
                $this->pdf->Line(5,$y+3,250,$y+3);
                $this->pdf->Ln(5);

                $total = 0;

                if($response->status == true)
                {
                    $datos = $response->data;

                    $tajos = [];
                    $ordenado = [];

                    for($j=0;$j<count($datos);$j++)
                    {
                        $tajos[] = [
                            'rfc_emisor' => $datos[$j]->rfc_emisor
                        ];
                    }

                    foreach($tajos as $key => $row)
                    {
                        $aux[$key] = $row['rfc_emisor'];
                    }

                    array_multisort($aux,SORT_ASC,$tajos);

                    foreach($tajos as $key => $row)
                    {
                        $ordenado[] = ['rfc_emisor' => $row['rfc_emisor'] ];
                    }

                    $datosr = array_unique($ordenado, SORT_REGULAR);

                    foreach($datosr as $lai)
                    {
                         $this->pdf->Cell(200,7,$lai['rfc_emisor'].' - ',0,0,'L',1);
                         $this->pdf->Ln(10);

                         for($i=0; $i<count($datos); $i++)
                         {
                             if($lai['rfc_emisor'] == $datos[$i]->rfc_emisor)
                             {
                                 $this->pdf->Cell(15,1,$datos[$i]->serie,0,0,'C');
                                 $this->pdf->Cell(20,1,$datos[$i]->folio,0,0,'R');
                                 $this->pdf->Cell(22,1,date('d-m-Y',strtotime($datos[$i]->fecha)),0,0,'R');
                                 $this->pdf->Cell(60,1,$datos[$i]->descripcion,0,0,'L');
                                 $this->pdf->Cell(25,1,$datos[$i]->poliza_pago,0,0,'C');
                                 if($datos[$i]->fecha_pago == '')
                                 {
                                      $this->pdf->Cell(30,1,'',0,0,'C');
                                 }
                                 else
                                 {
                                     $this->pdf->Cell(30,1,date('d-m-Y',strtotime($datos[$i]->fecha_pago)),0,0,'C');
                                 }

                                 $this->pdf->Cell(25,1,'$ '.number_format($datos[$i]->total,2,'.',''),0,0,'R');

                                 $total = $total + $datos[$i]->total;

                                 $this->pdf->Ln(5);
                             }
                         }
                    }
                }
                else
                {
                    $this->pdf->Cell(200,7,$response->error,0,0,'C',1);
                    $this->pdf->Ln(5);
                }

                $this->pdf->Ln(5);

                $this->pdf->Cell(165);
                $this->pdf->Cell(20,0,'Totales: '.number_format($total,2,'.',''),0,0,'R');
        }

       $this->pdf->Output('I','ReporteCuentasPagar.pdf');
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