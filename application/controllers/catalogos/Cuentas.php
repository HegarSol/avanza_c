<?php
class Cuentas extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('menuModel');
        $items=$this->menuModel->menus($_SESSION['tipo']);
        $this->multi_menu->set_items($items);
        $this->load->view('templates/header');
        $this->load->model('CuentasModel','cuentas');
        $this->load->model('CatalogosModel','cat');
        $this->load->model('BitacoraModel','bitacora');
        $this->load->model('ConfigCuentasModel','conficuentas');
        $this->load->model('Configuraciones_model','confi');
    }

    public function index()
    {
        if($this->aauth->is_loggedin())
        {
           $permisos = $this->permisosForma($_SESSION['id'],7);
           if(isset($permisos) && $permisos['leer']=="1")
           {
               $nombrempre = $this->confi->getConfig();
               $data = array('titulo' => 'Cuentas','permisosGrupo' =>  $permisos,'empresanombre'=>$nombrempre);
               $this->load->view('templates/navigation',$data);
               $this->load->view('cuentas/index');
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
    public function get_cuenta()
    {
        $cuen = $this->input->post('cuen');
        $subcu = $this->input->post('subcuen');

         $valor = $this->cuentas->get_cuenta($cuen,$subcu);

        $this->output->set_content_type('application/json')->set_output(json_encode($valor));
    }
    public function ajax_cuentabeneficiario()
    {
        $list = $this->cuentas->get_datatables();
        $data = array();
        foreach($list as $cuentas)
        {
            $row = array();
            $row[] = '<button type="button" class="btn btn-primary" onclick="seleccionarcunetabeneficiario(\''.$cuentas->cuenta.'\',\''.$cuentas->sub_cta.'\',\''.$cuentas->nombre.'\')">Seleccionar</button>';
            // $row[] = $cuentas->idcuenta;
            $row[] = $cuentas->cuenta;
            $row[] = $cuentas->sub_cta;
            $row[] = $cuentas->nombre;
            $data[] = $row;
        }
        $output = array(
            'draw' => $this->input->post('draw'),
            'recordsTotal' =>  $this->cuentas->count_all(),
            'recordsFiltered' => $this->cuentas->count_filtered(),
            'data' => $data
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function ajax_cuentaselejir()
    {
        $list = $this->cuentas->get_datatables();
        $data = array();
        foreach($list as $cuentas)
        {
            $row = array();
            $row[] = '<button type="button" class="btn btn-primary" onclick="seleccionarcuneta(\''.$cuentas->cuenta.'\',\''.$cuentas->sub_cta.'\',\''.$cuentas->nombre.'\')">Seleccionar</button>';
            // $row[] = $cuentas->idcuenta;
            $row[] = $cuentas->cuenta;
            $row[] = $cuentas->sub_cta;
            $row[] = $cuentas->nombre;
            $data[] = $row;
        }
        $output = array(
            'draw' => $this->input->post('draw'),
            'recordsTotal' =>  $this->cuentas->count_all(),
            'recordsFiltered' => $this->cuentas->count_filtered(),
            'data' => $data
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function buscarcuentas()
    {
        $cuenta = $this->input->post('cuenta');

        $dat = $this->cuentas->buscarcuentas($cuenta);

        $this->output->set_content_type('application/json')->set_output(json_encode($dat));
    }

    public function insertsubcuentadestino()
    {
        $cuenta = $this->input->post('cuenta');
        $dessubcuenta = $this->input->post('dessubcuenta');
        $check = $this->input->post('id');
        $nombre = $this->input->post('nombredes');
        $ssbcta = $this->input->post('ssbcta');

        $dat = $this->cuentas->datosCuentas($check);

        $datos = array('cuenta'=> $cuenta,
        'sub_cta' => $dessubcuenta,
        'nombre'=> $ssbcta == 0 ? $nombre : $dat[0]['nombre'],
        'tipo'=>$dat[0]['tipo'],
        'ctasat'=>$dat[0]['ctasat'],
        'natur'=>$dat[0]['natur'],
        'cvecobro'=>$dat[0]['cvecobro'],
        'ssub_cta'=>$dat[0]['ssub_cta']);

        $this->cuentas->crearCuenta($datos);

        //$this->output->set_content_type('application/json')->set_output(json_encode($dat));
    }
    public function buscarsubcuentaexistente()
    {
        $cuenta = $this->input->post('cuenta');
        $dessubcuenta = $this->input->post('dessubcuenta');

        $dat = $this->cuentas->get_cuenta_existe($cuenta,$dessubcuenta);

        $this->output->set_content_type('application/json')->set_output(json_encode($dat));
    }
    public function buscarsubcuentas()
    {
        $cuenta = $this->input->post('cuenta');
        $subcuenta = $this->input->post('subcuenta');

        $dat = $this->cuentas->get_cuenta($cuenta,$subcuenta);

        $this->output->set_content_type('application/json')->set_output(json_encode($dat));
    }
    public function ajax_cuentaselejiroperaciones()
    {
        $list = $this->cuentas->get_datatables();
        $data = array();
        foreach($list as $cuentas)
        {
            $row = array();
            $row[] = '<button type="button" class="btn btn-primary" onclick="seleccionarcunetaoperaciones(\''.$cuentas->cuenta.'\',\''.$cuentas->sub_cta.'\',\''.$cuentas->nombre.'\')">Seleccionar</button>';
            // $row[] = $cuentas->idcuenta;
            $row[] = $cuentas->cuenta;
            $row[] = $cuentas->sub_cta;
            $row[] = $cuentas->nombre;
            $data[] = $row;
        }
        $output = array(
            'draw' => $this->input->post('draw'),
            'recordsTotal' =>  $this->cuentas->count_all(),
            'recordsFiltered' => $this->cuentas->count_filtered(),
            'data' => $data
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function ajax_cuentasconfig()
    {
      $list = $this->conficuentas->get_datatables();
      $data = array();
      foreach($list as $confi)
      {
         $row = array();
         $row[] = '<button type="button" class="btn btn-primary" onclick="seleccionarconf(\''.$confi->cuenta.'\',\''.$confi->sub_cta.'\',\''.$confi->descrip.'\')">Seleccionar</button>';
         $row[] = $confi->cuenta;
         $row[] = $confi->sub_cta;
         $row[] = $confi->descrip;
         $data[] = $row;
      }
      $output = array(
          'draw' => $this->input->post('draw'),
          'recordsTotal' => $this->conficuentas->count_all(),
          'recordsFiltered' => $this->conficuentas->count_filtered(),
          'data' => $data
      );
      $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function ajax_list()
    {
        $permisos= $this->permisosForma($_SESSION['id'],7);
        $edit=$permisos['edit'];
        $del=$permisos['del'];
        if($edit=="0"){$edit='class="disabled"';} else {$edit="";}
        if($del=="0"){$del='class="disabled"';} else {$del="";}
        $list = $this->cuentas->get_datatables();
        $data = array();
        foreach($list as $cuentas)
        {
            $row = array();
            $row[] = $cuentas->idcuenta;
            $row[] = $cuentas->cuenta;
            $row[] = $cuentas->sub_cta;
            $row[] = $cuentas->ssub_cta;
            $row[] = $cuentas->nombre;
            $row[] = $cuentas->tipo;
            $row[] = $cuentas->ctasat;
            $row[] = $cuentas->natur;
            $row[] = $cuentas->cvecobro;
            $row[] = '<a href="'.base_url().'catalogos/cuentas/editar/'.$cuentas->idcuenta.'" '.$edit.' class="btn btn-primary" title="Editar Cuenta"><i class="fa fa-pencil-square-o"></i></a>
            <a href="#" onClick="EliminarCuenta(\''.$cuentas->idcuenta.'\')" '.$del.' class="btn btn-danger" title="Eliminar Cuenta"><i class="fa fa-times"></i></a>';
            $data[] = $row;
        }
        $output = array(
        'draw' => $this->input->post('draw'),
        'recordsTotal' =>  $this->cuentas->count_all(),
        'recordsFiltered' => $this->cuentas->count_filtered(),
        'data' => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function agregar($mensaje = null)
    {
        if($this->aauth->is_loggedin())
        {
            $permisos = $this->permisosForma($_SESSION['id'],7);
            if(isset($permisos) && $permisos['add']=="1")
            {
                $cuentas = $this->cat->selectcatcuentas();
                $data = array('titulo' => 'Nueva cuenta', 'accion' => 'catalogos/Cuentas/guardarcuenta','permisosGrupo'=>$permisos , 'cuentas' => $cuentas, 'mensaje'=>$mensaje);
                $this->load->view('templates/navigation',$data);
                $this->load->view('cuentas/cuentas');
                $this->load->view('templates/footer');
            }
            else
            {
                redirect('catalogos/cuentas/index','refresh');
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
            $permisos = $this->permisosForma($_SESSION['id'],7);
            if(isset($permisos) && $permisos['add']=="1")
            {
                $datos=$this->cuentas->datosCuentas($id);
                $cuentas = $this->cat->selectcatcuentas();
                $data = array('titulo' => 'Editar cuenta','accion' => 'catalogos/cuentas/guardarcuenta','permisosGrupo' => $permisos,'datos'=>$datos , 'cuentas' => $cuentas);
                $this->load->view('templates/navigation',$data);
                $this->load->view('cuentas/cuentas');
                $this->load->view('templates/footer');
            }
            else
            {
               redirect('catalogos/cuentas/index','refresh');
            }
        }
        else
        {
           redirect('/inicio/login','refresh');
        }
    }
    public function guardarcuenta()
    {
        date_default_timezone_set("America/Mexico_City");

        $id= $this->input->post('idcuenta');
        $correcto=false;
        $this->load->library("form_validation");
        if($this->form_validation->run('cuentas') === FALSE)
        {
            if($id == 0)
            {
               $this->agregar();
            }
            else
            {
               $this->editar($id);
            }
        }
        else
        {

            if($this->input->post('cvecobro') == '')
            {
                $clvcobro = 0;
            }
            else
            {
               $clvcobro = $this->input->post('cvecobro');
            }
            $datos = array('cuenta' => $this->input->post('cuenta'),'sub_cta' => $this->input->post('sub_cta'),'nombre'=> $this->input->post('nombre'),
           'tipo' => $this->input->post('tipo'),'ctasat' => $this->input->post('ctasat'),'natur' => $this->input->post('natur'),'cvecobro'=>$clvcobro,
           'ssub_cta' => $this->input->post('ssub_cta'));
           if($id>0)
           {
             $opera = array('usuario' => $_SESSION['nombreU'],
                            'tipo_mov' => '',
                            'no_banco' => '',
                            'no_mov' => '',
                            'accion' => 'Modificar',
                            'cuando' => date('Y-m-d H:i:s'),
                            'comentario' => 'Modifico la cuenta con el ID: '. $id,
                            'modulo' => 'Catalogos -> Cuentas');
               $this->bitacora->operacion($opera);
               $correcto=$this->cuentas->editarCuenta($id,$datos);
           }
           else
           {
                $checar = $this->cuentas->verificarsiexiste($this->input->post('cuenta'),$this->input->post('sub_cta'),$this->input->post('ssub_cta'));
                
                if(count($checar) > 0)
                {
                    $mensaje =array('mensaje'=>"Ya existe esta cuenta.");
                    $this->agregar($mensaje);
                }
                else
                {   
                    $opera = array('usuario' => $_SESSION['nombreU'],
                                  'tipo_mov' => '',
                                  'no_banco' => '',
                                  'no_mov' => '', 
                                  'accion' => 'Agregar', 
                                  'cuando' => date('Y-m-d H:i:s'), 
                                  'comentario' => 'Creo la cuenta: '.$this->input->post('cuenta') .' - '.$this->input->post('sub_cta').' - '.$this->input->post('nombre') ,
                                  'modulo' => 'Catalogos -> Cuentas');
                    $this->bitacora->operacion($opera);
                    $correcto=$this->cuentas->crearCuenta($datos);
                }
           }
           if($correcto == true)
           {
               redirect('catalogos/Cuentas/index','refresh');
           }
        }
    }
    public function eliminar($id)
    {
        date_default_timezone_set("America/Mexico_City");
      if($this->aauth->is_loggedin())
      {
        $permisos= $this->permisosForma($_SESSION['id'],5);
        if(isset($permisos) && $permisos['del']=="1")
        {
            $cuentas = $this->cuentas->datosCuentas($id);

          $res=$this->cuentas->borrarCuenta($id);
          if($res==true)
          {
              $opera = array('usuario' => $_SESSION['nombreU'],
                           'tipo_mov' => '',
                           'no_banco' => '',
                           'no_mov' => '',
                           'accion' => 'Eliminar',
                           'cuando' => date('Y-m-d H:i:s'),
                           'comentario' => 'Elimino la cuenta con el ID: '.$id. ' Cuenta: '.$cuentas[0]['cuenta']. ' Sub Cta: '.$cuentas[0]['sub_cta']. ' Nombre: '.$cuentas[0]['nombre'],
                           'modulo' => 'Catalogos -> Cuentas');
                $this->bitacora->operacion($opera);
                
             header("Location:".base_url()."catalogos/cuentas/index", 301);
            exit();
          }
        } else{ redirect('catalogos/cuentas/index', 'refresh');}
      } else{ redirect('/inicio/login', 'refresh');}
    }
    public function XMLCuentas($mes,$anio)
    {
        date_default_timezone_set("America/Mexico_City");
        $opera = array('usuario' => $_SESSION['nombreU'],
                       'tipo_mov' => '',
                       'no_banco' => '',
                       'no_mov' => '',
                       'accion' => 'Descargar',
                       'cuando' => date('Y-m-d H:i:s'),
                       'comentario' => 'Descargo las cuentas en XML con mes: '.$mes. ' y año: '.$anio,
                       'modulo' => 'Catalogos -> Cuentas -> XML SAT');
              $this->bitacora->operacion($opera);
        // $mes = $this->input->post('mes');
        // $anio = $this->input->post('anio');
        $conf = $this->cuentas->getConfig();
        $rfc = $conf[0]['rfc'];
        $this->load->library('ClaseXML');
        $this->cuentasxml = NULL;
        $this->cuentasxml = new ClaseXML();
        $mensaje = $this->cuentasxml->CrearXMLCuentas($mes, $anio, $rfc);

        $zip = new ZipArchive();
        $zip->open('XMLCuenta.zip',ZipArchive::CREATE);
        file_put_contents('Cuentas.xml',$mensaje);
        $zip->addFile('Cuentas.xml','Cuentas.xml');
        $zip->close();

        header("Content-type: application/octet-stream");
        header("Content-disposition: attachment; filename=XMLCuenta.zip");

        readfile('XMLCuenta.zip');
        unlink('Cuentas.xml');
        unlink('XMLCuenta.zip');
        // $this->load->helper('download');

        // header('Content-Type: text/xml; charset=UTF-8');

        // force_download('Cuentas.xml', $mensaje);
    } 
}