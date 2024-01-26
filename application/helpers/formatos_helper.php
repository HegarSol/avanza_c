<?php

defined('BASEPATH') or exit('No direct script access alloed');

/**
 * 
 * Formatos Helper
 * 
 *  Funciones para llamar a los distintos tipos de formatos de cheques de los clientes
 * 
 */


 if(!function_exists('formato'))
 {
      function formato($ruta,$id)
      {
          if(count($ruta) == 0)
          {
              formato_standar($id);
          }
          else
          {
             eval($ruta[0]['nombre_formato'].'('.$id.');');
          }
      }
 }
 if(!function_exists('formato_standar'))
 {
    function formato_standar($id)
    {
        $CI =& get_instance();
        $CI->load->model('BancosModel','bancos');
        $CI->load->model('OperacionesModel','opera');
        $CI->load->model('Configuraciones_model','configura');
        $CI->load->model('CuentasModel','cuentas');

        $rowc = $CI->configura->getConfig();
        $datos = $CI->opera->datosOpera($id);
        $detalle = $CI->opera->detallepoliza($id);

        $CI->pdf->SetAutoPageBreak(true,10);
        $CI->pdf->AddPage();
        $CI->pdf->SetTitle(utf8_decode('Poliza contable cheque'));
        $CI->pdf->SetFillColor(220,220,220);
        $CI->pdf->SetDrawColor(220,220,220);
        $CI->pdf->SetFont('Helvetica','B',15);
        $CI->pdf->Cell(10,0,utf8_decode('PÓLIZA CONTABLE CHEQUE'));
        $CI->pdf->Cell(150);
        $CI->pdf->SetFont('Helvetica','B',10);
        $CI->pdf->Cell(10,0,'No.Cheque: '.$datos[0]['no_mov']);
        $CI->pdf->Ln(8);
        $CI->pdf->Cell(160);
        $CI->pdf->Cell(10,0,'Fecha: '.date('d-m-Y',strtotime($datos[0]['fecha'])));
        $CI->pdf->Ln(8);
        $CI->pdf->Cell(10,7,'Beneficiario: '.$datos[0]['beneficia']);
        $CI->pdf->Line(10, 35, 200, 35);
        $CI->pdf->Cell(135);
        $CI->pdf->Cell(40,7,'$ '.number_format($datos[0]['monto'],2,'.',''),1,0,'C');
        $CI->pdf->Line(10, 45, 200, 45);
        $CI->pdf->Ln(15);
        $CI->pdf->Cell(10,0,$CI->pdf->num2letras($datos[0]['monto'],'MXN'));
        $CI->pdf->Ln(7);
        $CI->pdf->Cell(145,4,'Concepto',0,1,'L','true');
        $CI->pdf->Cell(145,15,$datos[0]['concepto'],1,0,'');
        $CI->pdf->SetCol(0);
        $CI->pdf->SetY(48);
        $CI->pdf->SetCol(2.3);
        $CI->pdf->Cell(50,4,'Firma de recibido',0,1,'C','true');
        $CI->pdf->Cell(50,15,'',1,0,'');
        $CI->pdf->SetCol(0);
        $CI->pdf->Ln(20);
        $CI->pdf->Cell(20,4,'Cuenta',0,0,'',true);
        $CI->pdf->Cell(50,4,'Nombre',0,0,'',true);
        $CI->pdf->Cell(80,4,'Referencia',0,0,'',true);
        $CI->pdf->Cell(25,4,'Cargo',0,0,'',true);
        $CI->pdf->Cell(25,4,'Abono',0,0,'',true);
        $CI->pdf->Ln(10);

        $totalcargos = 0;
        $totalabono = 0;

        for($i=0; $i<count($detalle); $i++)
        {
            if($detalle[$i]['c_a'] == '+')
            {
               $CI->pdf->Cell(20,0,$detalle[$i]['cuenta'].' - '.$detalle[$i]['sub_cta']);
               $CI->pdf->Cell(50,0,utf8_decode($detalle[$i]['nombre_cuenta']));
               $CI->pdf->Cell(75,0,utf8_decode($detalle[$i]['referencia']));
               $CI->pdf->Cell(25,0,$detalle[$i]['monto'],0,0,'R');
               $CI->pdf->Cell(25,0,'');
               $totalcargos = $totalcargos + $detalle[$i]['monto'];
         
            }
            else
            {
               $CI->pdf->Cell(20,0,$detalle[$i]['cuenta'].' - '.$detalle[$i]['sub_cta']);
               $CI->pdf->Cell(50,0,utf8_decode($detalle[$i]['nombre_cuenta']));
               $CI->pdf->Cell(80,0,utf8_decode($detalle[$i]['referencia']));
               $CI->pdf->Cell(25,0,'');
               $CI->pdf->Cell(25,0,$detalle[$i]['monto'],0,0,'R');
               $totalabono = $totalabono + $detalle[$i]['monto'];
           
            }
            $CI->pdf->Ln(5);
        }

        $CI->pdf->SetY(254);
        $CI->pdf->SetCol(1.3);
        $CI->pdf->Cell(50,4,'Sumas iguales',0,1,'L','true');
        $CI->pdf->SetY(254);
        $CI->pdf->SetCol(2.1);
        $CI->pdf->Cell(30,4,number_format($totalcargos,2,'.',''),0,1,'R',true);
        $CI->pdf->SetY(254);
        $CI->pdf->SetCol(2.6);
        $CI->pdf->Cell(30,4,number_format($totalabono,2,'.',''),0,1,'R',true);

        $CI->pdf->SetY(261);
        $CI->pdf->SetCol(0);
        $CI->pdf->Cell(30,4,'Elaborado por',0,1,'C','true');
        $CI->pdf->Cell(30,10,'',1,0,'');
        $CI->pdf->SetY(261);
        $CI->pdf->SetCol(0.5);
        $CI->pdf->Cell(30,4,'Revisado',0,1,'C','true');
        $CI->pdf->Cell(30,10,'',1,0,'');
        $CI->pdf->SetY(261);
        $CI->pdf->SetCol(1);
        $CI->pdf->Cell(30,4,'Autorizado',0,1,'C','true');
        $CI->pdf->Cell(30,10,'',1,0,'');
        $CI->pdf->SetY(261);
        $CI->pdf->SetCol(1.5);
        $CI->pdf->Cell(30,4,'Auxiliar',0,1,'C','true');
        $CI->pdf->Cell(30,10,'',1,0,'');
        $CI->pdf->SetY(261);
        $CI->pdf->SetCol(2);
        $CI->pdf->Cell(69,4,'',0,1,'C','true');
        $CI->pdf->Cell(69,10,'',1,0,'');

        $CI->pdf->Output('I','poliza_contable_cheque.pdf');
    }        
 }
 if(!function_exists('cheque_banamex_calderon'))
 {
     function cheque_banamex_calderon($id)
     {
         $CI =& get_instance();
         $CI->load->model('BancosModel','bancos');
         $CI->load->model('OperacionesModel','opera');

         $datos = $CI->opera->datosOpera($id);

         $CI->pdf->SetAutoPageBreak(true,10);
         $CI->pdf->AddPage('L',array(80,210));
         $CI->pdf->SetTitle(utf8_decode('Cheque de Banamex'));
         $CI->pdf->SetFillColor(220,220,220);
         $CI->pdf->SetDrawColor(220,220,220);
         $CI->pdf->SetFont('Helvetica','B',10);
         $CI->pdf->Cell(160);
         $CI->pdf->Cell(10,0,'Fecha: '.date('d-m-Y',strtotime($datos[0]['fecha'])));         
         $CI->pdf->SetFont('Helvetica','',8);
         $CI->pdf->Ln(12);
         $CI->pdf->Cell(10,0,utf8_decode('Páguese este cheque a la orden de:'));
         $CI->pdf->Ln(7);
         $CI->pdf->SetFont('Helvetica','B',12.5);
         $CI->pdf->Cell(10,0,$datos[0]['beneficia']);
         $CI->pdf->Line(10, 35, 200, 35);
         $CI->pdf->Cell(150);
         $CI->pdf->Cell(10,0,'$ '.number_format($datos[0]['monto'],2,'.',''));
         $CI->pdf->Ln(15);
         $CI->pdf->Cell(10,0,$CI->pdf->num2letras($datos[0]['monto'],'MXN'));
         $CI->pdf->Line(10, 50, 200, 50);

         $CI->pdf->Ln(25);
         $CI->pdf->SetFont('Helvetica','',8);
         $CI->pdf->Cell(155);
         $CI->pdf->Cell(10,0,'Firma');
         $CI->pdf->Line(140, 65, 200, 65);

         $CI->pdf->Output('I','cheque_banamex.pdf');
     }
 }