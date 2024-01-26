<?php
    class MY_Controller extends CI_Controller{
        function __construct()
        {
            parent::__construct();
            if(!$this->aauth->is_loggedin())
            { 
                redirect('inicio/login'); 
            }
            $this->load->model('MenuModel','menu');
             $items = $this->menu->menus($_SESSION['tipo']);
             $this->multi_menu->set_items($items);
        }

        public function permisosForma($id,$idF)
        {
            $leer=0; $add=0; $edit=0; $del=0; $print=0;
            if($this->session->tipo != 'usuario'){
                return array(
                    'leer' => 1,
                    'add' => 1,
                    'edit' => 1,
                    'del' => 1,
                    'print' => 1
                );
            }
            else
            {
            $this->load->model("usuariosModel");
            $items=$this->usuariosModel->permisosPorFormaYGrupo($idF);
            if(count($items)>0)
            {
                if($items[0]['leer']==1){ $leer=1;}
                if($items[0]['agregar']==1){ $add=1;}
                if($items[0]['editar']==1){ $edit=1;}
                if($items[0]['borrar']==1){ $del=1;}
                if($items[0]['print']==1){ $print=1;}
            }
          }
            return $permisosFinal= array( "leer" => $leer, "add" => $add, "edit" => $edit, "del" => $del,'print'=>$print );
        }
    }
?>
