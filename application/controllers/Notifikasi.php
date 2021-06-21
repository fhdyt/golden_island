<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifikasi extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */



	function __construct()
	{
		parent::__construct();
		$this->load->model('PdfModel');
		$this->load->model('LoginModel');
		$this->LoginModel->cek_login();
	}

	public function index()
	{
	}
	public function telegram()
	{
		send_telegram("Test");
	}
	public function test()
	{
		//notifikasi();
		//$this->load->library('ci_pusher');
		// $options = array(
		// 	'cluster' => 'ap1',
		// 	'useTLS' => true
		// );
		// $pusher = new Pusher\Pusher(
		// 	'1b15b42882162825307f',
		// 	'7d1aa65ac06a11eabb87',
		// 	'1191698',
		// 	$options
		// );

		// $data['message'] = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam rerum ipsum numquam natus, tenetur molestiae iste sequi cupiditate minima in minus laudantium exercitationem magni magnam unde vero quidem placeat! In!';
		// $pusher->trigger('my-channel', 'my-event', $data);
	}
}
