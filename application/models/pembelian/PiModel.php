<?php
class PiModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM PEMBELIAN WHERE PEMBELIAN_JENIS="PI" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"  ORDER BY PEMBELIAN_NOMOR DESC ')->result();
        foreach ($hasil as $row) {
            $supplier = $this->db->query('SELECT * FROM MASTER_SUPPLIER WHERE MASTER_SUPPLIER_ID="' . $row->MASTER_SUPPLIER_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            $row->TANGGAL = tanggal($row->PEMBELIAN_TANGGAL);
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

        $this->db->where('PI_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('PEMBELIAN', $data_edit_aktif);

        $data_edit_aktif_transaksi = array(
            'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('PI_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('PEMBELIAN_TRANSAKSI', $data_edit_aktif_transaksi);


        $data = array(
            'PEMBELIAN_ID' => $this->input->post('id_pembelian'),
            'PEMBELIAN_JENIS' => "PI",
            'PEMBELIAN_NOMOR' => nomor_pembelian("PO", $this->input->post('tanggal')),
            'PI_ID' => $this->input->post('id'),
            'AKUN_ID' => $this->input->post('akun'),
            'PEMBELIAN_BARANG' => $this->input->post('jenis'),
            'PEMBELIAN_NOMOR_SURAT' => $this->input->post('nomor_surat'),
            'PEMBELIAN_TANGGAL' => $this->input->post('tanggal'),
            'PEMBELIAN_KETERANGAN' => $this->input->post('keterangan'),
            'PEMBELIAN_STATUS' => "open",
            'MASTER_SUPPLIER_ID' => $this->input->post('supplier'),

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->insert('PEMBELIAN', $data);

        $data_transaksi = array(
            'PEMBELIAN_ID' => $this->input->post('id_pembelian'),
            'PI_ID' => $this->input->post('id'),
            'PEMBELIAN_JENIS' => "PI",
            'PEMBELIAN_TRANSAKSI_TOTAL' => str_replace(".", "", $this->input->post('total')),
            'PEMBELIAN_TRANSAKSI_POTONGAN' => str_replace(".", "", $this->input->post('potongan')),
            'PEMBELIAN_TRANSAKSI_LAINNYA' => str_replace(".", "", $this->input->post('lainnya')),
            'PEMBELIAN_TRANSAKSI_PAJAK' => $this->input->post('pajak'),
            'PEMBELIAN_TRANSAKSI_PAJAK_RUPIAH' => str_replace(".", "", $this->input->post('pajak_rupiah')),
            'PEMBELIAN_TRANSAKSI_UANG_MUKA' => str_replace(".", "", $this->input->post('uang_muka')),
            'PEMBELIAN_TRANSAKSI_BAYAR' => str_replace(".", "", $this->input->post('bayar')),

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('PEMBELIAN_TRANSAKSI', $data_transaksi);
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

        $this->db->where('PEMBELIAN_BARANG_ID', $id);
        $result = $this->db->update('PEMBELIAN_BARANG', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM 
        PEMBELIAN
        WHERE PI_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        foreach ($hasil as $row) {
            $transaksi_po = $this->db->query('SELECT * FROM PEMBELIAN_TRANSAKSI WHERE PEMBELIAN_ID="' . $row->PEMBELIAN_ID . '" AND PEMBELIAN_JENIS="PO" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
            $transaksi_pd = $this->db->query('SELECT * FROM PEMBELIAN_TRANSAKSI WHERE PEMBELIAN_ID="' . $row->PEMBELIAN_ID . '" AND PEMBELIAN_JENIS="PD" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
            $transaksi = $this->db->query('SELECT * FROM PEMBELIAN_TRANSAKSI WHERE PEMBELIAN_ID="' . $row->PEMBELIAN_ID . '" AND PEMBELIAN_JENIS="PI" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
            $row->TRANSAKSI = $transaksi;
            $row->TRANSAKSI_PO = $transaksi_po;
            $row->TRANSAKSI_PD = $transaksi_pd;
        }
        return $hasil;
    }

    public function detail_jenis_barang($jenis)
    {
        if ($jenis == "gas" or $jenis == "tabung") {
            $jenis_barang = "gas";
        } else if ($jenis == "liquid" or $jenis == "tangki" or $jenis == "transporter") {
            $jenis_barang = "liquid";
        } else {
            $jenis_barang = $jenis;
        }
        $hasil = $this->db->query('SELECT * FROM MASTER_BARANG WHERE MASTER_BARANG_JENIS="' . $jenis_barang . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        return $hasil;
    }

    public function add_barang()
    {
        $total = $this->input->post('quantity_barang') * $this->input->post('harga_barang');
        $data = array(
            'PEMBELIAN_BARANG_ID' => create_id(),
            'PI_ID' => $this->input->post('id'),
            'PEMBELIAN_ID' => $this->input->post('id_pembelian'),
            'MASTER_BARANG_ID' => $this->input->post('barang'),
            'PEMBELIAN_BARANG_SATUAN' => $this->input->post('satuan'),
            'PEMBELIAN_BARANG_HARGA' => $this->input->post('harga_barang'),
            'PEMBELIAN_BARANG_QUANTITY' => $this->input->post('quantity_barang'),
            'PEMBELIAN_BARANG_TOTAL' => $total,

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('PEMBELIAN_BARANG', $data);
        return $result;
    }

    public function list_barang($id, $id_pembelian)
    {
        $hasil = $this->db->query('SELECT * FROM 
        PEMBELIAN_BARANG AS P LEFT JOIN MASTER_BARANG AS B 
        ON P.MASTER_BARANG_ID=B.MASTER_BARANG_ID
        WHERE 
        P.RECORD_STATUS="AKTIF" AND 
        B.RECORD_STATUS="AKTIF" AND 
        P.PI_ID="' . $id . '" AND P.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY P.PEMBELIAN_BARANG_INDEX DESC')->result();
        return $hasil;
    }

    public function edit()
    {
        $hasil = $this->db->query('SELECT * FROM 
        PEMBELIAN_BARANG 
        WHERE 
        RECORD_STATUS="AKTIF" AND 
        PEMBELIAN_BARANG_ID="' . $this->input->post('id') . '" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();

        $total = str_replace(".", "", $this->input->post('harga')) * $hasil[0]->PEMBELIAN_BARANG_QUANTITY;
        $data_barang = array(
            'PEMBELIAN_BARANG_HARGA' => str_replace(".", "", $this->input->post('harga')),
            'PEMBELIAN_BARANG_TOTAL' => $total,
        );

        $this->db->where('PEMBELIAN_BARANG_ID', $this->input->post('id'));
        $result = $this->db->update('PEMBELIAN_BARANG', $data_barang);
    }
}
