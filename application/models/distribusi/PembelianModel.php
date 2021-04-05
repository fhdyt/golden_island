<?php
class PembelianModel extends CI_Model
{

    public function list()
    {
        $hasil = $this->db->query('SELECT * FROM PEMBELIAN WHERE RECORD_STATUS="AKTIF" ORDER BY PEMBELIAN_INDEX DESC ')->result();
        foreach ($hasil as $row) {
            $row->TANGGAL = tanggal($row->PEMBELIAN_TANGGAL);
        }
        return $hasil;
    }

    public function add()
    {
        $data_edit_aktif = array(
            'EDIT_WAKTU' => date("Y-m-d h:i:sa"),
            'EDIT_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "EDIT",
        );

        $this->db->where('PEMBELIAN_ID', $this->input->post('id'));
        $this->db->where('RECORD_STATUS', 'AKTIF');
        $edit_aktif = $this->db->update('PEMBELIAN', $data_edit_aktif);

        $total = $this->input->post('quantity') * $this->input->post('harga');
        $sisa_bayar = $total - $this->input->post('total_bayar');
        $data = array(
            'PEMBELIAN_ID' => $this->input->post('id'),
            'PEMBELIAN_JENIS' => $this->input->post('jenis_pembelian'),
            'PEMBELIAN_NOMOR_SURAT' => $this->input->post('nomor_surat'),
            'PEMBELIAN_TANGGAL' => $this->input->post('tanggal'),
            'PEMBELIAN_KETERANGAN' => $this->input->post('keterangan'),
            'MASTER_SUPPLIER_ID' => $this->input->post('supplier'),
            'PEMBELIAN_QUANTITY' => $this->input->post('quantity'),
            'PEMBELIAN_HARGA' => $this->input->post('harga'),
            'PEMBELIAN_TOTAL' => $total,
            'PEMBELIAN_BAYAR' => $this->input->post('bayar'),
            'PEMBELIAN_SISA_BAYAR' => $sisa_bayar,

            'ENTRI_WAKTU' => date("Y-m-d h:i:sa"),
            'ENTRI_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "AKTIF",
        );

        $result = $this->db->insert('PEMBELIAN', $data);
        return $result;
    }

    public function hapus($id)
    {
        $data = array(
            'DELETE_WAKTU' => date("Y-m-d h:i:sa"),
            'DELETE_USER' => $this->session->userdata('USER_ID'),
            'RECORD_STATUS' => "DELETE",
        );

        $this->db->where('MASTER_DRIVER_ID', $id);
        $result = $this->db->update('MASTER_DRIVER', $data);
        return $result;
    }

    public function detail($id)
    {
        $hasil = $this->db->query('SELECT * FROM PEMBELIAN WHERE PEMBELIAN_ID="' . $id . '" AND RECORD_STATUS="AKTIF" LIMIT 1')->result();
        return $hasil;
    }
}
