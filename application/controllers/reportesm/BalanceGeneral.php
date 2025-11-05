<?php

class BalanceGeneral extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('menuModel');
        $items=$this->menuModel->menus($_SESSION['tipo']);
        $this->multi_menu->set_items($items);
        $this->load->view('templates/header');
        $this->load->model('Configuraciones_model','configModel');
        $this->load->model('OperacionesModel','operaciones');
        $this->load->model('CuentasModel','cuentas');
        $this->load->model('ConfigCuentasModel','conficue');
        $this->load->library('Pdf');
    }

    public function index()
    {

        $items2=$this->menuModel->menusdisponibles();
        if($items2[23]['mante'] == 1)
        {
                $data=array('titulo'=>'No disponible por el momento');
                $items=$this->menuModel->menus($_SESSION['tipo']);
                $this->multi_menu->set_items($items);
                $this->load->view('templates/header');
                $this->load->view('templates/navigation',$data);
                $this->load->view('nodisponible');
                $this->load->view('templates/footer');

        }
        else
        {
            if($this->aauth->is_loggedin())
            {
                $errores=array();
                $rfc = $this->configModel->getConfig();
                $permisos=$this->permisosForma($_SESSION['id'],1);
                $data=array('titulo'=>'Reporte balance general','rfc' => $rfc[0]['rfc'],'razon' => $this->validaempresas->get_razon($_SESSION['idEmpresa']),'errores'=>$errores,'permisosGrupo'=>$permisos);
                $items=$this->menuModel->menus($_SESSION['tipo']);
                $this->multi_menu->set_items($items);
                $this->load->view('templates/header');
                $this->load->view('templates/navigation',$data);
                $this->load->view('reportes/reportebalancegeneral');
                $this->load->view('templates/footer');
            }
            else
            {
                redirect('inicio/login','refresh');
            }
        }
    }
    public function imprimir()
    {

        $dta = $this->conficue->getidcuentaconfi(17);
        $pnAC = $dta[0]['cuenta'];
        $pnAC2 = $dta[0]['sub_cta'];
        $dta1 = $this->conficue->getidcuentaconfi(18);
        $pnAF = $dta1[0]['cuenta'];
        $pnAF2 = $dta1[0]['sub_cta'];
        $dta2 = $this->conficue->getidcuentaconfi(19);
        $pnOA = $dta2[0]['cuenta'];
        $pnOA2 = $dta2[0]['sub_cta'];
        $dta3 = $this->conficue->getidcuentaconfi(20);
        $pnPC = $dta3[0]['cuenta'];
        $pnPC2 = $dta3[0]['sub_cta'];
        $dta4 = $this->conficue->getidcuentaconfi(21);
        $pnPF = $dta4[0]['cuenta'];
        $pnPF2 = $dta4[0]['sub_cta'];
        $dta5 = $this->conficue->getidcuentaconfi(22);
        $pnCa = $dta5[0]['cuenta'];
        $pnCa2 = $dta5[0]['sub_cta'];
        $dta6 = $this->conficue->getidcuentaconfi(23);
        $pnUN = $dta6[0]['cuenta'];
        $pnUN2 = $dta6[0]['sub_cta'];
        $dta7 = $this->conficue->getidcuentaconfi(24);
        $pnCtaIng = $dta7[0]['cuenta'];
        $pnCtaIng2 = $dta7[0]['sub_cta'];
        $dta8 = $this->conficue->getidcuentaconfi(25);
        $pnCtaEgr = $dta8[0]['cuenta'];
        $dta9 = $this->conficue->getidcuentaconfi(27);
        $pnCtaEgr2 = $dta9[0]['sub_cta'];


        $fecha = $this->input->post('fechaini');
        /// obtener el ultimo día del mes
        $ultimoDia = date("Y-m-t", strtotime($fecha));
        $databalanze = $this->operaciones->balancegeneral($ultimoDia,$pnCa2);
        $datosfecha = explode('-',$fecha);

        $anol = $datosfecha[0];
        $mese = $datosfecha[1];

        

        $tf0 = $anol.'-01-01';

        $tfi = date($anol.'-'.$mese.'-01');

        $L = new DateTime( $tfi ); 
        $tff = $L->format( 'Y-m-t' );

        $dataestado = $this->cuentas->getestadoresultado($tf0,$tfi,$tff);
        $erSaldo = 0;
        foreach($dataestado as $row)
        {
            $erSaldo += $row->sini + $row->periodo;
        }
         $databalanze[] = (object) array('cuenta' => $pnUN, 'sub_cta' => $pnUN2,'nombre' => 'Resultado del ejercicio', 'saldo' => $erSaldo);
      //  var_dump($databalanze);

      $tActivoC = 0;
      $tActivoF = 0;
      $tActivoO = 0;
      $tPasivoC = 0;
      $tPasivoF = 0;
      $tCapital = 0;

$this->pdf->SetAutoPageBreak(true,10);
          $this->pdf->AddPage();
          $this->pdf->SetTitle('Balanza de comprobación');
          $this->pdf->SetFillColor(220,220,220);
          $this->pdf->SetDrawColor(220,220,220);

          $this->encabezado();

          $this->pdf->SetFont('Helvetica','B',8);
          $this->pdf->Ln(10);
          
          $this->pdf->SetY(55);
          $this->pdf->SetCol(0.6);
          $this->pdf->Cell(70,5,'Nombre',0,0,'');
          $this->pdf->SetY(55);
         $this->pdf->SetCol(2.2);
          $this->pdf->Cell(17,5,'Monto',0,0,'');
        $this->pdf->Ln(5);
          $this->pdf->SetCol(.1);
          $this->pdf->Cell(17,5,'ACTIVO',0,0,'');
        $this->pdf->Ln(5);
          $this->pdf->SetCol(.2);
          $this->pdf->Cell(17,5,'CIRCULANTE',0,0,'');
        
         $this->pdf->SetCol(0.1);
          $this->pdf->Ln(10);
//          $this->pdf->SetWidths(array(26,50,30,20,25,25,20));
          $this->pdf->SetFont('Helvetica','',8);
          $baf = 0;
          $boa = 0;
        $bpc = 0;
          $bpf = 0;
          $bc = 0;      

            



          
        foreach($databalanze as $row2)
        {
            if(($row2->cuenta >= $pnPC && $row2->cuenta <= $pnPF2) || ($row2->cuenta >= $pnCa && $row2->sub_cta <= $pnCa2))
            {
                $row2->saldo = $row2->saldo * -1;
            }
            if($row2->cuenta >= $pnAC && $row2->cuenta <= $pnAC2)
            {
                $tActivoC += $row2->saldo;
            }

            if(($row2->cuenta >= $pnAF && $row2->cuenta <= $pnAF2) || ($row2->cuenta > $pnAF2 && $row2->cuenta < $pnOA2))
            {
                
                if($baf == 0)
                {   
                    $this->pdf->SetFont('Helvetica','B',8);
                    $this->pdf->Cell(35);
                    // format number with commas
                   // $this->pdf->Cell(0,5,'Total activo circulante:',0,0,'R',true);
                    $this->pdf->Cell(115,5,number_format($tActivoC, 2),0,0,'R');
                    $baf = 1;
                    $this->pdf->Ln(10);
                    $this->pdf->Cell(8);
                    $this->pdf->Cell(0,0,'FIJO:',0,0,'');
                    $this->pdf->Ln(5);
                    $this->pdf->SetFont('Helvetica','',8);
                }
                 if($row2->cuenta >= $pnAF && $row2->cuenta <= $pnAF2)
                {
                $tActivoF += $row2->saldo;
                }
            }
            if($row2->cuenta >= $pnOA && $row2->cuenta <= $pnOA2)
            {
                 if($boa == 0)
                {   
                     $this->pdf->SetFont('Helvetica','B',8);
                    $this->pdf->Cell(35);
                    $this->pdf->Cell(115,5,number_format($tActivoF, 2),0,0,'R');
                    $boa = 1;
                    $this->pdf->Ln(10);
                    $this->pdf->Cell(8);
                    $this->pdf->Cell(0,0,'OTROS ACTIVOS:',0,0,'',true);
                     $this->pdf->SetFont('Helvetica','',8);
                    $this->pdf->Ln(5);
                }
                $tActivoO += $row2->saldo;
            }
            if($row2->cuenta >= $pnPC && $row2->cuenta <= $pnPC2)
            {
                 if($bpc == 0)
                 {
                     $this->pdf->SetFont('Helvetica','B',9);
                    $this->pdf->Cell(35);
                    $this->pdf->Cell(115,5,number_format($tActivoO, 2),0,0,'R');
                    $this->pdf->Ln(10);
                    $this->pdf->setcol(.9);
                    $this->pdf->cell(20,5,'TOTAL ACTIVO:',0,0,'');
                    $this->pdf->SetCol(2.16);
                    $this->pdf->Cell(30,5,number_format($tActivoC + $tActivoF + $tActivoO, 2),0,0,'R');
                       $this->pdf->SetFont('Helvetica','B',8);
                    $this->pdf->Cell(35);
                    $bpc = 1;
                    $this->pdf->Ln(10);
                    $this->pdf->Cell(8);
                    $this->pdf->SetCol(.1);
                    $this->pdf->Cell(0,5,'PASIVO',0,0,'');
                    $this->pdf->Ln(10);
                      $this->pdf->SetCol(.2);
                    $this->pdf->Cell(17,5,'CIRCULANTE',0,0,'');
                    $this->pdf->SetCol(0.1);
                     $this->pdf->SetFont('Helvetica','',8);
                    $this->pdf->Ln(10);
                }
                $tPasivoC += $row2->saldo;
            }
            if(($row2->cuenta >= $pnPF && $row2->cuenta <= $pnPF2) || ($row2->cuenta > $pnPF2 && $row2->cuenta < $pnCa2))
            {
                    if($bpf == 0)
                    {   
                        $this->pdf->Cell(35);
                        $this->pdf->SetCol(2.16);
                        $this->pdf->SetFont('Helvetica','B',8);
                        $this->pdf->Cell(115,5,number_format($tPasivoC, 2),0,0,'');
                        $bpf = 1;
                        $this->pdf->Ln(5);
                        $this->pdf->SetCol(.2);
                        $this->pdf->Cell(17,5,'NO CIRCULANTE:',0,0,'');
                        $this->pdf->SetFont('Helvetica','',8);
                        $this->pdf->Ln(5);
                    }
                    if($row2->cuenta >= $pnPF && $row2->cuenta <= $pnPF2)
            {
                $tPasivoF += $row2->saldo;
            }
            }
            if($row2->cuenta >= $pnCa && $row2->cuenta <= $pnCa2)
            {
                  if($bc == 0)
                    {   
                        $this->pdf->Cell(35);
                         $this->pdf->SetFont('Helvetica','B',8);
                        $this->pdf->Cell(109,5,number_format($tPasivoF, 2),0,0,'R');
                        $bc = 1;
                        $this->pdf->Ln(5);
                        $this->pdf->SetCol(.1);
                        $this->pdf->Cell(17,5,'CAPITAL',0,0,'');
                         $this->pdf->SetFont('Helvetica','',8);
                        $this->pdf->Ln(5);
                    }
                $tCapital += $row2->saldo;
            }
                 $this->pdf->Cell(20);
                $this->pdf->Cell(0,0,$row2->cuenta,0,1,'');
                $this->pdf->Cell(35);
                $this->pdf->Cell(0,0,$row2->nombre,0,1,'');

                $this->pdf->Cell(35);
                $this->pdf->Cell(115,0,number_format($row2->saldo, 2),0,1,'R');
                $this->pdf->Ln(5);
        }
        // toal de capital
            $this->pdf->Cell(35);
            $this->pdf->SetFont('Helvetica','B',8);
            $this->pdf->Cell(115,5,number_format($tCapital, 2),0,0,'R');
             $this->pdf->SetFont('Helvetica','',8);
            $this->pdf->Ln(10);
            $this->pdf->SetFont('Helvetica','B',9);
            $this->pdf->setcol(.9);
                    $this->pdf->cell(20,5,'TOTAL PASIVO + CAPITAL:',0,0,'');
                    $this->pdf->SetCol(2.16);
                    $this->pdf->Cell(30,5,number_format($tPasivoC + $tPasivoF + $tCapital, 2),0,0,'R');
                       $this->pdf->SetFont('Helvetica','B',8);

        $this->pdf->footer2();
          $this->pdf->Output('I','ReporteBalanceGeneral.pdf');

    }
    public function encabezado()
    {
        $this->rowc = $this->configModel->getConfig();
      //  date_default_timezone_set("America/Mexico_City");
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
          $this->pdf->Image(APPPATH . 'public'.DIRECTORY_SEPARATOR.'Logo_' . $this->rowc[0]['rfc'] .'.'.$formato[1],2,2,80,50);
        }

        $this->pdf->SetFont('Helvetica','B',15);
        $this->pdf->Cell(70);
        $this->pdf->Cell(10,0,$this->rowc[0]['nombreEmpresa'],0,0,'L');
        $this->pdf->Ln(20);
        $this->pdf->Cell(70);
        $this->pdf->SetFont('Helvetica','B',10);
        $this->pdf->Cell(10,0,'Reporte: Balance general');
        $this->pdf->Ln(5);
        $this->pdf->Cell(70);
        $this->pdf->SetFont('Helvetica','B',10);
        $this->pdf->Cell(10,0,'Periodo: '.$this->input->post('fechaini'));
        
    }
}