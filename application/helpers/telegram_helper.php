<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('tanggal')) {
    function send_telegram($pesan)
    {
        $API = "https://api.telegram.org/bot1696034827:AAGfDO9eyQspEKhnJIfm1Dwv2weP73VF1Kg/sendmessage?chat_id=744164478&text=" . $pesan . "";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_URL, $API);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
