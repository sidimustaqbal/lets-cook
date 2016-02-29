<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Location Module
 *
 * Manage data location of Indonesia (Province, Cities/District, Sub-District, and Villages)
 *
 */
class Admin_kecamatan extends Admin_Controller
{
	// -------------------------------------
    // This will set the active section tab
	// -------------------------------------
	
    protected $section = 'kecamatan';

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
	 * List all kecamatan
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

		$pagination_config['base_url'] = base_url(). 'admin/location/kecamatan/index';
		$pagination_config['uri_segment'] = 5;
		$pagination_config['total_rows'] = $this->kecamatan_m->count_all_kecamatan($filter);
		$pagination_config['per_page'] = Settings::get('records_per_page');
		$this->pagination->initialize($pagination_config);
		$data['pagination_config'] = $pagination_config;
		
        // -------------------------------------
		// Get entries
		// -------------------------------------
		
        $data['kecamatan']['entries'] = $this->kecamatan_m->get_kecamatan($pagination_config, $filter);
		$data['kecamatan']['total'] = count($data['kecamatan']['entries']);
		$data['kecamatan']['pagination'] = $this->pagination->create_links();

		$data['provinsi'] = $this->provinsi_m->get_provinsi();
		$data['kota'] = array();
		if($this->input->get('f-provinsi')) {
			$data['kota'] = $this->kota_m->get_kota_by_provinsi($this->input->get('f-provinsi'));
		}

		// -------------------------------------
        // Build the page. See views/admin/index.php
        // for the view code.
		// -------------------------------------
		
