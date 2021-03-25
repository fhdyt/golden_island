<?php
class UserModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM USER WHERE RECORD_STATUS="AKTIF" ORDER BY USER_INDEX DESC ')->result();
        return $hasil;
    }

    public function add()
    {
        $data = array(
            'USER_ID' => create_id(),
            'USER_NAMA' => $this->input->post('nama'),
            'USER_USERNAME' => $this->input->post('username'),
            'USER_PASSWORD' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'PERUSAHAAN_KODE' => $this->input->post('perusahaan'),

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
        );

        $result = $this->db->insert('USER', $data);
        return $result;
    }

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
        );

        $this->db->where('USER_ID', $id);
        $result = $this->db->update('USER', $data);
        return $result;
    }

    public function menu_list()
    {
        $hasil = $this->db->query('SELECT * FROM MENU AS M 
        LEFT JOIN APLIKASI AS A ON M.APLIKASI_ID=A.APLIKASI_ID
        WHERE 
        M.RECORD_STATUS="AKTIF" 
        AND A.RECORD_STATUS="AKTIF" 
        ORDER BY A.APLIKASI_LINK ASC ')->result();
        foreach ($hasil as $row) {
            $status = $this->db->query('SELECT RECORD_STATUS as STATUS FROM USER_AKSES WHERE MENU_ID="' . $row->MENU_ID . '" AND USER_ID="' . $this->uri->segment('4') . '" AND RECORD_STATUS="AKTIF"');
            if ($status->num_rows() > 0) {
                $row->STATUS = "AKTIF";
            } else {
                $row->STATUS = "";
            }
            $result[] = $row;
        }
        return $result;
    }

    public function akses_menu($user, $menu_id)
    {
        $menu = $this->db->query('SELECT * FROM MENU WHERE RECORD_STATUS="AKTIF" AND MENU_ID="' . $menu_id . '"')->result();
        $hasil = $this->db->query('SELECT * FROM USER_AKSES WHERE RECORD_STATUS="AKTIF" AND MENU_ID="' . $menu_id . '" AND USER_ID="' . $user . '"');
        $data = $hasil->num_rows();
        if ($data == 0) {
            $data = array(
                'USER_AKSES_ID' => create_id(),
                'USER_ID' => $user,
                'MENU_ID' => $menu_id,
                'APLIKASI_ID' => $menu[0]->APLIKASI_ID,

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
            );

            $result = $this->db->insert('USER_AKSES', $data);
            return $result;
        } else {
            $data_menu = $hasil->result();
            $data = array(
                'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
                'DELETE_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "DELETE",
            );

            $this->db->where('USER_AKSES_ID', $data_menu[0]->USER_AKSES_ID);
            $result = $this->db->update('USER_AKSES', $data);
            return $result;
        }
    }
}
