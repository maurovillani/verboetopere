<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Prova extends MY_Controller {

    public function forgot_password() {
        $this->data['title'] = $this->lang->line('forgot_password_heading');

// setting validation rules by checking whether identity is username or email
        if ($this->config->item('identity', 'ion_auth') != 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
        } else {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
        }


        if ($this->form_validation->run() === FALSE) {
            $this->data['type'] = $this->config->item('identity', 'ion_auth');
// setup the input
            $this->data['identity'] = [
                'name' => 'identity',
                'id' => 'identity',
            ];

            if ($this->config->item('identity', 'ion_auth') != 'email') {
                $this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
            } else {
                $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
            }

// set any errors and display the form
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->renderView('auth' . DIRECTORY_SEPARATOR . 'forgot_password', 'auth\login');
        } else {
            $identity_column = $this->config->item('identity', 'ion_auth');
            $identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

            if (empty($identity)) {

                if ($this->config->item('identity', 'ion_auth') != 'email') {
                    $this->ion_auth->set_error('forgot_password_identity_not_found');
                } else {
                    $this->ion_auth->set_error('forgot_password_email_not_found');
                }

                $this->session->set_flashdata('message', $this->ion_auth->errors());
                //exit($this->ion_auth->errors());
                //exit($this->ion_auth->errors($this->session->userdata('message')));
                $this->data['message'] = $this->session->userdata('message');
                redirect("forgot_password", 'refresh');
            }

            // run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

            if ($forgotten) {

                $data = array(
                    'identity' => $forgotten['identity'],
                    'forgotten_password_code' => $forgotten['forgotten_password_code'],
                );

                $attribute['from']['from'] = 'verboetopere@alfonsiana.org';
                $attribute['from']['name'] = 'Accademia Alfonsiana';
                $attribute['to'] = $identity->username;
                $attribute['subject'] = 'forgot_password';
                $attribute['message'] = $this->load->view('auth/email/forgot_password.tpl.php', $data, TRUE);
                if ($this->send_mail($attribute)) {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    //exit('sent mail');
                    redirect("login", 'refresh'); //we should display a confirmation page here instead of the login page
                } else {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    exit($this->ion_auth->errors());
                    redirect("forgot_password", 'refresh');
                }
            }
        }
    }
}