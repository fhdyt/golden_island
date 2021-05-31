<?php
class Kontrol_tabungModel extends CI_Model
{

    public function list($relasi, $tabung, $status)
    {
        if (empty($relasi)) {
            $filter_relasi = "";
        } else {
            $filter_relasi = 'AND R.MASTER_RELASI_ID="' . $relasi . '"';
        }

        if (empty($tabung)) {
            $filter_tabung = "";
        } else {
            $filter_tabung = 'AND J.MASTER_BARANG_ID="' . $tabung . '"';
        }

        if (empty($status)) {
            $filter_status = "";
        } else {
            $filter_status = 'AND J.JURNAL_TABUNG_STATUS="' . $status . '"';
        }

        $tanggal_dari = $this->input->post("tanggal_dari");
        $tanggal_sampai = $this->input->post("tanggal_sampai");

        $filter_tanggal = 'AND J.JURNAL_TABUNG_TANGGAL BETWEEN "' . $tanggal_dari . '" AND "' . $tanggal_sampai . '"';

        $hasil = $this->db->query('SELECT * FROM 
        JURNAL_TABUNG AS J LEFT JOIN MASTER_RELASI AS R
        ON J.MASTER_RELASI_ID=R.MASTER_RELASI_ID
        WHERE 
        J.RECORD_STATUS="AKTIF" AND J.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" AND
        R.RECORD_STATUS="AKTIF" AND R.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
        ' . $filter_relasi . '
        ' . $filter_status . '
        ' . $filter_tabung . '
        ORDER BY J.JURNAL_TABUNG_TANGGAL ASC ')->result();
        foreach ($hasil as $row) {
            $nama_barang = $this->db->query('SELECT MASTER_BARANG_NAMA FROM MASTER_BARANG WHERE MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"');
            $row->NAMA_BARANG = $nama_barang->result();
            $row->TANGGAL = tanggal($row->JURNAL_TABUNG_TANGGAL);
            $row->TOTAL = $row->JURNAL_TABUNG_KIRIM - $row->JURNAL_TABUNG_KEMBALI;
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
