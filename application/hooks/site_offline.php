<?php

if( !defined('BASEPATH')) exit('No direct script access allowed');

class Site_Offline
{
    function __construct()
    {

    }

    public function is_offline()
    {
        if(file_exists(APPPATH . 'config/avanzac.php'))
        {
            include(APPPATH . 'config/avanzac.php');
            if(isset($config['is_offline']) && $config['is_offline'] === TRUE && $_SERVER['SERVER_NAME'] != 'avanzac-test.hegarss.com'){
                include(APPPATH . 'views/maintenance_view.php');
                exit();
            }
        }
    }
}