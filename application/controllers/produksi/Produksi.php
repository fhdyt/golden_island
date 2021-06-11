<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produksi extends CI_Controller
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
        $this->load->model('produksi/ProduksiModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {
        $this->load->view('_template/header');
        $this->load->view('produksi/produksi/v_produksi');
        $this->load->view('_template/footer');
    }
    public function form()
    {
        $this->load->view('_template/header');
        $this->load->view('produksi/produksi/v_form');
        $this->load->view('_template/footer');
    }

    public function list()
    {
        $data = $this->ProduksiModel->list();
        echo json_encode($data);
    }

    public function list_barang()
    {
        $id = $this->uri->segment('4');
        $data = $this->ProduksiModel->list_barang($id);
        echo json_encode($data);
    }

    public function list_karyawan()
    {
        $id = $this->uri->segment('4');
        $data = $this->ProduksiModel->list_karyawan($id);
        echo json_encode($data);
    }

    public function add()
    {
        $data = $this->ProduksiModel->add();
    }

    public function add_barang()
    {
        $data = $this->ProduksiModel->add_barang();
        echo json_encode($data);
    }

    public function add_karyawan()
    {
        $data = $this->ProduksiModel->add_karyawan();
        echo json_encode($data);
    }

    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->ProduksiModel->hapus($id);
        echo json_encode($data);
    }
    public function hapus_karyawan()
    {
        $id = $this->uri->segment('4');
        $data = $this->ProduksiModel->hapus_karyawan($id);
        echo json_encode($data);
    }

    public function detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->ProduksiModel->detail($id);
        echo json_encode($data);
    }
}
