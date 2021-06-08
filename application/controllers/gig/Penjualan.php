<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
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
        $this->load->model('gig/PenjualanModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {
        $this->load->view('_template/header');
        $this->load->view('gig/v_penjualan');
        $this->load->view('_template/footer');
    }

    public function list()
    {
        $data = $this->PenjualanModel->list();
        echo json_encode($data);
    }
    public function barang_list()
    {
        $data = $this->PenjualanModel->barang_list();
        echo json_encode($data);
    }

    public function add()
    {
        $data = $this->PenjualanModel->add();
    }

    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->PenjualanModel->hapus($id);
        echo json_encode($data);
    }

    public function detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->PenjualanModel->detail($id);
        echo json_encode($data);
    }
}
