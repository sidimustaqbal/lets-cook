<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Location Module
 *
 * Manage data location of Indonesia (Province, Cities/District, Sub-District, and Villages)
 *
 */
class Admin_kota extends Admin_Controller
{
	// -------------------------------------
    // This will set the active section tab
	// -------------------------------------
	
    protected $section = 'kota';

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
    }

    /**
	 * List all kota
     *
     * @return	void
     */
    public function index()
    {
    	$filter = null;

    	if($this->input->get('f-provinsi')) {
    		$filter['id_provinsi'] = $this->input->get('f-provinsi');
    	}

		// -------------------------------------
		// Pagination
		// -------------------------------------

		$pagination_config['base_url'] = base_url(). 'admin/location/kota/index';
		$pagination_config['uri_segment'] = 5;
		$pagination_config['total_rows'] = $this->kota_m->count_all_kota($filter);
		$pagination_config['per_page'] = Settings::get('records_per_page');
		$this->pagination->initialize($pagination_config);
		$data['pagination_config'] = $pagination_config;
		
        // -------------------------------------
		// Get entries
		// -------------------------------------
		
        $data['kota']['entries'] = $this->kota_m->get_kota($pagination_config,$filter);
		$data['kota']['total'] = count($data['kota']['entries']);
		$data['kota']['pagination'] = $this->pagination->create_links();

		$data['provinsi'] = $this->provinsi_m->get_provinsi();

		// -------------------------------------
        // Build the page. See views/admin/index.php
        // for the view code.
		// -------------------------------------
		
        $this->template->title(lang('location:kota:plural'))
			->set_breadcrumb('Home', '/admin')
			->set_breadcrumb(lang('location:kota:plural'))
			->build('admin/kota_index', $data);
    }
	
	/**
     * Display one kota
     *
     * @return  void
     */
    public function view($id = 0)
    {
    	redirect('admin/location/kota/index');
        // -------------------------------------
		// Get our entry.
		// -------------------------------------
		
        $data['kota'] = $this->kota_m->get_kota_by_id($id);
		
		// -------------------------------------
        // Build the page. See views/admin/index.php
        // for the view code.
		// -------------------------------------
		
        $this->template->title(lang('location:kota:view'))
			->set_breadcrumb('Home', '/admin')
			->set_breadcrumb(lang('location:kota:plural'), '/admin/location/kota/index')
			->set_breadcrumb(lang('location:kota:view'))
			->build('admin/kota_entry', $data);
    }
	
	/**
     * Create a new kota entry
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
			if($this->_update_kota('new')){	
				$this->session->set_flashdata('success', lang('location:kota:submit_success'));				
				redirect('admin/location/kota/index' . '?' . $_SERVER['QUERY_STRING']);
			}else{
				$data['messages']['error'] = lang('location:kota:submit_failure');
			}
		}
		
		$data['mode'] = 'new';
		$data['return'] = 'admin/location/kota/index' . '?' . $_SERVER['QUERY_STRING'];

		$data['provinsi'] = $this->provinsi_m->get_provinsi();
		
		// -------------------------------------
		// Build the form page.
		// -------------------------------------

		$this->template->append_js('jquery/jquery.slugify.js');
		
        $this->template->title(lang('location:kota:new'))
			->set_breadcrumb('Home', '/admin')
			->set_breadcrumb(lang('location:kota:plural'), '/admin/location/kota/index')
			->set_breadcrumb(lang('location:kota:new'))
			->build('admin/kota_form', $data);
    }
	
	/**
     * Edit a kota entry
     *
     * We're passing the
     * id of the entry, which will allow entry_form to
     * repopulate the data from the database.
	 * We are building entry form manually using the fields API
     * and displaying the output in a custom view file.
     *
     * @param   int [$id] The id of the kota to the be deleted.
     * @return	void
     */
    public function edit($id = 0)
    {
        // -------------------------------------
		// Process POST input
		// -------------------------------------
		
		if($_POST){
			if($this->_update_kota('edit', $id)){	
				$this->session->set_flashdata('success', lang('location:kota:submit_success'));				
				redirect('admin/location/kota/index' . '?' . $_SERVER['QUERY_STRING']);
			}else{
				$data['messages']['error'] = lang('location:kota:submit_failure');
			}
		}
		
		$data['fields'] = $this->kota_m->get_kota_by_id($id);
		$data['mode'] = 'edit';
		$data['return'] = 'admin/location/kota/index?'.$_SERVER['QUERY_STRING'];
		$data['entry_id'] = $id;

		$data['provinsi'] = $this->provinsi_m->get_provinsi();
		
		// -------------------------------------
		// Build the form page.
		// -------------------------------------

		$this->template->append_js('jquery/jquery.slugify.js');
		
        $this->template->title(lang('location:kota:edit'))
			->set_breadcrumb('Home', '/admin')
			->set_breadcrumb(lang('location:kota:plural'), '/admin/location/kota/index')
			->set_breadcrumb(lang('location:kota:view'), '/admin/location/kota/view/'.$id)
			->set_breadcrumb(lang('location:kota:edit'))
			->build('admin/kota_form', $data);
    }
	
	/**
     * Delete a kota entry
     * 
     * @param   int [$id] The id of kota to be deleted
     * @return  void
     */
    public function delete($id = 0)
    {
    	// Check whether it has child or not
		$child = $this->kecamatan_m->get_kecamatan_by_kota($id);

		if(count($child)>0) {
			$this->session->set_flashdata('error', lang('location:kota:deleted_has_child'));
			redirect('admin/location/kota/index' . '?' . $_SERVER['QUERY_STRING']);
		}

		// -------------------------------------
		// Delete entry
		// -------------------------------------
		
        $this->kota_m->delete_kota_by_id($id);
        $this->session->set_flashdata('error', lang('location:kota:deleted'));
 
		// -------------------------------------
		// Redirect
		// -------------------------------------
		
        redirect('admin/location/kota/index' . '?' . $_SERVER['QUERY_STRING']);
    }
	
	/**
     * Insert or update kota entry in database
     *
     * @param   string [$method] The method of database update ('new' or 'edit').
	 * @param   int [$row_id] The entry id (if in edit mode).
     * @return	boolean
     */
	private function _update_kota($method, $row_id = null)
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
		$this->form_validation->set_rules('nama', lang('location:nama_kota'), 'required');
		$this->form_validation->set_rules('slug', lang('location:slug_kota'), 'required');
		
		// Set Error Delimns
		$this->form_validation->set_error_delimiters('<div>', '</div>');
		
		$result = false;

		if ($this->form_validation->run() === true)
		{
			if ($method == 'new')
			{
				$result = $this->kota_m->insert_kota($values);
				
			}
			else
			{
				$result = $this->kota_m->update_kota($values, $row_id);
			}
		}
		
		return $result;
	}

	// --------------------------------------------------------------------------

}