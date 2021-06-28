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
			$text = urlencode("**GMSCLOUD.ID");
			file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=" . $text . "");
		} else if (strpos($message, "/user") === 0) {
		} else if (strpos($message, "/id") === 0) {
			$text = urlencode("Username : " . $username . " \nNama : " . $nama . " \nID Telegram anda : " . $chatID . "");
			file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=" . $text . "");
		}
	}

	public function check_expired()
	{
		$hasil = $this->M_Telegram->m_check_expired();
		$admin = $this->M_Telegram->m_admin();
		$pesan = urlencode("Web Undangaan yang expired\n=====================\n\n=====================\n");
		foreach ($hasil as $row) {
			if ($row->USER_TANGGAL_NONAKTIF < date("Y-m-d")) {
				$pesan .= urlencode("" . $row->USER_LINK . "\n=====================\n");
			}
		}

		foreach ($admin as $data) {
			$API = "https://api.telegram.org/bot1514363312:AAGok7yRfZ668Z7469JURkPkA5xhAvV5tlA/sendmessage?chat_id=" . $data->ADMIN_TELEGRAM . "&text=" . $pesan . "";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_URL, $API);
			$result = curl_exec($ch);
			curl_close($ch);
		}
	}
}
