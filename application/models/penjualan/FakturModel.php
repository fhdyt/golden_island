<?php
class FakturModel extends CI_Model
{

    public function list()
    {
        $tanggal_dari = $this->input->post("tanggal_dari");
        $tanggal_sampai = $this->input->post("tanggal_sampai");
        $tanggal = 'FAKTUR_TANGGAL BETWEEN "' . $tanggal_dari . '" AND "' . $tanggal_sampai . '" AND';

        $hasil = $this->db->query('SELECT * FROM FAKTUR WHERE ' . $tanggal . ' RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY FAKTUR_NOMOR DESC ')->result();
        foreach ($hasil as $row) {
            $relasi = $this->db->query('SELECT * FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            $row->TRANSAKSI = $this->db->query('SELECT * FROM FAKTUR_TRANSAKSI WHERE FAKTUR_ID="' . $row->FAKTUR_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            $row->TANGGAL = tanggal($row->FAKTUR_TANGGAL);
            $row->RELASI = $relasi;
        }
        return $hasil;
    }

    public function surat_jalan_baru()
    {
        $hasil = $this->db->query('SELECT * FROM 
        SURAT_JALAN
        WHERE SURAT_JALAN_STATUS="open" AND SURAT_JALAN_JENIS="penjualan" AND SURAT_JALAN_REALISASI_STATUS="selesai" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY SURAT_JALAN_TANGGAL DESC, SURAT_JALAN_NOMOR DESC')->result();
        foreach ($hasil as $row) {
            $relasi = $this->db->query('SELECT * FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            $row->TANGGAL = tanggal($row->SURAT_JALAN_TANGGAL);
            $oleh = $this->db->query('SELECT * FROM USER WHERE USER_ID="' . $row->ENTRI_USER . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
            $row->RELASI = $relasi;
            $row->OLEH = $oleh;
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

        $data_edit_jaminan = array(
            'RECORD_STATUS' => "AKTIF",
        );
        $this->db->where('FAKTUR_JAMINAN_REF', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'DRAFT');
        $this->db->update('FAKTUR_JAMINAN', $data_edit_jaminan);

        $data_edit_aktif = array(
            'EDIT_WAKTU' => date("Y-m-d G:i:s"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );
        $this->db->where('FAKTUR_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('FAKTUR', $data_edit_aktif);

        $data_edit_transaksi = array(
            'EDIT_WAKTU' => date("Y-m-d G:i:s"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );
        $this->db->where('FAKTUR_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('FAKTUR_TRANSAKSI', $data_edit_transaksi);

        $data_edit_piutang = array(
            'EDIT_WAKTU' => date("Y-m-d G:i:s"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );
        $this->db->where('PIUTANG_REF', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('PIUTANG', $data_edit_piutang);

        $data_edit_buku_besar = array(
            'EDIT_WAKTU' => date("Y-m-d G:i:s"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );
        $this->db->where('BUKU_BESAR_REF', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('BUKU_BESAR', $data_edit_buku_besar);

        if ($this->input->post('nomor_faktur') == "") {
            $nomor_faktur = nomor_faktur($this->input->post('tanggal'));
        } else {
            $nomor_faktur = $this->input->post('nomor_faktur');
        }

        // $hasil = $this->db->query('SELECT * FROM 
        //                             FAKTUR_BARANG 
        //                              WHERE FAKTUR_ID="' . $this->input->post('id') . '" 
        //                              AND RECORD_STATUS="AKTIF" 
        //                              AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        $barang = $this->db->query('SELECT * FROM 
                                    FAKTUR_BARANG AS FB
                                    LEFT JOIN MASTER_BARANG AS B
                                    ON FB.MASTER_BARANG_ID=B.MASTER_BARANG_ID 
                                     WHERE FB.FAKTUR_ID="' . $this->input->post('id') . '" 
                                     AND FB.RECORD_STATUS="AKTIF" 
                                     AND FB.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                     AND B.RECORD_STATUS="AKTIF" 
                                     AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();

        foreach ($barang as $row) {
            if ($row->FAKTUR_BARANG_HARGA < 1) {
                $harga = $this->db->query('SELECT * FROM MASTER_HARGA WHERE MASTER_RELASI_ID="' . $this->input->post('relasi') . '" AND MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1');

                if ($harga->num_rows() == 0) {
                    $harga_faktur = $row->MASTER_BARANG_HARGA_SATUAN;
                } else {
                    $harga_satuan = $harga->result();
                    $harga_faktur = $harga_satuan[0]->MASTER_HARGA_HARGA;
                }

                $harga_relasi = array(
                    'FAKTUR_BARANG_HARGA' => $harga_faktur,
                );
                $this->db->where('FAKTUR_ID', $this->input->post('id'));
                $this->db->where('MASTER_BARANG_ID', $row->MASTER_BARANG_ID);
                $this->db->where('RECORD_STATUS', 'AKTIF');
                $this->db->update('FAKTUR_BARANG', $harga_relasi);
            }
        }

        if (str_replace(".", "", $this->input->post('sisa_bayar')) > 0) {
            $data_piutang = array(
                'PIUTANG_REF' => $this->input->post('id'),
                'PIUTANG_ID' => create_id(),
                'AKUN_ID' => $this->input->post('akun'),
                'MASTER_RELASI_ID' => $this->input->post('relasi'),
                'PIUTANG_TANGGAL' => $this->input->post('tanggal'),
                'PIUTANG_TANGGAL_TEMPO' => $this->input->post('tanggal_tempo'),
                'PIUTANG_KREDIT' => "",
                'PIUTANG_DEBET' => str_replace(".", "", $this->input->post('sisa_bayar')),
                'PIUTANG_SUMBER' => "PENJUALAN",
                'PIUTANG_KETERANGAN' => "PIUTANG " . $nomor_faktur,
                'MASTER_RELASI_ID' => $this->input->post('relasi'),


                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->insert('PIUTANG', $data_piutang);
        }

        $relasi = $this->db->query('SELECT * FROM 
        MASTER_RELASI
        WHERE MASTER_RELASI_ID="' . $this->input->post('relasi') . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();

        $data_buku_besar = array(
            'BUKU_BESAR_ID' => create_id(),
            'BUKU_BESAR_REF' => $this->input->post('id'),
            'AKUN_ID' => $this->input->post('akun'),
            'BUKU_BESAR_TANGGAL' => $this->input->post('tanggal'),
            'BUKU_BESAR_KREDIT' => "0",
            'BUKU_BESAR_DEBET' => str_replace(".", "", $this->input->post('bayar')),
            'BUKU_BESAR_SUMBER' => "PENJUALAN",
            'BUKU_BESAR_KETERANGAN' => "PENJUALAN " . $nomor_faktur . " <br>(" . $relasi[0]->MASTER_RELASI_NAMA . ")",

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->insert('BUKU_BESAR', $data_buku_besar);

        if (str_replace(".", "", $this->input->post('total_jaminan')) > 0) {
            $faktur_jaminan = $this->db->query('SELECT * FROM 
        FAKTUR_JAMINAN
        WHERE FAKTUR_JAMINAN_REF="' . $this->input->post('id') . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            foreach ($faktur_jaminan as $row) {
                $data_buku_besar = array(
                    'BUKU_BESAR_ID' => create_id(),
                    'BUKU_BESAR_REF' => $this->input->post('id'),
                    'AKUN_ID' => $this->input->post('akun'),
                    'BUKU_BESAR_TANGGAL' => $this->input->post('tanggal'),
                    'BUKU_BESAR_KREDIT' => "0",
                    'BUKU_BESAR_DEBET' => str_replace(".", "", $row->FAKTUR_JAMINAN_TOTAL_RUPIAH),
                    'BUKU_BESAR_SUMBER' => "JAMINAN",
                    'BUKU_BESAR_JENIS_PENGELUARAN' => "Jaminan",
                    'BUKU_BESAR_KETERANGAN' => "JAMINAN NO." . $row->FAKTUR_JAMINAN_NOMOR . " <br>(" . $relasi[0]->MASTER_RELASI_NAMA . ")",

                    'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                    'ENTRI_USER' => $this->session->userdata('USER_ID'),
                    'RECORD_STATUS' => "AKTIF",
                    'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
                );

                $this->db->insert('BUKU_BESAR', $data_buku_besar);
            }
        }

        $data = array(
            'FAKTUR_ID' => $this->input->post('id'),
            'FAKTUR_NOMOR' => $nomor_faktur,
            'FAKTUR_TANGGAL' => $this->input->post('tanggal'),
            'FAKTUR_KETERANGAN' => $this->input->post('keterangan'),
            'MASTER_RELASI_ID' => $this->input->post('relasi'),
            'AKUN_ID' => $this->input->post('akun'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
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
            'FAKTUR_TRANSAKSI_POTONGAN' => str_replace(".", "", $this->input->post('potongan')),
            'PIUTANG_TANGGAL_TEMPO' => $this->input->post('tanggal_tempo'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $data_transaksi = $this->db->insert('FAKTUR_TRANSAKSI', $data_transaksi);
        //send_telegram("Penjualan (" . $this->session->userdata('PERUSAHAAN_KODE') . ")\nKredit : 0\nDebet : " . $this->input->post('bayar') . "\nTanggal : " . tanggal($this->input->post('tanggal')) . "\nKeterangan : PENJUALAN RELASI " . $relasi[0]->MASTER_RELASI_NAMA . "");
        return $data_transaksi;
    }

    public function add_sj_scan()
    {
        $surat_jalan = $this->db->query('SELECT * FROM 
        SURAT_JALAN
        WHERE SURAT_JALAN_NOMOR="' . $this->input->post('surat_jalan_nomor') . '" AND SURAT_JALAN_STATUS="open" AND SURAT_JALAN_JENIS="penjualan" AND SURAT_JALAN_REALISASI_STATUS="selesai" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        if (empty($surat_jalan)) {
            $faktur_id = "error";
        } else {
            $nomor_faktur = nomor_faktur(date("Y-m-d"));
            $faktur_id = create_id();
            $data_surat_jalan = array(
                'SURAT_JALAN_STATUS' => "close",
            );

            $this->db->where('SURAT_JALAN_ID', $surat_jalan[0]->SURAT_JALAN_ID);
            $this->db->update('SURAT_JALAN', $data_surat_jalan);

            $data = array(
                'FAKTUR_SURAT_JALAN_ID' => create_id(),
                'FAKTUR_ID' => $faktur_id,
                'SURAT_JALAN_ID' => $surat_jalan[0]->SURAT_JALAN_ID,

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->insert('FAKTUR_SURAT_JALAN', $data);

            $hasil = $this->db->query('SELECT * FROM 
            SURAT_JALAN_BARANG
            WHERE SURAT_JALAN_ID="' . $surat_jalan[0]->SURAT_JALAN_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            foreach ($hasil as $row) {
                $data = array(
                    'FAKTUR_BARANG_ID' => create_id(),
                    'FAKTUR_ID' => $faktur_id,
                    'SURAT_JALAN_ID' => $surat_jalan[0]->SURAT_JALAN_ID,
                    'MASTER_BARANG_ID' => $row->MASTER_BARANG_ID,
                    'FAKTUR_BARANG_JENIS' => $row->SURAT_JALAN_BARANG_JENIS,
                    'FAKTUR_BARANG_QUANTITY' => $row->SURAT_JALAN_BARANG_QUANTITY - $row->SURAT_JALAN_BARANG_QUANTITY_KLAIM,
                    'FAKTUR_BARANG_SATUAN' => $row->SURAT_JALAN_BARANG_SATUAN,

                    'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                    'ENTRI_USER' => $this->session->userdata('USER_ID'),
                    'RECORD_STATUS' => "AKTIF",
                    'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
                );

                $this->db->insert('FAKTUR_BARANG', $data);

                $jaminan = $this->db->query('SELECT * FROM SURAT_JALAN WHERE SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"  ')->result();
                if ($jaminan[0]->SURAT_JALAN_JAMINAN == 'Yes') {
                    $nomor_jaminan = nomor_jaminan($this->input->post('tanggal'));
                    $harga_dasar = $this->db->query('SELECT * FROM MASTER_BARANG WHERE MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1');
                    $harga = $this->db->query('SELECT * FROM MASTER_HARGA WHERE MASTER_RELASI_ID="' . $jaminan[0]->MASTER_RELASI_ID . '" AND MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1');
                    if ($harga->num_rows() == 0) {
                        $harga_dasar_jaminan = $harga_dasar->result();
                        $harga_jaminan = $harga_dasar_jaminan[0]->MASTER_BARANG_HARGA_JAMINAN;
                    } else {
                        $harga_satuan = $harga->result();
                        $harga_jaminan = $harga_satuan[0]->MASTER_HARGA_JAMINAN;
                    }
                    $data = array(
                        'FAKTUR_JAMINAN_ID' => create_id(),
                        'MASTER_RELASI_ID' => $jaminan[0]->MASTER_RELASI_ID,
                        'AKUN_ID' => $this->input->post('akun'),
                        'FAKTUR_JAMINAN_NOMOR' => $nomor_jaminan,
                        'SURAT_JALAN_ID' => $jaminan[0]->SURAT_JALAN_ID,
                        'FAKTUR_JAMINAN_TANGGAL' => $this->input->post('tanggal'),
                        'FAKTUR_JAMINAN_KETERANGAN' => "JAMINAN NO. " . $nomor_jaminan . "",
                        'FAKTUR_JAMINAN_JUMLAH'   => $row->SURAT_JALAN_BARANG_QUANTITY - $row->SURAT_JALAN_BARANG_QUANTITY_KLAIM,
                        'FAKTUR_JAMINAN_HARGA' => $harga_jaminan,
                        'FAKTUR_JAMINAN_TOTAL_RUPIAH' => ($row->SURAT_JALAN_BARANG_QUANTITY - $row->SURAT_JALAN_BARANG_QUANTITY_KLAIM) * $harga_jaminan,
                        'FAKTUR_JAMINAN_REF' => $faktur_id,

                        'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                        'ENTRI_USER' => $this->session->userdata('USER_ID'),
                        'RECORD_STATUS' => "DRAFT",
                        'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
                    );
                    $this->db->insert('FAKTUR_JAMINAN', $data);
                }
            }

            $data = array(
                'FAKTUR_ID' => $faktur_id,
                'FAKTUR_NOMOR' => $nomor_faktur,
                'FAKTUR_TANGGAL' => date("Y-m-d"),
                'FAKTUR_KETERANGAN' => "",
                'MASTER_RELASI_ID' => $surat_jalan[0]->MASTER_RELASI_ID,
                'AKUN_ID' => '',

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->insert('FAKTUR', $data);
        }
        return $faktur_id;
    }
    public function hapus($id)
    {
        $hasil = $this->db->query('SELECT * FROM 
        FAKTUR_SURAT_JALAN
        WHERE FAKTUR_SURAT_JALAN_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();

        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('FAKTUR_SURAT_JALAN_ID', $id);
        $this->db->update('FAKTUR_SURAT_JALAN', $data);

        $data_barang = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('SURAT_JALAN_ID', $hasil[0]->SURAT_JALAN_ID);
        $this->db->update('FAKTUR_BARANG', $data_barang);

        $data_jaminan = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('SURAT_JALAN_ID', $hasil[0]->SURAT_JALAN_ID);
        $this->db->update('FAKTUR_JAMINAN', $data_jaminan);

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
            $harga = $this->db->query('SELECT * FROM MASTER_HARGA WHERE MASTER_RELASI_ID="' . $relasi . '" AND MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1');
            if ($harga->num_rows() == 0) {
                $row->HARGA = $row->MASTER_BARANG_HARGA_SATUAN;
            } else {
                $harga_satuan = $harga->result();
                $row->HARGA = $harga_satuan[0]->MASTER_HARGA_HARGA;
            }
        }
        return $hasil;
    }

    public function jaminan_list($id, $relasi)
    {
        $hasil = $this->db->query('SELECT * FROM 
                                    FAKTUR_JAMINAN
                                     WHERE FAKTUR_JAMINAN_REF="' . $id . '" 
                                     AND (RECORD_STATUS="AKTIF" OR RECORD_STATUS="DRAFT") 
                                     AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        foreach ($hasil as $row) {
            $surat_jalan = $this->db->query('SELECT * FROM SURAT_JALAN WHERE SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
            $row->SURAT_JALAN_NOMOR  = $surat_jalan[0]->SURAT_JALAN_NOMOR;
        }
        return $hasil;
    }
    public function edit_harga_jaminan()
    {
        $data_barang = array(
            'FAKTUR_JAMINAN_HARGA' => str_replace(".", "", $this->input->post('harga')),
            'FAKTUR_JAMINAN_TOTAL_RUPIAH' => str_replace(".", "", $this->input->post('harga')) * $this->input->post('jumlah'),
        );

        $this->db->where('FAKTUR_JAMINAN_ID', $this->input->post('id'));
        $result = $this->db->update('FAKTUR_JAMINAN', $data_barang);
    }

    public function edit_harga_barang()
    {
        $hasil = $this->db->query('SELECT * FROM 
        FAKTUR_BARANG
        WHERE FAKTUR_BARANG_ID="' . $this->input->post('id') . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        $cek = $this->db->query('SELECT * FROM MASTER_HARGA WHERE MASTER_RELASI_ID="' . $this->input->post('relasi') . '" AND MASTER_BARANG_ID="' . $hasil[0]->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"');
        if ($cek->num_rows() == 0) {
            $data = array(
                'MASTER_HARGA_ID' => create_id(),
                'MASTER_RELASI_ID' => $this->input->post('relasi'),
                'MASTER_BARANG_ID' => $hasil[0]->MASTER_BARANG_ID,
                'MASTER_HARGA_HARGA' => str_replace(".", "", $this->input->post('harga')),
                'MASTER_HARGA_JAMINAN' => "0",

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->insert('MASTER_HARGA', $data);
        } else {
            $harga = $cek->result();
            $data_delete = array(
                'DELETE_WAKTU' => date("Y-m-d G:i:s"),
                'DELETE_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "DELETE",
            );

            $this->db->where('MASTER_HARGA_ID', $harga[0]->MASTER_HARGA_ID);
            $this->db->update('MASTER_HARGA', $data_delete);

            $data = array(
                'MASTER_HARGA_ID' => create_id(),
                'MASTER_RELASI_ID' => $this->input->post('relasi'),
                'MASTER_BARANG_ID' => $hasil[0]->MASTER_BARANG_ID,
                'MASTER_HARGA_HARGA' => str_replace(".", "", $this->input->post('harga')),
                'MASTER_HARGA_JAMINAN' => "0",

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->insert('MASTER_HARGA', $data);
        }
        $data_barang = array(
            'FAKTUR_BARANG_HARGA' => str_replace(".", "", $this->input->post('harga')),
            //         'FAKTUR_JAMINAN_TOTAL_RUPIAH' => str_replace(".", "", $this->input->post('harga')) * $this->input->post('jumlah'),
        );

        $this->db->where('FAKTUR_BARANG_ID', $this->input->post('id'));
        $result = $this->db->update('FAKTUR_BARANG', $data_barang);
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

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
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
                'FAKTUR_BARANG_QUANTITY' => $row->SURAT_JALAN_BARANG_QUANTITY - $row->SURAT_JALAN_BARANG_QUANTITY_KLAIM,
                'FAKTUR_BARANG_SATUAN' => $row->SURAT_JALAN_BARANG_SATUAN,

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );
            $this->db->insert('FAKTUR_BARANG', $data);

            $jaminan = $this->db->query('SELECT * FROM SURAT_JALAN WHERE SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"  ')->result();
            if ($jaminan[0]->SURAT_JALAN_JAMINAN == 'Yes') {
                $nomor_jaminan = nomor_jaminan($this->input->post('tanggal'));
                $harga_dasar = $this->db->query('SELECT * FROM MASTER_BARANG WHERE MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1');
                $harga = $this->db->query('SELECT * FROM MASTER_HARGA WHERE MASTER_RELASI_ID="' . $jaminan[0]->MASTER_RELASI_ID . '" AND MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1');
                if ($harga->num_rows() == 0) {
                    $harga_dasar_jaminan = $harga_dasar->result();
                    $harga_jaminan = $harga_dasar_jaminan[0]->MASTER_BARANG_HARGA_JAMINAN;
                } else {
                    $harga_satuan = $harga->result();
                    $harga_jaminan = $harga_satuan[0]->MASTER_HARGA_JAMINAN;
                }
                $data = array(
                    'FAKTUR_JAMINAN_ID' => create_id(),
                    'MASTER_RELASI_ID' => $jaminan[0]->MASTER_RELASI_ID,
                    'AKUN_ID' => $this->input->post('akun'),
                    'FAKTUR_JAMINAN_NOMOR' => $nomor_jaminan,
                    'SURAT_JALAN_ID' => $jaminan[0]->SURAT_JALAN_ID,
                    'FAKTUR_JAMINAN_TANGGAL' => $this->input->post('tanggal'),
                    'FAKTUR_JAMINAN_KETERANGAN' => "JAMINAN NO. " . $nomor_jaminan . "",
                    'FAKTUR_JAMINAN_JUMLAH'   => $row->SURAT_JALAN_BARANG_QUANTITY - $row->SURAT_JALAN_BARANG_QUANTITY_KLAIM,
                    'FAKTUR_JAMINAN_HARGA' => $harga_jaminan,
                    'FAKTUR_JAMINAN_TOTAL_RUPIAH' => ($row->SURAT_JALAN_BARANG_QUANTITY - $row->SURAT_JALAN_BARANG_QUANTITY_KLAIM) * $harga_jaminan,
                    'FAKTUR_JAMINAN_REF' => $this->input->post('id'),

                    'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                    'ENTRI_USER' => $this->session->userdata('USER_ID'),
                    'RECORD_STATUS' => "DRAFT",
                    'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
                );
                $this->db->insert('FAKTUR_JAMINAN', $data);
            }
        }

        return true;
    }

    public function add_surat_jalan_semua()
    {
        $surat_jalan = $this->db->query('SELECT * FROM 
        SURAT_JALAN
        WHERE MASTER_RELASI_ID="' . $this->input->post('relasi') . '" AND SURAT_JALAN_STATUS="open" AND SURAT_JALAN_JENIS="penjualan" AND SURAT_JALAN_REALISASI_STATUS="selesai" AND 
        MONTH(SURAT_JALAN_TANGGAL) = ' . $this->input->post('bulan') . ' 
                                        AND YEAR(SURAT_JALAN_TANGGAL) = ' . $this->input->post('tahun') . ' 
                                    AND
        RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();

        foreach ($surat_jalan as $row_sj) {

            $data = array(
                'FAKTUR_SURAT_JALAN_ID' => create_id(),
                'FAKTUR_ID' => $this->input->post('id'),
                'SURAT_JALAN_ID' => $row_sj->SURAT_JALAN_ID,

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->insert('FAKTUR_SURAT_JALAN', $data);

            $hasil = $this->db->query('SELECT * FROM 
        SURAT_JALAN_BARANG
        WHERE SURAT_JALAN_ID="' . $row_sj->SURAT_JALAN_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            foreach ($hasil as $row) {
                $data = array(
                    'FAKTUR_BARANG_ID' => create_id(),
                    'FAKTUR_ID' => $this->input->post('id'),
                    'SURAT_JALAN_ID' => $row_sj->SURAT_JALAN_ID,
                    'MASTER_BARANG_ID' => $row->MASTER_BARANG_ID,
                    'FAKTUR_BARANG_JENIS' => $row->SURAT_JALAN_BARANG_JENIS,
                    'FAKTUR_BARANG_QUANTITY' => $row->SURAT_JALAN_BARANG_QUANTITY - $row->SURAT_JALAN_BARANG_QUANTITY_KLAIM,
                    'FAKTUR_BARANG_SATUAN' => $row->SURAT_JALAN_BARANG_SATUAN,

                    'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                    'ENTRI_USER' => $this->session->userdata('USER_ID'),
                    'RECORD_STATUS' => "AKTIF",
                    'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
                );

                $this->db->insert('FAKTUR_BARANG', $data);

                $jaminan = $this->db->query('SELECT * FROM SURAT_JALAN WHERE SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"  ')->result();
                if ($jaminan[0]->SURAT_JALAN_JAMINAN == 'Yes') {
                    $nomor_jaminan = nomor_jaminan($jaminan[0]->SURAT_JALAN_TANGGAL);
                    $harga_dasar = $this->db->query('SELECT * FROM MASTER_BARANG WHERE MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1');
                    $harga = $this->db->query('SELECT * FROM MASTER_HARGA WHERE MASTER_RELASI_ID="' . $jaminan[0]->MASTER_RELASI_ID . '" AND MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1');
                    if ($harga->num_rows() == 0) {
                        $harga_dasar_jaminan = $harga_dasar->result();
                        $harga_jaminan = $harga_dasar_jaminan[0]->MASTER_BARANG_HARGA_JAMINAN;
                    } else {
                        $harga_satuan = $harga->result();
                        $harga_jaminan = $harga_satuan[0]->MASTER_HARGA_JAMINAN;
                    }
                    $data = array(
                        'FAKTUR_JAMINAN_ID' => create_id(),
                        'MASTER_RELASI_ID' => $jaminan[0]->MASTER_RELASI_ID,
                        'AKUN_ID' => $this->input->post('akun'),
                        'FAKTUR_JAMINAN_NOMOR' => $nomor_jaminan,
                        'SURAT_JALAN_ID' => $jaminan[0]->SURAT_JALAN_ID,
                        'FAKTUR_JAMINAN_TANGGAL' => $jaminan[0]->SURAT_JALAN_TANGGAL,
                        'FAKTUR_JAMINAN_KETERANGAN' => "JAMINAN NO. " . $nomor_jaminan . "",
                        'FAKTUR_JAMINAN_JUMLAH' => $row->SURAT_JALAN_BARANG_QUANTITY - $row->SURAT_JALAN_BARANG_QUANTITY_KLAIM,
                        'FAKTUR_JAMINAN_HARGA' => $harga_jaminan,
                        'FAKTUR_JAMINAN_TOTAL_RUPIAH' => ($row->SURAT_JALAN_BARANG_QUANTITY - $row->SURAT_JALAN_BARANG_QUANTITY_KLAIM) * $harga_jaminan,
                        'FAKTUR_JAMINAN_REF' => $this->input->post('id'),

                        'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                        'ENTRI_USER' => $this->session->userdata('USER_ID'),
                        'RECORD_STATUS' => "DRAFT",
                        'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
                    );
                    $this->db->insert('FAKTUR_JAMINAN', $data);
                }
            }
        }
        return true;
    }
}
