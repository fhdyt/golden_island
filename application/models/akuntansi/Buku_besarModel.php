<?php
class Buku_besarModel extends CI_Model
{

    public function list($akun)
    {

        $hasil = $this->db->query('SELECT * FROM BUKU_BESAR WHERE AKUN_ID="' . $akun . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY BUKU_BESAR_TANGGAL ASC')->result();
        foreach ($hasil as $row) {
            $row->TANGGAL = tanggal($row->BUKU_BESAR_TANGGAL);
            $row->SALDO = $row->BUKU_BESAR_DEBET - $row->BUKU_BESAR_KREDIT;
        }
        return $hasil;
    }

    public function add($akun)
    {
        $data_buku_besar = array(
            'BUKU_BESAR_ID' => create_id(),
            'BUKU_BESAR_REF' => $this->input->post('id'),
            'AKUN_ID' => $akun,
            'BUKU_BESAR_TANGGAL' => $this->input->post('tanggal'),
            'BUKU_BESAR_JENIS' => "KREDIT",
            'BUKU_BESAR_KREDIT' => str_replace(".", "", $this->input->post('kredit')),
            'BUKU_BESAR_DEBET' => str_replace(".", "", $this->input->post('debet')),
            'BUKU_BESAR_SUMBER' => "BUKU BESAR",
            'BUKU_BESAR_KETERANGAN' => $this->input->post('keterangan'),

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
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
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('BUKU_BESAR_ID', $id);
        $result = $this->db->update('BUKU_BESAR', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM AKUN WHERE AKUN_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        return $hasil;
    }
}
