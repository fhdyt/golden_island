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

    public function harga_list($id)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_BARANG WHERE RECORD_STATUS="AKTIF" ORDER BY MASTER_BARANG_NAMA AND MASTER_BARANG_JENIS="gas" ASC ')->result();
        foreach ($hasil as $row) {
            $harga = $this->db->query('SELECT * FROM 
            MASTER_HARGA WHERE MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '" AND MASTER_RELASI_ID="' . $id . '" AND RECORD_STATUS="AKTIF"');
            if ($harga->num_rows() == 0) {
                $row->HARGA = array([]);
            } else {
                $row->HARGA = $harga->result();
            }
        }
        return $hasil;
    }

    public function add_harga($user)
    {
        $cek = $this->db->query('SELECT * FROM MASTER_HARGA WHERE MASTER_RELASI_ID="' . $user . '" AND MASTER_BARANG_ID="' . $this->input->post('id_detail') . '" AND RECORD_STATUS="AKTIF"');
        if ($cek->num_rows() == 0) {
            $data = array(
                'MASTER_HARGA_ID' => create_id(),
                'MASTER_RELASI_ID' => $user,
                'MASTER_BARANG_ID' => $this->input->post('id_detail'),
                'MASTER_HARGA_HARGA' => str_replace(".", "", $this->input->post('harga')),

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
            );

            $result = $this->db->insert('MASTER_HARGA', $data);
            return $result;
        } else {
            $harga = $cek->result();
            $data_delete = array(
                'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
                'DELETE_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "DELETE",
            );

            $this->db->where('MASTER_HARGA_ID', $harga[0]->MASTER_HARGA_ID);
            $result_delete = $this->db->update('MASTER_HARGA', $data_delete);

            $data = array(
                'MASTER_HARGA_ID' => create_id(),
                'MASTER_RELASI_ID' => $user,
                'MASTER_JENIS_BARANG_DETAIL_ID' => $this->input->post('id_detail'),
                'MASTER_HARGA_HARGA' => str_replace(".", "", $this->input->post('harga')),

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
            );

            $result = $this->db->insert('MASTER_HARGA', $data);
            return $result;
        }
    }
}
