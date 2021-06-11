<?php
class ProduksiModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM PAJAK WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY PAJAK_INDEX DESC ')->result();
        return $hasil;
    }

    public function list_barang($id)
    {
        $hasil = $this->db->query('SELECT * 
                                        FROM PRODUKSI_BARANG AS P
                                        LEFT JOIN MASTER_BARANG AS B
                                        ON P.MASTER_BARANG_ID=B.MASTER_BARANG_ID
                                        WHERE 
                                        P.PRODUKSI_ID="' . $id . '"
                                        AND (P.RECORD_STATUS="AKTIF"  OR P.RECORD_STATUS="DRAFT")
                                        AND P.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                        AND B.RECORD_STATUS="AKTIF" 
                                        AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                        ORDER BY P.PRODUKSI_BARANG_INDEX DESC ')->result();
        return $hasil;
    }

    public function list_karyawan($id)
    {
        $hasil = $this->db->query('SELECT * 
                                        FROM PRODUKSI_KARYAWAN AS P
                                        LEFT JOIN MASTER_KARYAWAN AS K
                                        ON P.MASTER_KARYAWAN_ID=K.MASTER_KARYAWAN_ID
                                        WHERE 
                                        P.PRODUKSI_ID="' . $id . '"
                                        AND (P.RECORD_STATUS="AKTIF"  OR P.RECORD_STATUS="DRAFT")
                                        AND P.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                        AND K.RECORD_STATUS="AKTIF" 
                                        AND K.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                        ORDER BY P.PRODUKSI_KARYAWAN_INDEX DESC ')->result();
        return $hasil;
    }

    public function add()
    {
        if ($this->input->post('id') == "") {
            $data = array(
                'PAJAK_ID' => create_id(),
                'PAJAK_NAMA' => $this->input->post('nama'),
                'PAJAK_NILAI' => $this->input->post('nilai'),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('PAJAK', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d G:i:s"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->where('PAJAK_ID', $this->input->post('id'));
            $edit = $this->db->update('PAJAK', $data_edit);

            $data = array(
                'PAJAK_ID' => $this->input->post('id'),
                'PAJAK_NAMA' => $this->input->post('nama'),
                'PAJAK_NILAI' => $this->input->post('nilai'),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('PAJAK', $data);
            return $result;
        }
    }

    public function add_barang()
    {
        $data = array(
            'PRODUKSI_BARANG_ID' => create_id(),
            'PRODUKSI_ID' => $this->input->post('id'),
            'MASTER_BARANG_ID' => $this->input->post('barang'),
            'PRODUKSI_BARANG_TOTAL' => $this->input->post('total_barang'),
            'PRODUKSI_BARANG_KEPEMILIKAN' => $this->input->post('kepemilikan_barang'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DRAFT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('PRODUKSI_BARANG', $data);
        return $result;
    }

    public function add_karyawan()
    {
        $data = array(
            'PRODUKSI_KARYAWAN_ID' => create_id(),
            'PRODUKSI_ID' => $this->input->post('id'),
            'MASTER_KARYAWAN_ID' => $this->input->post('karyawan_produksi'),
            'PRODUKSI_KARYAWAN_TOTAL' => $this->input->post('total_produksi'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DRAFT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('PRODUKSI_KARYAWAN', $data);
        return $result;
    }

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('PRODUKSI_BARANG_ID', $id);
        $result = $this->db->update('PRODUKSI_BARANG', $data);
        return $result;
    }

    public function hapus_karyawan($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('PRODUKSI_KARYAWAN_ID', $id);
        $result = $this->db->update('PRODUKSI_KARYAWAN', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM PAJAK WHERE PAJAK_ID="' . $id . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }
}
