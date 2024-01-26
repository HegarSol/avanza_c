<?php
defined('BASEPATH') or die('No direct access to script allowed');

class MY_Model extends CI_Model {
  var $dbEmpresa; // Controlador de la base de datos de la empresa
  var $table; // Nombre de la tabla que se estara usando
  var $column_order = array(); // Columnas por las cuales se podra ordenar
  var $column_search = array(); // Nombre de las columnas por las que se puede buscar
  var $order = array(); // Columnas de orden
  var $lastError = "";

  public function __construct($userDataBase = false)
  {
    parent::__construct();
    if($userDataBase && isset($_SESSION['idEmpresa'])){
      $this->dbEmpresa = $this->hegardb->getDatabase($_SESSION['idEmpresa']);
    }else {
      $this->dbEmpresa = $this->load->database('default',true);
    }
  }

  public function set_database($id_empresa)
  {
    $this->dbEmpresa = $this->hegardb->getDatabase($id_empresa);
  }

  public function get_datatables($where=FALSE, $join=FALSE)
  {
    if($where!=false){$this->where=$where;}
    if($join!=false){$this->join=$join;}
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
    $this->dbEmpresa->limit($_POST['length'], $_POST['start']);
    $query = $this->dbEmpresa->get();
    return $query->result();
  }

  private function _get_datatables_query(){
    $this->dbEmpresa->from($this->table);
    if(isset($this->join)){
      $this->dbEmpresa->join($this->join['tabla'], $this->join['condicion']);}
    if(isset($this->where))
    { $this->dbEmpresa->where($this->where); }

    $i = 0;

    foreach ($this->column_search as $item)
    {
      if($_POST['search']['value']) {
        if($i === 0)
        {
          $this->dbEmpresa->group_start();
          $this->dbEmpresa->like($item,$_POST['search']['value']);
        }
        else { $this->dbEmpresa->or_like($item, $_POST['search']['value']); }
        if(count($this->column_search) - 1 == $i)
          $this->dbEmpresa->group_end();
        $i++;
      }
    }
    $columns = $this->input->post('columns');
    if($columns)
    {
       foreach($columns as $column)
       {
          if($column['search']['value'])
             $this->dbEmpresa->where($column['name'], $column['search']['value']);
       }
    }
    if(isset($_POST['order'])){
      $this->dbEmpresa->order_by($this->column_order[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
    } else if(isset($this->order)) {
      $order = $this->order;
      $this->dbEmpresa->order_by(key($order),$order[key($order)]);
    }
  }

  public function count_filtered()
  {
    $this->_get_datatables_query();
    $query = $this->dbEmpresa->get();
    return $query->num_rows();
  }

  public function count_all(){
    $this->dbEmpresa->from($this->table);
    if(isset($this->join)){
      $this->dbEmpresa->join($this->join['tabla'], $this->join['condicion']);}
    if(isset($this->where)){
        $this->dbEmpresa->where($this->where);
    }
    return $this->dbEmpresa->count_all_results();
  }
}

 ?>
