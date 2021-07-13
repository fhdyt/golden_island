<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Publik extends CI_Controller
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
		$this->load->model('PublikModel');
	}
	public function index()
	{
		echo "Anda tidak memiliki akses";
	}

	public function polda_bengkulu()
	{
		$tanggal = $this->uri->segment('3');
		if ($tanggal < '2021-07-10') {
			echo "Laporan Tidak Ditemukan";
		} else {
			$data['surat_jalan'] = $this->PublikModel->polda($tanggal);
			$this->load->view('publik/polda', $data);
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('is_login_golden_island');
		redirect('login');
	}
}
