<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pajak extends CI_Controller
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
        $this->load->model('akuntansi/PajakModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {
        $this->load->view('_template/header');
        $this->load->view('akuntansi/v_pajak');
        $this->load->view('_template/footer');
    }

    public function list()
    {
        $data = $this->PajakModel->list();
        echo json_encode($data);
    }

    public function add()
    {
        $data = $this->PajakModel->add();
    }

    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->PajakModel->hapus($id);
        echo json_encode($data);
    }

    public function jenis_pajak()
    {
        $jenis = $_GET['jenis'];
        $data = $this->PajakModel->jenis_pajak($jenis);
        echo json_encode($data);
    }
}
