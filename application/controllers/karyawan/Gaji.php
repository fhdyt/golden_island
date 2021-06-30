<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gaji extends CI_Controller
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
        $this->load->model('karyawan/GajiModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {
        $this->load->view('_template/header');
        $this->load->view('karyawan/v_gaji');
        $this->load->view('_template/footer');
    }
    public function gaji()
    {
        $this->load->view('_template/header');
        $this->load->view('karyawan/v_karyawan_gaji');
        $this->load->view('_template/footer');
    }
    public function konfigurasi()
    {
        $this->load->view('_template/header');
        $this->load->view('karyawan/v_konfigurasi_gaji');
        $this->load->view('_template/footer');
    }

    public function list()
    {
        $data = $this->GajiModel->list();
        echo json_encode($data);
    }

    public function surat_jalan_list()
    {
        $data = $this->GajiModel->surat_jalan_list();
        echo json_encode($data);
    }
    public function produksi_list()
    {
        $data = $this->GajiModel->produksi_list();
        echo json_encode($data);
    }
    public function penjualan_list()
    {
        $data = $this->GajiModel->penjualan_list();
        echo json_encode($data);
    }

    public function add()
    {
        $data = $this->GajiModel->add();
    }
    public function add_konfigurasi()
    {
        $data = $this->GajiModel->add_konfigurasi();
    }
    public function detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->GajiModel->detail($id);
        echo json_encode($data);
    }


    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->GajiModel->hapus($id);
        echo json_encode($data);
    }

    public function detail_konfigurasi()
    {
        $id = $this->uri->segment('4');
        $data = $this->GajiModel->detail_konfigurasi($id);
        echo json_encode($data);
    }
}
