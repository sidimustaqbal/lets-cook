<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Location Module
 *
 * Manage data location of Indonesia (Province, Cities/District, Sub-District, and Villages)
 *
 */
class Location_kota extends Public_Controller
{
	// -------------------------------------
    // This will set the active section tab
	// -------------------------------------
	
    protected $section = 'kota';
	
    public function __construct()
    {
        parent::__construct();

        // -------------------------------------
		// Load everything we need
		// -------------------------------------

		$this->lang->load('buttons');
        $this->lang->load('location');
		
		$this->load->model('kota_m');
    }

    /**
	 * List all kota
     *
     * @return	void
     */
    public function index()
    {
		// -------------------------------------
		// Check permission
		// -------------------------------------
		
		if(! group_has_role('location', 'view_all_kota') AND ! group_has_role('location', 'view_own_kota')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		
        // -------------------------------------
		// Pagination
		// -------------------------------------

		$pagination_config['base_url'] = base_url(). 'location/kota/index';
		$pagination_config['uri_segment'] = 4;
		$pagination_config['total_rows'] = $this->kota_m->count_all_kota();
		$pagination_config['per_page'] = Settings::get('records_per_page');
		$this->pagination->initialize($pagination_config);
		$data['pagination_config'] = $pagination_config;
		
        // -------------------------------------
		// Get entries
		// -------------------------------------
		
        $data['kota']['entries'] = $this->kota_m->get_kota($pagination_config);
		$data['kota']['total'] = count($data['kota']['entries']);
		$data['kota']['pagination'] = $this->pagination->create_links();

		// -------------------------------------
		// Build the page. 
		// -------------------------------------
		
        $this->template->title(lang('location:kota:plural'))
			->set_breadcrumb('Home', '/')
			->set_breadcrumb(lang('location:kota:plural'))
			->build('kota_index', $data);
    }
	
	/**
     * Display one kota
     *
     * @return  void
     */
    public function view($id = 0)
    {
        // -------------------------------------
		// Check permission
		// -------------------------------------
		
		if(! group_has_role('location', 'view_all_kota') AND ! group_has_role('location', 'view_own_kota')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		
		// -------------------------------------
		// Get our entry.
		// -------------------------------------
		
        $data['kota'] = $this->kota_m->get_kota_by_id($id);
		
		// Check view all/own permission
		if(! group_has_role('location', 'view_all_kota')){
			if($data['kota']->created_by != $this->current_user->id){
				$this->session->set_flashdata('error', lang('cp:access_denied'));
				redirect('login');
			}
		}

		// -------------------------------------
		// Build the page.
		// -------------------------------------
		
        $this->template->title(lang('location:kota:view'))
			->set_breadcrumb('Home', '/home')
			->set_breadcrumb(lang('location:kota:plural'), '/location/kota/index')
			->set_breadcrumb(lang('location:kota:view'))
			->build('kota_entry', $data);
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
		// Check permission
		// -------------------------------------
		
		if(! group_has_role('location', 'create_kota')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		
		// -------------------------------------
		// Process POST input
		// -------------------------------------
		
		if($_POST){
			if($this->_update_kota('new')){	
				$this->session->set_flashdata('success', lang('location:kota:submit_success'));				
				redirect('location/kota/index');
			}else{
				$data['messages']['error'] = lang('location:kota:submit_failure');
			}
		}
		
		$data['mode'] = 'new';
		$data['return'] = 'location/kota/index';
		
		// -------------------------------------
		// Build the form page.
		// -------------------------------------
		
        $this->template->title(lang('location:kota:new'))
			->set_breadcrumb('Home', '/home')
			->set_breadcrumb(lang('location:kota:plural'), '/location/kota/index')
			->set_breadcrumb(lang('location:kota:new'))
			->build('kota_form', $data);
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
		// Check permission
		// -------------------------------------
		
		if(! group_has_role('location', 'edit_all_kota') AND ! group_has_role('location', 'edit_own_kota')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		// Check view all/own permission
		if(! group_has_role('location', 'edit_all_kota')){
			$entry = $this->kota_m->get_kota_by_id($id);
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
			if($this->_update_kota('edit', $id)){	
				$this->session->set_flashdata('success', lang('location:kota:submit_success'));				
				redirect('location/kota/index');
			}else{
				$data['messages']['error'] = lang('location:kota:submit_failure');
			}
		}
		
		$data['fields'] = $this->kota_m->get_kota_by_id($id);
		$data['mode'] = 'edit';
		$data['return'] = 'location/kota/view/'.$id;
		$data['entry_id'] = $id;
		
		// -------------------------------------
		// Build the form page.
		// -------------------------------------
        $this->template->title(lang('location:kota:edit'))
			->set_breadcrumb('Home', '/home')
			->set_breadcrumb(lang('location:kota:plural'), '/location/kota/index')
			->set_breadcrumb(lang('location:kota:view'), '/location/kota/view/'.$id)
			->set_breadcrumb(lang('location:kota:edit'))
			->build('kota_form', $data);
    }
	
	/**
     * Delete a kota entry
     * 
     * @param   int [$id] The id of kota to be deleted
     * @return  void
     */
    public function delete($id = 0)
    {
		// -------------------------------------
		// Check permission
		// -------------------------------------
		
		if(! group_has_role('location', 'delete_all_kota') AND ! group_has_role('location', 'delete_own_kota')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		// Check view all/own permission
		if(! group_has_role('location', 'delete_all_kota')){
			$entry = $this->kota_m->get_kota_by_id($id);
			$created_by_user_id = $entry['created_by'];
			if($created_by_user_id != $this->current_user->id){
				$this->session->set_flashdata('error', lang('cp:access_denied'));
				redirect('login');
			}
		}
		
		// -------------------------------------
		// Delete entry
		// -------------------------------------
		
        $this->kota_m->delete_kota_by_id($id);
		$this->session->set_flashdata('error', lang('location:kota:deleted'));
 
		// -------------------------------------
		// Redirect
		// -------------------------------------
		
        redirect('location/kota/index');
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
		$this->form_validation->set_rules('field_name', lang('location:kota:field_name'), 'required');
		
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