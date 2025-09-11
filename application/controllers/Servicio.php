<?php

class Servicio extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
       $this->pendientes();
      // $this->cancelados();
    }
    public function pendientes()
    {
        $json = file_get_contents('empresas.json');
        $data = json_decode($json, true);
        $inserycance = 1;

        foreach($data as $dat)
        {

            if(ENVIRONMENT == 'development')
            {
               $ch = curl_init("http://localhost:85/avanza_facturacion_github/api/Contabilidad/obtener_polizas_ingreso?id=".$dat['IdEmpresa']);
            }
            else
            {
                $ch = curl_init("https://avanzaf.hegarss.com/api/Contabilidad/obtener_polizas_ingreso?id=".$dat['IdEmpresa']);
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $resu = curl_exec($ch);
            $response = json_decode($resu);

                    if(isset($dat['IdEmpresa'])){
                        $this->db2 = $this->hegardb->getDatabase($dat['IdEmpresa']);
                        if(!$this->db2)
                        {
                            show_error('No se puede establecer conexion con la base de datos: '.$dat['IdEmpresa']);
                        }
                    }

                    if(count($response) > 0)
                    {
                       $this->insertar($response,$dat['IdEmpresa'],$inserycance);
                    }
        }
    }
    // public function cancelados()
    // {
    //     $json = file_get_contents('empresas.json');
    //     $data = json_decode($json, true);
    //     $inserycance = 0;

    //     foreach($data as $dat)
    //     {
    //         if(ENVIRONMENT == 'development')
    //         {
    //             $ch = curl_init("http://localhost:85/avanza_facturacion_github/api/Contabilidad/obtener_polizas_cancelacion?id=".$dat['IdEmpresa']);
    //         }
    //         else
    //         {
    //             $ch = curl_init("https://avanzaf.hegarss.com/api/Contabilidad/obtener_polizas_cancelacion?id=".$dat['IdEmpresa']);
    //         }
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //         $resu = curl_exec($ch);
    //         $response = json_decode($resu);

    //                 if(isset($dat['IdEmpresa'])){
    //                     $this->db2 = $this->hegardb->getDatabase($dat['IdEmpresa']);
    //                     if(!$this->db2)
    //                     {
    //                         show_error('No se puede establecer conexion con la base de datos: '.$dat['IdEmpresa']);
    //                     }
    //                 }
                  
    //              if(count($response) > 0)
    //              {
    //                 $this->insertar($response,$dat['IdEmpresa'],$inserycance);
    //              }
    //     }
    // }
    public function insertar($response,$idempresa,$inserycance)
    {
        foreach($response as $inserpo)
        {

            // if($inserycance == 1)
            //     {
                    $this->db2->where('tipo_mov', $inserpo->tipo_mov);
                    $this->db2->where('no_banco', $inserpo->no_banco);
                    $this->db2->where('no_mov', $inserpo->no_mov);
                    $this->db2->delete('opera_banco_detalle');
               // }

            foreach($inserpo->poliza as $poliza)
            {
                $datos = array(
                    'tipo_mov' => $inserpo->tipo_mov == 'I' ? $inserpo->tipo_mov : 'X',
                    'no_banco' => $inserpo->no_banco,
                    'no_mov' => $inserpo->no_mov,
                    'cuenta' => (int) $poliza->cuenta,
                    'ren' => 0,
                    'referencia' => $inserpo->serie.$inserpo->no_mov,
                    'sub_cta' => (int) $poliza->sub_cta,
                    'monto' => $poliza->monto,
                    'c_a' => $poliza->c_a,
                    'fecha' => $inserpo->fecha,
                    'concepto' => $inserpo->nombreC,
                    'ssub_cta' => 0,
                );

                $this->db2->trans_begin();
                $this->db2->insert('opera_banco_detalle', $datos);
                if ($this->db2->trans_status() === FALSE)
                {
                        $this->db2->trans_rollback();
                }
                else
                {
                    $this->db2->trans_commit();
                    if($inserpo->tipo_mov == 'X')
                    {
                        $cancelacion = '1';
                        $poliza = 'X'.$inserpo->no_banco.$inserpo->no_mov;
                    }
                    else
                    {
                        $cancelacion = '';
                        $poliza = $inserpo->tipo_mov.$inserpo->no_banco.$inserpo->no_mov;
                    }

                    $this->actualizar($idempresa,$inserpo->id_factura,$poliza,$cancelacion);
                }
            }
        }
    }
    public function actualizar($idempresa,$idFactura,$poliza,$cancelacion)
    {

        if(ENVIRONMENT == 'development')
        {
        $ch = curl_init("http://localhost:85/avanza_facturacion_github/api/Contabilidad/establece_contabilizada");
        }
        else
        {
            $ch = curl_init("https://avanzaf.hegarss.com/api/Contabilidad/establece_contabilizada");
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "id_empresa=".$idempresa."&id_factura=".$idFactura."&poliza=".$poliza."&cancelacion=".$cancelacion);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $resu = curl_exec($ch);
        $response = json_decode($resu);
    }
}