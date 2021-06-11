<?php
class MenuModel extends CI_Model
{

    public function list()
    {
        if (empty($_GET['menu_filter'])) {
            $filter = '';
        } else {
            $filter = 'AND M.APLIKASI_ID="' . $_GET['menu_filter'] . '"';
        }

        $hasil = $this->db->query('SELECT * FROM MENU AS M 
        LEFT JOIN APLIKASI AS A ON M.APLIKASI_ID=A.APLIKASI_ID
        WHERE M.RECORD_STATUS="AKTIF" AND A.RECORD_STATUS="AKTIF" ' . $filter . ' ORDER BY A.APLIKASI_LINK ASC ')->result();
        return $hasil;
    }

    public function add()
    {
        if ($this->input->post('id') == "") {
            $data = array(
                'MENU_ID' => create_id(),
                'APLIKASI_ID' => $this->input->post('aplikasi'),
                'MENU_NAMA' => $this->input->post('nama'),
                'MENU_LINK' => $this->input->post('link'),
                'MENU_ICON' => $this->input->post('icon'),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
            );

            $result = $this->db->insert('MENU', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d G:i:s"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
            );

            $this->db->where('MENU_ID', $this->input->post('id'));
            $edit = $this->db->update('MENU', $data_edit);

            $data = array(
                'MENU_ID' => $this->input->post('id'),
                'APLIKASI_ID' => $this->input->post('aplikasi'),
                'MENU_NAMA' => $this->input->post('nama'),
                'MENU_LINK' => $this->input->post('link'),
                'MENU_ICON' => $this->input->post('icon'),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
            );

            $result = $this->db->insert('MENU', $data);
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

        $this->db->where('MENU_ID', $id);
        $result = $this->db->update('MENU', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM MENU WHERE MENU_ID="' . $id . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }
}
