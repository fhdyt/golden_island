<?php
class PeralihanModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * 
                                    FROM 
                                    JURNAL_TABUNG AS J
                                    LEFT JOIN
                                    MASTER_BARANG AS B
                                    ON
                                    J.MASTER_BARANG_ID=B.MASTER_BARANG_ID
                                    WHERE 
                                    J.JURNAL_TABUNG_REF="PERALIHAN"
                                    AND J.RECORD_STATUS="AKTIF" 
                                    AND J.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                    AND B.RECORD_STATUS="AKTIF" 
                                    AND B.PERUSAHAAN_KODE="' . $this->session->userdata('PERUSAHAAN_KODE') . '" 
                                    ORDER BY J.JURNAL_TABUNG_INDEX DESC ')->result();
        foreach ($hasil as $row) {
            $row->TANGGAL = tanggal($row->JURNAL_TABUNG_TANGGAL);
        }
        return $hasil;
    }

    public function add()
    {
        $id_keluar = create_id();
        $id_masuk = create_id();
        $data_keluar = array(
            'JURNAL_TABUNG_ID' =>  $id_keluar,
            'MASTER_RELASI_ID' => "",
            'MASTER_SUPPLIER_ID' => "",
            'MASTER_BARANG_ID' => $this->input->post("dari"),
            'JURNAL_TABUNG_TANGGAL' => $this->input->post("tanggal"),
            'JURNAL_TABUNG_KIRIM' => $this->input->post("jumlah"),
            'JURNAL_TABUNG_KEMBALI' => "",
            'JURNAL_TABUNG_STATUS' => $this->input->post("kepemilikan"),
            'JURNAL_TABUNG_KETERANGAN' => $this->input->post("keterangan"),
            'JURNAL_TABUNG_FILE' => "empty",
            'JURNAL_TABUNG_REF'  => "PERALIHAN",

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );
        $this->db->insert('JURNAL_TABUNG', $data_keluar);

        $data_masuk = array(
            'JURNAL_TABUNG_ID' => $id_masuk,
            'MASTER_RELASI_ID' => "",
            'MASTER_SUPPLIER_ID' => "",
            'MASTER_BARANG_ID' => $this->input->post("ke"),
            'JURNAL_TABUNG_TANGGAL' => $this->input->post("tanggal"),
            'JURNAL_TABUNG_KIRIM' => "",
            'JURNAL_TABUNG_KEMBALI' => $this->input->post("jumlah"),
            'JURNAL_TABUNG_STATUS' => $this->input->post("kepemilikan"),
            'JURNAL_TABUNG_KETERANGAN' => $this->input->post("keterangan"),
            'JURNAL_TABUNG_FILE' => "empty",
            'JURNAL_TABUNG_REF'  => "PERALIHAN",

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );
        $this->db->insert('JURNAL_TABUNG', $data_masuk);

        if ($this->input->post('isi') == "on") {
            $isi = "1";
        } else {
            $isi = "0";
        }

        $data_panggung_keluar = array(
            'PANGGUNG_ID' => create_id(),
            'MASTER_RELASI_ID' => "",
            'MASTER_SUPPLIER_ID' => "",
            'MASTER_BARANG_ID' => $this->input->post("dari"),
            'PANGGUNG_TANGGAL' => $this->input->post("tanggal"),
            'PANGGUNG_STATUS' => "out",
            'PANGGUNG_STATUS_ISI' => $isi,
            'PANGGUNG_JUMLAH' => $this->input->post("jumlah"),
            'PANGGUNG_STATUS_KEPEMILIKAN' => $this->input->post("kepemilikan"),
            'PANGGUNG_KETERANGAN' => $this->input->post("keterangan"),
            'PANGGUNG_REF'  =>  $id_keluar,

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );
        $this->db->insert('PANGGUNG', $data_panggung_keluar);

        $data_panggung_masuk = array(
            'PANGGUNG_ID' => create_id(),
            'MASTER_RELASI_ID' => "",
            'MASTER_SUPPLIER_ID' => "",
            'MASTER_BARANG_ID' => $this->input->post("ke"),
            'PANGGUNG_TANGGAL' => $this->input->post("tanggal"),
            'PANGGUNG_STATUS' => "in",
            'PANGGUNG_STATUS_ISI' => $isi,
            'PANGGUNG_JUMLAH' => $this->input->post("jumlah"),
            'PANGGUNG_STATUS_KEPEMILIKAN' => $this->input->post("kepemilikan"),
            'PANGGUNG_KETERANGAN' => $this->input->post("keterangan"),
            'PANGGUNG_REF'  => $id_masuk,

            'ENTRI_WAKTU' => date("Y-m-d G:i:s"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );
        $this->db->insert('PANGGUNG', $data_panggung_masuk);
        return true;
    }

    public function hapus($id)
    {
        $data_panggung = array(
            'DELETE_WAKTU' => date("Y-m-d G:i:s"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
            'PERUSAHAAN_KODE' => $this->session->userdata('PERUSAHAAN_KODE'),
        );

        $this->db->where('PANGGUNG_REF', $id);
        $this->db->update('PANGGUNG', $data_panggung);

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
