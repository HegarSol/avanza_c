<?php

class Reportes extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('menuModel');
        $items=$this->menuModel->menus($_SESSION['tipo']);
        $this->multi_menu->set_items($items);
        $this->load->library('form_validation');
        $this->load->model('CuentasModel','cuentas');
        $this->load->model('BancosModel','bancos');
        $this->load->model('BitacoraModel','bitacora');
        $this->load->model('OperacionesModel','opera');
        $this->load->model('Configuraciones_model','configura');
        $this->load->library('Pdf');
        $this->load->helper('formatos');
    }
    public function ReporteExcelCuentas()
    {
        date_default_timezone_set("America/Mexico_City");
        $opera = array('usuario' => $_SESSION['nombreU'],
                    'tipo_mov' => '',
                    'no_banco' => '',
                    'no_mov' => '',
                    'accion' => 'Descargar',
                    'cuando' => date('Y-m-d H:i:s'),
                    'comentario' => 'Exporto las cuentas a excel',
                    'modulo' => 'Cuentas -> Exportar Excel');
                    $this->bitacora->operacion($opera);
        $cuentas = $this->cuentas->getCuentas();
        $this->output->set_content_type('application/json')->set_output(json_encode($cuentas));
    } 
    public function ReporteExcelBancos()
    {   
        date_default_timezone_set("America/Mexico_City");
        $opera = array('usuario' => $_SESSION['nombreU'],
                       'tipo_mov' => '',
                       'no_banco' => '',
                       'no_mov' => '',
                       'accion' => 'Descargar',
                       'cuando' => date('Y-m-d H:i:s'),
                       'comentario' => 'Exporto los bancos a excel',
                       'modulo' => 'Bancos -> Exportar Excel');
                       $this->bitacora->operacion($opera);
        $bancos = $this->bancos->getBancos();
        $this->output->set_content_type('application/json')->set_output(json_encode($bancos));
    }
    public function encabezado()
    {
        date_default_timezone_set("America/Mexico_City");
        $img = $this->rowc[0]['imgName'];
        $formato = explode(".",$this->rowc[0]['imgName']);
        $imagen = $this->rowc[0]['img'];
        if(isset($imagen)){$this->pdf->Image("data:image/$formato[1];base64,$imagen");}
        $this->pdf->SetFont('Helvetica','B',15);
        $this->pdf->Cell(18,5,'','',0,'L');
        if($this->datos[0]['tipo_mov'] == 'C')
        {
            $this->pdf->Cell(60,5,'CHEQUE','',1,'L');
        }
        else if($this->datos[0]['tipo_mov'] == 'D')
        {
            $this->pdf->Cell(60,5,'DEPOSITO','',1,'L');
        }
        else if($this->datos[0]['tipo_mov'] == 'T')
        {
            $this->pdf->Cell(60,5,'TRANSFERENCIA','',1,'L');
        }
        else if($this->datos[0]['tipo_mov'] == 'O')
        {
            $this->pdf->Cell(60,5,'POLIZA DE DIARIO','',1,'L');
        }
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Helvetica','',10);
        $this->pdf->Cell(32,3.5,'Fecha:','',0,'R');
        $this->pdf->Cell(40,3.5,date('d-m-Y',strtotime($this->datos[0]['fecha'])),'',1,'L');
        $this->pdf->Ln(3);
        $this->pdf->Cell(45,3.5,utf8_decode('Póliza número:'),'',0,'R');
        $this->pdf->Cell(40,3.5,$this->datos[0]['tipo_mov']. ' - ' .$this->datos[0]['no_mov'],'',1,'L');
        $this->pdf->Ln(10);
        $this->pdf->Cell(20);
        $this->pdf->SetFont('Helvetica','B',11);
        $this->pdf->Cell(130,3.5,$this->rowc[0]['nombreEmpresa']);
        $this->pdf->Ln(22);

        $this->pdf->SetFont('Helvetica','B',9);
        if($this->datos[0]['tipo_mov'] == 'C')
        {
           $this->pdf->Cell(100,5,'No.- Prov: '.$this->datos[0]['no_prov']);
           $this->pdf->Ln(5);
           $this->pdf->Cell(100,5,utf8_decode('Nombre beneficiario ó proveedor: ').$this->datos[0]['beneficia']);
           $this->pdf->Ln(5);
        }

        if($this->datos[0]['tipo_mov'] == 'T' && $this->datos[0]['c_a'] == '-')
        {
           $this->pdf->Cell(100,5,'No.- Prov: '.$this->datos[0]['no_prov']);
           $this->pdf->Ln(5);
           $this->pdf->Cell(100,5,utf8_decode('Nombre beneficiario ó proveedor: ').$this->datos[0]['beneficia']);
           $this->pdf->Ln(5);
           $this->pdf->Cell(100,5,'Cta Banco: '.$this->datos[0]['cta_banco']);
           $this->pdf->Ln(5);
           $this->pdf->Cell(100,5,'Banco: '.utf8_decode($this->datos[0]['bene_ctaban']));
           $this->pdf->Ln(5);
        }

        $this->pdf->Cell(200,5,'CONCEPTO',0,1,'C',1);
        $this->pdf->Ln(5);
        $html = '<span style="text-align:justify;" >'.utf8_decode($this->datos[0]['concepto']).'</span>';
        $this->pdf->writeHTML($html, true, 0, true, true);
        $this->pdf->Ln(10); 
    }
    public function ReportePoliza($id,$tipo)
    {

        $this->rowc = $this->configura->getConfig();
        $this->datos = $this->opera->datosOpera($id);
        $this->detalle = $this->opera->detallepoliza($id);

        $ruta = $this->opera->getruta($this->datos[0]['no_banco']);
        
        if($tipo == 'C')
        {
            formato($ruta,$id);
        }
        else
        {
            $this->pdf->SetAutoPageBreak(true,10);
            $this->pdf->AddPage();
            $this->pdf->SetTitle(utf8_decode('Reporte de Póliza'));
            $this->pdf->SetFillColor(220,220,220);
            $this->pdf->SetDrawColor(220,220,220);
    
            $this->encabezado();
    
            $this->pdf->Cell(200,5,'ASIENTO CONTABLE',0,1,'C',1);
            $this->pdf->Ln(10);
            $this->pdf->SetWidths(array(15,30,13,32,60,20,40,20));
            $this->Rowpdf(array('Cuenta','Referencia','Fact','Nombre de cuenta','Concepto','Cargos','Abonos'));
            $this->pdf->Ln(10);
    
            $totalcargos = 0;
            $totalabono = 0;
    
            for($i=0; $i<count($this->detalle); $i++)
            {
                if($this->detalle[$i]['c_a'] == '+')
                {
                   $renglony = $this->Rowpdf(array($this->detalle[$i]['cuenta'],$this->detalle[$i]['referencia'],$this->detalle[$i]['factrefe'],$this->detalle[$i]['nombre_cuenta'],$this->detalle[$i]['concepto'],$this->detalle[$i]['monto'],''));
                   $totalcargos = $totalcargos + $this->detalle[$i]['monto'];
                   $this->pdf->SetY($renglony-3.5);
                }
                else
                {
                   $renglony = $this->Rowpdf(array($this->detalle[$i]['cuenta'],$this->detalle[$i]['referencia'],$this->detalle[$i]['factrefe'],$this->detalle[$i]['nombre_cuenta'],$this->detalle[$i]['concepto'],'',$this->detalle[$i]['monto']));
                   $totalabono = $totalabono + $this->detalle[$i]['monto'];
                   $this->pdf->SetY($renglony-3.5);
                }
                $this->pdf->Ln(5);
           }
           $this->pdf->Ln(1);
           $this->pdf->Cell(135);
           $this->pdf->Cell(10,3,'___________________________________');
           $this->pdf->Ln(5);
           $this->pdf->Cell(115);
           $this->pdf->SetWidths(array(30,30,30));
           $this->Rowpdf(array('TOTAL',number_format($totalcargos,2,'.',''),number_format($totalabono,2,'.','')));
    
            $this->pdf->Output('I','Reportepolizas.pdf');
        }


    }
    public function reporteConciliacion()
    {
        $this->id = $this->input->post('idbanco');
        $this->saldoesta = $this->input->post('saldoestado');
        $this->diferenciaestado = $this->input->post('diferenciaestado');
        $this->fechaini = $this->input->post('fechaini');
        $this->fechafin = $this->input->post('fechafin');

        $this->tipo = $this->input->post('tipoliza');
        $this->mosmo = $this->input->post('mosmo');

        if($this->tipo == 'A')
        {
          $tipo = 'Ambas';
        }
        else if($this->tipo == 'C')
        {
           $tipo = 'Cheques';
        }
        else
        {
           $tipo = 'Depósitos';
        }
        if($this->mosmo == '0')
        {
           $mosmo = 'En transito';
        }
        else
        {
           $mosmo = 'cobrados / en transito';
        }

        $this->saldoinicial = $this->input->post('saldoinicial');
        $this->cargoconciliado = $this->input->post('cargoconciliado');
        $this->abonoconcialiado = $this->input->post('abonoconciliado');
        $this->saldobancos = $this->input->post('saldobancos');
        $this->cargossinconcialiar = $this->input->post('cargossinconciliar');
        $this->abonossinconciliar = $this->input->post('abonossinconciliar');
        $this->saldolibros = $this->input->post('saldolibros');

        $this->valores = $this->bancos->getconciliacion($this->fechaini,$this->fechafin,$this->tipo,$this->id,$this->mosmo);

        $this->data = $this->bancos->datosBancos($this->id);

        $this->pdf->SetAutoPageBreak(true,10);
        $this->pdf->AddPage();
        $this->pdf->SetTitle(utf8_decode('Reporte conciliación bancaria'));
        $this->pdf->SetFillColor(220,220,220);
        $this->pdf->SetDrawColor(220,220,220);        

        $formato = explode(".",$this->data[0]['imgName']);
        $imagen = $this->data[0]['logo'];

        $this->pdf->Image(isset($imagen) ? "data:image/$formato[1];base64,$imagen" : APPPATH.'public'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'logo.png',5,6,70,30,"$formato[1]");
        $this->pdf->SetFont('Helvetica','B',10);
        $this->pdf->Ln(10);
        $this->pdf->Cell(130);
        $this->pdf->Cell(10,0,'Cuenta: '.$this->data[0]['cuenta'],0,1);
        $this->pdf->Ln(5);
        $this->pdf->Cell(130);
        $this->pdf->Cell(10,0,'Banco: '.$this->data[0]['banco'],0,1);
        $this->pdf->Ln(20);
        $this->pdf->SetFont('Helvetica','B',20);
        $this->pdf->Cell(55);
        $this->pdf->Cell(10,0,utf8_decode('Conciliación bancaria'));
        $this->pdf->Ln(20);
        $this->pdf->SetFont('Helvetica','B',10);
        $this->pdf->Cell(10,0,'Del: '.date('d-m-Y',strtotime($this->fechaini)),0,1);
        $this->pdf->Cell(30);
        $this->pdf->Cell(10,0,'Al: '.date('d-m-Y',strtotime($this->fechafin)),0,1);
        $this->pdf->Cell(65);
        $this->pdf->Cell(10,0,utf8_decode('Tipo de póliza: '.$tipo),0,1);
        $this->pdf->Cell(110);
        $this->pdf->Cell(10,0,utf8_decode('Mostrar movimientos: '.$mosmo),0,1);
        $this->pdf->Ln(10);
        $this->pdf->Cell(50,0,'Saldo inicial: ');
        $this->pdf->Cell(10,0,number_format($this->saldoinicial,2,'.',''),0,1,'R');
        $this->pdf->Ln(10);
        $this->pdf->Cell(50,0,'Cargo conciliados  + : ');
        $this->pdf->Cell(10,0,number_format($this->cargoconciliado,2,'.',''),0,1,'R');
        $this->pdf->Ln(10);
        $this->pdf->Cell(50,0,'Abonos conciliados - : ');
        $this->pdf->Cell(10,0,number_format($this->abonoconcialiado,2,'.',''),0,1,'R');
        $this->pdf->Ln(10);
        $this->pdf->Cell(50,0,'Saldo en bancos = : ');
        $this->pdf->Cell(10,0,number_format($this->saldobancos,2,'.',''),0,1,'R');
        $this->pdf->Cell(70,0);
        $this->pdf->Cell(60,0,'Saldo en estado de cuenta: ');
        $this->pdf->Cell(10,0,number_format($this->saldoesta,2,'.',''),0,1,'R');
        $this->pdf->Cell(150,0);
        $this->pdf->Cell(30,0,'Diferencia: ');
        $this->pdf->Cell(10,0,number_format($this->diferenciaestado,2,'.',''),0,1,'R');
        $this->pdf->Ln(10);
        $this->pdf->Cell(50,0,'Cargos sin conciliar + : ');
        $this->pdf->Cell(10,0,number_format($this->cargossinconcialiar,2,'.',''),0,1,'R');
        $this->pdf->Ln(10);
        $this->pdf->Cell(50,0,'Abonos sin conciliar - : ');
        $this->pdf->Cell(10,0,number_format($this->abonossinconciliar,2,'.',''),0,1,'R');
        $this->pdf->Ln(10);
        $this->pdf->Cell(50,0,'Saldo libros = : ');
        $this->pdf->Cell(10,0,number_format($this->saldolibros,2,'.',''),0,1,'R');
        $this->pdf->Ln(10);
        $y=$this->pdf->GetY();
        $this->pdf->SetWidths(array(13,17,15,23,30,30,10,20,20,23));
        $this->Rowpdf(array(utf8_decode('Tipo póliza'),'Num banco','Num mov','Fecha','Beneficiario','Concepto','+/-','Monto','Cobrado','Fecha cobro'));
        $this->pdf->Line(5,$y+3,250,$y+3);
        $this->pdf->Ln(7);
        $this->pdf->SetFont('Helvetica','',8);
        for($i=0;$i<count($this->valores);$i++)
        { 

            if($this->valores[$i]['tipo_mov'] == '')
            {

            }
            else
            {
                $renglony=$this->Rowpdf(array(
                    $this->valores[$i]['tipo_mov'],
                    $this->valores[$i]['no_banco'],
                    $this->valores[$i]['no_mov'],
                    date('d-m-Y',strtotime($this->valores[$i]['fecha'])),
                    $this->valores[$i]['beneficia'],
                    $this->valores[$i]['concepto'],
                    $this->valores[$i]['c_a'],
                    $this->valores[$i]['monto'],
                    $this->valores[$i]['cobrado'],
                    date('d-m-Y',strtotime($this->valores[$i]['fechaCobro']))
                   ));
                    $this->pdf->SetY($renglony-3.5);
                    $this->pdf->Ln(4);
            }
       
         }

        $this->pdf->Output('I','conciliacionbancaria.pdf');

    }
    public function ReportePolizaDiaria($id)
    {
        $this->rowc = $this->configura->getConfig();
        $this->datos = $this->opera->datosOpera($id);
        $this->detalle = $this->opera->detallepoliza($id);

        $this->pdf->SetAutoPageBreak(true,10);
        $this->pdf->AddPage();
        $this->pdf->SetTitle(utf8_decode('Reporte de Póliza'));
        $this->pdf->SetFillColor(220,220,220);
        $this->pdf->SetDrawColor(220,220,220);

        $this->encabezado();

        $this->pdf->Cell(200,5,'ASIENTO CONTABLE',0,1,'C',1);
        $this->pdf->Ln(10);
        $this->pdf->SetWidths(array(15,30,13,32,60,20,40,20));
        $this->Rowpdf(array('Cuenta','Referencia','Fact','Nombre de cuenta','Concepto','Cargos','Abonos'));
        $this->pdf->Ln(10);

        $totalcargos = 0;
        $totalabono = 0;

        for($i=0; $i<count($this->detalle); $i++)
        {
            if($this->detalle[$i]['c_a'] == '+')
            {
               $renglony = $this->Rowpdf(array($this->detalle[$i]['cuenta'],$this->detalle[$i]['referencia'],$this->detalle[$i]['factrefe'],$this->detalle[$i]['nombre_cuenta'],$this->detalle[$i]['concepto'],$this->detalle[$i]['monto'],''));
               $totalcargos = $totalcargos + $this->detalle[$i]['monto'];
               $this->pdf->SetY($renglony-3.5);
            }
            else
            {
               $renglony = $this->Rowpdf(array($this->detalle[$i]['cuenta'],$this->detalle[$i]['referencia'],$this->detalle[$i]['factrefe'],$this->detalle[$i]['nombre_cuenta'],$this->detalle[$i]['concepto'],'',$this->detalle[$i]['monto']));
               $totalabono = $totalabono + $this->detalle[$i]['monto'];
               $this->pdf->SetY($renglony-3.5);
            }
            $this->pdf->Ln(5);
       }
       $this->pdf->Ln(1);
       $this->pdf->Cell(135);
       $this->pdf->Cell(10,3,'___________________________________');
       $this->pdf->Ln(5);
       $this->pdf->Cell(115);
       $this->pdf->SetWidths(array(30,30,30));
       $this->Rowpdf(array('TOTAL',number_format($totalcargos,2,'.',''),number_format($totalabono,2,'.','')));
       $this->pdf->Output('I','Reportepolizas.pdf');
    }
    public function Reportecuenta()
    {

        date_default_timezone_set("America/Mexico_City");

        $this->pdf->AliasNbPages();
        $this->pdf->SetAutoPageBreak(true,10);
        $this->pdf->AddPage();
        $this->pdf->SetFillColor(220,220,220);
        $this->pdf->SetDrawColor(220,220,220);
        $this->pdf->SetFont('Helvetica','B',17);
        $this->pdf->SetTitle('Reporte Cuenta');
        $this->pdf->Cell(0,3,utf8_decode('CUENTAS'),'',0,'C');
        $this->pdf->SetFont('Helvetica','B',10);
        $this->pdf->Ln(8);
        $this->pdf->Cell(0,1,'Fecha: ' .date('d-m-Y H:i:s'));
        $this->pdf->Ln(9);

        $cuentas=$this->cuentas->getCuentas();

        //$this->pdf->SetWidths(array(20,25,35,20,20,25,25,25));
        $this->pdf->SetFont('Helvetica','B',9.5);
        $this->pdf->SetX(5);
        $this->pdf->Cell(20,5,'Cuenta',0, 0,'C',1);
        $this->pdf->Cell(25,5,'Sub Cuenta',0, 0,'C',1);
        $this->pdf->Cell(39,5,'Nombre',0, 0,'C',1);
        $this->pdf->Cell(20,5,'Tipo',0, 0,'C',1);
        $this->pdf->Cell(20,5,'Cta SAT',0, 0,'C',1);
        $this->pdf->Cell(25,5,'Naturalera',0, 0,'C',1);
        $this->pdf->Cell(25,5,'Clave Cobro',0, 0,'C',1);
        $this->pdf->Cell(25,5,'Ssub Cuenta',0, 0,'C',1);
        //$this->pdf->Row(array('Cuenta','Sub Cuenta','Nombre','Tipo','Cta SAT','Naturaleza','Clave Cobro','Ssub Cuenta'),'',1);
        $this->pdf->Ln(9);
        $this->pdf->SetFont('Helvetica','',8);
        for($i=0;$i<count($cuentas);$i++)
        {
            $this->pdf->SetWidths(array(20,25,39));
            $this->pdf->SetX(5);
            $this->pdf->Row(array($cuentas[$i]['cuenta'],
                                  $cuentas[$i]['sub_cta']),'C');
                                  if(strlen($cuentas[$i]['nombre']) > 40)
                                    {
                                    $mitad1 = substr($cuentas[$i]['nombre'],0,35);
                                    $mitad2 = substr($cuentas[$i]['nombre'],36,200);

                                    $this->pdf->Cell(48,0,utf8_decode($mitad1),'',0,'L');
                                    $this->pdf->Ln(5);
                                    $this->pdf->Cell(48);
                                    $this->pdf->Cell(48,0,utf8_decode($mitad2),'',0,'L');
                                    }
                                    else
                                    {
                                    $this->pdf->Cell(48,0,utf8_decode($cuentas[$i]['nombre']),'',0,'L');
                                    }
             $this->pdf->SetWidths(array(20,20,25,25,25));
             $this->pdf->Row(array(                    
                                  $cuentas[$i]['tipo'],
                                  $cuentas[$i]['ctasat'],
                                  $cuentas[$i]['natur'],
                                  $cuentas[$i]['cvecobro'],
                                  $cuentas[$i]['ssub_cta']),'L');
            $this->pdf->Ln(6);
        }

        $this->pdf->Output('I','ReporteCuentas.pdf');
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