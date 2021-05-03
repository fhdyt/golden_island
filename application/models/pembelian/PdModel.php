<?php
class PdModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM PEMBELIAN WHERE PEMBELIAN_JENIS="PD" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"  ORDER BY PEMBELIAN_NOMOR DESC ')->result();
        foreach ($hasil as $row) {
            $supplier = $this->db->query('SELECT * FROM MASTER_SUPPLIER WHERE MASTER_SUPPLIER_ID="' . $row->MASTER_SUPPLIER_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
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
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('PD_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('PEMBELIAN', $data_edit_aktif);

        $data_edit_aktif_transaksi = array(
            'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('PD_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('PEMBELIAN_TRANSAKSI', $data_edit_aktif_transaksi);

        $data_edit_buku_besar = array(
            'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('BUKU_BESAR_REF', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('BUKU_BESAR', $data_edit_buku_besar);

        if ($this->input->post('nomor_pembelian') == "") {
            $nomor_pembelian = nomor_pembelian("PD", $this->input->post('tanggal'));
        } else {
            $nomor_pembelian = $this->input->post('nomor_pembelian');
        }

        $data = array(
            'PEMBELIAN_ID' => $this->input->post('id_pembelian'),
            'PEMBELIAN_JENIS' => "PD",
            'PEMBELIAN_NOMOR' => $nomor_pembelian,
            'PD_ID' => $this->input->post('id'),
            'AKUN_ID' => $this->input->post('akun'),
            'PEMBELIAN_BARANG' => $this->input->post('jenis'),
            'PEMBELIAN_NOMOR_SURAT' => $this->input->post('nomor_surat'),
            'PEMBELIAN_TANGGAL' => $this->input->post('tanggal'),
            'PEMBELIAN_KETERANGAN' => $this->input->post('keterangan'),
            'PEMBELIAN_STATUS' => "open",
            'PEMBELIAN_FILE' => $config['file_name'],
            'MASTER_SUPPLIER_ID' => $this->input->post('supplier'),

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->insert('PEMBELIAN', $data);

        $data_transaksi = array(
            'PEMBELIAN_ID' => $this->input->post('id_pembelian'),
            'PD_ID' => $this->input->post('id'),
            'PEMBELIAN_JENIS' => "PD",
            'PEMBELIAN_TRANSAKSI_LAINNYA' => str_replace(".", "", $this->input->post('lainnya')),

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
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
            'BUKU_BESAR_KREDIT' => str_replace(".", "", $this->input->post('lainnya')),
            'BUKU_BESAR_DEBET' => "0",
            'BUKU_BESAR_SUMBER' => "PEMBELIAN",
            'BUKU_BESAR_KETERANGAN' => "Pembayaran Biaya Lainnya " . $nomor_pembelian,

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->insert('BUKU_BESAR', $data_buku_besar);

        if ($this->input->post('jenis') == "gas") {
            $data_edit_stok = array(
                'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->where('STOK_BARANG_REF', $this->input->post('id'));
            $this->db->where('RECORD_STATUS', 'AKTIF');
            $this->db->update('STOK_BARANG', $data_edit_stok);

            $hasil = $this->db->query('SELECT * FROM 
        PEMBELIAN_BARANG 
        WHERE 
        RECORD_STATUS="AKTIF" AND 
        PD_ID="' . $this->input->post('id') . '" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();

            foreach ($hasil as $row) {
                $data_stok = array(
                    'STOK_BARANG_ID' => create_id(),
                    'MASTER_BARANG_ID' => $row->MASTER_BARANG_ID,
                    'STOK_BARANG_REF' => $this->input->post('id'),
                    'STOK_BARANG_TANGGAL' => $this->input->post('tanggal'),
                    'STOK_BARANG_MASUK' => $row->PEMBELIAN_BARANG_QUANTITY,
                    'STOK_BARANG_KELUAR' => 0,

                    'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                    'ENTRI_USER' => $this->session->userdata('USER_ID'),
                    'RECORD_STATUS' => "AKTIF",
                    'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
                );

                $this->db->insert('STOK_BARANG', $data_stok);
            }
        } else if ($this->input->post('jenis') == "tabung") {
            $hasil = $this->db->query('SELECT * FROM 
        STOK_BARANG 
        WHERE 
        RECORD_STATUS="AKTIF" AND 
        STOK_BARANG_REF="' . $this->input->post('id') . '" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();

            foreach ($hasil as $row) {
                $data = array(
                    'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
                    'DELETE_USER' => $this->session->userdata('USER_ID'),
                    'RECORD_STATUS' => "DELETE",
                    'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
                );

                $this->db->where('STOK_BARANG_ID', $row->STOK_BARANG_ID);
                $this->db->update('MASTER_TABUNG', $data);
            }

            $data_edit_stok = array(
                'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->where('STOK_BARANG_REF', $this->input->post('id'));
            $this->db->where('RECORD_STATUS', 'AKTIF');
            $this->db->update('STOK_BARANG', $data_edit_stok);

            $hasil = $this->db->query('SELECT * FROM 
        PEMBELIAN_BARANG 
        WHERE 
        RECORD_STATUS="AKTIF" AND 
        PD_ID="' . $this->input->post('id') . '" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();

            foreach ($hasil as $row) {

                $id_stok_barang = create_id();
                $data_stok = array(
                    'STOK_BARANG_ID' => $id_stok_barang,
                    'MASTER_BARANG_ID' => $row->MASTER_BARANG_ID,
                    'STOK_BARANG_REF' => $this->input->post('id'),
                    'STOK_BARANG_TANGGAL' => $this->input->post('tanggal'),
                    'STOK_BARANG_MASUK' => $row->PEMBELIAN_BARANG_QUANTITY,
                    'STOK_BARANG_KELUAR' => 0,

                    'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                    'ENTRI_USER' => $this->session->userdata('USER_ID'),
                    'RECORD_STATUS' => "AKTIF",
                    'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
                );
                $this->db->insert('STOK_BARANG', $data_stok);

                for ($x = 0; $x < $row->PEMBELIAN_BARANG_QUANTITY; $x++) {
                    $data = array(
                        'MASTER_TABUNG_ID' => create_id(),
                        'MASTER_TABUNG_KODE' => kode_tabung(),
                        'MASTER_BARANG_ID' => $row->MASTER_BARANG_ID,
                        'STOK_BARANG_ID' => $id_stok_barang,
                        'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                        'ENTRI_USER' => $this->session->userdata('USER_ID'),
                        'RECORD_STATUS' => "AKTIF",
                        'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
                    );
                    $this->db->insert('MASTER_TABUNG', $data);
                }
            }
        }

        return true;
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
        WHERE PD_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        foreach ($hasil as $row) {
            $transaksi = $this->db->query('SELECT * FROM PEMBELIAN_TRANSAKSI WHERE PD_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
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
        $hasil = $this->db->query('SELECT * FROM MASTER_BARANG WHERE MASTER_BARANG_JENIS="' . $jenis_barang . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        return $hasil;
    }

    public function add_barang()
    {
        $data = array(
            'PEMBELIAN_BARANG_ID' => create_id(),
            'PD_ID' => $this->input->post('id'),
            'PEMBELIAN_ID' => $this->input->post('id_pembelian'),
            'MASTER_BARANG_ID' => $this->input->post('barang'),
            'PEMBELIAN_BARANG_SATUAN' => $this->input->post('satuan'),
            'PEMBELIAN_BARANG_HARGA' => "0",
            'PEMBELIAN_BARANG_QUANTITY' => $this->input->post('quantity_barang'),
            'PEMBELIAN_BARANG_TOTAL' => "0",

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
        P.PD_ID="' . $id . '" AND P.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY P.PEMBELIAN_BARANG_INDEX DESC')->result();
        return $hasil;
    }

    public function realisasi_tabung()
    {
        $quantity = $this->input->post('quantity_realisasi');
        $hasil = $this->db->query('SELECT * FROM 
        PEMBELIAN_BARANG 
        WHERE 
        RECORD_STATUS="AKTIF" AND 
        PEMBELIAN_BARANG_ID="' . $this->input->post('id_realisasi') . '" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        if (!empty($hasil)) {
            for ($x = 0; $x < $quantity; $x++) {
                $data = array(
                    'MASTER_TABUNG_ID' => create_id(),
                    'MASTER_TABUNG_KODE' => kode_tabung(),
                    'MASTER_BARANG_ID' => $hasil[0]->MASTER_BARANG_ID,
                    'PEMBELIAN_NOMOR_SURAT' => "",
                    'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                    'ENTRI_USER' => $this->session->userdata('USER_ID'),
                    'RECORD_STATUS' => "AKTIF",
                    'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
                );
                $this->db->insert('MASTER_TABUNG', $data);
            }
            $total = $quantity * $hasil[0]->PEMBELIAN_BARANG_HARGA;
            $data_barang = array(
                'PEMBELIAN_BARANG_QUANTITY' => $quantity,
                'PEMBELIAN_BARANG_TOTAL' => $total,
                'PEMBELIAN_BARANG_REALISASI' => "1",
            );

            $this->db->where('PEMBELIAN_BARANG_ID', $this->input->post('id_realisasi'));
            $result = $this->db->update('PEMBELIAN_BARANG', $data_barang);
        }

        return $result;
    }

    public function edit()
    {
        $hasil = $this->db->query('SELECT * FROM 
        PEMBELIAN_BARANG 
        WHERE 
        RECORD_STATUS="AKTIF" AND 
        PEMBELIAN_BARANG_ID="' . $this->input->post('id_barang') . '" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();

        $total = $this->input->post('quantity_barang') * $hasil[0]->PEMBELIAN_BARANG_HARGA;
        $data_barang = array(
            'PEMBELIAN_BARANG_QUANTITY' => $this->input->post('quantity_barang'),
            'PEMBELIAN_BARANG_TOTAL' => $total,
            'PEMBELIAN_BARANG_SATUAN' => $this->input->post('satuan_barang'),
        );

        $this->db->where('PEMBELIAN_BARANG_ID', $this->input->post('id_barang'));
        $result = $this->db->update('PEMBELIAN_BARANG', $data_barang);
    }


    public function pd_to_pi($id, $id_pembelian)
    {
        $id_pi = create_id();
        $data_close = array(
            'PEMBELIAN_STATUS' => "close",
        );

        $this->db->where('PD_ID', $id);
        $this->db->update('PEMBELIAN', $data_close);

        $hasil = $this->db->query('SELECT * FROM 
        PEMBELIAN
        WHERE PD_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();

        if (!empty($hasil)) {
            $data = array(
                'PEMBELIAN_ID' => $id_pembelian,
                'PEMBELIAN_JENIS' => "PI",
                'PEMBELIAN_NOMOR' => nomor_pembelian("PI", $hasil[0]->PEMBELIAN_TANGGAL),
                'PI_ID' => $id_pi,
                'AKUN_ID' => $hasil[0]->AKUN_ID,
                'PEMBELIAN_BARANG' => $hasil[0]->PEMBELIAN_BARANG,
                'PEMBELIAN_NOMOR_SURAT' => $hasil[0]->PEMBELIAN_NOMOR_SURAT,
                'PEMBELIAN_TANGGAL' => $hasil[0]->PEMBELIAN_TANGGAL,
                'PEMBELIAN_KETERANGAN' => $hasil[0]->PEMBELIAN_KETERANGAN,
                'PEMBELIAN_STATUS' => "open",
                'MASTER_SUPPLIER_ID' => $hasil[0]->MASTER_SUPPLIER_ID,

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );
            $this->db->insert('PEMBELIAN', $data);

            $list_barang = $this->db->query('SELECT * FROM 
        PEMBELIAN_BARANG 
        WHERE 
        PD_ID = "' . $id . '"
        AND PEMBELIAN_ID="' . $id_pembelian . '" AND
        RECORD_STATUS="AKTIF" AND 
        PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();

            foreach ($list_barang as $row) {
                $total = $row->PEMBELIAN_BARANG_QUANTITY * $row->PEMBELIAN_BARANG_HARGA;
                $data_barang = array(
                    'PEMBELIAN_BARANG_ID' => create_id(),
                    'PI_ID' => $id_pi,
                    'PEMBELIAN_ID' => $id_pembelian,
                    'MASTER_BARANG_ID' => $row->MASTER_BARANG_ID,
                    'PEMBELIAN_BARANG_SATUAN' => $row->PEMBELIAN_BARANG_SATUAN,
                    'PEMBELIAN_BARANG_HARGA' =>  $row->PEMBELIAN_BARANG_HARGA,
                    'PEMBELIAN_BARANG_QUANTITY' =>  $row->PEMBELIAN_BARANG_QUANTITY,
                    'PEMBELIAN_BARANG_TOTAL' => $total,

                    'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                    'ENTRI_USER' => $this->session->userdata('USER_ID'),
                    'RECORD_STATUS' => "AKTIF",
                    'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
                );

                $this->db->insert('PEMBELIAN_BARANG', $data_barang);
            }
            return $data;
        }
    }
}
