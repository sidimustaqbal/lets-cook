<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Location Module
 *
 * Manage data location of Indonesia (Province, Cities/District, Sub-District, and Villages)
 *
 */
class Admin_provinsi extends Admin_Controller
{
	// -------------------------------------
    // This will set the active section tab
	// -------------------------------------
	
    protected $section = 'provinsi';

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
    }

    /**
	 * List all provinsi
     *
     * @return	void
     */
    public function index()
    {
		// -------------------------------------
		// Get entries
		// -------------------------------------
		
        $data['provinsi']['entries'] = $this->provinsi_m->get_provinsi();
		$data['provinsi']['total'] = count($data['provinsi']['entries']);
		$data['provinsi']['pagination'] = $this->pagination->create_links();

		// -------------------------------------
        // Build the page. See views/admin/index.php
        // for the view code.
		// -------------------------------------
		
        $this->template->title(lang('location:provinsi:plural'))
			->set_breadcrumb('Home', '/admin')
			->set_breadcrumb(lang('location:provinsi:plural'))
			->build('admin/provinsi_index', $data);
    }
	
	/**
     * Display one provinsi
     *
     * @return  void
     */
    public function view($id = 0)
    {
    	redirect('admin/location/provinsi/index');
        // -------------------------------------
		// Get our entry.
		// -------------------------------------
		
        $data['provinsi'] = $this->provinsi_m->get_provinsi_by_id($id);
		
		// -------------------------------------
        // Build the page. See views/admin/index.php
        // for the view code.
		// -------------------------------------
		
        $this->template->title(lang('location:provinsi:view'))
			->set_breadcrumb('Home', '/admin')
			->set_breadcrumb(lang('location:provinsi:plural'), '/admin/location/provinsi/index')
			->set_breadcrumb(lang('location:provinsi:view'))
			->build('admin/provinsi_entry', $data);
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
		// Process POST input
		// -------------------------------------
		
		if($_POST){
			if($this->_update_provinsi('new')){	
				$this->session->set_flashdata('success', lang('location:provinsi:submit_success'));				
				redirect('admin/location/provinsi/index');
			}else{
				$data['messages']['error'] = lang('location:provinsi:submit_failure');
			}
		}
		
		$data['mode'] = 'new';
		$data['return'] = 'admin/location/provinsi/index';
		
		// -------------------------------------
		// Build the form page.
		// -------------------------------------

		$this->template->append_js('jquery/jquery.slugify.js');
		
        $this->template->title(lang('location:provinsi:new'))
			->set_breadcrumb('Home', '/admin')
			->set_breadcrumb(lang('location:provinsi:plural'), '/admin/location/provinsi/index')
			->set_breadcrumb(lang('location:provinsi:new'))
			->build('admin/provinsi_form', $data);
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
		// Process POST input
		// -------------------------------------
		
		if($_POST){
			if($this->_update_provinsi('edit', $id)){	
				$this->session->set_flashdata('success', lang('location:provinsi:submit_success'));				
				redirect('admin/location/provinsi/index');
			}else{
				$data['messages']['error'] = lang('location:provinsi:submit_failure');
			}
		}
		
		$data['fields'] = $this->provinsi_m->get_provinsi_by_id($id);
		$data['mode'] = 'edit';
		$data['return'] = 'admin/location/provinsi/index';
		$data['entry_id'] = $id;
		
		// -------------------------------------
		// Build the form page.
		// -------------------------------------

		$this->template->append_js('jquery/jquery.slugify.js');
		
        $this->template->title(lang('location:provinsi:edit'))
			->set_breadcrumb('Home', '/admin')
			->set_breadcrumb(lang('location:provinsi:plural'), '/admin/location/provinsi/index')
			->set_breadcrumb(lang('location:provinsi:view'), '/admin/location/provinsi/view/'.$id)
			->set_breadcrumb(lang('location:provinsi:edit'))
			->build('admin/provinsi_form', $data);
    }
	
	/**
     * Delete a provinsi entry
     * 
     * @param   int [$id] The id of provinsi to be deleted
     * @return  void
     */
    public function delete($id = 0)
    {
		// Check whether it has child or not
		$child = $this->kota_m->get_kota_by_provinsi($id);

		if(count($child)>0) {
			$this->session->set_flashdata('error', lang('location:provinsi:deleted_has_child'));
			redirect('admin/location/provinsi/index');
		}

		// -------------------------------------
		// Delete entry
		// -------------------------------------
		
        $this->provinsi_m->delete_provinsi_by_id($id);
        $this->session->set_flashdata('error', lang('location:provinsi:deleted'));
 
		// -------------------------------------
		// Redirect
		// -------------------------------------
		
        redirect('admin/location/provinsi/index');
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
		$this->form_validation->set_rules('nama', lang('location:provinsi:nama'), 'required');
		$this->form_validation->set_rules('slug', lang('location:provinsi:slug'), 'required');
		
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

	public function move($direction = '', $id = 0, $order = 0) {
		if($id == 0 or $order == 0 or $direction == '') {
			redirect('admin/location/provinsi/index');
		}

		$provinsi = $this->provinsi_m->get_provinsi();

		if($direction == 'up' AND $order == 1) {
			$this->session->set_flashdata('error', lang('location:move_up_error'));
			redirect('admin/location/provinsi/index');
		}

		if($direction == 'down' AND $order == count($provinsi)) {
			$this->session->set_flashdata('error', lang('location:move_down_error'));
			redirect('admin/location/provinsi/index');
		}

		$move = $this->provinsi_m->move_provinsi($id, $order, $direction);

		if ($move === FALSE) {
			$this->session->set_flashdata('error', lang('location:move_error'));
		} else {
			$this->session->set_flashdata('success', lang('location:move_success'));
		}

		redirect('admin/location/provinsi/index');
	}

}