<?php

class EstadoCuenta extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('menuModel');
        $items=$this->menuModel->menus($_SESSION['tipo']);
        $this->multi_menu->set_items($items);
        $this->load->view('templates/header');
        $this->load->model('Configuraciones_model','configModel');
        $this->load->model('ConfigCuentasModel','configCuentas');
        $this->load->model('OperacionesModel','operaciones');
        $this->load->model('CuentasModel','cuentas');
         $this->load->library('Pdf');
    }

    public function index()
    {
        if($this->aauth->is_loggedin())
        {
            $permisos= $this->permisosForma($_SESSION['id'],18);
            if(isset($permisos) && $permisos['leer']=="1")
            {
                $errores=array();
                $rfc = $this->configModel->getConfig();
                $data=array('titulo'=>'Estado de cuenta','rfc' => $rfc[0]['rfc'],'razon'=>$this->validaempresas->get_razon($_SESSION['idEmpresa']),'errores'=>$errores,'permisosGrupo'=>$permisos);
                // $items=$this->menuModel->menus($_SESSION['tipo']);
                // $this->multi_menu->set_items($items);
                $this->load->view('templates/header');
                $this->load->view('templates/navigation',$data);
                $this->load->view('reportesespe/estadocuenta');
                $this->load->view('templates/footer');
            }
            else
            {
                redirect('welcome', 'refresh');
            }
        }
        else
        {
            redirect('/inicio/login','refresh');
        }
    }
    public function imprimir()
    {

            $this->rowc = $this->configModel->getConfig();

        // $this->cuenta = $this->input->post('cuenta');
        // $this->subcun = $this->input->post('subcuenta');
        // $this->subcun2 = $this->input->post('subcuenta2');

        $this->fechaini = $this->input->post('fechaini');
        $this->fechafin = $this->input->post('fechafin');

        $valor5 = $this->input->post('acude');
        if($valor5 == 1)
        {
           $acude = true;
           $descripcion = 'ACUMULADO';
        }
        else
        {
           $acude = '';
           $descripcion = 'DETALLADO';
        }
        //funcion que se obtiene de ConfigCuentasModel de la carpeta models, se le pasa el id de la cuenta cliente que se obtiene de la tabla de configuraciones para obtener el numero de cuenta
        $this->cuentacliente = $this->configCuentas->getidcuentaconfi(9);

        //funcion que se obtiene de OperacionesModel de la carpeta models, se le pasan los parametros de cuenta, subcuenta, subcuenta2, fecha inicio, fecha fin y acumulado o detallado
        $this->datosdetalle = $this->operaciones->detalleEstadocuenta($this->cuentacliente[0]['cuenta'],$this->fechaini,$this->fechafin,$acude);


        $this->pdf->SetAutoPageBreak(true,10);
        $this->pdf->AddPAge();
        $this->pdf->SetTitle('Estado de cuenta');
        $this->pdf->SetFillColor(220,220,220);
        $this->pdf->SetDrawColor(220,220,220);

        $this->encabezado($descripcion);

        $this->pdf->Ln(15);

        if($acude == true)
        {
          $this->pdf->Cell(55,5,'Cuenta',0,1,'',true);
        }
         else
        {
          $this->pdf->Cell(55,5,'Referencia',0,1,'',true);
        }
            $this->pdf->SetY(55);
        $this->pdf->SetCol(0.8);
        $this->pdf->Cell(55,5,'Cargo',0,1,'',true);
        $this->pdf->SetY(55);
        $this->pdf->SetCol(1.5);
        $this->pdf->Cell(55,5,'Abono',0,1,'',true);
        $this->pdf->SetY(55);
        $this->pdf->SetCol(2.3);
        $this->pdf->Cell(47,5,'Saldo',0,1,'',true);
        $this->pdf->Ln(5);
        $totalcargo = 0;
        $totalabono = 0;
        $this->pdf->SetFont('Helvetica','',8);
        for($i=0;$i<count($this->datosdetalle);$i++)
        {

                $totalcargo = $totalcargo + $this->datosdetalle[$i]->cargo;
                $totalabono = $totalabono + $this->datosdetalle[$i]->abono;
                $this->pdf->SetCol(0);
                if($acude == true)
                {
                   $this->pdf->Cell(17,0,$this->datosdetalle[$i]->cuenta.' - '.$this->datosdetalle[$i]->sub_cta.' - '.$this->datosdetalle[$i]->ssub_cta,0,1,'R'); 
                }
                else
                {
                   $this->pdf->Cell(17,0,$this->datosdetalle[$i]->referencia,0,1,'L');
                }
                //$this->pdf->Cell(17,0,$this->datosdetalle[$i]->referencia,0,1,'L');
                $this->pdf->SetCol(0.8);    
                $this->pdf->Cell(17,0,number_format($this->datosdetalle[$i]->cargo,2,'.',','),0,1,'R');
                $this->pdf->SetCol(1.5);    
                $this->pdf->Cell(17,0,number_format($this->datosdetalle[$i]->abono,2,'.',','),0,1,'R');
                $this->pdf->SetCol(2.3);
                $this->pdf->Cell(17,0,number_format($this->datosdetalle[$i]->cargo-$this->datosdetalle[$i]->abono,2,'.',','),0,1,'R');                    
                $this->pdf->Ln(5);
            //}            
        }

        $this->pdf->Ln(10);
       $this->pdf->SetCol(0.0);
        $totales = $totalcargo - $totalabono;
        $this->pdf->Cell(50);
         $this->pdf->SetFont('Helvetica','B',10);
        $this->pdf->Cell(30,0,'Totales: '.number_format($totalcargo,2,'.',','),0,0,'L');
        $this->pdf->Cell(15);
        $this->pdf->Cell(10,0,'-   '.number_format($totalabono,2,'.',',').' =',0,0,'L');
        $this->pdf->Cell(22);
        $this->pdf->Cell(10,0,number_format($totales,2,'.',','),0,0,'L');
        $this->pdf->Ln(5);
      


        $this->pdf->footer2();

        $this->pdf->Output('I','EstadoCuenta.pdf');
    }
    public function encabezado($descripcion)
    {
        date_default_timezone_set("America/Mexico_City");
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
        $this->pdf->Cell(10,0,'Estado de cuenta: '.$descripcion);
        $this->pdf->Ln(5);
        $this->pdf->Cell(70);
        $this->pdf->SetFont('Helvetica','B',10);
        $this->pdf->Cell(10,0,'Del: '.date('d-m-Y',strtotime($this->fechaini)).' Al '.date('d-m-Y',strtotime($this->fechafin)));
        $this->pdf->Ln(5);
        // $this->pdf->Cell(70);
        // $this->pdf->SetFont('Helvetica','B',10);
       // $this->pdf->Cell(10,0,'Cuenta: '.$this->datoscuenta[0]['cuenta'].' - '.$this->datoscuenta[0]['sub_cta'].' - '.$this->datoscuenta[0]['ssub_cta']);
       // $this->pdf->Cell(10,0,'Cuenta: '.$this->datoscuenta[0]['nombre']);
        
    }
}