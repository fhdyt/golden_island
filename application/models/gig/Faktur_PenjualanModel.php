<?php
class Faktur_PenjualanModel extends CI_Model
{

    public function list()
    {
        if (empty($this->input->post("relasi"))) {
            $filter_relasi = "";
        } else {
            $filter_relasi = 'AND F.MASTER_RELASI_ID="' . $this->input->post("relasi") . '"';
        }
        if (empty($this->input->post("pembayaran"))) {
            $filter_pembayaran = "";
        } else if ($this->input->post("pembayaran") == "lunas") {
            $filter_pembayaran = 'AND T.FAKTUR_TRANSAKSI_GRAND_TOTAL=T.PEMBELIAN_TRANSAKSI_BAYAR';
        } else if ($this->input->post("pembayaran") == "hutang") {
            $filter_pembayaran = 'AND T.FAKTUR_TRANSAKSI_GRAND_TOTAL>T.PEMBELIAN_TRANSAKSI_BAYAR';
        } else if ($this->input->post("pembayaran") == "gratis") {
            $filter_pembayaran = 'AND T.FAKTUR_TRANSAKSI_GRAND_TOTAL=T.FAKTUR_TRANSAKSI_POTONGAN';
        }

        $tanggal_dari = $this->input->post("tanggal_dari");
        $tanggal_sampai = $this->input->post("tanggal_sampai");
        $tanggal = 'F.FAKTUR_TANGGAL BETWEEN "' . $tanggal_dari . '" AND "' . $tanggal_sampai . '"';

        $hasil = $this->db->query('SELECT * FROM FAKTUR AS F
        LEFT JOIN FAKTUR_TRANSAKSI AS T
        ON F.FAKTUR_ID=T.FAKTUR_ID
                                     WHERE ' . $tanggal . ' 
                                     ' . $filter_relasi . '
                                     ' . $filter_pembayaran . '
                                     AND F.RECORD_STATUS="AKTIF" AND F.PERUSAHAAN_KODE="' . $this->input->post("perusahaan") . '" 
                                     AND T.RECORD_STATUS="AKTIF" AND T.PERUSAHAAN_KODE="' . $this->input->post("perusahaan") . '" 
                                     ORDER BY F.FAKTUR_NOMOR DESC ')->result();
        foreach ($hasil as $row) {
            $row->SURAT_JALAN = $this->db->query('SELECT * FROM 
                                SURAT_JALAN AS SJ LEFT JOIN FAKTUR_SURAT_JALAN AS F
                                ON SJ.SURAT_JALAN_ID=F.SURAT_JALAN_ID
                                WHERE F.FAKTUR_ID="' . $row->FAKTUR_ID . '" 
                                AND SJ.RECORD_STATUS="AKTIF" AND SJ.PERUSAHAAN_KODE="' . $this->input->post("perusahaan") . '"
                                AND F.RECORD_STATUS="AKTIF" AND F.PERUSAHAAN_KODE="' . $this->input->post("perusahaan") . '"
                                ORDER BY SURAT_JALAN_NOMOR ASC')->result();
            foreach ($row->SURAT_JALAN as $sj) {
                $sj->TANGGAL = tanggal($sj->SURAT_JALAN_TANGGAL);
            }
            $relasi = $this->db->query('SELECT * FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->input->post("perusahaan") . '"')->result();
            $row->TRANSAKSI = $this->db->query('SELECT * FROM FAKTUR_TRANSAKSI WHERE FAKTUR_ID="' . $row->FAKTUR_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->input->post("perusahaan") . '"')->result();
            $row->TANGGAL = tanggal($row->FAKTUR_TANGGAL);
            $row->RELASI = $relasi;
        }
        return $hasil;
    }

    public function list_barang($id)
    {
        $hasil = $this->db->query('SELECT * 
                                        FROM PRODUKSI_BARANG AS P
                                        LEFT JOIN MASTER_BARANG AS B
                                        ON P.MASTER_BARANG_ID=B.MASTER_BARANG_ID
                                        WHERE 
                                        P.PRODUKSI_ID="' . $id . '"
                                        AND (P.RECORD_STATUS="AKTIF"  OR P.RECORD_STATUS="DRAFT")
                                        AND P.PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" 
                                        AND B.RECORD_STATUS="AKTIF" 
                                        AND B.PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" 
                                        ORDER BY P.PRODUKSI_BARANG_INDEX DESC ')->result();
        return $hasil;
    }

    public function jenis_barang($id)
    {
        $hasil = $this->db->query('SELECT * 
                                       FROM MASTER_BARANG 
                                        WHERE 
                                        MASTER_BARANG_BAHAN="' . $id . '"
                                        AND RECORD_STATUS="AKTIF"
                                        AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '"')->result();
        return $hasil;
    }

    public function kapasitas_tangki($id)
    {
        $hasil = $this->db->query('SELECT * 
                                       FROM MASTER_TANGKI 
                                        WHERE 
                                        MASTER_TANGKI_ID="' . $id . '"
                                        AND RECORD_STATUS="AKTIF"
                                        AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '"')->result();
        foreach ($hasil as $row) {
            $kapasitas = $this->db->query('SELECT SUM(RIWAYAT_TANGKI_KAPASITAS_MASUK) AS MASUK,SUM(RIWAYAT_TANGKI_KAPASITAS_KELUAR) AS KELUAR FROM RIWAYAT_TANGKI
            WHERE MASTER_TANGKI_ID="' . $row->MASTER_TANGKI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '"');
            if ($kapasitas->num_rows() == 0) {
                $row->KAPASITAS = array();
            } else {
                $hasil_kapasitas =  $kapasitas->result();
                $row->KAPASITAS_MASUK = $hasil_kapasitas[0]->MASUK;
                $row->KAPASITAS_KELUAR = $hasil_kapasitas[0]->KELUAR;
                $row->TOTAL = $row->KAPASITAS_MASUK - $row->KAPASITAS_KELUAR;
            }
        }
        return $hasil;
    }

    public function list_karyawan($id)
    {
        $hasil = $this->db->query('SELECT * 
                                        FROM PRODUKSI_KARYAWAN AS P
                                        LEFT JOIN MASTER_KARYAWAN AS K
                                        ON P.MASTER_KARYAWAN_ID=K.MASTER_KARYAWAN_ID
                                        WHERE 
                                        P.PRODUKSI_ID="' . $id . '"
                                        AND (P.RECORD_STATUS="AKTIF"  OR P.RECORD_STATUS="DRAFT")
                                        AND P.PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" 
                                        AND K.RECORD_STATUS="AKTIF" 
                                        AND K.PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" 
                                        ORDER BY P.PRODUKSI_KARYAWAN_INDEX DESC ')->result();
        return $hasil;
    }

    public function add($config)
    {

        $data_edit = array(
            'EDIT_WAKTU' => date("Y-m-d G:i:s"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->input->post('perusahaan'),
        );

        $this->db->where('PRODUKSI_ID', $this->input->post('id'));
        $this->db->update('PRODUKSI', $data_edit);

        $data = array(
            'PRODUKSI_ID' => $this->input->post('id'),
            'PRODUKSI_NOMOR' => nomor_produksi($this->input->post('tanggal')),
            'PRODUKSI_TANGGAL' => $this->input->post('tanggal'),
            'MASTER_BARANG_ID' => $this->input->post('jenis'),
            'PRODUKSI_LEVEL_AWAL' => $this->input->post('level_awal'),
            'PRODUKSI_LEVEL_AWAL_FILE' => $config['file_name'],

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->input->post('perusahaan'),
        );

        $result = $this->db->insert('PRODUKSI', $data);
        return $result;
    }

    public function add_selesai($config)
    {
        $data_edit = array(
            'EDIT_WAKTU' => date("Y-m-d G:i:s"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->input->post('perusahaan'),
        );

        $this->db->where('PRODUKSI_ID', $this->input->post('id'));
        $this->db->update('PRODUKSI', $data_edit);

        $data_edit_panggung = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->input->post('perusahaan'),
        );

        $this->db->where('PANGGUNG_REF', $this->input->post('id'));
        $this->db->update('PANGGUNG', $data_edit_panggung);

        $data_edit_barang = array(
            'RECORD_STATUS' => "AKTIF",
        );
        $this->db->where('PRODUKSI_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'DRAFT');
        $this->db->update('PRODUKSI_BARANG', $data_edit_barang);

        $data_edit_karyawan = array(
            'RECORD_STATUS' => "AKTIF",
        );
        $this->db->where('PRODUKSI_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'DRAFT');
        $this->db->update('PRODUKSI_KARYAWAN', $data_edit_karyawan);


        if ($this->input->post('nomor_produksi') == "") {
            $nomor_produksi = nomor_produksi($this->input->post('tanggal'));
        } else {
            $nomor_produksi = $this->input->post('nomor_produksi');
        }

        $data_edit_riwayat = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->input->post('perusahaan'),
        );

        $this->db->where('RIWAYAT_TANGKI_REF', $this->input->post('id'));
        $this->db->update('RIWAYAT_TANGKI', $data_edit_riwayat);

        $data_riwayat = array(
            'RIWAYAT_TANGKI_ID' => create_id(),
            'MASTER_TANGKI_ID' => $this->input->post('master_tangki'),
            'RIWAYAT_TANGKI_TANGGAL' => date("Y-m-d"),
            'RIWAYAT_TANGKI_KAPASITAS_MASUK' => "0",
            'RIWAYAT_TANGKI_KAPASITAS_KELUAR' => $this->input->post('level_awal') - $this->input->post('level_akhir'),
            'RIWAYAT_TANGKI_KETERANGAN' => $nomor_produksi,
            'RIWAYAT_TANGKI_REF' => $this->input->post('id'),


            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->input->post('perusahaan'),
        );
        $this->db->insert('RIWAYAT_TANGKI', $data_riwayat);

        $data = array(
            'PRODUKSI_ID' => $this->input->post('id'),
            'PRODUKSI_NOMOR' => $nomor_produksi,
            'PRODUKSI_TANGGAL' => $this->input->post('tanggal'),
            'MASTER_BARANG_ID' => $this->input->post('jenis'),
            'MASTER_TANGKI_ID' => $this->input->post('master_tangki'),
            'PRODUKSI_LEVEL_AWAL' => $this->input->post('level_awal'),
            'PRODUKSI_LEVEL_AWAL_FILE' => $config['file_name_awal'],

            'PRODUKSI_KONVERSI_NILAI' => $this->input->post('konversi'),
            'PRODUKSI_LEVEL_AKHIR' => $this->input->post('level_akhir'),
            'PRODUKSI_LEVEL_AKHIR_FILE' => $config['file_name'],
            'PRODUKSI_LEVEL_TERPAKAI' => $this->input->post('terpakai'),
            'PRODUKSI_G_L' => $this->input->post('g_l'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->input->post('perusahaan'),
        );

        $this->db->insert('PRODUKSI', $data);

        // $data_edit = array(
        //     'PRODUKSI_KONVERSI_NILAI' => $this->input->post('konversi'),
        //     'PRODUKSI_LEVEL_AKHIR' => $this->input->post('level_akhir'),
        //     'PRODUKSI_LEVEL_AKHIR_FILE' => $config['file_name'],
        //     'PRODUKSI_LEVEL_TERPAKAI' => $this->input->post('terpakai'),
        //     'PRODUKSI_G_L' => $this->input->post('g_l'),
        // );

        // $this->db->where('PRODUKSI_ID', $this->input->post('id'));
        // $this->db->update('PRODUKSI', $data_edit);

        $barang = $this->db->query('SELECT * 
                                        FROM PRODUKSI_BARANG AS P
                                        LEFT JOIN MASTER_BARANG AS B
                                        ON P.MASTER_BARANG_ID=B.MASTER_BARANG_ID
                                        WHERE 
                                        P.PRODUKSI_ID="' . $this->input->post('id') . '"
                                        AND (P.RECORD_STATUS="AKTIF" OR P.RECORD_STATUS="DRAFT")
                                        AND P.PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" 
                                        AND B.RECORD_STATUS="AKTIF" 
                                        AND B.PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" 
                                        ORDER BY P.PRODUKSI_BARANG_INDEX DESC ')->result();
        foreach ($barang as $row) {
            $data_panggung_mp_out = array(
                'PANGGUNG_ID' => create_id(),
                'MASTER_BARANG_ID' => $row->MASTER_BARANG_ID,
                'PANGGUNG_TANGGAL' => $this->input->post("tanggal"),
                'PANGGUNG_STATUS' => "out",
                'PANGGUNG_STATUS_ISI' => 0,
                'PANGGUNG_JUMLAH' => $row->PRODUKSI_BARANG_TOTAL,
                'PANGGUNG_STATUS_KEPEMILIKAN' => $row->PRODUKSI_BARANG_KEPEMILIKAN,
                'PANGGUNG_KETERANGAN' => "" . $nomor_produksi . "",
                'PANGGUNG_REF'  => $this->input->post("id"),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->input->post('perusahaan'),
            );
            $this->db->insert('PANGGUNG', $data_panggung_mp_out);

            $data_panggung_mp = array(
                'PANGGUNG_ID' => create_id(),
                'MASTER_BARANG_ID' => $row->MASTER_BARANG_ID,
                'PANGGUNG_TANGGAL' => $this->input->post("tanggal"),
                'PANGGUNG_STATUS' => "in",
                'PANGGUNG_STATUS_ISI' => 1,
                'PANGGUNG_JUMLAH' => $row->PRODUKSI_BARANG_TOTAL,
                'PANGGUNG_STATUS_KEPEMILIKAN' => $row->PRODUKSI_BARANG_KEPEMILIKAN,
                'PANGGUNG_KETERANGAN' => "" . $nomor_produksi . "",
                'PANGGUNG_REF'  => $this->input->post("id"),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->input->post('perusahaan'),
            );
            $this->db->insert('PANGGUNG', $data_panggung_mp);
        }

        return true;
    }

    public function add_barang()
    {
        $data = array(
            'PRODUKSI_BARANG_ID' => create_id(),
            'PRODUKSI_ID' => $this->input->post('id'),
            'MASTER_BARANG_ID' => $this->input->post('barang'),
            'PRODUKSI_BARANG_TOTAL' => $this->input->post('total_barang'),
            'PRODUKSI_BARANG_KEPEMILIKAN' => $this->input->post('kepemilikan_barang'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DRAFT",
            'PERUSAHAAN_KODE' => $this->input->post('perusahaan'),
        );

        $result = $this->db->insert('PRODUKSI_BARANG', $data);
        return $result;
    }

    public function add_karyawan()
    {
        $data = array(
            'PRODUKSI_KARYAWAN_ID' => create_id(),
            'PRODUKSI_ID' => $this->input->post('id'),
            'MASTER_KARYAWAN_ID' => $this->input->post('karyawan_produksi'),
            'PRODUKSI_KARYAWAN_TOTAL' => $this->input->post('total_produksi'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DRAFT",
            'PERUSAHAAN_KODE' => $this->input->post('perusahaan'),
        );

        $result = $this->db->insert('PRODUKSI_KARYAWAN', $data);
        return $result;
    }

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->input->post('perusahaan'),
        );

        $this->db->where('PRODUKSI_BARANG_ID', $id);
        $result = $this->db->update('PRODUKSI_BARANG', $data);
        return $result;
    }

    public function hapus_karyawan($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->input->post('perusahaan'),
        );

        $this->db->where('PRODUKSI_KARYAWAN_ID', $id);
        $result = $this->db->update('PRODUKSI_KARYAWAN', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil['data'] = $this->db->query('SELECT * FROM PRODUKSI WHERE PRODUKSI_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" LIMIT 1')->result();
        foreach ($hasil['data'] as $row) {
            $row->TANGGAL = date("Y-m-d", strtotime($row->PRODUKSI_TANGGAL));
            $row->KONVERSI = $this->db->query('SELECT * FROM KONVERSI WHERE KONVERSI_DARI LIKE "%kg%" AND KONVERSI_KE LIKE "%m3%" AND RECORD_STATUS="AKTIF"
                                        AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '"')->result();
        }
        $hasil['terakhir'] = $this->db->query('SELECT * FROM PRODUKSI WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" ORDER BY PRODUKSI_TANGGAL DESC LIMIT 1')->result();
        return $hasil;
    }
}
