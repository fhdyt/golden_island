<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends CI_Controller
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
        $this->load->model('pembelian/PembelianModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {
        $this->load->view('_template/header');
        $this->load->view('pembelian/pembelian/v_pembelian');
        $this->load->view('_template/footer');
    }

    public function form_pembelian()
    {
        $this->load->model('master/SupplierModel');
        $this->load->model('pembelian/PoModel');

        $data['supplier'] = $this->SupplierModel->list();
        $data['po'] = $this->PoModel->list();

        $this->load->view('_template/header');
        $this->load->view('pembelian/pembelian/v_form_pembelian', $data);
        $this->load->view('_template/footer');
    }

    public function list()
    {
        $data = $this->PembelianModel->list();
        echo json_encode($data);
    }

    public function add()
    {
        $config['name']                    = random_string('sha1', 40);
        $config['upload_path']          = './uploads/pembelian';
        $config['allowed_types']        = '*';
        $config['file_name']            = $config['name'] . "." . pathinfo($_FILES["userfile"]["name"], PATHINFO_EXTENSION);
        $config['size_gambar'] = $_FILES["userfile"]["size"];

        $this->load->library('upload', $config);
        $this->upload->do_upload('userfile');
        $this->PembelianModel->add($config);
    }
    public function add_barang()
    {
        $data = $this->PembelianModel->add_barang();
        echo json_encode($data);
    }

    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->PembelianModel->hapus($id);
        echo json_encode($data);
    }

    public function pilih_po_barang()
    {
        $id = $this->uri->segment('4');
        $id_pembelian = $this->uri->segment('5');
        $data = $this->PembelianModel->pilih_po_barang($id, $id_pembelian);
        echo json_encode($data);
    }

    public function detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->PembelianModel->detail($id);
        echo json_encode($data);
    }
    public function detail_jenis_barang()
    {
        $jenis = $_GET['jenis'];
        $data = $this->PembelianModel->detail_jenis_barang($jenis);
        echo json_encode($data);
    }

    public function list_barang()
    {
        $id = $this->uri->segment('4');
        $data = $this->PembelianModel->list_barang($id);
        echo json_encode($data);
    }
}
