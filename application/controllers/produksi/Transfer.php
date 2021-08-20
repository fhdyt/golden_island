<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transfer extends CI_Controller
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
        $this->load->model('produksi/TransferModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {
        $this->load->view('_template/header');
        $this->load->view('produksi/transfer/v_transfer');
        $this->load->view('_template/footer');
    }
    public function form()
    {
        $this->load->view('_template/header');
        $this->load->view('produksi/transfer/v_form');
        $this->load->view('_template/footer');
    }

    public function jenis_barang()
    {
        $id = $this->uri->segment('4');
        $data = $this->TransferModel->jenis_barang($id);
        echo json_encode($data);
    }
    public function kapasitas_tangki()
    {
        $id = $this->uri->segment('4');
        $data = $this->TransferModel->kapasitas_tangki($id);
        echo json_encode($data);
    }
    public function list()
    {
        $data = $this->TransferModel->list();
        echo json_encode($data);
    }

    public function list_barang_dari()
    {
        $id = $this->uri->segment('4');
        $data = $this->TransferModel->list_barang_dari($id);
        echo json_encode($data);
    }
    public function list_barang_jadi()
    {
        $id = $this->uri->segment('4');
        $data = $this->TransferModel->list_barang_jadi($id);
        echo json_encode($data);
    }

    public function list_karyawan()
    {
        $id = $this->uri->segment('4');
        $data = $this->TransferModel->list_karyawan($id);
        echo json_encode($data);
    }

    public function add()
    {


        if ($this->input->post('userfile_name') == "" and $_FILES["userfile"]["name"] == "") {
            $config['file_name'] = $this->input->post('userfile_name');
        } else  if ($this->input->post('userfile_name') != "" and $_FILES["userfile"]["name"] == "") {
            $config['file_name'] = $this->input->post('userfile_name');
        } else {
            $config['name']                    = random_string('sha1', 40);
            $config['upload_path']          = './uploads/produksi';
            $config['allowed_types']        = '*';
            $config['file_name']            = $config['name'] . "." . pathinfo($_FILES["userfile"]["name"], PATHINFO_EXTENSION);

            $this->load->library('upload', $config);
            $this->upload->do_upload('userfile');
        }
        $data = $this->ProduksiModel->add($config);
        echo json_encode($data);
    }

    public function add_selesai()
    {
        $data = $this->TransferModel->add_selesai();
        echo json_encode($data);
    }

    public function add_barang_dari()
    {
        $data = $this->TransferModel->add_barang_dari();
        echo json_encode($data);
    }
    public function add_barang_jadi()
    {
        $data = $this->TransferModel->add_barang_jadi();
        echo json_encode($data);
    }

    public function add_karyawan()
    {
        $data = $this->TransferModel->add_karyawan();
        echo json_encode($data);
    }

    public function hapus_dari()
    {
        $id = $this->uri->segment('4');
        $data = $this->TransferModel->hapus_dari($id);
        echo json_encode($data);
    }
    public function hapus_jadi()
    {
        $id = $this->uri->segment('4');
        $data = $this->TransferModel->hapus_jadi($id);
        echo json_encode($data);
    }
    public function hapus_karyawan()
    {
        $id = $this->uri->segment('4');
        $data = $this->TransferModel->hapus_karyawan($id);
        echo json_encode($data);
    }

    public function detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->TransferModel->detail($id);
        echo json_encode($data);
    }
}
