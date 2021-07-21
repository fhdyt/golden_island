<?php
class JaminanModel extends CI_Model
{

    public function list()
    {
        if (empty($this->input->post('nama_relasi'))) {
            $filter = '';
        } else {
            $filter = 'MASTER_RELASI_ID LIKE "%' . $this->input->post('nama_relasi') . '%" AND';
        }

        $hasil = $this->db->query('SELECT * FROM FAKTUR_JAMINAN WHERE ' . $filter . ' RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY FAKTUR_JAMINAN_TANGGAL DESC, FAKTUR_JAMINAN_NOMOR DESC ')->result();
        foreach ($hasil as $row) {
            $surat_jalan = $this->db->query('SELECT SURAT_JALAN_TANGGAL FROM SURAT_JALAN WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY SURAT_JALAN_TANGGAL DESC LIMIT 1')->result();
            if (empty($surat_jalan)) {
                $row->SELISIH_TANGGAL = array();
                $row->SURAT_JALAN_TERAKHIR = array();
            } else {
                $row->SURAT_JALAN_TERAKHIR = $surat_jalan[0]->SURAT_JALAN_TANGGAL;
                $date1 = strtotime(date("Y-m-d"));
                $date2 = strtotime($row->SURAT_JALAN_TERAKHIR);
                $diff = abs($date2 - $date1);
                $years = floor($diff / (365 * 60 * 60 * 24));
                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                $row->SELISIH_TANGGAL = $days . " Hari, " . $months . " Bulan, " . $years . " Tahun";
                $row->HARI_INI = date("Y-m-d");
            }

            $row->NAMA_RELASI = $this->db->query('SELECT MASTER_RELASI_NAMA FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();
            $row->TANGGAL = tanggal($row->FAKTUR_JAMINAN_TANGGAL);
            $row->TANGGAL_SELESAI = tanggal($row->FAKTUR_JAMINAN_TANGGAL_SELESAI);
            $row->SURAT_JALAN = $this->db->query('SELECT * FROM SURAT_JALAN WHERE SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();;
        }
        return $hasil;
    }

    public function add()
    {
        // $data_surat_jalan = array(
        //     'SURAT_JALAN_STATUS' => "open",
        // );

        // $this->db->where('SURAT_JALAN_ID', $this->input->post('surat_jalan'));
        // $this->db->update('SURAT_JALAN', $data_surat_jalan);

        // $data_edit_buku_besar = array(
        //     'EDIT_WAKTU' => date("Y-m-d G:i:s"),
        //     'EDIT_USER' => $this->session->userdata('USER_ID'),
        //     'RECORD_STATUS' => "EDIT",
        //     'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        // );
        // $this->db->where('BUKU_BESAR_REF', $this->input->post('surat_jalan'));
        // $this->db->where('RECORD_STATUS', 'AKTIF');
        // $this->db->update('BUKU_BESAR', $data_edit_buku_besar);

        $hasil = $this->db->query('SELECT * FROM SURAT_JALAN WHERE SURAT_JALAN_ID="' . $this->input->post('surat_jalan') . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"  LIMIT 1 ')->result();
        $nomor_jaminan = nomor_jaminan($this->input->post('tanggal'));
        $data = array(
            'FAKTUR_JAMINAN_ID' => create_id(),
            'MASTER_RELASI_ID' => $hasil[0]->MASTER_RELASI_ID,
            'AKUN_ID' => $this->input->post('akun'),
            'FAKTUR_JAMINAN_NOMOR' => $nomor_jaminan,
            'SURAT_JALAN_ID' => $this->input->post('surat_jalan'),
            'FAKTUR_JAMINAN_TANGGAL' => $this->input->post('tanggal'),
            'FAKTUR_JAMINAN_KETERANGAN' => "JAMINAN NO. " . $nomor_jaminan . "",
            'FAKTUR_JAMINAN_JUMLAH' => str_replace(".", "", $this->input->post('jumlah')),
            'FAKTUR_JAMINAN_HARGA' => str_replace(".", "", $this->input->post('harga')),
            'FAKTUR_JAMINAN_TOTAL_RUPIAH' => str_replace(".", "", $this->input->post('total')),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('FAKTUR_JAMINAN', $data);

        // $data_buku_besar = array(
        //     'BUKU_BESAR_ID' => create_id(),
        //     'BUKU_BESAR_REF' => $this->input->post('id'),
        //     'AKUN_ID' => $this->input->post('akun'),
        //     'BUKU_BESAR_TANGGAL' => $this->input->post('tanggal'),
        //     'BUKU_BESAR_KREDIT' => "0",
        //     'BUKU_BESAR_DEBET' => str_replace(".", "", $this->input->post('total')),
        //     'BUKU_BESAR_SUMBER' => "JAMINAN",
        //     'BUKU_BESAR_JENIS_PENGELUARAN' => "Jaminan",
        //     'BUKU_BESAR_KETERANGAN' => "JAMINAN NO." . $nomor_jaminan . "",

        //     'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
        //     'ENTRI_USER' => $this->session->userdata('USER_ID'),
        //     'RECORD_STATUS' => "AKTIF",
        //     'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        // );

        // $result = $this->db->insert('BUKU_BESAR', $data_buku_besar);
        return $result;
    }

    public function selesai()
    {
        $hasil = $this->db->query('SELECT * FROM FAKTUR_JAMINAN WHERE FAKTUR_JAMINAN_ID="' . $this->input->post('id_jaminan') . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"  LIMIT 1 ')->result();

        $data_edit_jaminan = array(
            'FAKTUR_JAMINAN_STATUS' => "selesai",
            'FAKTUR_JAMINAN_TANGGAL_SELESAI' => date("Y-m-d"),
        );
        $this->db->where('FAKTUR_JAMINAN_ID', $this->input->post('id_jaminan'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('FAKTUR_JAMINAN', $data_edit_jaminan);


        $data_buku_besar = array(
            'BUKU_BESAR_ID' => create_id(),
            'BUKU_BESAR_REF' => $this->input->post('id_jaminan'),
            'AKUN_ID' => $this->input->post('akun'),
            'BUKU_BESAR_TANGGAL' => date("Y-m-d"),
            'BUKU_BESAR_KREDIT' => $hasil[0]->FAKTUR_JAMINAN_TOTAL_RUPIAH,
            'BUKU_BESAR_DEBET' => "0",
            'BUKU_BESAR_SUMBER' => "JAMINAN",
            'BUKU_BESAR_JENIS_PENGELUARAN' => "Jaminan",
            'BUKU_BESAR_KETERANGAN' => "SELESAI JAMINAN TABUNG NO. " . $hasil[0]->FAKTUR_JAMINAN_NOMOR . "",

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('BUKU_BESAR', $data_buku_besar);
        return $result;
    }

    public function surat_jalan_list()
    {
        $hasil = $this->db->query('SELECT * FROM 
        SURAT_JALAN
        WHERE SURAT_JALAN_JENIS="penjualan" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        foreach ($hasil as $row) {
            $relasi = $this->db->query('SELECT * FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            $row->TANGGAL = tanggal($row->SURAT_JALAN_TANGGAL);
            $oleh = $this->db->query('SELECT * FROM USER WHERE USER_ID="' . $row->ENTRI_USER . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
            $row->RELASI = $relasi;
            $row->OLEH = $oleh;
        }
        return $hasil;
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

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM FAKTUR_JAMINAN WHERE FAKTUR_JAMINAN_ID="' . $id . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }
}
