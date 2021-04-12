<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Po extends CI_Controller
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
        $this->load->model('pembelian/PoModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {

        $data['menu'] = $this->LoginModel->menu();
        $this->load->view('_template/header', $data);
        $this->load->view('pembelian/po/v_po');
        $this->load->view('_template/footer');
    }
    public function form_po()
    {
        $this->load->model('master/SupplierModel');

        $data['menu'] = $this->LoginModel->menu();
        $data['supplier'] = $this->SupplierModel->list();
        $this->load->view('_template/header', $data);
        $this->load->view('pembelian/po/v_form_po');
        $this->load->view('_template/footer');
    }

    public function list()
    {
        $data = $this->PoModel->list();
        echo json_encode($data);
    }

    public function add()
    {
        $config['name']                    = random_string('sha1', 40);
        $config['upload_path']          = './uploads/po';
        $config['allowed_types']        = '*';
        $config['file_name']            = $config['name'] . "." . pathinfo($_FILES["userfile"]["name"], PATHINFO_EXTENSION);
        $config['size_gambar'] = $_FILES["userfile"]["size"];

        $this->load->library('upload', $config);
        $this->upload->do_upload('userfile');
        $this->PoModel->add($config);
    }

    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->PoModel->hapus($id);
        echo json_encode($data);
    }

    public function detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->PoModel->detail($id);
        echo json_encode($data);
    }
}
