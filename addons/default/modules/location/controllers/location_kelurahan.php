<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Location Module
 *
 * Manage data location of Indonesia (Province, Cities/District, Sub-District, and Villages)
 *
 */
class Location_kelurahan extends Public_Controller
{
	// -------------------------------------
    // This will set the active section tab
	// -------------------------------------
	
    protected $section = 'kelurahan';
	
    public function __construct()
    {
        parent::__construct();

        // -------------------------------------
		// Load everything we need
		// -------------------------------------

		$this->lang->load('buttons');
        $this->lang->load('location');
		
		$this->load->model('kelurahan_m');
    }

    /**
	 * List all kelurahan
     *
     * @return	void
     */
    public function index()
    {
		// -------------------------------------
		// Check permission
		// -------------------------------------
		
		if(! group_has_role('location', 'view_all_kelurahan') AND ! group_has_role('location', 'view_own_kelurahan')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		
        // -------------------------------------
		// Pagination
		// -------------------------------------

		$pagination_config['base_url'] = base_url(). 'location/kelurahan/index';
		$pagination_config['uri_segment'] = 4;
		$pagination_config['total_rows'] = $this->kelurahan_m->count_all_kelurahan();
		$pagination_config['per_page'] = Settings::get('records_per_page');
		$this->pagination->initialize($pagination_config);
		$data['pagination_config'] = $pagination_config;
		
        // -------------------------------------
		// Get entries
		// -------------------------------------
		
        $data['kelurahan']['entries'] = $this->kelurahan_m->get_kelurahan($pagination_config);
		$data['kelurahan']['total'] = count($data['kelurahan']['entries']);
		$data['kelurahan']['pagination'] = $this->pagination->create_links();

		// -------------------------------------
		// Build the page. 
		// -------------------------------------
		
        $this->template->title(lang('location:kelurahan:plural'))
			->set_breadcrumb('Home', '/')
			->set_breadcrumb(lang('location:kelurahan:plural'))
			->build('kelurahan_index', $data);
    }
	
	/**
     * Display one kelurahan
     *
     * @return  void
     */
    public function view($id = 0)
    {
        // -------------------------------------
		// Check permission
		// -------------------------------------
		
		if(! group_has_role('location', 'view_all_kelurahan') AND ! group_has_role('location', 'view_own_kelurahan')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		
		// -------------------------------------
		// Get our entry.
		// -------------------------------------
		
        $data['kelurahan'] = $this->kelurahan_m->get_kelurahan_by_id($id);
		
		// Check view all/own permission
		if(! group_has_role('location', 'view_all_kelurahan')){
			if($data['kelurahan']->created_by != $this->current_user->id){
				$this->session->set_flashdata('error', lang('cp:access_denied'));
				redirect('login');
			}
		}

		// -------------------------------------
		// Build the page.
		// -------------------------------------
		
        $this->template->title(lang('location:kelurahan:view'))
			->set_breadcrumb('Home', '/home')
			->set_breadcrumb(lang('location:kelurahan:plural'), '/location/kelurahan/index')
			->set_breadcrumb(lang('location:kelurahan:view'))
			->build('kelurahan_entry', $data);
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
		// Check permission
		// -------------------------------------
		
		if(! group_has_role('location', 'create_kelurahan')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		
		// -------------------------------------
		// Process POST input
		// -------------------------------------
		
		if($_POST){
			if($this->_update_kelurahan('new')){	
				$this->session->set_flashdata('success', lang('location:kelurahan:submit_success'));				
				redirect('location/kelurahan/index');
			}else{
				$data['messages']['error'] = lang('location:kelurahan:submit_failure');
			}
		}
		
		$data['mode'] = 'new';
		$data['return'] = 'location/kelurahan/index';
		
		// -------------------------------------
		// Build the form page.
		// -------------------------------------
		
        $this->template->title(lang('location:kelurahan:new'))
			->set_breadcrumb('Home', '/home')
			->set_breadcrumb(lang('location:kelurahan:plural'), '/location/kelurahan/index')
			->set_breadcrumb(lang('location:kelurahan:new'))
			->build('kelurahan_form', $data);
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
		// Check permission
		// -------------------------------------
		
		if(! group_has_role('location', 'edit_all_kelurahan') AND ! group_has_role('location', 'edit_own_kelurahan')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		// Check view all/own permission
		if(! group_has_role('location', 'edit_all_kelurahan')){
			$entry = $this->kelurahan_m->get_kelurahan_by_id($id);
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
			if($this->_update_kelurahan('edit', $id)){	
				$this->session->set_flashdata('success', lang('location:kelurahan:submit_success'));				
				redirect('location/kelurahan/index');
			}else{
				$data['messages']['error'] = lang('location:kelurahan:submit_failure');
			}
		}
		
		$data['fields'] = $this->kelurahan_m->get_kelurahan_by_id($id);
		$data['mode'] = 'edit';
		$data['return'] = 'location/kelurahan/view/'.$id;
		$data['entry_id'] = $id;
		
		// -------------------------------------
		// Build the form page.
		// -------------------------------------
        $this->template->title(lang('location:kelurahan:edit'))
			->set_breadcrumb('Home', '/home')
			->set_breadcrumb(lang('location:kelurahan:plural'), '/location/kelurahan/index')
			->set_breadcrumb(lang('location:kelurahan:view'), '/location/kelurahan/view/'.$id)
			->set_breadcrumb(lang('location:kelurahan:edit'))
			->build('kelurahan_form', $data);
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
		// Check permission
		// -------------------------------------
		
		if(! group_has_role('location', 'delete_all_kelurahan') AND ! group_has_role('location', 'delete_own_kelurahan')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		// Check view all/own permission
		if(! group_has_role('location', 'delete_all_kelurahan')){
			$entry = $this->kelurahan_m->get_kelurahan_by_id($id);
			$created_by_user_id = $entry['created_by'];
			if($created_by_user_id != $this->current_user->id){
				$this->session->set_flashdata('error', lang('cp:access_denied'));
				redirect('login');
			}
		}
		
		// -------------------------------------
		// Delete entry
		// -------------------------------------
		
        $this->kelurahan_m->delete_kelurahan_by_id($id);
		$this->session->set_flashdata('error', lang('location:kelurahan:deleted'));
 
		// -------------------------------------
		// Redirect
		// -------------------------------------
		
        redirect('location/kelurahan/index');
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
		$this->form_validation->set_rules('field_name', lang('location:kelurahan:field_name'), 'required');
		
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

}