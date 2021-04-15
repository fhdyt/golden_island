<?php
class PoModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM PO WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"  ORDER BY PO_INDEX DESC ')->result();
        foreach ($hasil as $row) {
            $supplier = $this->db->query('SELECT * FROM MASTER_SUPPLIER WHERE MASTER_SUPPLIER_ID="' . $row->MASTER_SUPPLIER_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            $row->TANGGAL = tanggal($row->PO_TANGGAL);
            $row->SUPPLIER = $supplier;
        }
        return $hasil;
    }

    public function add()
    {
        $data_edit_aktif = array(
            'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('PO_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('PO', $data_edit_aktif);


        $data = array(
            'PO_ID' => $this->input->post('id'),
            'PO_JENIS' => $this->input->post('jenis'),
            'PO_NOMOR_SURAT' => $this->input->post('nomor_surat'),
            'PO_TANGGAL' => $this->input->post('tanggal'),
            'PO_KETERANGAN' => $this->input->post('keterangan'),
            'MASTER_SUPPLIER_ID' => $this->input->post('supplier'),
            'PO_TOTAL' => str_replace(".", "", $this->input->post('total')),
            'PO_BAYAR' => str_replace(".", "", $this->input->post('bayar')),

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('PO', $data);
        return $result;
    }

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('PO_BARANG_ID', $id);
        $result = $this->db->update('PO_BARANG', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM 
        PO
        WHERE PO_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();

        return $hasil;
    }

    public function detail_jenis_barang($jenis)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_BARANG WHERE MASTER_BARANG_JENIS="' . $jenis . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        return $hasil;
    }

    public function add_barang()
    {
        $total = $this->input->post('quantity_barang') * $this->input->post('harga_barang');
        $data = array(
            'PO_BARANG_ID' => create_id(),
            'PO_ID' => $this->input->post('id'),

            'MASTER_BARANG_ID' => $this->input->post('barang'),
            'PO_BARANG_SATUAN' => $this->input->post('satuan'),
            'PO_BARANG_HARGA' => $this->input->post('harga_barang'),
            'PO_BARANG_QUANTITY' => $this->input->post('quantity_barang'),
            'PO_BARANG_TOTAL' => $total,

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('PO_BARANG', $data);
        return $result;
    }

    public function list_barang($id)
    {
        $hasil = $this->db->query('SELECT * FROM 
        PO_BARANG AS P LEFT JOIN MASTER_BARANG AS B 
        ON P.MASTER_BARANG_ID=B.MASTER_BARANG_ID
        WHERE 
        P.RECORD_STATUS="AKTIF" AND 
        B.RECORD_STATUS="AKTIF" AND 
        P.PO_ID="' . $id . '" AND P.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY P.PO_BARANG_INDEX DESC')->result();
        return $hasil;
    }
}
