<?php
class AplikasiModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM APLIKASI WHERE RECORD_STATUS="AKTIF" ORDER BY APLIKASI_ID DESC ')->result();
        return $hasil;
    }

    public function add()
    {
        if ($this->input->post('id') == "") {
            $data = array(
                'APLIKASI_ID' => create_id(),
                'APLIKASI_NAMA' => $this->input->post('nama'),
                'APLIKASI_LINK' => $this->input->post('link'),
                'APLIKASI_ICON' => $this->input->post('icon'),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
            );

            $result = $this->db->insert('APLIKASI', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d G:i:s"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
            );

            $this->db->where('APLIKASI_ID', $this->input->post('id'));
            $edit = $this->db->update('APLIKASI', $data_edit);

            $data = array(
                'APLIKASI_ID' => $this->input->post('id'),
                'APLIKASI_NAMA' => $this->input->post('nama'),
                'APLIKASI_LINK' => $this->input->post('link'),
                'APLIKASI_ICON' => $this->input->post('icon'),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
            );

            $result = $this->db->insert('APLIKASI', $data);
            return $result;
        }
    }

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
        );

        $this->db->where('APLIKASI_ID', $id);
        $result = $this->db->update('APLIKASI', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM APLIKASI WHERE APLIKASI_ID="' . $id . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }
}
