<?php

class DeptosCostos extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('menuModel');
        $items=$this->menuModel->menus($_SESSION['tipo']);
        $this->multi_menu->set_items($items);
        $this->load->view('templates/header');
        $this->load->model('DepartamentoCostosModel','depacoto');
    }
    public function index()
    {
        if($this->aauth->is_loggedin())
        {
            $permisos = $this->permisosForma($_SESSION['id'],13);
            if(isset($permisos) && $permisos['leer'] == "1")
            {
                $data = array('titulo' => 'Departamento costos', 'permisosGrupo' => $permisos);
                $this->load->view('templates/navigation',$data);
                $this->load->view('departacostos/index');
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
    public function ajax_list()
    {
        $permisos = $this->permisosForma($_SESSION['id'],13);
        $edit = $permisos['edit'];
        $del = $permisos['del'];
        if($edit == "0"){$edit='class="disabled"';}else{$edit="";}
        if($del == "0"){$del='class="disabled"';}else{$del="";}


        $list = $this->depacoto->get_datatables();

        $data = array();

        foreach($list as $depa)
        {
            $row = array();
            $row[] = $depa->id;
            $row[] = $depa->clave;
            $row[] = $depa->descripcion;
            $row[] = $depa->matriz;
            $row[] = '<a href="'.base_url().'/catalogos/DeptosCostos/editar/'.$depa->id.'" '.$edit.' class="btn btn-primary" title="Editar departamento costos"><i class="fa fa-pencil-square-o"></i></a>';
            $data[] = $row;
        }

        $output =  array(
            'draw' => $this->input->post('draw'),
            'recordsTotal' => $this->depacoto->count_all(),
            'recordsFiltered' => $this->depacoto->count_filtered(),
            'data' => $data
         );
         $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function agregar()
    {
        if($this->aauth->is_loggedin())
        {
            $permisos = $this->permisosForma($_SESSION['id'],13);
            if(isset($permisos) && $permisos['add'] == "1")
            {
                $data = array('titulo' => 'Agregar departamento costos','accion'=>'catalogos/DeptosCostos/guardarcostos','permisosGrupo' => $permisos);
                $this->load->view('templates/navigation',$data);
                $this->load->view('departacostos/departacostos');
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
    public function guardarcostos()
    {

    }
}