<?php
class Empresas extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("menuModel");
        $items=$this->menuModel->menus($_SESSION['tipo']);
        $this->multi_menu->set_items($items);
        $this->load->view('templates/header');
        $this->load->model('usuariosModel');
        $this->load->model('empresasModel');
    }
    public function index()
    {
        if($this->aauth->is_loggedin())
        {
            if($_SESSION['tipo']=="SU")
            {
                $data = array('titulo' => 'Empresas');
                $this->load->view('templates/navigation',$data);
                $this->load->view('empresas/index');
                $this->load->view('templates/footer');
            }
            else
            {
               redirect('/usuarios/redireccionar','refresh');
            }
        }
        else
        {
            redirect('/inicio/login','refresh');
        }
    }
    public function dataTable()
  {
    $list = $this->empresasModel->get_datatables();
    $data = array();
    foreach($list as $empresa)
    {
      $row = array();
      $row[] = $empresa->idEmpresa;
      $row[] = $empresa->rfcEmpresa;
      $row[] = $empresa->razon;
      $row[] = $empresa->tel;
      $row[] = '<a href="'.base_url().'empresas/editar/'.$empresa->idEmpresa.'" class="btn btn-primary" title="Editar Empresa"><i class="fa fa-pencil-square-o"></i></a>
      <a href="#"  onClick="EliminarEmpresa(\''.$empresa->idEmpresa.'\')" class="btn btn-danger" title="Eliminar Empresa"><i class="fa fa-times"></i></a></li>';
      $data[] = $row;
    }
    $output = array(
      'draw' => $this->input->post('draw'),
      'recordsTotal' =>  $this->empresasModel->count_all(),
      'recordsFiltered' => $this->empresasModel->count_filtered(),
      'data' => $data
    );
    $this->output->set_content_type('application/json')->set_output(json_encode($output));
  }
  public function agregar()
  {
      if($this->aauth->is_loggedin())
      {
         if($_SESSION['tipo'] == "SU")
         {
            $data = array('titulo' => 'Nueva empresa','accion' => 'empresas/guardarEmpresa');
            $this->load->view('templates/navigation',$data);
            $this->load->view('empresas/empresas');
            $this->load->view('templates/footer');
         }
         else
         {
             redirect('/grupos/index','refresh');
         }
      }
      else
      {
          redirect('/inicio/login','refresh');
      }
  }
  public function editar($id)
  {
      if($this->aauth->is_loggedin())
      {
          if($_SESSION['tipo']=="SU")
          {
             $datos = $this->empresasModel->datosEmpresa($id);
             $configuraciones=$this->empresasModel->getConfiguracion($datos[0]['idEmpresa']);
             $usuarios=$this->aauth->list_users();
             $pertenece=$this->empresasModel->UsuariosPertenecenAEmpresa($id);
                $usuariosArray = json_decode(json_encode($usuarios), True);
                $usuariosArray1 = json_decode(json_encode($usuarios), True);
                $perteneceArray=json_decode(json_encode($pertenece), True);
                for($i=0; $i<count($perteneceArray); $i++)
                {
                for($j=0; $j<count($usuarios); $j++)
                {
                    $pert=$perteneceArray[$i]['id'];
                    $gruoo=$usuariosArray1[$j]['id'];
                    if($pert==$gruoo)
                    { unset($usuariosArray[$j]); }
                }
                }
                $data = array('titulo' => 'Editar empresa','accion' => 'empresas/guardarEmpresa','datos' => $datos,
                'usuariosT' => $usuariosArray, 'pertenece' => $pertenece,'configuraciones' => $configuraciones);
                $this->load->view('templates/navigation',$data);
                $this->load->view('empresas/empresas');
                $this->load->view('templates/footer');
          }
          else
          {
              redirect('grupos/index','refresh');
          }
      }
      else
      {
          redirect('/inicio/login','refresh');
      }
  }
  public function guardarEmpresa()
  {
      $id = $this->input->post('idEmpresa');

      $datosPrevios=$this->empresasModel->datosEmpresa($id);
      $datos=array('razon'=>$this->input->post('nombre'),'rfcEmpresa'=>$this->input->post('rfc'),'curp'=>$this->input->post('curp'),
      'tel'=>$this->input->post('telefono'),'basedeDatos'=>$this->input->post('basedeDatos'),'usuario'=>$this->input->post('usuario'),
      'contrasena'=>$this->input->post('contrasena'),'host'=>$this->input->post('host'),'idAdmin'=>$this->input->post('idU'),
      'correoAdmin'=>$this->input->post('admin'),'autorizacion'=>$this->input->post('autorizacion') == 1 ? 1 : 0,
      'referenciamarca'=>$this->input->post('referenciamarca') == 1 ? 1 : 0,
      'usactacontable'=>$this->input->post('usactacontable') == 1 ? 1 : 0);

      if($id>0)
      {
          $correcto=$this->empresasModel->editarEmpresa($id,$datos);
          $this->usuariosModel->agregarRelUsuarioEmpresa($this->input->post('idU'),$id);
      }
      else
      {
          $correcto=$this->empresasModel->crearEmpresa($datos,$id);
          $this->usuariosModel->agregarRelUsuarioEmpresa($this->input->post('idU'),$correcto);
      }
      if($correcto==true)
      {
          if(isset($datosPrevios))
          {
              $a=$datosPrevios[0]['idAdmin'];
              $b=$this->input->post('idU');
              if($a != $b)
              {
                  $this->aauth->send_verification($this->input->post('idU'),$this->input->post('admin'),$this->input->post('pass'),$this->input->post('nombre'));
              }
          }
          redirect('empresas/index','refresh');
      }
  }
  public function AgregarUsuario()
  {
      $idE = $this->input->post('idEmpresa');
      $idU = $this->input->post('idUsuario');
      return $this->empresasModel->agregarRelUsuarioE($idU,$idE);
  }
  public function RemoverUsuario()
  {
      $idE = $this->input->post('idEmpresa');
      $idU = $this->input->post('idUsuario');
      return $this->empresasModel->eliminarRelUsuarioE($idU,$idE);
  }
}