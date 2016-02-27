<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Daftar extends Module
{
    public $version = '1.0';

    public function info()
    {
        $info = array();
		$info['name'] = array(
			'en' => 'Daftar',
			'id' => 'Daftar',
		);
		$info['description'] = array(
			'en' => 'Registration Module for Insurance',
			'id' => 'Modul Pendaftaran Untuk Asuransi',
		);
		$info['frontend'] = true;
		$info['backend'] = true;
		$info['menu'] = 'Daftar';
		$info['roles'] = array(
			'access_data_backend', 'view_all_data', 'view_own_data',
			'edit_all_data', 'edit_own_data', 'delete_all_data',
			'delete_own_data', 'create_data',
		);

		if(group_has_role('daftar', 'access_data_backend')){
			$info['sections']['data']['name'] = 'daftar:data:plural';
			$info['sections']['data']['uri'] = 'admin/daftar/data/index';

			if(group_has_role('daftar', 'create_data')){
				$info['sections']['data']['shortcuts']['create'] = array(
					'name' => 'daftar:data:new',
					'uri' => 'admin/daftar/data/create',
					'class' => 'add'
				);
			}
		}

		return $info;
    }

	/**
	 * Admin menu
	 *
	 * If a module has an admin_menu function, then
	 * we simply run that and allow it to manipulate the
	 * menu array
	 */
	public function admin_menu(&$menu){

		unset($menu['lang:cp:nav_Daftar']);
		$menu['Aplikasi'] = 'admin/daftar/data/index';
		add_admin_menu_place('Aplikasi', 1);
	}

    /**
     * Install
     *
     * This function will set up our streams
	 *
     */
    public function install()
    {
      $this->load->dbforge();

			// data
			$fields = array(
				'id' => array(
					'type' => 'INT',
					'constraint' => 11,
					'unsigned' => TRUE,
					'auto_increment' => TRUE,
				),
				'nama' => array(
					'type' => 'varchar',
					'constraint' => '50',
				),
				'status' => array(
					'type' => 'tinyint',
					'constraint' => '2',
					'default' => '1',
				),
				'form' => array(
					'type' => 'text',
				),
				'created_on' => array(
					'type' => 'DATETIME',
				),
				'created_by' => array(
					'type' => 'INT',
					'constraint' => 11,
					'unsigned' => TRUE,
					'null' => TRUE,
				),
				'updated_on' => array(
					'type' => 'DATETIME',
					'null' => TRUE,
				),
				'updated_by' => array(
					'type' => 'INT',
					'constraint' => 11,
					'unsigned' => TRUE,
					'null' => TRUE,
				),
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('id', TRUE);
			// $this->dbforge->create_table('daftar_data', TRUE);


      $sample_setting = array(
          'slug' => 'allow_edit_daftar',
          'title' => 'Apakah pengguna yang sudah mendaftar boleh merubah data yang ada ?',
          'description' => 'Apakah pengguna yang sudah mendaftar boleh merubah data yang ada ?',
          'default' => '1',
          'value' => '1',
          'type' => 'radio',
          'options' => '1=Ya|0=Tidak',
          'is_required' => 1,
          'is_gui' => 1,
          'module' => 'daftar'
      );

			if ( ! $this->dbforge->create_table('daftar_data', TRUE) OR ! $this->db->insert('settings', $sample_setting))
      {
          return false;
      }
			$this->db->query("CREATE INDEX author_index ON default_daftar_data(created_by)");

			return true;
    }

    /**
     * Uninstall
     *
     * Uninstall our module - this should tear down
     * all information associated with it.
     */
    public function uninstall()
    {
			$this->load->dbforge();
			$this->db->delete('settings', array('module' => 'daftar'));
      $this->dbforge->drop_table('daftar_data');
      return true;
    }

    public function upgrade($old_version)
    {
      return true;
    }

    public function help()
    {
      // Return a string containing help info
      // You could include a file and return it here.
      return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
    }

}