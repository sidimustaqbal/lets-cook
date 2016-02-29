<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Daftar Module
 *
 * Modul Pendaftaran Untuk Asuransi
 *
 */
class Admin_data extends Admin_Controller
{
	// -------------------------------------
    // This will set the active section tab
	// -------------------------------------

    protected $section = 'data';
    private $status = array(''=>'-- Pilih Status --',1=>'Belum Diproses',2=>'Sedang Diproses',3=>'Selesai Diproses',4=>'Dibatalkan Pelanggan',5=>'Ditolak Pihak Asuransi');

    public function __construct()
    {
      parent::__construct();

			// -------------------------------------
			// Check permission
			// -------------------------------------

			if(! group_has_role('daftar', 'access_data_backend')){
				$this->session->set_flashdata('error', lang('cp:access_denied'));
				redirect('admin');
			}

			// -------------------------------------
			// Load everything we need
			// -------------------------------------

      $this->lang->load('daftar');
			$this->load->model('data_m');
			$this->load->library('pagination');
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
				redirect('admin');
			}

			// -------------------------------------
			// Pagination
			// -------------------------------------

			$pagination_config['base_url'] = base_url(). 'admin/daftar/data/index';
			$pagination_config['uri_segment'] = 5;
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
			$data['status'] = $this->status;

			// -------------------------------------
      // Build the page. See views/admin/index.php
      // for the view code.
			// -------------------------------------

      $this->template->title(lang('daftar:data:plural'))
				->set_breadcrumb('Home', '/admin')
				->set_breadcrumb(lang('daftar:data:plural'))
				->build('admin/data_index', $data);
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
				redirect('admin');
			}

			// -------------------------------------
			// Get our entry.
			// -------------------------------------

        $data['data'] = $this->data_m->get_data_by_id($id);
        // $data['lang']['calono'] = lang('calono');

			// -------------------------------------
			// Check view all/own permission
			// -------------------------------------

			if(! group_has_role('daftar', 'view_all_data')){
				if($data['data']->created_by != $this->current_user->id){
					$this->session->set_flashdata('error', lang('cp:access_denied'));
					redirect('admin');
				}
			}
			$data['status'] = $this->status;
			$data['arr_key'] = array('ayah'=>'Ayah','ibu'=>'Ibu','laki'=>'Saudara Laki-Laki','perempuan'=>'Saudara Perempuan');

			// -------------------------------------
      // Build the page. See views/admin/index.php
      // for the view code.
			// -------------------------------------

      $this->template->title(lang('daftar:data:view'))
			->set_breadcrumb('Home', '/admin')
			->set_breadcrumb(lang('daftar:data:plural'), '/admin/daftar/data/index')
			->set_breadcrumb(lang('daftar:data:view'))
			->build('admin/data_entry', $data);
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
			redirect('admin');
		}

		// -------------------------------------
		// Process POST input
		// -------------------------------------

		if($_POST){
			if($this->_update_data('new')){
				$this->session->set_flashdata('success', lang('daftar:data:submit_success'));
				redirect('admin/daftar/data/index');
			}else{
				$data['messages']['error'] = lang('daftar:data:submit_failure');
			}
		}

		$data['mode'] = 'new';
		$data['return'] = 'admin/daftar/data/index';

		// -------------------------------------
		// Build the form page.
		// -------------------------------------

        $this->template->title(lang('daftar:data:new'))
			->set_breadcrumb('Home', '/admin')
			->set_breadcrumb(lang('daftar:data:plural'), '/admin/daftar/data/index')
			->set_breadcrumb(lang('daftar:data:new'))
			->build('admin/data_form', $data);
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
			redirect('admin');
		}

		// Check view all/own permission
		if(! group_has_role('daftar', 'edit_all_data')){
			$entry = $this->data_m->get_data_by_id($id);
			$created_by_user_id = $entry['created_by'];
			if($created_by_user_id != $this->current_user->id){
				$this->session->set_flashdata('error', lang('cp:access_denied'));
				redirect('admin');
			}
		}

		// -------------------------------------
		// Process POST input
		// -------------------------------------

		if($_POST){
			if($this->_update_data('edit', $id)){
				$this->session->set_flashdata('success', lang('daftar:data:submit_success'));
				redirect('admin/daftar/data/index');
			}else{
				$data['messages']['error'] = lang('daftar:data:submit_failure');
			}
		}

		$data['fields'] = $this->data_m->get_data_by_id($id);
		$data['mode'] = 'edit';
		$data['return'] = 'admin/daftar/data/view/'.$id;
		$data['entry_id'] = $id;

		// -------------------------------------
		// Build the form page.
		// -------------------------------------

        $this->template->title(lang('daftar:data:edit'))
			->set_breadcrumb('Home', '/admin')
			->set_breadcrumb(lang('daftar:data:plural'), '/admin/daftar/data/index')
			->set_breadcrumb(lang('daftar:data:view'), '/admin/daftar/data/view/'.$id)
			->set_breadcrumb(lang('daftar:data:edit'))
			->build('admin/data_form', $data);
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
			redirect('admin');
		}
		// Check view all/own permission
		if(! group_has_role('daftar', 'delete_all_data')){
			$entry = $this->data_m->get_data_by_id($id);
			$created_by_user_id = $entry['created_by'];
			if($created_by_user_id != $this->current_user->id){
				$this->session->set_flashdata('error', lang('cp:access_denied'));
				redirect('admin');
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

        redirect('admin/daftar/data/index');
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