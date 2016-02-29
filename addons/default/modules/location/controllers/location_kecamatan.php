<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Location Module
 *
 * Manage data location of Indonesia (Province, Cities/District, Sub-District, and Villages)
 *
 */
class Location_kecamatan extends Public_Controller
{
	// -------------------------------------
    // This will set the active section tab
	// -------------------------------------
	
    protected $section = 'kecamatan';
	
    public function __construct()
    {
        parent::__construct();

        // -------------------------------------
		// Load everything we need
		// -------------------------------------

		$this->lang->load('buttons');
        $this->lang->load('location');
		
		$this->load->model('kecamatan_m');
    }

    /**
	 * List all kecamatan
     *
     * @return	void
     */
    public function index()
    {
		// -------------------------------------
		// Check permission
		// -------------------------------------
		
		if(! group_has_role('location', 'view_all_kecamatan') AND ! group_has_role('location', 'view_own_kecamatan')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		
        // -------------------------------------
		// Pagination
		// -------------------------------------

		$pagination_config['base_url'] = base_url(). 'location/kecamatan/index';
		$pagination_config['uri_segment'] = 4;
		$pagination_config['total_rows'] = $this->kecamatan_m->count_all_kecamatan();
		$pagination_config['per_page'] = Settings::get('records_per_page');
		$this->pagination->initialize($pagination_config);
		$data['pagination_config'] = $pagination_config;
		
        // -------------------------------------
		// Get entries
		// -------------------------------------
		
        $data['kecamatan']['entries'] = $this->kecamatan_m->get_kecamatan($pagination_config);
		$data['kecamatan']['total'] = count($data['kecamatan']['entries']);
		$data['kecamatan']['pagination'] = $this->pagination->create_links();

		// -------------------------------------
		// Build the page. 
		// -------------------------------------
		
        $this->template->title(lang('location:kecamatan:plural'))
			->set_breadcrumb('Home', '/')
			->set_breadcrumb(lang('location:kecamatan:plural'))
			->build('kecamatan_index', $data);
    }
	
	/**
     * Display one kecamatan
     *
     * @return  void
     */
    public function view($id = 0)
    {
        // -------------------------------------
		// Check permission
		// -------------------------------------
		
		if(! group_has_role('location', 'view_all_kecamatan') AND ! group_has_role('location', 'view_own_kecamatan')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		
		// -------------------------------------
		// Get our entry.
		// -------------------------------------
		
        $data['kecamatan'] = $this->kecamatan_m->get_kecamatan_by_id($id);
		
		// Check view all/own permission
		if(! group_has_role('location', 'view_all_kecamatan')){
			if($data['kecamatan']->created_by != $this->current_user->id){
				$this->session->set_flashdata('error', lang('cp:access_denied'));
				redirect('login');
			}
		}

		// -------------------------------------
		// Build the page.
		// -------------------------------------
		
        $this->template->title(lang('location:kecamatan:view'))
			->set_breadcrumb('Home', '/home')
			->set_breadcrumb(lang('location:kecamatan:plural'), '/location/kecamatan/index')
			->set_breadcrumb(lang('location:kecamatan:view'))
			->build('kecamatan_entry', $data);
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
		// Check permission
		// -------------------------------------
		
		if(! group_has_role('location', 'create_kecamatan')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		
		// -------------------------------------
		// Process POST input
		// -------------------------------------
		
		if($_POST){
			if($this->_update_kecamatan('new')){	
				$this->session->set_flashdata('success', lang('location:kecamatan:submit_success'));				
				redirect('location/kecamatan/index');
			}else{
				$data['messages']['error'] = lang('location:kecamatan:submit_failure');
			}
		}
		
		$data['mode'] = 'new';
		$data['return'] = 'location/kecamatan/index';
		
		// -------------------------------------
		// Build the form page.
		// -------------------------------------
		
        $this->template->title(lang('location:kecamatan:new'))
			->set_breadcrumb('Home', '/home')
			->set_breadcrumb(lang('location:kecamatan:plural'), '/location/kecamatan/index')
			->set_breadcrumb(lang('location:kecamatan:new'))
			->build('kecamatan_form', $data);
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
		// Check permission
		// -------------------------------------
		
		if(! group_has_role('location', 'edit_all_kecamatan') AND ! group_has_role('location', 'edit_own_kecamatan')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		// Check view all/own permission
		if(! group_has_role('location', 'edit_all_kecamatan')){
			$entry = $this->kecamatan_m->get_kecamatan_by_id($id);
			$created_by_user_id = $entry['created_by'];
			if($created_by_user_id != $this->current_user->id){
				$this->session->set_flashdata('error', lang('cp:access_denied'));
				redirect('login');
			}
		}
		
		// -------------------------------------
		// Process POST input
		// -------------------------------------
		
		if($_POST){
			if($this->_update_kecamatan('edit', $id)){	
				$this->session->set_flashdata('success', lang('location:kecamatan:submit_success'));				
				redirect('location/kecamatan/index');
			}else{
				$data['messages']['error'] = lang('location:kecamatan:submit_failure');
			}
		}
		
		$data['fields'] = $this->kecamatan_m->get_kecamatan_by_id($id);
		$data['mode'] = 'edit';
		$data['return'] = 'location/kecamatan/view/'.$id;
		$data['entry_id'] = $id;
		
		// -------------------------------------
		// Build the form page.
		// -------------------------------------
        $this->template->title(lang('location:kecamatan:edit'))
			->set_breadcrumb('Home', '/home')
			->set_breadcrumb(lang('location:kecamatan:plural'), '/location/kecamatan/index')
			->set_breadcrumb(lang('location:kecamatan:view'), '/location/kecamatan/view/'.$id)
			->set_breadcrumb(lang('location:kecamatan:edit'))
			->build('kecamatan_form', $data);
    }
	
	/**
     * Delete a kecamatan entry
     * 
     * @param   int [$id] The id of kecamatan to be deleted
     * @return  void
     */
    public function delete($id = 0)
    {
		// -------------------------------------
		// Check permission
		// -------------------------------------
		
		if(! group_has_role('location', 'delete_all_kecamatan') AND ! group_has_role('location', 'delete_own_kecamatan')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		// Check view all/own permission
		if(! group_has_role('location', 'delete_all_kecamatan')){
			$entry = $this->kecamatan_m->get_kecamatan_by_id($id);
			$created_by_user_id = $entry['created_by'];
			if($created_by_user_id != $this->current_user->id){
				$this->session->set_flashdata('error', lang('cp:access_denied'));
				redirect('login');
			}
		}
		
		// -------------------------------------
		// Delete entry
		// -------------------------------------
		
        $this->kecamatan_m->delete_kecamatan_by_id($id);
		$this->session->set_flashdata('error', lang('location:kecamatan:deleted'));
 
		// -------------------------------------
		// Redirect
		// -------------------------------------
		
        redirect('location/kecamatan/index');
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
		$this->form_validation->set_rules('field_name', lang('location:kecamatan:field_name'), 'required');
		
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

}