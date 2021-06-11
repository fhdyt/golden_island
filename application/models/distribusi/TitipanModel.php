<?php
class TitipanModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * 
                                    FROM 
                                    JURNAL_TABUNG AS J
                                    LEFT JOIN MASTER_RELASI AS R
                                    ON
                                    J.MASTER_RELASI_ID=R.MASTER_RELASI_ID
                                    LEFT JOIN
                                    MASTER_BARANG AS B
                                    ON
                                    J.MASTER_BARANG_ID=B.MASTER_BARANG_ID
                                    WHERE J.JURNAL_TABUNG_TITIPAN="Yes" 
                                    AND J.RECORD_STATUS="AKTIF" 
                                    AND J.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                    AND R.RECORD_STATUS="AKTIF" 
                                    AND R.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                    AND B.RECORD_STATUS="AKTIF" 
                                    AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                    ORDER BY J.JURNAL_TABUNG_NOMOR DESC ')->result();
        foreach ($hasil as $row) {
            $row->TANGGAL = tanggal($row->JURNAL_TABUNG_TANGGAL);
        }
        return $hasil;
    }

    public function add()
    {
        $data_mp = array(
            'JURNAL_TABUNG_ID' => create_id(),
            'MASTER_RELASI_ID' => $this->input->post('relasi'),
            'MASTER_BARANG_ID' => $this->input->post('jenis'),
            'JURNAL_TABUNG_NOMOR' => nomor_titipan($this->input->post('tanggal')),
            'JURNAL_TABUNG_TANGGAL' => $this->input->post('tanggal'),
            'JURNAL_TABUNG_KIRIM' => "0",
            'JURNAL_TABUNG_KEMBALI' => $this->input->post('jumlah'),
            'JURNAL_TABUNG_STATUS' => $this->input->post('kepemilikan'),
            'JURNAL_TABUNG_KETERANGAN' => $this->input->post('keterangan'),
            'JURNAL_TABUNG_FILE' => "empty",
            'JURNAL_TABUNG_TITIPAN' => "Yes",

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );
        $resutl = $this->db->insert('JURNAL_TABUNG', $data_mp);
        return $resutl;
    }

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('JURNAL_TABUNG_ID', $id);
        $result = $this->db->update('JURNAL_TABUNG', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM PAJAK WHERE PAJAK_ID="' . $id . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }
}
