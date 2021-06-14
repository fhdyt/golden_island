<?php
class RelasiModel extends CI_Model
{

    public function list()
    {
        if (empty($this->input->post('nama_relasi'))) {
            $filter = '';
        } else {
            $filter = 'MASTER_RELASI_NAMA LIKE "%' . $this->input->post('nama_relasi') . '%" AND';
        }

        $hasil = $this->db->query('SELECT * FROM MASTER_RELASI WHERE ' . $filter . ' RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY MASTER_RELASI_NAMA')->result();

        foreach ($hasil as $row) {

            $begin = new DateTime("" . $this->input->post('tahun') . "-" . $this->input->post('bulan') . "-01");
            $tanggal_terakhir = date("t", strtotime("" . $this->input->post('tahun') . "-" . $this->input->post('bulan') . "-01"));
            $end   = new DateTime("" . $this->input->post('tahun') . "-" . $this->input->post('bulan') . "-" . $tanggal_terakhir . "");

            for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
                $jumlah_pemesanan = $this->db->query('SELECT SUM(SB.SURAT_JALAN_BARANG_QUANTITY) AS JUMLAH
                                                        FROM SURAT_JALAN_BARANG AS SB
                                                        LEFT JOIN
                                                        SURAT_JALAN AS SJ
                                                        ON
                                                        SB.SURAT_JALAN_ID=SJ.SURAT_JALAN_ID
                                                        WHERE 
                                                        SJ.SURAT_JALAN_TANGGAL="' . $i->format("Y-m-d") . '" 
                                                        AND 
                                                        SJ.MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" 
                                                        AND 
                                                        SJ.RECORD_STATUS="AKTIF" 
                                                        AND 
                                                        SJ.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                                        AND 
                                                        SB.RECORD_STATUS="AKTIF" 
                                                        AND 
                                                        SB.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"
                                                        ')->result();
                $tanggal[$i->format("d")] = $jumlah_pemesanan[0]->JUMLAH;
            }
            $row->TANGGAL = $tanggal;
            $row->JUMLAH_TANGGAL = $tanggal_terakhir;
            $surat_jalan = $this->db->query('SELECT SURAT_JALAN_TANGGAL FROM SURAT_JALAN WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY SURAT_JALAN_TANGGAL DESC LIMIT 1')->result();
            if (empty($surat_jalan)) {
                $row->SELISIH_TANGGAL = array();
                $row->SURAT_JALAN_TERAKHIR = array();
            } else {
                $row->SURAT_JALAN_TERAKHIR = tanggal($surat_jalan[0]->SURAT_JALAN_TANGGAL);
                $date1 = strtotime(date("Y-m-d"));
                $date2 = strtotime($row->SURAT_JALAN_TERAKHIR);
                $diff = abs($date2 - $date1);
                $years = floor($diff / (365 * 60 * 60 * 24));
                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                $row->SELISIH_TANGGAL = $days . " Hari, " . $months . " Bulan, " . $years . " Tahun";
                $row->HARI_INI = date("Y-m-d");
            }
        }
        return $hasil;
    }

