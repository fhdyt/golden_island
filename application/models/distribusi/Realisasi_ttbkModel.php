<?php
class Realisasi_ttbkModel extends CI_Model
{

    public function list_realisasi($surat_jalan_id)
    {
        $hasil = $this->db->query('SELECT * FROM SURAT_JALAN WHERE SURAT_JALAN_ID="' . $surat_jalan_id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY SURAT_JALAN_NOMOR DESC')->result();
        foreach ($hasil as $row) {
            $barang = $this->db->query('SELECT * FROM 
                                                SURAT_JALAN_BARANG AS SJ
                                                LEFT JOIN MASTER_BARANG AS B
                                                ON
                                                SJ.MASTER_BARANG_ID = B.MASTER_BARANG_ID 
                                                WHERE 
                                                SJ.SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" 
                                                AND SJ.RECORD_STATUS="AKTIF" 
                                                AND SJ.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                                AND B.RECORD_STATUS="AKTIF" 
                                                AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                                ')->result();
            foreach ($barang as $row_barang) {
                $row_barang->TOTAL = ($row_barang->SURAT_JALAN_BARANG_QUANTITY + $row_barang->SURAT_JALAN_BARANG_QUANTITY_KOSONG) - $row_barang->SURAT_JALAN_BARANG_QUANTITY_KLAIM;
            }
            $row->BARANG = $barang;

            if (empty($row->SURAT_JALAN_REALISASI_TTBK_TANGGAL) or $row->SURAT_JALAN_REALISASI_TTBK_TANGGAL == "0000-00-00 00:00:00") {
                $row->EXPIRED = "";
            } else {
                $tanggal_hari_ini = strtotime(date("Y-m-d G:i:s"));
                $tanggal_entri = strtotime($row->SURAT_JALAN_REALISASI_TTBK_TANGGAL);
                $timediff = $tanggal_hari_ini - $tanggal_entri;
                if ($timediff > 86400) {
                    $row->EXPIRED = "EXPIRED";
                } else {
                    $row->EXPIRED = "";
                }
            }


            $row->TANGGAL = tanggal($row->SURAT_JALAN_TANGGAL);
        }
        return $hasil;
    }

    public function jenis_tabung($jenis)
    {
        if ($jenis == "") {
            $filter = '';
        } else {
            $filter = 'AND MASTER_BARANG_ID="' . $jenis . '"';
        }
        $hasil = $this->db->query('SELECT * FROM MASTER_TABUNG WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ' . $filter . '')->result();
        return $hasil;
    }

    public function list()
    {
        $tanggal_dari = $this->input->post("tanggal_dari");
        $tanggal_sampai = $this->input->post("tanggal_sampai");



        if ($this->input->post("surat_jalan_nomor") == "") {
            $filter = 'AND SJ.SURAT_JALAN_TANGGAL BETWEEN "' . $tanggal_dari . '" AND "' . $tanggal_sampai . '"';
        } else {
            $filter = 'AND SJ.SURAT_JALAN_NOMOR LIKE "%' . $this->input->post("surat_jalan_nomor") . '%"';
        }
        $hasil = $this->db->query('SELECT * FROM SURAT_JALAN AS SJ 
                                    WHERE 
                                    SJ.RECORD_STATUS="AKTIF" 
                                    AND SJ.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                    ' . $filter . '
                                    ORDER BY SJ.SURAT_JALAN_NOMOR DESC')->result();
        foreach ($hasil as $row) {
            $driver = $this->db->query('SELECT * FROM MASTER_KARYAWAN WHERE MASTER_KARYAWAN_ID="' . $row->DRIVER_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"  LIMIT 1 ');
            if ($driver->num_rows() < 1) {
                $row->DRIVER = array();
            } else {
                $row->DRIVER = $driver->result();
            }
            $relasi = $this->db->query('SELECT * FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"  LIMIT 1 ')->result();
            $row->RELASI = $relasi;
            $supplier = $this->db->query('SELECT * FROM MASTER_SUPPLIER WHERE MASTER_SUPPLIER_ID="' . $row->MASTER_SUPPLIER_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"  LIMIT 1 ')->result();
            $row->SUPPLIER = $supplier;
            $row->TANGGAL = tanggal($row->SURAT_JALAN_TANGGAL);
        }
        return $hasil;
    }

    public function list_realisasi_tabung($surat_jalan_id)
    {
        $hasil['mp'] = $this->db->query('SELECT * FROM 
                                    REALISASI_TTBK_BARANG AS R
                                    LEFT JOIN MASTER_BARANG AS B
                                    ON R.MASTER_BARANG_ID=B.MASTER_BARANG_ID
                                    WHERE 
                                    R.SURAT_JALAN_ID="' . $surat_jalan_id . '" 
                                    AND (R.RECORD_STATUS="AKTIF" OR R.RECORD_STATUS="DRAFT") 
                                    AND R.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                    AND B.RECORD_STATUS="AKTIF"
                                    AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        foreach ($hasil['mp'] as $row) {
            $tabung = $this->db->query('SELECT MASTER_TABUNG_KODE,MASTER_TABUNG_KODE_LAMA FROM MASTER_TABUNG WHERE
                                    MASTER_TABUNG_ID = "' . $row->MASTER_TABUNG_ID . '"
                                    AND RECORD_STATUS="AKTIF"
                                    AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"');
            $row->KODE_TABUNG = $tabung->result();
        }
        $hasil['mr'] = $this->db->query('SELECT * FROM 
                                    REALISASI_TTBK_BARANG_MR AS R
                                    LEFT JOIN MASTER_BARANG AS B
                                    ON R.MASTER_BARANG_ID=B.MASTER_BARANG_ID
                                    WHERE 
                                    R.SURAT_JALAN_ID="' . $surat_jalan_id . '" 
                                    AND (R.RECORD_STATUS="AKTIF" OR R.RECORD_STATUS="DRAFT") 
                                    AND R.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                    AND B.RECORD_STATUS="AKTIF"
                                    AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        // $hasil = $this->db->query('SELECT * FROM 
        //                             REALISASI_BARANG AS R
        //                             LEFT JOIN MASTER_TABUNG AS T
        //                             ON 
        //                             R.MASTER_TABUNG_ID = T.MASTER_TABUNG_ID
        //                             LEFT JOIN
        //                             MASTER_BARANG AS B
        //                             ON T.MASTER_BARANG_ID=B.MASTER_BARANG_ID
        //                             WHERE 
        //                             R.SURAT_JALAN_ID="' . $surat_jalan_id . '" 
        //                             AND (R.RECORD_STATUS="AKTIF" OR R.RECORD_STATUS="DRAFT") 
        //                             AND R.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
        //                             AND B.RECORD_STATUS="AKTIF"
        //                             AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
        //                             AND T.RECORD_STATUS="AKTIF"
        //                             AND T.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();
        return $hasil;
    }

    // public function list_realisasi_tabung_mr($surat_jalan_id)
    // {
    //     $hasil = $this->db->query('SELECT * FROM 
    //                                 REALISASI_BARANG_MR AS R
    //                                 LEFT JOIN MASTER_BARANG AS T
    //                                 ON 
    //                                 R.MASTER_BARANG_ID = T.MASTER_BARANG_ID
    //                                 WHERE 
    //                                 R.SURAT_JALAN_ID="' . $surat_jalan_id . '" 
    //                                 AND R.RECORD_STATUS="AKTIF" 
    //                                 AND R.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
    //                                 AND T.RECORD_STATUS="AKTIF"
    //                                 AND T.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();
    //     return $hasil;
    // }

    public function add()
    {
        $surat_jalan = $this->db->query('SELECT * FROM SURAT_JALAN WHERE SURAT_JALAN_ID="' . $this->input->post('surat_jalan_id') . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();

        $data_edit_panggung = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('PANGGUNG_REF', $this->input->post("surat_jalan_id"));
        $this->db->where('PANGGUNG_STATUS', 'in');
        $this->db->update('PANGGUNG', $data_edit_panggung);

        $data_edit_jurnal = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('JURNAL_TABUNG_REF', $this->input->post("surat_jalan_id"));
        $this->db->where('JURNAL_TABUNG_KEMBALI >', 0);
        $this->db->update('JURNAL_TABUNG', $data_edit_jurnal);

        $data = array(
            'SURAT_JALAN_REALISASI_TTBK_STATUS' => "selesai",
            'SURAT_JALAN_REALISASI_TTBK_OLEH' => $this->session->userdata('USER_ID'),
            'SURAT_JALAN_REALISASI_TTBK_TANGGAL' => date("Y-m-d G:i:s"),
            'SURAT_JALAN_REALISASI_TTBK_JUMLAH_MP' => $this->input->post("total_realisasi"),
            'SURAT_JALAN_REALISASI_TTBK_JUMLAH_MR' => $this->input->post("total_tabung_mr"),
        );

        $this->db->where('SURAT_JALAN_ID', $this->input->post("surat_jalan_id"));
        $this->db->where('RECORD_STATUS', "AKTIF");
        $this->db->update('SURAT_JALAN', $data);

        $realisasi_barang = $this->db->query('SELECT REALISASI_TTBK_BARANG_STATUS,MASTER_BARANG_ID,COUNT(MASTER_BARANG_ID) AS JUMLAH FROM REALISASI_TTBK_BARANG WHERE SURAT_JALAN_ID="' . $this->input->post("surat_jalan_id") . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" GROUP BY MASTER_BARANG_ID,REALISASI_TTBK_BARANG_STATUS ')->result();
        $realisasi_barang_mr = $this->db->query('SELECT REALISASI_TTBK_BARANG_MR_STATUS,MASTER_BARANG_ID, COUNT(MASTER_BARANG_ID) AS JUMLAH FROM REALISASI_TTBK_BARANG_MR WHERE SURAT_JALAN_ID="' . $this->input->post("surat_jalan_id") . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" GROUP BY MASTER_BARANG_ID,REALISASI_TTBK_BARANG_MR_STATUS ')->result();

        foreach ($realisasi_barang as $mp) {
            $data_mp = array(
                'JURNAL_TABUNG_ID' => create_id(),
                'MASTER_RELASI_ID' => $surat_jalan[0]->MASTER_RELASI_ID,
                'MASTER_SUPPLIER_ID' => $surat_jalan[0]->MASTER_SUPPLIER_ID,
                'MASTER_BARANG_ID' => $mp->MASTER_BARANG_ID,
                'JURNAL_TABUNG_TANGGAL' => $surat_jalan[0]->SURAT_JALAN_TANGGAL,
                'JURNAL_TABUNG_KIRIM' => "",
                'JURNAL_TABUNG_KEMBALI' => $mp->JUMLAH,
                'JURNAL_TABUNG_STATUS' => "MP",
                'JURNAL_TABUNG_KETERANGAN' => "" . $surat_jalan[0]->SURAT_JALAN_NOMOR . " (TTBK)",
                'JURNAL_TABUNG_FILE' => "empty",
                'JURNAL_TABUNG_REF'  => $this->input->post("surat_jalan_id"),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );
            $this->db->insert('JURNAL_TABUNG', $data_mp);
        }

        foreach ($realisasi_barang_mr as $mr) {
            $data_mr = array(
                'JURNAL_TABUNG_ID' => create_id(),
                'MASTER_RELASI_ID' => $surat_jalan[0]->MASTER_RELASI_ID,
                'MASTER_SUPPLIER_ID' => $surat_jalan[0]->MASTER_SUPPLIER_ID,
                'MASTER_BARANG_ID' => $mr->MASTER_BARANG_ID,
                'JURNAL_TABUNG_TANGGAL' => $surat_jalan[0]->SURAT_JALAN_TANGGAL,
                'JURNAL_TABUNG_KIRIM' => "",
                'JURNAL_TABUNG_KEMBALI' => $mr->JUMLAH,
                'JURNAL_TABUNG_STATUS' => "MR",
                'JURNAL_TABUNG_KETERANGAN' => "" . $surat_jalan[0]->SURAT_JALAN_NOMOR . " (TTBK)",
                'JURNAL_TABUNG_FILE' => "empty",
                'JURNAL_TABUNG_REF'  => $this->input->post("surat_jalan_id"),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );
            $this->db->insert('JURNAL_TABUNG', $data_mr);
        }

        $realisasi_barang_panggung = $this->db->query('SELECT * FROM REALISASI_TTBK_BARANG WHERE SURAT_JALAN_ID="' . $this->input->post("surat_jalan_id") . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();
        $realisasi_barang_mr_panggung = $this->db->query('SELECT * FROM REALISASI_TTBK_BARANG_MR WHERE SURAT_JALAN_ID="' . $this->input->post("surat_jalan_id") . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();
        $jumlah_mp = 0;
        $jumlah_mr = 0;
        foreach ($realisasi_barang_panggung as $mp) {
            $jumlah_mp += 1;
            $data_panggung_mp = array(
                'PANGGUNG_ID' => create_id(),
                'MASTER_RELASI_ID' => $surat_jalan[0]->MASTER_RELASI_ID,
                'MASTER_SUPPLIER_ID' => $surat_jalan[0]->MASTER_SUPPLIER_ID,
                'MASTER_BARANG_ID' => $mp->MASTER_BARANG_ID,
                'PANGGUNG_TANGGAL' => $surat_jalan[0]->SURAT_JALAN_TANGGAL,
                'PANGGUNG_STATUS' => "in",
                'PANGGUNG_STATUS_ISI' => $mp->REALISASI_TTBK_BARANG_STATUS,
                'PANGGUNG_JUMLAH' => 1,
                'PANGGUNG_STATUS_KEPEMILIKAN' => "MP",
                'PANGGUNG_KETERANGAN' => "" . $surat_jalan[0]->SURAT_JALAN_NOMOR . "",
                'PANGGUNG_REF'  => $this->input->post("surat_jalan_id"),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );
            $this->db->insert('PANGGUNG', $data_panggung_mp);
        }

        foreach ($realisasi_barang_mr_panggung as $mr) {
            $jumlah_mr += 1;
            $data_panggung_mr = array(
                'PANGGUNG_ID' => create_id(),
                'MASTER_RELASI_ID' => $surat_jalan[0]->MASTER_RELASI_ID,
                'MASTER_SUPPLIER_ID' => $surat_jalan[0]->MASTER_SUPPLIER_ID,
                'MASTER_BARANG_ID' => $mr->MASTER_BARANG_ID,
                'PANGGUNG_TANGGAL' => $surat_jalan[0]->SURAT_JALAN_TANGGAL,
                'PANGGUNG_STATUS' => "in",
                'PANGGUNG_STATUS_ISI' => $mr->REALISASI_TTBK_BARANG_MR_STATUS,
                'PANGGUNG_JUMLAH' => 1,
                'PANGGUNG_STATUS_KEPEMILIKAN' => "MR",
                'PANGGUNG_KETERANGAN' => "" . $surat_jalan[0]->SURAT_JALAN_NOMOR . "",
                'PANGGUNG_REF'  => $this->input->post("surat_jalan_id"),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );
            $this->db->insert('PANGGUNG', $data_panggung_mr);
        }
        return true;
    }

    public function add_barang($surat_jalan_id)
    {
        if ($this->input->post('isi') == "on") {
            $isi = "1";
        } else {
            $isi = "0";
        }

        for ($x = 1; $x <= $this->input->post('jumlah_mp'); $x++) {
            $data = array(
                'REALISASI_TTBK_BARANG_ID' => create_id(),
                'SURAT_JALAN_ID' => $surat_jalan_id,
                'MASTER_BARANG_ID' => $this->input->post('jenis'),
                'REALISASI_TTBK_BARANG_STATUS' => $isi,

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->insert('REALISASI_TTBK_BARANG', $data);
        }

        for ($x = 1; $x <= $this->input->post('jumlah_mr'); $x++) {
            $data = array(
                'REALISASI_TTBK_BARANG_MR_ID' => create_id(),
                'SURAT_JALAN_ID' => $surat_jalan_id,
                'MASTER_BARANG_ID' => $this->input->post('jenis'),
                'REALISASI_TTBK_BARANG_MR_STATUS' => $isi,

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->insert('REALISASI_TTBK_BARANG_MR', $data);
        }

        return true;
    }

    public function add_scan($surat_jalan_id)
    {
        if ($this->input->post('isi') == "on") {
            $isi = "1";
        } else {
            $isi = "0";
        }

        $surat_jalan = $this->db->query('SELECT * FROM SURAT_JALAN WHERE SURAT_JALAN_ID="' . $surat_jalan_id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        $list = explode(PHP_EOL, $this->input->post('scan'));
        foreach ($list as $row) {
            $hasil = $this->db->query('SELECT * FROM MASTER_TABUNG WHERE MASTER_TABUNG_KODE="' . $row . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1');
            if ($hasil->num_rows() == "") {
            } else {
                $tabung = $hasil->result();
                $id_realisasi = create_id();
                $data = array(
                    'REALISASI_TTBK_BARANG_ID' => $id_realisasi,
                    'SURAT_JALAN_ID' => $surat_jalan_id,
                    'MASTER_BARANG_ID' => $tabung[0]->MASTER_BARANG_ID,
                    'MASTER_TABUNG_ID' => $tabung[0]->MASTER_TABUNG_ID,
                    'REALISASI_TTBK_BARANG_STATUS' => $isi,

                    'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                    'ENTRI_USER' => $this->session->userdata('USER_ID'),
                    'RECORD_STATUS' => "AKTIF",
                    'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
                );
                $this->db->insert('REALISASI_TTBK_BARANG', $data);

                $data_riwayat_tabung = array(
                    'RIWAYAT_TABUNG_ID' => create_id(),
                    'MASTER_TABUNG_ID' => $tabung[0]->MASTER_TABUNG_ID,
                    'RIWAYAT_TABUNG_TANGGAL' => $surat_jalan[0]->SURAT_JALAN_TANGGAL,
                    'RIWAYAT_TABUNG_STATUS' => '0',
                    'RIWAYAT_TABUNG_KIRIM' => '0',
                    'RIWAYAT_TABUNG_KEMBALI' => '1',
                    'MASTER_RELASI_ID' => $surat_jalan[0]->MASTER_RELASI_ID,
                    'MASTER_SUPPLIER_ID' => $surat_jalan[0]->MASTER_SUPPLIER_ID,
                    'RIWAYAT_TABUNG_KETERANGAN' => $surat_jalan[0]->SURAT_JALAN_NOMOR,
                    'RIWAYAT_TABUNG_REF' => $id_realisasi,

                    'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                    'ENTRI_USER' => $this->session->userdata('USER_ID'),
                    'RECORD_STATUS' => "AKTIF",
                    'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
                );
                $this->db->insert('RIWAYAT_TABUNG', $data_riwayat_tabung);
            }
        }
        return true;
    }
    public function panggung_realisasi($surat_jalan_id)
    {
        $hasil = $this->db->query('SELECT * FROM PANGGUNG WHERE PANGGUNG_REF="' . $surat_jalan_id . '" AND PANGGUNG_STATUS="in" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        return $hasil;
    }
    public function klaim_barang($surat_jalan_id)
    {
        $data = array(

            'SURAT_JALAN_BARANG_QUANTITY_KLAIM' => $this->input->post('jumlah'),
        );

        $this->db->where('SURAT_JALAN_ID', $surat_jalan_id);
        $this->db->where('MASTER_BARANG_ID', $this->input->post('jenis'));
        $this->db->where('RECORD_STATUS', "AKTIF");
        $result = $this->db->update('SURAT_JALAN_BARANG', $data);
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

        $this->db->where('RIWAYAT_TABUNG_REF', $id);
        $this->db->update('RIWAYAT_TABUNG', $data);

        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('REALISASI_TTBK_BARANG_ID', $id);
        $result = $this->db->update('REALISASI_TTBK_BARANG', $data);
        return $result;
    }
    public function hapus_mr($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('REALISASI_TTBK_BARANG_MR_ID', $id);
        $result = $this->db->update('REALISASI_TTBK_BARANG_MR', $data);
        return $result;
    }

    public function hapus_semua($surat_jalan_id)
    {
        $data_mr = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('SURAT_JALAN_ID', $surat_jalan_id);
        $this->db->update('REALISASI_TTBK_BARANG_MR', $data_mr);

        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('SURAT_JALAN_ID', $surat_jalan_id);
        $this->db->update('REALISASI_TTBK_BARANG', $data);
        return true;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM SURAT_JALAN WHERE SURAT_JALAN_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        return $hasil;
    }
}
