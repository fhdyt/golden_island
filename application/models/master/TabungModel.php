<?php
class TabungModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM 
        MASTER_TABUNG AS T LEFT JOIN MASTER_BARANG AS B
        ON T.MASTER_BARANG_ID=B.MASTER_BARANG_ID
        WHERE T.RECORD_STATUS="AKTIF" AND T.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" AND B.RECORD_STATUS="AKTIF" AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY T.MASTER_TABUNG_KODE DESC')->result();

        return $hasil;
    }
    public function pembelian_jenis_gas()
    {
        $hasil = $this->db->query('SELECT * FROM PEMBELIAN WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" AND PEMBELIAN_JENIS="tabung" ')->result();
        return $hasil;
    }

    public function add()
    {
        $tabung_id = create_id();
        if ($this->input->post('id') == "") {
            $data_riwayat = array(
                'RIWAYAT_TABUNG_ID' => create_id(),
                'MASTER_TABUNG_ID' => $tabung_id,
                'RIWAYAT_TABUNG_TANGGAL' => date("Y-m-d"),
                'RIWAYAT_TABUNG_STATUS' => "baru",
                'RIWAYAT_TABUNG_KETERANGAN' => "",


                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );
            $this->db->insert('RIWAYAT_TABUNG', $data_riwayat);

            if ($this->input->post('isi') == "on") {
                $data_riwayat = array(
                    'RIWAYAT_TABUNG_ID' => create_id(),
                    'MASTER_TABUNG_ID' => $tabung_id,
                    'RIWAYAT_TABUNG_TANGGAL' => date("Y-m-d"),
                    'RIWAYAT_TABUNG_STATUS' => "isi",
                    'RIWAYAT_TABUNG_KETERANGAN' => "",


                    'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                    'ENTRI_USER' => $this->session->userdata('USER_ID'),
                    'RECORD_STATUS' => "AKTIF",
                    'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
                );
                $this->db->insert('RIWAYAT_TABUNG', $data_riwayat);
            }

            $data = array(
                'MASTER_TABUNG_ID' => $tabung_id,
                'MASTER_TABUNG_KODE' => kode_tabung(),
                'MASTER_BARANG_ID' => $this->input->post('tabung'),
                'PEMBELIAN_NOMOR_SURAT' => $this->input->post('surat'),

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('MASTER_TABUNG', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->where('MASTER_TABUNG_ID', $this->input->post('id'));
            $edit = $this->db->update('MASTER_TABUNG', $data_edit);

            $data = array(
                'MASTER_TABUNG_ID' => $this->input->post('id'),
                'MASTER_TABUNG_KODE' => $this->input->post('kode'),
                'MASTER_BARANG_ID' => $this->input->post('tabung'),
                'PEMBELIAN_NOMOR_SURAT' => $this->input->post('surat'),

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('MASTER_TABUNG', $data);
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

        $this->db->where('MASTER_TABUNG_ID', $id);
        $result = $this->db->update('MASTER_TABUNG', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_TABUNG WHERE MASTER_TABUNG_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        return $hasil;
    }
}
