<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Buku_besar extends CI_Controller
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
        $this->load->model('gig/Buku_besarModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {
        $this->load->view('_template/header');
        $this->load->view('gig/v_buku_besar');
        $this->load->view('_template/footer');
    }

    public function list()
    {
        $akun = $_GET['akun'];
        $data = $this->Buku_besarModel->list($akun);
        echo json_encode($data);
    }

    public function add()
    {
        $config['name']                    = random_string('sha1', 40);
        $config['upload_path']          = './uploads/buku_besar';
        $config['allowed_types']        = '*';
        $config['file_name']            = $config['name'] . "." . pathinfo($_FILES["userfile"]["name"], PATHINFO_EXTENSION);

        $this->load->library('upload', $config);
        $this->upload->do_upload('userfile');

        if ($_FILES["userfile"]["name"] == "") {
            $config['file_name'] = "";
        }

        $akun = $_GET['akun'];
        $data = $this->Buku_besarModel->add($akun, $config);
        return $data;
    }

    public function transfer()
    {
        $data = $this->Buku_besarModel->transfer();
        return $data;
    }

    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->Buku_besarModel->hapus($id);
        echo json_encode($data);
    }

    public function akun_list()
    {
        $id = $this->uri->segment('4');
        $data = $this->Buku_besarModel->akun_list($id);
        echo json_encode($data);
    }
}
