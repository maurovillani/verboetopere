<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sendingemail
 *
 * @author Paolo Minervino <paolo.minervino@ecm2.it>
 */
class Sendemail extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('login', 'refresh');
        }

        $current_user = $this->ion_auth->user()->row();
        $this->data['first_name'] = $current_user->first_name;
        $this->data['last_name'] = $current_user->last_name;
        $this->data['email'] = $current_user->email;


        $this->sidebar = $this->buildSidebarMenuWthCurrentUriPermitted();
        $this->data['sidebar'] = $this->sidebar;
    }

    public function index()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('need', 'need', 'trim|required');
        $this->form_validation->set_rules('message', 'body', 'trim|required');

        if ($this->form_validation->run() === false) { } else {
            //exit('end validation');
            $attribute=[];
            
            $attribute['from']['from']=$this->data['email'];
            $attribute['from']['name']='Utente Portale';
            $attribute['from']['return_path']=NULL;

            $attribute['to']=['verboetopere@alfonsiana.org'];
            //$attribute['to']=['paolo.minervino@gmail.com'];
            $attribute['subject']=$this->input->post('need');
            $attribute['message']=$this->input->post('message');

            if ($this->send_mail($attribute)) {
                $this->session->set_flashdata('message', 'Congratulation Request Send Successfully.');
            } else {
                $this->session->set_flashdata('message', 'You have encountered an error');
            }
        }
        $this->data['message'] = $this->session->flashdata('message');
        $this->renderView('sendingemail' . DIRECTORY_SEPARATOR . 'contact_email_form','frontend');
    }
}
