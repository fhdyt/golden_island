<?php
class KaryawanModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_KARYAWAN WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY MASTER_KARYAWAN_NAMA ')->result();
        return $hasil;
    }
    public function produksi_list()
    {
        $hasil = $this->db->query('SELECT * 
                                FROM PRODUKSI_KARYAWAN AS PK 
                                LEFT JOIN 
                                PRODUKSI AS P
                                ON
                                PK.PRODUKSI_ID=P.PRODUKSI_ID
                                WHERE 
                                MONTH(P.PRODUKSI_TANGGAL) = ' . $this->input->post('bulan') . ' 
                                        AND YEAR(P.PRODUKSI_TANGGAL) = ' . $this->input->post('tahun') . '
                                        AND PK.MASTER_KARYAWAN_ID="' . $this->input->post('id') . '" 
                                AND PK.RECORD_STATUS="AKTIF" 
                                AND PK.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                AND P.RECORD_STATUS="AKTIF" 
                                AND P.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                ORDER BY P.PRODUKSI_NOMOR, P.PRODUKSI_TANGGAL  ASC ')->result();
        foreach ($hasil as $row) {
            $row->TANGGAL = tanggal($row->PRODUKSI_TANGGAL);
        }
        return $hasil;
    }

    public function penjualan_list()
    {
        $hasil['gas'] = $this->db->query('SELECT
                                        SUM(SJB.SURAT_JALAN_BARANG_QUANTITY) AS ISI,
                                        SUM(SJB.SURAT_JALAN_BARANG_QUANTITY_KOSONG) AS KOSONG,
                                        SUM(SJB.SURAT_JALAN_BARANG_QUANTITY_KLAIM) AS KLAIM
                                        FROM 
                                        SURAT_JALAN_BARANG AS SJB
                                        LEFT JOIN
                                        SURAT_JALAN AS SJ
                                        ON SJB.SURAT_JALAN_ID=SJ.SURAT_JALAN_ID
                                        WHERE MONTH(SJ.SURAT_JALAN_TANGGAL) = ' . $this->input->post('bulan') . ' 
                                        AND YEAR(SJ.SURAT_JALAN_TANGGAL) = ' . $this->input->post('tahun') . '
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
                                        WHERE MONTH(SJ.SURAT_JALAN_TANGGAL) = ' . $this->input->post('bulan') . ' 
                                        AND YEAR(SJ.SURAT_JALAN_TANGGAL) = ' . $this->input->post('tahun') . '
                                        AND SJ.SURAT_JALAN_JENIS="penjualan"
                                        AND SJ.SURAT_JALAN_STATUS_JENIS="liquid"
                                        AND SJB.RECORD_STATUS="AKTIF" 
                                        AND SJB.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                        AND SJ.RECORD_STATUS="AKTIF" 
                                        AND SJ.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        foreach ($hasil['liquid'] as $row) {
            $row->TOTAL = $row->ISI + $row->KOSONG - $row->KLAIM;
        }
        return $hasil;
    }

    public function surat_jalan_list()
    {

        $hasil = $this->db->query('SELECT * 
                                FROM SURAT_JALAN WHERE 
                                MONTH(SURAT_JALAN_TANGGAL) = ' . $this->input->post('bulan') . ' 
                                        AND YEAR(SURAT_JALAN_TANGGAL) = ' . $this->input->post('tahun') . '
                                        AND DRIVER_ID="' . $this->input->post('id') . '" 
                                AND RECORD_STATUS="AKTIF" 
                                AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                ORDER BY SURAT_JALAN_NOMOR ASC ')->result();
        foreach ($hasil as $row) {
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
        return $hasil;
    }

    public function list_driver()
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_KARYAWAN WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" AND MASTER_KARYAWAN_JABATAN="Driver" ORDER BY MASTER_KARYAWAN_NAMA ASC ')->result();
        return $hasil;
    }

    public function add()
    {
        if ($this->input->post('id') == "") {
            $data = array(
                'MASTER_KARYAWAN_ID' => create_id(),
                'MASTER_KARYAWAN_NAMA' => $this->input->post('nama'),
                'MASTER_KARYAWAN_JABATAN' => $this->input->post('jabatan'),
                'MASTER_KARYAWAN_ALAMAT' => $this->input->post('alamat'),
                'MASTER_KARYAWAN_HP' => $this->input->post('hp'),
                'MASTER_KARYAWAN_KTP' => $this->input->post('ktp'),
                'MASTER_KARYAWAN_GAJI_POKOK' => str_replace(".", "", $this->input->post('gaji')),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('MASTER_KARYAWAN', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d G:i:s"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->where('MASTER_KARYAWAN_ID', $this->input->post('id'));
            $edit = $this->db->update('MASTER_KARYAWAN', $data_edit);

            $data = array(
                'MASTER_KARYAWAN_ID' => $this->input->post('id'),
                'MASTER_KARYAWAN_NAMA' => $this->input->post('nama'),
                'MASTER_KARYAWAN_JABATAN' => $this->input->post('jabatan'),
                'MASTER_KARYAWAN_ALAMAT' => $this->input->post('alamat'),
                'MASTER_KARYAWAN_HP' => $this->input->post('hp'),
                'MASTER_KARYAWAN_KTP' => $this->input->post('ktp'),
                'MASTER_KARYAWAN_GAJI_POKOK' => str_replace(".", "", $this->input->post('gaji')),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('MASTER_KARYAWAN', $data);
            return $result;
        }
    }

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('MASTER_KARYAWAN_ID', $id);
        $result = $this->db->update('MASTER_KARYAWAN', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_KARYAWAN WHERE MASTER_KARYAWAN_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        return $hasil;
    }

    public function add_konfigurasi()
    {
        $data_edit = array(
            'EDIT_WAKTU' => date("Y-m-d G:i:s"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('MASTER_KARYAWAN_ID', $this->input->post('id'));
        $edit = $this->db->update('GAJI_KONFIGURASI', $data_edit);

        $data = array(
            'GAJI_KONFIGURASI_ID' => create_id(),
            'MASTER_KARYAWAN_ID' => str_replace(".", "", $this->input->post('id')),
            'GAJI_KONFIGURASI_POKOK' => str_replace(".", "", $this->input->post('gaji_pokok')),
            'GAJI_KONFIGURASI_JABATAN' => str_replace(".", "", $this->input->post('tunjangan_jabatan')),
            'GAJI_KONFIGURASI_TRANSPORTASI' => str_replace(".", "", $this->input->post('tunjangan_transportasi')),
            'GAJI_KONFIGURASI_KOMUNIKASI' => str_replace(".", "", $this->input->post('tunjangan_komunikasi')),
            'GAJI_KONFIGURASI_UANG_MAKAN' => str_replace(".", "", $this->input->post('uang_makan')),
            'GAJI_KONFIGURASI_PERSENTASE_PREMI' => str_replace(".", "", $this->input->post('persentase_premi')),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('GAJI_KONFIGURASI', $data);
        return $result;
    }

    public function detail_konfigurasi($id)
    {
        $hasil = $this->db->query('SELECT * FROM GAJI_KONFIGURASI WHERE MASTER_KARYAWAN_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        return $hasil;
    }
}
