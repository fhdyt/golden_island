<?php
class DashboardModel extends CI_Model
{

    public function list_catatan()
    {
        $hasil = $this->db->query('SELECT * FROM CATATAN WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY ENTRI_WAKTU DESC ')->result();

        foreach ($hasil as $row) {
            $row->USER = $this->db->query('SELECT * FROM USER WHERE USER_ID="' . $row->ENTRI_USER . '" AND RECORD_STATUS="AKTIF"')->result();
            $row->TANGGAL = tanggal($row->ENTRI_WAKTU);
            $row->CATATAN = nl2br($row->CATATAN);
        }
        return $hasil;
    }

    public function add()
    {

        $data = array(
            'CATATAN_ID' => create_id(),
            'CATATAN' => $this->input->post('catatan'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('CATATAN', $data);
        return $result;
    }

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('CATATAN_ID', $id);
        $result = $this->db->update('CATATAN', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM KONVERSI WHERE KONVERSI_ID="' . $id . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }
}
