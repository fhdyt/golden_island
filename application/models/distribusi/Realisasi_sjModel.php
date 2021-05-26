<?php
class Realisasi_sjModel extends CI_Model
{

    public function list_realisasi($surat_jalan_id)
    {
        $hasil = $this->db->query('SELECT * FROM SURAT_JALAN WHERE SURAT_JALAN_ID="' . $surat_jalan_id . '" AND SURAT_JALAN_STATUS="open" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY SURAT_JALAN_NOMOR')->result();
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
        $hasil = $this->db->query('SELECT * FROM SURAT_JALAN AS SJ 
                                    LEFT JOIN MASTER_KARYAWAN AS K 
                                    ON SJ.DRIVER_ID=K.MASTER_KARYAWAN_ID 
                                    WHERE SJ.SURAT_JALAN_STATUS="open" 
                                    AND SJ.RECORD_STATUS="AKTIF" 
                                    AND SJ.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                    AND K.RECORD_STATUS="AKTIF" 
                                    AND K.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                    ORDER BY K.MASTER_KARYAWAN_NAMA DESC')->result();
        foreach ($hasil as $row) {
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
        $hasil = $this->db->query('SELECT * FROM 
                                    REALISASI_BARANG AS R
                                    LEFT JOIN MASTER_TABUNG AS T
                                    ON 
                                    R.MASTER_TABUNG_ID = T.MASTER_TABUNG_ID
                                    LEFT JOIN
                                    MASTER_BARANG AS B
                                    ON T.MASTER_BARANG_ID=B.MASTER_BARANG_ID
                                    WHERE 
                                    R.SURAT_JALAN_ID="' . $surat_jalan_id . '" 
                                    AND (R.RECORD_STATUS="AKTIF" OR R.RECORD_STATUS="DRAFT") 
                                    AND R.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                    AND B.RECORD_STATUS="AKTIF"
                                    AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                    AND T.RECORD_STATUS="AKTIF"
                                    AND T.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();
        return $hasil;
    }

    public function list_realisasi_tabung_mr($surat_jalan_id)
    {
        $hasil = $this->db->query('SELECT * FROM 
                                    REALISASI_BARANG_MR AS R
                                    LEFT JOIN MASTER_BARANG AS T
                                    ON 
                                    R.MASTER_BARANG_ID = T.MASTER_BARANG_ID
                                    WHERE 
                                    R.SURAT_JALAN_ID="' . $surat_jalan_id . '" 
                                    AND R.RECORD_STATUS="AKTIF" 
                                    AND R.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                    AND T.RECORD_STATUS="AKTIF"
                                    AND T.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();
        return $hasil;
    }

    public function add()
    {
        $surat_jalan = $this->db->query('SELECT * FROM SURAT_JALAN WHERE SURAT_JALAN_ID="' . $this->input->post('surat_jalan_id') . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();

        $data_edit_jurnal = array(
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('JURNAL_TABUNG_REF', $this->input->post("surat_jalan_id"));
        $this->db->update('JURNAL_TABUNG', $data_edit_jurnal);

        $data = array(
            'SURAT_JALAN_REALISASI_STATUS' => "selesai",
            'SURAT_JALAN_REALISASI_JUMLAH_MP' => $this->input->post("total_realisasi"),
            'SURAT_JALAN_REALISASI_JUMLAH_MR' => $this->input->post("total_tabung_mr"),
        );

        $this->db->where('SURAT_JALAN_ID', $this->input->post("surat_jalan_id"));
        $this->db->where('RECORD_STATUS', "AKTIF");
        $this->db->update('SURAT_JALAN', $data);

        $surat_jalan_barang = $this->db->query('SELECT * FROM SURAT_JALAN_BARANG WHERE SURAT_JALAN_ID="' . $this->input->post("surat_jalan_id") . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();
        $realisasi_barang = $this->db->query('SELECT MASTER_BARANG_ID,COUNT(MASTER_BARANG_ID) AS JUMLAH FROM REALISASI_BARANG WHERE SURAT_JALAN_ID="' . $this->input->post("surat_jalan_id") . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" GROUP BY MASTER_BARANG_ID ')->result();
        $realisasi_barang_mr = $this->db->query('SELECT MASTER_BARANG_ID, SUM(REALISASI_BARANG_MR_JUMLAH) AS JUMLAH FROM REALISASI_BARANG_MR WHERE SURAT_JALAN_ID="' . $this->input->post("surat_jalan_id") . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" GROUP BY MASTER_BARANG_ID ')->result();
        foreach ($realisasi_barang as $mp) {
            $data_mp = array(
                'JURNAL_TABUNG_ID' => create_id(),
                'MASTER_RELASI_ID' => $surat_jalan[0]->MASTER_RELASI_ID,
                'MASTER_SUPPLIER_ID' => $surat_jalan[0]->MASTER_SUPPLIER_ID,
                'MASTER_BARANG_ID' => $mp->MASTER_BARANG_ID,
                'JURNAL_TABUNG_TANGGAL' => date("Y-m-d"),
                'JURNAL_TABUNG_KIRIM' => $mp->JUMLAH,
                'JURNAL_TABUNG_KEMBALI' => "",
                'JURNAL_TABUNG_STATUS' => "MP",
                'JURNAL_TABUNG_KETERANGAN' => "SURAT JALAN NO. " . $surat_jalan[0]->SURAT_JALAN_NOMOR . "",
                'JURNAL_TABUNG_FILE' => "empty",
                'JURNAL_TABUNG_REF'  => $this->input->post("surat_jalan_id"),

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
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
                'JURNAL_TABUNG_TANGGAL' => date("Y-m-d"),
                'JURNAL_TABUNG_KIRIM' => $this->input->post("total_tabung_mr"),
                'JURNAL_TABUNG_KEMBALI' => "",
                'JURNAL_TABUNG_STATUS' => "MR",
                'JURNAL_TABUNG_KETERANGAN' => "SURAT JALAN NO. " . $surat_jalan[0]->SURAT_JALAN_NOMOR . "",
                'JURNAL_TABUNG_FILE' => "empty",
                'JURNAL_TABUNG_REF'  => $this->input->post("surat_jalan_id"),

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );
            $this->db->insert('JURNAL_TABUNG', $data_mr);
        }



        return true;
    }

    public function add_barang($surat_jalan_id)
    {
        if ($this->input->post('tabung') == "baru") {
            $id_tabung_realisasi = create_id();
            $data_tabung = array(
                'MASTER_TABUNG_ID' => $id_tabung_realisasi,
                'MASTER_TABUNG_KODE' => kode_tabung(),
                'MASTER_TABUNG_KODE_LAMA' => $this->input->post('kode'),
                'MASTER_BARANG_ID' => $this->input->post('jenis'),
                'MASTER_TABUNG_KEPEMILIKAN' => $this->input->post('kepemilikan'),
                'STOK_BARANG_ID' => "",

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );
            $this->db->insert('MASTER_TABUNG', $data_tabung);

            $data_riwayat_tabung = array(
                'RIWAYAT_TABUNG_ID' => create_id(),
                'MASTER_TABUNG_ID' => $id_tabung_realisasi,
                'RIWAYAT_TABUNG_TANGGAL' => date("Y-m-d"),
                'RIWAYAT_TABUNG_STATUS' => '0',
                'RIWAYAT_TABUNG_KETERANGAN' => '',

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );
            $this->db->insert('RIWAYAT_TABUNG', $data_riwayat_tabung);
        } else {
            $id_tabung_realisasi = $this->input->post('tabung');
        }
        $hasil = $this->db->query('SELECT * FROM MASTER_TABUNG WHERE MASTER_TABUNG_ID="' . $this->input->post('tabung') . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        $data = array(
            'REALISASI_BARANG_ID' => create_id(),
            'SURAT_JALAN_ID' => $surat_jalan_id,
            'MASTER_BARANG_ID' => $hasil[0]->MASTER_BARANG_ID,
            'MASTER_TABUNG_ID' => $id_tabung_realisasi,

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('REALISASI_BARANG', $data);
        return $result;
    }

    public function add_barang_mr($surat_jalan_id)
    {

        $data = array(
            'REALISASI_BARANG_MR_ID' => create_id(),
            'SURAT_JALAN_ID' => $surat_jalan_id,
            'MASTER_BARANG_ID' => $this->input->post('jenis'),
            'REALISASI_BARANG_MR_JUMLAH' => $this->input->post('jumlah'),

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('REALISASI_BARANG_MR', $data);
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
    public function hapus_mr($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('REALISASI_BARANG_MR_ID', $id);
        $result = $this->db->update('REALISASI_BARANG_MR', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM SURAT_JALAN WHERE SURAT_JALAN_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        return $hasil;
    }
}
