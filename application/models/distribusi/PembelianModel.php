<?php
class PembelianModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM PEMBELIAN WHERE RECORD_STATUS="AKTIF" ORDER BY PEMBELIAN_INDEX DESC ')->result();
        foreach ($hasil as $row) {
            $supplier = $this->db->query('SELECT * FROM MASTER_SUPPLIER WHERE MASTER_SUPPLIER_ID="' . $row->MASTER_SUPPLIER_ID . '" AND RECORD_STATUS="AKTIF"')->result();
            $row->TANGGAL = tanggal($row->PEMBELIAN_TANGGAL);
            $row->SUPPLIER = $supplier;
        }
        return $hasil;
    }

    public function add($config)
    {
        $data_edit_aktif = array(
            'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
        );

        $this->db->where('PEMBELIAN_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('PEMBELIAN', $data_edit_aktif);

        $data_edit_aktif_transaksi = array(
            'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
        );

        $this->db->where('PEMBELIAN_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('TRANSAKSI_PEMBELIAN', $data_edit_aktif_transaksi);

        $data_transaksi = array(
            'TRANSAKSI_PEMBELIAN_ID' => $this->input->post('id'),
            'PEMBELIAN_ID' => $this->input->post('id'),

            'TRANSAKSI_PEMBELIAN_PPN' => $this->input->post('ppn_check'),
            'TRANSAKSI_PEMBELIAN_PPN_RUPIAH' => str_replace(".", "", $this->input->post('ppn_rupiah')),
            'TRANSAKSI_PEMBELIAN_POTONGAN' => str_replace(".", "", $this->input->post('potongan')),
            'TRANSAKSI_PEMBELIAN_TOTAL' => str_replace(".", "", $this->input->post('total')),
            'TRANSAKSI_PEMBELIAN_SUB_TOTAL' => str_replace(".", "", $this->input->post('sub_total')),
            'TRANSAKSI_PEMBELIAN_BIAYA_TAMBAHAN' => str_replace(".", "", $this->input->post('biaya_tambahan')),
            'TRANSAKSI_PEMBELIAN_GRAND_TOTAL' => str_replace(".", "", $this->input->post('grand_total')),
            'TRANSAKSI_PEMBELIAN_BAYAR' => str_replace(".", "", $this->input->post('bayar')),
            'TRANSAKSI_PEMBELIAN_SISA_BAYAR' => str_replace(".", "", $this->input->post('sisa_bayar')),


            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
        );

        $this->db->insert('TRANSAKSI_PEMBELIAN', $data_transaksi);

        $data = array(
            'PEMBELIAN_ID' => $this->input->post('id'),
            'PEMBELIAN_JENIS' => $this->input->post('jenis'),
            'PEMBELIAN_NOMOR_SURAT' => $this->input->post('nomor_surat'),
            'PEMBELIAN_TANGGAL' => $this->input->post('tanggal'),
            'PEMBELIAN_KETERANGAN' => $this->input->post('keterangan'),
            'MASTER_SUPPLIER_ID' => $this->input->post('supplier'),
            'PEMBELIAN_FILE' => $config['file_name'],

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
        );

        $result = $this->db->insert('PEMBELIAN', $data);
        return $result;
    }

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
        );

        $this->db->where('PEMBELIAN_BARANG_ID', $id);
        $result = $this->db->update('PEMBELIAN_BARANG', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM 
        PEMBELIAN AS P LEFT JOIN TRANSAKSI_PEMBELIAN AS TP
        ON P.PEMBELIAN_ID=TP.PEMBELIAN_ID
        WHERE P.PEMBELIAN_ID="' . $id . '" AND P.RECORD_STATUS="AKTIF" AND TP.RECORD_STATUS="AKTIF" LIMIT 1')->result();
        foreach ($hasil as $row) {
            $sub_total = $this->db->query('SELECT SUM(PEMBELIAN_BARANG_TOTAL) AS TOTAL FROM 
        PEMBELIAN_BARANG 
        WHERE 
        RECORD_STATUS="AKTIF" AND 
        PEMBELIAN_ID="' . $row->PEMBELIAN_ID . '"')->result();
            $row->SUB_TOTAL = $sub_total;
        }
        return $hasil;
    }

    public function detail_jenis_barang($jenis)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_BARANG WHERE MASTER_BARANG_JENIS="' . $jenis . '" AND RECORD_STATUS="AKTIF"')->result();
        return $hasil;
    }

    public function add_barang()
    {
        $total = $this->input->post('quantity_barang') * $this->input->post('harga_barang');
        $data = array(
            'PEMBELIAN_BARANG_ID' => create_id(),
            'PEMBELIAN_ID' => $this->input->post('id'),
            'MASTER_BARANG_ID' => $this->input->post('barang'),
            'PEMBELIAN_BARANG_SATUAN' => $this->input->post('satuan'),
            'PEMBELIAN_BARANG_HARGA' => $this->input->post('harga_barang'),
            'PEMBELIAN_BARANG_QUANTITY' => $this->input->post('quantity_barang'),
            'PEMBELIAN_BARANG_TOTAL' => $total,

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
        );

        $result = $this->db->insert('PEMBELIAN_BARANG', $data);
        return $result;
    }

    public function list_barang($id)
    {
        $hasil = $this->db->query('SELECT * FROM 
        PEMBELIAN_BARANG AS P LEFT JOIN MASTER_BARANG AS B 
        ON P.MASTER_BARANG_ID=B.MASTER_BARANG_ID
        WHERE 
        P.RECORD_STATUS="AKTIF" AND 
        B.RECORD_STATUS="AKTIF" AND 
        P.PEMBELIAN_ID="' . $id . '" ORDER BY P.PEMBELIAN_BARANG_INDEX DESC ')->result();
        return $hasil;
    }
}
