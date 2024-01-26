<?php
defined("BASEPATH") or exit('No se permite el acceso directo al script');

class Updates extends MY_controller{
    public function __construct()
    {
        $this->config->load('migration_clientes',true);
    }

    public function index()
    {
        
    }
}