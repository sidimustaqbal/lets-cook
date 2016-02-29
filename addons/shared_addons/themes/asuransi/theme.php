<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Theme_Asuransi extends Theme {

    public $name = 'Asuransi';
    public $author = 'Riky';
    public $author_website = '';
    public $website = '';
    public $description = '';
    public $version = '1.0.0';
    public $options = array(
        'show_breadcrumbs' => array(
            'title'         => 'Show Breadcrumbs',
            'description'   => 'Would you like to display breadcrumbs?',
            'default'       => 'yes',
            'type'          => 'radio',
            'options'       => 'yes=Yes|no=No',
            'is_required'   => TRUE
        ),
    );


}

