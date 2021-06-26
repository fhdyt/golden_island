<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
		$this->load->model('DashboardModel');
		$this->load->model('LoginModel');
		$this->LoginModel->cek_login();
	}

	public function index()
	{
		$data['menu'] = $this->LoginModel->menu();
		$this->load->view('_template/header', $data);
		$this->load->view('dashboard');
		$this->load->view('_template/footer');
	}
	public function not_found()
	{
		$this->load->view('_template/header');
		$this->load->view('errors/404');
		$this->load->view('_template/footer');
	}
	public function akses()
	{
		$this->load->view('_template/header');
		$this->load->view('errors/akses');
		$this->load->view('_template/footer');
	}

	public function list_catatan()
	{
		$data = $this->DashboardModel->list_catatan();
		echo json_encode($data);
	}

	public function add()
	{
		$data = $this->DashboardModel->add();
	}

	public function hapus()
	{
		$id = $this->uri->segment('3');
		$data = $this->DashboardModel->hapus($id);
		echo json_encode($data);
	}

	public function folder()
	{
		mkdir("/test", 0777, true);
	}
}
