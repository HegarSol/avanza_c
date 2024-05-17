<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('menuModel');
        $items=$this->menuModel->menus($_SESSION['tipo']);
        $this->multi_menu->set_items($items);
        $this->load->view('templates/header');
        $this->load->model('BancosModel','bancos');
        $this->load->model('OperacionesModel','opera');
        $this->load->model('EmpresasModel','empresas');
    }
    public function index($id)
    {
        if($this->aauth->is_loggedin())
        {
            $errores=array();
            $datosbanco = $this->bancos->datosBancos($id);
            $data=array('titulo'=>'Importación de archivos (nómina)','no_banco'=>$id,'datosbanco'=> $datosbanco,'razon'=>$this->validaempresas->get_razon($_SESSION['idEmpresa']),'errores'=>$errores);
            $items=$this->menuModel->menus($_SESSION['tipo']);
            $this->multi_menu->set_items($items);
            $this->load->view('templates/header');
            $this->load->view('templates/navigation',$data);
            $this->load->view('importan/index');
            $this->load->view('templates/footer');
        }
        else
        {
            redirect('/inicio/login','refresh');
        }
    }
    public function getNomina()
    {
        $id = $this->input->post('id');
        $fechap = $this->input->post('fechap');
        $configNueva=$this->empresas->datosEmpresa($_SESSION['idEmpresa']);


        if(ENVIRONMENT == 'development')
        {
           $ch = curl_init("http://localhost:8000/ajuste/show?idEmpresa=".$configNueva[0]['idNomina']."&fechapago=".$fechap);
        }
        else
        {
           $ch = curl_init("http://avanzan.hegarss.com/ajuste/show?idEmpresa=".$configNueva[0]['idNomina']."&fechapago=".$fechap);
        }              
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $resu = curl_exec($ch);
        $response = json_decode($resu);

       $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function insertpolizar()
    {
        $chek = $this->input->post('chek');
        $concep = $this->input->post('concep');
        $refe = $this->input->post('refe');
        $idbanco = $this->input->post('id');

        // var_dump($concep);
        // var_dump($refe);
        // var_dump($idbanco);



        foreach($chek as $checar)
        {
            $datos=$this->bancos->datosBancos($idbanco);

            if($checar[0] == 'Transferencia')
            {
                $tipo = 'T';
                var_dump($datos[0]['movimiento']);
            }
            else
            {
                $tipo = 'C';
                var_dump($datos[0]['cheques']);

            }
           //tipooperacion $checar[0];
           //nombre $checar[1];
           //sueldo $checar[2];
           //vacaciones $checar[3];
           //aguinaldo $checar[4];
           //ptu $checar[5];
           //otras_perce $checar[6];
           //prima_vaca $checar[7];
           //isr $checar[8];
           //imss $checar[9];
           //infonavit $checar[10];
           //total $checar[11];



        }



    }
}