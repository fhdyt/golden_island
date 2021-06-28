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
