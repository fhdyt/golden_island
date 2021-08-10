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

	public function cetak_ttbk()
	{
		$id = $this->uri->segment('3');
		$data = $this->PdfModel->cetak_sj($id);

		$no_surat_jalan = explode("/", $data['detail'][0]->SURAT_JALAN_NOMOR);
		$no_ttbk = $no_surat_jalan[0] . '/TTBK/' . $no_surat_jalan[2] . '/' . $no_surat_jalan[3];

		qrcode($no_ttbk);
		$this->load->view('cetak/cetak_ttbk', $data);
	}

	public function cetak_sj_blanko()
	{
		$id = $this->uri->segment('3');
		$data = $this->PdfModel->cetak_sj($id);
		qrcode($data['detail'][0]->SURAT_JALAN_NOMOR);
		$this->load->view('cetak/cetak_sj_blanko', $data);
	}

	public function cetak_panggung()
	{
		$this->load->model('laporan/PanggungModel');
		$data['barang'] = $this->PanggungModel->ex_list();
		$this->load->view('cetak/cetak_panggung', $data);
	}

	public function cetak_blanko()
	{
		$this->load->view('cetak/cetak_blanko');
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
	public function faktur_penjualan()
	{
		error_reporting(0);
		$id = $this->uri->segment('3');
		$data = $this->PdfModel->faktur_penjualan($id);
		qrcode($data['detail'][0]->FAKTUR_NOMOR);
		//echo json_encode($data);
		$this->load->view('cetak/faktur_penjualan', $data);
	}

	public function faktur_jaminan()
	{
		$id = $this->uri->segment('3');
		$data = $this->PdfModel->faktur_jaminan($id);
		qrcode($data['detail'][0]->FAKTUR_JAMINAN_NOMOR);
		$this->load->view('cetak/faktur_jaminan', $data);
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

	public function cetak_titipan()
	{
		$id = $this->uri->segment('3');
		$data = $this->PdfModel->cetak_titipan($id);
		qrcode($data['detail'][0]->JURNAL_TABUNG_NOMOR);
		$this->load->view('cetak/cetak_titipan', $data);
	}

	public function cetak_gaji()
	{
		$id = $this->uri->segment('3');
		$bulan = $_GET['bulan'];
		$tahun = $_GET['tahun'];
		$data = $this->PdfModel->cetak_gaji($id, $bulan, $tahun);

		$this->load->view('cetak/cetak_gaji', $data);
	}
	public function laporan()
	{
		$dari = $_GET['dari'];
		$sampai = $_GET['sampai'];
		$data['penjualan'] = $this->PdfModel->laporan_penjualan($dari, $sampai);
		$data['barang'] = $this->PdfModel->laporan_barang($dari, $sampai);
		$data['produksi'] = $this->PdfModel->laporan_produksi($dari, $sampai);

		$this->load->view('cetak/laporan', $data);
	}

	public function form_produksi()
	{
		$this->load->view('cetak/form_produksi');
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
