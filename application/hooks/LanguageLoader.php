<?php
class LanguageLoader
{
    function initialize()
    {
        $ci = &get_instance();
        $ci->load->helper('language');
        $siteLang = $ci->session->userdata('USER_BAHASA');
        if ($siteLang) {
            $ci->lang->load('message', $siteLang);
        } else {
            $ci->lang->load('message', 'bahasa');
        }
    }
}
