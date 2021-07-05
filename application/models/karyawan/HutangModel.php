<?php
class HutangModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_KARYAWAN WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY MASTER_KARYAWAN_NAMA')->result();
        foreach ($hasil as $row) {
            $hutang = $this->db->query('SELECT * FROM KARYAWAN_HUTANG WHERE MASTER_KARYAWAN_ID="' . $row->MASTER_KARYAWAN_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            $row->GAJI = $hutang;
        }
        return $hasil;
    }

    public function add()
    {
        $data = array(
            'KARYAWAN_HUTANG_ID' => create_id(),
            'AKUN_ID' => $this->input->post('akun'),
            'KARYAWAN_HUTANG_TANGGAL' => $this->input->post('tanggal'),
            'MASTER_KARYAWAN_ID' => $this->input->post('id_karyawan'),
            'KARYAWAN_HUTANG_KREDIT' => str_replace(".", "", $this->input->post('harga')),
            'KARYAWAN_HUTANG_DEBET' => "0",
            'KARYAWAN_HUTANG_SUMBER' => "HUTANG",
            'KARYAWAN_HUTANG_KETERANGAN' => $this->input->post('keterangan'),

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
            'BUKU_BESAR_KREDIT' => "0",
            'BUKU_BESAR_DEBET' => str_replace(".", "", $this->input->post('harga')),
            'BUKU_BESAR_SUMBER' => "HUTANG KARYAWAN",
            'BUKU_BESAR_KETERANGAN' => $this->input->post('keterangan'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('BUKU_BESAR', $data_buku_besar);
        return $result;
    }
}
