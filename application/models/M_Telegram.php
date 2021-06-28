<?php
class M_Telegram extends CI_Model
{


	public function m_telegram_detail_user($username)
	{
		$hasil = $this->db->query('SELECT * FROM USER WHERE USER_USERNAME="' . $username . '"')->result();
		return $hasil;
	}
	public function m_telegram_username($username, $chatID)
	{
		$hasil = $this->db->query('SELECT * FROM USER WHERE USER_TELEGRAM_USERNAME="' . $username . '"')->result();
		if (empty($hasil)) {
			return false;
		} else {
			$data = array(
				'USER_TELEGRAM_ID' => $chatID,
			);

			$this->db->where('USER_TELEGRAM_USERNAME', $hasil[0]->USER_TELEGRAM_USERNAME);
			$result = $this->db->update('USER', $data);
			return true;
		}
	}

	public function penjualan($perusahaan)
	{
		if (empty($this->input->post("relasi"))) {
			$filter_relasi = "";
		} else {
			$filter_relasi = 'AND MASTER_RELASI_ID="' . $this->input->post("relasi") . '"';
		}

		$tanggal_dari = date("Y-m-d");
		$tanggal_sampai = date("Y-m-d");

		$filter_tanggal = 'SURAT_JALAN_TANGGAL BETWEEN "' . $tanggal_dari . '" AND "' . $tanggal_sampai . '"';

		$hasil = $this->db->query('SELECT * 
                            FROM 
                            SURAT_JALAN 
                            WHERE 
                            ' . $filter_tanggal . '
                            ' . $filter_relasi . '
                            AND SURAT_JALAN_JENIS = "penjualan"
                            AND RECORD_STATUS="AKTIF" 
                            AND PERUSAHAAN_KODE="' . $perusahaan . '" 
                            ORDER BY SURAT_JALAN_NOMOR ')->result();
		foreach ($hasil as $row) {
			$row->RELASI = $this->db->query('SELECT MASTER_RELASI_NAMA FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $perusahaan . '"')->result();

			$total_perbarang = 0;
			if ($row->SURAT_JALAN_STATUS == "open") {

				$barang = $this->db->query('SELECT * FROM
                                                        SURAT_JALAN_BARANG AS SJ 
                                                        LEFT JOIN
                                                        MASTER_BARANG AS B
                                                        ON SJ.MASTER_BARANG_ID = B.MASTER_BARANG_ID
                                                        WHERE SJ.SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '"
                                                        AND SJ.RECORD_STATUS="AKTIF" 
                                                        AND SJ.PERUSAHAAN_KODE="' . $perusahaan . '" 
                                                        AND B.RECORD_STATUS="AKTIF" 
                                                        AND B.PERUSAHAAN_KODE="' . $perusahaan . '"')->result();
				foreach ($barang as $row_barang) {
					$row_barang->NAMA_BARANG = $this->db->query('SELECT MASTER_BARANG_NAMA FROM MASTER_BARANG WHERE MASTER_BARANG_ID="' . $row_barang->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $perusahaan . '"')->result();
					$row_barang->HARGA_BARANG = $this->db->query('SELECT * FROM MASTER_HARGA WHERE MASTER_BARANG_ID="' . $row_barang->MASTER_BARANG_ID . '" AND MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $perusahaan . '"')->result();
					if (count($row_barang->HARGA_BARANG) == 0) {
						$total_perbarang = 0;
					} else {
						$total_perbarang += $row_barang->HARGA_BARANG[0]->MASTER_HARGA_HARGA * ($row_barang->SURAT_JALAN_BARANG_QUANTITY - $row_barang->SURAT_JALAN_BARANG_QUANTITY_KLAIM);
					}
				}

				$terbayar = array();
			} else if ($row->SURAT_JALAN_STATUS == "close") {
				$faktur = $this->db->query('SELECT 
                                            FSJ.FAKTUR_ID 
                                            FROM 
                                            FAKTUR AS F
                                            LEFT JOIN
                                            FAKTUR_SURAT_JALAN AS FSJ
                                            ON F.FAKTUR_ID=FSJ.FAKTUR_ID
                                            WHERE FSJ.SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" 
                                            AND F.RECORD_STATUS="AKTIF" 
                                            AND F.PERUSAHAAN_KODE="' . $perusahaan . '" 
                                            AND FSJ.RECORD_STATUS="AKTIF" 
                                            AND FSJ.PERUSAHAAN_KODE="' . $perusahaan . '" LIMIT 1')->result();

				$barang = $this->db->query('SELECT * FROM FAKTUR_BARANG WHERE FAKTUR_ID="' . $faktur[0]->FAKTUR_ID . '" AND SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" AND RECORD_STATUS="AKTIF" 
                                            AND PERUSAHAAN_KODE="' . $perusahaan . '" ')->result();
				foreach ($barang as $row_barang) {
					$row_barang->NAMA_BARANG = $this->db->query('SELECT MASTER_BARANG_NAMA FROM MASTER_BARANG WHERE MASTER_BARANG_ID="' . $row_barang->MASTER_BARANG_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $perusahaan . '"')->result();
					$row_barang->HARGA_BARANG = $this->db->query('SELECT * FROM FAKTUR_BARANG WHERE MASTER_BARANG_ID="' . $row_barang->MASTER_BARANG_ID . '" AND SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $perusahaan . '"')->result();
					$total_perbarang += $row_barang->HARGA_BARANG[0]->FAKTUR_BARANG_QUANTITY * $row_barang->HARGA_BARANG[0]->FAKTUR_BARANG_HARGA;
				}
				$terbayar = $this->db->query('SELECT * FROM FAKTUR_TRANSAKSI
                                                                    WHERE
                                                                    FAKTUR_ID="' . $faktur[0]->FAKTUR_ID . '"
                                                                    AND RECORD_STATUS="AKTIF" 
                                                                    AND PERUSAHAAN_KODE="' . $perusahaan . '" LIMIT 1')->result();
			}

			$row->BARANG = $barang;
			$row->TOTAL = $total_perbarang;
			$row->TERBAYAR = $terbayar;
			$row->TANGGAL = tanggal($row->SURAT_JALAN_TANGGAL);
		}

		$total_terbayar = 0;
		$total_piutang = 0;
		foreach ($hasil as $row) {
			if (count($row->TERBAYAR) == 0) {
				$terbayar = 0;
				$piutang = $row->TOTAL;;
			} else {
				$grandtotal = $row->TERBAYAR[0]->FAKTUR_TRANSAKSI_GRAND_TOTAL;
				$terbayar = $row->TERBAYAR[0]->PEMBELIAN_TRANSAKSI_BAYAR;
				$piutang = $row->TOTAL - $terbayar;
				if ($piutang < 0) {
					$piutang = 0;
				} else {
					$piutang = $piutang;
				}
			}
			$total_terbayar += $terbayar;
			$total_piutang += $piutang;
		}
		$total['terbayar'] = $total_terbayar;
		$total['piutang'] = $total_piutang;
		return $total;
	}

	public function m_check_expired()
	{
		$hasil = $this->db->query('SELECT * FROM USER ORDER BY USER_TANGGAL_NONAKTIF DESC ')->result();
		return $hasil;
	}
	public function m_admin()
	{
		$hasil = $this->db->query('SELECT * FROM ADMIN ')->result();
		return $hasil;
	}
}
