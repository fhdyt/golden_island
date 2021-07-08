<?php
class PenjualanModel extends CI_Model
{

    public function list()
    {
        if (empty($this->input->post("relasi"))) {
            $filter_relasi = "";
        } else {
            $filter_relasi = 'AND MASTER_RELASI_ID="' . $this->input->post("relasi") . '"';
        }

        $tanggal_dari = $this->input->post("tanggal_dari");
        $tanggal_sampai = $this->input->post("tanggal_sampai");

        $filter_tanggal = 'SURAT_JALAN_TANGGAL BETWEEN "' . $tanggal_dari . '" AND "' . $tanggal_sampai . '"';

        $hasil = $this->db->query('SELECT * 
                            FROM 
                            SURAT_JALAN 
                            WHERE 
                            ' . $filter_tanggal . '
                            ' . $filter_relasi . '
                            AND NOT SURAT_JALAN_STATUS="cancel"
                            AND SURAT_JALAN_JENIS = "penjualan"
                            AND RECORD_STATUS="AKTIF" 
                            AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" 
                            ORDER BY SURAT_JALAN_NOMOR ')->result();
        foreach ($hasil as $row) {
            $row->RELASI = $this->db->query('SELECT MASTER_RELASI_NAMA FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '"')->result();

            $total_perbarang = 0;
            if ($row->SURAT_JALAN_STATUS == "open") {

                $barang = $this->db->query('SELECT * FROM
                                                        SURAT_JALAN_BARANG AS SJ 
                                                        LEFT JOIN
                                                        MASTER_BARANG AS B
                                                        ON SJ.MASTER_BARANG_ID = B.MASTER_BARANG_ID
                                                        WHERE SJ.SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '"
                                                        AND SJ.RECORD_STATUS="AKTIF" 
                                                        AND SJ.PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" 
                                                        AND B.RECORD_STATUS="AKTIF" 
                                                        AND B.PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '"')->result();
                foreach ($barang as $row_barang) {
                    $row_barang->NAMA_BARANG = $this->db->query('SELECT MASTER_BARANG_NAMA FROM MASTER_BARANG WHERE MASTER_BARANG_ID="' . $row_barang->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '"')->result();
                    $row_barang->HARGA_BARANG = $this->db->query('SELECT * FROM MASTER_HARGA WHERE MASTER_BARANG_ID="' . $row_barang->MASTER_BARANG_ID . '" AND MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '"')->result();
                    if (count($row_barang->HARGA_BARANG) == 0) {
                        $total_perbarang += $row_barang->MASTER_BARANG_HARGA_SATUAN * ($row_barang->SURAT_JALAN_BARANG_QUANTITY - $row_barang->SURAT_JALAN_BARANG_QUANTITY_KLAIM);
                    } else {
                        $total_perbarang += $row_barang->HARGA_BARANG[0]->MASTER_HARGA_HARGA * ($row_barang->SURAT_JALAN_BARANG_QUANTITY - $row_barang->SURAT_JALAN_BARANG_QUANTITY_KLAIM);
                    }
                }

                $terbayar = array();
            } else if ($row->SURAT_JALAN_STATUS == "close") {
                $faktur = $this->db->query('SELECT 
                                            FSJ.FAKTUR_ID 
                                            FROM 
                                            FAKTUR AS F
                                            LEFT JOIN
                                            FAKTUR_SURAT_JALAN AS FSJ
                                            ON F.FAKTUR_ID=FSJ.FAKTUR_ID
                                            WHERE FSJ.SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" 
                                            AND F.RECORD_STATUS="AKTIF" 
                                            AND F.PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" 
                                            AND FSJ.RECORD_STATUS="AKTIF" 
                                            AND FSJ.PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" LIMIT 1')->result();

                $barang = $this->db->query('SELECT * FROM FAKTUR_BARANG WHERE FAKTUR_ID="' . $faktur[0]->FAKTUR_ID . '" AND SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" AND RECORD_STATUS="AKTIF" 
                                            AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" ')->result();
                foreach ($barang as $row_barang) {
                    $row_barang->NAMA_BARANG = $this->db->query('SELECT MASTER_BARANG_NAMA FROM MASTER_BARANG WHERE MASTER_BARANG_ID="' . $row_barang->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '"')->result();
                    $row_barang->HARGA_BARANG = $this->db->query('SELECT * FROM FAKTUR_BARANG WHERE FAKTUR_ID="' . $faktur[0]->FAKTUR_ID . '" AND MASTER_BARANG_ID="' . $row_barang->MASTER_BARANG_ID . '" AND SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '"')->result();
                    $total_perbarang += $row_barang->HARGA_BARANG[0]->FAKTUR_BARANG_QUANTITY * $row_barang->HARGA_BARANG[0]->FAKTUR_BARANG_HARGA;
                }
                $terbayar = $this->db->query('SELECT * FROM FAKTUR_TRANSAKSI
                                                                    WHERE
                                                                    FAKTUR_ID="' . $faktur[0]->FAKTUR_ID . '"
                                                                    AND RECORD_STATUS="AKTIF" 
                                                                    AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" LIMIT 1')->result();
            }

            $row->BARANG = $barang;
            $row->TOTAL = $total_perbarang;
            $row->TERBAYAR = $terbayar;
        }
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

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('PAJAK_ID', $id);
        $result = $this->db->update('PAJAK', $data);
        return $result;
    }

    public function barang_list()
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_BARANG WHERE MASTER_BARANG_JENIS="gas" AND RECORD_STATUS="AKTIF"  AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '"')->result();
        foreach ($hasil as $row) {
            if (empty($this->input->post("relasi"))) {
                $filter_relasi = "";
            } else {
                $filter_relasi = 'AND SJ.MASTER_RELASI_ID="' . $this->input->post("relasi") . '"';
            }

            $tanggal_dari = $this->input->post("tanggal_dari");
            $tanggal_sampai = $this->input->post("tanggal_sampai");

            $filter_tanggal = 'SJ.SURAT_JALAN_TANGGAL BETWEEN "' . $tanggal_dari . '" AND "' . $tanggal_sampai . '"';

            $barang = $this->db->query('SELECT SUM(SJB.SURAT_JALAN_BARANG_QUANTITY) AS QTY, SUM(SJB.SURAT_JALAN_BARANG_QUANTITY_KLAIM) AS QTY_KLAIM FROM 
                                        SURAT_JALAN_BARANG SJB LEFT JOIN SURAT_JALAN AS SJ
                                        ON SJB.SURAT_JALAN_ID=SJ.SURAT_JALAN_ID
                                        WHERE 
                                        SJ.SURAT_JALAN_JENIS="penjualan"
                                        AND SJB.MASTER_BARANG_ID ="' . $row->MASTER_BARANG_ID . '"
                                        AND ' . $filter_tanggal . '
                                        ' . $filter_relasi . '
                                        AND SJB.RECORD_STATUS="AKTIF" 
                                        AND SJB.PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" 
                                        AND SJ.RECORD_STATUS="AKTIF" 
                                        AND SJ.PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" LIMIT 1')->result();
            $row->QTY = $barang;
            $qty = $barang[0]->QTY;
            $qty_klaim = $barang[0]->QTY_KLAIM;
            $row->TOTAL = $qty - $qty_klaim;
        }
        return $hasil;
    }
}
