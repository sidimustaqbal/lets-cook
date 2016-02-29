<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Location Module
 *
 * Manage data location of Indonesia (Province, Cities/District, Sub-District, and Villages)
 *
 */
class Location_provinsi extends Public_Controller
{
	// -------------------------------------
    // This will set the active section tab
	// -------------------------------------
	
    protected $section = 'provinsi';
	
    public function __construct()
    {
        parent::__construct();

        // -------------------------------------
		// Load everything we need
		// -------------------------------------

		$this->lang->load('buttons');
        $this->lang->load('location');
		
		$this->load->model('provinsi_m');
    }

    /**
	 * List all provinsi
     *
     * @return	void
     */
    public function index()
    {
		// -------------------------------------
		// Check permission
		// -------------------------------------
		
		if(! group_has_role('location', 'view_all_provinsi') AND ! group_has_role('location', 'view_own_provinsi')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		
        // -------------------------------------
		// Pagination
		// -------------------------------------

		$pagination_config['base_url'] = base_url(). 'location/provinsi/index';
		$pagination_config['uri_segment'] = 4;
		$pagination_config['total_rows'] = $this->provinsi_m->count_all_provinsi();
		$pagination_config['per_page'] = Settings::get('records_per_page');
		$this->pagination->initialize($pagination_config);
		$data['pagination_config'] = $pagination_config;
		
        // -------------------------------------
		// Get entries
		// -------------------------------------
		
        $data['provinsi']['entries'] = $this->provinsi_m->get_provinsi($pagination_config);
		$data['provinsi']['total'] = count($data['provinsi']['entries']);
		$data['provinsi']['pagination'] = $this->pagination->create_links();

		// -------------------------------------
		// Build the page. 
		// -------------------------------------
		
        $this->template->title(lang('location:provinsi:plural'))
			->set_breadcrumb('Home', '/')
			->set_breadcrumb(lang('location:provinsi:plural'))
			->build('provinsi_index', $data);
    }
	
	/**
     * Display one provinsi
     *
     * @return  void
     */
    public function view($id = 0)
    {
        // -------------------------------------
		// Check permission
		// -------------------------------------
		
		if(! group_has_role('location', 'view_all_provinsi') AND ! group_has_role('location', 'view_own_provinsi')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		
		// -------------------------------------
		// Get our entry.
		// -------------------------------------
		
        $data['provinsi'] = $this->provinsi_m->get_provinsi_by_id($id);
		
		// Check view all/own permission
		if(! group_has_role('location', 'view_all_provinsi')){
			if($data['provinsi']->created_by != $this->current_user->id){
				$this->session->set_flashdata('error', lang('cp:access_denied'));
				redirect('login');
			}
		}

		// -------------------------------------
		// Build the page.
		// -------------------------------------
		
        $this->template->title(lang('location:provinsi:view'))
			->set_breadcrumb('Home', '/home')
			->set_breadcrumb(lang('location:provinsi:plural'), '/location/provinsi/index')
			->set_breadcrumb(lang('location:provinsi:view'))
			->build('provinsi_entry', $data);
    }
	
	/**
     * Create a new provinsi entry
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
		
		if(! group_has_role('location', 'create_provinsi')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		
		// -------------------------------------
		// Process POST input
		// -------------------------------------
		
		if($_POST){
			if($this->_update_provinsi('new')){	
				$this->session->set_flashdata('success', lang('location:provinsi:submit_success'));				
				redirect('location/provinsi/index');
			}else{
				$data['messages']['error'] = lang('location:provinsi:submit_failure');
			}
		}
		
		$data['mode'] = 'new';
		$data['return'] = 'location/provinsi/index';
		
		// -------------------------------------
		// Build the form page.
		// -------------------------------------
		
        $this->template->title(lang('location:provinsi:new'))
			->set_breadcrumb('Home', '/home')
			->set_breadcrumb(lang('location:provinsi:plural'), '/location/provinsi/index')
			->set_breadcrumb(lang('location:provinsi:new'))
			->build('provinsi_form', $data);
    }
	
	/**
     * Edit a provinsi entry
     *
     * We're passing the
     * id of the entry, which will allow entry_form to
     * repopulate the data from the database.
	 * We are building entry form manually using the fields API
     * and displaying the output in a custom view file.
     *
     * @param   int [$id] The id of the provinsi to the be deleted.
     * @return	void
     */
    public function edit($id = 0)
    {
        // -------------------------------------
		// Check permission
		// -------------------------------------
		
		if(! group_has_role('location', 'edit_all_provinsi') AND ! group_has_role('location', 'edit_own_provinsi')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		// Check view all/own permission
		if(! group_has_role('location', 'edit_all_provinsi')){
			$entry = $this->provinsi_m->get_provinsi_by_id($id);
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
			if($this->_update_provinsi('edit', $id)){	
				$this->session->set_flashdata('success', lang('location:provinsi:submit_success'));				
				redirect('location/provinsi/index');
			}else{
				$data['messages']['error'] = lang('location:provinsi:submit_failure');
			}
		}
		
		$data['fields'] = $this->provinsi_m->get_provinsi_by_id($id);
		$data['mode'] = 'edit';
		$data['return'] = 'location/provinsi/view/'.$id;
		$data['entry_id'] = $id;
		
		// -------------------------------------
		// Build the form page.
		// -------------------------------------
        $this->template->title(lang('location:provinsi:edit'))
			->set_breadcrumb('Home', '/home')
			->set_breadcrumb(lang('location:provinsi:plural'), '/location/provinsi/index')
			->set_breadcrumb(lang('location:provinsi:view'), '/location/provinsi/view/'.$id)
			->set_breadcrumb(lang('location:provinsi:edit'))
			->build('provinsi_form', $data);
    }
	
	/**
     * Delete a provinsi entry
     * 
     * @param   int [$id] The id of provinsi to be deleted
     * @return  void
     */
    public function delete($id = 0)
    {
		// -------------------------------------
		// Check permission
		// -------------------------------------
		
		if(! group_has_role('location', 'delete_all_provinsi') AND ! group_has_role('location', 'delete_own_provinsi')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		// Check view all/own permission
		if(! group_has_role('location', 'delete_all_provinsi')){
			$entry = $this->provinsi_m->get_provinsi_by_id($id);
			$created_by_user_id = $entry['created_by'];
			if($created_by_user_id != $this->current_user->id){
				$this->session->set_flashdata('error', lang('cp:access_denied'));
				redirect('login');
			}
		}
		
		// -------------------------------------
		// Delete entry
		// -------------------------------------
		
        $this->provinsi_m->delete_provinsi_by_id($id);
		$this->session->set_flashdata('error', lang('location:provinsi:deleted'));
 
		// -------------------------------------
		// Redirect
		// -------------------------------------
		
        redirect('location/provinsi/index');
    }
	
	/**
     * Insert or update provinsi entry in database
     *
     * @param   string [$method] The method of database update ('new' or 'edit').
	 * @param   int [$row_id] The entry id (if in edit mode).
     * @return	boolean
     */
	private function _update_provinsi($method, $row_id = null)
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
		$this->form_validation->set_rules('field_name', lang('location:provinsi:field_name'), 'required');
		
		// Set Error Delimns
		$this->form_validation->set_error_delimiters('<div>', '</div>');
		
		$result = false;

		if ($this->form_validation->run() === true)
		{
			if ($method == 'new')
			{
				$result = $this->provinsi_m->insert_provinsi($values);
			}
			else
			{
				$result = $this->provinsi_m->update_provinsi($values, $row_id);
			}
		}
		
		return $result;
	}

	// --------------------------------------------------------------------------

}