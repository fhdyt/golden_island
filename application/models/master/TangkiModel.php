<?php
class TangkiModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_TANGKI WHERE RECORD_STATUS="AKTIF" ORDER BY MASTER_TANGKI_INDEX DESC ')->result();
        return $hasil;
    }
    public function pembelian_jenis_gas()
    {
        $hasil = $this->db->query('SELECT * FROM PEMBELIAN WHERE RECORD_STATUS="AKTIF" AND PEMBELIAN_JENIS="tangki" ')->result();
        return $hasil;
    }

    public function add()
    {
        if ($this->input->post('id') == "") {
            // $data_riwayat = array(
            //     'RIWAYAT_TANGKI_ID' => create_id(),
            //     'MASTER_TANGKI_KODE' => $this->input->post('kode'),
            //     'RIWAYAT_TANGKI_TANGGAL' => date("Y-m-d"),
            //     'RIWAYAT_TANGKI_STATUS' => "baru",
            //     'RIWAYAT_TANGKI_KETERANGAN' => "",


            //     'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            //     'ENTRI_USER' => $this->session->userdata('USER_ID'),
            //     'RECORD_STATUS' => "AKTIF",
            // );
            // $this->db->insert('RIWAYAT_TANGKI', $data_riwayat);

            // if ($this->input->post('isi') == "on") {
            //     $data_riwayat = array(
            //         'RIWAYAT_TANGKI_ID' => create_id(),
            //         'MASTER_TANGKI_KODE' => $this->input->post('kode'),
            //         'RIWAYAT_TANGKI_TANGGAL' => date("Y-m-d"),
            //         'RIWAYAT_TANGKI_STATUS' => "isi",
            //         'RIWAYAT_TANGKI_KETERANGAN' => "",


            //         'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            //         'ENTRI_USER' => $this->session->userdata('USER_ID'),
            //         'RECORD_STATUS' => "AKTIF",
            //     );
            //     $this->db->insert('RIWAYAT_TANGKI', $data_riwayat);
            // }

            $data = array(
                'MASTER_TANGKI_ID' => create_id(),
                'MASTER_TANGKI_KODE' => $this->input->post('kode'),
                'MASTER_JENIS_BARANG_DETAIL_ID' => $this->input->post('jenis_barang'),
                'PEMBELIAN_NOMOR_SURAT' => $this->input->post('surat'),

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
            );

            $result = $this->db->insert('MASTER_TANGKI', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
            );

            $this->db->where('MASTER_TANGKI_ID', $this->input->post('id'));
            $edit = $this->db->update('MASTER_TANGKI', $data_edit);

            $data = array(
                'MASTER_TANGKI_ID' => $this->input->post('id'),
                'MASTER_TANGKI_KODE' => $this->input->post('kode'),
                'MASTER_JENIS_BARANG_DETAIL_ID' => $this->input->post('jenis_barang'),
                'PEMBELIAN_NOMOR_SURAT' => $this->input->post('surat'),

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
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
        );

        $this->db->where('MASTER_TANGKI_ID', $id);
        $result = $this->db->update('MASTER_TANGKI', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_TANGKI WHERE MASTER_TANGKI_ID="' . $id . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }
}
