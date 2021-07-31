<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Faktur extends CI_Controller
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
        $this->load->model('penjualan/FakturModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {
        $this->load->view('_template/header');
        $this->load->view('penjualan/faktur/v_faktur');
        $this->load->view('_template/footer');
    }
    public function form()
    {
        $this->load->view('_template/header');
        $this->load->view('penjualan/faktur/v_form');
        $this->load->view('_template/footer');
    }


    public function list()
    {
        $data = $this->FakturModel->list();
        echo json_encode($data);
    }

    public function surat_jalan_baru()
    {
        $data = $this->FakturModel->surat_jalan_baru();
        echo json_encode($data);
    }

    public function surat_jalan_list()
    {
        $id = $this->uri->segment('4');
        $data = $this->FakturModel->surat_jalan_list($id);
        echo json_encode($data);
    }

    public function barang_list()
    {
        $id = $this->uri->segment('4');
        $relasi = $_GET['relasi'];
        $data = $this->FakturModel->barang_list($id, $relasi);
        echo json_encode($data);
    }
    public function jaminan_list()
    {
        $id = $this->uri->segment('4');
        $relasi = $_GET['relasi'];
        $data = $this->FakturModel->jaminan_list($id, $relasi);
        echo json_encode($data);
    }

    public function surat_jalan()
    {
        $relasi = $_GET['relasi'];
        $data = $this->FakturModel->surat_jalan($relasi);
        echo json_encode($data);
    }

    public function add()
    {
        $data = $this->FakturModel->add();
        echo json_encode($data);
    }

    public function edit_harga_jaminan()
    {
        $data = $this->FakturModel->edit_harga_jaminan();
        echo json_encode($data);
    }

    public function edit_harga_barang()
    {
        $data = $this->FakturModel->edit_harga_barang();
        echo json_encode($data);
    }
    public function add_sj_scan()
    {
        $data = $this->FakturModel->add_sj_scan();
        echo json_encode($data);
    }

    public function add_surat_jalan()
    {
        $data = $this->FakturModel->add_surat_jalan();
        echo json_encode($data);
    }

    public function add_surat_jalan_semua()
    {
        $data = $this->FakturModel->add_surat_jalan_semua();
        echo json_encode($data);
    }

    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->FakturModel->hapus($id);
        echo json_encode($data);
    }

    public function detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->FakturModel->detail($id);
        echo json_encode($data);
    }
}
