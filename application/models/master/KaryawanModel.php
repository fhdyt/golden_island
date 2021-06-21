<?php
class KaryawanModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_KARYAWAN WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY MASTER_KARYAWAN_INDEX DESC ')->result();
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
}
