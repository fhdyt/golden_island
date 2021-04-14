<?php
class PdModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM PD WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY PD_INDEX DESC ')->result();
        foreach ($hasil as $row) {
            $supplier = $this->db->query('SELECT * FROM MASTER_SUPPLIER WHERE MASTER_SUPPLIER_ID="' . $row->MASTER_SUPPLIER_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            $row->TANGGAL = tanggal($row->PD_TANGGAL);
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

        $this->db->where('PD_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('PD', $data_edit_aktif);


        $data = array(
            'PD_ID' => $this->input->post('id'),
            'PO_ID' => $this->input->post('po'),
            'PD_JENIS' => $this->input->post('jenis'),
            'PD_NOMOR_SURAT' => $this->input->post('nomor_surat'),
            'PD_TANGGAL' => $this->input->post('tanggal'),
            'PD_KETERANGAN' => $this->input->post('keterangan'),
            'MASTER_SUPPLIER_ID' => $this->input->post('supplier'),
            'PD_TOTAL' => str_replace(".", "", $this->input->post('total')),
            'PD_BAYAR' => str_replace(".", "", $this->input->post('bayar')),

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('PD', $data);
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

        $this->db->where('PD_BARANG_ID', $id);
        $result = $this->db->update('PD_BARANG', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM 
        PD
        WHERE PD_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();

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
            'PD_BARANG_ID' => create_id(),
            'PD_ID' => $this->input->post('id'),

            'MASTER_BARANG_ID' => $this->input->post('barang'),
            'PD_BARANG_SATUAN' => $this->input->post('satuan'),
            'PD_BARANG_HARGA' => $this->input->post('harga_barang'),
            'PD_BARANG_QUANTITY' => $this->input->post('quantity_barang'),
            'PD_BARANG_TOTAL' => $total,

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('PD_BARANG', $data);
        return $result;
    }

    public function list_barang($id)
    {
        $hasil = $this->db->query('SELECT * FROM 
        PD_BARANG AS P LEFT JOIN MASTER_BARANG AS B 
        ON P.MASTER_BARANG_ID=B.MASTER_BARANG_ID
        WHERE 
        P.RECORD_STATUS="AKTIF" AND 
        B.RECORD_STATUS="AKTIF" AND 
        P.PD_ID="' . $id . '" AND P.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY P.PD_BARANG_INDEX DESC')->result();
        return $hasil;
    }

    public function pilih_po_barang($id, $id_pd)
    {
        $detail_po = $this->db->query('SELECT * FROM PO WHERE PO_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        $hasil = $this->db->query('SELECT * FROM PO_BARANG WHERE PO_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        foreach ($hasil as $row) {
            $data = array(
                'PD_BARANG_ID' => create_id(),
                'PD_ID' => $id_pd,
                'MASTER_BARANG_ID' => $row->MASTER_BARANG_ID,
                'PD_BARANG_SATUAN' => $row->PO_BARANG_SATUAN,
                'PD_BARANG_HARGA' => $row->PO_BARANG_HARGA,
                'PD_BARANG_QUANTITY' => $row->PO_BARANG_QUANTITY,
                'PD_BARANG_TOTAL' => $row->PO_BARANG_TOTAL,

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );
            $this->db->insert('PD_BARANG', $data);
        }
        return $detail_po;
    }
}
