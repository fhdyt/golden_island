<?php
class PanggungModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM 
                                                    MASTER_BARANG 
                                                    WHERE 
                                                    MASTER_BARANG_JENIS="gas"
                                                    AND RECORD_STATUS="AKTIF" 
                                                    AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" ORDER BY MASTER_BARANG_NAMA')->result();
        foreach ($hasil as $row) {
            $row->SALDO_AWAL_MP = $this->db->query('SELECT * FROM 
                                                    JURNAL_TABUNG 
                                                    WHERE 
                                                    JURNAL_TABUNG_REF="SALDO_AWAL" 
                                                    AND MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '"
                                                    AND JURNAL_TABUNG_STATUS="MP"
                                                    AND RECORD_STATUS="AKTIF" 
                                                    AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" ')->result();
            $row->SALDO_AWAL_MR = $this->db->query('SELECT * FROM 
                                                    JURNAL_TABUNG 
                                                    WHERE 
                                                    JURNAL_TABUNG_REF="SALDO_AWAL" 
                                                    AND MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '"
                                                    AND JURNAL_TABUNG_STATUS="MR"
                                                    AND RECORD_STATUS="AKTIF" 
                                                    AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" ')->result();

            $row->SALDO_MP = $this->db->query('SELECT SUM(JURNAL_TABUNG_KIRIM) AS KIRIM, SUM(JURNAL_TABUNG_KEMBALI) AS KEMBALI FROM 
                                                    JURNAL_TABUNG 
                                                    WHERE
                                                    NOT JURNAL_TABUNG_REF="SALDO_AWAL"
                                                    AND MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '"
                                                    AND JURNAL_TABUNG_STATUS="MP"
                                                    AND RECORD_STATUS="AKTIF" 
                                                    AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" ')->result();
            $row->SALDO_MR = $this->db->query('SELECT SUM(JURNAL_TABUNG_KIRIM) AS KIRIM, SUM(JURNAL_TABUNG_KEMBALI) AS KEMBALI FROM 
                                                    JURNAL_TABUNG 
                                                    WHERE 
                                                    NOT JURNAL_TABUNG_REF="SALDO_AWAL"
                                                    AND MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '"
                                                    AND JURNAL_TABUNG_STATUS="MR"
                                                    AND RECORD_STATUS="AKTIF" 
                                                    AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" ')->result();
        }
        // $hasil['saldo_awal'] = $this->db->query('SELECT * FROM 
        //                                             JURNAL_TABUNG 
        //                                             WHERE 
        //                                             JURNAL_TABUNG_REF="SALDO_AWAL" 
        //                                             AND MASTER_BARANG_ID="' . $this->input->post('tabung') . '"
        //                                             AND RECORD_STATUS="AKTIF" 
        //                                             AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();

        // $tabung = $this->input->post('tabung');
        // if (empty($tabung)) {
        //     $filter_tabung = "";
        // } else {
        //     $filter_tabung = 'AND MASTER_BARANG_ID="' . $tabung . '"';
        // }

        // $tanggal_dari = $this->input->post("tanggal_dari");
        // $tanggal_sampai = $this->input->post("tanggal_sampai");

        // $filter_tanggal = 'AND JURNAL_TABUNG_TANGGAL BETWEEN "' . $tanggal_dari . '" AND "' . $tanggal_sampai . '"';
        // $filter_tabung = 'AND MASTER_BARANG_ID="' . $this->input->post('tabung') . '"';
        // $hasil['list'] = $this->db->query('SELECT * FROM 
        // JURNAL_TABUNG 
        // WHERE 
        // NOT JURNAL_TABUNG_REF="SALDO_AWAL"
        // AND
        // RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
        // ' . $filter_tanggal . '
        // ' . $filter_tabung . '
        // ORDER BY JURNAL_TABUNG_TANGGAL ASC ')->result();
        // foreach ($hasil['list'] as $row) {
        //     $nama_barang = $this->db->query('SELECT MASTER_BARANG_NAMA FROM MASTER_BARANG WHERE MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"');
        //     $relasi_nama = $this->db->query('SELECT MASTER_RELASI_NAMA FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"');
        //     $supplier_nama = $this->db->query('SELECT MASTER_SUPPLIER_NAMA FROM MASTER_SUPPLIER WHERE MASTER_SUPPLIER_ID="' . $row->MASTER_SUPPLIER_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"');
        //     $row->RELASI_NAMA = $relasi_nama->result();
        //     $row->SUPPLIER_NAMA = $supplier_nama->result();
        //     $row->NAMA_BARANG = $nama_barang->result();
        //     $row->TANGGAL = tanggal($row->JURNAL_TABUNG_TANGGAL);
        //     $row->TOTAL = $row->JURNAL_TABUNG_KEMBALI - $row->JURNAL_TABUNG_KIRIM;
        // }
        return $hasil;
    }

    public function verifikasi()
    {
        $data_mp = array(
            'VERIFIKASI_PANGGUNG_ID' => create_id(),
            'VERIFIKASI_PANGGUNG_TOTAL' => $this->input->post('total'),
            'VERIFIKASI_PANGGUNG_TANGGAL' => date("Y-m-d G:i:s"),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );
        $result = $this->db->insert('VERIFIKASI_PANGGUNG', $data_mp);
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

        $this->db->where('PAJAK_ID', $id);
        $result = $this->db->update('PAJAK', $data);
        return $result;
    }

    public function verifikasi_list()
    {
        $hasil = $this->db->query('SELECT * 
                                    FROM VERIFIKASI_PANGGUNG 
                                    WHERE VERIFIKASI_PANGGUNG_TANGGAL LIKE "%' . date("Y-m-d") . '%" 
                                    AND RECORD_STATUS="AKTIF" 
                                    AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '"')->result();
        foreach ($hasil as $row) {
            $row->USER = $this->db->query('SELECT * FROM USER WHERE USER_ID="' . $row->ENTRI_USER . '" AND RECORD_STATUS="AKTIF"')->result();
        }
        return $hasil;
    }
    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM PAJAK WHERE PAJAK_ID="' . $id . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }
}
