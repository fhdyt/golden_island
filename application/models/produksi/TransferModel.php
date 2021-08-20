<?php
class TransferModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM 
                                    PRODUKSI_TRANSFER 
                                    WHERE 
                                    MONTH(PRODUKSI_TRANSFER_TANGGAL) = ' . $this->input->post('bulan') . ' 
                                        AND YEAR(PRODUKSI_TRANSFER_TANGGAL) = ' . $this->input->post('tahun') . ' 
                                    AND
                                    RECORD_STATUS="AKTIF" 
                                    AND 
                                    PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                    ORDER BY PRODUKSI_TRANSFER_NOMOR DESC ')->result();
        foreach ($hasil as $row) {
            $total_dari = $this->db->query('SELECT SUM(PRODUKSI_TRANSFER_BARANG_TOTAL) AS TOTAL
            FROM PRODUKSI_TRANSFER_BARANG
            WHERE PRODUKSI_TRANSFER_ID="' . $row->PRODUKSI_ID . '"
                                        AND RECORD_STATUS="AKTIF" 
                                        AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
            $row->TOTAL_DARI = $total_dari[0]->TOTAL;
            $row->TANGGAL = tanggal($row->PRODUKSI_TANGGAL);
        }
        return $hasil;
    }

    public function list_barang_dari($id)
    {
        $hasil = $this->db->query('SELECT * 
                                        FROM PRODUKSI_TRANSFER_BARANG_DARI AS P
                                        LEFT JOIN MASTER_BARANG AS B
                                        ON P.MASTER_BARANG_ID=B.MASTER_BARANG_ID
                                        WHERE 
                                        P.PRODUKSI_TRANSFER_ID="' . $id . '"
                                        AND (P.RECORD_STATUS="AKTIF"  OR P.RECORD_STATUS="DRAFT")
                                        AND P.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                        AND B.RECORD_STATUS="AKTIF" 
                                        AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                        ORDER BY P.PRODUKSI_TRANSFER_BARANG_DARI_INDEX DESC ')->result();
        return $hasil;
    }

    public function list_barang_jadi($id)
    {
        $hasil = $this->db->query('SELECT * 
                                        FROM PRODUKSI_TRANSFER_BARANG_JADI AS P
                                        LEFT JOIN MASTER_BARANG AS B
                                        ON P.MASTER_BARANG_ID=B.MASTER_BARANG_ID
                                        WHERE 
                                        P.PRODUKSI_TRANSFER_ID="' . $id . '"
                                        AND (P.RECORD_STATUS="AKTIF"  OR P.RECORD_STATUS="DRAFT")
                                        AND P.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                        AND B.RECORD_STATUS="AKTIF" 
                                        AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                        ORDER BY P.PRODUKSI_TRANSFER_BARANG_JADI_INDEX DESC ')->result();
        return $hasil;
    }

    public function jenis_barang($id)
    {
        $hasil = $this->db->query('SELECT * 
                                       FROM MASTER_BARANG 
                                        WHERE 
                                        MASTER_BARANG_BAHAN="' . $id . '"
                                        AND RECORD_STATUS="AKTIF"
                                        AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        return $hasil;
    }

    public function kapasitas_tangki($id)
    {
        $hasil = $this->db->query('SELECT * 
                                       FROM MASTER_TANGKI 
                                        WHERE 
                                        MASTER_TANGKI_ID="' . $id . '"
                                        AND RECORD_STATUS="AKTIF"
                                        AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"')->result();
        foreach ($hasil as $row) {
            $kapasitas = $this->db->query('SELECT SUM(RIWAYAT_TANGKI_KAPASITAS_MASUK) AS MASUK,SUM(RIWAYAT_TANGKI_KAPASITAS_KELUAR) AS KELUAR FROM RIWAYAT_TANGKI
            WHERE MASTER_TANGKI_ID="' . $row->MASTER_TANGKI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"');
            if ($kapasitas->num_rows() == 0) {
                $row->KAPASITAS = array();
            } else {
                $hasil_kapasitas =  $kapasitas->result();
                $row->KAPASITAS_MASUK = $hasil_kapasitas[0]->MASUK;
                $row->KAPASITAS_KELUAR = $hasil_kapasitas[0]->KELUAR;
                $row->TOTAL = $row->KAPASITAS_MASUK - $row->KAPASITAS_KELUAR;
            }
        }
        return $hasil;
    }

    public function list_karyawan($id)
    {
        $hasil = $this->db->query('SELECT * 
                                        FROM PRODUKSI_TRANSFER_KARYAWAN AS P
                                        LEFT JOIN MASTER_KARYAWAN AS K
                                        ON P.MASTER_KARYAWAN_ID=K.MASTER_KARYAWAN_ID
                                        WHERE 
                                        P.PRODUKSI_TRANSFER_ID="' . $id . '"
                                        AND (P.RECORD_STATUS="AKTIF"  OR P.RECORD_STATUS="DRAFT")
                                        AND P.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                        AND K.RECORD_STATUS="AKTIF" 
                                        AND K.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                        ORDER BY P.PRODUKSI_TRANSFER_KARYAWAN_INDEX DESC ')->result();
        return $hasil;
    }

    public function add($config)
    {

        $data_edit = array(
            'EDIT_WAKTU' => date("Y-m-d G:i:s"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('PRODUKSI_ID', $this->input->post('id'));
        $this->db->update('PRODUKSI', $data_edit);

        $data = array(
            'PRODUKSI_ID' => $this->input->post('id'),
            'PRODUKSI_NOMOR' => nomor_produksi($this->input->post('tanggal')),
            'PRODUKSI_TANGGAL' => $this->input->post('tanggal'),
            'MASTER_BARANG_ID' => $this->input->post('jenis'),
            'PRODUKSI_LEVEL_AWAL' => $this->input->post('level_awal'),
            'PRODUKSI_LEVEL_AWAL_FILE' => $config['file_name'],

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('PRODUKSI', $data);
        return $result;
    }

    public function add_selesai()
    {
        $data_edit = array(
            'EDIT_WAKTU' => date("Y-m-d G:i:s"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('PRODUKSI_TRANSFER_ID', $this->input->post('id'));
        $this->db->update('PRODUKSI_TRANSFER', $data_edit);

        $data_edit_panggung = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('PANGGUNG_REF', $this->input->post('id'));
        $this->db->update('PANGGUNG', $data_edit_panggung);

        $data_edit_barang = array(
            'RECORD_STATUS' => "AKTIF",
        );
        $this->db->where('PRODUKSI_TRANSFER_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'DRAFT');
        $this->db->update('PRODUKSI_TRANSFER_BARANG_DARI', $data_edit_barang);

        $data_edit_barang_jadi = array(
            'RECORD_STATUS' => "AKTIF",
        );
        $this->db->where('PRODUKSI_TRANSFER_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'DRAFT');
        $this->db->update('PRODUKSI_TRANSFER_BARANG_JADI', $data_edit_barang_jadi);

        $data_edit_karyawan = array(
            'RECORD_STATUS' => "AKTIF",
        );
        $this->db->where('PRODUKSI_TRANSFER_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'DRAFT');
        $this->db->update('PRODUKSI_TRANSFER_KARYAWAN', $data_edit_karyawan);


        if ($this->input->post('nomor_transfer_produksi') == "") {
            $nomor_transfer_produksi = nomor_transfer_produksi($this->input->post('tanggal'));
        } else {
            $nomor_transfer_produksi = $this->input->post('nomor_transfer_produksi');
        }

        $data_edit_riwayat = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('RIWAYAT_TANGKI_REF', $this->input->post('id'));
        $this->db->update('RIWAYAT_TANGKI', $data_edit_riwayat);

        $data_riwayat = array(
            'RIWAYAT_TANGKI_ID' => create_id(),
            'MASTER_TANGKI_ID' => $this->input->post('master_tangki'),
            'RIWAYAT_TANGKI_TANGGAL' => date("Y-m-d"),
            'RIWAYAT_TANGKI_KAPASITAS_MASUK' => "0",
            'RIWAYAT_TANGKI_KAPASITAS_KELUAR' => $this->input->post('level_awal') - $this->input->post('level_akhir'),
            'RIWAYAT_TANGKI_KETERANGAN' => $nomor_transfer_produksi,
            'RIWAYAT_TANGKI_REF' => $this->input->post('id'),


            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );
        $this->db->insert('RIWAYAT_TANGKI', $data_riwayat);

        $data = array(
            'PRODUKSI_TRANSFER_ID' => $this->input->post('id'),
            'PRODUKSI_TRANSFER_NOMOR' => $nomor_transfer_produksi,
            'PRODUKSI_TRANSFER_TANGGAL' => $this->input->post('tanggal'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->insert('PRODUKSI_TRANSFER', $data);

        $barang = $this->db->query('SELECT * 
                                        FROM PRODUKSI_BARANG_DARI AS P
                                        LEFT JOIN MASTER_BARANG AS B
                                        ON P.MASTER_BARANG_ID=B.MASTER_BARANG_ID
                                        WHERE 
                                        P.PRODUKSI_ID="' . $this->input->post('id') . '"
                                        AND (P.RECORD_STATUS="AKTIF" OR P.RECORD_STATUS="DRAFT")
                                        AND P.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                        AND B.RECORD_STATUS="AKTIF" 
                                        AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                        ORDER BY P.PRODUKSI_BARANG_DARI_INDEX DESC ')->result();
        foreach ($barang as $row) {
            $data_panggung_mp_out = array(
                'PANGGUNG_ID' => create_id(),
                'MASTER_BARANG_ID' => $row->MASTER_BARANG_ID,
                'PANGGUNG_TANGGAL' => $this->input->post("tanggal"),
                'PANGGUNG_STATUS' => "out",
                'PANGGUNG_STATUS_ISI' => 1,
                'PANGGUNG_JUMLAH' => $row->PRODUKSI_BARANG_DARI_TOTAL,
                'PANGGUNG_STATUS_KEPEMILIKAN' => $row->PRODUKSI_BARANG_DARI_KEPEMILIKAN,
                'PANGGUNG_KETERANGAN' => "TRANSFER " . $nomor_transfer_produksi . "",
                'PANGGUNG_REF'  => $this->input->post("id"),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );
            $this->db->insert('PANGGUNG', $data_panggung_mp_out);

            $data_panggung_mp = array(
                'PANGGUNG_ID' => create_id(),
                'MASTER_BARANG_ID' => $row->MASTER_BARANG_ID,
                'PANGGUNG_TANGGAL' => $this->input->post("tanggal"),
                'PANGGUNG_STATUS' => "in",
                'PANGGUNG_STATUS_ISI' => 0,
                'PANGGUNG_JUMLAH' => $row->PRODUKSI_BARANG_DARI_TOTAL,
                'PANGGUNG_STATUS_KEPEMILIKAN' => $row->PRODUKSI_BARANG_DARI_KEPEMILIKAN,
                'PANGGUNG_KETERANGAN' => "TRANSFER " . $nomor_transfer_produksi . "",
                'PANGGUNG_REF'  => $this->input->post("id"),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );
            $this->db->insert('PANGGUNG', $data_panggung_mp);
        }

        return true;
    }

    public function add_barang_dari()
    {
        $data = array(
            'PRODUKSI_TRANSFER_BARANG_DARI_ID' => create_id(),
            'PRODUKSI_TRANSFER_ID' => $this->input->post('id'),
            'MASTER_BARANG_ID' => $this->input->post('barang'),
            'PRODUKSI_TRANSFER_BARANG_DARI_TOTAL' => $this->input->post('total_barang'),
            'PRODUKSI_TRANSFER_BARANG_DARI_KEPEMILIKAN' => $this->input->post('kepemilikan_barang'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DRAFT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('PRODUKSI_TRANSFER_BARANG_DARI', $data);
        return $result;
    }

    public function add_barang_jadi()
    {
        $data = array(
            'PRODUKSI_TRANSFER_BARANG_JADI_ID' => create_id(),
            'PRODUKSI_TRANSFER_ID' => $this->input->post('id'),
            'MASTER_BARANG_ID' => $this->input->post('barang'),
            'PRODUKSI_TRANSFER_BARANG_JADI_TOTAL' => $this->input->post('total_barang'),
            'PRODUKSI_TRANSFER_BARANG_JADI_KEPEMILIKAN' => $this->input->post('kepemilikan_barang'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DRAFT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('PRODUKSI_TRANSFER_BARANG_JADI', $data);
        return $result;
    }

    public function add_karyawan()
    {
        $data = array(
            'PRODUKSI_TRANSFER_KARYAWAN_ID' => create_id(),
            'PRODUKSI_TRANSFER_ID' => $this->input->post('id'),
            'MASTER_KARYAWAN_ID' => $this->input->post('karyawan_produksi'),
            'PRODUKSI_TRANSFER_KARYAWAN_TOTAL' => $this->input->post('total_produksi'),

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DRAFT",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $result = $this->db->insert('PRODUKSI_TRANSFER_KARYAWAN', $data);
        return $result;
    }

    public function hapus_dari($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('PRODUKSI_TRANSFER_BARANG_DARI_ID', $id);
        $result = $this->db->update('PRODUKSI_TRANSFER_BARANG_DARI', $data);
        return $result;
    }
    public function hapus_jadi($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('PRODUKSI_TRANSFER_BARANG_JADI_ID', $id);
        $result = $this->db->update('PRODUKSI_TRANSFER_BARANG_JADI', $data);
        return $result;
    }

    public function hapus_karyawan($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('PRODUKSI_TRANSFER_KARYAWAN_ID', $id);
        $result = $this->db->update('PRODUKSI_TRANSFER_KARYAWAN', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil['data'] = $this->db->query('SELECT * FROM PRODUKSI_TRANSFER WHERE PRODUKSI_TRANSFER_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        foreach ($hasil['data'] as $row) {
            $row->TANGGAL = date("Y-m-d", strtotime($row->PRODUKSI_TRANSFER_TANGGAL));
        }
        return $hasil;
    }
}
