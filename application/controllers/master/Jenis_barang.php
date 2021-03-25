<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_barang extends CI_Controller
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
        $this->load->model('master/Jenis_barangModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {
        $data['menu'] = $this->LoginModel->menu();
        $this->load->view('_template/header', $data);
        $this->load->view('master/v_jenis_barang');
        $this->load->view('_template/footer');
    }

    public function detail_barang()
    {
        $data['menu'] = $this->LoginModel->menu();
        $data['detail'] = $this->Jenis_barangModel->detail($this->uri->segment('4'));
        $this->load->view('_template/header', $data);
        $this->load->view('master/v_detail_barang', $data);
        $this->load->view('_template/footer');
    }

    public function list()
    {
        $data = $this->Jenis_barangModel->list();
        echo json_encode($data);
    }

    public function list_detail()
    {
        $data = $this->Jenis_barangModel->list_detail($this->uri->segment('4'));
        echo json_encode($data);
    }

    public function add()
    {
        $data = $this->Jenis_barangModel->add();
    }

    public function add_detail()
    {
        $data = $this->Jenis_barangModel->add_detail($this->uri->segment('4'));
    }

    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->Jenis_barangModel->hapus($id);
        echo json_encode($data);
    }
    public function hapus_detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->Jenis_barangModel->hapus_detail($id);
        echo json_encode($data);
    }

    public function detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->Jenis_barangModel->detail($id);
        echo json_encode($data);
    }

    public function detail_detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->Jenis_barangModel->detail_detail($id);
        echo json_encode($data);
    }
}
