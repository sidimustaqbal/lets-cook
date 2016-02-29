<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Location extends Module
{
    public $version = '1.0';

    public function info()
    {
        $info = array();
		$info['name'] = array(
			'en' => 'Location',
			'id' => 'Location',
		);
		$info['description'] = array(
			'en' => 'Manage data location of Indonesia (Province, Cities/District, Sub-District, and Villages)',
			'id' => 'Mengelola data lokasi di Indonesia (Provinsi, Kota/Kabupaten, kecamatan, dan kelurahan/Desa)',
		);
		$info['frontend'] = false;
		$info['backend'] = true;
		$info['menu'] = 'Location';
		$info['roles'] = array('manage_location');

		if(group_has_role('location', 'manage_location')){
			$info['sections']['provinsi']['name'] = 'location:provinsi:plural';
			$info['sections']['provinsi']['uri'] = 'admin/location/provinsi/index';

		// 	if(group_has_role('location', 'create_provinsi')){
		// 		$info['sections']['provinsi']['shortcuts']['create'] = array(
		// 			'name' => 'location:provinsi:new',
		// 			'uri' => 'admin/location/provinsi/create',
		// 			'class' => 'add'
		// 		);
		// 	}
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
	// public function admin_menu(&$menu_items, &$menu_order){
	// 	unset($menu_items['lang:cp:nav_Location']);

	// 	if(group_has_role('location', 'manage_location')){
	// 		$menu_items['lang:cp:nav_data']['lang:cp:nav_Location']['lang:location:provinsi:plural']['urls'] = array('admin/location/provinsi/index','admin/location/provinsi/create','admin/location/provinsi/view%1','admin/location/provinsi/edit%1');
	// 		$menu_items['lang:cp:nav_data']['lang:cp:nav_Location']['lang:location:kota:plural']['urls'] = array('admin/location/kota/index','admin/location/kota/create','admin/location/kota/view%1','admin/location/kota/edit%1');
	// 		$menu_items['lang:cp:nav_data']['lang:cp:nav_Location']['lang:location:kecamatan:plural']['urls'] = array('admin/location/kecamatan/index','admin/location/kecamatan/create','admin/location/kecamatan/view%1','admin/location/kecamatan/edit%1');
	// 		$menu_items['lang:cp:nav_data']['lang:cp:nav_Location']['lang:location:kelurahan:plural']['urls'] = array('admin/location/kelurahan/index','admin/location/kelurahan/create','admin/location/kelurahan/view%1','admin/location/kelurahan/edit%1');
	// 	}
	// }

    /**
     * Install
     *
     * This function will set up our streams
	 *
     */
    public function install()
    {
        $this->load->dbforge();

		// provinsi
		$fields = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'kode' => array(
				'type' => 'varchar',
				'constraint' => '100',
				'default' => '',
				'null' => TRUE,
			),
			'nama' => array(
				'type' => 'varchar',
				'constraint' => '100',
				'default' => '',
				'null' => TRUE,
			),
			'slug' => array(
				'type' => 'varchar',
				'constraint' => '100',
				'default' => '',
				'null' => TRUE,
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
			'ordering_count' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'null' => TRUE,
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('location_provinsi', TRUE);
		$this->db->query("CREATE INDEX author_index ON default_location_provinsi(created_by)");


		// kota
		$fields = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'kode' => array(
				'type' => 'varchar',
				'constraint' => '100',
				'default' => '',
				'null' => TRUE,
			),
			'nama' => array(
				'type' => 'varchar',
				'constraint' => '100',
				'default' => '',
				'null' => TRUE,
			),
			'slug' => array(
				'type' => 'varchar',
				'constraint' => '100',
				'default' => '',
				'null' => TRUE,
			),
			'id_provinsi' => array(
				'type' => 'INT',
				'constraint' => 11,
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
			'ordering_count' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'null' => TRUE,
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('location_kota', TRUE);
		$this->db->query("CREATE INDEX author_index ON default_location_kota(created_by)");


		// kecamatan
		$fields = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'kode' => array(
				'type' => 'varchar',
				'constraint' => '100',
				'default' => '',
				'null' => TRUE,
			),
			'nama' => array(
				'type' => 'varchar',
				'constraint' => '100',
				'default' => '',
				'null' => TRUE,
			),
			'slug' => array(
				'type' => 'varchar',
				'constraint' => '100',
				'default' => '',
				'null' => TRUE,
			),
			'id_kota' => array(
				'type' => 'INT',
				'constraint' => 11,
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
			'ordering_count' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'null' => TRUE,
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('location_kecamatan', TRUE);
		$this->db->query("CREATE INDEX author_index ON default_location_kecamatan(created_by)");


		// kelurahan
		$fields = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'kode' => array(
				'type' => 'varchar',
				'constraint' => '100',
				'default' => '',
				'null' => TRUE,
			),
			'nama' => array(
				'type' => 'varchar',
				'constraint' => '100',
				'default' => '',
				'null' => TRUE,
			),
			'slug' => array(
				'type' => 'varchar',
				'constraint' => '100',
				'default' => '',
				'null' => TRUE,
			),
			'id_kecamatan' => array(
				'type' => 'INT',
				'constraint' => 11,
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
			'ordering_count' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'null' => TRUE,
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('location_kelurahan', TRUE);
		$this->db->query("CREATE INDEX author_index ON default_location_kelurahan(created_by)");

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
        $this->dbforge->drop_table('location_provinsi');
        $this->dbforge->drop_table('location_kota');
        $this->dbforge->drop_table('location_kecamatan');
        $this->dbforge->drop_table('location_kelurahan');
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