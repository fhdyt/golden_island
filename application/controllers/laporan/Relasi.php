<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Relasi extends CI_Controller
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
        $this->load->model('laporan/RelasiModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {
        $this->load->view('_template/header');
        $this->load->view('laporan/v_relasi');
        $this->load->view('_template/footer');
    }

    public function harga_relasi()
    {
        $data['relasi'] = $this->RelasiModel->detail($this->uri->segment('4'));
        $this->load->view('_template/header');
        $this->load->view('laporan/v_harga_relasi', $data);
        $this->load->view('_template/footer');
    }

    public function kontrol_tabung()
    {
        $data['relasi'] = $this->RelasiModel->detail($this->uri->segment('4'));
        $this->load->view('_template/header');
        $this->load->view('laporan/v_kontrol_tabung', $data);
        $this->load->view('_template/footer');
    }

    public function kontrol_tabung_list()
    {
        $id = $this->uri->segment('4');
        $tabung = $_GET['tabung'];
        $status = $_GET['status'];
        $data = $this->RelasiModel->kontrol_tabung_list($id, $tabung, $status);
        echo json_encode($data);
    }

    public function add_kontrol_tabung()
    {
        $config['name']                    = random_string('sha1', 40);
        $config['upload_path']          = './uploads/kontrol_tabung';
        $config['allowed_types']        = '*';
        $config['file_name']            = $config['name'] . "." . pathinfo($_FILES["userfile"]["name"], PATHINFO_EXTENSION);

        $this->load->library('upload', $config);
        $this->upload->do_upload('userfile');

        if ($_FILES["userfile"]["name"] == "") {
            $config['file_name'] = "empty";
        }

        $id = $this->uri->segment('4');
        $data = $this->RelasiModel->add_kontrol_tabung($id, $config);
        echo json_encode($data);
    }
    public function hapus_kontrol_tabung()
    {
        $id = $this->uri->segment('4');
        $data = $this->RelasiModel->hapus_kontrol_tabung($id);
        echo json_encode($data);
    }

    public function list()
    {

        $data = $this->RelasiModel->list();
        echo json_encode($data);
    }

    public function add()
    {
        $data = $this->RelasiModel->add();
    }

    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->RelasiModel->hapus($id);
        echo json_encode($data);
    }

    public function detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->RelasiModel->detail($id);
        echo json_encode($data);
    }

    public function add_harga()
    {
        $user = $this->uri->segment('4');
        $data = $this->RelasiModel->add_harga($user);
        echo json_encode($data);
    }

    public function harga_list()
    {
        $id = $this->uri->segment('4');
        $data = $this->RelasiModel->harga_list($id);
        echo json_encode($data);
    }
}
