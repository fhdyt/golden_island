<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Realisasi_sj extends CI_Controller
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
        $this->load->model('distribusi/Realisasi_sjModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {
        $this->load->view('_template/header');
        $this->load->view('distribusi/realisasi_sj/v_realisasi_sj');
        $this->load->view('_template/footer');
    }

    public function form()
    {
        $this->load->view('_template/header');
        $this->load->view('distribusi/realisasi_sj/v_form');
        $this->load->view('_template/footer');
    }

    public function list()
    {
        $data = $this->Realisasi_sjModel->list();
        echo json_encode($data);
    }

    public function list_realisasi()
    {
        $driver_id = $_GET['driver'];
        $data = $this->Realisasi_sjModel->list_realisasi($driver_id);
        echo json_encode($data);
    }

    public function list_realisasi_tabung()
    {
        $id_realisasi = $_GET['realisasi_id'];
        $data = $this->Realisasi_sjModel->list_realisasi_tabung($id_realisasi);
        echo json_encode($data);
    }

    public function detail_driver()
    {
        $driver_id = $_GET['driver'];
        $data = $this->Realisasi_sjModel->detail_driver($driver_id);
        echo json_encode($data);
    }

    public function add()
    {
        $data = $this->Realisasi_sjModel->add();
        echo json_encode($data);
    }
    public function add_barang()
    {
        $realisasi_id = $_GET['realisasi_id'];
        $data = $this->Realisasi_sjModel->add_barang($realisasi_id);
        echo json_encode($data);
    }

    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->Realisasi_sjModel->hapus($id);
        echo json_encode($data);
    }

    public function detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->Realisasi_sjModel->detail($id);
        echo json_encode($data);
    }
}
