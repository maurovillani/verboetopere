<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class LanguageSwitcher extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    function switchLang($language = "")
    {
        $language = ($language != "") ? $language : "italian";
        $this->session->set_userdata('site_lang', $language);
        redirect($this->session->userdata('referred_from'));
    }
}
