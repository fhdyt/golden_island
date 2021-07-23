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

	public function penjualan_tabung($perusahaan)
	{
		$hasil = $this->db->query('SELECT * FROM MASTER_BARANG WHERE MASTER_BARANG_JENIS="gas" AND RECORD_STATUS="AKTIF"  AND PERUSAHAAN_KODE="' . $perusahaan . '" ORDER BY MASTER_BARANG_PRIORITAS DESC')->result();
		foreach ($hasil as $row) {
			if (empty($this->input->post("relasi"))) {
				$filter_relasi = "";
			} else {
				$filter_relasi = 'AND SJ.MASTER_RELASI_ID="' . $this->input->post("relasi") . '"';
			}

			$tanggal_dari = date("Y-m-d");
			$tanggal_sampai = date("Y-m-d");

			$filter_tanggal = 'SJ.SURAT_JALAN_TANGGAL BETWEEN "' . $tanggal_dari . '" AND "' . $tanggal_sampai . '"';

			$barang = $this->db->query('SELECT SUM(SJB.SURAT_JALAN_BARANG_QUANTITY) AS QTY, SUM(SJB.SURAT_JALAN_BARANG_QUANTITY_KLAIM) AS QTY_KLAIM FROM 
                                        SURAT_JALAN_BARANG SJB LEFT JOIN SURAT_JALAN AS SJ
                                        ON SJB.SURAT_JALAN_ID=SJ.SURAT_JALAN_ID
                                        WHERE 
                                        SJ.SURAT_JALAN_JENIS="penjualan"
                                        AND SJB.MASTER_BARANG_ID ="' . $row->MASTER_BARANG_ID . '"
                                        AND ' . $filter_tanggal . '
                                        ' . $filter_relasi . '
                                        AND SJB.RECORD_STATUS="AKTIF" 
                                        AND SJB.PERUSAHAAN_KODE="' . $perusahaan . '" 
                                        AND SJ.RECORD_STATUS="AKTIF" 
                                        AND SJ.PERUSAHAAN_KODE="' . $perusahaan . '" LIMIT 1')->result();
			$row->QTY = $barang;
			$qty = $barang[0]->QTY;
			$qty_klaim = $barang[0]->QTY_KLAIM;
			$row->TOTAL = $qty - $qty_klaim;
		}
		return $hasil;
	}
	public function buku_besar($perusahaan)
	{

		$hasil = $this->db->query('SELECT * FROM AKUN WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $perusahaan . '"')->result();
		foreach ($hasil as $row) {
			$tanggal_dari = date("Y-m-d");
			$tanggal_sampai = date("Y-m-d");

			$filter_tanggal = 'AND BUKU_BESAR_TANGGAL BETWEEN "' . $tanggal_dari . '" AND "' . $tanggal_sampai . '"';

			$saldo_awal = $this->db->query('SELECT 
            SUM(BUKU_BESAR_KREDIT) AS KREDIT,
            SUM(BUKU_BESAR_DEBET) AS DEBET 
            FROM 
            BUKU_BESAR WHERE 
            AKUN_ID="' . $row->AKUN_ID . '" 
            AND RECORD_STATUS="AKTIF" 
            AND PERUSAHAAN_KODE="' . $perusahaan . '" 
            AND BUKU_BESAR_TANGGAL < "' . $tanggal_dari . '"
            ORDER BY BUKU_BESAR_TANGGAL ASC')->result();

			$buku_besar = $this->db->query('SELECT SUM(BUKU_BESAR_KREDIT) AS KREDIT, SUM(BUKU_BESAR_DEBET) AS DEBET FROM 
        BUKU_BESAR WHERE 
        AKUN_ID="' . $row->AKUN_ID . '" 
        AND RECORD_STATUS="AKTIF" 
        AND PERUSAHAAN_KODE="' . $perusahaan . '" 
        ' . $filter_tanggal . '')->result();
			$row->KREDIT = $buku_besar[0]->KREDIT;
			$row->DEBET = $buku_besar[0]->DEBET;
			$row->SALDO_AWAL = $saldo_awal[0]->DEBET - $saldo_awal[0]->KREDIT;
			$row->TOTAL = $buku_besar[0]->DEBET - $buku_besar[0]->KREDIT;

			$row->SALDO = $row->SALDO_AWAL + $row->TOTAL;
		}
		return $hasil;;
	}
	public function rincian_buku_besar($perusahaan)
	{

		$hasil = $this->db->query('SELECT * FROM AKUN WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $perusahaan . '"')->result();
		foreach ($hasil as $row) {
			$tanggal_dari = date("Y-m-d");
			$tanggal_sampai = date("Y-m-d");

			$filter_tanggal = 'AND BUKU_BESAR_TANGGAL BETWEEN "' . $tanggal_dari . '" AND "' . $tanggal_sampai . '"';

			$saldo_awal = $this->db->query('SELECT 
            SUM(BUKU_BESAR_KREDIT) AS KREDIT,
            SUM(BUKU_BESAR_DEBET) AS DEBET 
            FROM 
            BUKU_BESAR WHERE 
            AKUN_ID="' . $row->AKUN_ID . '" 
            AND RECORD_STATUS="AKTIF" 
            AND PERUSAHAAN_KODE="' . $perusahaan . '" 
            AND BUKU_BESAR_TANGGAL < "' . $tanggal_dari . '"
            ORDER BY BUKU_BESAR_TANGGAL ASC')->result();

			$buku_besar = $this->db->query('SELECT SUM(BUKU_BESAR_KREDIT) AS KREDIT, SUM(BUKU_BESAR_DEBET) AS DEBET FROM 
        BUKU_BESAR WHERE 
        AKUN_ID="' . $row->AKUN_ID . '" 
        AND RECORD_STATUS="AKTIF" 
        AND PERUSAHAAN_KODE="' . $perusahaan . '" 
        ' . $filter_tanggal . '')->result();
			$row->KREDIT = $buku_besar[0]->KREDIT;
			$row->DEBET = $buku_besar[0]->DEBET;
			$row->SALDO_AWAL = $saldo_awal[0]->DEBET - $saldo_awal[0]->KREDIT;
			$row->TOTAL = $buku_besar[0]->DEBET - $buku_besar[0]->KREDIT;

			$row->SALDO = $row->SALDO_AWAL + $row->TOTAL;
		}
		return $hasil;;
	}

	public function surat_jalan_driver($id_telegram)
	{
		$bulan = date("m");
		$tahun = date("Y");
		$id = $this->db->query('SELECT * FROM MASTER_KARYAWAN WHERE MASTER_KARYAWAN_TELEGRAM_ID="' . $id_telegram . '" AND RECORD_STATUS="AKTIF"')->result();
		$hasil = $this->db->query('SELECT * 
                                FROM SURAT_JALAN WHERE 
                                MONTH(SURAT_JALAN_TANGGAL) = ' . $bulan . ' 
                                        AND YEAR(SURAT_JALAN_TANGGAL) = ' . $tahun . '
                                        AND DRIVER_ID="' . $id[0]->MASTER_KARYAWAN_ID . '" 
                                AND RECORD_STATUS="AKTIF" 
                                AND PERUSAHAAN_KODE="' . $id[0]->PERUSAHAAN_KODE . '" 
                                ORDER BY SURAT_JALAN_NOMOR ASC ')->result();
		foreach ($hasil as $row) {
			$relasi = $this->db->query('SELECT * FROM MASTER_RELASI WHERE MASTER_RELASI_ID="' . $row->MASTER_RELASI_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $id[0]->PERUSAHAAN_KODE . '"')->result();
			$supplier = $this->db->query('SELECT * FROM MASTER_SUPPLIER WHERE MASTER_SUPPLIER_ID="' . $row->MASTER_SUPPLIER_ID . '" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $id[0]->PERUSAHAAN_KODE . '"')->result();
			$barang = $this->db->query('SELECT
                                        SUM(SURAT_JALAN_BARANG_QUANTITY) AS ISI,
                                        SUM(SURAT_JALAN_BARANG_QUANTITY_KOSONG) AS KOSONG,
                                        SUM(SURAT_JALAN_BARANG_QUANTITY_KLAIM) AS KLAIM
                                        FROM 
                                        SURAT_JALAN_BARANG 
                                        WHERE SURAT_JALAN_ID="' . $row->SURAT_JALAN_ID . '" 
                                        AND RECORD_STATUS="AKTIF" 
                                        AND PERUSAHAAN_KODE="' . $id[0]->PERUSAHAAN_KODE . '"')->result();
			$row->TANGGAL = tanggal($row->SURAT_JALAN_TANGGAL);
			$row->JAM = jam($row->ENTRI_WAKTU);
			$row->RELASI = $relasi;
			$row->SUPPLIER = $supplier;
			$row->BARANG = $barang;
			$row->NAMA = $id[0]->MASTER_KARYAWAN_NAMA;
		}
		return $hasil;
	}

	public function rincian($jenis, $perusahaan)
	{
		$id = create_id();
		$data = array(
			'LAPORAN_TELEGRAM_ID' => $id,
			'LAPORAN_TELEGRAM_JENIS' => $jenis,
			'LAPORAN_TELEGRAM_TANGGAL' => date("Y-m-d G:i:s"),
			'LAPORAN_TELEGRAM_EXPIRED' => date("Y-m-d G:i:s"),
			'PERUSAHAAN_KODE' => $perusahaan,
			'RECORD_STATUS' => "AKTIF",
		);

		$this->db->insert('LAPORAN_TELEGRAM', $data);
		return $data;
	}

	public function cek_akses($id, $perusahaan)
	{
		$user = $this->db->query('SELECT * FROM USER WHERE USER_TELEGRAM="' . $id . '" AND RECORD_STATUS="AKTIF" ')->result();
		$perusahaan = $this->db->query('SELECT * FROM USER_AKSES_PERUSAHAAN WHERE USER_ID="' . $user[0]->USER_ID . '" AND PERUSAHAAN_KODE="' . $perusahaan . '" AND RECORD_STATUS="AKTIF" ');
		if ($perusahaan->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
}
