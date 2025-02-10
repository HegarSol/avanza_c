<?php

class ReporteEstadoResultadoComparativo extends MY_Controller
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
    }

    public function index()
    {
        if($this->aauth->is_loggedin())
        {
            $errores=array();
            $rfc = $this->configModel->getConfig();
            $permisos=$this->permisosForma($_SESSION['id'],1);
            $data=array('titulo'=>'Reporte estado de resultado comparativo','rfc' => $rfc[0]['rfc'],'razon' => $this->validaempresas->get_razon($_SESSION['idEmpresa']),'errores'=>$errores,'permisosGrupo'=>$permisos);
            $items=$this->menuModel->menus($_SESSION['tipo']);
            $this->multi_menu->set_items($items);
            $this->load->view('templates/header');
            $this->load->view('templates/navigation',$data);
            $this->load->view('reportes/reportestadoresultadocomparativo');
            $this->load->view('templates/footer');
        }
        else
        {
            redirect('inicio/login','refresh');
        }
    }
    public function buscar()
    {
        $mes = $this->input->post('mes');
        $ano = $this->input->post('ano');

        $datos = $this->operaciones->estadocomparativo($mes,$ano);

        if($mes == 01)
        {
            $mesletra = array('Enero');
        }
        else if($mes == 02)
        {
            $mesletra = array('Enero','Febrero');
        }
        else if($mes == 03)
        {
            $mesletra = array('Enero','Febrero','Marzo');
        }
        else if($mes == 04)
        {
            $mesletra = array('Enero','Febrero','Marzo','Abril');
        }
        else if($mes == 05)
        {
            $mesletra = array('Enero','Febrero','Marzo','Abril','Mayo');
        }
        else if($mes == 06)
        {
            $mesletra = array('Enero','Febrero','Marzo','Abril','Mayo','Junio');
        }
        else if($mes == 07)
        {
            $mesletra = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio');
//            $junio = $this->operaciones->estadocomparativo('06',$ano);
         //   $julio = $this->operaciones->estadocomparativo('07',$ano);

  //          var_dump($junio);
      //      var_dump($julio);
        }
        else if($mes == '08')
        {
            $mesletra = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto');
        }
        else if($mes == '09')
        {
            $mesletra = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre');
        }
        else if($mes == 10)
        {
            $mesletra = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre');
        }
        else if($mes == 11)
        {
            $mesletra = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre');
        }
        else if($mes == 12)
        {
            $mesletra = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        }

        $data['comparativos'] = $datos;
        $data['meses'] = $mesletra;

        $this->load->view('reportes/comparativo/tabla_comparativo',$data);
    }
}