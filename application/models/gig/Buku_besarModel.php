<?php
class Buku_besarModel extends CI_Model
{

    public function list($akun)
    {
        $tanggal_dari = $this->input->post("tanggal_dari");
        $tanggal_sampai = $this->input->post("tanggal_sampai");
        // echo $this->input->post("tanggal_sampai");
        //exit;

        // if (!empty($tanggal_dari)) {

        // } else {
        //     $tanggal = '';
        //     $hasil['saldo_awal'] = "";
        // }

        $tanggal = 'AND BUKU_BESAR_TANGGAL BETWEEN "' . $tanggal_dari . '" AND "' . $tanggal_sampai . '"';
        $hasil['saldo_awal'] = $this->db->query('SELECT 
            SUM(BUKU_BESAR_KREDIT) AS KREDIT,
            SUM(BUKU_BESAR_DEBET) AS DEBET 
            FROM 
            BUKU_BESAR WHERE 
            AKUN_ID="' . $akun . '" 
            AND RECORD_STATUS="AKTIF" 
            AND PERUSAHAAN_KODE="' . $this->input->post("perusahaan") . '" 
            AND BUKU_BESAR_TANGGAL < "' . $tanggal_dari . '"
            ORDER BY BUKU_BESAR_TANGGAL ASC')->result();

        $hasil['data'] = $this->db->query('SELECT * FROM 
        BUKU_BESAR WHERE 
        AKUN_ID="' . $akun . '" 
        AND NOT (BUKU_BESAR_KREDIT=0 AND BUKU_BESAR_DEBET =0)
        AND RECORD_STATUS="AKTIF" 
        AND PERUSAHAAN_KODE="' . $this->input->post("perusahaan") . '" 
        ' . $tanggal . '
        ORDER BY BUKU_BESAR_TANGGAL ASC')->result();
        foreach ($hasil['data'] as $row) {
            $row->TANGGAL = tanggal($row->BUKU_BESAR_TANGGAL);
            $row->SALDO = $row->BUKU_BESAR_DEBET - $row->BUKU_BESAR_KREDIT;
        }
        return $hasil;
    }

    public function add($akun, $config)
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
            'BUKU_BESAR_JENIS_PENGELUARAN' => $this->input->post('jenis_pengeluaran'),
            'BUKU_BESAR_KETERANGAN' => $this->input->post('keterangan'),
            'BUKU_BESAR_FILE' => $config['file_name'],

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('BUKU_BESAR', $data_buku_besar);
        return $result;
    }

    public function transfer()
    {
        $data_dari = array(
            'BUKU_BESAR_ID' => create_id(),
            'BUKU_BESAR_REF' => $this->input->post('id'),
            'AKUN_ID' => $this->input->post('akun_dari'),
            'BUKU_BESAR_TANGGAL' => $this->input->post('tanggal'),
            'BUKU_BESAR_JENIS' => "KREDIT",
            'BUKU_BESAR_KREDIT' => str_replace(".", "", $this->input->post('rupiah')),
            'BUKU_BESAR_DEBET' => "0",
            'BUKU_BESAR_SUMBER' => "TRANSFER",
            'BUKU_BESAR_KETERANGAN' => $this->input->post('keterangan'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->insert('BUKU_BESAR', $data_dari);

        $data_tujuan = array(
            'BUKU_BESAR_ID' => create_id(),
            'BUKU_BESAR_REF' => $this->input->post('id'),
            'AKUN_ID' => $this->input->post('akun_tujuan'),
            'BUKU_BESAR_TANGGAL' => $this->input->post('tanggal'),
            'BUKU_BESAR_JENIS' => "DEBET",
            'BUKU_BESAR_KREDIT' => "0",
            'BUKU_BESAR_DEBET' => str_replace(".", "", $this->input->post('rupiah')),
            'BUKU_BESAR_SUMBER' => "TRANSFER",
            'BUKU_BESAR_KETERANGAN' => $this->input->post('keterangan'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('BUKU_BESAR', $data_tujuan);
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

        $this->db->where('BUKU_BESAR_ID', $id);
        $result = $this->db->update('BUKU_BESAR', $data);
        return $result;
    }

    public function akun_list($id)
    {
        $hasil = $this->db->query('SELECT * FROM AKUN WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $id . '"')->result();
        return $hasil;
    }
}
