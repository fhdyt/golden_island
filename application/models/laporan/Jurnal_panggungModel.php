<?php
class Jurnal_panggungModel extends CI_Model
{

    public function list()
    {
        if (empty($this->input->post('relasi'))) {
            $filter_relasi = "";
        } else {
            $filter_relasi = 'AND MASTER_RELASI_ID="' . $this->input->post('relasi') . '"';
        }
        if (empty($this->input->post('supplier'))) {
            $filter_supplier = "";
        } else {
            $filter_supplier = 'AND MASTER_SUPPLIER_ID="' . $this->input->post('supplier') . '"';
        }

        if (empty($this->input->post('tabung'))) {
            $filter_tabung = "";
        } else {
            $filter_tabung = 'AND MASTER_BARANG_ID="' . $this->input->post('tabung') . '"';
        }

        if (empty($this->input->post('status'))) {
            $filter_status = "";
        } else {
            $filter_status = 'AND PANGGUNG_STATUS_KEPEMILIKAN="' . $this->input->post('status') . '"';
        }

        if (empty($this->input->post('in_out'))) {
            $filter_in_out_status = "";
        } else {
            $filter_in_out_status = 'AND PANGGUNG_STATUS="' . $this->input->post('in_out') . '"';
        }

        if (empty($this->input->post('isi_kosong'))) {
            $filter_isi_kosong_status = "";
        } else {
            $filter_isi_kosong_status = 'AND PANGGUNG_STATUS_ISI="' . $this->input->post('isi_kosong') . '"';
        }

        $tanggal_dari = $this->input->post("tanggal_dari");
        $tanggal_sampai = $this->input->post("tanggal_sampai");

        if (empty($this->input->post('keterangan'))) {
            $filter_keterangan = "";
            $filter_tanggal = 'AND PANGGUNG_TANGGAL BETWEEN "' . $tanggal_dari . '" AND "' . $tanggal_sampai . '"';
        } else {
            $filter_keterangan = 'AND PANGGUNG_KETERANGAN LIKE "%' . $this->input->post('keterangan') . '%"';
            $filter_tanggal = "";
        }



        $hasil = $this->db->query('SELECT * FROM 
        PANGGUNG 
        WHERE 
        RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
        ' . $filter_tanggal . '
        ' . $filter_relasi . '
        ' . $filter_supplier . '
        ' . $filter_status . '
        ' . $filter_tabung . '
        ' . $filter_keterangan . '
        ' . $filter_in_out_status . '
        ' . $filter_isi_kosong_status . ' ORDER BY PANGGUNG_KETERANGAN')->result();
        foreach ($hasil as $row) {
            $nama_barang = $this->db->query('SELECT MASTER_BARANG_NAMA FROM MASTER_BARANG WHERE MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"');
            $relasi_nama = $this->db->query('SELECT MASTER_RELASI_NAMA FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"');
            $supplier_nama = $this->db->query('SELECT MASTER_SUPPLIER_NAMA FROM MASTER_SUPPLIER WHERE MASTER_SUPPLIER_ID="' . $row->MASTER_SUPPLIER_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"');
            $row->RELASI_NAMA = $relasi_nama->result();
            $row->SUPPLIER_NAMA = $supplier_nama->result();
            $row->NAMA_BARANG = $nama_barang->result();
            $row->TANGGAL = tanggal($row->PANGGUNG_TANGGAL);
            // $row->TOTAL = $row->JURNAL_TABUNG_KEMBALI - $row->JURNAL_TABUNG_KIRIM;
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
