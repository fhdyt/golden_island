<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends CI_Controller
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
        $this->load->model('distribusi/PembelianModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {

        $data['menu'] = $this->LoginModel->menu();
        $this->load->view('_template/header', $data);
        $this->load->view('distribusi/v_pembelian');
        $this->load->view('_template/footer');
    }
    public function form_pembelian()
    {
        $this->load->model('master/SupplierModel');

        $data['menu'] = $this->LoginModel->menu();
        $data['supplier'] = $this->SupplierModel->list();
        $this->load->view('_template/header', $data);
        $this->load->view('distribusi/v_form_pembelian');
        $this->load->view('_template/footer');
    }

    public function list()
    {
        $data = $this->PembelianModel->list();
        echo json_encode($data);
    }

    public function add()
    {
        $data = $this->PembelianModel->add();
    }
    public function add_barang()
    {
        $data = $this->PembelianModel->add_barang();
        echo json_encode($data);
    }

    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->PembelianModel->hapus($id);
        echo json_encode($data);
    }

    public function detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->PembelianModel->detail($id);
        echo json_encode($data);
    }
    public function detail_jenis_barang()
    {
        $jenis = $_GET['jenis'];
        $data = $this->PembelianModel->detail_jenis_barang($jenis);
        echo json_encode($data);
    }

    public function list_barang()
    {
        $id = $this->uri->segment('4');
        $data = $this->PembelianModel->list_barang($id);
        echo json_encode($data);
    }
}
