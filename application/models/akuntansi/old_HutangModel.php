<?php
class HutangModel extends CI_Model
{

    public function list($supplier, $pi)
    {
        $hasil = $this->db->query('SELECT * FROM 
        HUTANG 
        WHERE MASTER_SUPPLIER_ID="' . $supplier . '" 
        AND NOT (HUTANG_KREDIT=0 AND HUTANG_DEBET =0)
        AND HUTANG_REF="' . $pi . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY HUTANG_TANGGAL ASC')->result();
        foreach ($hasil as $row) {
            $row->TANGGAL = tanggal($row->HUTANG_TANGGAL);
            $row->SALDO = $row->HUTANG_DEBET - $row->HUTANG_KREDIT;
        }
        return $hasil;
    }

    public function add($supplier, $pi)
    {
        $data = array(
            'HUTANG_ID' => create_id(),
            'HUTANG_REF' => $pi,
            'AKUN_ID' => $this->input->post('akun'),
            'HUTANG_TANGGAL' => $this->input->post('tanggal'),
            'MASTER_SUPPLIER_ID' => $supplier,
            'HUTANG_KREDIT' => str_replace(".", "", $this->input->post('rupiah')),
            'HUTANG_DEBET' => "0",
            'HUTANG_SUMBER' => "PEMBELIAN",
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

    public function pi_list($id)
    {
        $hasil = $this->db->query('SELECT * FROM PEMBELIAN WHERE PEMBELIAN_JENIS="PI" AND MASTER_SUPPLIER_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        return $hasil;
    }
}
