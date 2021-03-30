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
        $data['menu'] = $this->LoginModel->menu();
        $this->load->view('_template/header', $data);
        $this->load->view('distribusi/v_surat_jalan');
        $this->load->view('_template/footer');
    }

    public function form_sj()
    {
        $this->load->model('master/RelasiModel');
        $this->load->model('master/DriverModel');
        $this->load->model('master/KendaraanModel');
        $this->load->model('master/Jenis_barangModel');

        $data['relasi'] = $this->RelasiModel->list();
        $data['driver'] = $this->DriverModel->list();
        $data['kendaraan'] = $this->KendaraanModel->list();
        $data['jenis_barang'] = $this->Jenis_barangModel->detail_jenis_barang();

        $data['menu'] = $this->LoginModel->menu();
        $this->load->view('_template/header', $data);
        $this->load->view('distribusi/v_form_sj');
        $this->load->view('_template/footer');
    }

    public function form_cash()
    {
        $this->load->model('master/RelasiModel');
        $this->load->model('master/DriverModel');
        $this->load->model('master/KendaraanModel');
        $this->load->model('master/Jenis_barangModel');

        $data['relasi'] = $this->RelasiModel->list();
        $data['driver'] = $this->DriverModel->list();
        $data['kendaraan'] = $this->KendaraanModel->list();
        $data['jenis_barang'] = $this->Jenis_barangModel->detail_jenis_barang();

        $data['menu'] = $this->LoginModel->menu();
        $this->load->view('_template/header', $data);
        $this->load->view('distribusi/v_form_cash');
        $this->load->view('_template/footer');
    }

    public function list()
    {
        $data = $this->Surat_jalanModel->list();
        echo json_encode($data);
    }

    public function barang_list()
    {
        $id = $this->uri->segment('4');
        $data = $this->Surat_jalanModel->barang_list($id);
        echo json_encode($data);
    }

    public function ttbk_list()
    {
        $id = $this->uri->segment('4');
        $data = $this->Surat_jalanModel->ttbk_list($id);
        echo json_encode($data);
    }
    public function detail_tabung_list()
    {
        $data = $this->Surat_jalanModel->detail_tabung_list();
        echo json_encode($data);
    }

    public function detail_jenis_barang()
    {
        $id = $this->uri->segment('4');
        $data = $this->Surat_jalanModel->detail_jenis_barang($id);
        echo json_encode($data);
    }
    public function perharga()
    {
        $id = $this->uri->segment('4');
        $relasi = $this->uri->segment('5');
        $data = $this->Surat_jalanModel->perharga($id, $relasi);
        echo json_encode($data);
    }

    public function add()
    {
        $data = $this->Surat_jalanModel->add();
    }

    public function add_barang()
    {
        $data = $this->Surat_jalanModel->add_barang();
        echo json_encode($data);
    }
    public function add_detail_tabung()
    {
        $data = $this->Surat_jalanModel->add_detail_tabung();
        echo json_encode($data);
    }

    public function add_ttbk()
    {
        $data = $this->Surat_jalanModel->add_ttbk();
        echo json_encode($data);
    }

    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->Surat_jalanModel->hapus($id);
        echo json_encode($data);
    }
    public function hapus_barang()
    {
        $id = $this->uri->segment('4');
        $data = $this->Surat_jalanModel->hapus_barang($id);
        echo json_encode($data);
    }
    public function hapus_ttbk()
    {
        $id = $this->uri->segment('4');
        $data = $this->Surat_jalanModel->hapus_ttbk($id);
        echo json_encode($data);
    }
    public function hapus_detail_tabung()
    {
        $id = $this->uri->segment('4');
        $data = $this->Surat_jalanModel->hapus_detail_tabung($id);
        echo json_encode($data);
    }

    public function detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->Surat_jalanModel->detail($id);
        echo json_encode($data);
    }
}
