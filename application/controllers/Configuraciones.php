<?php

class Configuraciones extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('menuModel');
        $items=$this->menuModel->menus($_SESSION['tipo']);
        $this->multi_menu->set_items($items);
        $this->load->view('templates/header');
        $this->load->model('ConfiguracionesGenemodel','configene');

    }

    public function index()
    {
        if($this->aauth->is_loggedin())
        {
             $permisos = $this->permisosForma($_SESSION['id'],10);
             if(isset($permisos) && $permisos['leer'] == "1")
             {

                $datosconf = $this->configene->getparent();
                $data = array('titulo' => 'Configuración sistema','permisosGrupo' => $permisos,'confige' => $datosconf);
                $this->load->view('templates/navigation',$data);
                $this->load->view('configuraciones');
                $this->load->view('templates/footer');
             }
             else
             {
                 redirect('welcome','refresh');
             }
        }
        else
        {
            redirect('inicio/login','refresh');
        }
    }
    public function getconfige()
    {
        $con = $this->input->post('confge');

        $data = $this->configene->buscarparent($con);

        $datas['configuragene'] = $data;

        $this->load->view('tablaConfi',$datas);
 
    }
    public function editconfig()
    {
        $valor = $this->input->post('valor');
        $inac = $this->input->post('inac');
        $id = $this->input->post('id');

        $datos = array('valor' => $valor,'inactiva' => $inac);

        $this->configene->editconf($id,$datos);
    }
}