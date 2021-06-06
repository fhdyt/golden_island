<?php
class PenjualanModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * 
                            FROM 
                            SURAT_JALAN 
                            WHERE 
                            SURAT_JALAN_TANGGAL = "' . $this->input->post('tanggal') . '"
                            AND SURAT_JALAN_JENIS = "penjualan"
                            AND (SURAT_JALAN_REALISASI_STATUS="selesai" OR SURAT_JALAN_REALISASI_TTBK_STATUS="selesai")
                            AND RECORD_STATUS="AKTIF" 
                            AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" 
                            ORDER BY SURAT_JALAN_NOMOR ')->result();
        foreach ($hasil as $row) {
            $row->RELASI = $this->db->query('SELECT MASTER_RELASI_NAMA FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '"')->result();
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
            if ($row->SURAT_JALAN_STATUS == "close") {
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
                                            AND FSJ.PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" 
                                            LIMIT 1')->result();
                foreach ($barang as $row_barang) {
                    $row_barang->HARGA_BARANG = $this->db->query('SELECT * FROM FAKTUR_BARANG
                                                                    WHERE
                                                                    FAKTUR_ID="' . $faktur[0]->FAKTUR_ID . '"
                                                                    AND MASTER_BARANG_ID="' . $row_barang->MASTER_BARANG_ID . '"
                                                                    AND RECORD_STATUS="AKTIF" 
                                                                    AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" LIMIT 1')->result();
                }
            } else {
                foreach ($barang as $row_barang) {
                    $row_barang->HARGA_BARANG = array();
                }
            }


            $row->BARANG = $barang;
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

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('PAJAK', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
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

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
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
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('PAJAK_ID', $id);
        $result = $this->db->update('PAJAK', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM PAJAK WHERE PAJAK_ID="' . $id . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }
}
