<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Location Module
 *
 * Manage data location of Indonesia (Province, Cities/District, Sub-District, and Villages)
 *
 */
class Admin extends Admin_Controller
{
    // This controller simply redirect to main section controller
	public function __construct()
    {
        parent::__construct();

        redirect('admin/location/provinsi/index');
    }

}