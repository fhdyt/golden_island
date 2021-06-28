<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Telegram extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_Telegram');
	}

	public function index()
	{
		$TOKEN = "1696034827:AAGfDO9eyQspEKhnJIfm1Dwv2weP73VF1Kg";
		$apiURL = "https://api.telegram.org/bot$TOKEN";
		$update = json_decode(file_get_contents("php://input"), TRUE);
		$chatID = $update["message"]["chat"]["id"];
		$nama = $update["message"]["chat"]["first_name"];
		$message = $update["message"]["text"];
		$username = $update["message"]["chat"]["username"];

		if (strpos($message, "/start") === 0) {
			// $data['user'] = $this->M_Telegram->m_telegram_username($username, $chatID);
			// if ($data['user']) {
			// 	$text = urlencode("**Selamat Datang** \nTerimakasih telah menggunakan @mengundangbot\nUntuk info lebih lanjut silahkan kunjungi mengundang.co.id\nAtau hubungi melalui WA 082228899882\n\n**Perintah Dasar**\n/start - Memulai Bot\n/id - Mendapatkan ID Telegram anda\n/user [username] - Detail User");
			// } else {
			// 	$text = urlencode("Username anda belum terdaftar, silahkan buka mengundang.co.id/notifikasi dan masukkan Username Telegram anda.");
			// }
			$text = urlencode("**Selamat Datang di gmscloud.id**");
			file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=" . $text . "");
		} else if (strpos($message, "/id") === 0) {
			$text = urlencode("Username : " . $username . " \nNama : " . $nama . " \nID Telegram anda : " . $chatID . "");
			file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=" . $text . "");
		} else {
			$pesan = explode(" ", $message);
			if (strtoupper($pesan[0]) == "PENJUALAN") {
				$penjualan = $this->M_Telegram->penjualan(strtoupper($pesan[1]));
				$text = urlencode("**Laporan Penjualan Hari ini**\n\nLunas : " . number_format($penjualan['terbayar']) . "\nPiutang : " . number_format($penjualan['piutang']) . "");
				file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=" . $text . "");
			}
			if (strtoupper($pesan[0]) == "PENJUALAN-TABUNG") {
				$penjualan = $this->M_Telegram->penjualan_tabung(strtoupper($pesan[1]));
				$tabung = "";
				foreach ($penjualan as $row) {
					$tabung .= $row->MASTER_BARANG_NAMA . " : " . number_format($row->TOTAL) . "\n";
				}
				$text = urlencode("**Penjualan Tabung Hari Ini**\n\n" . $tabung . "");
				file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=" . $text . "");
			}
			if (strtoupper($pesan[0]) == "BUKUBESAR") {
				$buku_besar = $this->M_Telegram->buku_besar(strtoupper($pesan[1]));
				$akun = "";
				foreach ($buku_besar as $row) {
					$akun .= "**" . $row->AKUN_NAMA . "**\nPengeluaran : Rp. " . number_format($row->KREDIT) . "\nPemasukan : Rp. " . number_format($row->DEBET) . "\nSaldo : Rp. " . number_format($row->SALDO) . "\n\n";
				}
				$text = urlencode("**Laporan Buku Besar Hari ini**\n\n" . $akun . "");
				file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=" . $text . "");
			}
			if (strtoupper($message) == "SURAT JALAN SAYA") {
				$sj = $this->M_Telegram->surat_jalan($chatID);
				$surat_jalan = "";
				$total = 0;
				$total_seluruh = 0;
				foreach ($sj as $row) {
					if (count($row->SUPPLIER) == 0) {
						$supplier = "-";
					} else {
						$supplier = $row->SUPPLIER[0]->MASTER_SUPPLIER_NAMA;
					}

					if (count($row->RELASI) == 0) {
						$relasi = "-";
					} else {
						$relasi = $row->RELASI[0]->MASTER_RELASI_NAMA;
					}
					$total_seluruh += $row->BARANG[0]->ISI + $row->BARANG[0]->KOSONG - $row->BARANG[0]->KLAIM;
					$total = $row->BARANG[0]->ISI + $row->BARANG[0]->KOSONG - $row->BARANG[0]->KLAIM;
					$surat_jalan .= "No. : " . $row->SURAT_JALAN_NOMOR . "\nRelasi : " . $relasi . "\nSupplier : " . $supplier . "\nTanggal : " . tanggal($row->SURAT_JALAN_TANGGAL) . "\nJumlah : " . $total . "\n";
				}
				$text = urlencode("**Surat Jalan Bulain Ini**\n\n" . $surat_jalan . "\nTotal Bulan ini : " . $total . "");
				file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=" . $text . "");
			}
		}
	}

	public function surat_jalan()
	{
		$chatID = "744164478";
		$sj = $this->M_Telegram->surat_jalan($chatID);
		$surat_jalan = "";
		$total = 0;
		$total_seluruh = 0;
		foreach ($sj as $row) {
			if (count($row->SUPPLIER) == 0) {
				$supplier = "-";
			} else {
				$supplier = $row->SUPPLIER[0]->MASTER_SUPPLIER_NAMA;
			}

			if (count($row->RELASI) == 0) {
				$relasi = "-";
			} else {
				$relasi = $row->RELASI[0]->MASTER_RELASI_NAMA;
			}
			$total_seluruh += $row->BARANG[0]->ISI + $row->BARANG[0]->KOSONG - $row->BARANG[0]->KLAIM;
			$total = $row->BARANG[0]->ISI + $row->BARANG[0]->KOSONG - $row->BARANG[0]->KLAIM;
			$surat_jalan .= "No. : " . $row->SURAT_JALAN_NOMOR . "\nRelasi : " . $relasi . "\nSupplier : " . $supplier . "\nTanggal : " . tanggal($row->SURAT_JALAN_TANGGAL) . "\nJumlah : " . $total . "\n";
		}
		$text = "**Surat Jalan Bulain Ini**\n\n" . $surat_jalan . "\nTotal Bulan ini : " . $total . "";
		echo $text;
	}
}
