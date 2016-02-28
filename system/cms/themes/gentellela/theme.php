<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Theme_Gentellela extends Theme {

  public $name			= 'Gentellela';
  public $author			= '';
  public $author_website	= '';
  public $website			= '';
  public $description		= 'Gentellela Theme by zhan';
  public $version			= '1.0.0';
	public $type			= 'admin';
	public $options 		= array('show_breadcrumbs' => 	array('title' 		=> 'Show Breadcrumbs',
																'description'   => 'Would you like to display breadcrumbs?',
																'default'       => 'yes',
																'type'          => 'radio',
																'options'       => 'yes=Yes|no=No',
																'is_required'   => true),
									'layout' => 			array('title' => 'Layout',
																'description'   => 'Which type of layout shall we use?',
																'default'       => '2 column',
																'type'          => 'select',
																'options'       => '2 column=Two Column|full-width=Full Width|full-width-home=Full Width Home Page',
																'is_required'   => true),
								   );
	/**
	 * Run() is triggered when the theme is loaded for use
	 *
	 * This should contain the main logic for the theme.
	 *
	 * @access	public
	 * @return	void
	 */
	public function run()
	{
		
	}
}

/* End of file theme.php */
