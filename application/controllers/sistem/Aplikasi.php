<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aplikasi extends CI_Controller
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
        $this->load->model('sistem/AplikasiModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {
        $data['menu'] = $this->LoginModel->menu();
        $this->load->view('_template/header', $data);
        $this->load->view('sistem/v_aplikasi');
        $this->load->view('_template/footer');
    }

    public function list()
    {
        $data = $this->AplikasiModel->list();
        echo json_encode($data);
    }

    public function add()
    {
        $data = $this->AplikasiModel->add();
    }

    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->AplikasiModel->hapus($id);
        echo json_encode($data);
    }

    public function detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->AplikasiModel->detail($id);
        echo json_encode($data);
    }
}
