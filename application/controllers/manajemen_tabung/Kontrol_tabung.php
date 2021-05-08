<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kontrol_tabung extends CI_Controller
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
        $this->load->model('manajemen_tabung/Kontrol_tabungModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {
        $this->load->view('_template/header');
        $this->load->view('manajemen_tabung/kontrol_tabung/v_relasi');
        $this->load->view('_template/footer');
    }

    public function detail()
    {
        $data['relasi'] = $this->Kontrol_tabungModel->relasi_detail($this->uri->segment('4'));
        $this->load->view('_template/header');
        $this->load->view('manajemen_tabung/kontrol_tabung/v_kontrol_tabung_detail', $data);
        $this->load->view('_template/footer');
    }
    public function form()
    {
        $this->load->view('_template/header');
        $this->load->view('manajemen_tabung/kontrol_tabung/v_form');
        $this->load->view('_template/footer');
    }

    public function kontrol_tabung_list()
    {
        $id = $this->uri->segment('4');
        $tabung = $_GET['tabung'];
        $status = $_GET['status'];
        $data = $this->Kontrol_tabungModel->kontrol_tabung_list($id, $tabung, $status);
        echo json_encode($data);
    }

    public function add_jurnal()
    {
        $data = $this->Kontrol_tabungModel->add_jurnal();
        echo json_encode($data);
    }
    public function list_jurnal()
    {
        $id = $this->uri->segment('4');
        $data = $this->Kontrol_tabungModel->list_jurnal($id);
        echo json_encode($data);
    }

    public function hapus_kontrol_tabung()
    {
        $id = $this->uri->segment('4');
        $data = $this->Kontrol_tabungModel->hapus_kontrol_tabung($id);
        echo json_encode($data);
    }

    public function relasi_list()
    {
        $data = $this->Kontrol_tabungModel->relasi_list();
        echo json_encode($data);
    }

    public function add()
    {
        $data = $this->Kontrol_tabungModel->add();
    }

    public function hapus_jurnal()
    {
        $id = $this->uri->segment('4');
        $data = $this->Kontrol_tabungModel->hapus_jurnal($id);
        echo json_encode($data);
    }

    public function harga_list()
    {
        $id = $this->uri->segment('4');
        $data = $this->Kontrol_tabungModel->harga_list($id);
        echo json_encode($data);
    }
}
