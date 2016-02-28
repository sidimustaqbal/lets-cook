<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * The public controller for the Home pages.
 *
 * @author		Muhammad Sidi Mustaqbal
 * @package		lets cook
 */
class Home extends Public_Controller
{

	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('blog/blog_m');
		$this->load->model('blog/blog_categories_m');
		$this->load->library(array('keywords/keywords'));
		$this->lang->load('blog/blog');

		$this->load->driver('Streams');

		// We are going to get all the categories so we can
		// easily access them later when processing posts.
		$cates = $this->db->get('blog_categories')->result_array();
		$this->categories = array();
	
		foreach ($cates as $cate)
		{
			$this->categories[$cate['id']] = $cate;
		}

		// Get blog stream. We use this to set the template
		// stream throughout the blog module.
		$this->stream = $this->streams_m->get_stream('blog', true, 'blogs');
	}

	public function index() {
		// Get our comment count whil we're at it.
		$this->row_m->sql['select'][] = "(SELECT COUNT(id) FROM ".
				$this->db->protect_identifiers('comments', true)." WHERE module='blog'
				AND is_active='1' AND entry_key='blog:post' AND entry_plural='blog:posts'
				AND entry_id=".$this->db->protect_identifiers('blog.id', true).") as `comment_count`";

		// Get the latest blog posts
		$posts = $this->streams->entries->get_entries(array(
			'stream'		=> 'blog',
			'namespace'		=> 'blogs',
			'limit'			=> Settings::get('records_per_page'),
			'where'			=> "`status` = 'live'",
			'paginate'		=> 'yes',
			'pag_base'		=> site_url('blog/page'),
			'pag_segment'   => 3
		));

		$data = array(
			'pagination' => $posts['pagination'],
			'posts' => $posts['entries']
		);
		// dump($posts['entries']);
		$this->template
			->set_layout(false)
			->title($this->module_details['name'])
			->set('posts', $posts['entries'])
			->set('pagination', $posts['pagination'])
			->build('home');
	}
}