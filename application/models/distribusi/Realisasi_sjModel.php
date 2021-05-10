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

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('MASTER_KARYAWAN', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
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

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
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
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
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
