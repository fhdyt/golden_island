<?php
class BarangModel extends CI_Model
{

    public function list()
    {
        if (empty($_GET['jenis'])) {
            $filter = '';
        } else {
            $filter = 'AND MASTER_BARANG_JENIS="' . $_GET['jenis'] . '"';
        }
        $hasil = $this->db->query('SELECT * FROM MASTER_BARANG WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ' . $filter . '  ORDER BY MASTER_BARANG_PRIORITAS DESC, MASTER_BARANG_NAMA ASC')->result();
        foreach ($hasil as $row) {
            $stok = $this->db->query('SELECT SUM(STOK_BARANG_MASUK) AS MASUK, SUM(STOK_BARANG_KELUAR) AS KELUAR FROM STOK_BARANG WHERE MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            $row->MASUK = $stok[0]->MASUK;
            $row->KELUAR = $stok[0]->KELUAR;
        }
        return $hasil;
    }


    public function add()
    {
        if ($this->input->post('id') == "") {
            $data = array(
                'MASTER_BARANG_ID' => create_id(),
                'MASTER_BARANG_NAMA' => $this->input->post('nama'),
                'MASTER_BARANG_JENIS' => $this->input->post('jenis'),
                'MASTER_BARANG_KETERANGAN' => $this->input->post('keterangan'),
                'MASTER_BARANG_TOTAL' => $this->input->post('total'),
                'MASTER_BARANG_HARGA_SATUAN' => str_replace(".", "", $this->input->post('harga_satuan')),
                'MASTER_BARANG_SATUAN' => $this->input->post('satuan'),
                'MASTER_BARANG_BAHAN' => $this->input->post('bahan'),
                'MASTER_BARANG_PRIORITAS' => $this->input->post('prioritas'),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('MASTER_BARANG', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d G:i:s"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->where('MASTER_BARANG_ID', $this->input->post('id'));
            $edit = $this->db->update('MASTER_BARANG', $data_edit);

            $data = array(
                'MASTER_BARANG_ID' => $this->input->post('id'),
                'MASTER_BARANG_NAMA' => $this->input->post('nama'),
                'MASTER_BARANG_JENIS' => $this->input->post('jenis'),
                'MASTER_BARANG_KETERANGAN' => $this->input->post('keterangan'),
                'MASTER_BARANG_TOTAL' => $this->input->post('total'),
                'MASTER_BARANG_HARGA_SATUAN' => str_replace(".", "", $this->input->post('harga_satuan')),
                'MASTER_BARANG_SATUAN' => $this->input->post('satuan'),
                'MASTER_BARANG_BAHAN' => $this->input->post('bahan'),
                'MASTER_BARANG_PRIORITAS' => $this->input->post('prioritas'),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('MASTER_BARANG', $data);
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

        $this->db->where('MASTER_BARANG_ID', $id);
        $result = $this->db->update('MASTER_BARANG', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_BARANG WHERE MASTER_BARANG_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        return $hasil;
    }
    public function detail_detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_JENIS_BARANG_DETAIL WHERE MASTER_JENIS_BARANG_DETAIL_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        return $hasil;
    }

    // public function detail_jenis_barang()
    // {
    //     $hasil = $this->db->query('SELECT * FROM 
    //     MASTER_JENIS_BARANG_DETAIL AS BD LEFT JOIN MASTER_JENIS_BARANG AS B
    //     ON BD.MASTER_JENIS_BARANG_ID=B.MASTER_JENIS_BARANG_ID
    //     WHERE BD.RECORD_STATUS="AKTIF" AND B.RECORD_STATUS="AKTIF" ORDER BY B.MASTER_JENIS_BARANG_NAMA')->result();
    //     return $hasil;
    // }
}
