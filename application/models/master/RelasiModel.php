<?php
class RelasiModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_RELASI WHERE RECORD_STATUS="AKTIF" ORDER BY MASTER_RELASI_INDEX DESC ')->result();
        return $hasil;
    }

    public function add()
    {
        if ($this->input->post('id') == "") {
            $data = array(
                'MASTER_RELASI_ID' => create_id(),
                'MASTER_RELASI_NAMA' => $this->input->post('nama'),
                'MASTER_RELASI_ALAMAT' => $this->input->post('alamat'),
                'MASTER_RELASI_HP' => $this->input->post('hp'),
                'MASTER_RELASI_NPWP' => $this->input->post('npwp'),
                'MASTER_RELASI_KTP' => $this->input->post('ktp'),

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
            );

            $result = $this->db->insert('MASTER_RELASI', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
            );

            $this->db->where('MASTER_RELASI_ID', $this->input->post('id'));
            $edit = $this->db->update('MASTER_RELASI', $data_edit);

            $data = array(
                'MASTER_RELASI_ID' => $this->input->post('id'),
                'MASTER_RELASI_NAMA' => $this->input->post('nama'),
                'MASTER_RELASI_ALAMAT' => $this->input->post('alamat'),
                'MASTER_RELASI_HP' => $this->input->post('hp'),
                'MASTER_RELASI_NPWP' => $this->input->post('npwp'),
                'MASTER_RELASI_KTP' => $this->input->post('ktp'),

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
            );

            $result = $this->db->insert('MASTER_RELASI', $data);
            return $result;
        }
    }

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
        );

        $this->db->where('MASTER_RELASI_ID', $id);
        $result = $this->db->update('MASTER_RELASI', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $id . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }

    public function harga_list()
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_JENIS_BARANG WHERE RECORD_STATUS="AKTIF" ORDER BY MASTER_JENIS_BARANG_NAMA ASC ')->result();
        foreach ($hasil as $row) {
            $detail = $this->db->query('SELECT * FROM MASTER_JENIS_BARANG_DETAIL WHERE MASTER_JENIS_BARANG_ID="' . $row->MASTER_JENIS_BARANG_ID . '" AND RECORD_STATUS="AKTIF"')->result();
            $row->DETAIL = $detail;
        }
        return $hasil;
    }
}
