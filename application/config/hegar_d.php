<?php
defined('BASEPATH') or exit("No se permite el acceso directo al script");

/**
 * Configuracion de la base de la tabla donde se almacenan las bases de datos
 * alternas
 */

 $config['hegar_d'] = array(
     //Nombre de la tabla donde se almacenan las conexiones
     'table_name' => 'empresas',
     //Nombre del campo que contiene el nombre de la base de datos
     'database_name' => 'basedeDatos',
     //Nombre del campo que contiene el password para realizar al conexion
     'user_name' => 'usuario',

     'password' => 'contrasena',
     // Nombre del campo que contiene el host para realizar la conexion
     'host' => 'host',
     //Nombre del campo que se usara como indice para realizar la busqueda de la 
     //configuracion
     'key' => 'idEmpresa'
 );
 ?>