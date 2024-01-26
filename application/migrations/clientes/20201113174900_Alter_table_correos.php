<?php
      class Migration_Alter_table_correos extends CI_Migration{
        public function up()
        {
          $campo= array('cc'=>array(
                                      'type' => 'longtext',
                                      'null' => TRUE));
          $this->dbforge->add_column('correos', $campo);
        }

        public function down()
        {
          $this->dbforge->drop_column('correos', 'cc');
        }
      }
