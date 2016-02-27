<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Daftar Module
 *
 * Modul Pendaftaran Untuk Asuransi
 *
 */
class Admin extends Admin_Controller
{
    // This controller simply redirect to main section controller
	public function __construct()
    {
        parent::__construct();

        redirect('admin/daftar/data/index');
    }

}