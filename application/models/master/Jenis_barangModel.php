<?php
class Jenis_barangModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_JENIS_BARANG WHERE RECORD_STATUS="AKTIF" ORDER BY MASTER_JENIS_BARANG_INDEX DESC ')->result();
        return $hasil;
    }

    public function list_detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_JENIS_BARANG_DETAIL WHERE RECORD_STATUS="AKTIF" AND MASTER_JENIS_BARANG_ID="' . $id . '"')->result();
        return $hasil;
    }

    public function add()
    {
        if ($this->input->post('id') == "") {
            $data = array(
                'MASTER_JENIS_BARANG_ID' => create_id(),
                'MASTER_JENIS_BARANG_NAMA' => $this->input->post('nama'),

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
            );

            $result = $this->db->insert('MASTER_JENIS_BARANG', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
            );

            $this->db->where('MASTER_JENIS_BARANG_ID', $this->input->post('id'));
            $edit = $this->db->update('MASTER_JENIS_BARANG', $data_edit);

            $data = array(
                'MASTER_JENIS_BARANG_ID' => $this->input->post('id'),
                'MASTER_JENIS_BARANG_NAMA' => $this->input->post('nama'),

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
            );

            $result = $this->db->insert('MASTER_JENIS_BARANG', $data);
            return $result;
        }
    }


    public function add_detail($id)
    {
        if ($this->input->post('id') == "") {
            $data = array(
                'MASTER_JENIS_BARANG_ID' => $id,
                'MASTER_JENIS_BARANG_DETAIL_ID' => create_id(),
                'MASTER_JENIS_BARANG_DETAIL_KAPASITAS' => $this->input->post('kapasitas'),
                'MASTER_JENIS_BARANG_DETAIL_SATUAN' => $this->input->post('satuan'),

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
            );

            $result = $this->db->insert('MASTER_JENIS_BARANG_DETAIL', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
            );

            $this->db->where('MASTER_JENIS_BARANG_DETAIL_ID', $this->input->post('id'));
            $edit = $this->db->update('MASTER_JENIS_BARANG_DETAIL', $data_edit);

            $data = array(
                'MASTER_JENIS_BARANG_ID' => $id,
                'MASTER_JENIS_BARANG_ID' => $this->input->post('id'),
                'MASTER_JENIS_BARANG_DETAIL_KAPASITAS' => $this->input->post('kapasitas'),
                'MASTER_JENIS_BARANG_DETAIL_SATUAN' => $this->input->post('satuan'),

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
            );

            $result = $this->db->insert('MASTER_JENIS_BARANG_DETAIL', $data);
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

        $this->db->where('MASTER_JENIS_BARANG_ID', $id);
        $result = $this->db->update('MASTER_JENIS_BARANG', $data);
        return $result;
    }

    public function hapus_detail($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
        );

        $this->db->where('MASTER_JENIS_BARANG_DETAIL_ID', $id);
        $result = $this->db->update('MASTER_JENIS_BARANG_DETAIL', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_JENIS_BARANG WHERE MASTER_JENIS_BARANG_ID="' . $id . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }
    public function detail_detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_JENIS_BARANG_DETAIL WHERE MASTER_JENIS_BARANG_DETAIL_ID="' . $id . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }
}
