<?php
 defined('BASEPATH') or exit("No se permite el acceso directo al archivo");
  class EmpresasModel extends MY_Model
  {

    private $db2;
    
      public function __construct()
      {
          parent::__construct();
          $this->table = 'empresas';
          $this->column_order = array('idEmpresa','rfcEmpresa','razon','tel');
          $this->column_search = array('idEmpresa','rfcEmpresa','razon','tel');
          $this->order = array('idEmpresa' => 'ASC');
          $this->db2 = $this->hegardb->getDatabase($_SESSION['idEmpresa']);
          if(!$this->db2){show_error('No se puede establecer conexion con la base de datos');}
      }

      public function crearEmpresa($datos,$id)
      {
          $this->db->insert('empresas',$datos);
          return $this->db->insert_id();
      }
      public function editarEmpresa($id,$datos)
      {
         $this->db->where('idEmpresa',$id);
         $editar=$this->db->update('empresas',$datos);
         return $editar;
      } 
      public function todasEmpresas($where=null)
      {
          $this->db->select('*');
          $this->db->from('empresas');
          $query=$this->db->get();
          return $query->result_array();
      }
      public function UsuariosPertenecenAEmpresa($id)
      {
         $this->db->select('u.id,u.name');
         $this->db->from('aauth_users as u');
         $this->db->join('relusuarioempresa rue','u.id = rue.idUsuario');
         $this->db->where('rue.idEmpresa',$id);
         $query = $this->db->get();
         return $query->result_array();
      }

      public function agregarRelUsuarioE($idU,$idEmpresa)
      {
          $this->db->where('idUsuario',$idU);
          $this->db->where('idEmpresa',$idEmpresa);
          $this->db->delete('relusuarioempresa');
          $data=array('idUsuario' => $idU,'idEmpresa'=>$idEmpresa);
          return $this->db->insert('relusuarioempresa',$data);
      }
      public function eliminarRelUsuarioE($idU,$idEmpresa)
      {
          $this->db->where('idUsuario',$idU);
          $this->db->where('idEmpresa',$idEmpresa);
          return $this->db->delete('relusuarioempresa');
      } 
      public function getConfiguracion($id)
      {
          $this->db2 = $this->hegardb->getDatabase($id);
          $this->db2->select('*');
          $this->db2->from('configuraciones');
          $query=$this->db2->get();
          return $query->result_array();
      } 
      public function guardarConfig($id,$idC,$valor)
      {
          $datos=array('valor'=>$valor);
          $this->db2 = $this->hegardb->getDatabase($id);
          $this->db2->where('idConfiguracion',$idC);
          return $this->db2->update('configuraciones',$datos);
      }
      public function datosEmpresa($id)
        {
        $this->db->select('*');
        $this->db->from('empresas');
        $this->db->where('idEmpresa', $id);
        $query=$this->db->get();
        return $query->result_array();
        }
        public function EsAdmin($id)
        {
        $this->db->select('*');
        $this->db->from('empresas');
        $this->db->where('idAdmin',$id);
        $query=$this->db->get();
        return $query->result_array();
        }
  }