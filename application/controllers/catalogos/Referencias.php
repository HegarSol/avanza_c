<?php

class Referencias extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('menuModel');
        $items=$this->menuModel->menus($_SESSION['tipo']);
        $this->multi_menu->set_items($items);
        $this->load->view('templates/header');
        $this->load->model('ReferenciasModel','refes');
    }
    public function index()
    {
        if($this->aauth->is_loggedin())
        {
            $permisos = $this->permisosForma($_SESSION['id'],14);
            if(isset($permisos) && $permisos['leer'] == "1")
            {
                $data = array('titulo' => 'Referencias control de gastos', 'permisosGrupo' => $permisos);
                $this->load->view('templates/navigation',$data);
                $this->load->view('referencias/index');
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


        $list = $this->refes->get_datatables();

        $data = array();

        foreach($list as $ref)
        {
            $row = array();
            $row[] = $ref->id;
            $row[] = $ref->referencia;
            $row[] = $ref->descripcion;
            $row[] = '<a href="'.base_url().'/catalogos/Referencias/editar/'.$ref->id.'" '.$edit.' class="btn btn-primary" title="Editar referencia"><i class="fa fa-pencil-square-o"></i></a>';
            $data[] = $row;
        }

        $output =  array(
            'draw' => $this->input->post('draw'),
            'recordsTotal' => $this->refes->count_all(),
            'recordsFiltered' => $this->refes->count_filtered(),
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
                $data = array('titulo' => 'Agregar referencia para control de gastos','accion'=>'catalogos/Referencias/guardarefe','permisosGrupo' => $permisos);
                $this->load->view('templates/navigation',$data);
                $this->load->view('referencias/referencias');
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
    public function editar($id)
    {
        if($this->aauth->is_loggedin())
        {
            $permisos = $this->permisosForma($_SESSION['id'],13);
            if(isset($permisos) && $permisos['edit']=="1")
            {
                $datos=$this->refes->datosReferencia($id);
                $data = array('titulo' => 'Editar referencia','accion' => 'catalogos/Referencias/guardarefe','permisosGrupo' => $permisos,'datos'=>$datos );
                $this->load->view('templates/navigation',$data);
                $this->load->view('referencias/referencias');
                $this->load->view('templates/footer');
            }
            else
            {
               redirect('welcome','refresh');
            }
        }
        else
        {
           redirect('/inicio/login','refresh');
        }
    }
    public function guardarrefe()
    {
        $id = $this->input->post('id');
        $correcto=false;
        $referencia = $this->input->post('referencia');
        $descripcion = $this->input->post('descripcion');
        if($id > 0)
        {
            $data = array(
                'referencia' => $referencia,
                'descripcion' => $descripcion,
            );
            $this->refes->update($id,$data);
        }
        else
        {
            $data = array(
                'referencia' => $referencia,
                'descripcion' => $descripcion,
            );
            $this->refes->insert($data);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(1));

    }
    public function buscarreferencia()
    {
        $datos = $this->refes->getallreferencia();
        if(count($datos) > 0)
        {
            $this->output->set_content_type('application/json')->set_output(json_encode($datos));
        }
        else
        {
            $this->output->set_content_type('application/json')->set_output(json_encode(array()));
        }
    }
}