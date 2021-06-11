<?php
class PerusahaanModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM PERUSAHAAN WHERE RECORD_STATUS="AKTIF"')->result();
        return $hasil;
    }

    public function add()
    {
        if ($this->input->post('id') == "") {
            $data = array(
                'PERUSAHAAN_ID' => create_id(),
                'PERUSAHAAN_KODE' => $this->input->post('kode'),
                'PERUSAHAAN_NAMA' => $this->input->post('nama'),
                'PERUSAHAAN_ALAMAT' => $this->input->post('alamat'),
                'PERUSAHAAN_TELP' => $this->input->post('telp'),
                'PERUSAHAAN_KOTA' => $this->input->post('kota'),
                'PERUSAHAAN_BANK' => $this->input->post('bank'),
                'PERUSAHAAN_LOGO' => "",

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
            );

            $result = $this->db->insert('PERUSAHAAN', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d G:i:s"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
            );

            $this->db->where('PERUSAHAAN_ID', $this->input->post('id'));
            $edit = $this->db->update('PERUSAHAAN', $data_edit);

            $data = array(
                'PERUSAHAAN_ID' => $this->input->post('id'),
                'PERUSAHAAN_KODE' => $this->input->post('kode'),
                'PERUSAHAAN_NAMA' => $this->input->post('nama'),
                'PERUSAHAAN_ALAMAT' => $this->input->post('alamat'),
                'PERUSAHAAN_TELP' => $this->input->post('telp'),
                'PERUSAHAAN_KOTA' => $this->input->post('kota'),
                'PERUSAHAAN_BANK' => $this->input->post('bank'),
                'PERUSAHAAN_LOGO' => "",

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
            );

            $result = $this->db->insert('PERUSAHAAN', $data);
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

        $this->db->where('PERUSAHAAN_ID', $id);
        $result = $this->db->update('PERUSAHAAN', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM PERUSAHAAN WHERE PERUSAHAAN_ID="' . $id . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }
}
