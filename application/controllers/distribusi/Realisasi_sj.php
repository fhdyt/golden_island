<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Realisasi_sj extends CI_Controller
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
        $this->load->model('distribusi/Realisasi_sjModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {
        $this->load->view('_template/header');
        $this->load->view('distribusi/realisasi_sj/v_realisasi_sj');
        $this->load->view('_template/footer');
    }

    public function form()
    {
        $this->load->view('_template/header');
        $this->load->view('distribusi/realisasi_sj/v_form');
        $this->load->view('_template/footer');
    }

    public function list()
    {
        $data = $this->Realisasi_sjModel->list();
        echo json_encode($data);
    }

    public function list_realisasi()
    {
        $surat_jalan_id = $_GET['surat_jalan_id'];
        $data = $this->Realisasi_sjModel->list_realisasi($surat_jalan_id);
        echo json_encode($data);
    }
    public function panggung_realisasi()
    {
        $surat_jalan_id = $_GET['surat_jalan_id'];
        $data = $this->Realisasi_sjModel->panggung_realisasi($surat_jalan_id);
        echo json_encode($data);
    }

    public function list_realisasi_tabung()
    {
        $surat_jalan_id = $_GET['surat_jalan_id'];
        $data = $this->Realisasi_sjModel->list_realisasi_tabung($surat_jalan_id);
        echo json_encode($data);
    }
    public function list_realisasi_tabung_mr()
    {
        $surat_jalan_id = $_GET['surat_jalan_id'];
        $data = $this->Realisasi_sjModel->list_realisasi_tabung_mr($surat_jalan_id);
        echo json_encode($data);
    }

    public function jenis_tabung()
    {
        $jenis = $_GET['jenis'];
        $data = $this->Realisasi_sjModel->jenis_tabung($jenis);
        echo json_encode($data);
    }

    public function add()
    {
        $data = $this->Realisasi_sjModel->add();
        echo json_encode($data);
    }
    public function add_barang()
    {
        $surat_jalan_id = $_GET['surat_jalan_id'];
        $data = $this->Realisasi_sjModel->add_barang($surat_jalan_id);
        echo json_encode($data);
    }
    public function add_barang_mr()
    {
        $surat_jalan_id = $_GET['surat_jalan_id'];
        $data = $this->Realisasi_sjModel->add_barang_mr($surat_jalan_id);
        echo json_encode($data);
    }

    public function add_scan()
    {
        $surat_jalan_id = $_GET['surat_jalan_id'];
        $data = $this->Realisasi_sjModel->add_scan($surat_jalan_id);
        echo json_encode($data);
    }

    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->Realisasi_sjModel->hapus($id);
        echo json_encode($data);
    }
    public function hapus_mr()
    {
        $id = $this->uri->segment('4');
        $data = $this->Realisasi_sjModel->hapus_mr($id);
        echo json_encode($data);
    }

    public function hapus_semua()
    {
        $surat_jalan_id = $_GET['surat_jalan_id'];
        $data = $this->Realisasi_sjModel->hapus_semua($surat_jalan_id);
        echo json_encode($data);
    }

    public function detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->Realisasi_sjModel->detail($id);
        echo json_encode($data);
    }
}
