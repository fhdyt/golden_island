<?php
class HutangModel extends CI_Model
{

    public function supplier_list()
    {
        $hasil = $this->db->query('SELECT * FROM 
        MASTER_SUPPLIER WHERE 
        RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY MASTER_SUPPLIER_NAMA')->result();
        foreach ($hasil as $row) {
            $kredit = $this->db->query('SELECT SUM(HUTANG_KREDIT) AS KREDIT
                                        FROM HUTANG 
                                        WHERE MASTER_SUPPLIER_ID="' . $row->MASTER_SUPPLIER_ID . '"
                                        AND RECORD_STATUS="AKTIF" 
                                        AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                        ')->result();

            $debet = $this->db->query('SELECT SUM(HUTANG_DEBET) AS DEBET
                                        FROM HUTANG 
                                        WHERE MASTER_SUPPLIER_ID="' . $row->MASTER_SUPPLIER_ID . '"
                                        AND RECORD_STATUS="AKTIF" 
                                        AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                        ')->result();

            $row->SALDO = $kredit[0]->KREDIT - $debet[0]->DEBET;
        }
        return $hasil;
    }

    public function laporan_list()
    {
        if (empty($this->input->post('nama_supplier'))) {
            $filter = '';
        } else {
            $filter = 'MASTER_SUPPLIER_NAMA LIKE "%' . $this->input->post('nama_supplier') . '%" AND';
        }
        $hasil = $this->db->query('SELECT * FROM 
        MASTER_SUPPLIER 
        WHERE ' . $filter . ' RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY MASTER_SUPPLIER_NAMA')->result();
        foreach ($hasil as $row) {
            $total = 0;
            foreach (bulan() as $value => $text) {
                $kredit = $this->db->query('SELECT SUM(HUTANG_KREDIT) AS KREDIT
                                        FROM HUTANG 
                                        WHERE MASTER_SUPPLIER_ID="' . $row->MASTER_SUPPLIER_ID . '"
                                        AND MONTH(HUTANG_TANGGAL) = ' . $value . ' 
                                        AND YEAR(HUTANG_TANGGAL) = ' . $this->input->post('tahun') . ' 
                                        AND RECORD_STATUS="AKTIF" 
                                        AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                        ')->result();

                $debet = $this->db->query('SELECT SUM(HUTANG_DEBET) AS DEBET
                                        FROM HUTANG 
                                        WHERE MASTER_SUPPLIER_ID="' . $row->MASTER_SUPPLIER_ID . '"
                                        AND MONTH(HUTANG_TANGGAL) = ' . $value . ' 
                                        AND YEAR(HUTANG_TANGGAL) = ' . $this->input->post('tahun') . ' 
                                        AND RECORD_STATUS="AKTIF" 
                                        AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                        ')->result();
                $row->$text = $kredit[0]->KREDIT - $debet[0]->DEBET;
                $total += $kredit[0]->KREDIT - $debet[0]->DEBET;
            }
            $row->TOTAL = $total;
        }
        return $hasil;
    }

    public function list_hutang($supplier)
    {
        $hasil = $this->db->query('SELECT * FROM 
        HUTANG 
        WHERE MASTER_SUPPLIER_ID="' . $supplier . '" 
        AND HUTANG_DEBET>0 AND HUTANG_KREDIT=0
        AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY HUTANG_TANGGAL ASC')->result();

        $kredit = $this->db->query('SELECT SUM(HUTANG_KREDIT) AS KREDIT
                                        FROM HUTANG 
                                        WHERE MASTER_SUPPLIER_ID="' . $supplier . '"
                                        AND RECORD_STATUS="AKTIF" 
                                        AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                        ')->result();
        $pembayaran = $kredit[0]->KREDIT;
        foreach ($hasil as $row) {
            $pembayaran = $pembayaran - $row->HUTANG_DEBET;
            if ($pembayaran >= 0) {
                $row->STATUS = "CORET";
                $row->PEMBAYARAN = "0";
            } else {
                $row->STATUS = "TIDAK";
                $row->PEMBAYARAN = $pembayaran;
            }
            $row->TANGGAL = tanggal($row->HUTANG_TANGGAL);
            $row->TANGGAL_TEMPO = tanggal($row->HUTANG_TANGGAL_TEMPO);
        }
        return $hasil;
    }

    public function list_pembayaran($supplier)
    {
        $hasil = $this->db->query('SELECT * FROM 
        HUTANG 
        WHERE MASTER_SUPPLIER_ID="' . $supplier . '" 
        AND HUTANG_KREDIT>0 AND HUTANG_DEBET=0
        AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY HUTANG_TANGGAL ASC')->result();
        foreach ($hasil as $row) {
            $row->TANGGAL = tanggal($row->HUTANG_TANGGAL);
        }
        return $hasil;
    }

    public function add()
    {
        $data = array(
            'HUTANG_ID' => create_id(),
            'AKUN_ID' => $this->input->post('akun'),
            'HUTANG_TANGGAL' => $this->input->post('tanggal'),
            'MASTER_SUPPLIER_ID' => $this->input->post('id'),
            'HUTANG_KREDIT' => str_replace(".", "", $this->input->post('rupiah')),
            'HUTANG_DEBET' => "0",
            'HUTANG_SUMBER' => "PENJUALAN",
            'HUTANG_KETERANGAN' => $this->input->post('keterangan'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->insert('HUTANG', $data);

        $data_buku_besar = array(
            'BUKU_BESAR_ID' => create_id(),
            'BUKU_BESAR_REF' => $this->input->post('id'),
            'AKUN_ID' => $this->input->post('akun'),
            'BUKU_BESAR_TANGGAL' => $this->input->post('tanggal'),
            'BUKU_BESAR_JENIS' => "KREDIT",
            'BUKU_BESAR_KREDIT' => str_replace(".", "", $this->input->post('rupiah')),
            'BUKU_BESAR_DEBET' => "0",
            'BUKU_BESAR_SUMBER' => "PEMBELIAN",
            'BUKU_BESAR_KETERANGAN' => $this->input->post('keterangan'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('BUKU_BESAR', $data_buku_besar);
        return $result;
    }

    public function add_saldo()
    {
        $data = array(
            'HUTANG_ID' => create_id(),
            'AKUN_ID' => $this->input->post('akun'),
            'HUTANG_TANGGAL' => $this->input->post('tanggal'),
            'HUTANG_TANGGAL_TEMPO' => $this->input->post('tanggal_tempo'),
            'MASTER_SUPPLIER_ID' => $this->input->post('id'),
            'HUTANG_KREDIT' => "0",
            'HUTANG_DEBET' => str_replace(".", "", $this->input->post('rupiah')),
            'HUTANG_SUMBER' => "HUTANG",
            'HUTANG_KETERANGAN' => $this->input->post('keterangan'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('HUTANG', $data);
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

        $this->db->where('AKUN_ID', $id);
        $result = $this->db->update('AKUN', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_SUPPLIER WHERE MASTER_SUPPLIER_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        return $hasil;
    }

    public function pi_list($id)
    {
        $hasil = $this->db->query('SELECT * FROM PEMBELIAN WHERE PEMBELIAN_JENIS="PI" AND MASTER_SUPPLIER_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        return $hasil;
    }
}
