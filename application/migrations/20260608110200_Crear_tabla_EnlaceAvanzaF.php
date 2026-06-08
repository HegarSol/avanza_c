<?php


class Migration_Crear_tabla_EnlaceAvanzaF extends CI_Migration{
    public function up()
    {
          $script = "CREATE TABLE `enlaceAvanzaF` (
            `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT,
            `RFC` char(13) NOT NULL,
            `empresas` varchar(100) DEFAULT NULL,
            `IdEmpresa` smallint(6) DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `empresas` (`empresas`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
        $this->db->query($script);
    // crear insertar datos del siguiente arreglo
    $data = [
    [
      "empresas"=>"FDI MEXICO",
      "RFC"=>"FME031024876",
      "IdEmpresa"=>118
    ],
    [
      "empresas"=>"AUTOTRANSPORTES LEMPAC",
      "RFC"=>"ALE1306254V8",
      "IdEmpresa"=>119
    ],
    [
      "empresas"=>"FDI CARGO MEXICO",
      "RFC"=>"FCM210519GK1",
      "IdEmpresa"=>120
    ],
    [
      "empresas"=>"XOCHILT PRUEBA",
      "RFC"=>"CACX7605101P8",
      "IdEmpresa"=>103
    ],
    [
      "empresas"=>"HEGAR SOLUCIONES EN SISTEMAS",
      "RFC"=>"HSS1306229V2",
      "IdEmpresa"=>1
    ],
    [
      "empresas"=>"FRANCISCO PEDRO HERRERA GALVAN",
      "RFC"=>"HEGF7110049X9",
      "IdEmpresa"=>19
    ],
    [
      "empresas"=>"LUCIA ELENA ARRIAGA SANTOS",
      "RFC"=>"AISL780820JV7",
      "IdEmpresa"=>142
    ],
    [
      "empresas"=>"ASFALTOS Y CONCRETOS",
      "RFC"=>"ACO981215PD0",
      "IdEmpresa"=>67
    ],
    [
      "empresas"=>"GM MORALES CONSULTORES",
      "RFC"=>"GMC170929S86",
      "IdEmpresa"=>56
    ]
];
            foreach($data as $dat)
            {
                $this->db->insert('enlaceAvanzaF', $dat);
            }
    
    }
    public function down()
    {
        $this->dbforge->drop_table('enlaceAvanzaF',TRUE);
    }
}