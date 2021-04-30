<?php
class HutangModel extends CI_Model
{

    public function list($supplier, $pi)
    {
        $hasil = $this->db->query('SELECT * FROM HUTANG WHERE MASTER_SUPPLIER_ID="' . $supplier . '" AND HUTANG_REF="' . $pi . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY HUTANG_TANGGAL ASC')->result();
        foreach ($hasil as $row) {
            $row->TANGGAL = tanggal($row->HUTANG_TANGGAL);
            $row->SALDO = $row->HUTANG_DEBET - $row->HUTANG_KREDIT;
        }
        return $hasil;
    }

    public function add()
    {
        if ($this->input->post('id') == "") {
            $data = array(
                'AKUN_ID' => create_id(),
                'AKUN_NAMA' => $this->input->post('nama'),
                'AKUN_KATEGORI' => $this->input->post('kategori'),

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('AKUN', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->where('AKUN_ID', $this->input->post('id'));
            $edit = $this->db->update('AKUN', $data_edit);

            $data = array(
                'AKUN_ID' => $this->input->post('id'),
                'AKUN_NAMA' => $this->input->post('nama'),
                'AKUN_KATEGORI' => $this->input->post('kategori'),

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('AKUN', $data);
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

        $this->db->where('AKUN_ID', $id);
        $result = $this->db->update('AKUN', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM AKUN WHERE AKUN_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        return $hasil;
    }

    public function pi_list($id)
    {
        $hasil = $this->db->query('SELECT * FROM PEMBELIAN WHERE PEMBELIAN_JENIS="PI" AND MASTER_SUPPLIER_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        return $hasil;
    }
}
