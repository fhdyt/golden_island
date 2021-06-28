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

		if (strpos($message, "start") === 0) {
			// $data['user'] = $this->M_Telegram->m_telegram_username($username, $chatID);
			// if ($data['user']) {
			// 	$text = urlencode("**Selamat Datang** \nTerimakasih telah menggunakan @mengundangbot\nUntuk info lebih lanjut silahkan kunjungi mengundang.co.id\nAtau hubungi melalui WA 082228899882\n\n**Perintah Dasar**\n/start - Memulai Bot\n/id - Mendapatkan ID Telegram anda\n/user [username] - Detail User");
			// } else {
			// 	$text = urlencode("Username anda belum terdaftar, silahkan buka mengundang.co.id/notifikasi dan masukkan Username Telegram anda.");
			// }
			$text = urlencode("**GMSCLOUD.ID");
			file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=" . $text . "");
		} else if (strpos($message, "/user") === 0) {
		} else if (strpos($message, "/id") === 0) {
			$text = urlencode("Username : " . $username . " \nNama : " . $nama . " \nID Telegram anda : " . $chatID . "");
			file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=" . $text . "");
		} else {
			$pesan = explode(" ", $message);
			if (strtoupper($pesan[0]) == "PENJUALAN") {
				$penjualan = $this->M_Telegram->penjualan(strtoupper($pesan[1]));
				$text = urlencode("*Laporan Penjualan Tanggal " . tanggal(date("Y-m-d")) . "*\n\nLunas :" . number_format($penjualan['terbayar']) . "\nPiutang : " . number_format($penjualan['piutang']) . "\n\n*Total : " . $penjualan['piutang'] + $penjualan['terbayar'] . "*");
				file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=" . $text . "");
			}
		}
	}
}
