<?php
class MenuModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM MENU AS M 
        LEFT JOIN APLIKASI AS A ON M.APLIKASI_ID=A.APLIKASI_ID
        WHERE M.RECORD_STATUS="AKTIF" AND A.RECORD_STATUS="AKTIF" ORDER BY A.APLIKASI_LINK ASC ')->result();
        return $hasil;
    }

    public function add()
    {
        $data = array(
            'MENU_ID' => create_id(),
            'APLIKASI_ID' => $this->input->post('aplikasi'),
            'MENU_NAMA' => $this->input->post('nama'),
            'MENU_LINK' => $this->input->post('link'),
            'MENU_ICON' => $this->input->post('icon'),

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
        );

        $result = $this->db->insert('MENU', $data);
        return $result;
    }

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
        );

        $this->db->where('MENU_ID', $id);
        $result = $this->db->update('MENU', $data);
        return $result;
    }
}
