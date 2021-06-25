<?php
class TangkiModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM 
        MASTER_TANGKI AS T LEFT JOIN MASTER_BARANG AS B
        ON T.MASTER_BARANG_ID=B.MASTER_BARANG_ID
        WHERE T.RECORD_STATUS="AKTIF" AND T.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" AND B.RECORD_STATUS="AKTIF" AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY T.MASTER_TANGKI_KODE DESC')->result();
        foreach ($hasil as $row) {
            $kapasitas = $this->db->query('SELECT SUM(RIWAYAT_TANGKI_KAPASITAS_MASUK) AS MASUK,SUM(RIWAYAT_TANGKI_KAPASITAS_KELUAR) AS KELUAR FROM RIWAYAT_TANGKI
            WHERE MASTER_TANGKI_ID="' . $row->MASTER_TANGKI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"');
            if ($kapasitas->num_rows() == 0) {
                $row->KAPASITAS = array();
            } else {
                $hasil_kapasitas =  $kapasitas->result();
                $row->KAPASITAS_MASUK = $hasil_kapasitas[0]->MASUK;
                $row->KAPASITAS_KELUAR = $hasil_kapasitas[0]->KELUAR;
                $row->TOTAL = $row->KAPASITAS_MASUK - $row->KAPASITAS_KELUAR;
            }
        }
        return $hasil;
    }
    public function add()
    {
        if ($this->input->post('id') == "") {
            $tangki_id = create_id();
            $data = array(
                'MASTER_TANGKI_ID' => $tangki_id,
                'MASTER_TANGKI_KODE' => $this->input->post('kode'),
                'MASTER_BARANG_ID' => $this->input->post('tangki'),
                'MASTER_TANGKI_LOKASI' => $this->input->post('lokasi'),
                'MASTER_TANGKI_SATUAN' => $this->input->post('satuan'),
                'MASTER_TANGKI_KAPASITAS' => $this->input->post('kapasitas'),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('MASTER_TANGKI', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d G:i:s"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->where('MASTER_TANGKI_ID', $this->input->post('id'));
            $edit = $this->db->update('MASTER_TANGKI', $data_edit);

            $data = array(
                'MASTER_TANGKI_ID' => $this->input->post('id'),
                'MASTER_TANGKI_KODE' => $this->input->post('kode'),
                'MASTER_BARANG_ID' => $this->input->post('tangki'),
                'MASTER_TANGKI_LOKASI' => $this->input->post('lokasi'),
                'MASTER_TANGKI_SATUAN' => $this->input->post('satuan'),
                'MASTER_TANGKI_KAPASITAS' => $this->input->post('kapasitas'),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('MASTER_TANGKI', $data);
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

        $this->db->where('MASTER_TANGKI_ID', $id);
        $result = $this->db->update('MASTER_TANGKI', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_TANGKI WHERE MASTER_TANGKI_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        return $hasil;
    }
}
