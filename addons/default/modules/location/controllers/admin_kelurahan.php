<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Location Module
 *
 * Manage data location of Indonesia (Province, Cities/District, Sub-District, and Villages)
 *
 */
class Admin_kelurahan extends Admin_Controller
{
	// -------------------------------------
    // This will set the active section tab
	// -------------------------------------
	
    protected $section = 'kelurahan';

    public function __construct()
    {
        parent::__construct();

		// -------------------------------------
		// Check permission
		// -------------------------------------
		
		if(! group_has_role('location', 'manage_location')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('admin');
		}
		
		// -------------------------------------
		// Load everything we need
		// -------------------------------------

        $this->lang->load('location');		
		$this->load->model('provinsi_m');
		$this->load->model('kota_m');
		$this->load->model('kecamatan_m');
		$this->load->model('kelurahan_m');
    }

    /**
	 * List all kelurahan
     *
     * @return	void
     */
    public function index()
    {
		$filter = null;

    	if($this->input->get('f-provinsi')) {
    		$filter['default_location_kota.id_provinsi'] = $this->input->get('f-provinsi');
    	}

    	if($this->input->get('f-kota')) {
    		$filter['default_location_kecamatan.id_kota'] = $this->input->get('f-kota');
    	}

    	if($this->input->get('f-kecamatan')) {
    		$filter['default_location_kelurahan.id_kecamatan'] = $this->input->get('f-kecamatan');
    	}

		// -------------------------------------
		// Pagination
		// -------------------------------------

		$pagination_config['base_url'] = base_url(). 'admin/location/kelurahan/index';
		$pagination_config['uri_segment'] = 5;
		$pagination_config['total_rows'] = $this->kelurahan_m->count_all_kelurahan($filter);
		$pagination_config['per_page'] = Settings::get('records_per_page');
		$this->pagination->initialize($pagination_config);
		$data['pagination_config'] = $pagination_config;
		
        // -------------------------------------
		// Get entries
		// -------------------------------------
		
        $data['kelurahan']['entries'] = $this->kelurahan_m->get_kelurahan($pagination_config, $filter);
		$data['kelurahan']['total'] = count($data['kelurahan']['entries']);
		$data['kelurahan']['pagination'] = $this->pagination->create_links();

		$data['provinsi'] = $this->provinsi_m->get_provinsi();
		$data['kota'] = array();
		$data['kecamatan'] = array();

		if($this->input->get('f-provinsi')) {
			$data['kota'] = $this->kota_m->get_kota_by_provinsi($this->input->get('f-provinsi'));
		}

		if($this->input->get('f-kota')) {
			$data['kecamatan'] = $this->kecamatan_m->get_kecamatan_by_kota($this->input->get('f-kota'));
		}

		// -------------------------------------
        // Build the page. See views/admin/index.php
        // for the view code.
		// -------------------------------------
		
        $this->template->title(lang('location:kelurahan:plural'))
			->set_breadcrumb('Home', '/admin')
			->set_breadcrumb(lang('location:kelurahan:plural'))
			->build('admin/kelurahan_index', $data);
    }
	
	/**
     * Display one kelurahan
     *
     * @return  void
     */
    public function view($id = 0)
    {
    	redirect('admin/location/kelurahan/index');
        // -------------------------------------
		// Get our entry.
		// -------------------------------------
		
        $data['kelurahan'] = $this->kelurahan_m->get_kelurahan_by_id($id);
		
		// -------------------------------------
        // Build the page. See views/admin/index.php
        // for the view code.
		// -------------------------------------
		
        $this->template->title(lang('location:kelurahan:view'))
			->set_breadcrumb('Home', '/admin')
			->set_breadcrumb(lang('location:kelurahan:plural'), '/admin/location/kelurahan/index')
			->set_breadcrumb(lang('location:kelurahan:view'))
			->build('admin/kelurahan_entry', $data);
    }
	
	/**
     * Create a new kelurahan entry
     *
     * We are building entry form manually using the fields API
     * and displaying the output in a custom view file.
     *
     * @return	void
     */
    public function create()
    {
		// -------------------------------------
		// Process POST input
		// -------------------------------------
		
		if($_POST){
			if($this->_update_kelurahan('new')){	
				$this->session->set_flashdata('success', lang('location:kelurahan:submit_success'));				
				redirect('admin/location/kelurahan/index' . '?' . $_SERVER['QUERY_STRING']);
			}else{
				$data['messages']['error'] = lang('location:kelurahan:submit_failure');
			}
		}
		
		$data['mode'] = 'new';
		$data['return'] = 'admin/location/kelurahan/index' . '?' . $_SERVER['QUERY_STRING'];

		$data['provinsi'] = $this->provinsi_m->get_provinsi();
		$data['kota'] = array();
		$data['kecamatan'] = array();

		if($this->input->post('id_provinsi')) {
			$data['kota'] = $this->kota_m->get_kota_by_provinsi($this->input->post('id_provinsi'));
		}elseif($this->input->get('f-provinsi')) {
			$data['kota'] = $this->kota_m->get_kota_by_provinsi($this->input->get('f-provinsi'));
		}

		if($this->input->post('id_kota')) {
			$data['kecamatan'] = $this->kecamatan_m->get_kecamatan_by_kota($this->input->post('id_kota'));
		}elseif($this->input->get('f-kota')) {
			$data['kecamatan'] = $this->kecamatan_m->get_kecamatan_by_kota($this->input->get('f-kota'));
		}
		
		// -------------------------------------
		// Build the form page.
		// -------------------------------------

		$this->template->append_js('jquery/jquery.slugify.js');
		
        $this->template->title(lang('location:kelurahan:new'))
			->set_breadcrumb('Home', '/admin')
			->set_breadcrumb(lang('location:kelurahan:plural'), '/admin/location/kelurahan/index')
			->set_breadcrumb(lang('location:kelurahan:new'))
			->build('admin/kelurahan_form', $data);
    }
	
