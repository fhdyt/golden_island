<?php
class Surat_jalanModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM SURAT_JALAN WHERE RECORD_STATUS="AKTIF" ORDER BY SURAT_JALAN_TANGGAL DESC ')->result();

        foreach ($hasil as $row) {
            $nama_relasi = $this->db->query('SELECT MASTER_RELASI_NAMA FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '"')->result();
            $row->RELASI = $nama_relasi;
        }

        foreach ($hasil as $row) {
            $nama_driver = $this->db->query('SELECT MASTER_DRIVER_NAMA FROM MASTER_DRIVER WHERE MASTER_DRIVER_ID="' . $row->MASTER_DRIVER_ID . '"')->result();
            $row->DRIVER = $nama_driver;
        }
        foreach ($hasil as $row) {
            $nama_kendaraan = $this->db->query('SELECT MASTER_KENDARAAN_NOMOR FROM MASTER_KENDARAAN WHERE MASTER_KENDARAAN_ID="' . $row->MASTER_KENDARAAN_ID . '"')->result();
            $row->KENDARAAN = $nama_kendaraan;
        }
        return $hasil;
    }
    public function barang_list($id)
    {
        $hasil = $this->db->query('SELECT JB.MASTER_JENIS_BARANG_NAMA,JB.MASTER_JENIS_BARANG_ID FROM 
        SURAT_JALAN_BARANG AS SJB LEFT JOIN MASTER_JENIS_BARANG AS JB
        ON SJB.MASTER_JENIS_BARANG_ID=JB.MASTER_JENIS_BARANG_ID
        WHERE (SJB.RECORD_STATUS="AKTIF" OR SJB.RECORD_STATUS="DRAFT") 
        AND JB.RECORD_STATUS="AKTIF" 
        AND SJB.SURAT_JALAN_ID="' . $id . '" 
        GROUP BY JB.MASTER_JENIS_BARANG_NAMA,JB.MASTER_JENIS_BARANG_ID')->result();
        foreach ($hasil as $row) {
            $detail = $this->db->query('SELECT *
            FROM 
        SURAT_JALAN_BARANG AS SJB LEFT JOIN MASTER_JENIS_BARANG_DETAIL AS JBD
        ON SJB.MASTER_JENIS_BARANG_DETAIL_ID=JBD.MASTER_JENIS_BARANG_DETAIL_ID
        WHERE (SJB.RECORD_STATUS="AKTIF" OR SJB.RECORD_STATUS="DRAFT") 
        AND JBD.RECORD_STATUS="AKTIF"
        AND SJB.MASTER_JENIS_BARANG_ID="' . $row->MASTER_JENIS_BARANG_ID . '"
        AND SJB.SURAT_JALAN_ID="' . $id . '"')->result();
            $row->DETAIL = $detail;
        }
        return $hasil;
    }

    public function detail_jenis_barang($id)
    {
        $hasil = $this->db->query('SELECT * FROM 
        MASTER_JENIS_BARANG_DETAIL 
        WHERE RECORD_STATUS="AKTIF" 
        AND MASTER_JENIS_BARANG_ID="' . $id . '" ')->result();
        return $hasil;
    }
    public function perharga($id, $relasi)
    {
        $hasil = $this->db->query('SELECT * FROM 
        MASTER_HARGA 
        WHERE RECORD_STATUS="AKTIF" 
        AND MASTER_JENIS_BARANG_DETAIL_ID="' . $id . '"
        AND MASTER_RELASI_ID="' . $relasi . '"')->result();
        return $hasil;
    }

    public function add()
    {
        $jumlah = $this->db->query('SELECT SUM(SURAT_JALAN_BARANG_QTY) AS QTY, SUM(SURAT_JALAN_BARANG_TOTAL) AS TOTAL FROM SURAT_JALAN_BARANG WHERE SURAT_JALAN_ID="' . $this->input->post('id') . '" AND (RECORD_STATUS="AKTIF" OR RECORD_STATUS="DRAFT")')->result();
        $data_edit_aktif = array(
            'RECORD_STATUS' => "AKTIF",
        );

        $this->db->where('SURAT_JALAN_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'DRAFT');
        $edit_aktif = $this->db->update('SURAT_JALAN_BARANG', $data_edit_aktif);

        $data_edit = array(
            'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
        );

        $this->db->where('SURAT_JALAN_ID', $this->input->post('id'));
        $edit = $this->db->update('SURAT_JALAN', $data_edit);

        $data = array(
            'SURAT_JALAN_JENIS' => $this->input->post('jenis_sj'),
            'SURAT_JALAN_ID' => $this->input->post('id'),
            'SURAT_JALAN_NOMOR' => $this->input->post('nomor'),
            'SURAT_JALAN_TANGGAL' => $this->input->post('tanggal'),
            'MASTER_RELASI_ID' => $this->input->post('relasi'),
            'SURAT_JALAN_NAMA_PELANGGAN' => $this->input->post('pelanggan'),
            'MASTER_DRIVER_ID' => $this->input->post('driver'),
            'MASTER_KENDARAAN_ID' => $this->input->post('kendaraan'),
            'SURAT_JALAN_JUMLAH' => $jumlah[0]->QTY,
            'SURAT_JALAN_TOTAL' => $jumlah[0]->TOTAL,

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
        );

        $result = $this->db->insert('SURAT_JALAN', $data);
        return $result;
    }

    public function add_barang()
    {

        $total = $this->input->post('qty') * $this->input->post('harga');
        $data = array(
            'SURAT_JALAN_BARANG_ID' => create_id(),
            'SURAT_JALAN_ID' => $this->input->post('id'),
            'MASTER_JENIS_BARANG_ID' => $this->input->post('jenis_barang'),
            'MASTER_JENIS_BARANG_DETAIL_ID' => $this->input->post('detail_barang'),
            'SURAT_JALAN_BARANG_QTY' => $this->input->post('qty'),
            'SURAT_JALAN_BARANG_HARGA' => $this->input->post('harga'),
            'SURAT_JALAN_BARANG_TOTAL' => $total,

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DRAFT",
        );

        $result = $this->db->insert('SURAT_JALAN_BARANG', $data);
        return $result;
    }

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
        );

        $this->db->where('MASTER_KENDARAAN_ID', $id);
        $result = $this->db->update('MASTER_KENDARAAN', $data);
        return $result;
    }

    public function hapus_barang($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
        );

        $this->db->where('SURAT_JALAN_BARANG_ID', $id);
        $result = $this->db->update('SURAT_JALAN_BARANG', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM SURAT_JALAN WHERE SURAT_JALAN_ID="' . $id . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }
}
