<?php

class Contrarecibos extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('menuModel');
        $items=$this->menuModel->menus($_SESSION['tipo']);
        $this->multi_menu->set_items($items);
        $this->load->view('templates/header');
        $this->load->model('ContrarecibosModel','contra');
        $this->load->model('OperacionesModel','opera');
        $this->load->model('BitacoraModel','bitacora');
        $this->load->model('BeneficiarioModel','benefi');
        $this->load->library('Pdf');
        $this->load->model('Configuraciones_model','configModel');
    }
    public function obtenercontrare()
    {
        $prov = $this->input->post('data');
        $ret = $this->contra->getall($prov);

        $data['comprobantes'] = $ret;
        $this->load->view('beneficiarios/contrarecibos/tabla',$data);
    }
    public function crearcontrareci()
    {
        $foli = $this->input->post('folio');
        $seri = $this->input->post('seri');
        $numpro = $this->input->post('numpro');
        $uuid = $this->input->post('uuid');

        $idsum = $this->configModel->getConfig();

        $valo = $this->contra->buscarcontrarecibo($foli,$seri,$numpro);

        $provi = $this->opera->getprovicion($foli,$seri,$uuid);

        if(count($valo) > 0)
        {
             $response = array('status' => false, 'error' => 'Ya se hizo el contra recibo de la factura seleccionada.');
        }
        else if(count($provi) == 0)
        {
            $response = array('status' => false, 'error' => 'Aún no se ha hecho una póliza de provisión para esta factura.');
        }
        else
        {
            $sumtori = $idsum[0]['id_contra'] + 1;

             $ch = curl_init("http://avanzab.hegarss.com/api/Comprobantes/actualicontra");
            //$ch = curl_init("http://localhost:85/getcfdi/api/Comprobantes/actualicontra");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, "uuid=".$uuid."&sumtori=".$sumtori);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $resu = curl_exec($ch);
            $response = json_decode($resu);
            
            $datos = array('proveedor'=>$numpro, 'fact'=>$foli, 'serie'=>$seri, 'no_contra'=>$sumtori, 'fechacreacion' => date('Y-m-d H:i:s'),'uuid_contra'=>$uuid);
            
            $dat = array('id_contra' => $sumtori);

            $this->configModel->editConfig(1,$dat);

            $this->contra->insertarcontra($datos);

            $crearopera = array('usuario' => $_SESSION['nombreU'],
                                                'tipo_mov' => $seri,
                                                'no_banco' => $numpro,
                                                'no_mov' => $foli,
                                                'accion' => 'Agregar',
                                                'cuando' => date('Y-m-d H:i:s'),
                                                'comentario' => 'Creo el contra recibo: '.$sumtori,
                                                'modulo' => 'Beneficiarios -> X pagar');
                              $this->bitacora->operacion($crearopera);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function pdf()
    {
        $folio = $_GET['folio'];
        $seri = $_GET['seri'];
        $uuid = $_GET['uuid'];
        $fecha = $_GET['fecha'];
        $total = $_GET['total'];
        $subto = $_GET['subt'];
        $iva = $_GET['iva'];
        $rfcemi = $_GET['rfcemi'];

        $val = $this->contra->getcontrarecbisoget($folio,$seri,$uuid);
        $provi = $this->opera->getprovicion($folio,$seri,$uuid);
        $configh = $this->configModel->getConfig();
      //  var_dump($provi);
        $detallecuenta = $this->opera->traerpolizaprovisiondetalle($provi[0]['no_mov']);
        $bene = $this->benefi->datosbenerfc($rfcemi);

        switch(date('m',strtotime($provi[0]['fecha'])))
        {
            case '01':
            $mes = 'Enero';
            break;
            case '02':
            $mes = 'Febrero';
            case '03':
            $mes = 'Marzo';
            break;
            case '04':
            $mes = 'Abril';
            break;
            case '05':
            $mes = 'Mayo';
            break;
            case '06':
            $mes = 'Junio';
            break;
            case '07':
            $mes = 'Julio';
            break;
            case '08':
            $mes = 'Agosto';
            break;
            case '09':
            $mes = 'Septiembre';
            break;
            case '10':
            $mes = 'Octubre';
            break;
            case '11':
            $mes = 'Noviembre';
            break;
            case '12':
            $mes = 'Diciembre';
            break;
        }

        switch(date('m',strtotime($fecha)))
        {
            case '01':
            $mesfac = 'Enero';
            break;
            case '02':
            $mesfac = 'Febrero';
            case '03':
            $mesfac = 'Marzo';
            break;
            case '04':
            $mesfac = 'Abril';
            break;
            case '05':
            $mesfac = 'Mayo';
            break;
            case '06':
            $mesfac = 'Junio';
            break;
            case '07':
            $mesfac = 'Julio';
            break;
            case '08':
            $mesfac = 'Agosto';
            break;
            case '09':
            $mesfac = 'Septiembre';
            break;
            case '10':
            $mesfac = 'Octubre';
            break;
            case '11':
            $mesfac = 'Noviembre';
            break;
            case '12':
            $mesfac = 'Diciembre';
            break;
        }

       $x = count($detallecuenta) * 37;
       if($x > 240)
       {
            $y = $x;
       }
       else
       {
            $y = 240;
       }

        $this->pdf->SetAutoPageBreak(true,10);
        $this->pdf->AddPage('P',array($y,110));
        $this->pdf->SetTitle(utf8_decode('Contra Recibo'));
        $this->pdf->SetFillColor(220,220,220);
        $this->pdf->SetDrawColor(220,220,220);

        date_default_timezone_set("America/Mexico_City");
        $this->pdf->SetFont('Helvetica','B',15);
        $this->pdf->Cell(18,5,'','',0,'L');
        $this->pdf->Ln(10);
        $this->pdf->SetFont('Helvetica','B',20);
        $this->pdf->Cell(90,5,utf8_decode($configh[0]['nombreEmpresa']),0,1,'C',0);
        $this->pdf->Ln(5);
        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->Cell(90,5,utf8_decode('Contra Recibo'),0,1,'C',0);
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->Ln(3);
        $this->pdf->SetFont('Helvetica','',10);
        $this->pdf->Cell(90,5,'Carretera a Piedras Negras Ka, 3.5',0,1,'C',0);
        $this->pdf->Cell(90,5,'Tels. y Fax '.$configh[0]['telefono'],0,1,'C',0);
        $this->pdf->Cell(90,5,'C.P,'.$configh[0]['cp'].','.$configh[0]['ciudad'].','.$configh[0]['estado'].' ',0,1,'C',0);
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Helvetica','B',20);
        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->Cell(90,0,'Folio: '.$provi[0]['no_mov'],0,1,'R',0);
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Helvetica','B',12);
        $this->pdf->Cell(90,0,date('d').' de '.$mes.' del '.date('Y'),0,1,'R',0);
        $this->pdf->Ln(5);
        $this->pdf->Cell(90,0,'Hora: '.date('H:i:s'),0,1,'R',0);
        $this->pdf->SetFont('Helvetica','',12);
        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->Ln(5);
        if(count($bene)>0)
        {
            $this->pdf->Cell(53,5,utf8_decode($bene[0]['nombre']),0,1,'R',0);
            $this->pdf->SetTextColor(0,0,0);
            $this->pdf->Cell(22,5,$bene[0]['direccion'].' '.$bene[0]['no_interior'].''.$bene[0]['no_exterior'],0,1,'R',0);
            $this->pdf->Cell(11,5,utf8_decode($bene[0]['colonia']),0,1,'R',0);
            $this->pdf->Cell(48,5,utf8_decode($bene[0]['ciudad']).','.utf8_decode($bene[0]['estado']),0,1,'R',0);
            $this->pdf->Cell(22,5,$bene[0]['telefono'],0,1,'R',0);
        }
        else
        {
            $this->pdf->Cell(53,5,'',0,1,'R',0);
            $this->pdf->SetTextColor(0,0,0);
            $this->pdf->Cell(22,5,'',0,1,'R',0);
            $this->pdf->Cell(11,5,'',0,1,'R',0);
            $this->pdf->Cell(48,5,'',0,1,'R',0);
            $this->pdf->Cell(22,5,'',0,1,'R',0);

             

        }
        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->Cell(90,5,'Documento: '.$seri.$folio,0,1,'R',0);
        $this->pdf->Cell(90,5,'Fecha: '.date('d',strtotime($fecha)).'/'.$mesfac.'/'.date('y',strtotime($fecha)),0,1,'R',0);
        $this->pdf->Ln(5);
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetWidths(array(37,25,35));
        $this->pdf->Cell(15,0,'Cuenta',0,1,'R',0);
        $this->pdf->Cell(50,0,'Cantidad',0,1,'R',0);
        $this->pdf->Cell(90,0,'T   o   t   a   l',0,1,'R',0);
        $this->pdf->Ln(5);

        for($i=0;$i<count($detallecuenta); $i++)
        {

            $this->pdf->Cell(15,0,$detallecuenta[$i]['cuenta'].'-'.$detallecuenta[$i]['sub_cta'],0,1,'R',0);
            $this->pdf->Cell(50,0,'1.00',0,1,'R',0);
            $this->pdf->Cell(90,0,$detallecuenta[$i]['monto'],0,1,'R',0);
            $this->pdf->Ln(4);
            $this->pdf->Cell(50,0,utf8_decode($detallecuenta[$i]['nombre_cuenta']),0,1,'L',0);
            $this->pdf->Ln(5);
        }

        

        $this->pdf->Ln(10);
        $this->pdf->Cell(50,0,'Subtotal. . .',0,1,'R',0);
        $this->pdf->Cell(89,0,number_format($subto,2,'.',''),0,1,'R');
        $this->pdf->Ln(5);
        $this->pdf->Cell(50,0,'I.V.A........',0,1,'R',0);
        $this->pdf->Cell(89,0,number_format($iva,2,'.',''),0,1,'R',0);
        $this->pdf->Ln(5);
        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->Cell(50,0,'T o t a l....',0,1,'R',0);
        $this->pdf->Cell(89,0,number_format($total,2,'.',''),0,1,'R',0);
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Helvetica','',9);
        $this->pdf->Cell(75,4,'('.$this->pdf->num2letras(number_format($total,2,'.',''),'MXN').')','',1,'R');
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->Ln(30);
        $this->pdf->Cell(10,3,'Firma Autorizada:_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _');

        $this->pdf->Output('I','ContraRecibos.pdf');
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