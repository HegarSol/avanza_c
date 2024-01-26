<?php if(! defined('BASEPATH')){
    exit('No direct script access allowd');
}

class Tools extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Solo puede ser llamado desde la consola
        if(!$this->input->is_cli_request()){
            exit('No esta permitido el acceso directo. Esta es una herramienta de consola. Usa la terminal');
        }
    }

    public function message($to = 'World')
    {
        echo "Hello {$to}" . PHP_EOL;
    }

    public function help()
    {
        $result = "estos son los comandos disponibles en la interface\n\n";
        $result .= "php index.php tools migration \"nombre_archivo\"          Crea un nuevo archivo migration\n";  
        $result .= "php index.php tools migration_cliente \"nombre_archivo\"  Crea un nuevo archivo migration\n";
        echo $result . PHP_EOL;
    }

    public function migration($name)
    {
        $this->make_migration_file($name);
    }

    public function migration_cliente($name)
    {
        $this->make_migration_file($name, TRUE);
    }

    protected function make_migration_file($name, $cliente = FALSE)
    {
        $date = new DateTime();
        $timestamp = $date->format('YmdHis');
        $table_name = strtolower($name);
        $path = APPPATH . "migrations/$timestamp" ."_"."$name.php";
        $class = "CI_Migration";
        if($cliente)
        {
           $path = APPPATH . "migrations/clientes/$timestamp" . "_" . "$name.php";
        }
        $my_migration = fopen($path, 'w') or die("No se puede crear el archivo de migracion");

        $migration_template = "<?php
        class Migration_$name extends $class{
            public function up()
            {
                \$this->dbforge->create_table('',TRUE);
            }
            public function down()
            {
                \$this->dbforge->drop_table('',TRUE);
            }
        }";
        fwrite($my_migration, $migration_template);
        fclose($my_migration);

        echo "$path migration creada correctamente". PHP_EOL;
    }
}