        $this->template->title(lang('location:kecamatan:plural'))
			->set_breadcrumb('Home', '/admin')
			->set_breadcrumb(lang('location:kecamatan:plural'))
			->build('admin/kecamatan_index', $data);
    }
	
	/**
     * Display one kecamatan
     *
     * @return  void
     */
    public function view($id = 0)
    {
    	redirect('admin/location/kecamatan/index');
        // -------------------------------------
		// Get our entry.
		// -------------------------------------
		
        $data['kecamatan'] = $this->kecamatan_m->get_kecamatan_by_id($id);
		
		// -------------------------------------
        // Build the page. See views/admin/index.php
        // for the view code.
		// -------------------------------------
		
        $this->template->title(lang('location:kecamatan:view'))
			->set_breadcrumb('Home', '/admin')
			->set_breadcrumb(lang('location:kecamatan:plural'), '/admin/location/kecamatan/index')
			->set_breadcrumb(lang('location:kecamatan:view'))
			->build('admin/kecamatan_entry', $data);
    }
	
	/**
     * Create a new kecamatan entry
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
			if($this->_update_kecamatan('new')){	
				$this->session->set_flashdata('success', lang('location:kecamatan:submit_success'));				
				redirect('admin/location/kecamatan/index' . '?' . $_SERVER['QUERY_STRING']);
			}else{
				$data['messages']['error'] = lang('location:kecamatan:submit_failure');
			}
		}
		
		$data['mode'] = 'new';
		$data['return'] = 'admin/location/kecamatan/index' . '?' . $_SERVER['QUERY_STRING'];

		$data['provinsi'] = $this->provinsi_m->get_provinsi();
		$data['kota'] = array();
		if($this->input->post('id_provinsi')) {
			$data['kota'] = $this->kota_m->get_kota_by_provinsi($this->input->post('id_provinsi'));
		}elseif($this->input->get('f-provinsi')) {
			$data['kota'] = $this->kota_m->get_kota_by_provinsi($this->input->get('f-provinsi'));
		}
		
		// -------------------------------------
		// Build the form page.
		// -------------------------------------

		$this->template->append_js('jquery/jquery.slugify.js');
		
        $this->template->title(lang('location:kecamatan:new'))
			->set_breadcrumb('Home', '/admin')
			->set_breadcrumb(lang('location:kecamatan:plural'), '/admin/location/kecamatan/index')
			->set_breadcrumb(lang('location:kecamatan:new'))
			->build('admin/kecamatan_form', $data);
    }
	
	/**
     * Edit a kecamatan entry
     *
     * We're passing the
     * id of the entry, which will allow entry_form to
     * repopulate the data from the database.
	 * We are building entry form manually using the fields API
     * and displaying the output in a custom view file.
     *
     * @param   int [$id] The id of the kecamatan to the be deleted.
     * @return	void
     */
    public function edit($id = 0)
    {
        // -------------------------------------
		// Process POST input
		// -------------------------------------
		
		if($_POST){
			if($this->_update_kecamatan('edit', $id)){	
				$this->session->set_flashdata('success', lang('location:kecamatan:submit_success'));				
				redirect('admin/location/kecamatan/index' . '?' . $_SERVER['QUERY_STRING']);
			}else{
				$data['messages']['error'] = lang('location:kecamatan:submit_failure');
			}
		}
		
		$data['fields'] = $this->kecamatan_m->get_kecamatan_by_id($id);
		$data['mode'] = 'edit';
		$data['return'] = 'admin/location/kecamatan/index' . '?' . $_SERVER['QUERY_STRING'];
		$data['entry_id'] = $id;

		$data['provinsi'] = $this->provinsi_m->get_provinsi();
		$data['kota'] = $this->kota_m->get_kota_by_provinsi($data['fields']['id_provinsi']);
		
		// -------------------------------------
		// Build the form page.
		// -------------------------------------

		$this->template->append_js('jquery/jquery.slugify.js');
		
        $this->template->title(lang('location:kecamatan:edit'))
			->set_breadcrumb('Home', '/admin')
			->set_breadcrumb(lang('location:kecamatan:plural'), '/admin/location/kecamatan/index')
			->set_breadcrumb(lang('location:kecamatan:view'), '/admin/location/kecamatan/view/'.$id)
			->set_breadcrumb(lang('location:kecamatan:edit'))
			->build('admin/kecamatan_form', $data);
    }
	
	/**
     * Delete a kecamatan entry
     * 
     * @param   int [$id] The id of kecamatan to be deleted
     * @return  void
     */
    public function delete($id = 0)
    {
		// Check whether it has child or not
		$child = $this->kelurahan_m->get_kelurahan_by_kecamatan($id);

		if(count($child)>0) {
			$this->session->set_flashdata('error', lang('location:kecamatan:deleted_has_child'));
			redirect('admin/location/kecamatan/index' . '?' . $_SERVER['QUERY_STRING']);
		}

		// -------------------------------------
		// Delete entry
		// -------------------------------------
		
        $this->kecamatan_m->delete_kecamatan_by_id($id);
        $this->session->set_flashdata('error', lang('location:kecamatan:deleted'));
 
		// -------------------------------------
		// Redirect
		// -------------------------------------
		
        redirect('admin/location/kecamatan/index' . '?' . $_SERVER['QUERY_STRING']);
    }
	
	/**
     * Insert or update kecamatan entry in database
     *
     * @param   string [$method] The method of database update ('new' or 'edit').
	 * @param   int [$row_id] The entry id (if in edit mode).
     * @return	boolean
     */
	private function _update_kecamatan($method, $row_id = null)
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
		$this->form_validation->set_rules('nama', lang('location:nama_kecamatan'), 'required');
		$this->form_validation->set_rules('slug', lang('location:slug_kecamatan'), 'required');
		
		// Set Error Delimns
		$this->form_validation->set_error_delimiters('<div>', '</div>');
		
		$result = false;

		if ($this->form_validation->run() === true)
		{
			if ($method == 'new')
			{
				$result = $this->kecamatan_m->insert_kecamatan($values);
				
			}
			else
			{
				$result = $this->kecamatan_m->update_kecamatan($values, $row_id);
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
}