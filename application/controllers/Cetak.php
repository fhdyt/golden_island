<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Cetak extends CI_Controller
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
		//sudo chmod -R 755 logs
		//sudo chmod -R 777 golden_island/application/logs
		//$this->load->library('ciqrcode');
		$this->load->model('PdfModel');
		$this->load->model('LoginModel');
		$this->LoginModel->cek_login();
	}
	public function index()
	{
	}

	public function cetak_po()
	{
		$id = $this->uri->segment('3');
		$id_pembelian = $this->uri->segment('4');
		$data = $this->PdfModel->cetak_po($id, $id_pembelian);
		qrcode($data['detail'][0]->PEMBELIAN_NOMOR);
		$this->load->view('cetak/cetak_po', $data);
	}
	public function cetak_sj()
	{
		$id = $this->uri->segment('3');
		$data = $this->PdfModel->cetak_sj($id);
		qrcode($data['detail'][0]->SURAT_JALAN_NOMOR);
		$this->load->view('cetak/cetak_sj', $data);
	}

	public function tabung()
	{
		$data['tabung'] = $this->PdfModel->tabung();
		foreach ($data['tabung'] as $row) {
			qrcode($row->MASTER_TABUNG_KODE);
		}
		$this->load->view('cetak/tabung', $data);
	}

	public function faktur()
	{
		$id = $this->uri->segment('3');
		$data = $this->PdfModel->faktur($id);
		qrcode($data['detail'][0]->FAKTUR_NOMOR);
		$this->load->view('cetak/faktur', $data);
	}
	public function kwitansi()
	{
		$id = $this->uri->segment('3');
		$data = $this->PdfModel->faktur($id);
		qrcode($data['detail'][0]->FAKTUR_NOMOR);
		$this->load->view('cetak/kwitansi', $data);
	}
	public function tt()
	{
		$id = $this->uri->segment('3');
		$data = $this->PdfModel->faktur($id);
		qrcode($data['detail'][0]->FAKTUR_NOMOR);
		$this->load->view('cetak/tt', $data);
	}

	// public function member()
	// {
	// 	for ($x = 0; $x <= 100; $x++) {
	// 		$id = "BGS-R" . sprintf("%04d", $x);
	// 		qrcode($id);
	// 	}
	// }
	public function test_qr()
	{

		qrcode("fikri hidayat");
	}
}
