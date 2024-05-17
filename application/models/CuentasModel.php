<?php
  defined('BASEPATH') or exit("No se permite el acceso directo al archivo");
   class CuentasModel extends MY_Model
   {
       private $db2;

       
       public function __construct()
       {
           parent::__construct(true);
           $this->table = 'catalogocta';
           $this->column_order = array('cuenta','sub_cta','ssub_cta');
           $this->column_search = array('idcuenta','cuenta','sub_cta','nombre','tipo','ctasat','natur','cvecobro','ssub_cta');
           if(isset($_SESSION['idEmpresa'])){
             $this->db2 = $this->hegardb->getDatabase($_SESSION['idEmpresa']);
             if(!$this->db2){show_error('No se puede establecer conexion con la base de datos');}
           }
        }

        public function crearCuenta($datos)
        {
            $this->dbEmpresa->insert('catalogocta',$datos);
            return $this->dbEmpresa->insert_id();
        }
        public function getConfig()
        {
            $row = $this->db2->select('*')->from('configuraciones')->where('id_configuracion',1)->get();
            return $row->result_array();
        }
        public function getCuentas()
        {
            $row = $this->db2->select('*')->from('catalogocta')->order_by('cuenta','sub_cta','ssub_cta')->get();
            return $row->result_array();
        } 
        public function editarCuenta($id,$datos)
        {
            $this->db2->where('idcuenta',$id);
            return $this->db2->update('catalogocta',$datos);
        }
        public function datosCuentas($id)
        {
            $row = $this->db2->select('*')->from('catalogocta')->where('idcuenta',$id)->get();
            return $row->result_array();
        }
        public function get_cuenta($cuen,$subcu)
        {
            $row = $this->db2->select('*')->from('catalogocta')->where('cuenta',$cuen)->where('sub_cta',$subcu)->get();
            return $row->result_array();
        }
        public function get_cuenta_existe($cuenta,$dessubcuenta)
        {
            $row = $this->db2->select('*')->from('catalogocta')->where('cuenta',$cuenta)->where('sub_cta',$dessubcuenta)->get();
            return $row->result_array();
        }
        public function verificarsiexiste($cuenta,$sub_cta,$ssub_cta)
        {
            $row = $this->db2->select('*')->from('catalogocta')->where('cuenta',$cuenta)->where('sub_cta',$sub_cta)->where('ssub_cta',$ssub_cta)->get();
            return $row->result_array();
        }
        public function verificarreportecuenta($cuenta,$sub_cta)
        {
            $row = $this->db2->select('*')->from('catalogocta')->where('cuenta',$cuenta)->where('sub_cta',$sub_cta)->get();
            return $row->result_array();
        }
        public function borrarCuenta($id)
        {
            $this->db2->where('idcuenta', $id);
	        return $this->db2->delete('catalogocta');
        }
        public function buscarcuentas($cuen)
        {
            $row = $this->db2->select('*')->from('catalogocta')->where('cuenta',$cuen)->get();
            return $row->result_array();
        }
        public function getpagado($fechaini,$fechafin)
        {
            $query = $this->db2->query('CALL getefePagado(\''.$fechaini.'\',\''.$fechafin.'\')');
            return $query->result();
        }
        public function getdiot($fechaini,$fechafin)
        {
            $query = $this->db2->query('CALL getDiot(\''.$fechaini.'\',\''.$fechafin.'\')');
            return $query->result();
        }
        public function getestadoresultado($tf0,$tfi,$tff)
        {
            $query = $this->db2->query('CALL getEstadoResultado(\''.$tf0.'\',\''.$tfi.'\',\''.$tff.'\')');
            return $query->result();
        }

   }