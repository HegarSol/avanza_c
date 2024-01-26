<?php
defined("BASEPATH") or exit("No se permite el acceso directo al script");

class ValidaEmpresas
{
    public $CI;

    /**
     * 
     * Array para almacenar los errores
     * @access public
     * @var array
     */
    public $errores = array();

    //Constructor
    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->database();
    }

    #################################
    # Funciones Publicas
    #################################

    /**
     * ValidaE
     * Realiza la validacion de las empresas, si se encuentra
     * màs de una registrada envia a la vista de SelecEmpresa, de lo contrario
     * asigna la variable $_SESSION['idEmpresa'] 
     */

     public function validaE()
     {
         $bbool = false;
         if(isset($_SESSION['id']))
         {
           $this->CI->db->select('e.idEmpresa, e.rfcEmpresa,e.razon,rue.tUsuario,e.idAdmin');
           $this->CI->db->from('empresas e');
           $this->CI->db->join('relusuarioempresa rue','e.idEmpresa = rue.idEmpresa');
           $this->CI->db->where('rue.idUsuario', $_SESSION['id']);
           $query = $this->CI->db->get();
           $row = $query->result_array();
           if(count($row>0))
           {
               if(count($row)==1)
               {
                $_SESSION['idEmpresa']=$row[0]['idEmpresa'];
                  //  $_SESSION['idEmpresa']=$row[0]['idEmpresa'];
                  //  if($row[0]['idAdmin']==$_SESSION['id'] && $_SESSION['tipo']=='SU' && $_SESSION['tipo']!= 'hegar')
                  //  {
                  //       $_SESSION['tipo']='admin';
                  //  }
                  //  else if($_SESSION['tipo']!="SU" && $_SESSION['tipo']!='hegar')
                  //  {
                  //       $_SESSION['tipo']='usuario';
                  //  }
                   $bbool=true;
                   $_SESSION['unica']=1;
               }
               else
               {
                   $bbool=$row;
                   $_SESSION['unica']=0;
               }
           }
           else
           {
             $this->error('No se encuentra una empresa asignada a este usaurio.');
             $bbool=false;
           }
         }
         else
         {
             return $this->error('No se ha iniciado la sesión');
             $bbool=false;
         }
         return $bbool;
     }

         /**
  	 * Error
  	 * Agrega un mensaje al array
  	 * @param string $message Error a agregar al array
  	 */
  	public function error($message = '')
    { $this->errors[] = $message; }

    public function get_errors()
    {

      if (!count($this->errors)==0)
      { return $this->errors; }
      else
      { return array(); }
    }

     public function get_tipo($id)
     {
       $this->CI->db->select('tUsuario');
       $this->CI->db->from('relusuarioempresa');
       $this->CI->db->where('idEmpresa', $id);
       $query=$this->CI->db->get();
       $row= $query->result_array();
       return $row[0]['tUsuario'];
     }
 
     public function get_razon($id)
     {
       $this->CI->db->select('razon');
       $this->CI->db->from('empresas');
       $this->CI->db->where('idEmpresa', $id);
       $query=$this->CI->db->get();
       $row= $query->result_array();
       $_SESSION['razon']= $row[0]['razon'];
       return true;
     }
}