<?php
class PerusahaanModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM PERUSAHAAN WHERE RECORD_STATUS="AKTIF"')->result();
        return $hasil;
    }

    public function add()
    {
        $data = array(
            'PERUSAHAAN_ID' => create_id(),
            'PERUSAHAAN_KODE' => $this->input->post('kode'),
            'PERUSAHAAN_NAMA' => $this->input->post('nama'),
            'PERUSAHAAN_ALAMAT' => $this->input->post('alamat'),
            'PERUSAHAAN_TELP' => $this->input->post('telp'),
            'PERUSAHAAN_LOGO' => "",

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
        );

        $result = $this->db->insert('PERUSAHAAN', $data);
        return $result;
    }

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
        );

        $this->db->where('PERUSAHAAN_ID', $id);
        $result = $this->db->update('PERUSAHAAN', $data);
        return $result;
    }
}
