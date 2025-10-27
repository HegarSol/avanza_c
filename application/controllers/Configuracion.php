<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracion extends MY_Controller{
    
    public function __construct(){
         parent::__construct();
         $this->load->model('Configuraciones_model','configModel');
         $this->load->model('BitacoraModel','bitacora');
         
    }

    public function index()
    {
        $permisos = $this->permisosForma($_SESSION['id'],6);
        if(isset($permisos) && $permisos['leer']=="1")
        {
            $configNueva="";
            $config=$this->configModel->getConfig();
            $correos=$this->configModel->getCorreos();
            if(count($config)==0)
            {
                $this->load->model('EmpresasModel','empresas');
                $configNueva=$this->empresas->datosEmpresa($_SESSION['idEmpresa']);
            }
            $data = array(
                'titulo' => 'Configuración',
                'permisosGrupo' => $permisos,
                'accion' => 'configuracion/guardarConfig',
                'datos' => $config,
                'correos' => $correos,
                'esNueva' => $configNueva
            );
            $this->load->view('templates/header');
            $this->load->view('templates/navigation',$data);
            $this->load->view('configuracion');
            $this->load->view('templates/footer');
        }
        else
        {
            show_error('No tiene permiso para entrar a la configuracion');
        }
    }
    public function ajax_list2()
    {
        $confgcuen = $this->configModel->getConfigCuentas();        
        $data = array();
        foreach($confgcuen as $confi)
        {
            $row = array();
           // $row[] = $confi['idcuentaconfi'];
            $row[] = $confi['descrip'];
            $row[] = $confi['cuenta'];
            $row[] = $confi['sub_cta'];
            $row[] = $confi['ssub_cta'];
            $row[] = '<button type="button" onclick="editarCuenta(\''.$confi['idcuentaconfi'].'\')" class="btn btn-primary" title="Editar cuenta"><i class="fa fa-pencil-square-o"></i></button>';
            $data[] = $row;
        }
        $output = array(
            'draw' => $this->input->post('draw'),
            'data' => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function getconfigcuenta()
    {
        $valor = $this->input->post('valor');
        $data = $this->configModel->getconfigcuenta($valor);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    public function guardaconfigcta()
    {
        $id = $this->input->post('id');
        $cuen = $this->input->post('cuen');
        $sub_cta = $this->input->post('sub_cta');
        $ssub_cta = $this->input->post('ssub_cta');

        $datos = array('cuenta' => $cuen, 'sub_cta' => $sub_cta, 'ssub_cta' => $ssub_cta);
        $correcto = $this->configModel->guardarconfigcuanta($id,$datos);
        echo json_encode($correcto);

    }
    public function upload()
    {
        $nom_mov = $this->input->post('no_mov');
        $no_banco = $this->input->post('no_banco');
        $tipo_mov = $this->input->post('tipo_mov');
        $config = $this->configModel->getConfig();

        if($tipo_mov == 'T')
        {
             $modulo_tipo = 'Transferencia';
        }
        else if($tipo_mov == 'D')
        {
            $modulo_tipo = 'Deposito';
        }
        else if($tipo_mov == 'C')
        {
            $modulo_tipo = 'Cheque';
        }

        $full_path = '/mnt/s3/polizasArchivos/' . $config[0]['rfc'] . DIRECTORY_SEPARATOR . $nom_mov . DIRECTORY_SEPARATOR . $no_banco . DIRECTORY_SEPARATOR . $tipo_mov .DIRECTORY_SEPARATOR;

        if(!file_exists($full_path))
        {
          mkdir($full_path,0777,TRUE);
        }

       if(isset($_FILES['archivo']) && $_FILES['archivo']['type'] != '')
       {
          $contenido = file_get_contents($_FILES['archivo']['tmp_name']);
          file_put_contents($full_path . $_FILES['archivo']['name'], $contenido);

          $datos = array('tipo_mov' => $tipo_mov, 'no_banco' => $no_banco, 'no_mov' => $nom_mov, 'path' => $full_path .$_FILES['archivo']['name']);

          $this->configModel->addPathFile($datos);

          $crearopera = array('usuario' => $_SESSION['nombreU'],
                    'tipo_mov' => '',
                    'no_banco' => '',
                    'no_mov' => '',
                    'accion' => 'Cargar', 
                    'cuando' => date('Y-m-d H:i:s'), 
                    'comentario' => 'Agrego el archivo: '. $_FILES['archivo']['name'] . ' con el movimiento: ' . $nom_mov . ' numero banco: '. $no_banco . ' tipo de movimiento: ' . $tipo_mov,
                    'modulo' => $modulo_tipo);
           $this->bitacora->operacion($crearopera);

          $this->output->set_content_type('application/json')->set_output(json_encode(1));
       }
       else
       {
          $this->output->set_content_type('application/json')->set_output(json_encode(0));
       }


    }
    public function guardarConfig()
    {
        $correcto=false;
        $imgName='';
        if(isset($_FILES['imgInp']) && $_FILES['imgInp']['name']!="")
        {
            $imgName = $_FILES['imgInp']['name'];
        }
        else
        {
            $imgName = $this->input->post('imgName');
        }
        $id=$this->input->post('idEmpresa');
        $datos=array(
            'nombreEmpresa' => $this->input->post('nombre'),
            'rfc' => $this->input->post('rfc'),
            'curp' => $this->input->post('curp'),
            'img' => $this->input->post('imgBase64'),
            'pais' => $this->input->post('pais'),
            'estado' => $this->input->post('estado'),
            'ciudad' => $this->input->post('ciudad'),
            'localidad' => $this->input->post('localidad'),
            'cp' => $this->input->post('cp'),
            'colonia' => $this->input->post('colonia'),
            'calle' => $this->input->post('calle'),
            'noExt' => $this->input->post('noExt'),
            'noInt' => $this->input->post('noInt'),
            'referencia' => $this->input->post('referencia'),
            'telefono' => $this->input->post('telefono'),
            'imgName' => $imgName
        );
        if($id>0)
        {
            $correcto = $this->configModel->editConfig($id,$datos);
        }
        else
        {
            $correcto = $this->configModel->setConfig($datos);
        }

        if($correcto == true)
        {
            redirect('Welcome/index','refresh');
        }
    }
    public function getDatosCorreo($id)
    {
        $datos=$this->configModel->getDatosCorreo($id);
        $this->output->set_content_type('application/json')->set_output(json_encode($datos));
    }

    public function guardarCorreo($id=0)
    {
        $correo=0;
        $json = array();
        if(isset($_POST['default1']) && $_POST['default1'] =="1"){$default=1;}else{$deafult=0;}
    if(isset($_POST['SMTPAuth']) && $_POST['SMTPAuth']=="1"){$smtpa=1;}else{$smtpa=0;}
    $datos=array('host'=>$_POST['host'],'SMTPAuth'=>$_POST['SMTPAuth'],'SMTPAuth'=>$smtpa,
                 'puerto'=>$_POST['puerto'],'userName'=>$_POST['userName'],'password'=>$_POST['password'],
                 'from1'=>$_POST['from1'],'fromName'=>$_POST['fromName'],'replyTo'=>$_POST['replyTo'],
                 'replyToName'=>$_POST['replyToName'],'subject'=>$_POST['subject'],'SMTPSecure'=>$_POST['SMTPSecure'],
                 'body'=>$_POST['body'],'default'=>$default,'cc'=>$_POST['cc']);
         if($default==1)
         {
             $this->configModel->updateDefault();
         }
         if($id!=0)
         {
             $correcto = $this->configModel->editarCorreo($id,$datos);
             $mensaje= 'Actualizado Correctamente';
         }
         else
         {
             $correcto=$this->configModel->crearCorreo($datos);
             $mensaje = 'Insertado Correctamente';
         }

         if($correcto>0)
         {
             $json[] = array('mensaje' => $mensaje , 'id' => $correcto);
         }
         else
         {
             $json[] = array('mensaje' => 'Error','errores' => 'No se pudieron guardar los datos del correo');
         }
         $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    public function borrarCorreo($id)
    {
        $mensaje=$correcto=$this->configModel->borrarCorreo($id);
        $this->output->set_content_type('application/json')->set_output(json_encode($mensaje));
    }
}