	/**
     * Edit a kelurahan entry
     *
     * We're passing the
     * id of the entry, which will allow entry_form to
     * repopulate the data from the database.
	 * We are building entry form manually using the fields API
     * and displaying the output in a custom view file.
     *
     * @param   int [$id] The id of the kelurahan to the be deleted.
     * @return	void
     */
    public function edit($id = 0)
    {
        // -------------------------------------
		// Process POST input
		// -------------------------------------
		
		if($_POST){
			if($this->_update_kelurahan('edit', $id)){	
				$this->session->set_flashdata('success', lang('location:kelurahan:submit_success'));				
				redirect('admin/location/kelurahan/index' . '?' . $_SERVER['QUERY_STRING']);
			}else{
				$data['messages']['error'] = lang('location:kelurahan:submit_failure');
			}
		}
		
		$data['fields'] = $this->kelurahan_m->get_kelurahan_by_id($id);
		$data['mode'] = 'edit';
		$data['return'] = 'admin/location/kelurahan/index' . '?' . $_SERVER['QUERY_STRING'];
		$data['entry_id'] = $id;

		$data['provinsi'] = $this->provinsi_m->get_provinsi();
		$data['kota'] = $this->kota_m->get_kota_by_provinsi($data['fields']['id_provinsi']);
		$data['kecamatan'] = $this->kecamatan_m->get_kecamatan_by_kota($data['fields']['id_kota']);
		
		// -------------------------------------
		// Build the form page.
		// -------------------------------------

		$this->template->append_js('jquery/jquery.slugify.js');
		
        $this->template->title(lang('location:kelurahan:edit'))
			->set_breadcrumb('Home', '/admin')
			->set_breadcrumb(lang('location:kelurahan:plural'), '/admin/location/kelurahan/index')
			->set_breadcrumb(lang('location:kelurahan:view'), '/admin/location/kelurahan/view/'.$id)
			->set_breadcrumb(lang('location:kelurahan:edit'))
			->build('admin/kelurahan_form', $data);
    }
	
	/**
     * Delete a kelurahan entry
     * 
     * @param   int [$id] The id of kelurahan to be deleted
     * @return  void
     */
    public function delete($id = 0)
    {
		// -------------------------------------
		// Delete entry
		// -------------------------------------
		
        $this->kelurahan_m->delete_kelurahan_by_id($id);
        $this->session->set_flashdata('error', lang('location:kelurahan:deleted'));
 
		// -------------------------------------
		// Redirect
		// -------------------------------------
		
        redirect('admin/location/kelurahan/index' . '?' . $_SERVER['QUERY_STRING']);
    }
	
	/**
     * Insert or update kelurahan entry in database
     *
     * @param   string [$method] The method of database update ('new' or 'edit').
	 * @param   int [$row_id] The entry id (if in edit mode).
     * @return	boolean
     */
	private function _update_kelurahan($method, $row_id = null)
 	{
 		// -------------------------------------
		// Load everything we need
		// -------------------------------------
		
		$this->load->helper(array('form', 'url'));
		
 		// -------------------------------------
		// Set Values
		// -------------------------------------
		
		$values = $this->input->post();

		// -------------------------------------
		// Validation
		// -------------------------------------
		
		// Set validation rules
		$this->form_validation->set_rules('id_provinsi', lang('location:nama_provinsi'), 'required');
		$this->form_validation->set_rules('id_kota', lang('location:nama_kota'), 'required');
		$this->form_validation->set_rules('id_kecamatan', lang('location:nama_kecamatan'), 'required');
		$this->form_validation->set_rules('nama', lang('location:nama_kelurahan'), 'required');
		$this->form_validation->set_rules('slug', lang('location:slug_kelurahan'), 'required');
		
		// Set Error Delimns
		$this->form_validation->set_error_delimiters('<div>', '</div>');
		
		$result = false;

		if ($this->form_validation->run() === true)
		{
			if ($method == 'new')
			{
				$result = $this->kelurahan_m->insert_kelurahan($values);
				
			}
			else
			{
				$result = $this->kelurahan_m->update_kelurahan($values, $row_id);
			}
		}
		
		return $result;
	}

	// --------------------------------------------------------------------------

	public function get_kota_by_provinsi($id_provinsi='')
	{
		$kota = $this->kota_m->get_kota_by_provinsi($id_provinsi);

		echo json_encode($kota);
	}

	public function get_kecamatan_by_kota($id_kota='')
	{
		$kecamatan = $this->kecamatan_m->get_kecamatan_by_kota($id_kota);

		echo json_encode($kecamatan);
	}
}