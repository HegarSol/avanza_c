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
        public function datosEmpresa2($id)
        {
            $this->db->select('*');
            $this->db->from('empresas');
            $this->db->where('idEmpresa',$id);
            $query=$this->db->get();
            return $query->result_array();
        }
        public function get_cuenta_existe_empresa($cuenta,$dessubcuenta)
        {
            $row = $this->dbEmpresa->select('*')->from('catalogocta')->where('cuenta',$cuenta)->where('sub_cta',$dessubcuenta)->get();
            return $row->result_array();
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
        public function buscarcuentamayor($data)
        {
            $row = $this->db2->select('*')->from('catalogocta')->where('cuenta',$data)->where('sub_cta',0)->get();
            return $row->result_array();            
        }
        public function datosCuentas($id)
        {
            $row = $this->db2->select('*')->from('catalogocta')->where('idcuenta',$id)->get();
            return $row->result_array();
        }
        public function get_cuenta($cuen,$subcu,$ssub_cta)
        {
            $row = $this->db2->select('*')->from('catalogocta')->where('cuenta',$cuen)->where('sub_cta',$subcu)->where('ssub_cta',$ssub_cta)->get();
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
        public function verificarreportecuenta($cuenta,$sub_cta,$ssub_cta)
        {
            $row = $this->db2->select('*')->from('catalogocta')->where('cuenta',$cuenta)->where('sub_cta',$sub_cta)->where('ssub_cta',$ssub_cta)->get();
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
        public function MaxCuentaExNa($data)
        {
            if($data == '105.01')
            {
                $row = $this->dbEmpresa->query('SELECT MAX(ca.sub_cta)+1 AS sub_cta  
                FROM catalogocta ca LEFT JOIN configuracion_cuentas cc 
                ON ca.cuenta = cc.cuenta
                WHERE ctasat = "105.01"'
                );
            }
            else
            {
                $row = $this->dbEmpresa->query('SELECT MAX(ca.sub_cta)+1 AS sub_cta  
                FROM catalogocta ca LEFT JOIN configuracion_cuentas cc 
                ON ca.cuenta = cc.cuenta
                WHERE ctasat = "105.02"'
                );
            }


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