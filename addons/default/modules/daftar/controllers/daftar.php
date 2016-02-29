<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Daftar Module
 *
 * Modul Pendaftaran Untuk Asuransi
 *
 */
class Daftar extends Public_Controller
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
			// Process POST input
			// -------------------------------------

   //  	if($this->input->post()){
			// 	dump($_POST);
			// 	die();
			// }
			// if($this->input->get()){
			// 	dump($_GET);
			// 	die();
			// }

			if($_POST){

				if($this->_update_data('new')){
					$this->session->set_flashdata('success', lang('daftar:data:submit_success'));
					redirect('daftar');
				}else{
					$data['messages']['error'] = lang('daftar:data:submit_failure');
				}
			}

			$data['mode'] = 'new';

			// -------------------------------------
			// Build the form page.
			// -------------------------------------

        $this->template->title(lang('daftar:data:new'))
			->set_breadcrumb('Home', '/home')
			->set_breadcrumb(lang('daftar:data:plural'), '/daftar/index')
			->set_breadcrumb(lang('daftar:data:new'))
			->build('data_index', $data);
    }


	/**
     * Insert or update data entry in database
     *
     * @param   string [$method] The method of database update ('new' or 'edit').
	 * @param   int [$row_id] The entry id (if in edit mode).
     * @return	boolean
     */
	private function _update_data($method)
 	{
 		$row_id = null;
 		// -------------------------------------
		// Load everything we need
		// -------------------------------------

		$this->load->helper(array('form', 'url'));

 		// -------------------------------------
		// Set Values
		// -------------------------------------

		$values['nama'] = ($this->input->post('pemilik')=='perusahaan') ? $this->input->post('calonp')['kantor'] : $this->input->post('calono')['nama'] ;
		$values['status'] = 1;
		$values['form'] = json_encode($this->input->post(),true);

		$result = false;
		$this->form_validation->set_rules('pemilik', 'Pemilik Polis', 'required');

		// -------------------------------------
		// Validation
		// -------------------------------------

		// Set Error Delimns
		$this->form_validation->set_error_delimiters('<div>', '</div>');

		if ($this->form_validation->run() === true)
		{
			if ($method == 'new')
			{
				$result = $this->data_m->insert_data($values);
			}
		}

		return $result;
	}

	// --------------------------------------------------------------------------

}