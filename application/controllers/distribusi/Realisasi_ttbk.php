<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Realisasi_ttbk extends CI_Controller
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
        $this->load->model('distribusi/Realisasi_ttbkModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {
        $this->load->view('_template/header');
        $this->load->view('distribusi/realisasi_ttbk/v_realisasi_ttbk');
        $this->load->view('_template/footer');
    }

    public function form()
    {
        $this->load->view('_template/header');
        $this->load->view('distribusi/realisasi_ttbk/v_form');
        $this->load->view('_template/footer');
    }

    public function list()
    {
        $data = $this->Realisasi_ttbkModel->list();
        echo json_encode($data);
    }

    public function list_realisasi()
    {
        $surat_jalan_id = $_GET['surat_jalan_id'];
        $data = $this->Realisasi_ttbkModel->list_realisasi($surat_jalan_id);
        echo json_encode($data);
    }

    public function panggung_realisasi()
    {
        $surat_jalan_id = $_GET['surat_jalan_id'];
        $data = $this->Realisasi_ttbkModel->panggung_realisasi($surat_jalan_id);
        echo json_encode($data);
    }

    public function list_realisasi_tabung()
    {
        $surat_jalan_id = $_GET['surat_jalan_id'];
        $data = $this->Realisasi_ttbkModel->list_realisasi_tabung($surat_jalan_id);
        echo json_encode($data);
    }
    public function list_realisasi_tabung_mr()
    {
        $surat_jalan_id = $_GET['surat_jalan_id'];
        $data = $this->Realisasi_ttbkModel->list_realisasi_tabung_mr($surat_jalan_id);
        echo json_encode($data);
    }

    public function jenis_tabung()
    {
        $jenis = $_GET['jenis'];
        $data = $this->Realisasi_ttbkModel->jenis_tabung($jenis);
        echo json_encode($data);
    }

    public function add()
    {
        $data = $this->Realisasi_ttbkModel->add();
        echo json_encode($data);
    }

    public function add_barang()
    {
        $surat_jalan_id = $_GET['surat_jalan_id'];
        $data = $this->Realisasi_ttbkModel->add_barang($surat_jalan_id);
        echo json_encode($data);
    }

    public function add_scan()
    {
        $surat_jalan_id = $_GET['surat_jalan_id'];
        $data = $this->Realisasi_ttbkModel->add_scan($surat_jalan_id);
        echo json_encode($data);
    }

    public function klaim_barang()
    {
        $surat_jalan_id = $_GET['surat_jalan_id'];
        $data = $this->Realisasi_ttbkModel->klaim_barang($surat_jalan_id);
        echo json_encode($data);
    }
    public function add_barang_mr()
    {
        $surat_jalan_id = $_GET['surat_jalan_id'];
        $data = $this->Realisasi_ttbkModel->add_barang_mr($surat_jalan_id);
        echo json_encode($data);
    }

    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->Realisasi_ttbkModel->hapus($id);
        echo json_encode($data);
    }
    public function hapus_mr()
    {
        $id = $this->uri->segment('4');
        $data = $this->Realisasi_ttbkModel->hapus_mr($id);
        echo json_encode($data);
    }

    public function hapus_semua()
    {
        $surat_jalan_id = $_GET['surat_jalan_id'];
        $data = $this->Realisasi_ttbkModel->hapus_semua($surat_jalan_id);
        echo json_encode($data);
    }

    public function detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->Realisasi_ttbkModel->detail($id);
        echo json_encode($data);
    }
}
