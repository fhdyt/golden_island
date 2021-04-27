<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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
        $this->load->model('sistem/UserModel');
        $this->load->model('LoginModel');
        $this->LoginModel->cek_login();
    }

    public function index()
    {
        $this->load->model('sistem/PerusahaanModel');

        $data['menu'] = $this->LoginModel->menu();
        $data['perusahaan'] = $this->PerusahaanModel->list();
        $this->load->view('_template/header', $data);
        $this->load->view('sistem/v_user');
        $this->load->view('_template/footer');
    }

    public function list()
    {
        $data = $this->UserModel->list();
        echo json_encode($data);
    }

    public function add()
    {
        $data = $this->UserModel->add();
    }

    public function hapus()
    {
        $id = $this->uri->segment('4');
        $data = $this->UserModel->hapus($id);
        echo json_encode($data);
    }

    public function ganti_bahasa()
    {
        $id = $this->uri->segment('4');
        $lang = $_GET['lang'];
        $data = $this->UserModel->ganti_bahasa($id, $lang);
        echo json_encode($data);
    }

    public function akses()
    {
        $this->load->model('sistem/AplikasiModel');

        $data['menu'] = $this->LoginModel->menu();
        $data['aplikasi'] = $this->AplikasiModel->list();
        $this->load->view('_template/header', $data);
        $this->load->view('sistem/v_akses_user');
        $this->load->view('_template/footer');
    }

    public function menu_list()
    {
        $data = $this->UserModel->menu_list();
        echo json_encode($data);
    }

    public function akses_menu()
    {
        $user = $this->uri->segment('4');
        $menu_id = $this->uri->segment('5');
        $data = $this->UserModel->akses_menu($user, $menu_id);
        echo json_encode($data);
    }

    public function detail()
    {
        $id = $this->uri->segment('4');
        $data = $this->UserModel->detail($id);
        echo json_encode($data);
    }
}
