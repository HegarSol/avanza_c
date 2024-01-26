<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$errores=array();
		 $this->load->model('menuModel');
		 $this->load->model('Configuraciones_model');
		 if($this->aauth->is_loggedin())
		 {
			 $permisos = $this->permisosForma($_SESSION['id'],13);
			 $data=array('titulo' => 'Facturas', 'razon' => $this->validaempresas->get_razon($_SESSION['idEmpresa']),'erroes' => $errores,'permisosGrupo' => $permisos);
			 $items=$this->menuModel->menus($_SESSION['tipo']);
			 $this->multi_menu->set_items($items);
			 $this->load->view('inicio'); 
		}
		 else
		 {
			 redirect('/inicio/login','refresh');
		 }
	}
}
