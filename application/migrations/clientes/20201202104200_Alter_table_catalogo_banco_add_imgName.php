<?php
      class Migration_Alter_table_catalogo_banco_add_imgName extends CI_Migration{
        public function up()
        {
          $campo= array('imgName'=>array(
                                      'type' => 'varchar',
                                      'constraint' => 255,
                                      'null' => TRUE));
          $this->dbforge->add_column('catalogo_banco', $campo);
        }

        public function down()
        {
          $this->dbforge->drop_column('catalogo_banco', 'imgName');
        }
      }
