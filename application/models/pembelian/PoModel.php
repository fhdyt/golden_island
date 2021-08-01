<?php
class PoModel extends CI_Model
{

    public function list()
    {
        $tanggal_dari = $this->input->post("tanggal_dari");
        $tanggal_sampai = $this->input->post("tanggal_sampai");
        $tanggal = 'PEMBELIAN_TANGGAL BETWEEN "' . $tanggal_dari . '" AND "' . $tanggal_sampai . '" AND';

        $hasil = $this->db->query('SELECT * FROM PEMBELIAN WHERE ' . $tanggal . ' PEMBELIAN_JENIS="PO" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"  ORDER BY PEMBELIAN_TANGGAL DESC ')->result();
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
            'EDIT_WAKTU' => date("Y-m-d G:i:s"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('PO_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('PEMBELIAN', $data_edit_aktif);

        $data_edit_aktif_transaksi = array(
            'EDIT_WAKTU' => date("Y-m-d G:i:s"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('PO_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('PEMBELIAN_TRANSAKSI', $data_edit_aktif_transaksi);

        $data_edit_buku_besar = array(
            'EDIT_WAKTU' => date("Y-m-d G:i:s"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('BUKU_BESAR_REF', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('BUKU_BESAR', $data_edit_buku_besar);

        if ($this->input->post('nomor_pembelian') == "") {
            $nomor_pembelian = nomor_pembelian("PO", $this->input->post('tanggal'));
        } else {
            $nomor_pembelian = $this->input->post('nomor_pembelian');
        }

        $data = array(
            'PEMBELIAN_ID' => $this->input->post('id_pembelian'),
            'PEMBELIAN_JENIS' => "PO",
            'PEMBELIAN_NOMOR' => $nomor_pembelian,
            'PO_ID' => $this->input->post('id'),
            'AKUN_ID' => $this->input->post('akun'),
            'PEMBELIAN_BARANG' => $this->input->post('jenis'),
            'PEMBELIAN_NOMOR_SURAT' => $this->input->post('nomor_surat'),
            'PEMBELIAN_TANGGAL' => $this->input->post('tanggal'),
            'PEMBELIAN_KETERANGAN' => $this->input->post('keterangan'),
            'PEMBELIAN_STATUS' => "open",
            'MASTER_SUPPLIER_ID' => $this->input->post('supplier'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->insert('PEMBELIAN', $data);

        $data_transaksi = array(
            'PEMBELIAN_ID' => $this->input->post('id_pembelian'),
            'PO_ID' => $this->input->post('id'),
            'PEMBELIAN_JENIS' => "PO",
            'PEMBELIAN_TRANSAKSI_TOTAL' => str_replace(".", "", $this->input->post('total')),
            'PEMBELIAN_TRANSAKSI_PAJAK' => $this->input->post('pajak'),
            'PEMBELIAN_TRANSAKSI_PAJAK_RUPIAH' => str_replace(".", "", $this->input->post('pajak_rupiah')),
            'PEMBELIAN_TRANSAKSI_POTONGAN' => str_replace(".", "", $this->input->post('potongan')),
            'PEMBELIAN_TRANSAKSI_UANG_MUKA' => str_replace(".", "", $this->input->post('bayar')),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->insert('PEMBELIAN_TRANSAKSI', $data_transaksi);

        $data_buku_besar = array(
            'BUKU_BESAR_ID' => create_id(),
            'BUKU_BESAR_REF' => $this->input->post('id'),
            'AKUN_ID' => $this->input->post('akun'),
            'BUKU_BESAR_TANGGAL' => $this->input->post('tanggal'),
            'BUKU_BESAR_JENIS' => "KREDIT",
            'BUKU_BESAR_KREDIT' => str_replace(".", "", $this->input->post('bayar')),
            'BUKU_BESAR_DEBET' => "0",
            'BUKU_BESAR_SUMBER' => "PEMBELIAN",
            'BUKU_BESAR_KETERANGAN' => "Pembayaran Uang Muka " . $nomor_pembelian,

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('BUKU_BESAR', $data_buku_besar);
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

        $this->db->where('PEMBELIAN_BARANG_ID', $id);
        $result = $this->db->update('PEMBELIAN_BARANG', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM 
        PEMBELIAN
        WHERE PO_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        foreach ($hasil as $row) {
            $transaksi = $this->db->query('SELECT * FROM PEMBELIAN_TRANSAKSI WHERE PO_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
            $row->TRANSAKSI = $transaksi;
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
        $hasil = $this->db->query('SELECT * FROM MASTER_BARANG WHERE MASTER_BARANG_JENIS="' . $jenis_barang . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY MASTER_BARANG_PRIORITAS DESC, MASTER_BARANG_NAMA ASC')->result();
        return $hasil;
    }

    public function add_barang()
    {
        $total = $this->input->post('quantity_barang') * $this->input->post('harga_barang');
        $data = array(
            'PEMBELIAN_BARANG_ID' => create_id(),
            'PO_ID' => $this->input->post('id'),
            'PEMBELIAN_ID' => $this->input->post('id_pembelian'),
            'MASTER_BARANG_ID' => $this->input->post('barang'),
            'PEMBELIAN_BARANG_SATUAN' => $this->input->post('satuan'),
            'PEMBELIAN_BARANG_HARGA' => $this->input->post('harga_barang'),
            'PEMBELIAN_BARANG_QUANTITY' => $this->input->post('quantity_barang'),
            'PEMBELIAN_BARANG_TOTAL' => $total,

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
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
        P.PO_ID="' . $id . '" AND P.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY P.PEMBELIAN_BARANG_INDEX DESC')->result();
        return $hasil;
    }

    public function po_to_pd($id, $id_pembelian)
    {
        $id_pd = create_id();
        $data_close = array(
            'PEMBELIAN_STATUS' => "close",
        );

        $this->db->where('PO_ID', $id);
        $this->db->update('PEMBELIAN', $data_close);

        $hasil = $this->db->query('SELECT * FROM 
        PEMBELIAN
        WHERE PO_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();

        if (!empty($hasil)) {
            $data = array(
                'PEMBELIAN_ID' => $id_pembelian,
                'PEMBELIAN_JENIS' => "PD",
                'PEMBELIAN_NOMOR' => nomor_pembelian("PD", $hasil[0]->PEMBELIAN_TANGGAL),
                'PD_ID' => $id_pd,
                'AKUN_ID' => $hasil[0]->AKUN_ID,
                'PEMBELIAN_BARANG' => $hasil[0]->PEMBELIAN_BARANG,
                'PEMBELIAN_NOMOR_SURAT' => $hasil[0]->PEMBELIAN_NOMOR_SURAT,
                'PEMBELIAN_TANGGAL' => $hasil[0]->PEMBELIAN_TANGGAL,
                'PEMBELIAN_KETERANGAN' => $hasil[0]->PEMBELIAN_KETERANGAN,
                'PEMBELIAN_STATUS' => "open",
                'MASTER_SUPPLIER_ID' => $hasil[0]->MASTER_SUPPLIER_ID,

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );
            $this->db->insert('PEMBELIAN', $data);

            $list_barang = $this->db->query('SELECT * FROM 
        PEMBELIAN_BARANG 
        WHERE 
        PO_ID = "' . $id . '"
        AND PEMBELIAN_ID="' . $id_pembelian . '" AND
        RECORD_STATUS="AKTIF" AND 
        PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();

            foreach ($list_barang as $row) {
                $total = $row->PEMBELIAN_BARANG_QUANTITY * $row->PEMBELIAN_BARANG_HARGA;
                $data = array(
                    'PEMBELIAN_BARANG_ID' => create_id(),
                    'PD_ID' => $id_pd,
                    'PEMBELIAN_ID' => $id_pembelian,
                    'MASTER_BARANG_ID' => $row->MASTER_BARANG_ID,
                    'PEMBELIAN_BARANG_SATUAN' => $row->PEMBELIAN_BARANG_SATUAN,
                    'PEMBELIAN_BARANG_HARGA' =>  $row->PEMBELIAN_BARANG_HARGA,
                    'PEMBELIAN_BARANG_QUANTITY' =>  $row->PEMBELIAN_BARANG_QUANTITY,
                    'PEMBELIAN_BARANG_TOTAL' => $total,

                    'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                    'ENTRI_USER' => $this->session->userdata('USER_ID'),
                    'RECORD_STATUS' => "AKTIF",
                    'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
                );

                $this->db->insert('PEMBELIAN_BARANG', $data);
            }
            return $data;
        }
    }
}
