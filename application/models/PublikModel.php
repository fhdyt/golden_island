<?php
class PublikModel extends CI_Model
{
    public function polda($tanggal)
    {

        $filter_tanggal = 'SJ.SURAT_JALAN_TANGGAL = "' . $tanggal . '"';

        $hasil = $this->db->query('SELECT *,SJ.ENTRI_WAKTU AS WAKTU 
                            FROM 
                            SURAT_JALAN AS SJ
                            LEFT JOIN MASTER_RELASI AS R
                            ON SJ.MASTER_RELASI_ID=R.MASTER_RELASI_ID
                            WHERE 
                            ' . $filter_tanggal . '
                            AND SJ.SURAT_JALAN_JENIS = "penjualan"
                            AND NOT SJ.SURAT_JALAN_STATUS="cancel"
                            AND SJ.RECORD_STATUS="AKTIF" 
                            AND SJ.PERUSAHAAN_KODE="BGS" 
                            AND R.MASTER_RELASI_NAMA LIKE "RS%"
                            AND R.RECORD_STATUS="AKTIF" 
                            AND R.PERUSAHAAN_KODE="BGS" 
                            ORDER BY SJ.SURAT_JALAN_NOMOR ')->result();
        foreach ($hasil as $row) {
            $row->RELASI = $this->db->query('SELECT MASTER_RELASI_NAMA FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="BGS"')->result();

            $total_perbarang = 0;
            if ($row->SURAT_JALAN_STATUS == "open") {

                $barang = $this->db->query('SELECT * FROM
                                                        SURAT_JALAN_BARANG AS SJ 
                                                        LEFT JOIN
                                                        MASTER_BARANG AS B
                                                        ON SJ.MASTER_BARANG_ID = B.MASTER_BARANG_ID
                                                        WHERE SJ.SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '"
                                                        AND SJ.RECORD_STATUS="AKTIF" 
                                                        AND SJ.PERUSAHAAN_KODE="BGS" 
                                                        AND B.RECORD_STATUS="AKTIF" 
                                                        AND B.PERUSAHAAN_KODE="BGS"')->result();
                foreach ($barang as $row_barang) {
                    $row_barang->NAMA_BARANG = $this->db->query('SELECT MASTER_BARANG_NAMA FROM MASTER_BARANG WHERE MASTER_BARANG_ID="' . $row_barang->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="BGS"')->result();
                    $row_barang->HARGA_BARANG = $this->db->query('SELECT * FROM MASTER_HARGA WHERE MASTER_BARANG_ID="' . $row_barang->MASTER_BARANG_ID . '" AND MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="BGS"')->result();
                    if (count($row_barang->HARGA_BARANG) == 0) {
                        $total_perbarang += $row_barang->MASTER_BARANG_HARGA_SATUAN * ($row_barang->SURAT_JALAN_BARANG_QUANTITY - $row_barang->SURAT_JALAN_BARANG_QUANTITY_KLAIM);
                    } else {
                        $total_perbarang += $row_barang->HARGA_BARANG[0]->MASTER_HARGA_HARGA * ($row_barang->SURAT_JALAN_BARANG_QUANTITY - $row_barang->SURAT_JALAN_BARANG_QUANTITY_KLAIM);
                    }
                }

                $terbayar = array();
            } else if ($row->SURAT_JALAN_STATUS == "close") {
                $faktur = $this->db->query('SELECT 
                                            FSJ.FAKTUR_ID 
                                            FROM 
                                            FAKTUR AS F
                                            LEFT JOIN
                                            FAKTUR_SURAT_JALAN AS FSJ
                                            ON F.FAKTUR_ID=FSJ.FAKTUR_ID
                                            WHERE FSJ.SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" 
                                            AND F.RECORD_STATUS="AKTIF" 
                                            AND F.PERUSAHAAN_KODE="BGS" 
                                            AND FSJ.RECORD_STATUS="AKTIF" 
                                            AND FSJ.PERUSAHAAN_KODE="BGS" LIMIT 1')->result();

                $barang = $this->db->query('SELECT * FROM FAKTUR_BARANG WHERE FAKTUR_ID="' . $faktur[0]->FAKTUR_ID . '" AND SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" AND RECORD_STATUS="AKTIF" 
                                            AND PERUSAHAAN_KODE="BGS" ')->result();
                foreach ($barang as $row_barang) {
                    $row_barang->NAMA_BARANG = $this->db->query('SELECT MASTER_BARANG_NAMA FROM MASTER_BARANG WHERE MASTER_BARANG_ID="' . $row_barang->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="BGS"')->result();
                    $row_barang->HARGA_BARANG = $this->db->query('SELECT * FROM FAKTUR_BARANG WHERE FAKTUR_ID="' . $faktur[0]->FAKTUR_ID . '" AND MASTER_BARANG_ID="' . $row_barang->MASTER_BARANG_ID . '" AND SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="BGS"')->result();
                    $total_perbarang += $row_barang->HARGA_BARANG[0]->FAKTUR_BARANG_QUANTITY * $row_barang->HARGA_BARANG[0]->FAKTUR_BARANG_HARGA;
                }
                $terbayar = $this->db->query('SELECT * FROM FAKTUR_TRANSAKSI
                                                                    WHERE
                                                                    FAKTUR_ID="' . $faktur[0]->FAKTUR_ID . '"
                                                                    AND RECORD_STATUS="AKTIF" 
                                                                    AND PERUSAHAAN_KODE="BGS" LIMIT 1')->result();
            }

            $row->BARANG = $barang;
            $row->TOTAL = $total_perbarang;
            $row->TERBAYAR = $terbayar;
            $row->TANGGAL = tanggal($row->SURAT_JALAN_TANGGAL);
            $row->JAM = jam($row->ENTRI_WAKTU);
        }
        return $hasil;
    }

    public function rs_sga($tanggal)
    {

        $filter_tanggal = 'SJ.SURAT_JALAN_TANGGAL = "' . $tanggal . '"';

        $hasil = $this->db->query('SELECT *,SJ.ENTRI_WAKTU AS WAKTU 
                            FROM 
                            SURAT_JALAN AS SJ
                            LEFT JOIN MASTER_RELASI AS R
                            ON SJ.MASTER_RELASI_ID=R.MASTER_RELASI_ID
                            WHERE 
                            ' . $filter_tanggal . '
                            AND SJ.SURAT_JALAN_JENIS = "penjualan"
                            AND NOT SJ.SURAT_JALAN_STATUS="cancel"
                            AND SJ.RECORD_STATUS="AKTIF" 
                            AND SJ.PERUSAHAAN_KODE="SGA" 
                            AND R.MASTER_RELASI_NAMA LIKE "RS%"
                            AND R.RECORD_STATUS="AKTIF" 
                            AND R.PERUSAHAAN_KODE="SGA" 
                            ORDER BY SJ.SURAT_JALAN_NOMOR ')->result();
        foreach ($hasil as $row) {
            $row->RELASI = $this->db->query('SELECT MASTER_RELASI_NAMA FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="SGA"')->result();

            $total_perbarang = 0;
            if ($row->SURAT_JALAN_STATUS == "open") {

                $barang = $this->db->query('SELECT * FROM
                                                        SURAT_JALAN_BARANG AS SJ 
                                                        LEFT JOIN
                                                        MASTER_BARANG AS B
                                                        ON SJ.MASTER_BARANG_ID = B.MASTER_BARANG_ID
                                                        WHERE SJ.SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '"
                                                        AND SJ.RECORD_STATUS="AKTIF" 
                                                        AND SJ.PERUSAHAAN_KODE="SGA" 
                                                        AND B.RECORD_STATUS="AKTIF" 
                                                        AND B.PERUSAHAAN_KODE="SGA"')->result();
                foreach ($barang as $row_barang) {
                    $row_barang->NAMA_BARANG = $this->db->query('SELECT MASTER_BARANG_NAMA FROM MASTER_BARANG WHERE MASTER_BARANG_ID="' . $row_barang->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="SGA"')->result();
                    $row_barang->HARGA_BARANG = $this->db->query('SELECT * FROM MASTER_HARGA WHERE MASTER_BARANG_ID="' . $row_barang->MASTER_BARANG_ID . '" AND MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="SGA"')->result();
                    if (count($row_barang->HARGA_BARANG) == 0) {
                        $total_perbarang += $row_barang->MASTER_BARANG_HARGA_SATUAN * ($row_barang->SURAT_JALAN_BARANG_QUANTITY - $row_barang->SURAT_JALAN_BARANG_QUANTITY_KLAIM);
                    } else {
                        $total_perbarang += $row_barang->HARGA_BARANG[0]->MASTER_HARGA_HARGA * ($row_barang->SURAT_JALAN_BARANG_QUANTITY - $row_barang->SURAT_JALAN_BARANG_QUANTITY_KLAIM);
                    }
                }

                $terbayar = array();
            } else if ($row->SURAT_JALAN_STATUS == "close") {
                $faktur = $this->db->query('SELECT 
                                            FSJ.FAKTUR_ID 
                                            FROM 
                                            FAKTUR AS F
                                            LEFT JOIN
                                            FAKTUR_SURAT_JALAN AS FSJ
                                            ON F.FAKTUR_ID=FSJ.FAKTUR_ID
                                            WHERE FSJ.SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" 
                                            AND F.RECORD_STATUS="AKTIF" 
                                            AND F.PERUSAHAAN_KODE="SGA" 
                                            AND FSJ.RECORD_STATUS="AKTIF" 
                                            AND FSJ.PERUSAHAAN_KODE="SGA" LIMIT 1')->result();

                $barang = $this->db->query('SELECT * FROM FAKTUR_BARANG WHERE FAKTUR_ID="' . $faktur[0]->FAKTUR_ID . '" AND SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" AND RECORD_STATUS="AKTIF" 
                                            AND PERUSAHAAN_KODE="SGA" ')->result();
                foreach ($barang as $row_barang) {
                    $row_barang->NAMA_BARANG = $this->db->query('SELECT MASTER_BARANG_NAMA FROM MASTER_BARANG WHERE MASTER_BARANG_ID="' . $row_barang->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="SGA"')->result();
                    $row_barang->HARGA_BARANG = $this->db->query('SELECT * FROM FAKTUR_BARANG WHERE FAKTUR_ID="' . $faktur[0]->FAKTUR_ID . '" AND MASTER_BARANG_ID="' . $row_barang->MASTER_BARANG_ID . '" AND SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="SGA"')->result();
                    $total_perbarang += $row_barang->HARGA_BARANG[0]->FAKTUR_BARANG_QUANTITY * $row_barang->HARGA_BARANG[0]->FAKTUR_BARANG_HARGA;
                }
                $terbayar = $this->db->query('SELECT * FROM FAKTUR_TRANSAKSI
                                                                    WHERE
                                                                    FAKTUR_ID="' . $faktur[0]->FAKTUR_ID . '"
                                                                    AND RECORD_STATUS="AKTIF" 
                                                                    AND PERUSAHAAN_KODE="SGA" LIMIT 1')->result();
            }

            $row->BARANG = $barang;
            $row->TOTAL = $total_perbarang;
            $row->TERBAYAR = $terbayar;
            $row->TANGGAL = tanggal($row->SURAT_JALAN_TANGGAL);
            $row->JAM = jam($row->ENTRI_WAKTU);
        }
        return $hasil;
    }


    public function telegram($jenis, $id)
    {
        $laporan = $this->db->query('SELECT * FROM LAPORAN_TELEGRAM WHERE LAPORAN_TELEGRAM_ID="' . $id . '" AND RECORD_STATUS="AKTIF"')->result();
        if ($jenis == "BUKUBESAR") {
            $akun = $this->db->query('SELECT * FROM AKUN WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $laporan[0]->PERUSAHAAN_KODE . '"')->result();
            foreach ($akun as $row) {
                $tanggal_dari = date("Y-m-d", strtotime($laporan[0]->LAPORAN_TELEGRAM_TANGGAL));
                $tanggal_sampai = date("Y-m-d", strtotime($laporan[0]->LAPORAN_TELEGRAM_TANGGAL));

                $tanggal = 'AND BUKU_BESAR_TANGGAL BETWEEN "' . $tanggal_dari . '" AND "' . $tanggal_sampai . '"';

                $row->SALDO_AWAL = $this->db->query('SELECT 
            SUM(BUKU_BESAR_KREDIT) AS KREDIT,
            SUM(BUKU_BESAR_DEBET) AS DEBET 
            FROM 
            BUKU_BESAR WHERE 
            AKUN_ID="' . $row->AKUN_ID . '" 
            AND RECORD_STATUS="AKTIF" 
            AND PERUSAHAAN_KODE="' . $laporan[0]->PERUSAHAAN_KODE . '" 
            AND BUKU_BESAR_TANGGAL < "' . $tanggal_dari . '"
            ORDER BY BUKU_BESAR_TANGGAL ASC')->result();

                $row->SALDO_DATA = $this->db->query('SELECT * FROM 
        BUKU_BESAR WHERE 
        AKUN_ID="' . $row->AKUN_ID . '" 
        AND NOT (BUKU_BESAR_KREDIT=0 AND BUKU_BESAR_DEBET =0)
        AND RECORD_STATUS="AKTIF" 
        AND PERUSAHAAN_KODE="' . $laporan[0]->PERUSAHAAN_KODE . '" 
        ' . $tanggal . '
        ORDER BY ENTRI_WAKTU ASC')->result();
                foreach ($row->SALDO_DATA as $row_x) {
                    $row_x->TANGGAL = tanggal($row_x->BUKU_BESAR_TANGGAL);
                    $row_x->SALDO = $row_x->BUKU_BESAR_DEBET - $row_x->BUKU_BESAR_KREDIT;
                }
            }
            return $akun;
        }
    }
}
