<?php
class TangkiModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM 
        MASTER_TANGKI AS T LEFT JOIN MASTER_BARANG AS B
        ON T.MASTER_BARANG_ID=B.MASTER_BARANG_ID
        WHERE T.RECORD_STATUS="AKTIF" AND T.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" AND B.RECORD_STATUS="AKTIF" AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        foreach ($hasil as $row) {
            $kapasitas = $this->db->query('SELECT RIWAYAT_TANGKI_KAPASITAS FROM RIWAYAT_TANGKI
        WHERE MASTER_TANGKI_ID="' . $row->MASTER_TANGKI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            $row->KAPASITAS = $kapasitas[0]->RIWAYAT_TANGKI_KAPASITAS;
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

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->insert('MASTER_TANGKI', $data);

            $data_riwayat = array(
                'RIWAYAT_TANGKI_ID' => create_id(),
                'MASTER_TANGKI_ID' => $tangki_id,
                'RIWAYAT_TANGKI_TANGGAL' => date("Y-m-d"),
                'RIWAYAT_TANGKI_KAPASITAS' => "0",
                'RIWAYAT_TANGKI_KETERANGAN' => "",


                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );
            $result = $this->db->insert('RIWAYAT_TANGKI', $data_riwayat);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
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

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
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
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
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
