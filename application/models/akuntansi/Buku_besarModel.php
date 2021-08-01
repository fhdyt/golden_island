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
            AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
            AND BUKU_BESAR_TANGGAL < "' . $tanggal_dari . '"
            ORDER BY BUKU_BESAR_TANGGAL ASC')->result();

        $hasil['data'] = $this->db->query('SELECT * FROM 
        BUKU_BESAR WHERE 
        AKUN_ID="' . $akun . '" 
        AND NOT (BUKU_BESAR_KREDIT=0 AND BUKU_BESAR_DEBET =0)
        AND RECORD_STATUS="AKTIF" 
        AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
        ' . $tanggal . '
        ORDER BY ENTRI_WAKTU ASC')->result();
        foreach ($hasil['data'] as $row) {
            $row->TANGGAL = tanggal($row->BUKU_BESAR_TANGGAL);
            $row->SALDO = $row->BUKU_BESAR_DEBET - $row->BUKU_BESAR_KREDIT;
        }
        return $hasil;
    }

    public function add($akun, $config)
    {
        if ($this->input->post('jenis_pengeluaran') == "Uang Jalan") {
            $hasil = $this->db->query('SELECT * FROM 
        SURAT_JALAN
        WHERE 
        SURAT_JALAN_ID="' . $this->input->post('nomor_surat_jalan') . '"
        AND
        RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
            $ref = $hasil[0]->SURAT_JALAN_ID;
            $surat_jalan_nomor = $hasil[0]->SURAT_JALAN_NOMOR;
        } else {
            $ref = create_id();
            $surat_jalan_nomor = "";
        }
        $data_buku_besar = array(
            'BUKU_BESAR_ID' => create_id(),
            'BUKU_BESAR_REF' => $ref,
            'AKUN_ID' => $akun,
            'BUKU_BESAR_TANGGAL' => $this->input->post('tanggal'),
            'BUKU_BESAR_JENIS' => "KREDIT",
            'BUKU_BESAR_KREDIT' => str_replace(".", "", $this->input->post('kredit')),
            'BUKU_BESAR_DEBET' => str_replace(".", "", $this->input->post('debet')),
            'BUKU_BESAR_SUMBER' => "BUKU BESAR",
            'BUKU_BESAR_JENIS_PENGELUARAN' => $this->input->post('jenis_pengeluaran'),
            'BUKU_BESAR_KETERANGAN' => $this->input->post('keterangan') . " " . $surat_jalan_nomor,
            'BUKU_BESAR_FILE' => $config['file_name'],

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('BUKU_BESAR', $data_buku_besar);
        // send_telegram("Buku Besar (" . $this->session->userdata('PERUSAHAAN_KODE') . ")\nKredit : " . $this->input->post('kredit') . "\nDebet : " . $this->input->post('debet') . "\nTanggal : " . tanggal($this->input->post('tanggal')) . "\nKeterangan : " . $this->input->post('keterangan') . "");
        return $result;
    }

    public function surat_jalan_3()
    {
        $hari_ini = date("Y-m-d");
        $before = date('Y-m-d', strtotime('-3 days'));
        $hasil = $this->db->query('SELECT * FROM 
        SURAT_JALAN
        WHERE 
        SURAT_JALAN_TANGGAL BETWEEN "' . $before . '" AND "' . $hari_ini . '" 
        AND
        RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY SURAT_JALAN_NOMOR DESC')->result();
        return $hasil;
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

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM AKUN WHERE AKUN_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        return $hasil;
    }
}
