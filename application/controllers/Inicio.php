<?php

 defined('BASEPATH') OR exit('No direct script access allowed');

 class Inicio extends CI_Controller
 {
     public function __construct(){
         parent::__construct();
         $this->load->view('templates/header');
     }

     public function login()
     {
         $this->load->view('validaUsuario');
     }
     public function logout()
     {
         $this->aauth->logout();
         redirect('/inicio/login','refresh');
         exit();
     }
     public function iniciarSesion()
     {
         if($this->input->post('remember')=="remember-me")
         {
             $remember=true;
         }
         else
         {
             $remember=false;
         }
         if($this->aauth->login($this->input->post('correo'), $this->input->post('contrasena'),$remember))
         {
            $_SESSION['id']=$this->aauth->get_user_id($this->input->post('correo'));
            $usuario=$this->aauth->get_user($_SESSION['id']);
            $_SESSION['img']=$this->aauth->get_user_var('img',$_SESSION['id']);
            $_SESSION['tipo']=$this->aauth->get_user_var('tipo',$_SESSION['id']);
            $_SESSION['nombreU']=$usuario->name;
            $empresas=$this->validaempresas->validaE();
            if(isset($_SESSION['idEmpresa']))
            {
                redirect('Welcome/index');
            }
            else if(!isset($_SESSION['idEmpresa']) && $_SESSION['tipo'] != 'SU')
            {
                $this->load->view('selEmpresa',array('empresas' => $empresas));
            }
            else if(!isset($_SESSION['idEmpresa']) && $_SESSION['tipo'] == 'SU')
            {
                $_SESSION['idEmpresa']=1;
                $this->load->model('EmpresasModel','empresas');
                $empresas=$this->empresas->todasEmpresas();
                $this->load->view('selEmpresa',array('empresas'=>$empresas));
            }
            else
            {
                $array=$this->validaEmpresas->get_errors();
                $this->load->view('validadUsuario',array('errores'=>$array));
            }
         }
         else
         {
             $array = $this->aauth->get_errors_array();
             $this->load->view('validaUsuario',array('errores'=>$array));
         }
     }
     public function VerSelecEmpresa()
     {
         $empresas=$this->validaempresas->validaE();
         if($_SESSION['tipo']=='SU')
         {
            $_SESSION['idEmpresa']=1;
            $this->load->model('EmpresasModel','empresas');
            $empresas=$this->empresas->todasEmpresas();
         }
         $this->load->view('selEmpresa',array('empresas'=>$empresas));
     } 
     public function CambioEjercicio()
     {
         $_SESSION['mes'] = $this->input->post('mes');
         $_SESSION['ano'] = $this->input->post('ano');
         $_SESSION['mesletra'] = $this->input->post('mesle');
     }
     public function SelecEmpresa()
     {
         $_SESSION['idEmpresa']=$this->input->post('empre');

         $_SESSION['mes'] = $this->input->post('mes2');
         $_SESSION['ano'] = $this->input->post('ano');
         $_SESSION['mesletra'] = $this->input->post('mesletra2');
         
         $this->load->model('UsuariosModel','usuarios');
         $this->load->model('EmpresasModel','empresas');
         $empresa= $this->empresas->datosEmpresa($_SESSION['idEmpresa']);
      
           // $esAdmin= $this->empresas->EsAdmin($_SESSION['id']);
            $empresa = $this->empresas->datosEmpresa($_SESSION['idEmpresa']);
            if($_SESSION['tipo']=="admin" && $_SESSION['tipo']!="SU" && $_SESSION['tipo']!="hegar")
            {
                 $_SESSION['tipo']="admin";
            }
            else if($_SESSION['tipo']!="SU" && $_SESSION['tipo']!="hegar")
            { 
                $_SESSION['tipo']="usuario"; 
            }
            redirect('/Welcome/index');
     }
 }