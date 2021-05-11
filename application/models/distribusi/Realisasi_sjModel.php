<?php
class Realisasi_sjModel extends CI_Model
{

    public function list_realisasi($driver_id)
    {

        $hasil = $this->db->query('SELECT * FROM SURAT_JALAN WHERE DRIVER_ID="' . $driver_id . '" AND SURAT_JALAN_STATUS="open" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY SURAT_JALAN_NOMOR')->result();
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
                $row_barang->TOTAL = $row_barang->SURAT_JALAN_BARANG_QUANTITY + $row_barang->SURAT_JALAN_BARANG_QUANTITY_KOSONG + $row_barang->SURAT_JALAN_BARANG_QUANTITY_KLAIM;
            }
            $row->BARANG = $barang;

            $row->TANGGAL = tanggal($row->SURAT_JALAN_TANGGAL);
        }
        return $hasil;
    }

    public function detail_driver($driver_id)
    {
        $hasil = $this->db->query('SELECT MASTER_KARYAWAN_NAMA FROM MASTER_KARYAWAN WHERE MASTER_KARYAWAN_ID="' . $driver_id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        return $hasil;
    }

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_KARYAWAN WHERE MASTER_KARYAWAN_JABATAN="Driver" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY MASTER_KARYAWAN_NAMA ')->result();
        foreach ($hasil as $row) {
            $sj = $this->db->query('SELECT * FROM SURAT_JALAN WHERE DRIVER_ID="' . $row->MASTER_KARYAWAN_ID . '" AND SURAT_JALAN_STATUS="open" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY SURAT_JALAN_TANGGAL DESC ')->result();
            foreach ($sj as $row_sj) {
                $relasi = $this->db->query('SELECT * FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $row_sj->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"  LIMIT 1 ')->result();
                $row_sj->RELASI = $relasi;
                $supplier = $this->db->query('SELECT * FROM MASTER_SUPPLIER WHERE MASTER_SUPPLIER_ID="' . $row_sj->MASTER_SUPPLIER_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"  LIMIT 1 ')->result();
                $row_sj->SUPPLIER = $supplier;
                $row_sj->TANGGAL = tanggal($row_sj->SURAT_JALAN_TANGGAL);
            }
            $row->SURAT_JALAN = $sj;
        }
        return $hasil;
    }

    public function list_realisasi_tabung($id_realisasi)
    {
        $hasil = $this->db->query('SELECT * FROM 
                                    REALISASI_BARANG AS R
                                    LEFT JOIN MASTER_TABUNG AS T
                                    ON 
                                    R.MASTER_TABUNG_ID = T.MASTER_TABUNG_ID
                                    WHERE 
                                    R.REALISASI_ID="' . $id_realisasi . '" 
                                    AND (R.RECORD_STATUS="AKTIF" OR R.RECORD_STATUS="DRAFT") 
                                    AND R.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                    AND T.RECORD_STATUS="AKTIF"
                                    AND T.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();
        return $hasil;
    }

    public function add()
    {
        $hasil = $this->db->query('SELECT * FROM SURAT_JALAN WHERE DRIVER_ID="' . $this->input->post('id_driver') . '" AND SURAT_JALAN_STATUS="open" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY SURAT_JALAN_NOMOR')->result();
        foreach ($hasil as $row) {
            $data = array(
                'REALISASI_ID' => $this->input->post('id_realisasi'),
            );

            $this->db->where('SURAT_JALAN_ID', $row->SURAT_JALAN_ID);
            $this->db->where('RECORD_STATUS', "AKTIF");
            $this->db->update('SURAT_JALAN', $data);
        }
        return true;
    }

    public function add_barang($realisasi_id)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_TABUNG WHERE MASTER_TABUNG_ID="' . $this->input->post('tabung') . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        $data = array(
            'REALISASI_BARANG_ID' => create_id(),
            'REALISASI_ID' => $realisasi_id,
            'MASTER_BARANG_ID' => $hasil[0]->MASTER_BARANG_ID,
            'MASTER_TABUNG_ID' => $this->input->post('tabung'),

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('REALISASI_BARANG', $data);
        return $result;
    }

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('REALISASI_BARANG_ID', $id);
        $result = $this->db->update('REALISASI_BARANG', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_KARYAWAN WHERE MASTER_KARYAWAN_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        return $hasil;
    }
}
