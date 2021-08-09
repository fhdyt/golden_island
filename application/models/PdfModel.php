<?php
class PdfModel extends CI_Model
{

    public function cetak_po($id, $id_pembelian)
    {
        $hasil['detail'] = $this->db->query('SELECT * FROM PEMBELIAN WHERE PO_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        $hasil['barang'] = $this->db->query('SELECT * FROM 
        PEMBELIAN_BARANG AS P LEFT JOIN MASTER_BARANG AS B 
        ON P.MASTER_BARANG_ID=B.MASTER_BARANG_ID
        WHERE 
        P.RECORD_STATUS="AKTIF" AND 
        B.RECORD_STATUS="AKTIF" AND 
        P.PO_ID="' . $id . '" AND P.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY P.PEMBELIAN_BARANG_INDEX DESC')->result();
        $hasil['transaksi'] = $this->db->query('SELECT * FROM PEMBELIAN_TRANSAKSI WHERE PO_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        $hasil['supplier'] = $this->db->query('SELECT * FROM MASTER_SUPPLIER WHERE MASTER_SUPPLIER_ID="' . $hasil['detail'][0]->MASTER_SUPPLIER_ID . '" AND RECORD_STATUS="AKTIF"  AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        $hasil['oleh'] = $this->db->query('SELECT * FROM USER WHERE USER_ID="' . $hasil['detail'][0]->ENTRI_USER . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }

    public function cetak_sj($id)
    {
        $hasil['detail'] = $this->db->query('SELECT * FROM SURAT_JALAN WHERE SURAT_JALAN_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        $hasil['barang'] = $this->db->query('SELECT * FROM 
        SURAT_JALAN_BARANG AS P LEFT JOIN MASTER_BARANG AS B 
        ON P.MASTER_BARANG_ID=B.MASTER_BARANG_ID
        WHERE 
        P.RECORD_STATUS="AKTIF" AND 
        B.RECORD_STATUS="AKTIF" AND 
        P.SURAT_JALAN_ID="' . $id . '" AND P.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY P.SURAT_JALAN_BARANG_INDEX DESC')->result();
        $hasil['relasi'] = $this->db->query('SELECT * FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $hasil['detail'][0]->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF"  AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        $hasil['supplier'] = $this->db->query('SELECT * FROM MASTER_SUPPLIER WHERE MASTER_SUPPLIER_ID="' . $hasil['detail'][0]->MASTER_SUPPLIER_ID . '" AND RECORD_STATUS="AKTIF"  AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        $hasil['oleh'] = $this->db->query('SELECT * FROM USER WHERE USER_ID="' . $hasil['detail'][0]->ENTRI_USER . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        $hasil['driver'] = $this->db->query('SELECT * FROM MASTER_KARYAWAN WHERE MASTER_KARYAWAN_ID="' . $hasil['detail'][0]->DRIVER_ID . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        $hasil['barang_mp'] = $this->db->query('SELECT * FROM 
                            REALISASI_BARANG AS R
                            LEFT JOIN MASTER_BARANG AS B
                            ON R.MASTER_BARANG_ID=B.MASTER_BARANG_ID
                            WHERE 
                            R.SURAT_JALAN_ID="' . $hasil['detail'][0]->SURAT_JALAN_ID . '" 
                            AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                            AND B.RECORD_STATUS="AKTIF"
                            AND R.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                            AND R.RECORD_STATUS="AKTIF"')->result();
        foreach ($hasil['barang_mp'] as $row) {
            $tabung = $this->db->query('SELECT MASTER_TABUNG_KODE,MASTER_TABUNG_KODE_LAMA FROM MASTER_TABUNG WHERE
                                    MASTER_TABUNG_ID = "' . $row->MASTER_TABUNG_ID . '"
                                    AND RECORD_STATUS="AKTIF"
                                    AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"');
            $row->KODE_TABUNG = $tabung->result();
        }
        $hasil['barang_mr'] = $this->db->query('SELECT * FROM 
                            REALISASI_BARANG_MR AS R
                            LEFT JOIN MASTER_BARANG AS B
                            ON R.MASTER_BARANG_ID=B.MASTER_BARANG_ID
                            WHERE 
                            R.SURAT_JALAN_ID="' . $hasil['detail'][0]->SURAT_JALAN_ID . '" 
                            AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                            AND B.RECORD_STATUS="AKTIF"
                            AND R.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                            AND R.RECORD_STATUS="AKTIF"')->result();
        return $hasil;
    }
    public function tabung()
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_TABUNG WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY MASTER_TABUNG_KODE ')->result();
        return $hasil;
    }

    public function faktur($id)
    {
        $hasil['detail'] = $this->db->query('SELECT * FROM FAKTUR WHERE FAKTUR_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        $hasil['surat_jalan'] = $this->db->query('SELECT * FROM 
                                    FAKTUR_SURAT_JALAN AS FSJ
                                    LEFT JOIN SURAT_JALAN AS SJ
                                    ON FSJ.SURAT_JALAN_ID=SJ.SURAT_JALAN_ID
                                     WHERE FSJ.FAKTUR_ID="' . $id . '" 
                                     AND FSJ.RECORD_STATUS="AKTIF" 
                                     AND FSJ.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                     AND SJ.RECORD_STATUS="AKTIF" 
                                     AND SJ.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        $hasil['barang'] = $this->db->query('SELECT 
                                            FB.MASTER_BARANG_ID,
                                            B.MASTER_BARANG_NAMA,
                                            SUM(FB.FAKTUR_BARANG_QUANTITY) AS SUM,
                                            FB.FAKTUR_BARANG_HARGA 
                                            FROM 
                                            FAKTUR_BARANG AS FB
                                            LEFT JOIN MASTER_BARANG AS B
                                            ON FB.MASTER_BARANG_ID=B.MASTER_BARANG_ID  
                                            WHERE FB.FAKTUR_ID="' . $id . '"
                                            AND FB.RECORD_STATUS="AKTIF" 
                                            AND FB.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                            AND B.RECORD_STATUS="AKTIF" 
                                            AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                            GROUP 
                                            BY
                                            FB.MASTER_BARANG_ID,
                                            B.MASTER_BARANG_NAMA,
                                            FB.FAKTUR_BARANG_HARGA')->result();
        $hasil['transaksi'] = $this->db->query('SELECT * FROM FAKTUR_TRANSAKSI WHERE FAKTUR_ID="' . $id . '" AND RECORD_STATUS="AKTIF"  AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        $hasil['relasi'] = $this->db->query('SELECT * FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $hasil['detail'][0]->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF"  AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        $hasil['oleh'] = $this->db->query('SELECT * FROM USER WHERE USER_ID="' . $hasil['detail'][0]->ENTRI_USER . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }

    public function faktur_penjualan($id)
    {
        $hasil['detail'] = $this->db->query('SELECT * FROM FAKTUR WHERE FAKTUR_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        $hasil['surat_jalan'] = $this->db->query('SELECT * FROM 
                                    FAKTUR_SURAT_JALAN AS FSJ
                                    LEFT JOIN SURAT_JALAN AS SJ
                                    ON FSJ.SURAT_JALAN_ID=SJ.SURAT_JALAN_ID
                                     WHERE FSJ.FAKTUR_ID="' . $id . '" 
                                     AND FSJ.RECORD_STATUS="AKTIF" 
                                     AND FSJ.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                     AND SJ.RECORD_STATUS="AKTIF" 
                                     AND SJ.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        foreach ($hasil['surat_jalan'] as $row) {
            $row->BARANG = $this->db->query('SELECT* 
                                            FROM 
                                            FAKTUR_BARANG AS FB
                                            LEFT JOIN MASTER_BARANG AS B
                                            ON FB.MASTER_BARANG_ID=B.MASTER_BARANG_ID  
                                            WHERE FB.FAKTUR_ID="' . $id . '"
                                            AND FB.SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '"
                                            AND FB.RECORD_STATUS="AKTIF" 
                                            AND FB.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                            AND B.RECORD_STATUS="AKTIF" 
                                            AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        }
        $hasil['barang'] = $this->db->query('SELECT 
                                            FB.MASTER_BARANG_ID,
                                            B.MASTER_BARANG_NAMA,
                                            SUM(FB.FAKTUR_BARANG_QUANTITY) AS SUM,
                                            FB.FAKTUR_BARANG_HARGA 
                                            FROM 
                                            FAKTUR_BARANG AS FB
                                            LEFT JOIN MASTER_BARANG AS B
                                            ON FB.MASTER_BARANG_ID=B.MASTER_BARANG_ID  
                                            WHERE FB.FAKTUR_ID="' . $id . '"
                                            AND FB.RECORD_STATUS="AKTIF" 
                                            AND FB.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                            AND B.RECORD_STATUS="AKTIF" 
                                            AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                            GROUP 
                                            BY
                                            FB.MASTER_BARANG_ID,
                                            B.MASTER_BARANG_NAMA,
                                            FB.FAKTUR_BARANG_HARGA')->result();
        $hasil['transaksi'] = $this->db->query('SELECT * FROM FAKTUR_TRANSAKSI WHERE FAKTUR_ID="' . $id . '" AND RECORD_STATUS="AKTIF"  AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        $hasil['relasi'] = $this->db->query('SELECT * FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $hasil['detail'][0]->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF"  AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        $hasil['oleh'] = $this->db->query('SELECT * FROM USER WHERE USER_ID="' . $hasil['detail'][0]->ENTRI_USER . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }

    public function faktur_jaminan($id)
    {
        $hasil['detail'] = $this->db->query('SELECT * FROM FAKTUR_JAMINAN WHERE FAKTUR_JAMINAN_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        $hasil['surat_jalan'] = $this->db->query('SELECT * FROM SURAT_JALAN WHERE SURAT_JALAN_ID="' . $hasil['detail'][0]->SURAT_JALAN_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        $hasil['barang'] = $this->db->query('SELECT * 
                                        FROM SURAT_JALAN_BARANG AS SJ
                                        LEFT JOIN MASTER_BARANG AS B
                                        ON SJ.MASTER_BARANG_ID=B.MASTER_BARANG_ID 
                                        WHERE 
                                        SJ.SURAT_JALAN_ID ="' . $hasil['detail'][0]->SURAT_JALAN_ID . '" 
                                        AND SJ.RECORD_STATUS="AKTIF" 
                                        AND SJ.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                        AND B.RECORD_STATUS="AKTIF" 
                                        AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                        LIMIT 1')->result();
        $hasil['relasi'] = $this->db->query('SELECT * FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $hasil['detail'][0]->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF"  AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        $hasil['oleh'] = $this->db->query('SELECT * FROM USER WHERE USER_ID="' . $hasil['detail'][0]->ENTRI_USER . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }

    public function cetak_titipan($id)
    {
        $hasil['detail'] = $this->db->query('SELECT *,
        J.ENTRI_USER AS USER
                                    FROM 
                                    JURNAL_TABUNG AS J
                                    LEFT JOIN MASTER_RELASI AS R
                                    ON
                                    J.MASTER_RELASI_ID=R.MASTER_RELASI_ID
                                    LEFT JOIN
                                    MASTER_BARANG AS B
                                    ON
                                    J.MASTER_BARANG_ID=B.MASTER_BARANG_ID
                                    WHERE J.JURNAL_TABUNG_ID="' . $id . '"
                                    AND J.RECORD_STATUS="AKTIF" 
                                    AND J.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                    AND R.RECORD_STATUS="AKTIF" 
                                    AND R.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                    AND B.RECORD_STATUS="AKTIF" 
                                    AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                    LIMIT 1')->result();

        $hasil['relasi'] = $this->db->query('SELECT * FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $hasil['detail'][0]->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF"  AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        $hasil['oleh'] = $this->db->query('SELECT * FROM USER WHERE USER_ID="' . $hasil['detail'][0]->USER . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }

    public function cetak_gaji($id, $bulan, $tahun)
    {
        $hasil['gaji'] = $this->db->query('SELECT *, G.ENTRI_USER AS USER 
                    FROM 
                    GAJI AS G LEFT JOIN MASTER_KARYAWAN AS K
                    ON G.MASTER_KARYAWAN_ID=K.MASTER_KARYAWAN_ID
                    WHERE 
                    G.MASTER_KARYAWAN_ID="' . $id . '" 
                    AND G.GAJI_BULAN="' . $bulan . '" 
                    AND G.GAJI_TAHUN="' . $tahun . '" 
                    AND G.RECORD_STATUS="AKTIF" 
                    AND G.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                    AND K.RECORD_STATUS="AKTIF" 
                    AND K.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        $hasil['surat_jalan'] = $this->db->query('SELECT * 
                                FROM SURAT_JALAN WHERE 
                                MONTH(SURAT_JALAN_TANGGAL) = ' . $bulan . ' 
                                        AND YEAR(SURAT_JALAN_TANGGAL) = ' . $tahun . '
                                        AND DRIVER_ID="' . $id . '" 
                                AND RECORD_STATUS="AKTIF" 
                                AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                ORDER BY SURAT_JALAN_NOMOR ASC ')->result();
        foreach ($hasil['surat_jalan'] as $row) {
            $relasi = $this->db->query('SELECT * FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            $supplier = $this->db->query('SELECT * FROM MASTER_SUPPLIER WHERE MASTER_SUPPLIER_ID="' . $row->MASTER_SUPPLIER_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            $barang = $this->db->query('SELECT
                                        SUM(SURAT_JALAN_BARANG_QUANTITY) AS ISI,
                                        SUM(SURAT_JALAN_BARANG_QUANTITY_KOSONG) AS KOSONG,
                                        SUM(SURAT_JALAN_BARANG_QUANTITY_KLAIM) AS KLAIM
                                        FROM 
                                        SURAT_JALAN_BARANG 
                                        WHERE SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" 
                                        AND RECORD_STATUS="AKTIF" 
                                        AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            $row->TANGGAL = tanggal($row->SURAT_JALAN_TANGGAL);
            $row->JAM = jam($row->ENTRI_WAKTU);
            $row->RELASI = $relasi;
            $row->SUPPLIER = $supplier;
            $row->BARANG = $barang;
        }

        $hasil['produksi'] = $this->db->query('SELECT * 
                                FROM PRODUKSI_KARYAWAN AS PK 
                                LEFT JOIN 
                                PRODUKSI AS P
                                ON
                                PK.PRODUKSI_ID=P.PRODUKSI_ID
                                WHERE 
                                MONTH(P.PRODUKSI_TANGGAL) = ' . $bulan . ' 
                                        AND YEAR(P.PRODUKSI_TANGGAL) = ' . $tahun . '
                                        AND PK.MASTER_KARYAWAN_ID="' . $id . '" 
                                AND PK.RECORD_STATUS="AKTIF" 
                                AND PK.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                AND P.RECORD_STATUS="AKTIF" 
                                AND P.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                ORDER BY P.PRODUKSI_NOMOR, P.PRODUKSI_TANGGAL  ASC ')->result();
        foreach ($hasil['produksi'] as $row) {
            $row->TANGGAL = tanggal($row->PRODUKSI_TANGGAL);
        }

        $hasil['gas'] = $this->db->query('SELECT
                                        SUM(SJB.SURAT_JALAN_BARANG_QUANTITY) AS ISI,
                                        SUM(SJB.SURAT_JALAN_BARANG_QUANTITY_KOSONG) AS KOSONG,
                                        SUM(SJB.SURAT_JALAN_BARANG_QUANTITY_KLAIM) AS KLAIM
                                        FROM 
                                        SURAT_JALAN_BARANG AS SJB
                                        LEFT JOIN
                                        SURAT_JALAN AS SJ
                                        ON SJB.SURAT_JALAN_ID=SJ.SURAT_JALAN_ID
                                        WHERE MONTH(SJ.SURAT_JALAN_TANGGAL) = ' . $bulan . ' 
                                        AND YEAR(SJ.SURAT_JALAN_TANGGAL) = ' . $tahun . '
                                        AND SJ.SURAT_JALAN_JENIS="penjualan"
                                        AND SJ.SURAT_JALAN_STATUS_JENIS="gas"
                                        AND SJB.RECORD_STATUS="AKTIF" 
                                        AND SJB.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                        AND SJ.RECORD_STATUS="AKTIF" 
                                        AND SJ.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        foreach ($hasil['gas'] as $row) {
            $row->TOTAL = $row->ISI + $row->KOSONG - $row->KLAIM;
        }
        $hasil['liquid'] = $this->db->query('SELECT
                                        SUM(SJB.SURAT_JALAN_BARANG_QUANTITY) AS ISI,
                                        SUM(SJB.SURAT_JALAN_BARANG_QUANTITY_KOSONG) AS KOSONG,
                                        SUM(SJB.SURAT_JALAN_BARANG_QUANTITY_KLAIM) AS KLAIM
                                        FROM 
                                        SURAT_JALAN_BARANG AS SJB
                                        LEFT JOIN
                                        SURAT_JALAN AS SJ
                                        ON SJB.SURAT_JALAN_ID=SJ.SURAT_JALAN_ID
                                        WHERE MONTH(SJ.SURAT_JALAN_TANGGAL) = ' . $bulan . ' 
                                        AND YEAR(SJ.SURAT_JALAN_TANGGAL) = ' . $tahun . '
                                        AND SJ.SURAT_JALAN_JENIS="penjualan"
                                        AND SJ.SURAT_JALAN_STATUS_JENIS="liquid"
                                        AND SJB.RECORD_STATUS="AKTIF" 
                                        AND SJB.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                        AND SJ.RECORD_STATUS="AKTIF" 
                                        AND SJ.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        foreach ($hasil['liquid'] as $row) {
            $row->TOTAL = $row->ISI + $row->KOSONG - $row->KLAIM;
        }

        $hasil['oleh'] = $this->db->query('SELECT * FROM USER WHERE USER_ID="' . $hasil['gaji'][0]->USER . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }

    public function laporan_penjualan($dari, $sampai)
    {
        if (empty($this->input->post("relasi"))) {
            $filter_relasi = "";
        } else {
            $filter_relasi = 'AND MASTER_RELASI_ID="' . $this->input->post("relasi") . '"';
        }

        if (empty($this->input->post("jenis"))) {
            $filter_jenis = "";
        } else {
            $filter_jenis = 'AND SURAT_JALAN_STATUS_JENIS="' . $this->input->post("jenis") . '"';
        }

        $tanggal_dari = $dari;
        $tanggal_sampai = $sampai;

        $filter_tanggal = 'SURAT_JALAN_TANGGAL BETWEEN "' . $tanggal_dari . '" AND "' . $tanggal_sampai . '"';

        $hasil = $this->db->query('SELECT * 
                            FROM 
                            SURAT_JALAN 
                            WHERE 
                            ' . $filter_tanggal . '
                            ' . $filter_relasi . '
                            ' . $filter_jenis . '
                            AND SURAT_JALAN_JENIS = "penjualan"
                            AND NOT SURAT_JALAN_STATUS="cancel"
                            AND RECORD_STATUS="AKTIF" 
                            AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                            ORDER BY SURAT_JALAN_NOMOR ')->result();
        foreach ($hasil as $row) {
            $row->RELASI = $this->db->query('SELECT MASTER_RELASI_NAMA FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();

            $total_perbarang = 0;
            if ($row->SURAT_JALAN_STATUS == "open") {

                $barang = $this->db->query('SELECT * FROM
                                                        SURAT_JALAN_BARANG AS SJ 
                                                        LEFT JOIN
                                                        MASTER_BARANG AS B
                                                        ON SJ.MASTER_BARANG_ID = B.MASTER_BARANG_ID
                                                        WHERE SJ.SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '"
                                                        AND SJ.RECORD_STATUS="AKTIF" 
                                                        AND SJ.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                                        AND B.RECORD_STATUS="AKTIF" 
                                                        AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
                foreach ($barang as $row_barang) {
                    $row_barang->NAMA_BARANG = $this->db->query('SELECT MASTER_BARANG_NAMA FROM MASTER_BARANG WHERE MASTER_BARANG_ID="' . $row_barang->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
                    $row_barang->HARGA_BARANG = $this->db->query('SELECT * FROM MASTER_HARGA WHERE MASTER_BARANG_ID="' . $row_barang->MASTER_BARANG_ID . '" AND MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
                    if (count($row_barang->HARGA_BARANG) == 0) {
                        $total_perbarang += $row_barang->MASTER_BARANG_HARGA_SATUAN * ($row_barang->SURAT_JALAN_BARANG_QUANTITY - $row_barang->SURAT_JALAN_BARANG_QUANTITY_KLAIM);
                    } else {
                        $total_perbarang += $row_barang->HARGA_BARANG[0]->MASTER_HARGA_HARGA * ($row_barang->SURAT_JALAN_BARANG_QUANTITY - $row_barang->SURAT_JALAN_BARANG_QUANTITY_KLAIM);
                    }
                }

                $terbayar = array();
                $akun = array();
            } else if ($row->SURAT_JALAN_STATUS == "close") {
                $faktur = $this->db->query('SELECT 
                                            FSJ.FAKTUR_ID ,
                                            F.AKUN_ID 
                                            FROM 
                                            FAKTUR AS F
                                            LEFT JOIN
                                            FAKTUR_SURAT_JALAN AS FSJ
                                            ON F.FAKTUR_ID=FSJ.FAKTUR_ID
                                            WHERE FSJ.SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" 
                                            AND F.RECORD_STATUS="AKTIF" 
                                            AND F.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                            AND FSJ.RECORD_STATUS="AKTIF" 
                                            AND FSJ.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();

                $barang = $this->db->query('SELECT * FROM FAKTUR_BARANG WHERE FAKTUR_ID="' . $faktur[0]->FAKTUR_ID . '" AND SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" AND RECORD_STATUS="AKTIF" 
                                            AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();
                $akun = $this->db->query('SELECT AKUN_NAMA FROM AKUN WHERE AKUN_ID="' . $faktur[0]->AKUN_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();

                foreach ($barang as $row_barang) {
                    $row_barang->NAMA_BARANG = $this->db->query('SELECT MASTER_BARANG_NAMA FROM MASTER_BARANG WHERE MASTER_BARANG_ID="' . $row_barang->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
                    $row_barang->HARGA_BARANG = $this->db->query('SELECT * FROM FAKTUR_BARANG WHERE FAKTUR_ID="' . $faktur[0]->FAKTUR_ID . '" AND MASTER_BARANG_ID="' . $row_barang->MASTER_BARANG_ID . '" AND SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
                    $total_perbarang += $row_barang->HARGA_BARANG[0]->FAKTUR_BARANG_QUANTITY * $row_barang->HARGA_BARANG[0]->FAKTUR_BARANG_HARGA;
                }
                $terbayar = $this->db->query('SELECT * FROM FAKTUR_TRANSAKSI
                                                                    WHERE
                                                                    FAKTUR_ID="' . $faktur[0]->FAKTUR_ID . '"
                                                                    AND RECORD_STATUS="AKTIF" 
                                                                    AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
            }

            $row->BARANG = $barang;
            $row->TOTAL = $total_perbarang;
            $row->AKUN = $akun;
            $row->TERBAYAR = $terbayar;
            $row->TANGGAL = tanggal($row->SURAT_JALAN_TANGGAL);
            $row->JAM = jam($row->ENTRI_WAKTU);
        }
        return $hasil;
    }

    public function laporan_barang($dari, $sampai)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_BARANG WHERE RECORD_STATUS="AKTIF"  AND NOT MASTER_BARANG_PRIORITAS="0" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY MASTER_BARANG_PRIORITAS DESC')->result();
        foreach ($hasil as $row) {
            if (empty($this->input->post("relasi"))) {
                $filter_relasi = "";
            } else {
                $filter_relasi = 'AND SJ.MASTER_RELASI_ID="' . $this->input->post("relasi") . '"';
            }

            $tanggal_dari = $dari;
            $tanggal_sampai = $sampai;

            $filter_tanggal = 'SJ.SURAT_JALAN_TANGGAL BETWEEN "' . $tanggal_dari . '" AND "' . $tanggal_sampai . '"';

            $barang = $this->db->query('SELECT SUM(SJB.SURAT_JALAN_BARANG_QUANTITY) AS QTY, SUM(SJB.SURAT_JALAN_BARANG_QUANTITY_KLAIM) AS QTY_KLAIM FROM 
                                        SURAT_JALAN_BARANG SJB LEFT JOIN SURAT_JALAN AS SJ
                                        ON SJB.SURAT_JALAN_ID=SJ.SURAT_JALAN_ID
                                        WHERE 
                                        SJ.SURAT_JALAN_JENIS="penjualan"
                                        AND SJB.MASTER_BARANG_ID ="' . $row->MASTER_BARANG_ID . '"
                                        AND ' . $filter_tanggal . '
                                        ' . $filter_relasi . '
                                        AND SJB.RECORD_STATUS="AKTIF" 
                                        AND SJB.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                        AND SJ.RECORD_STATUS="AKTIF" 
                                        AND SJ.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
            $row->QTY = $barang;
            $qty = $barang[0]->QTY;
            $qty_klaim = $barang[0]->QTY_KLAIM;
            $row->TOTAL = $qty - $qty_klaim;
        }
        return $hasil;
    }
    public function laporan_produksi($dari, $sampai)
    {
        $tanggal_dari = $dari;
        $tanggal_sampai = $sampai;

        $filter_tanggal = 'PRODUKSI_TANGGAL BETWEEN "' . $tanggal_dari . '" AND "' . $tanggal_sampai . '"';

        $hasil = $this->db->query('SELECT * FROM PRODUKSI WHERE ' . $filter_tanggal . ' AND RECORD_STATUS="AKTIF"  AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY PRODUKSI_TANGGAL DESC')->result();
        foreach ($hasil as $row) {
            $barang = $this->db->query('SELECT * FROM 
                                        PRODUKSI_BARANG PB LEFT JOIN MASTER_BARANG AS B
                                        ON PB.MASTER_BARANG_ID=B.MASTER_BARANG_ID
                                        WHERE 
                                        PB.PRODUKSI_ID ="' . $row->PRODUKSI_ID . '"
                                        AND PB.RECORD_STATUS="AKTIF" 
                                        AND PB.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                        AND B.RECORD_STATUS="AKTIF" 
                                        AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            $row->BARANG = $barang;
        }
        return $hasil;
    }
}
