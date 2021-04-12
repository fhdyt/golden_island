<?php
class Kas_kecilModel extends CI_Model
{

    public function list()
    {
        $bulan = $_GET['bulan'];
        $tahun = $_GET['tahun'];
        $hasil['saldo_awal'] = $this->db->query('SELECT SUM(KAS_KECIL_RUPIAH) AS SALDO_AWAL FROM KAS_KECIL WHERE RECORD_STATUS="AKTIF" AND KAS_KECIL_TANGGAL < "' . $tahun . '-' . $bulan . '-01" ')->result();
        $hasil['kas_kecil'] = $this->db->query('SELECT * FROM KAS_KECIL WHERE RECORD_STATUS="AKTIF" ORDER BY KAS_KECIL_TANGGAL ASC ')->result();
        return $hasil;
    }

    public function add()
    {
        if ($this->input->post('id') == "") {
            $data = array(
                'KAS_KECIL_ID' => create_id(),
                'KAS_KECIL_TANGGAL' => $this->input->post('tanggal'),
                'KAS_KECIL_JENIS' => $this->input->post('jenis'),
                'KAS_KECIL_KETERANGAN' => $this->input->post('keterangan'),
                'KAS_KECIL_RUPIAH' => str_replace(".", "", $this->input->post('rupiah')),

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
            );

            $result = $this->db->insert('KAS_KECIL', $data);
            return $result;
        } else {
            $data_edit = array(
                'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
                'EDIT_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "EDIT",
            );

            $this->db->where('KAS_KECIL_ID', $this->input->post('id'));
            $edit = $this->db->update('KAS_KECIL', $data_edit);

            $data = array(
                'KAS_KECIL_ID' => $this->input->post('id'),
                'KAS_KECIL_TANGGAL' => $this->input->post('tanggal'),
                'KAS_KECIL_JENIS' => $this->input->post('jenis'),
                'KAS_KECIL_KETERANGAN' => $this->input->post('keterangan'),
                'KAS_KECIL_RUPIAH' => $this->input->post('rupiah'),

                'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
                'ENTRI_USER' => $this->session->userdata('USER_ID'),
                'RECORD_STATUS' => "AKTIF",
            );

            $result = $this->db->insert('KAS_KECIL', $data);
            return $result;
        }
    }

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
        );

        $this->db->where('KAS_KECIL_ID', $id);
        $result = $this->db->update('KAS_KECIL', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM KAS_KECIL WHERE KAS_KECIL_ID="' . $id . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }
}
