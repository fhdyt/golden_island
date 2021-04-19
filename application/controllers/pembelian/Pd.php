<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pd extends CI_Controller
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
        $this->load->model('pembelian/PdModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {
        $this->load->view('_template/header');
        $this->load->view('pembelian/pd/v_pd');
        $this->load->view('_template/footer');
    }

    public function form_pd()
    {
        $this->load->model('master/SupplierModel');
        $data['supplier'] = $this->SupplierModel->list();

        $this->load->view('_template/header');
        $this->load->view('pembelian/pd/v_form_pd', $data);
        $this->load->view('_template/footer');
    }

    public function list()
    {
        $data = $this->PdModel->list();
        echo json_encode($data);
    }

    public function add()
    {
        $data = $this->PdModel->add();
        echo json_encode($data);
    }

    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->PdModel->hapus($id);
        echo json_encode($data);
    }

    public function detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->PdModel->detail($id);
        echo json_encode($data);
    }

    public function add_barang()
    {
        $data = $this->PdModel->add_barang();
        echo json_encode($data);
    }

    public function list_barang()
    {
        $id = $this->uri->segment('4');
        $id_pembelian = $this->uri->segment('5');
        $data = $this->PdModel->list_barang($id, $id_pembelian);
        echo json_encode($data);
    }
    public function detail_jenis_barang()
    {
        $jenis = $_GET['jenis'];
        $data = $this->PdModel->detail_jenis_barang($jenis);
        echo json_encode($data);
    }

    public function po_to_pd()
    {
        $id = $this->uri->segment('4');
        $id_pembelian = $this->uri->segment('5');
        $data = $this->PdModel->po_to_pd($id, $id_pembelian);
        echo json_encode($data);
    }
}
