<?php
defined("BASEPATH") or exit('No se permite el acceso directo al script');

class MY_Migration extends CI_Migration{

	protected $_migration_session_empresa_id = NULL;
	public $dbEmpresa;

  public function __construct()
  {
    // Only run this constructor on main library load
		if ( ! in_array(get_class($this), array('CI_Migration', config_item('subclass_prefix').'Migration'), TRUE))
		{
			return;
		}
		if(!$this->config->load('migration_clientes', TRUE)){
			show_error('No se ha especificado una configuracion para las migraciones de los clientes');
			return;
		}
		$config = $this->config->item('migration_clientes');

		foreach ($config as $key => $val)
		{
			$this->{'_'.$key} = $val;
		}

		log_message('info', 'Migrations Class Initialized');

		// Are they trying to use migrations while it is disabled?
		if ($this->_migration_enabled !== TRUE)
		{
			show_error('Migrations has been loaded but is disabled or set up incorrectly.');
		}

		// If not set, set it
		$this->_migration_path !== '' OR $this->_migration_path = APPPATH.'migrations/clientes/';

		// Add trailing slash if not set
		$this->_migration_path = rtrim($this->_migration_path, '/').'/';

		// Load migration language
		$this->lang->load('migration');
		// Cambiamos a la base de datos del cliente
		$id_empresa = $this->session->userdata($this->_migration_session_empresa_id);
		if(!$id_empresa){
			return;
		}
		$this->db = $this->hegardb->getDatabase($id_empresa);
		// They'll probably be using dbforge
		$this->load->dbforge($this->db);

		// Make sure the migration table name was set.
		if (empty($this->_migration_table))
		{
			show_error('Migrations configuration file (migration.php) must have "migration_table" set.');
		}

		// Migration basename regex
		$this->_migration_regex = ($this->_migration_type === 'timestamp')
			? '/^\d{14}_(\w+)$/'
			: '/^\d{3}_(\w+)$/';

		// Make sure a valid migration numbering type was set.
		if ( ! in_array($this->_migration_type, array('sequential', 'timestamp')))
		{
			show_error('An invalid migration numbering type was specified: '.$this->_migration_type);
		}

		// If the migrations table is missing, make it
		if ( ! $this->db->table_exists($this->_migration_table))
		{
			$this->dbforge->add_field(array(
				'version' => array('type' => 'BIGINT', 'constraint' => 20),
			));

			$this->dbforge->create_table($this->_migration_table, TRUE);

			$this->db->insert($this->_migration_table, array('version' => 0));
		}

		// Do we auto migrate to the latest migration?
		if ($this->_migration_auto_latest === TRUE && ! $this->latest())
		{
			show_error($this->error_string());
		}
  }
}
