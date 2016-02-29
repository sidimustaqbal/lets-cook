<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Location Module
 *
 * Manage data location of Indonesia (Province, Cities/District, Sub-District, and Villages)
 *
 */
class Location extends Public_Controller
{
    // This controller simply redirect to main section controller
	public function __construct()
    {
        parent::__construct();

        redirect('location/provinsi/index');
    }

}