    public function kontrol_tabung_list($id, $tabung, $status)
    {
        if (empty($status)) {
            $filter_status = "";
        } else {
            $filter_status = 'AND JURNAL_TABUNG_STATUS="' . $status . '"';
        }
        $hasil = $this->db->query('SELECT * FROM JURNAL_TABUNG WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" AND MASTER_RELASI_ID="' . $id . '" AND MASTER_BARANG_ID="' . $tabung . '" ' . $filter_status . ' ORDER BY JURNAL_TABUNG_TANGGAL ASC ')->result();
        foreach ($hasil as $row) {
            $nama_barang = $this->db->query('SELECT MASTER_BARANG_NAMA FROM MASTER_BARANG WHERE MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"');
            $row->NAMA_BARANG = $nama_barang;
            $row->TANGGAL = tanggal($row->JURNAL_TABUNG_TANGGAL);
            $row->TOTAL = $row->JURNAL_TABUNG_KIRIM - $row->JURNAL_TABUNG_KEMBALI;
        }

        return $hasil;
    }
    public function add_kontrol_tabung($user, $config)
    {
        $data = array(
            'JURNAL_TABUNG_ID' => create_id(),
            'MASTER_RELASI_ID' => $user,
            'MASTER_BARANG_ID' => $this->input->post('tabung'),
            'JURNAL_TABUNG_TANGGAL' => $this->input->post('tanggal'),
            'JURNAL_TABUNG_KIRIM' => $this->input->post('kirim'),
            'JURNAL_TABUNG_KEMBALI' => $this->input->post('kembali'),
            'JURNAL_TABUNG_STATUS' => $this->input->post('status'),
            'JURNAL_TABUNG_KETERANGAN' => $this->input->post('keterangan'),
            'JURNAL_TABUNG_FILE' => $config['file_name'],

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('JURNAL_TABUNG', $data);
        return $result;
    }

    public function hapus_kontrol_tabung($id)
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

    public function add()
    {
        if ($this->input->post('id') == "") {
            $data = array(
                'MASTER_RELASI_ID' => create_id(),
                'MASTER_RELASI_QR_ID' => $this->input->post('qr_id'),
                'MASTER_RELASI_NAMA' => $this->input->post('nama'),
                'MASTER_RELASI_ALAMAT' => $this->input->post('alamat'),
                'MASTER_RELASI_HP' => $this->input->post('hp'),
                'MASTER_RELASI_NPWP' => $this->input->post('npwp'),
                'MASTER_RELASI_KTP' => $this->input->post('ktp'),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('MASTER_RELASI', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d G:i:s"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->where('MASTER_RELASI_ID', $this->input->post('id'));
            $edit = $this->db->update('MASTER_RELASI', $data_edit);

            $data = array(
                'MASTER_RELASI_ID' => $this->input->post('id'),
                'MASTER_RELASI_QR_ID' => $this->input->post('qr_id'),
                'MASTER_RELASI_NAMA' => $this->input->post('nama'),
                'MASTER_RELASI_ALAMAT' => $this->input->post('alamat'),
                'MASTER_RELASI_HP' => $this->input->post('hp'),
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

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('MASTER_RELASI_ID', $id);
        $result = $this->db->update('MASTER_RELASI', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        return $hasil;
    }

    public function harga_list($id)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_BARANG WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY MASTER_BARANG_NAMA AND MASTER_BARANG_JENIS="gas" ASC ')->result();
        foreach ($hasil as $row) {
            $harga = $this->db->query('SELECT * FROM 
            MASTER_HARGA WHERE MASTER_BARANG_ID="' . $row->MASTER_BARANG_ID . '" AND MASTER_RELASI_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"');
            if ($harga->num_rows() == 0) {
                $row->HARGA = array([]);
            } else {
                $row->HARGA = $harga->result();
            }
        }
        return $hasil;
    }

    public function add_harga($user)
    {
        $cek = $this->db->query('SELECT * FROM MASTER_HARGA WHERE MASTER_RELASI_ID="' . $user . '" AND MASTER_BARANG_ID="' . $this->input->post('id_detail') . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"');
        if ($cek->num_rows() == 0) {
            $data = array(
                'MASTER_HARGA_ID' => create_id(),
                'MASTER_RELASI_ID' => $user,
                'MASTER_BARANG_ID' => $this->input->post('id_detail'),
                'MASTER_HARGA_HARGA' => str_replace(".", "", $this->input->post('harga')),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('MASTER_HARGA', $data);
            return $result;
        } else {
            $harga = $cek->result();
            $data_delete = array(
                'DELETE_WAKTU' => date("Y-m-d G:i:s"),
                'DELETE_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "DELETE",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->where('MASTER_HARGA_ID', $harga[0]->MASTER_HARGA_ID);
            $result_delete = $this->db->update('MASTER_HARGA', $data_delete);

            $data = array(
                'MASTER_HARGA_ID' => create_id(),
                'MASTER_RELASI_ID' => $user,
                'MASTER_BARANG_ID' => $this->input->post('id_detail'),
                'MASTER_HARGA_HARGA' => str_replace(".", "", $this->input->post('harga')),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('MASTER_HARGA', $data);
            return $result;
        }
    }
}
