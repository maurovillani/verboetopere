<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LanguageLoader
{


    function initialize()
    {
        $ci  = &get_instance();
        $ci->load->helper('language');
        $siteLang = $ci->session->userdata('site_lang');
        if ($siteLang) {
            $ci->lang->load('ion_auth', $siteLang);
            $ci->lang->load('auth', $siteLang);
            $ci->lang->load('information', $siteLang);
        } else {
            $ci->lang->load('ion_auth', 'italian');
            $ci->lang->load('auth', 'italian');
            $ci->lang->load('information', 'italian');
        }
    }
}
