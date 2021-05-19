<?php
class FakturModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM FAKTUR WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY FAKTUR_NOMOR DESC ')->result();
        foreach ($hasil as $row) {
            $relasi = $this->db->query('SELECT * FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            $row->TANGGAL = tanggal($row->FAKTUR_TANGGAL);
            $row->RELASI = $relasi;
        }
        return $hasil;
    }
    public function add()
    {
        $hasil = $this->db->query('SELECT * FROM 
        FAKTUR_SURAT_JALAN
        WHERE FAKTUR_ID="' . $this->input->post('id') . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        foreach ($hasil as $row) {
            $data_surat_jalan = array(
                'SURAT_JALAN_STATUS' => "close",
            );

            $this->db->where('SURAT_JALAN_ID', $row->SURAT_JALAN_ID);
            $this->db->update('SURAT_JALAN', $data_surat_jalan);
        }

        $data_edit_aktif = array(
            'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );
        $this->db->where('FAKTUR_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('FAKTUR', $data_edit_aktif);

        $data_edit_transaksi = array(
            'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );
        $this->db->where('FAKTUR_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('FAKTUR_TRANSAKSI', $data_edit_transaksi);

        $data_edit_piutang = array(
            'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );
        $this->db->where('PIUTANG_REF', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('PIUTANG', $data_edit_piutang);

        $data_edit_buku_besar = array(
            'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );
        $this->db->where('BUKU_BESAR_REF', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('BUKU_BESAR', $data_edit_buku_besar);

        if (str_replace(".", "", $this->input->post('sisa_bayar')) > 0) {
            $data_piutang = array(
                'PIUTANG_REF' => $this->input->post('id'),
                'PIUTANG_ID' => create_id(),
                'AKUN_ID' => $this->input->post('akun'),
                'MASTER_RELASI_ID' => $this->input->post('relasi'),
                'PIUTANG_TANGGAL' => $this->input->post('tanggal'),
                'PIUTANG_KREDIT' => str_replace(".", "", $this->input->post('sisa_bayar')),
                'PIUTANG_DEBET' => "0",
                'PIUTANG_SUMBER' => "PENJUALAN",
                'PIUTANG_KETERANGAN' => $this->input->post('keterangan'),
                'MASTER_RELASI_ID' => $this->input->post('relasi'),


                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->insert('PIUTANG', $data_piutang);
        }


        $data_buku_besar = array(
            'BUKU_BESAR_ID' => create_id(),
            'BUKU_BESAR_REF' => $this->input->post('id'),
            'AKUN_ID' => $this->input->post('akun'),
            'BUKU_BESAR_TANGGAL' => $this->input->post('tanggal'),
            'BUKU_BESAR_KREDIT' => str_replace(".", "", $this->input->post('sisa_bayar')),
            'BUKU_BESAR_DEBET' => str_replace(".", "", $this->input->post('sisa_bayar')),
            'BUKU_BESAR_SUMBER' => "PENJUALAN",
            'BUKU_BESAR_KETERANGAN' => "",

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->insert('BUKU_BESAR', $data_buku_besar);

        $data = array(
            'FAKTUR_ID' => $this->input->post('id'),
            'FAKTUR_NOMOR' => nomor_faktur($this->input->post('tanggal')),
            'FAKTUR_TANGGAL' => $this->input->post('tanggal'),
            'FAKTUR_KETERANGAN' => $this->input->post('keterangan'),
            'MASTER_RELASI_ID' => $this->input->post('relasi'),
            'AKUN_ID' => $this->input->post('akun'),

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->insert('FAKTUR', $data);

        $data_transaksi = array(
            'FAKTUR_TRANSAKSI_ID' => create_id(),
            'FAKTUR_ID' => $this->input->post('id'),
            'FAKTUR_TRANSAKSI_TOTAL' => str_replace(".", "", $this->input->post('total')),
            'FAKTUR_TRANSAKSI_PAJAK' => $this->input->post('pajak'),
            'FAKTUR_TRANSAKSI_PAJAK_RUPIAH' => str_replace(".", "", $this->input->post('pajak_rupiah')),
            'FAKTUR_TRANSAKSI_GRAND_TOTAL' => str_replace(".", "", $this->input->post('grand_total')),
            'PEMBELIAN_TRANSAKSI_BAYAR' => str_replace(".", "", $this->input->post('bayar')),

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $data_transaksi = $this->db->insert('FAKTUR_TRANSAKSI', $data_transaksi);
        return $data_transaksi;
    }

    public function hapus($id)
    {
        $hasil = $this->db->query('SELECT * FROM 
        FAKTUR_SURAT_JALAN
        WHERE FAKTUR_SURAT_JALAN_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();

        $data = array(
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('FAKTUR_SURAT_JALAN_ID', $id);
        $this->db->update('FAKTUR_SURAT_JALAN', $data);

        $data_barang = array(
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('SURAT_JALAN_ID', $hasil[0]->SURAT_JALAN_ID);
        $this->db->update('FAKTUR_BARANG', $data_barang);

        $data_surat_jalan = array(
            'SURAT_JALAN_STATUS' => "open",
        );

        $this->db->where('SURAT_JALAN_ID', $hasil[0]->SURAT_JALAN_ID);
        $result = $this->db->update('SURAT_JALAN', $data_surat_jalan);


        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM 
        FAKTUR
        WHERE FAKTUR_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        foreach ($hasil as $row) {
            $transaksi = $this->db->query('SELECT * FROM FAKTUR_TRANSAKSI WHERE FAKTUR_ID="' . $row->FAKTUR_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1');
            if ($transaksi->num_rows() < 1) {
                $row->TRANSAKSI = array();
            } else {
                $row->TRANSAKSI = $transaksi->result();
            }
        }
        return $hasil;
    }

    public function surat_jalan_list($id)
    {
        $hasil = $this->db->query('SELECT * FROM 
                                    FAKTUR_SURAT_JALAN AS FSJ
                                    LEFT JOIN SURAT_JALAN AS SJ
                                    ON FSJ.SURAT_JALAN_ID=SJ.SURAT_JALAN_ID
                                     WHERE FSJ.FAKTUR_ID="' . $id . '" 
                                     AND FSJ.RECORD_STATUS="AKTIF" 
                                     AND FSJ.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                     AND SJ.RECORD_STATUS="AKTIF" 
                                     AND SJ.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        return $hasil;
    }
    public function barang_list($id, $relasi)
    {
        $hasil = $this->db->query('SELECT * FROM 
                                    FAKTUR_BARANG AS FB
                                    LEFT JOIN MASTER_BARANG AS B
                                    ON FB.MASTER_BARANG_ID=B.MASTER_BARANG_ID 
                                     WHERE FB.FAKTUR_ID="' . $id . '" 
                                     AND FB.RECORD_STATUS="AKTIF" 
                                     AND FB.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                     AND B.RECORD_STATUS="AKTIF" 
                                     AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        foreach ($hasil as $row) {
            $harga = $this->db->query('SELECT * FROM MASTER_HARGA WHERE MASTER_RELASI_ID="' . $relasi . '" AND MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
            $row->HARGA = $harga;
        }
        return $hasil;
    }

    public function surat_jalan($relasi)
    {
        $hasil = $this->db->query('SELECT * FROM 
        SURAT_JALAN
        WHERE MASTER_RELASI_ID="' . $relasi . '" AND SURAT_JALAN_STATUS="open" AND SURAT_JALAN_JENIS="penjualan" AND SURAT_JALAN_REALISASI_STATUS="selesai" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        return $hasil;
    }

    public function add_surat_jalan()
    {
        $data = array(
            'FAKTUR_SURAT_JALAN_ID' => create_id(),
            'FAKTUR_ID' => $this->input->post('id'),
            'SURAT_JALAN_ID' => $this->input->post('surat_jalan'),

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->insert('FAKTUR_SURAT_JALAN', $data);

        $hasil = $this->db->query('SELECT * FROM 
        SURAT_JALAN_BARANG
        WHERE SURAT_JALAN_ID="' . $this->input->post('surat_jalan') . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        foreach ($hasil as $row) {
            $data = array(
                'FAKTUR_BARANG_ID' => create_id(),
                'FAKTUR_ID' => $this->input->post('id'),
                'SURAT_JALAN_ID' => $this->input->post('surat_jalan'),
                'MASTER_BARANG_ID' => $row->MASTER_BARANG_ID,
                'FAKTUR_BARANG_JENIS' => $row->SURAT_JALAN_BARANG_JENIS,
                'FAKTUR_BARANG_QUANTITY' => $row->SURAT_JALAN_BARANG_QUANTITY,
                'FAKTUR_BARANG_SATUAN' => $row->SURAT_JALAN_BARANG_SATUAN,

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->insert('FAKTUR_BARANG', $data);
        }
        return true;
    }
}
