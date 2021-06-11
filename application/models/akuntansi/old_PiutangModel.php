<?php
class PiutangModel extends CI_Model
{

    public function list($relasi)
    {
        $hasil = $this->db->query('SELECT * FROM 
        PIUTANG 
        WHERE MASTER_RELASI_ID="' . $relasi . '" 
        AND NOT (PIUTANG_KREDIT=0 AND PIUTANG_DEBET =0)
        AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY PIUTANG_TANGGAL ASC')->result();
        foreach ($hasil as $row) {
            $row->TANGGAL = tanggal($row->PIUTANG_TANGGAL);
            $row->SALDO = $row->PIUTANG_DEBET - $row->PIUTANG_KREDIT;
        }
        return $hasil;
    }

    public function add($relasi)
    {
        $data = array(
            'PIUTANG_ID' => create_id(),
            'AKUN_ID' => $this->input->post('akun'),
            'PIUTANG_TANGGAL' => $this->input->post('tanggal'),
            'MASTER_RELASI_ID' => $relasi,
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
        $hasil = $this->db->query('SELECT * FROM AKUN WHERE AKUN_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        return $hasil;
    }
}
