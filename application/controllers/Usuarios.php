<?php

 class Usuarios extends MY_Controller
 {
     public function __construct()
     {
         parent::__construct();
         $this->load->model("menuModel");
         $items=$this->menuModel->menus($_SESSION['tipo']);
         $this->multi_menu->set_items($items);
         $this->load->library('form_validation');
         $this->load->view('templates/header');
         $this->load->model('EmpresasModel');
         $this->load->model('UsuariosModel');
         $this->load->model('BitacoraModel');
         $this->load->model('Configuraciones_model','configModel');
         switch ($_SESSION['tipo'])
         {
             case 'SU':
                $this->permisos = array(
                    'leer' => 1,
                    'add' => 1,
                    'edit' => 1,
                    'del' => 1
                );
            break;
            case 'admin':
                $this->permisos= array(
                    'leer' => 1,
                    'add' => 0,
                    'edit' => 1,
                    'del' => 0
                );
            break;
         }
     }
     public function index()
     {
         if($this->aauth->is_loggedin())
         {
             if($_SESSION['tipo']=="SU" || $_SESSION['tipo']=='admin')
             {
                $data = array('titulo' => 'Usuarios','permisosGrupo' => $this->permisos);
                $this->load->view('templates/navigation',$data);
                $this->load->view('usuarios/index');
                $this->load->view('templates/footer');
             }
             else
             {
                 show_error('No tiene permisos de lectura sobre el modulo',200,"Error de Acceso");
             }
         }
         else
         {
             redirect('inicio/login','refresh');
         }
     }
     public function agregar()
    {
        if($this->aauth->is_loggedin())
        {
        if($_SESSION['tipo']=='SU' || $_SESSION['tipo']=='admin')
        {
        
            $items=$this->UsuariosModel->permisos();
            $correos=$this->configModel->getCorreos();
            $data = array('titulo' => 'Agregar Usuario','accion' => 'usuarios/crear_usuario','formas'=>$items,'correos'=>$correos);
            $this->load->view('templates/navigation',$data);
            $this->load->view('usuarios/Usuarios');
            $this->load->view('templates/footer');
        } else{ redirect('/usuarios/index', 'refresh'); }
        } else{ redirect('/inicio/login', 'refresh'); }
    }
  public function crear_usuario()
  {
    date_default_timezone_set("America/Mexico_City");
    if ($this->form_validation->run('usuarios') === FALSE)
    { $this->agregar(); }
    else
    {
      $items=$this->UsuariosModel->permisos();
      $id=$this->aauth->create_user($this->input->post('correo'),$this->input->post('contrasena'),$this->input->post('nombre'));
   //var_dump($id);
        if($id>0)
      {

        $img1= $this->aauth->set_user_var('img',$this->input->post('base64textarea'),$id);
        if($this->input->post('tUsuario')=="SU")
        {
           $this->aauth->add_member($id, 'SU');
        }
        if($this->input->post('tUsuario')=="hegar")
        {
           $this->aauth->add_member($id, 'hegar');
        }
        if($this->input->post('tUsuario')=="usuario")
        {
            $this->Permisos($id);
        }
        $this->aauth->set_user_var('tipo',$this->input->post('tUsuario'),$id);

        $usuario = array(
            'usuario' => $_SESSION['nombreU'],
            'tipo_mov' => '',
            'no_banco' => '',
            'no_mov' => '',
            'accion' => 'Agregar',
            'cuando' => date('Y-m-d H:i:s'),
            'comentario' => 'Agrego el usuario: '.$this->input->post('nombre'). ' Correo: ' .$this->input->post('correo'). ' con tipo: '. $this->input->post('tUsuario'),
            'modulo' => 'Administrativo -> Usuarios'
        );
        $this->BitacoraModel->operacion($usuario);

        header("Location:".base_url()."usuarios/index", 301);
      }
      else
      {
        $items=$this->UsuariosModel->permisos();
        $array= $this->aauth->get_errors_array();
        $data = array('titulo' => 'Agregar Usuario','accion' => 'usuarios/crear_usuario','formas'=>$items);
        $this->load->view('templates/navigation',$data);
        $this->load->view('usuarios/Usuarios');
        $this->load->view('templates/footer');
      }
    }
  }
    public function edit($id)
    {
        if($this->aauth->is_loggedin())
        {
        if($_SESSION['tipo']=="SU" || $_SESSION['tipo']=="admin")
        {
            $correoDefault=$this->UsuariosModel->correoDefault($_SESSION['idEmpresa'],$id);
            if(count($correoDefault)>0){
            $correoD= $correoDefault[0]['correoDefault'];
            }
            else {
            $correoD='';
            }
            $correos=$this->configModel->getCorreos();
            $grupos=$this->aauth->list_groups();
            $this->load->model("UsuariosModel");
            $tUsuario= $this->aauth->get_user_var('tipo',$id);
            $items=$this->UsuariosModel->datosUsuario($id);
            $items2=$this->UsuariosModel->permisos();
        
            $permisosF=$this->UsuariosModel->permisosEdit($id);
            $img= $this->aauth->get_user_var('img',$id );
            $data = array('titulo' => 'Editar Usuario', 'datos'=>$items, 'accion' => 'usuarios/editar','img'=>$img, 'formas'=>$items2,'correos'=>$correos,
            'permisos'=>$permisosF,'tUsuario'=>$tUsuario,
            'correoD'=>$correoD);
            $this->load->view('templates/navigation',$data);
            $this->load->view('usuarios/Usuarios');
            $this->load->view('templates/footer');
        }
        else{ redirect('/Usuarios/index', 'refresh');}
        }
        else{ redirect('/inicio/login', 'refresh'); }
    }
        public function editarPerfil($id)
        {
            if($this->aauth->is_loggedin())
            {
                $grupos=$this->aauth->list_groups();
                $this->load->model("UsuariosModel");
                $items=$this->UsuariosModel->datosUsuario($id);
                $img= $this->aauth->get_user_var('img',$id );
                $data = array('titulo' => 'Editar Usuario', 'datos'=>$items, 'accion' => 'usuarios/editarPF','img'=>$img);
                $this->load->view('templates/navigation',$data);
                $this->load->view('usuarios/editarPerfil');
                $this->load->view('templates/footer');
            }
            else{ redirect('/inicio/login', 'refresh'); }
        }

     public function dataTable()
     {
        if($_SESSION['tipo']=='SU')
        {$list = $this->UsuariosModel->get_datatables();}
        else {
          $join= array('tabla'=>'relusuarioempresa rue','condicion'=>'rue.idUsuario=aauth_users.id');
          $where =array('rue.idEmpresa'=>$_SESSION['idEmpresa']);
          $list = $this->UsuariosModel->get_datatables($where,$join);
        }
        $data = array();
        foreach($list as $usuarios)
        {
          $usuarios->banned==0 ? $banned="No":$banned="Si";
          if ($usuarios->banned == 0) 
          {
              $acciones='

              <a href="'.base_url().'usuarios/edit/'.$usuarios->id.'" class="btn btn-primary" title="Editar Usuario"><i class="fa fa-pencil-square-o"></i></a>
              <a href="'.base_url().'usuarios/resetInt/'.$usuarios->id.'" class="btn btn-warning" title="Reiniciar Intentos de Inicio"><i class="glyphicon glyphicon-repeat"></i></a>
              <a href="'.base_url().'usuarios/resetPass/'.$usuarios->email.'" class="btn btn-warning" title="Reiniciar Contraseña"><i class="glyphicon glyphicon-refresh"></i></a>
              <a href="#" onClick="EliminarUsuario(\''.$usuarios->id.'\')" class="btn btn-danger" title="Eliminar Usuario"><i class="fa fa-times"></i></a>
              <a href="'.base_url().'usuarios/bloquear/'.$usuarios->id.'" class="btn btn-danger" title="Bloquear"><i class="glyphicon glyphicon-thumbs-down"></i></a>
              
              ';
          }
          else if ($usuarios->banned == 1)
          { 
              $acciones='
              
              <a href="'.base_url().'/usuarios/edit/'.$usuarios->id.'" class="btn btn-primary" title="Editar Usuario"><i class="fa fa-pencil-square-o"></i></a>
              <a href="#"   onClick="EliminarUsuario(\''.$usuarios->id.'\')" class="btn btn-danger" title="Eliminar Usuario"><i class="fa fa-times"></i></a>
              <a href="'.base_url().'usuarios/desbloquear/'.$usuarios->id.'" class="btn btn-info" title="Desbloquear"><i class="glyphicon glyphicon-thumbs-up"></i></a>';
          }
          $row = array();
          $row[] = $usuarios->id;
          $row[] = $usuarios->name;
          $row[] = $usuarios->email;
          $row[] = $banned;
          $row[] = $usuarios->last_login;
          $row[] =  $acciones;
          $data[] = $row;
        }
        $output = array(
          'draw' => $this->input->post('draw'),
          'recordsTotal' =>  $this->UsuariosModel->count_all(),
          'recordsFiltered' => $this->UsuariosModel->count_filtered(),
          'data' => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
     }
     public function editar()
     {
       if($this->aauth->is_loggedin())
       {
        date_default_timezone_set("America/Mexico_City");
       //  $this->load->model("clientes_model");
       //  $where=array('tipofacturacion !='=>'Pago');
        // $series= $this->clientes_model->getSeries($where);
         $permisosF=$this->UsuariosModel->permisosEdit($this->input->post('id'));
         $tiposUsuarios= $this->aauth->list_groups();
         $img= $this->aauth->get_user_var('img',$this->input->post('id'));
         $tu= $this->aauth->get_user_var('tUsuario',$this->input->post('id'));
         if ($this->form_validation->run('usuarios') === FALSE)
         {
           $data = array('titulo' => 'Editar Usuario','accion' => 'usuarios/editar','series'=>$series,
           'permisosGrupo' => $this->permisos,'img'=>$img,'formas'=>$items2,'permisos'=>$permisosF,
           'serieDefault'=>$this->UsuariosModel->serieDefault($_SESSION['idEmpresa'],$this->post->input('id')));
           $this->load->view('templates/navigation',$data);
           $this->load->view('usuarios/Usuarios');
           $this->load->view('templates/footer');
         }
         else
         {
           $contrasena=$this->input->post('contrasena');
           if($contrasena=="password" || $contrasena ==""){$contrasena=FALSE;}
           if($this->aauth->update_user($this->input->post('id'),$this->input->post('correo'),$contrasena,$this->input->post('nombre')))
           {
             if($this->input->post('tUsuario')=="usuario"){$this->Permisos();}
             if($this->input->post('base64textarea')!="") { $img1= $this->aauth->set_user_var('img',$this->input->post('base64textarea'),$this->input->post('id')); }
             $tipoUsuario= $this->aauth->set_user_var('tipo',$this->input->post('tUsuario'),$this->input->post('id'));
             $this->UsuariosModel->agregarRelUsuarioEmpresa($this->input->post('id'),$_SESSION['idEmpresa'],$this->input->post('series'),$this->input->post('correos'));
             if($this->input->post('tUsuario')=="SU")
             {
                $this->aauth->add_member($this->input->post('id'), 'SU');
             }
             if($this->input->post('tUsuario')=="hegar")
             {
                $this->aauth->add_member($this->input->post('id'), 'hegar');
             }

             
             if($this->input->post('id')==$_SESSION['id'])
             {
               $_SESSION['nombreU']=$this->input->post('nombre');
               if($this->input->post('base64textarea')!=""){$_SESSION['foto']= $this->input->post('base64textarea');}
   
               redirect('/Welcome', 'refresh');
             }
             else
             {
                $usuario = array(
                    'usuario' => $_SESSION['nombreU'],
                    'tipo_mov' => '',
                    'no_banco' => '',
                    'no_mov' => '',
                    'accion' => 'Modificar',
                    'cuando' => date('Y-m-d H:i:s'),
                    'comentario' => 'Modifico al usuario con el ID: '. $this->input->post('id'),
                    'modulo' => 'Administrativo -> Usuarios'
                );
                $this->BitacoraModel->operacion($usuario);

                 redirect('/usuarios/index', 'refresh');
             }
           }
           else {$this->edit($this->input->post('id'));  }
         }
       }
       else{ redirect('/inicio/login', 'refresh');}
     }
     public function Permisos($id=0)
     {
       if($id==0)
       {$id=$this->input->post('id');}
       $items2=$this->UsuariosModel->permisos();
       $this->UsuariosModel->borrarPermisos($id);
         for($i= 0; $i<count($items2); $i++)
         {
           $nf=$items2[$i]['nombrForma'];
           $if= $items2[$i]['idForma'];
           $leer= $this->input->post("leer$nf");         if($leer!="1"){$leer=0;}
           $print= $this->input->post("print$nf");       if($print!="1"){$print=0;}
           $editar= $this->input->post("editar$nf");     if($editar!="1"){$editar=0;}
           $borrar= $this->input->post("borrar$nf");     if($borrar!="1"){$borrar=0;}
           $agregar= $this->input->post("agregar$nf");   if($agregar!="1"){$agregar=0;}
           $this->UsuariosModel->actualizarPermisos($if,$id,$leer,$agregar,$editar,$borrar,$print);
         }
     }
     public function dataTableEmpresas()
     {
         $list = $this->UsuariosModel->get_datatables();
         $data = array();
         foreach($list as $usuarios)
         {
             $row = array();
             $row[] = $usuarios->id;
             $row[] = $usuarios->name;
             $row[] = $usuarios->email;
             $data[] = $row;
         }
         $output = array(
             'draw' => $this->input->post('draw'),
             'recordsTotal' => $this->UsuariosModel->count_all(),
             'recordsFiltered' => $this->UsuariosModel->count_filtered(),
             'data' => $data
         );
         $this->output->set_content_type('application/json')->set_output(json_encode($output));
     }
        public function resetInt($id)
        {
            if($this->aauth->is_loggedin())
            {
                if($_SESSION['tipo']=="SU" || $_SESSION['tipo']=="admin")
                {
                    date_default_timezone_set("America/Mexico_City");
                    $usuario = array(
                        'usuario' => $_SESSION['nombreU'],
                        'tipo_mov' => '',
                        'no_banco' => '',
                        'no_mov' => '',
                        'accion' => 'ResetearIntentos',
                        'cuando' => date('Y-m-d H:i:s'),
                        'comentario' => 'Reseteo los intentos del usuario con el ID: '. $id,
                        'modulo' => 'Administrativo -> Usuarios'
                    );
                    $this->BitacoraModel->operacion($usuario);

                    if($this->aauth->reset_login_attempts($id))
                    { $data = array('titulo' => 'Usuario','reseteo'=>'1','permisosGrupo'=>$this->permisos); }
                    else{$data = array('titulo' => 'Usuario','reseteo'=>'0'); }
                    $this->load->view('templates/navigation',$data);
                    $this->load->view('usuarios/index');
                    $this->load->view('templates/footer');
                } else{ redirect('/usuarios/index', 'refresh');}
            } else{redirect('/inicio/login', 'refresh'); }
        }
        public function resetPass($id)
        {
            if($this->aauth->is_loggedin())
            {
                if($_SESSION['tipo']=="SU" || $_SESSION['tipo']=="admin")
                {
                $a= $this->aauth->remind_password($id);
                $data = array('titulo' => 'Usuario','reseteoPass'=>'1','permisosGrupo'=>$this->permisos);
                $this->load->view('templates/navigation',$data);
                $this->load->view('usuarios/index');
                $this->load->view('templates/footer');
            } else{ redirect('/usuarios/index', 'refresh');}
            } else{redirect('/inicio/login', 'refresh'); }
        }

        public function reset_password($user_id, $ver_code)
        {
            if($this->aauth->verify_user($user_id, $ver_code))
            {
                $data= array('id'=>$user_id);
                $this->load->view('usuarios/ResetPassword',$data);
            }
            else {redirect('/inicio/login', 'refresh');}
        }

        public function editRePass()
        {
            if($this->aauth->is_loggedin())
            {
                if($_SESSION['tipo']=="SU" || $_SESSION['tipo']=="admin")
                {
                if($this->aauth->update_user($this->input->post('id'),FALSE,$this->input->post('contrasena'),FALSE))
                {redirect('inicio/logout', 'refresh');}
                } else{ redirect('/usuarios/index', 'refresh');}
            } else{ redirect('/inicio/login', 'refresh'); }
        }
       public function bloquear($usuario)
        {
            if($this->aauth->is_loggedin())
            {
                if($_SESSION['tipo']=="SU" || $_SESSION['tipo']=="admin")
                {
                    date_default_timezone_set("America/Mexico_City");
                    $usuario2 = array(
                        'usuario' => $_SESSION['nombreU'],
                        'tipo_mov' => '',
                        'no_banco' => '',
                        'no_mov' => '',
                        'accion' => 'Bloquear',
                        'cuando' => date('Y-m-d H:i:s'),
                        'comentario' => 'Bloquio al usuario con el ID: '. $usuario,
                        'modulo' => 'Administrativo -> Usuarios'
                    );
                    $this->BitacoraModel->operacion($usuario2);
                $this->aauth->ban_user($usuario);
                header("Location:".base_url()."/usuarios/index", 301);
                exit();
                } else{ redirect('/usuarios/index', 'refresh');}
            } else{ redirect('/inicio/login', 'refresh'); }
        }
        public function desbloquear($usuario)
        {
            if($this->aauth->is_loggedin())
            {
                if($_SESSION['tipo']=="SU" || $_SESSION['tipo']=="admin")
                {
                    date_default_timezone_set("America/Mexico_City");
                    $usuario2 = array(
                        'usuario' => $_SESSION['nombreU'],
                        'tipo_mov' => '',
                        'no_banco' => '',
                        'no_mov' => '',
                        'accion' => 'Desbloquear',
                        'cuando' => date('Y-m-d H:i:s'),
                        'comentario' => 'Desbloquio al usuario con el ID: '. $usuario,
                        'modulo' => 'Administrativo -> Usuarios'
                    );
                    $this->BitacoraModel->operacion($usuario2);
                $this->aauth->unban_user($usuario);
                header("Location:".base_url()."/usuarios/index", 301);
                exit();
                } else{ redirect('/usuarios/index', 'refresh');}
            } else{redirect('/inicio/login', 'refresh'); }
        }

        //Función para verificar y cambiar la contraseña de un usuario
        public function verificacion($id,$verificacion,$contrasena)
        {
            if($this->aauth->verify_user($id,$verificacion))
            {
                $data= array('id'=>$id);
                $this->load->view('usuarios/ResetPassword',$data);
            }
        }

        //Función para eliminar al usuario
        public function eliminar($usuario)
        {
            date_default_timezone_set("America/Mexico_City");
            if($this->aauth->is_loggedin())
            {
                if($_SESSION['tipo']=="SU" || $_SESSION['tipo']=="admin")
                {
                $res=$this->aauth->delete_user($usuario);
                if($res==true)
                {
                    $usuario2 = array(
                        'usuario' => $_SESSION['nombreU'],
                        'tipo_mov' => '',
                        'no_banco' => '',
                        'no_mov' => '',
                        'accion' => 'Eliminar',
                        'cuando' => date('Y-m-d H:i:s'),
                        'comentario' => 'Elimino al usuario con el ID: '. $usuario,
                        'modulo' => 'Administrativo -> Usuarios'
                    );
                    $this->BitacoraModel->operacion($usuario2);

                    header("Location:".base_url()."/usuarios/index", 301);
                    exit();
                }
                } else{ redirect('/usuarios/index', 'refresh');}
            } else{ redirect('/inicio/login', 'refresh');}
        }
 }