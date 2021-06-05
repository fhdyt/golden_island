<?php
class PanggungModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM 
                                                    MASTER_BARANG 
                                                    WHERE 
                                                    RECORD_STATUS="AKTIF" 
                                                    AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();
        foreach ($hasil as $row) {
            $row->SALDO_AWAL_MP = $this->db->query('SELECT * FROM 
                                                    JURNAL_TABUNG 
                                                    WHERE 
                                                    JURNAL_TABUNG_REF="SALDO_AWAL" 
                                                    AND MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '"
                                                    AND JURNAL_TABUNG_STATUS="MP"
                                                    AND RECORD_STATUS="AKTIF" 
                                                    AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();
            $row->SALDO_AWAL_MR = $this->db->query('SELECT * FROM 
                                                    JURNAL_TABUNG 
                                                    WHERE 
                                                    JURNAL_TABUNG_REF="SALDO_AWAL" 
                                                    AND MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '"
                                                    AND JURNAL_TABUNG_STATUS="MR"
                                                    AND RECORD_STATUS="AKTIF" 
                                                    AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();

            $row->SALDO_MP = $this->db->query('SELECT SUM(JURNAL_TABUNG_KIRIM) AS KIRIM, SUM(JURNAL_TABUNG_KEMBALI) AS KEMBALI FROM 
                                                    JURNAL_TABUNG 
                                                    WHERE
                                                    NOT JURNAL_TABUNG_REF="SALDO_AWAL"
                                                    AND MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '"
                                                    AND JURNAL_TABUNG_STATUS="MP"
                                                    AND RECORD_STATUS="AKTIF" 
                                                    AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();
            $row->SALDO_MR = $this->db->query('SELECT SUM(JURNAL_TABUNG_KIRIM) AS KIRIM, SUM(JURNAL_TABUNG_KEMBALI) AS KEMBALI FROM 
                                                    JURNAL_TABUNG 
                                                    WHERE 
                                                    NOT JURNAL_TABUNG_REF="SALDO_AWAL"
                                                    AND MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '"
                                                    AND JURNAL_TABUNG_STATUS="MR"
                                                    AND RECORD_STATUS="AKTIF" 
                                                    AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();
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

    public function saldo_awal_list()
    {
        $hasil = $this->db->query('SELECT * FROM 
                                    JURNAL_TABUNG AS J
                                    LEFT JOIN MASTER_BARANG AS B
                                    ON 
                                    J.MASTER_BARANG_ID=B.MASTER_BARANG_ID
                                    WHERE 
                                    J.JURNAL_TABUNG_REF="SALDO_AWAL" 
                                    AND J.RECORD_STATUS="AKTIF" 
                                    AND J.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                    AND B.RECORD_STATUS="AKTIF" 
                                    AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                    ORDER BY 
                                    J.JURNAL_TABUNG_TANGGAL ')->result();
        foreach ($hasil as $row) {
            $row->TANGGAL = tanggal($row->JURNAL_TABUNG_TANGGAL);
        }
        return $hasil;
    }

    public function add()
    {
        $data_mp = array(
            'JURNAL_TABUNG_ID' => create_id(),
            'MASTER_BARANG_ID' => $this->input->post('jenis'),
            'JURNAL_TABUNG_TANGGAL' => $this->input->post('tanggal'),
            'JURNAL_TABUNG_KIRIM' => "0",
            'JURNAL_TABUNG_KEMBALI' => $this->input->post('total'),
            'JURNAL_TABUNG_STATUS' => $this->input->post('status'),
            'JURNAL_TABUNG_KETERANGAN' => $this->input->post('keterangan'),
            'JURNAL_TABUNG_REF' => "SALDO_AWAL",

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );
        $resutl = $this->db->insert('JURNAL_TABUNG', $data_mp);
    }

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('PAJAK_ID', $id);
        $result = $this->db->update('PAJAK', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM PAJAK WHERE PAJAK_ID="' . $id . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }
}
