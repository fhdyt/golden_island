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
                                            B.MASTER_BARANG_ID,
                                            SUM(FB.FAKTUR_BARANG_QUANTITY) AS SUM, 
                                            FB.FAKTUR_BARANG_QUANTITY,
                                            FB.FAKTUR_BARANG_HARGA,
                                            B.MASTER_BARANG_NAMA 
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
                                            B.MASTER_BARANG_ID,
                                            FB.FAKTUR_BARANG_QUANTITY,
                                            FB.FAKTUR_BARANG_HARGA,
                                            B.MASTER_BARANG_NAMA')->result();
        $hasil['relasi'] = $this->db->query('SELECT * FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $hasil['detail'][0]->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF"  AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        $hasil['oleh'] = $this->db->query('SELECT * FROM USER WHERE USER_ID="' . $hasil['detail'][0]->ENTRI_USER . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }
}
