<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat_jalan extends CI_Controller
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
        $this->load->model('distribusi/Surat_jalanModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {
        $this->load->view('_template/header');
        $this->load->view('distribusi/surat_jalan/v_surat_jalan');
        $this->load->view('_template/footer');
    }
    public function form()
    {
        $this->load->view('_template/header');
        $this->load->view('distribusi/surat_jalan/v_form');
        $this->load->view('_template/footer');
    }

    public function detail_jenis_barang()
    {
        $jenis = $_GET['jenis'];
        $data = $this->Surat_jalanModel->detail_jenis_barang($jenis);
        echo json_encode($data);
    }

    public function list()
    {
        $jenis_sj = $_GET['jenis_sj'];
        $data = $this->Surat_jalanModel->list($jenis_sj);
        echo json_encode($data);
    }

    public function add()
    {
        $data = $this->Surat_jalanModel->add();
        echo json_encode($data);
    }
    public function batal()
    {
        $data = $this->Surat_jalanModel->batal();
        echo json_encode($data);
    }

    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->Surat_jalanModel->hapus($id);
        echo json_encode($data);
    }

    public function detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->Surat_jalanModel->detail($id);
        echo json_encode($data);
    }

    public function add_barang()
    {
        $data = $this->Surat_jalanModel->add_barang();
        echo json_encode($data);
    }
    public function add_relasi()
    {
        $data = $this->Surat_jalanModel->add_relasi();
        echo json_encode($data);
    }

    public function list_barang()
    {
        $id = $this->uri->segment('4');
        $data = $this->Surat_jalanModel->list_barang($id);
        echo json_encode($data);
    }
}
