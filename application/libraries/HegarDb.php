<?php
defined("BASEPATH") or exit("No se permite el acceso directo al script");

/**
 * HegarDb es una clase para el manejo de multiples bases de datos en una misma
 * aplicacion de codeigniter
 *
 * @author  Ing. Guadalupe Garza Moreno
 *
 * @copyright 2017 HEGAR Soluciones en Sistemas S. de R.L.
 *
 * @version 1.0
 */
class HegarDb {

  /**
   * La variable al objeto de codeigniter
   * @access public
   * @var object
   */
   public $CI;

   /**
    * Variable para cargar las configuraciones
    * @access public
    * @var array
    */
   public $config_vars;

   ##################################
   # Funciones Basicas
   ##################################

   /**
    * Constructor
    */
   public function __construct()
   {
     // Obteniendo el objeto principal de CodeIgniter
     $this->CI = & get_instance();
     $this->CI->load->database();

     // Cargamos la configuracion de la libreria
     $this->CI->load->config('hegar_d');
     $this->config_vars = $this->CI->config->item('hegar_d');
   }

   ###################################
   # Funciones Publicas
   ###################################

   /**
    * Obtiene el objeto de base de datos para poder usado con los datos de la
    * configuracion especificada
    *
    * @param string $id   Identificador del registro que se desea cargar
    * @return object|null
    */
   public function getDatabase($id)
   {
     return $this->CI->load->database($this->getConfig($id), true);
   }

   public function getConfig($id)
   {
     $this->CI->db->where($this->config_vars['key'], $id);
     $this->CI->db->from($this->config_vars['table_name']);
     $row = $this->CI->db->get()->row_array();
     if(!$row){
       show_error("No se encontro el registro especificado de configuracion: ");
     }
     $conn['hostname'] = $row[$this->config_vars['host']];
     $conn['username'] = $row[$this->config_vars['user_name']];
     $conn['password'] = $row[$this->config_vars['password']];
     $conn['database'] = $row[$this->config_vars['database_name']];
     $conn['dbdriver'] = 'mysqli';
     $conn['dbprefix'] = '';
     $conn['pconnect'] = FALSE;
     $conn['db_debug'] = (ENVIRONMENT !== 'production');
     $conn['cache_on'] = FALSE;
     $conn['cachedir'] = '';
     $conn['char_set'] = 'utf8';
     $conn['dbcollat'] = 'utf8_general_ci';
     return $conn;
   }
}

 ?>
