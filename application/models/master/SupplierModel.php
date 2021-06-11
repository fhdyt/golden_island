<?php
class SupplierModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_SUPPLIER WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY MASTER_SUPPLIER_INDEX DESC ')->result();
        return $hasil;
    }

    public function add()
    {
        if ($this->input->post('id') == "") {
            $data = array(
                'MASTER_SUPPLIER_ID' => create_id(),
                'MASTER_SUPPLIER_NAMA' => $this->input->post('nama'),
                'MASTER_SUPPLIER_ALAMAT' => $this->input->post('alamat'),
                'MASTER_SUPPLIER_HP' => $this->input->post('hp'),
                'MASTER_SUPPLIER_NPWP' => $this->input->post('npwp'),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('MASTER_SUPPLIER', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d G:i:s"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->where('MASTER_SUPPLIER_ID', $this->input->post('id'));
            $edit = $this->db->update('MASTER_SUPPLIER', $data_edit);

            $data = array(
                'MASTER_SUPPLIER_ID' => $this->input->post('id'),
                'MASTER_SUPPLIER_NAMA' => $this->input->post('nama'),
                'MASTER_SUPPLIER_ALAMAT' => $this->input->post('alamat'),
                'MASTER_SUPPLIER_HP' => $this->input->post('hp'),
                'MASTER_SUPPLIER_NPWP' => $this->input->post('npwp'),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('MASTER_SUPPLIER', $data);
            return $result;
        }
    }

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('MASTER_SUPPLIER_ID', $id);
        $result = $this->db->update('MASTER_SUPPLIER', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_SUPPLIER WHERE MASTER_SUPPLIER_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        return $hasil;
    }
}
