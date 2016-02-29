<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Daftar Module
 *
 * Modul Pendaftaran Untuk Asuransi
 *
 */
class Daftar_data extends Public_Controller
{
	// -------------------------------------
    // This will set the active section tab
	// -------------------------------------

    protected $section = 'data';

    public function __construct()
    {
        parent::__construct();

        // -------------------------------------
		// Load everything we need
		// -------------------------------------

		$this->lang->load('buttons');
        $this->lang->load('daftar');

		$this->load->model('data_m');
    }

    /**
	 * List all data
     *
     * @return	void
     */
    public function index()
    {
			// -------------------------------------
			// Check permission
			// -------------------------------------

			if(! group_has_role('daftar', 'view_all_data') AND ! group_has_role('daftar', 'view_own_data')){
				$this->session->set_flashdata('error', lang('cp:access_denied'));
				redirect('login');
			}

      // -------------------------------------
			// Pagination
			// -------------------------------------

			$pagination_config['base_url'] = base_url(). 'daftar/data/index';
			$pagination_config['uri_segment'] = 4;
			$pagination_config['total_rows'] = $this->data_m->count_all_data();
			$pagination_config['per_page'] = Settings::get('records_per_page');
			$this->pagination->initialize($pagination_config);
			$data['pagination_config'] = $pagination_config;

      // -------------------------------------
			// Get entries
			// -------------------------------------

      $data['data']['entries'] = $this->data_m->get_data($pagination_config);
			$data['data']['total'] = count($data['data']['entries']);
			$data['data']['pagination'] = $this->pagination->create_links();

			// -------------------------------------
			// Build the page.
			// -------------------------------------

      $this->template->title(lang('daftar:data:plural'))
			->set_breadcrumb('Home', '/')
			->set_breadcrumb(lang('daftar:data:plural'))
			->build('data_index', $data);
    }

	/**
     * Display one data
     *
     * @return  void
     */
    public function view($id = 0)
    {
        // -------------------------------------
		// Check permission
		// -------------------------------------

		if(! group_has_role('daftar', 'view_all_data') AND ! group_has_role('daftar', 'view_own_data')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}

		// -------------------------------------
		// Get our entry.
		// -------------------------------------

        $data['data'] = $this->data_m->get_data_by_id($id);

		// Check view all/own permission
		if(! group_has_role('daftar', 'view_all_data')){
			if($data['data']->created_by != $this->current_user->id){
				$this->session->set_flashdata('error', lang('cp:access_denied'));
				redirect('login');
			}
		}

		// -------------------------------------
		// Build the page.
		// -------------------------------------

        $this->template->title(lang('daftar:data:view'))
			->set_breadcrumb('Home', '/home')
			->set_breadcrumb(lang('daftar:data:plural'), '/daftar/data/index')
			->set_breadcrumb(lang('daftar:data:view'))
			->build('data_entry', $data);
    }

	/**
     * Create a new data entry
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

		if(! group_has_role('daftar', 'create_data')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}

		// -------------------------------------
		// Process POST input
		// -------------------------------------

		if($_POST){
			if($this->_update_data('new')){
				$this->session->set_flashdata('success', lang('daftar:data:submit_success'));
				redirect('daftar/data/index');
			}else{
				$data['messages']['error'] = lang('daftar:data:submit_failure');
			}
		}

		$data['mode'] = 'new';
		$data['return'] = 'daftar/data/index';

		// -------------------------------------
		// Build the form page.
		// -------------------------------------

        $this->template->title(lang('daftar:data:new'))
			->set_breadcrumb('Home', '/home')
			->set_breadcrumb(lang('daftar:data:plural'), '/daftar/data/index')
			->set_breadcrumb(lang('daftar:data:new'))
			->build('data_form', $data);
    }

	/**
     * Edit a data entry
     *
     * We're passing the
     * id of the entry, which will allow entry_form to
     * repopulate the data from the database.
	 * We are building entry form manually using the fields API
     * and displaying the output in a custom view file.
     *
     * @param   int [$id] The id of the data to the be deleted.
     * @return	void
     */
    public function edit($id = 0)
    {
        // -------------------------------------
		// Check permission
		// -------------------------------------

		if(! group_has_role('daftar', 'edit_all_data') AND ! group_has_role('daftar', 'edit_own_data')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		// Check view all/own permission
		if(! group_has_role('daftar', 'edit_all_data')){
			$entry = $this->data_m->get_data_by_id($id);
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
			if($this->_update_data('edit', $id)){
				$this->session->set_flashdata('success', lang('daftar:data:submit_success'));
				redirect('daftar/data/index');
			}else{
				$data['messages']['error'] = lang('daftar:data:submit_failure');
			}
		}

		$data['fields'] = $this->data_m->get_data_by_id($id);
		$data['mode'] = 'edit';
		$data['return'] = 'daftar/data/view/'.$id;
		$data['entry_id'] = $id;

		// -------------------------------------
		// Build the form page.
		// -------------------------------------
        $this->template->title(lang('daftar:data:edit'))
			->set_breadcrumb('Home', '/home')
			->set_breadcrumb(lang('daftar:data:plural'), '/daftar/data/index')
			->set_breadcrumb(lang('daftar:data:view'), '/daftar/data/view/'.$id)
			->set_breadcrumb(lang('daftar:data:edit'))
			->build('data_form', $data);
    }

	/**
     * Delete a data entry
     *
     * @param   int [$id] The id of data to be deleted
     * @return  void
     */
    public function delete($id = 0)
    {
		// -------------------------------------
		// Check permission
		// -------------------------------------

		if(! group_has_role('daftar', 'delete_all_data') AND ! group_has_role('daftar', 'delete_own_data')){
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect('login');
		}
		// Check view all/own permission
		if(! group_has_role('daftar', 'delete_all_data')){
			$entry = $this->data_m->get_data_by_id($id);
			$created_by_user_id = $entry['created_by'];
			if($created_by_user_id != $this->current_user->id){
				$this->session->set_flashdata('error', lang('cp:access_denied'));
				redirect('login');
			}
		}

		// -------------------------------------
		// Delete entry
		// -------------------------------------

        $this->data_m->delete_data_by_id($id);
		$this->session->set_flashdata('error', lang('daftar:data:deleted'));

		// -------------------------------------
		// Redirect
		// -------------------------------------

        redirect('daftar/data/index');
    }

	/**
     * Insert or update data entry in database
     *
     * @param   string [$method] The method of database update ('new' or 'edit').
	 * @param   int [$row_id] The entry id (if in edit mode).
     * @return	boolean
     */
	private function _update_data($method, $row_id = null)
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
		$this->form_validation->set_rules('field_name', lang('daftar:data:field_name'), 'required');

		// Set Error Delimns
		$this->form_validation->set_error_delimiters('<div>', '</div>');

		$result = false;

		if ($this->form_validation->run() === true)
		{
			if ($method == 'new')
			{
				$result = $this->data_m->insert_data($values);
			}
			else
			{
				$result = $this->data_m->update_data($values, $row_id);
			}
		}

		return $result;
	}

	// --------------------------------------------------------------------------

}