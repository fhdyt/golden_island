<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Panggung extends CI_Controller
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
        $this->load->model('laporan/PanggungModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {
        $this->load->view('_template/header');
        $this->load->view('laporan/v_panggung');
        $this->load->view('_template/footer');
    }

    public function list()
    {
        $data = $this->PanggungModel->list();
        echo json_encode($data);
    }
    public function ex_list()
    {
        $data = $this->PanggungModel->ex_list();
        echo json_encode($data);
    }
    public function verifikasi_list()
    {
        $data = $this->PanggungModel->verifikasi_list();
        echo json_encode($data);
    }
    public function saldo_awal_list()
    {
        $data = $this->PanggungModel->saldo_awal_list();
        echo json_encode($data);
    }

    public function add()
    {
        $data = $this->PanggungModel->add();
    }
    public function verifikasi()
    {
        $data = $this->PanggungModel->verifikasi();
        echo json_encode($data);
    }
    public function balance()
    {
        $data = $this->PanggungModel->balance();
        echo json_encode($data);
    }

    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->PanggungModel->hapus($id);
        echo json_encode($data);
    }

    public function detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->PanggungModel->detail($id);
        echo json_encode($data);
    }
}
