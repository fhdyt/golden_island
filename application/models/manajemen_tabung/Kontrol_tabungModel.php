<?php
class Kontrol_tabungModel extends CI_Model
{

    public function relasi_list()
    {
        if (empty($this->input->post('nama_relasi'))) {
            $filter = '';
        } else {
            $filter = 'MASTER_RELASI_NAMA LIKE "%' . $this->input->post('nama_relasi') . '%" AND';
        }
        $hasil = $this->db->query('SELECT * FROM MASTER_RELASI WHERE ' . $filter . ' RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY MASTER_RELASI_NAMA ')->result();
        return $hasil;
    }

    public function relasi_detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        return $hasil;
    }

    public function kontrol_tabung_list($id, $tabung, $status)
    {
        if (empty($status)) {
            $filter_status = "";
        } else {
            $filter_status = 'AND JURNAL_TABUNG_STATUS="' . $status . '"';
        }
        $hasil = $this->db->query('SELECT * FROM JURNAL_TABUNG WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" AND MASTER_RELASI_ID="' . $id . '" AND MASTER_BARANG_ID="' . $tabung . '" ' . $filter_status . ' ORDER BY JURNAL_TABUNG_TANGGAL ASC ')->result();
        foreach ($hasil as $row) {
            $nama_barang = $this->db->query('SELECT MASTER_BARANG_NAMA FROM MASTER_BARANG WHERE MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"');
            $row->NAMA_BARANG = $nama_barang;
            $row->TANGGAL = tanggal($row->JURNAL_TABUNG_TANGGAL);
            $row->TOTAL = $row->JURNAL_TABUNG_KIRIM - $row->JURNAL_TABUNG_KEMBALI;
        }

        return $hasil;
    }
    public function add_jurnal()
    {
        $data = array(
            'JURNAL_TABUNG_ID' => create_id(),
            'MASTER_RELASI_ID' => $this->input->post('relasi'),
            'MASTER_BARANG_ID' => $this->input->post('tabung'),
            'JURNAL_FORM_ID' => $this->input->post('id'),
            'JURNAL_TABUNG_TANGGAL' => $this->input->post('tanggal'),
            'JURNAL_TABUNG_KIRIM' => $this->input->post('kirim'),
            'JURNAL_TABUNG_KEMBALI' => $this->input->post('kembali'),
            'JURNAL_TABUNG_STATUS' => $this->input->post('status'),
            'JURNAL_TABUNG_KETERANGAN' => "",
            'JURNAL_TABUNG_FILE' => "empty",

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DRAFT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('JURNAL_TABUNG', $data);
        return $result;
    }
    public function list_jurnal($id)
    {
        $hasil = $this->db->query('SELECT * FROM JURNAL_TABUNG WHERE JURNAL_FORM_ID="' . $id . '" AND RECORD_STATUS="DRAFT" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        foreach ($hasil as $row) {
            $nama_barang = $this->db->query('SELECT MASTER_BARANG_NAMA FROM MASTER_BARANG WHERE MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            $row->NAMA_BARANG = $nama_barang;
        }
        return $hasil;
    }

    public function hapus_kontrol_tabung($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('JURNAL_TABUNG_ID', $id);
        $result = $this->db->update('JURNAL_TABUNG', $data);
        return $result;
    }
    public function hapus_jurnal($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('JURNAL_TABUNG_ID', $id);
        $result = $this->db->update('JURNAL_TABUNG', $data);
        return $result;
    }

    public function add()
    {
        $data = array(
            'MASTER_RELASI_ID' => $this->input->post('relasi'),
            'JURNAL_TABUNG_TANGGAL' => $this->input->post('tanggal_kirim'),
            'JURNAL_TABUNG_TANGGAL_KEMBALI' => $this->input->post('tanggal_kembali'),
            'JURNAL_TABUNG_KETERANGAN' => $this->input->post('keterangan'),
            'SURAT_JALAN_NOMOR' => $this->input->post('surat_jalan_nomor'),
            'TTBK_NOMOR' => $this->input->post('ttbk_nomor'),
            'RECORD_STATUS' => "AKTIF",
        );

        $this->db->where('JURNAL_FORM_ID', $this->input->post('id'));
        $result = $this->db->update('JURNAL_TABUNG', $data);
        return $result;
    }
}
