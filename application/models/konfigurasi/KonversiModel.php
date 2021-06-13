<?php
class KonversiModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM KONVERSI WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY KONVERSI_INDEX DESC ')->result();
        foreach ($hasil as $row) {
            $row->DARI = $this->db->query('SELECT * FROM SATUAN WHERE SATUAN_ID="' . $row->KONVERSI_DARI . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1 ')->result();
            $row->KE = $this->db->query('SELECT * FROM SATUAN WHERE SATUAN_ID="' . $row->KONVERSI_KE . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1 ')->result();
        }
        return $hasil;
    }

    public function add()
    {
        if ($this->input->post('id') == "") {
            $data = array(
                'KONVERSI_ID' => create_id(),
                'KONVERSI_NAMA' => $this->input->post('nama'),
                'KONVERSI_DARI' => $this->input->post('dari'),
                'KONVERSI_KE' => $this->input->post('ke'),
                'KONVERSI_NILAI' => $this->input->post('nilai'),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('KONVERSI', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d G:i:s"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->where('KONVERSI_ID', $this->input->post('id'));
            $edit = $this->db->update('KONVERSI', $data_edit);

            $data = array(
                'KONVERSI_ID' => $this->input->post('id'),
                'KONVERSI_NAMA' => $this->input->post('nama'),
                'KONVERSI_DARI' => $this->input->post('dari'),
                'KONVERSI_KE' => $this->input->post('ke'),
                'KONVERSI_NILAI' => $this->input->post('nilai'),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('KONVERSI', $data);
            return $result;
        }
    }

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('KONVERSI_ID', $id);
        $result = $this->db->update('KONVERSI', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM KONVERSI WHERE KONVERSI_ID="' . $id . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }
}
