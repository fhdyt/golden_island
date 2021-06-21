<?php
class LoginModel extends CI_Model
{

  function login_user($username, $password)
  {
    $query = $this->db->get_where('USER', array('USER_USERNAME' => $username, 'RECORD_STATUS' => 'AKTIF'));
    if ($query->num_rows() > 0) {
      $data_user = $query->row();
      if (password_verify($password, $data_user->USER_PASSWORD)) {
        $this->session->set_userdata('USER_NAMA', $data_user->USER_NAMA);
        $this->session->set_userdata('USER_USERNAME', $data_user->USER_USERNAME);
        $this->session->set_userdata('USER_ID', $data_user->USER_ID);
        $this->session->set_userdata('PERUSAHAAN_KODE', $data_user->PERUSAHAAN_KODE);
        $this->session->set_userdata('USER_BAHASA', $data_user->USER_BAHASA);
        $this->session->set_userdata('is_login_golden_island', TRUE);


        $this->load->library('user_agent');
        $data = array(
          'USER_ID' => $data_user->USER_ID,
          'LOGIN_LOG_IP' => $this->input->ip_address(),
          'LOGIN_LOG_BROWSER' => $this->agent->browser(),
          'LOGIN_LOG_PLATFORM' => $this->agent->platform(),

          'LOGIN_LOG_WAKTU' => date("Y-m-d G:i:s"),
        );

        $this->db->insert('LOGIN_LOG', $data);
        return TRUE;
      } else {
        $this->session->set_flashdata('error_login', 'Username dan Password salah.');
      }
    } else {
      $this->session->set_flashdata('error_login', 'Username belum terdaftar.');
      redirect('login');
    }
  }

  function cek_login()
  {
    if (empty($this->session->userdata('is_login_golden_island'))) {
      redirect('login');
    } else {
    }
  }

  function akses()
  {
    $aplikasi = $this->uri->segment('1');
    $menu = $this->uri->segment('2');
    $aplikasi_r = $this->db->query('SELECT APLIKASI_ID FROM APLIKASI WHERE APLIKASI_NAMA LIKE "%' . $aplikasi . '%" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
    $menu_r = $this->db->query('SELECT MENU_ID FROM MENU WHERE MENU_NAMA LIKE "%' . $menu . '%" AND APLIKASI_ID="' . $aplikasi_r[0]->APLIKASI_ID . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
    $akses = $this->db->query('SELECT * FROM USER_AKSES WHERE APLIKASI_ID="' . $aplikasi_r[0]->APLIKASI_ID . '" AND MENU_ID="' . $menu_r[0]->MENU_ID . '" AND USER_ID="' . $this->session->userdata('USER_ID') . '" AND RECORD_STATUS="AKTIF"');
    if ($akses->num_rows() == 0) {
      // redirect('dashboard/akses');
      $this->load->view('_template/header');
      $this->load->view('errors/akses');
      $this->load->view('_template/footer');
    }
  }

  public function menu()
  {
    $hasil = $this->db->query('SELECT APLIKASI.APLIKASI_ID, APLIKASI.APLIKASI_NAMA, APLIKASI.APLIKASI_ICON, APLIKASI.APLIKASI_LINK FROM 
    USER_AKSES AS AKSES 
    LEFT JOIN APLIKASI AS APLIKASI 
    ON AKSES.APLIKASI_ID=APLIKASI.APLIKASI_ID 
    WHERE AKSES.USER_ID="' . $this->session->userdata('USER_ID') . '"
    AND AKSES.RECORD_STATUS="AKTIF"
    AND APLIKASI.RECORD_STATUS="AKTIF" GROUP BY APLIKASI.APLIKASI_ID, APLIKASI.APLIKASI_NAMA, APLIKASI.APLIKASI_ICON, APLIKASI.APLIKASI_LINK ORDER BY APLIKASI.APLIKASI_NAMA')->result();

    foreach ($hasil as $row) {
      $menu = $this->db->query('SELECT * FROM USER_AKSES AS AKSES
      LEFT JOIN MENU AS MENU ON AKSES.MENU_ID=MENU.MENU_ID
      WHERE AKSES.USER_ID = "' . $this->session->userdata('USER_ID') . '"
      AND AKSES.APLIKASI_ID = "' . $row->APLIKASI_ID . '"
      AND AKSES.RECORD_STATUS="AKTIF"
    AND MENU.RECORD_STATUS="AKTIF" ORDER BY MENU.MENU_NAMA
       ')->result();
      $row->MENU = $menu;
      $result[] = $row;
    }

    return $hasil;
  }
}
