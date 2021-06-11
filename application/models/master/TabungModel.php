<?php
class TabungModel extends CI_Model
{

    public function list($tabung)
    {
        if (empty($tabung)) {
            $filter_tabung = "";
        } else {
            $filter_tabung = 'AND T.MASTER_BARANG_ID = "' . $tabung . '"';
        }
        $hasil = $this->db->query('SELECT * FROM 
        MASTER_TABUNG AS T LEFT JOIN MASTER_BARANG AS B
        ON T.MASTER_BARANG_ID=B.MASTER_BARANG_ID
        WHERE 
        T.RECORD_STATUS="AKTIF" AND T.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
        AND B.RECORD_STATUS="AKTIF" AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
        ' . $filter_tabung . '
        ORDER BY T.MASTER_TABUNG_KODE')->result();
        foreach ($hasil as $row) {
            $riwayat_tabung = $this->db->query('SELECT RIWAYAT_TABUNG_STATUS FROM RIWAYAT_TABUNG WHERE MASTER_TABUNG_ID="' . $row->MASTER_TABUNG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY RIWAYAT_TABUNG_INDEX DESC LIMIT 1');
            if ($riwayat_tabung->num_rows() > 0) {
                $row->RIWAYAT = $riwayat_tabung->result();
            } else {
                $row->RIWAYAT = array();
            }
        }

        return $hasil;
    }
    public function pembelian_jenis_gas()
    {
        $hasil = $this->db->query('SELECT * FROM PEMBELIAN WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" AND PEMBELIAN_JENIS="tabung" ')->result();
        return $hasil;
    }

    public function add()
    {
        $tabung_id = create_id();

        if ($this->input->post('id') == "") {
            for ($x = 0; $x < $this->input->post('jumlah'); $x++) {
                $tabung_id_loop = create_id();
                $data_riwayat_tabung = array(
                    'RIWAYAT_TABUNG_ID' => create_id(),
                    'MASTER_TABUNG_ID' => $tabung_id_loop,
                    'RIWAYAT_TABUNG_TANGGAL' => $this->input->post('tanggal'),
                    'RIWAYAT_TABUNG_STATUS' => '0',
                    'RIWAYAT_TABUNG_KETERANGAN' => '',

                    'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                    'ENTRI_USER' => $this->session->userdata('USER_ID'),
                    'RECORD_STATUS' => "AKTIF",
                    'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
                );
                $this->db->insert('RIWAYAT_TABUNG', $data_riwayat_tabung);

                if ($this->input->post('isi') == "on") {
                    $data_riwayat_tabung = array(
                        'RIWAYAT_TABUNG_ID' => create_id(),
                        'MASTER_TABUNG_ID' => $tabung_id_loop,
                        'RIWAYAT_TABUNG_TANGGAL' => $this->input->post('tanggal'),
                        'RIWAYAT_TABUNG_STATUS' => '1',
                        'RIWAYAT_TABUNG_KETERANGAN' => '',

                        'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                        'ENTRI_USER' => $this->session->userdata('USER_ID'),
                        'RECORD_STATUS' => "AKTIF",
                        'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
                    );
                    $this->db->insert('RIWAYAT_TABUNG', $data_riwayat_tabung);
                }

                $data = array(
                    'MASTER_TABUNG_ID' => $tabung_id_loop,
                    'MASTER_TABUNG_KODE' => kode_tabung(),
                    'MASTER_TABUNG_KODE_LAMA' => $this->input->post('kode_lama'),
                    'MASTER_BARANG_ID' => $this->input->post('tabung'),
                    'MASTER_TABUNG_KEPEMILIKAN' => $this->input->post('kepemilikan'),
                    'MASTER_TABUNG_KODE_PRODUKSI' => $this->input->post('kode_produksi'),
                    'MASTER_TABUNG_TAHUN' => $this->input->post('tahun'),
                    'STOK_BARANG_ID' => "",

                    'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                    'ENTRI_USER' => $this->session->userdata('USER_ID'),
                    'RECORD_STATUS' => "AKTIF",
                    'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
                );

                $result = $this->db->insert('MASTER_TABUNG', $data);
            }
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d G:i:s"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $this->db->where('MASTER_TABUNG_ID', $this->input->post('id'));
            $edit = $this->db->update('MASTER_TABUNG', $data_edit);

            $data = array(
                'MASTER_TABUNG_ID' => $this->input->post('id'),
                'MASTER_TABUNG_KODE' => $this->input->post('kode'),
                'MASTER_TABUNG_KODE_LAMA' => $this->input->post('kode_lama'),
                'MASTER_BARANG_ID' => $this->input->post('tabung'),
                'MASTER_TABUNG_KEPEMILIKAN' => $this->input->post('kepemilikan'),
                'MASTER_TABUNG_KODE_PRODUKSI' => $this->input->post('kode_produksi'),
                'MASTER_TABUNG_TAHUN' => $this->input->post('tahun'),

                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
                'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
            );

            $result = $this->db->insert('MASTER_TABUNG', $data);
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

        $this->db->where('MASTER_TABUNG_ID', $id);
        $result = $this->db->update('MASTER_TABUNG', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM MASTER_TABUNG WHERE MASTER_TABUNG_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" LIMIT 1')->result();
        return $hasil;
    }

    public function list_riwayat($id)
    {
        $hasil = $this->db->query('SELECT * FROM RIWAYAT_TABUNG WHERE MASTER_TABUNG_ID="' . $id . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY RIWAYAT_TABUNG_INDEX')->result();
        foreach ($hasil as $row_sj) {
            $relasi = $this->db->query('SELECT * FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $row_sj->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"  LIMIT 1 ')->result();
            $row_sj->RELASI = $relasi;
            $supplier = $this->db->query('SELECT * FROM MASTER_SUPPLIER WHERE MASTER_SUPPLIER_ID="' . $row_sj->MASTER_SUPPLIER_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '"  LIMIT 1 ')->result();
            $row_sj->SUPPLIER = $supplier;
            $row_sj->TANGGAL = tanggal($row_sj->RIWAYAT_TABUNG_TANGGAL);
        }
        return $hasil;
    }
}
