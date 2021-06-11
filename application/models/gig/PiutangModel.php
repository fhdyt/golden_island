<?php
class PiutangModel extends CI_Model
{

    public function relasi_list()
    {
        $hasil = $this->db->query('SELECT * FROM 
        MASTER_RELASI 
        WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" ORDER BY MASTER_RELASI_NAMA')->result();
        foreach ($hasil as $row) {
            $kredit = $this->db->query('SELECT SUM(PIUTANG_KREDIT) AS KREDIT
                                        FROM PIUTANG 
                                        WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '"
                                        AND RECORD_STATUS="AKTIF" 
                                        AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '"')->result();

            $debet = $this->db->query('SELECT SUM(PIUTANG_DEBET) AS DEBET
                                        FROM PIUTANG 
                                        WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '"
                                        AND RECORD_STATUS="AKTIF" 
                                        AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '"')->result();

            $row->SALDO = $kredit[0]->KREDIT - $debet[0]->DEBET;
        }
        return $hasil;
    }

    public function list_hutang($relasi)
    {
        $hasil = $this->db->query('SELECT * FROM 
        PIUTANG 
        WHERE MASTER_RELASI_ID="' . $relasi . '" 
        AND PIUTANG_DEBET>0 AND PIUTANG_KREDIT=0
        AND RECORD_STATUS="AKTIF" ORDER BY PIUTANG_TANGGAL ASC')->result();

        $kredit = $this->db->query('SELECT SUM(PIUTANG_KREDIT) AS KREDIT
                                        FROM PIUTANG 
                                        WHERE MASTER_RELASI_ID="' . $relasi . '"
                                        AND RECORD_STATUS="AKTIF"')->result();
        $pembayaran = $kredit[0]->KREDIT;
        foreach ($hasil as $row) {
            $pembayaran = $pembayaran - $row->PIUTANG_DEBET;
            if ($pembayaran >= 0) {
                $row->STATUS = "CORET";
                $row->PEMBAYARAN = "0";
            } else {
                $row->STATUS = "TIDAK";
                $row->PEMBAYARAN = $pembayaran;
            }
            $row->TANGGAL = tanggal($row->PIUTANG_TANGGAL);
            $row->TANGGAL_TEMPO = tanggal($row->PIUTANG_TANGGAL_TEMPO);
        }
        return $hasil;
    }
    public function list_pembayaran($relasi)
    {
        $hasil = $this->db->query('SELECT * FROM 
        PIUTANG 
        WHERE MASTER_RELASI_ID="' . $relasi . '" 
        AND PIUTANG_KREDIT>0 AND PIUTANG_DEBET=0
        AND RECORD_STATUS="AKTIF" ORDER BY PIUTANG_TANGGAL ASC')->result();
        foreach ($hasil as $row) {
            $row->TANGGAL = tanggal($row->PIUTANG_TANGGAL);
        }
        return $hasil;
    }

    public function add()
    {
        $data = array(
            'PIUTANG_ID' => create_id(),
            'AKUN_ID' => $this->input->post('akun'),
            'PIUTANG_TANGGAL' => $this->input->post('tanggal'),
            'MASTER_RELASI_ID' => $this->input->post('id'),
            'PIUTANG_KREDIT' => str_replace(".", "", $this->input->post('rupiah')),
            'PIUTANG_DEBET' => "0",
            'PIUTANG_SUMBER' => "PENJUALAN",
            'PIUTANG_KETERANGAN' => $this->input->post('keterangan'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->insert('PIUTANG', $data);

        $data_buku_besar = array(
            'BUKU_BESAR_ID' => create_id(),
            'BUKU_BESAR_REF' => $this->input->post('id'),
            'AKUN_ID' => $this->input->post('akun'),
            'BUKU_BESAR_TANGGAL' => $this->input->post('tanggal'),
            'BUKU_BESAR_JENIS' => "KREDIT",
            'BUKU_BESAR_KREDIT' => "0",
            'BUKU_BESAR_DEBET' => str_replace(".", "", $this->input->post('rupiah')),
            'BUKU_BESAR_SUMBER' => "PENJUALAN",
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
            'PIUTANG_ID' => create_id(),
            'AKUN_ID' => $this->input->post('akun'),
            'PIUTANG_TANGGAL' => $this->input->post('tanggal'),
            'PIUTANG_TANGGAL_TEMPO' => $this->input->post('tanggal_tempo'),
            'MASTER_RELASI_ID' => $this->input->post('id'),
            'PIUTANG_KREDIT' => "0",
            'PIUTANG_DEBET' => str_replace(".", "", $this->input->post('rupiah')),
            'PIUTANG_SUMBER' => "PIUTANG",
            'PIUTANG_KETERANGAN' => $this->input->post('keterangan'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('PIUTANG', $data);
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
        $hasil = $this->db->query('SELECT * FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $id . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }
}
