<?php
class DriverModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_DRIVER WHERE RECORD_STATUS="AKTIF" ORDER BY MASTER_DRIVER_INDEX DESC ')->result();
        return $hasil;
    }

    public function add()
    {
        if ($this->input->post('id') == "") {
            $data = array(
                'MASTER_DRIVER_ID' => create_id(),
                'MASTER_DRIVER_NAMA' => $this->input->post('nama'),
                'MASTER_DRIVER_ALAMAT' => $this->input->post('alamat'),
                'MASTER_DRIVER_HP' => $this->input->post('hp'),
                'MASTER_DRIVER_SIM' => $this->input->post('sim'),
                'MASTER_DRIVER_KTP' => $this->input->post('ktp'),

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
            );

            $result = $this->db->insert('MASTER_DRIVER', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
            );

            $this->db->where('MASTER_DRIVER_ID', $this->input->post('id'));
            $edit = $this->db->update('MASTER_DRIVER', $data_edit);

            $data = array(
                'MASTER_DRIVER_ID' => $this->input->post('id'),
                'MASTER_DRIVER_NAMA' => $this->input->post('nama'),
                'MASTER_DRIVER_ALAMAT' => $this->input->post('alamat'),
                'MASTER_DRIVER_HP' => $this->input->post('hp'),
                'MASTER_DRIVER_SIM' => $this->input->post('sim'),
                'MASTER_DRIVER_KTP' => $this->input->post('ktp'),

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
            );

            $result = $this->db->insert('MASTER_DRIVER', $data);
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

        $this->db->where('MASTER_DRIVER_ID', $id);
        $result = $this->db->update('MASTER_DRIVER', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_DRIVER WHERE MASTER_DRIVER_ID="' . $id . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }
}
