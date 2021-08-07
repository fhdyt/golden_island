<?php
class Surat_jalanModel extends CI_Model
{

    public function list($jenis_sj)
    {
        $tanggal_dari = $this->input->post("tanggal_dari");
        $tanggal_sampai = $this->input->post("tanggal_sampai");
        $tanggal = 'AND SURAT_JALAN_TANGGAL BETWEEN "' . $tanggal_dari . '" AND "' . $tanggal_sampai . '"';

        $hasil = $this->db->query('SELECT * FROM SURAT_JALAN WHERE SURAT_JALAN_JENIS="' . $jenis_sj . '" ' . $tanggal . ' AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY SURAT_JALAN_NOMOR DESC ')->result();
        foreach ($hasil as $row) {
            $driver = $this->db->query('SELECT * FROM MASTER_KARYAWAN WHERE MASTER_KARYAWAN_ID="' . $row->DRIVER_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"  LIMIT 1 ');
            if ($driver->num_rows() < 1) {
                $row->DRIVER = array();
            } else {
                $row->DRIVER = $driver->result();
            }
            $row->BARANG = $this->db->query('SELECT * FROM  SURAT_JALAN_BARANG AS BARANG LEFT JOIN MASTER_BARANG AS M ON BARANG.MASTER_BARANG_ID=M.MASTER_BARANG_ID WHERE BARANG.SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" AND BARANG.RECORD_STATUS="AKTIF" AND BARANG.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" AND M.RECORD_STATUS="AKTIF" AND M.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ')->result();
            $relasi = $this->db->query('SELECT * FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            $supplier = $this->db->query('SELECT * FROM MASTER_SUPPLIER WHERE MASTER_SUPPLIER_ID="' . $row->MASTER_SUPPLIER_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            $row->TANGGAL = tanggal($row->SURAT_JALAN_TANGGAL);
            $row->JAM = jam($row->ENTRI_WAKTU);
            $row->RELASI = $relasi;
            $row->SUPPLIER = $supplier;
            $row->OLEH = $this->db->query('SELECT * FROM USER WHERE USER_ID="' . $row->ENTRI_USER . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
            $row->OLEH_REALISASI = $this->db->query('SELECT * FROM USER WHERE USER_ID="' . $row->SURAT_JALAN_REALISASI_OLEH . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
            $row->OLEH_TTBK = $this->db->query('SELECT * FROM USER WHERE USER_ID="' . $row->SURAT_JALAN_REALISASI_TTBK_OLEH . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        }
        return $hasil;
    }
    public function add()
    {
        $data_edit_stok = array(
            'EDIT_WAKTU' => date("Y-m-d G:i:s"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('STOK_BARANG_REF', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('STOK_BARANG', $data_edit_stok);

        $data_edit_aktif = array(
            'EDIT_WAKTU' => date("Y-m-d G:i:s"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('SURAT_JALAN_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('SURAT_JALAN', $data_edit_aktif);

        if ($this->input->post('jenis_sj') == "penjualan") {
            $sj = "SJ";
        } else {
            $sj = "SJP";
        }

        if ($this->input->post('nomor_surat_jalan') == "") {
            $nomor_surat_jalan = nomor_surat_jalan($sj, $this->input->post('tanggal'));
        } else {
            $nomor_surat_jalan = $this->input->post('nomor_surat_jalan');
        }

        if ($this->input->post('jenis') == "gas") {
            $realisasi_sj = "";
            $realisasi_ttbk = "";
        } else if ($this->input->post('jenis') == "sparepart") {
            $realisasi_sj = "selesai";
            $realisasi_ttbk = "selesai";

            $barang_sparepart = $this->db->query('SELECT * FROM 
            SURAT_JALAN_BARANG AS P LEFT JOIN MASTER_BARANG AS B 
            ON P.MASTER_BARANG_ID=B.MASTER_BARANG_ID
            WHERE 
            P.RECORD_STATUS="AKTIF" AND 
            B.RECORD_STATUS="AKTIF" AND 
            P.SURAT_JALAN_ID="' . $this->input->post('id') . '" AND P.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY P.SURAT_JALAN_BARANG_INDEX DESC')->result();
            foreach ($barang_sparepart as $row_sparepart) {
                $data_stok = array(
                    'STOK_BARANG_ID' => create_id(),
                    'MASTER_BARANG_ID' => $row_sparepart->MASTER_BARANG_ID,
                    'STOK_BARANG_REF' => $this->input->post('id'),
                    'STOK_BARANG_TANGGAL' => date("Y-m-d"),
                    'STOK_BARANG_MASUK' => 0,
                    'STOK_BARANG_KELUAR' => $row_sparepart->SURAT_JALAN_BARANG_QUANTITY,
                    'STOK_BARANG_POSISI' => "GUDANG",
                    'STOK_BARANG_KETERANGAN' =>  $nomor_surat_jalan,

                    'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                    'ENTRI_USER' => $this->session->userdata('USER_ID'),
                    'RECORD_STATUS' => "AKTIF",
                    'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
                );

                $this->db->insert('STOK_BARANG', $data_stok);
            }
        } else {
            $realisasi_sj = "selesai";
            $realisasi_ttbk = "selesai";
        }

        if ($this->input->post('jaminan') == "on") {
            $jaminan = "Yes";
        } else {
            $jaminan = "No";
        }
        $data = array(
            'SURAT_JALAN_ID' => $this->input->post('id'),
            'SURAT_JALAN_JENIS' => $this->input->post('jenis_sj'),
            'SURAT_JALAN_NOMOR' => $nomor_surat_jalan,
            'SURAT_JALAN_STATUS_JENIS' => $this->input->post('jenis'),
            'SURAT_JALAN_JAMINAN' => $jaminan,
            'SURAT_JALAN_NOMOR_SURAT' => $this->input->post('nomor_surat'),
            'SURAT_JALAN_TANGGAL' => $this->input->post('tanggal'),
            'SURAT_JALAN_KETERANGAN' => $this->input->post('keterangan'),
            'SURAT_JALAN_STATUS' => "open",
            'SURAT_JALAN_REALISASI_STATUS' => $realisasi_sj,
            'SURAT_JALAN_REALISASI_TTBK_STATUS' => $realisasi_ttbk,
            'MASTER_RELASI_ID' => $this->input->post('relasi'),
            'MASTER_SUPPLIER_ID' => $this->input->post('supplier'),
            'DRIVER_ID' => $this->input->post('driver'),
            'MASTER_KENDARAAN_ID' => $this->input->post('kendaraan'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $data = $this->db->insert('SURAT_JALAN', $data);
        return $data;
    }

    public function batal()
    {
        echo $this->input->post('id');
        $data_edit = array(
            'SURAT_JALAN_STATUS' => "cancel",
            'SURAT_JALAN_REALISASI_STATUS' => "",
            'SURAT_JALAN_REALISASI_TTBK_STATUS' => "",

            'EDIT_WAKTU' => date("Y-m-d G:i:s"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
        );

        $this->db->where('SURAT_JALAN_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $this->db->update('SURAT_JALAN', $data_edit);

        $data_edit_panggung = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('PANGGUNG_REF', $this->input->post("id"));
        $this->db->update('PANGGUNG', $data_edit_panggung);

        $data_edit_jurnal = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('JURNAL_TABUNG_REF', $this->input->post("id"));
        $this->db->update('JURNAL_TABUNG', $data_edit_jurnal);

        //  return true;
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

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('SURAT_JALAN_BARANG_ID', $id);
        $result = $this->db->update('SURAT_JALAN_BARANG', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM 
        SURAT_JALAN
        WHERE SURAT_JALAN_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        return $hasil;
    }

    public function add_barang()
    {
        $data = array(
            'SURAT_JALAN_BARANG_ID' => create_id(),
            'SURAT_JALAN_ID' => $this->input->post('id'),
            'MASTER_BARANG_ID' => $this->input->post('barang'),
            'SURAT_JALAN_BARANG_JENIS' => $this->input->post('jenis'),
            'SURAT_JALAN_BARANG_QUANTITY' => $this->input->post('quantity_barang'),
            'SURAT_JALAN_BARANG_QUANTITY_KOSONG' => $this->input->post('quantity_barang_kosong'),
            'SURAT_JALAN_BARANG_QUANTITY_KLAIM' => $this->input->post('quantity_barang_klaim'),
            'SURAT_JALAN_BARANG_SATUAN' => $this->input->post('satuan_barang'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('SURAT_JALAN_BARANG', $data);
        return $result;
    }

    public function list_barang($id)
    {
        $hasil['isi'] = $this->db->query('SELECT * FROM 
        SURAT_JALAN_BARANG AS P LEFT JOIN MASTER_BARANG AS B 
        ON P.MASTER_BARANG_ID=B.MASTER_BARANG_ID
        WHERE 
        P.RECORD_STATUS="AKTIF" AND 
        B.RECORD_STATUS="AKTIF" AND 
        P.SURAT_JALAN_ID="' . $id . '" AND P.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY P.SURAT_JALAN_BARANG_INDEX DESC')->result();
        return $hasil;
    }

    public function add_relasi()
    {
        $data = array(
            'MASTER_RELASI_ID' => create_id(),
            'MASTER_RELASI_QR_ID' => "",
            'MASTER_RELASI_NAMA' => $this->input->post('nama_relasi'),
            'MASTER_RELASI_ALAMAT' => $this->input->post('alamat_relasi'),
            'MASTER_RELASI_HP' => $this->input->post('hp_relasi'),
            'MASTER_RELASI_NPWP' => $this->input->post('npwp'),
            'MASTER_RELASI_KTP' => $this->input->post('ktp'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('MASTER_RELASI', $data);
        return $result;
    }
}
