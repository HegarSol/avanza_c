<?php
    defined('BASEPATH') or exit("No se permite el acceso directo al archivo");
    class usuariosModel extends MY_Model
    {

        private $db2;
        public function __construct()
        {
            parent::__construct();
            $this->table = 'aauth_users';
            $this->column_order = array('id','email','pass','banned');
            $this->column_search = array('id','email','pass','banned');
            $this->order = array('idEmpresa' => 'ASC');
            $this->db2 = $this->hegardb->getDatabase($_SESSION['idEmpresa']);
            if(!$this->db2){show_error('No se puede establecer conexion con la base de datos');}
        }
        public function datosUsuario($id)
        {
            $row = $this->db->select('*')->from('aauth_users')->where('id',$id)->get();
            return $row->result_array(); 
        }
        public function tipoUsuario($idE,$idU)
        {
            $this->db->select('*');
            $this->db->from('relusuarioempresa');
            $this->db->where('idUsuario',$idU);
            $this->db->where('idEmpresa',$idE);
            $query=$this->db->get();
            $row=$query->result_array();
            return $row[0]['tUsuario'];
        }
        public function correoDefault($idE,$idU)
        {
            $this->db->select('*');
            $this->db->from('relusuarioempresa');
            $this->db->where('idUsuario',$idU);
            $this->db->where('idEmpresa',$idE);
            $this->db->where('correoDefault !=','null');
            $this->db->where('correoDefault !=','');
            $query=$this->db->get();
            return $query->result_array();
        }
        public function agregarRelUsuarioEmpresa1($idU,$idEmpresa,$tu)
        {
            $data=array('idUsuario'=>$idU,'idEmpresa'=>$idEmpresa);
            $this->db->insert('relusuarioempresa',$data);
        }

        public function existeCorreoDefault($idU,$idEmpresa)
        {
            $this->db->select('*');
            $this->db->from('relusuarioempresa');
            $this->db->where('idUsuario',$idU);
            $this->db->where('idEmpresa',$idEmpresa);
            $this->db->where('correoDefault !=','');
            $this->db->where('correoDefault !=',NULL);
            $query=$this->db->get();
            $row=$query->result_array();
        }
        public function agregarRelUsuarioEmpresa($idU,$idEmpresa,$serie='',$correo='')
        {
            $this->db->select('*');
            $this->db->from('relusuarioempresa');
            $this->db->where('idUsuario',$idU);
            $this->db->where('idEmpresa',$idEmpresa);
            $query=$this->db->get();
            $row=$query->result_array();
            $data=array('idUsuario'=>$idU,'idEmpresa'=>$idEmpresa,'serieDefault'=>$serie,'correoDefault'=>$correo);
            if(count($row)>0)
            {
                $this->db->where('idUsuario',$idU);
                $this->db->where('idEmpresa',$idEmpresa);
                return $this->db->update('relusuarioempresa',$data);
            }
            else
            {
                return $this->db->insert('relusuarioempresa',$data);
            }
        }
        public function permisos()
        {
            if($_SESSION['tipo']=="SU")
            {
                $nivel = 3;
            }
            if($_SESSION['tipo']=="admin")
            {
                $nivel = 2;
            }
            $row=$this->db->where('tipo <=',$nivel)->get('formas');
            return $row->result_array();
        }
        public function permisosGrupos($if,$id,$read,$add,$edit,$del,$print)
        {
            $data = array('idForma' => $if,'idUsuario' => $id,'leer' => $read,'agregar' => $add,'editar' => $edit,'borrar' => $del,'print' => $print);
            return $this->db2->insert('permisos',$data);
        }
        public function permisosGruposAdmin($if,$id,$idEmpresa,$read,$add,$edit,$del,$print)
        {
            $data = array( 'idForma' => $if, 'idUsuario' => $id,'idEmpresa'=>$_SESSION['idEmpresa'],'leer' => $read, 'agregar' => $add, 'editar' => $edit, 'borrar' => $del,'print'=>$print);
            return $this->db2->insert('permisos', $data);
        }
        public function permisosEdit($id)
      {
        $row= $this->db2->select('*')->from('permisos')->where('idUsuario',$id)->get();
        return $row->result_array();
      }

      public function borrarPermisos($id)
      {
        $this->db2->where('idUsuario',$id);
        return $this->db2->delete('permisos');
      }
      public function actualizarPermisos($if, $id,$read,$add,$edit,$del,$print)
      {
        $data = array( 'idForma' => $if, 'idUsuario' => $id, 'leer' => $read, 'agregar' => $add, 'editar' => $edit, 'borrar' => $del,'print'=>$print);
        return $this->db2->insert('permisos', $data);
      }

      public function permisosPorFormaYGrupo($if)
      {
        $this->db2->select('*');
        $this->db2->from('permisos');
        $this->db2->where('idForma', $if);
        $this->db2->where('idUsuario',$_SESSION['id']);
        $query=$this->db2->get();
        return $query->result_array();
      }
    }