<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
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
        $this->load->model('master/BarangModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {
        $this->load->view('_template/header');
        $this->load->view('master/v_barang');
        $this->load->view('_template/footer');
    }

    public function list()
    {
        $data = $this->BarangModel->list();
        echo json_encode($data);
    }

    public function list_detail()
    {
        $data = $this->BarangModel->list_detail($this->uri->segment('4'));
        echo json_encode($data);
    }

    public function add()
    {
        $data = $this->BarangModel->add();
    }

    public function add_detail()
    {
        $data = $this->BarangModel->add_detail($this->uri->segment('4'));
    }

    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->BarangModel->hapus($id);
        echo json_encode($data);
    }
    // public function hapus_detail()
    // {
    //     $id = $this->uri->segment('4');
    //     $data = $this->Jenis_barangModel->hapus_detail($id);
    //     echo json_encode($data);
    // }

    public function detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->BarangModel->detail($id);
        echo json_encode($data);
    }

    // public function detail_detail()
    // {
    //     $id = $this->uri->segment('4');
    //     $data = $this->Jenis_barangModel->detail_detail($id);
    //     echo json_encode($data);
    // }
}
