<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('menuModel');
        $items=$this->menuModel->menus($_SESSION['tipo']);
        $this->multi_menu->set_items($items);
        $this->load->view('templates/header');
        $this->load->model('BancosModel','bancos');
        $this->load->model('BitacoraModel','bitacora');
        $this->load->model('OperacionesModel','opera');
        $this->load->model('EmpresasModel','empresas');
        $this->load->model('BeneficiarioModel','benefi');
    }
    public function index($id)
    {
        if($this->aauth->is_loggedin())
        {
            $errores=array();
            $datosbanco = $this->bancos->datosBancos($id);
            $data=array('titulo'=>'Importación de archivos (nómina)','no_banco'=>$id,'datosbanco'=> $datosbanco,'razon'=>$this->validaempresas->get_razon($_SESSION['idEmpresa']),'errores'=>$errores);
            $items=$this->menuModel->menus($_SESSION['tipo']);
            $this->multi_menu->set_items($items);
            $this->load->view('templates/header');
            $this->load->view('templates/navigation',$data);
            $this->load->view('importan/index');
            $this->load->view('templates/footer');
        }
        else
        {
            redirect('/inicio/login','refresh');
        }
    }
    public function getNomina()
    {
        $id = $this->input->post('id');
        $fechap = $this->input->post('fechap');
        $configNueva=$this->empresas->datosEmpresa($_SESSION['idEmpresa']);


        if(ENVIRONMENT == 'development')
        {
           $ch = curl_init("http://localhost:8000/ajuste/show?idEmpresa=".$configNueva[0]['idNomina']."&fechapago=".$fechap);
        }
        else
        {
           $ch = curl_init("http://avanzan.hegarss.com/ajuste/show?idEmpresa=".$configNueva[0]['idNomina']."&fechapago=".$fechap);
        }              
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $resu = curl_exec($ch);
        $response = json_decode($resu);

       $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function insertpolizar()
    {
        $chek = $this->input->post('chek');
        $concep = $this->input->post('concep');
        $refe = $this->input->post('refe');
        $idbanco = $this->input->post('id');
        $fechapago = $this->input->post('fechapago');  


        foreach($chek as $checar)
        {
            $datos=$this->bancos->datosBancos($idbanco);

            // $checar[0]    tipo,
            // $checar[1]    nombre,
            // $checar[2]    sueldo,
            // $checar[3]    tiempo_extra,
            // $checar[4]    vacaciones,
            // $checar[5]    aguinaldo, 
            // $checar[6]    ptu, 
            // $checar[7]    indemnizaciones,
            // $checar[8]    otras_perce,
            // $checar[9]    vales_despensa,
            // $checar[10]    gratificaciones,
            // $checar[11]    premio_puntualidad,
            // $checar[12]    asistencia,
            // $checar[13]    guarderias,
            // $checar[14]    dias_festivos,
            // $checar[15]    fondo_ahorro,
            // $checar[16]    prima_vacacional,
            // $checar[17]    ayuda_funeraria,
            // $checar[18]    prima_dominical,
            // $checar[19]    extras_triples,
            // $checar[20]    pagos_separacion,
            // $checar[21]    prima_antiguedad,
            // $checar[22]    jubi_pen_ha_re,
            // $checar[23]    jubi_pen_ha_re_par,
            // $checar[24]    subsi_incapaci,
            // $checar[25]    asimilados,
            // $checar[26]    septimo_dias,
            // $checar[27]    descanso_labora,

            // $checar[28]    isr,
            // $checar[29]    imss,
            // $checar[30]    infonavit,
            // $checar[31]    prestamo,
            // $checar[32]    ahorro_sindical,
            // $checar[33]    ahorro_bancario,
            // $checar[34]    otras_deducion,

            // $checar[35]    ajuste_subsi_causado,
            // $checar[36]    ajuste_subsi_empleo,
            // $checar[37]    isr_ajustado,
            // $checar[38]    descuen_incapaci,
            // $checar[39]    pension_alimen,
            // $checar[40]    reintegro_isr_pagado,
            // $checar[41]    subsidio_para_empleo,
            // $checar[42]    viaticos,
            // $checar[43]    aplica_saldo_favor_compensa,
            // $checar[44]    reinte_isr_ret,
            // $checar[45]    alimentos_bienes,
            // $checar[46]    isr_ajustado_subsidio,
            // $checar[47]    subsio_efec_entrega,
            // $checar[48]    pago_disti_listados_suedo,
            // $checar[49]    total_percepciones,
            // $checar[50]    total_deducciones,
            // $checar[51]    total_otros_pagos 

          $nombreemple = $this->benefi->buscarnombre($checar[1]);
        
          $nombrebanco = $this->benefi->buscarbanco($nombreemple[0]['no_prov']);

       //  var_dump($nombrebanco);

          if($checar[0] == 'Transferencia')
            {
                $tipo = 'T';
            }
            else
            {
                $tipo = 'C';
            }

            $next_mov = $tipo == 'T' ? $datos[0]['movimiento'] + 1 : $datos[0]['cheques'] + 1;

                 $total = (($checar[49] - $checar[50]) + $checar[51]);
                 $datosinsert = array(
                    'tipo_mov' => $tipo,
                    'no_banco' => $datos[0]['no_banco'],
                    'no_mov' => $next_mov,
                    'fecha' => date('Y-m-d'),
                    'beneficia' => $checar[1],
                    'concepto' => $refe.' '.$concep,
                    'monto' => $total,
                    'c_a' => '-',
                    'cobrado' => 1,
                    'cerrado' => 0,
                    'no_prov' => $nombreemple[0]['no_prov'],
                    'fechaCobro' => NULL,
                    'impreso' => 0,
                    'afectar' => 0,
                    'bancosat' => isset($nombrebanco[0]['bancoSat']) ? $nombrebanco[0]['bancoSat'] : '',
                    'bene_ctaban' => isset($nombrebanco[0]['nombre']) ? $nombrebanco[0]['nombre'] : '',
                    'tieneCxP_pagos' => 0,
                    'cta_banco' => isset($nombrebanco[0]['ctaBan']) ? $nombrebanco[0]['ctaBan'] : '',
                    'tipo_proveedor' => ''
                );
                $id = $this->opera->crearPoliza($datosinsert);
                $this->opera->actualizarmovimiento($datos[0]['no_banco'],$tipo,$next_mov);

                //SE INSERTA PRIMERO EL ASIENTO DEL BANCO
                $detalle = array(
                    'id_encabezado' => $id,
                    'tipo_mov' => $tipo,
                    'no_banco' => $datos[0]['no_banco'],
                    'no_mov' => $next_mov,
                    'ren' => 0,
                    'cuenta' => $datos[0]['cta'],
                    'sub_cta' => $datos[0]['sub_cta'],
                    'monto' => $total,
                    'c_a' => '-',
                    'fecha' => date('Y-m-d'),
                    'concepto' => $checar[1],
                    'referencia' => $refe,
                    'no_prov' => 0,
                    'factrefe' => 0,
                    'nombre_cuenta' => $datos[0]['banco'],
                    'ssub_cta' => $datos[0]['ssub_cta'],
                 );

                 $detalle= $this->opera->guardarDetalle($detalle); 
                 
                 //SUELDOS

               if($checar[2] > 0)
               {
                   $valorsuel = $this->opera->getcuentanomina(601,5);
                  // var_dump($valorsuel);

                   $detalle = array(
                    'id_encabezado' => $id,
                    'tipo_mov' => $tipo,
                    'no_banco' => $datos[0]['no_banco'],
                    'no_mov' => $next_mov,
                    'ren' => 0,
                    'cuenta' => $valorsuel[0]['cuenta'],
                    'sub_cta' => $valorsuel[0]['sub_cta'],
                    'monto' => $checar[2],
                    'c_a' => '+',
                    'fecha' => date('Y-m-d'),
                    'concepto' => $checar[1],
                    'referencia' => $refe,
                    'no_prov' => $nombreemple[0]['no_prov'],
                    'factrefe' => 0,
                    'nombre_cuenta' => $valorsuel[0]['descrip'],
                    'ssub_cta' => $valorsuel[0]['ssub_cta'],
                 );

                 $detalle= $this->opera->guardarDetalle($detalle);  
               }

               //AGUINALDO

               if($checar[5] > 0)
               {
                        $valorsuel = $this->opera->getcuentanomina(601,10);
                        // var_dump($valorsuel);

                        $detalle = array(
                        'id_encabezado' => $id,
                        'tipo_mov' => $tipo,
                        'no_banco' => $datos[0]['no_banco'],
                        'no_mov' => $next_mov,
                        'ren' => 0,
                        'cuenta' => $valorsuel[0]['cuenta'],
                        'sub_cta' => $valorsuel[0]['sub_cta'],
                        'monto' => $checar[5],
                        'c_a' => '+',
                        'fecha' => date('Y-m-d'),
                        'concepto' =>$checar[1],
                        'referencia' => $refe,
                        'no_prov' => $nombreemple[0]['no_prov'],
                        'factrefe' => 0,
                        'nombre_cuenta' => $valorsuel[0]['descrip'],
                        'ssub_cta' => $valorsuel[0]['ssub_cta'],
                    );

                    $detalle= $this->opera->guardarDetalle($detalle);  
               }

               //PREMIO PUNTUALIDAD

               if($checar[11] > 0)
               {
                        $valorsuel = $this->opera->getcuentanomina(601,100);
                        // var_dump($valorsuel);

                        $detalle = array(
                        'id_encabezado' => $id,
                        'tipo_mov' => $tipo,
                        'no_banco' => $datos[0]['no_banco'],
                        'no_mov' => $next_mov,
                        'ren' => 0,
                        'cuenta' => $valorsuel[0]['cuenta'],
                        'sub_cta' => $valorsuel[0]['sub_cta'],
                        'monto' => $checar[11],
                        'c_a' => '+',
                        'fecha' => date('Y-m-d'),
                        'concepto' =>$checar[1],
                        'referencia' => $refe,
                        'no_prov' => $nombreemple[0]['no_prov'],
                        'factrefe' => 0,
                        'nombre_cuenta' => $valorsuel[0]['descrip'],
                        'ssub_cta' => $valorsuel[0]['ssub_cta'],
                    );

                    $detalle= $this->opera->guardarDetalle($detalle);  
               }

               //VACACIONES

               if($checar[4] > 0)
               {
                       $valorsuel = $this->opera->getcuentanomina(601,7);
                        // var_dump($valorsuel);

                        $detalle = array(
                        'id_encabezado' => $id,
                        'tipo_mov' => $tipo,
                        'no_banco' => $datos[0]['no_banco'],
                        'no_mov' => $next_mov,
                        'ren' => 0,
                        'cuenta' => $valorsuel[0]['cuenta'],
                        'sub_cta' => $valorsuel[0]['sub_cta'],
                        'monto' => $checar[4],
                        'c_a' => '+',
                        'fecha' => date('Y-m-d'),
                        'concepto' => $checar[1],
                        'referencia' => $refe,
                        'no_prov' => $nombreemple[0]['no_prov'],
                        'factrefe' => 0,
                        'nombre_cuenta' => $valorsuel[0]['descrip'],
                        'ssub_cta' => $valorsuel[0]['ssub_cta'],
                        );

                    $detalle= $this->opera->guardarDetalle($detalle); 
               }

               //PRIMA VACACIONAL

               if($checar[16] > 0)
               {
                    $valorsuel = $this->opera->getcuentanomina(601,59);
                    // var_dump($valorsuel);

                    $detalle = array(
                    'id_encabezado' => $id,
                    'tipo_mov' => $tipo,
                    'no_banco' => $datos[0]['no_banco'],
                    'no_mov' => $next_mov,
                    'ren' => 0,
                    'cuenta' => $valorsuel[0]['cuenta'],
                    'sub_cta' => $valorsuel[0]['sub_cta'],
                    'monto' => $checar[16],
                    'c_a' => '+',
                    'fecha' => date('Y-m-d'),
                    'concepto' => $checar[1],
                    'referencia' => $refe,
                    'no_prov' => $nombreemple[0]['no_prov'],
                    'factrefe' => 0,
                    'nombre_cuenta' => $valorsuel[0]['descrip'],
                    'ssub_cta' => $valorsuel[0]['ssub_cta'],
                    );

                   $detalle= $this->opera->guardarDetalle($detalle);  
               }

               //P.T.U

               if($checar[6] > 0)
               {
                    $valorsuel = $this->opera->getcuentanomina(601,9);
                    // var_dump($valorsuel);

                    $detalle = array(
                    'id_encabezado' => $id,
                    'tipo_mov' => $tipo,
                    'no_banco' => $datos[0]['no_banco'],
                    'no_mov' => $next_mov,
                    'ren' => 0,
                    'cuenta' => $valorsuel[0]['cuenta'],
                    'sub_cta' => $valorsuel[0]['sub_cta'],
                    'monto' => $checar[6],
                    'c_a' => '+',
                    'fecha' => date('Y-m-d'),
                    'concepto' => $checar[1],
                    'referencia' => $refe,
                    'no_prov' => $nombreemple[0]['no_prov'],
                    'factrefe' => 0,
                    'nombre_cuenta' => $valorsuel[0]['descrip'],
                    'ssub_cta' => $valorsuel[0]['ssub_cta'],
                    );

                $detalle= $this->opera->guardarDetalle($detalle);  
               }

               //INDEMIZACIONES

               if($checar[7] > 0)
               {
                     $valorsuel = $this->opera->getcuentanomina(601,8);
                        // var_dump($valorsuel);

                        $detalle = array(
                        'id_encabezado' => $id,
                        'tipo_mov' => $tipo,
                        'no_banco' => $datos[0]['no_banco'],
                        'no_mov' => $next_mov,
                        'ren' => 0,
                        'cuenta' => $valorsuel[0]['cuenta'],
                        'sub_cta' => $valorsuel[0]['sub_cta'],
                        'monto' => $checar[7],
                        'c_a' => '+',
                        'fecha' => date('Y-m-d'),
                        'concepto' =>$checar[1],
                        'referencia' => $refe,
                        'no_prov' => $nombreemple[0]['no_prov'],
                        'factrefe' => 0,
                        'nombre_cuenta' => $valorsuel[0]['descrip'],
                        'ssub_cta' => $valorsuel[0]['ssub_cta'],
                        );

                    $detalle= $this->opera->guardarDetalle($detalle); 
               }

               //OTRAS PERCEPCIONES

               if($checar[8] > 0)
               {
                    $valorsuel = $this->opera->getcuentanomina(601,6);
                        // var_dump($valorsuel);

                        $detalle = array(
                        'id_encabezado' => $id,
                        'tipo_mov' => $tipo,
                        'no_banco' => $datos[0]['no_banco'],
                        'no_mov' => $next_mov,
                        'ren' => 0,
                        'cuenta' => $valorsuel[0]['cuenta'],
                        'sub_cta' => $valorsuel[0]['sub_cta'],
                        'monto' => $checar[8],
                        'c_a' => '+',
                        'fecha' => date('Y-m-d'),
                        'concepto' => $checar[1],
                        'referencia' => $refe,
                        'no_prov' => $nombreemple[0]['no_prov'],
                        'factrefe' => 0,
                        'nombre_cuenta' => $valorsuel[0]['descrip'],
                        'ssub_cta' => $valorsuel[0]['ssub_cta'],
                        );

                    $detalle= $this->opera->guardarDetalle($detalle); 
               }

               //ISR

               if($checar[28] > 0)
               {
                    $valorsuel = $this->opera->getcuentanomina(201,1);
                    // var_dump($valorsuel);

                    $detalle = array(
                        'id_encabezado' => $id,
                        'tipo_mov' => $tipo,
                        'no_banco' => $datos[0]['no_banco'],
                        'no_mov' => $next_mov,
                        'ren' => 0,
                        'cuenta' => $valorsuel[0]['cuenta'],
                        'sub_cta' => $valorsuel[0]['sub_cta'],
                        'monto' => $checar[28],
                        'c_a' => '-',
                        'fecha' => date('Y-m-d'),
                        'concepto' => $checar[1],
                        'referencia' => $refe,
                        'no_prov' => $nombreemple[0]['no_prov'],
                        'factrefe' => 0,
                        'nombre_cuenta' => $valorsuel[0]['descrip'],
                        'ssub_cta' => $valorsuel[0]['ssub_cta'],
                    );

                    $detalle= $this->opera->guardarDetalle($detalle);  
               }

               //IMSS

               if($checar[29] > 0)
               {
                    $valorsuel = $this->opera->getcuentanomina(201,2);
                    // var_dump($valorsuel);

                    $detalle = array(
                        'id_encabezado' => $id,
                        'tipo_mov' => $tipo,
                        'no_banco' => $datos[0]['no_banco'],
                        'no_mov' => $next_mov,
                        'ren' => 0,
                        'cuenta' => $valorsuel[0]['cuenta'],
                        'sub_cta' => $valorsuel[0]['sub_cta'],
                        'monto' => $checar[29],
                        'c_a' => '-',
                        'fecha' => date('Y-m-d'),
                        'concepto' => $checar[1],
                        'referencia' => $refe,
                        'no_prov' => $nombreemple[0]['no_prov'],
                        'factrefe' => 0,
                        'nombre_cuenta' => $valorsuel[0]['descrip'],
                        'ssub_cta' => $valorsuel[0]['ssub_cta'],
                    );

                    $detalle= $this->opera->guardarDetalle($detalle); 
               }

               //INFONAVIT

               if($checar[30] > 0)
               {
                    $valorsuel = $this->opera->getcuentanomina(201,10);
                    // var_dump($valorsuel);

                    $detalle = array(
                        'id_encabezado' => $id,
                        'tipo_mov' => $tipo,
                        'no_banco' => $datos[0]['no_banco'],
                        'no_mov' => $next_mov,
                        'ren' => 0,
                        'cuenta' => $valorsuel[0]['cuenta'],
                        'sub_cta' => $valorsuel[0]['sub_cta'],
                        'monto' => $checar[30],
                        'c_a' => '-',
                        'fecha' => date('Y-m-d'),
                        'concepto' => $checar[1],
                        'referencia' => $refe,
                        'no_prov' => $nombreemple[0]['no_prov'],
                        'factrefe' => 0,
                        'nombre_cuenta' => $valorsuel[0]['descrip'],
                        'ssub_cta' => $valorsuel[0]['ssub_cta'],
                    );

                    $detalle= $this->opera->guardarDetalle($detalle); 
               }

        }

        $crearopera = array('usuario' => $_SESSION['nombreU'],
                'tipo_mov' => '',
                'no_banco' => '',
                'no_mov' => '',
                'accion' => 'Agregar', 
                'cuando' => date('Y-m-d H:i:s'), 
                'comentario' => 'Importo la informacion de nómina con fecha de pago: '.$fechapago.' con referencia: '.$refe,
                'modulo' => 'Bancos -> Importar info');
            $this->bitacora->operacion($crearopera);

    }
}