<?php

class Conciliacion extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('menuModel');
        $items=$this->menuModel->menus($_SESSION['tipo']);
        $this->multi_menu->set_items($items);
        $this->load->view('templates/header');
        $this->load->model('BancosModel','bancos');
    }

    public function index($id)
    {
        $permisos = $this->permisosForma($_SESSION['id'],11);
        if(isset($permisos) && $permisos['leer'] == '1')
        {
            if($this->aauth->is_loggedin())
            {
                $errores=array();
                $datosbanco = $this->bancos->datosBancos($id);
                $data=array('titulo'=>'Conciliación bancaria','no_banco'=>$id,'datosbanco'=> $datosbanco,'razon'=>$this->validaempresas->get_razon($_SESSION['idEmpresa']),'errores'=>$errores,'permisosGrupo' => $permisos);
                $items=$this->menuModel->menus($_SESSION['tipo']);
                $this->multi_menu->set_items($items);
                $this->load->view('templates/header');
                $this->load->view('templates/navigation',$data);
                $this->load->view('conciliacion/index');
                $this->load->view('templates/footer');
            }
            else
            {
               redirect('/inicio/login','refresh');
            }
        }
        else
        {
            show_error('No tiene permiso para entrar a conciliacion');
        }

    }

    public function getdatosconciliacion()
    {
        $fechaini = $this->input->post('fechaini');
        $fechafin = $this->input->post('fechafin');
        $no_banco =  $this->input->post('no_banco');
        $tipo = $this->input->post('tipo');
        $mosmo = $this->input->post('mosmo');

        $data = $this->bancos->getconciliacion($fechaini,$fechafin,$tipo,$no_banco,$mosmo); 

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    public function actualizarconci()
    {
        $valor = $this->input->post('valor');
        $fecha = $this->input->post('fecha');
        $tipo = $this->input->post('tipo');
        $num_ban = $this->input->post('num_ban');
        $num_mov = $this->input->post('num_mov');

        $datos = array('cobrado'=>$valor,'fechaCobro'=>$fecha ? $fecha : null);

        $this->bancos->updatepoliza($tipo,$num_ban,$num_mov,$datos);
    }
}