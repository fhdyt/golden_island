<?php
class PajakModel extends CI_Model
{
    public function list()
    {
        if ($this->input->post('jenis_pajak') == "masukan") {
            $hasil = $this->db->query('SELECT * 
                                        FROM PEMBELIAN_TRANSAKSI AS T
                                        LEFT JOIN PEMBELIAN AS P
                                        ON T.PI_ID=P.PI_ID
                                        WHERE 
                                        MONTH(P.PEMBELIAN_TANGGAL) = ' . $this->input->post('bulan') . ' 
                                        AND YEAR(P.PEMBELIAN_TANGGAL) = ' . $this->input->post('tahun') . ' 
                                        AND T.RECORD_STATUS="AKTIF" 
                                        AND T.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                        AND P.RECORD_STATUS="AKTIF" 
                                        AND P.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                        ORDER BY P.PEMBELIAN_TANGGAL ASC')->result();
        } else if ($this->input->post('jenis_pajak') == "pengeluaran") {
            $hasil = $this->db->query('SELECT * 
                                        FROM FAKTUR_TRANSAKSI AS T
                                        LEFT JOIN FAKTUR AS F
                                        ON T.FAKTUR_ID=F.FAKTUR_ID
                                        WHERE 
                                        MONTH(F.FAKTUR_TANGGAL) = ' . $this->input->post('bulan') . ' 
                                        AND YEAR(F.FAKTUR_TANGGAL) = ' . $this->input->post('tahun') . ' 
                                        AND T.RECORD_STATUS="AKTIF" 
                                        AND T.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                        AND F.RECORD_STATUS="AKTIF" 
                                        AND F.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                        ORDER BY F.FAKTUR_TANGGAL ASC')->result();
        } else {
            $hasil = array();
        }

        return $hasil;
    }

    public function add()
    {
        if ($this->input->post('id') == "") {
            $data = array(
                'AKUN_ID' => create_id(),
                'AKUN_NAMA' => $this->input->post('nama'),
                'AKUN_KATEGORI' => $this->input->post('kategori'),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('AKUN', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d G:i:s"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->where('AKUN_ID', $this->input->post('id'));
            $edit = $this->db->update('AKUN', $data_edit);

            $data = array(
                'AKUN_ID' => $this->input->post('id'),
                'AKUN_NAMA' => $this->input->post('nama'),
                'AKUN_KATEGORI' => $this->input->post('kategori'),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('AKUN', $data);
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

        $this->db->where('AKUN_ID', $id);
        $result = $this->db->update('AKUN', $data);
        return $result;
    }

    public function jenis_pajak($jenis)
    {
        if ($jenis == "masukan") {
            $hasil = $this->db->query('SELECT * FROM MASTER_SUPPLIER WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        } else if ($jenis == "pengeluaran") {
            $hasil = $this->db->query('SELECT * FROM MASTER_RELASI WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        } else {
            $hasil = array();
        }

        return $hasil;
    }
}
