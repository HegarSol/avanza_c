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

        $items=$this->menuModel->menus($_SESSION['tipo']);
        if($items[23]['mante'] == 1)
        {
                $data=array('titulo'=>'No disponible por el momento');
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


        $fechaini = $this->input->post('fechaini');

        $datosfecha = explode('-',$fechaini);

        $anol = $datosfecha[0];
        $mese = $datosfecha[1];

        $databalanze = $this->operaciones->balancegeneral($fechaini,$pnCa2);

        $tf0 = $anol.'-01-01';

        $tfi = date($anol.'-'.$mese.'-01');

        $L = new DateTime( $tfi ); 
        $tff = $L->format( 'Y-m-t' );

        $dataestado = $this->cuentas->getestadoresultado($tf0,$tfi,$tff);

        foreach($dataestado as $row)
        {
             $databalanze[] = (object) array('cuenta' => $pnUN, 'sub_cta' => $pnUN2, 'saldo' => $row->sini+$row->periodo);
        }

      //  var_dump($databalanze);

      $tActivoC = 0;
      $tActivoF = 0;
      $tActivoO = 0;
      $tPasivoC = 0;
      $tPasivoF = 0;
      $tCapital = 0;

        foreach($databalanze as $row2)
        {
 
            var_dump($row2);
           // echo "<br>";
            if($row2->cuenta >= $pnPC && $row2->cuenta <= $pnPF2)
            {
                $row2->saldo = $row2->saldo * -1;
            }

            if($row2->cuenta == $pnCa && $row2->cuenta == $pnCa2)
            {
                $row2->saldo = $row2->saldo * -1;
            }

          //  var_dump($row2);
            echo "<br>";
            // if($row2['cuenta'] == $pnAC && $row2['sub_cta'] == $pnAC2)
            // {
            //     $tActivoC =+ $row2['saldo'];
            // }
            // if($row2['cuenta'] == $pnAF && $row2['sub_cta'] == $pnAF2)
            // {
            //     $tActivoF =+ $row2['saldo'];
            // }
            // if($row2['cuenta'] == $pnOA && $row2['sub_cta'] == $pnOA2)
            // {
            //     $tActivoO =+ $row2['saldo'];
            // }
            // if($row2['cuenta'] == $pnPC && $row2['sub_cta'] == $pnPC2)
            // {
            //     $tPasivoC =+ $row2['saldo'];
            // }
            // if($row2['cuenta'] == $pnPF && $row2['sub_cta'] == $pnPF2)
            // {
            //     $tPasivoF =+ $row2['saldo'];
            // }
            // if($row2['cuenta'] == $pnCa && $row2['sub_cta'] == $pnCa2)
            // {
            //     $tCapital =+ $row2['saldo'];
            // }
        }

    }
}