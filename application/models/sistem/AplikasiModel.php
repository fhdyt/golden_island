<?php
class AplikasiModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM APLIKASI WHERE RECORD_STATUS="AKTIF" ORDER BY APLIKASI_ID DESC ')->result();
        return $hasil;
    }

    public function add()
    {
        $data = array(
            'APLIKASI_ID' => create_id(),
            'APLIKASI_NAMA' => $this->input->post('nama'),
            'APLIKASI_LINK' => $this->input->post('link'),
            'APLIKASI_ICON' => $this->input->post('icon'),

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
        );

        $result = $this->db->insert('APLIKASI', $data);
        return $result;
    }

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
        );

        $this->db->where('APLIKASI_ID', $id);
        $result = $this->db->update('APLIKASI', $data);
        return $result;
    }
}
