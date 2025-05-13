<?php

defined('BASEPATH') or exit("No se permite el acceso directo al archivo");
class OperacionesModel extends MY_Model
{
    private $db2;

    public function __construct()
    {
        parent::__construct(true);
        $this->table = 'opera_banco_encabe';
        $this->column_order = array('id','no_mov','tipo_mov','no_banco','fecha','beneficia','concepto','monto');
        $this->column_search = array('id','no_mov','tipo_mov','no_banco','fecha','beneficia','concepto','monto');
        if(isset($_SESSION['idEmpresa'])){
            $this->db2 = $this->hegardb->getDatabase($_SESSION['idEmpresa']);
            if(!$this->db2){show_error('No se puede establecer conexion con la base de datos');}
        }
    }

    public function crearPoliza($datos)
    {
        $this->dbEmpresa->insert('opera_banco_encabe',$datos);
        return $this->dbEmpresa->insert_id();
    }
    public function editarPoliza($id,$datos)
    {
        $this->db2->where('id',$id);
        return $this->db2->update('opera_banco_encabe',$datos);
    }
    public function borrarPoliza($id)
    {
        $this->db2->where('id',$id);
        return $this->db2->delete('opera_banco_encabe');
    }
    public function borrarDetalle($id)
    {
        $this->db2->where('id_encabezado',$id);
        return $this->db2->delete('opera_banco_detalle');
    }
    public function guardarDetalle($detalle)
    {
        $this->db2->insert('opera_banco_detalle', $detalle);
        return $this->db2->insert_id();
    }
    public function getcuentanomina($cta,$subcta)
    {
        $row = $this->db2->select('*')->from('configctanomina')->where('cuenta',$cta)->where('sub_cta',$subcta)->get();
        return $row->result_array();
    }
    public function actualizarmovimiento($numero_banco,$tipo_movimento,$numero_movimento)
    {
        if($tipo_movimento == 'T')
        {
            $datos = array('movimiento' => $numero_movimento);

            $this->db2->where('no_banco',$numero_banco);
            $this->db2->update('catalogo_banco',$datos);
        }
        else if($tipo_movimento == "C")
        {
            $datos = array('cheques' => $numero_movimento);

            $this->db2->where('no_banco',$numero_banco);
            $this->db2->update('catalogo_banco',$datos);
        }
        else
        {
            $datos = array('depositos' => $numero_movimento);

            $this->db2->where('no_banco',$numero_banco);
            $this->db2->update('catalogo_banco',$datos);
        }
    }
    public function getpolizapagoproveedor($no_prov)
    {
        $this->db2->select('*');
        $this->db2->from('opera_banco_encabe');
        $this->db2->where('no_prov',$no_prov);         
        $this->db2->where('tieneCxP_pagos','1');
        $where = '(tipo_mov="T" and c_a="-" or tipo_mov="C" and c_a="-")';
        $this->db2->where($where);
        $row = $this->db2->get();

        return $row->result_array();
    }
    public function datosOpera($id)
    {
        $row = $this->db2->select('*')->from('opera_banco_encabe')->where('id',$id)->get();
        return $row->result_array();
    }
    public function detallepoliza($id)
    {
        $row = $this->db2->select('*')->from('opera_banco_detalle')->where('id_encabezado',$id)->order_by('cuenta','asc')->get();
        return $row->result_array();
    }
    public function checarPolizas($id)
    {
        $row = $this->db2->select('*')->from('opera_banco_encabe')->where('no_banco',$id)->get();
        return $row->result_array();
    }
    public function traerpolizaprovisiondetalle($mov)
    {
        $row = $this->db2->select('*')->from('opera_banco_detalle')->where('tipo_mov','P')->where('no_banco','0')->where('no_mov',$mov)->get();
        return $row->result_array();
    }
    public function maxid()
    {

        $con = '0001';
        $tipo = 'O';

        $año = substr($_SESSION['ano'], -2);
        $mes = $_SESSION['mes'];

        $query = $this->db2->select('IF(MAX(no_mov) > 0,MAX(no_mov)+1,CONCAT("'.$año.'","'.$mes.'","'.$con.'")) AS maxmov') 
        ->from('opera_banco_encabe') 
        ->where('tipo_mov = "'.$tipo.'" AND LEFT(no_mov,2) = "'.$año.'" AND SUBSTR(no_mov,3,2) = "'.$mes.'"');
        return $this->db2->get()->result_array();
    }
    public function maxidPro()
    {
        $row = $this->db2->select_max('id')->from('opera_banco_encabe')->where('tipo_mov','P')->get();
        $valor = $row->result_array();

        $row2 = $this->db2->select('*')->from('opera_banco_encabe')->where('id',$valor[0]['id'])->get();
        return $row2->result_array();
    }
    public function estadocomparativo($mes,$ano)
    {
       // var_dump($mes);

        $fechaini = date($ano.'-'.$mes.'-01 00:00:00');
        if($mes == '02')
        {
            $fechafin = date($ano.'-'.$mes.'-28 23:59:59');
        }
        else if($mes == '04' || $mes == '06' || $mes == '09' || $mes == '11')
        {
            $fechafin = date($ano.'-'.$mes.'-30 23:59:59');
        }
        else
        {
            $fechafin = date($ano.'-'.$mes.'-t 23:59:59');
        }



        $query = $this->db2->query('CALL getEstadoResultadoComparativo(\''.$fechaini.'\',\''.$fechafin.'\')');

     //   var_dump($query->result());
        $data = $query->result_array();

        return $data;
    }
    public function getprovicion($folio,$seri,$uuid)
    {
        $row = $this->db2->select('*')
        ->from('opera_banco_encabe')
        ->where('factura_provi',$folio)
        ->where('serie_prov',$seri)
        ->where('uuid_provi',$uuid)
        ->get();

        return $row->result_array();
    }
    public function existemesdiaria()
    {
        $row = $this->db2->select('*')
        ->from('opera_banco_encabe')
        ->where('tipo_mov','O')
        ->where('YEAR(fecha)',date('Y'))
        ->where('MONTH(fecha)',date('m'))
        ->get();

        return $row->result_array();
    }
    public function getruta($id)
    {
        $row = $this->db2->select('*')
        ->from('formato_cheques')
        ->where('banco',$id)
        ->get();

        return $row->result_array();
    }
    public function saldoinicial($cuenta,$subcuen,$subcu2,$fechaini)
    {
      $row = $this->db2->select('cuenta,sub_cta,SUM(IF(c_a = "+",monto,-monto)) as saldo')
      ->from('opera_banco_detalle')
      ->where('cuenta',$cuenta)
      ->where('sub_cta',$subcuen)
      ->where('ssub_cta',$subcu2)
      ->where('fecha <',$fechaini)
      ->group_by('cuenta,sub_cta')
      ->get();

      return $row->result_array();
    }
    public function auxiliarcliente($subcta,$fechaini,$fechafin)
    {
        $query = $this->db2->query('CALL getAuxiliarCliente(\''.$subcta.'\',\''.$fechaini.'\',\''.$fechafin.'\')');

        return $query->result();


    }
    public function auxiliardetalle($cuenta,$subcuenta,$subcuen2,$fechaini,$fechafin,$agrupa)
    {
       $this->db2->select('ac.tipo_mov,ac.no_banco,ac.no_mov,ac.cuenta,ac.sub_cta,ac.fecha,ac.c_a as signo,ac.monto,t.concepto as conceenca,ac.referencia as rece,ac.no_prov,t.beneficia,ac.concepto as concedeta')
       ->from('opera_banco_detalle ac')
       ->join('opera_banco_encabe t','ac.tipo_mov = t.tipo_mov AND ac.no_banco = t.no_banco AND ac.no_mov = t.no_mov','left')
       ->where('ac.cuenta',$cuenta)
       ->where('ac.sub_cta ',$subcuenta)
       ->where('ac.ssub_cta ',$subcuen2)
       ->where('ac.fecha >=',$fechaini)
       ->where('ac.fecha <=',$fechafin);
       if($agrupa == 1)
       {
          $this->db2->order_by('ac.referencia,ac.fecha');
       }
       else
       {
          $this->db2->order_by('ac.cuenta,ac.sub_cta,ac.fecha,ac.no_mov');
       }
     //  $this->db2->group_by('ac.tipo_mov,ac.no_banco,ac.no_mov');

       return $this->db2->get()->result();
    }
    public function balanza($inicial,$final,$cuentasmayor)
    {
        if($cuentasmayor == 1)
        {
            $this->db2->select('opera_banco_detalle.cuenta,opera_banco_detalle.sub_cta,opera_banco_detalle.ssub_cta,nombre,SUM(IF(fecha < "'.$inicial.'",IF(c_a = "+",monto,monto*-1),0.00)) as sini,
            SUM(IF(c_a = "+" AND fecha BETWEEN "'.$inicial.' "AND" '.$final.'",monto,0.00 )) as cargos,
            SUM(IF(c_a = "-" AND fecha BETWEEN "'.$inicial.' "AND" '.$final.'",monto,0.00 )) as abonos')
            ->from('opera_banco_detalle')
            ->join('catalogocta','catalogocta.cuenta = opera_banco_detalle.cuenta AND catalogocta.sub_cta = opera_banco_detalle.sub_cta AND catalogocta.ssub_cta = opera_banco_detalle.ssub_cta','left')
            ->where('fecha <=',$final)
            ->order_by('cuenta,sub_cta,ssub_cta','asc')
            ->group_by('cuenta,sub_cta,ssub_cta');
        }
        else
        {
            $this->db2->select('opera_banco_detalle.cuenta,opera_banco_detalle.sub_cta,opera_banco_detalle.ssub_cta,nombre,SUM(IF(fecha < "'.$inicial.'",IF(c_a = "+",monto,monto*-1),0.00)) as sini,
            SUM(IF(c_a = "+" AND fecha BETWEEN "'.$inicial.' "AND" '.$final.'",monto,0.00 )) as cargos,
            SUM(IF(c_a = "-" AND fecha BETWEEN "'.$inicial.' "AND" '.$final.'",monto,0.00 )) as abonos')
            ->from('opera_banco_detalle')
            ->join('catalogocta','catalogocta.cuenta = opera_banco_detalle.cuenta AND catalogocta.sub_cta = opera_banco_detalle.sub_cta AND catalogocta.ssub_cta = opera_banco_detalle.ssub_cta','left')
            ->where('fecha <=',$final)
            ->order_by('cuenta,sub_cta,ssub_cta','asc');
        }

        return $this->db2->get()->result_array();
    }
    public function libro($tipo,$fechaini,$fechafin)
    {
         $this->db2->select('t.tipo_mov,t.no_banco,t.no_mov,t.fecha,t.beneficia,t.concepto,ac.cuenta,ac.sub_cta,ac.ssub_cta,ac.nombre_cuenta,ac.monto,ac.c_a,ac.num_reg')
         ->from('opera_banco_encabe t')
         ->join('opera_banco_detalle ac','ac.tipo_mov = t.tipo_mov AND ac.no_banco = t.no_banco AND ac.no_mov = t.no_mov','right');
        //  ->join('catalogocta cat','ac.cuenta = cat.cuenta AND ac.sub_cta = cat.sub_cta','right');
         if($tipo == '*')
         {
            $this->db2->where('t.fecha BETWEEN "'.$fechaini.' "AND" '.$fechafin.'" ');
         }
         else
         {
            $this->db2->where('t.fecha BETWEEN "'.$fechaini.' "AND" '.$fechafin.'" ')
            ->where('t.tipo_mov',$tipo);
         }
         $this->db2->order_by('t.tipo_mov,t.no_banco,t.no_mov');
         return $this->db2->get()->result_array();

    }
    public function CrearTablaTemporal($datas)
    {
       
        $query = $this->db2->query("SHOW TABLES LIKE 'builtemporal'");

       if(count($query->result()) == 1)
       {
            foreach($datas as $data)
            {
                $data = array(
                    'cuenta' => $data['cuenta'],
                    'sub_cta' => $data['sub_cta'],
                    'ssub_cta' => $data['ssub_cta'],
                    'nombre_cta' => $data['nombre_cta'],
                    'importe' => $data['importe'],
                    'c_a' => $data['c_a']
                );
                $this->db2->insert('builtemporal', $data);
            }
       }
       else
       {
        $query = "CREATE TABLE `builtemporal` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
                `cuenta` smallint(6) DEFAULT NULL,
                `sub_cta` smallint(6) DEFAULT NULL,
                `ssub_cta` smallint(6) DEFAULT NULL,
                `nombre_cta` varchar(90) DEFAULT NULL,
                `importe` decimal(11,2) DEFAULT NULL,
                `c_a` char(3) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
            $this->db2->query($query);
            foreach($datas as $data)
            {
                $data = array(
                    'cuenta' => $data['cuenta'],
                    'sub_cta' => $data['sub_cta'],
                    'ssub_cta' => $data['ssub_cta'],
                    'nombre_cta' => $data['nombre_cta'],
                    'importe' => $data['importe'],
                    'c_a' => $data['c_a']
                );
                $this->db2->insert('builtemporal', $data);
            }
       }


    }
    public function obtenerTablaTemporal()
    {
        $row = $this->db2->select('*')->from('builtemporal')->get();
        return $row->result_array();
    }
    public function borrarTablaTemporal()
    {
        $query = $this->db2->query('DROP TABLE IF EXISTS builtemporal');
    }

}