<?php
class KendaraanModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_KENDARAAN WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY MASTER_KENDARAAN_INDEX DESC ')->result();
        return $hasil;
    }

    public function add()
    {
        if ($this->input->post('id') == "") {
            $data = array(
                'MASTER_KENDARAAN_ID' => create_id(),
                'MASTER_KENDARAAN_NOMOR' => $this->input->post('nomor'),
                'MASTER_KENDARAAN_SURAT' => $this->input->post('surat'),
                'MASTER_KENDARAAN_PRODUSEN' => $this->input->post('produsen'),
                'MASTER_KENDARAAN_JENIS' => $this->input->post('jenis'),
                'MASTER_KENDARAAN_TAHUN' => $this->input->post('tahun'),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('MASTER_KENDARAAN', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d G:i:s"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->where('MASTER_KENDARAAN_ID', $this->input->post('id'));
            $edit = $this->db->update('MASTER_KENDARAAN', $data_edit);

            $data = array(
                'MASTER_KENDARAAN_ID' => $this->input->post('id'),
                'MASTER_KENDARAAN_NOMOR' => $this->input->post('nomor'),
                'MASTER_KENDARAAN_SURAT' => $this->input->post('surat'),
                'MASTER_KENDARAAN_PRODUSEN' => $this->input->post('produsen'),
                'MASTER_KENDARAAN_JENIS' => $this->input->post('jenis'),
                'MASTER_KENDARAAN_TAHUN' => $this->input->post('tahun'),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('MASTER_KENDARAAN', $data);
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

        $this->db->where('MASTER_KENDARAAN_ID', $id);
        $result = $this->db->update('MASTER_KENDARAAN', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_KENDARAAN WHERE MASTER_KENDARAAN_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        return $hasil;
    }
}
