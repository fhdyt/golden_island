<?php
class PanggungModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM 
                                                    MASTER_BARANG 
                                                    WHERE 
                                                    MASTER_BARANG_JENIS="gas"
                                                    AND NOT MASTER_BARANG_PRIORITAS="0"
                                                    AND RECORD_STATUS="AKTIF" 
                                                    AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" ORDER BY MASTER_BARANG_PRIORITAS DESC, MASTER_BARANG_NAMA ASC')->result();
        foreach ($hasil as $row) {

            $row->SALDO_MP_ISI_OUT = $this->db->query('SELECT SUM(PANGGUNG_JUMLAH) AS JUMLAH FROM 
                                                    PANGGUNG 
                                                    WHERE
                                                    MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '"
                                                    AND PANGGUNG_STATUS_KEPEMILIKAN="MP"
                                                    AND PANGGUNG_STATUS="out"
                                                    AND PANGGUNG_STATUS_ISI="1"
                                                    AND RECORD_STATUS="AKTIF" 
                                                    AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" ')->result();
            $row->SALDO_MP_KOSONG_OUT = $this->db->query('SELECT SUM(PANGGUNG_JUMLAH) AS JUMLAH FROM 
                                                    PANGGUNG 
                                                    WHERE
                                                    MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '"
                                                    AND PANGGUNG_STATUS_KEPEMILIKAN="MP"
                                                    AND PANGGUNG_STATUS="out"
                                                    AND PANGGUNG_STATUS_ISI="0"
                                                    AND RECORD_STATUS="AKTIF" 
                                                    AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" ')->result();



            $row->SALDO_MR_ISI_OUT = $this->db->query('SELECT SUM(PANGGUNG_JUMLAH) AS JUMLAH FROM 
                                                    PANGGUNG 
                                                    WHERE
                                                    MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '"
                                                    AND PANGGUNG_STATUS_KEPEMILIKAN="MR"
                                                    AND PANGGUNG_STATUS="out"
                                                    AND PANGGUNG_STATUS_ISI="1"
                                                    AND RECORD_STATUS="AKTIF" 
                                                    AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" ')->result();
            $row->SALDO_MR_KOSONG_OUT = $this->db->query('SELECT SUM(PANGGUNG_JUMLAH) AS JUMLAH FROM 
                                                    PANGGUNG 
                                                    WHERE
                                                    MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '"
                                                    AND PANGGUNG_STATUS_KEPEMILIKAN="MR"
                                                    AND PANGGUNG_STATUS="out"
                                                    AND PANGGUNG_STATUS_ISI="0"
                                                    AND RECORD_STATUS="AKTIF" 
                                                    AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" ')->result();

            $row->SALDO_MP_ISI_IN = $this->db->query('SELECT SUM(PANGGUNG_JUMLAH) AS JUMLAH FROM 
                                                    PANGGUNG 
                                                    WHERE
                                                    MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '"
                                                    AND PANGGUNG_STATUS_KEPEMILIKAN="MP"
                                                    AND PANGGUNG_STATUS="in"
                                                    AND PANGGUNG_STATUS_ISI="1"
                                                    AND RECORD_STATUS="AKTIF" 
                                                    AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" ')->result();
            $row->SALDO_MP_KOSONG_IN = $this->db->query('SELECT SUM(PANGGUNG_JUMLAH) AS JUMLAH FROM 
                                                    PANGGUNG 
                                                    WHERE
                                                    MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '"
                                                    AND PANGGUNG_STATUS_KEPEMILIKAN="MP"
                                                    AND PANGGUNG_STATUS="in"
                                                    AND PANGGUNG_STATUS_ISI="0"
                                                    AND RECORD_STATUS="AKTIF" 
                                                    AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" ')->result();

            $row->SALDO_MR_ISI_IN = $this->db->query('SELECT SUM(PANGGUNG_JUMLAH) AS JUMLAH FROM 
                                                    PANGGUNG 
                                                    WHERE
                                                    MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '"
                                                    AND PANGGUNG_STATUS_KEPEMILIKAN="MR"
                                                    AND PANGGUNG_STATUS="in"
                                                    AND PANGGUNG_STATUS_ISI="1"
                                                    AND RECORD_STATUS="AKTIF" 
                                                    AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" ')->result();
            $row->SALDO_MR_KOSONG_IN = $this->db->query('SELECT SUM(PANGGUNG_JUMLAH) AS JUMLAH FROM 
                                                    PANGGUNG 
                                                    WHERE
                                                    MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '"
                                                    AND PANGGUNG_STATUS_KEPEMILIKAN="MR"
                                                    AND PANGGUNG_STATUS="in"
                                                    AND PANGGUNG_STATUS_ISI="0"
                                                    AND RECORD_STATUS="AKTIF" 
                                                    AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '" ')->result();
        }
        return $hasil;
    }

    public function verifikasi()
    {
        $data_mp = array(
            'VERIFIKASI_PANGGUNG_ID' => create_id(),
            'VERIFIKASI_PANGGUNG_TOTAL' => $this->input->post('total'),
            'VERIFIKASI_PANGGUNG_TANGGAL' => date("Y-m-d G:i:s"),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );
        $result = $this->db->insert('VERIFIKASI_PANGGUNG', $data_mp);
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

        $this->db->where('PAJAK_ID', $id);
        $result = $this->db->update('PAJAK', $data);
        return $result;
    }

    public function verifikasi_list()
    {
        $hasil = $this->db->query('SELECT * 
                                    FROM VERIFIKASI_PANGGUNG 
                                    WHERE VERIFIKASI_PANGGUNG_TANGGAL LIKE "%' . date("Y-m-d") . '%" 
                                    AND RECORD_STATUS="AKTIF" 
                                    AND PERUSAHAAN_KODE="' . $this->input->post('perusahaan') . '"')->result();
        foreach ($hasil as $row) {
            $row->USER = $this->db->query('SELECT * FROM USER WHERE USER_ID="' . $row->ENTRI_USER . '" AND RECORD_STATUS="AKTIF"')->result();
        }
        return $hasil;
    }
    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM PAJAK WHERE PAJAK_ID="' . $id . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }
}
