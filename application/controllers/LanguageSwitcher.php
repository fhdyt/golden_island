<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class LanguageSwitcher extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    function switchLang($language = "")
    {

        $language = ($language != "") ? $language : "bahasa";
        $this->session->set_userdata('USER_BAHASA', $language);

        redirect($_SERVER['HTTP_REFERER']);
    }
}
