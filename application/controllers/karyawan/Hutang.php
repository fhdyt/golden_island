<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hutang extends CI_Controller
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
        $this->load->model('karyawan/HutangModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {
        $this->load->view('_template/header');
        $this->load->view('karyawan/v_hutang');
        $this->load->view('_template/footer');
    }

    public function hutang()
    {
        $this->load->view('_template/header');
        $this->load->view('karyawan/hutang/v_hutang_riwayat');
        $this->load->view('_template/footer');
    }

    public function pembayaran()
    {
        $this->load->view('_template/header');
        $this->load->view('karyawan/hutang/v_pembayaran');
        $this->load->view('_template/footer');
    }

    public function supplier_list()
    {
        $data = $this->HutangModel->supplier_list();
        echo json_encode($data);
    }

    public function list()
    {
        $data = $this->HutangModel->list();
        echo json_encode($data);
    }
    public function list_pembayaran()
    {
        $supplier = $_GET['id'];
        $data = $this->HutangModel->list_pembayaran($supplier);
        echo json_encode($data);
    }

    public function add()
    {
        $data = $this->HutangModel->add();
    }
    public function add_saldo()
    {
        $data = $this->HutangModel->add_saldo();
    }
    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->HutangModel->hapus($id);
        echo json_encode($data);
    }

    public function detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->HutangModel->detail($id);
        echo json_encode($data);
    }
    public function pi_list()
    {
        $id = $this->uri->segment('4');
        $data = $this->HutangModel->pi_list($id);
        echo json_encode($data);
    }
}
