<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Auth extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->ion_auth->logged_in()) {
            $this->load->model('service_model', 'serviceDB');
            $this->sidebar = $this->serviceDB->buildSidebarMenu();
            $this->data['sidebar'] = $this->buildSidebar($this->sidebar);
        }

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->load->helpers('url');
    }

    /**
     * Redirect if needed, otherwise display the user list
     */
    public function index() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('login', 'refresh');
        } else if (!$this->ion_auth->is_admin()) { // remove this elseif if you want to enable this for non-admins
            // redirect them to the home page because they must be an administrator to view this
            show_error('You must be an administrator to view this page.');
        } else {
            $this->data['title'] = $this->lang->line('index_heading');


            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            //list the users
            $this->data['users'] = $this->ion_auth->users()->result();

            //USAGE NOTE - you can do more complicated queries like this
            //$this->data['users'] = $this->ion_auth->where('field', 'value')->users()->result();
            foreach ($this->data['users'] as $k => $user) {
                $this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
            }

            //////////////////////////////////////////////////////////////////////////////////paolo minervino<i class="fab fa-buffer"></i>
            $this->add_stylesheet('vendor/datatables/dataTables.bootstrap4.min.css');
            $this->add_script('vendor/datatables/jquery.dataTables.min.js');
            $this->add_script('vendor/datatables/dataTables.bootstrap4.min.js');
            $script = '
            $(document).ready(function() {
                $(\'#users\').DataTable();
            });'
            ;
            $this->add_scriptSource($script);
            //////////////////////////////////////////////////////////////////////////////////paolo minervino

            $this->renderView('auth' . DIRECTORY_SEPARATOR . 'index');
        }
    }

    /**
     * Log the user in
     */
    public function login() {
        $this->data['body_class'] = 'bg-gradient-login';
        $this->data['title'] = $this->lang->line('login_heading');
        
        if(!isset($_SESSION['lingua'])){
            $_SESSION['lingua']='IT';
        }
        $this->data['lingua'] = $_SESSION['lingua'];        

// validate form input
        $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

        if ($this->form_validation->run() === TRUE) {
// check to see if the user is logging in
// check for "remember me"
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
//if the login is successful
//redirect them back to the home page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('', 'refresh');
            } else {
// if the login was un-successful
// redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        } else {
// the user is not logging in so display the login page
// set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['identity'] = [
                'name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
            ];

            $this->data['password'] = [
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
            ];

//$this->renderView('auth' . DIRECTORY_SEPARATOR . 'login''test');

            $this->renderView('auth/login', 'auth/login');
        }
    }
    /**
     * Log the user out
     */
    public function logout() {
        $this->data['title'] = "Logout";

// log the user out
        $this->ion_auth->logout();


// redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('login', 'refresh');
    }

    /**
     * Change password
     */
    public function change_password() {
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

        if (!$this->ion_auth->logged_in()) {
            redirect('login', 'refresh');
        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() === FALSE) {
            // display the form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = [
                'name' => 'old',
                'id' => 'old',
                'type' => 'password',
            ];
            $this->data['new_password'] = [
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            ];
            $this->data['new_password_confirm'] = [
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            ];
            $this->data['user_id'] = [
                'name' => 'user_id',
                'id' => 'user_id',
                'type' => 'hidden',
                'value' => $user->id,
            ];

// render
            $this->renderView('auth' . DIRECTORY_SEPARATOR . 'change_password', 'frontend');
        } else {
            $identity = $this->session->userdata('identity');

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change) {
//if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $this->logout();
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('change_password', 'refresh');
            }
        }
    }

    /**
     * Forgot password
     */
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

    /**
     * Reset password - final step for forgotten password
     *
     * @param string|null $code The reset code
     */
    public function reset_password($code = NULL) {
        if (!$code) {
            show_404();
        }

        $this->data['title'] = $this->lang->line('reset_password_heading');

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {
// if the code is valid then display the password reset form

            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if ($this->form_validation->run() === FALSE) {
// display the form
// set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = [
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                ];
                $this->data['new_password_confirm'] = [
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                ];
                $this->data['user_id'] = [
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                ];
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;

// render
                $this->renderView('auth' . DIRECTORY_SEPARATOR . 'reset_password');
            } else {
                $identity = $user->{$this->config->item('identity', 'ion_auth')};

// do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

// something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($identity);

                    show_error($this->lang->line('error_csrf'));
                } else {
// finally change the password
                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change) {
// if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect("login", 'refresh');
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect('reset_password/' . $code, 'refresh');
                    }
                }
            }
        } else {
// if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("forgot_password", 'refresh');
        }
    }
    
    
    
    /**
     * Activate the user
     *
     * @param int         $id   The user ID
     * @param string|bool $code The activation code
     */
    public function activate($id, $code = FALSE) {
        //exit($code);
        $activation = FALSE;


        if ($code !== FALSE) {
            //$code=rawurldecode($code);
            $activation = $this->ion_auth->activate($id, $code);
        } else if ($this->ion_auth->is_admin()) {
            $activation = $this->ion_auth->activate($id);
        }

        if ($activation) {
            // redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("auth", 'refresh');
        } else {
            // redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("login", 'refresh');
        }
    }

    /**
     * Deactivate the user
     *
     * @param int|string|null $id The user ID
     */
    public function deactivate($id = NULL) {
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
// redirect them to the home page because they must be an administrator to view this
            show_error('You must be an administrator to view this page.');
        }

        $id = (int) $id;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
        $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

        if ($this->form_validation->run() === FALSE) {
// insert csrf check
            $this->data['csrf'] = $this->_get_csrf_nonce();
            $this->data['user'] = $this->ion_auth->user($id)->row();

            $this->renderView('auth' . DIRECTORY_SEPARATOR . 'deactivate_user');
        } else {
// do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes') {
// do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                    show_error($this->lang->line('error_csrf'));
                }

// do we have the right userlevel?
                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
                    $this->ion_auth->deactivate($id);
                }
            }

// redirect them back to the auth page
            redirect('auth', 'refresh');
        }
    }

    /**
     * Create a new user
     */
    public function create_user() {
        $this->data['title'] = $this->lang->line('create_user_heading');
        /*
          if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
          redirect('auth', 'refresh');
          }
         */
        if ($this->input->post('email')!=""){
            $this->load->model('studente_model');
            $this->studente_model->EliminaUserNonAttivato($this->input->post('email'));               
        }
        
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim|required');
        if ($identity_column !== 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email');
        } else {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
//        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
//        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
//        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
//        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() === TRUE) {
            $email = strtolower($this->input->post('email'));
            $identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
            $password = 'Password';// $this->input->post('password');

            $additional_data = [
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => 'AA',//$this->input->post('company'),
                //'phone' => $this->input->post('phone'),
            ];
        }
        if ($this->form_validation->run() === TRUE) {

            $user_id = $this->ion_auth->register($identity, $password, $email, $additional_data);
            // check to see if we are creating the user
            // redirect them back to the admin page
            if ($user_id) {
                if ($this->ion_auth->logged_in() || $this->ion_auth->is_admin()) {
                    //generates the activation_code
//                    $check = $this->ion_auth->deactivate($user_id);
                $identity = $this->ion_auth->where($identity_column, $email)->users()->row();

                $forgotten = $this->genera_codice($identity);

                if ($forgotten) {
                    $str_query="SELECT * from users where email='".$identity->email."'"; 
                    $query=$this->db->query($str_query);
                    $user = $query->row_array(); 
                    $data = array(
                        'identity' => $email,
                        'forgotten_password_code' => $user['forgotten_password_selector'],
                    );

                    $attribute['from']['from'] = 'verboetopere@alfonsiana.org';
                    $attribute['from']['name'] = 'Accademia Alfonsiana';
                    $attribute['to'] = $identity->username;
                    $attribute['subject'] = 'Imposta Password';
                    $attribute['message'] = $this->load->view('auth/email/activate.tpl.php', $data, TRUE);
                    if ($this->send_mail($attribute)) {
                        $this->session->set_flashdata('message', 'Utente creato con successo<br/>l\'utente riceverà un\'email per l\'impostazione della password');
                        redirect("create_user", 'refresh');
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        exit($this->ion_auth->errors());
                        redirect("create_user", 'refresh');
                    }
                }
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth", 'refresh');
            }
        }
        } else {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['first_name'] = [
                'name' => 'first_name',
                'id' => 'first_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            ];
            $this->data['last_name'] = [
                'name' => 'last_name',
                'id' => 'last_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            ];
            $this->data['identity'] = [
                'name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
            ];
            $this->data['email'] = [
                'name' => 'email',
                'id' => 'email',
                'type' => 'text',
                'value' => $this->form_validation->set_value('email'),
            ];
            $this->data['company'] = [
                'name' => 'company',
                'id' => 'company',
                'type' => 'text',
                'value' => 'AA',//$this->form_validation->set_value('company'),
            ];
//            $this->data['phone'] = [
//                'name' => 'phone',
//                'id' => 'phone',
//                'type' => 'text',
//                'value' => $this->form_validation->set_value('phone'),
//            ];
            $this->data['password'] = [
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'value' => 'Password', //$this->form_validation->set_value('password'),
            ];
            $this->data['password_confirm'] = [
                'name' => 'password_confirm',
                'id' => 'password_confirm',
                'type' => 'password',
                'value' => 'Password', //$this->form_validation->set_value('password_confirm'),
            ];
            $this->renderView('auth' . DIRECTORY_SEPARATOR . 'create_user');
        }
    }
    public function imposta_lingua($redirect, $lingua='IT') {
        $_SESSION['lingua']=$lingua;
        //$this->create_user_preiscrizione();
//        redirect(site_url('Preiscrizione'));
        redirect(site_url($redirect));
    }
    /**
     * Create a new user preiscrizione
     */
    public function create_user_preiscrizione() {
        $this->data['title'] = $this->lang->line('create_user_heading');
        //if (!isset($lingua)) $lingua='IT';
        //if ($lingua=='') $lingua='IT';
        if(!isset($_SESSION['lingua'])){
            $_SESSION['lingua']='IT';
        }
        $lingua=$_SESSION['lingua'];
        $this->data['lingua']=$lingua;
        /*
          if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
          redirect('auth', 'refresh');
          }
         */
        if ($this->input->post('email')!=""){
            $this->load->model('studente_model');
            $this->studente_model->EliminaUserNonAttivato($this->input->post('email'));               
        }
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim|required');
//        if ($identity_column !== 'email') {
//            $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
//            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email');
//        } else {
            $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]|matches[email_confirm]');
//        }
        $this->form_validation->set_rules('email_confirm', $this->lang->line('create_user_validation_email_label'), 'required');
//        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        //$this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() === TRUE) {
            $email = strtolower($this->input->post('email'));
//            $identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
            $identity = $email;
            $password = $this->input->post('password');

            $additional_data = [
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => 'AA', //$this->input->post('company'),
                //'phone' => $this->input->post('phone'),
            ];
        }
        if ($this->form_validation->run() === TRUE) {
            $user_id = $this->ion_auth->register($identity, $password, $email, $additional_data);
            // check to see if we are creating the user
            // redirect them back to the admin page
            if ($user_id) {
                if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
                    //generates the activation_code
                    $check = $this->ion_auth->deactivate($user_id);
                    //get the activation code from the user record
                    $data = array(
                        'identity' => $identity,
                        'id' => $user_id,
                        'activation' => $this->ion_auth_model->activation_code,
                    );
                    $attribute['from']['from'] = 'verboetopere@alfonsiana.org';
                    $attribute['from']['name'] = 'Accademia Alfonsiana';
                    $attribute['to'] = $email;
                    $attribute['subject'] = 'Abilitazione utente - User Activation'; //activation_code';
                    //Preiscrizione
                    $attribute['message'] = $this->load->view('auth/email/activate_preiscrizione.tpl.php', $data, TRUE);

                    if ($this->send_mail($attribute)) {
                        //inserisce record nella tabella studente_preiscrizione e nei relativi gruppi
                        $this->load->model('studente_model');
                        $this->load->model('tabelle_model');
                        $tab_parametri_preiscrizione=$this->tabelle_model->tab_parametri_preiscrizione();
                        $this->studente_model->NuovoUtentePreiscrizione($user_id,$tab_parametri_preiscrizione['ANNOACCA'],$tab_parametri_preiscrizione['SEMESTRE']);                    
                        $this->studente_model->InserisciGruppo($user_id,'4');                    
                        $this->studente_model->InserisciGruppo($user_id,'7');                    

                        $this->session->set_flashdata('message', $this->ion_auth->messages());
//                        redirect("login", 'refresh'); //we should display a confirmation page here instead of the login page
                        redirect("preiscrizione_ok", 'refresh'); //we should display a confirmation page here instead of the login page
                        
                    } else {
                        redirect("preiscrizione_ko", 'refresh'); 
//                        $this->session->set_flashdata('message', $this->ion_auth->errors());
//                        redirect("login", 'refresh'); 
//                        exit($this->ion_auth->errors());
//                        redirect("create_user", 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect("auth", 'refresh');
                }
            }

            redirect("auth", 'refresh');
        } else {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['first_name'] = [
                'name' => 'first_name',
                'id' => 'first_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            ];
            $this->data['last_name'] = [
                'name' => 'last_name',
                'id' => 'last_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            ];
            $this->data['identity'] = [
                'name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
            ];
            $this->data['email'] = [
                'name' => 'email',
                'id' => 'email',
                'type' => 'text',
                'value' => $this->form_validation->set_value('email'),
            ];
            $this->data['email_confirm'] = [
                'name' => 'email_confirm',
                'id' => 'email_confirm',
                'type' => 'text',
                'value' => $this->form_validation->set_value('email_confirm'),
            ];
            $this->data['company'] = [
                'name' => 'company',
                'id' => 'company',
                'type' => 'text',
                'value' => 'AA', //$this->form_validation->set_value('company'),
            ];
//            $this->data['phone'] = [
//                'name' => 'phone',
//                'id' => 'phone',
//                'type' => 'text',
//                'value' => $this->form_validation->set_value('phone'),
//            ];
            $this->data['password'] = [
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'value' => $this->form_validation->set_value('password'),
            ];
            $this->data['password_confirm'] = [
                'name' => 'password_confirm',
                'id' => 'password_confirm',
                'type' => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            ];

            //$this->renderView('auth' . DIRECTORY_SEPARATOR . 'create_user_preiscrizione');
            $this->renderView('auth/create_user_preiscrizione', 'auth/login');
//            $this->renderView('auth/create_user_preiscrizione', 'auth/preiscrizone_ok');
        }
    }    
    

    /**
     * Redirect a user checking if is admin
     */
    public function redirectUser() {
        if ($this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }
        redirect('/', 'refresh');
    }

    /**
     * Edit a user
     *
     * @param int|string $id
     */
    public function edit_user($id) {
        $this->data['title'] = $this->lang->line('edit_user_heading');

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
            redirect('auth', 'refresh');
        }

        $user = $this->ion_auth->user($id)->row();
        $groups = $this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();

//USAGE NOTE - you can do more complicated queries like this
//$groups = $this->ion_auth->where(['field' => 'value'])->groups()->result_array();
// validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'trim|required');
        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'trim|required');
//        $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'trim|required');
//        $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'trim|required');

        if (isset($_POST) && !empty($_POST)) {
// do we have a valid request?
            if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                show_error($this->lang->line('error_csrf'));
            }

// update the password if it was posted
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
            }

            if ($this->form_validation->run() === TRUE) {
                $data = [
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'company' => $this->input->post('company'),
                    'phone' => $this->input->post('phone'),
                ];

// update the password if it was posted
                if ($this->input->post('password')) {
                    $data['password'] = $this->input->post('password');
                }

// Only allow updating groups if user is admin
                if ($this->ion_auth->is_admin()) {
// Update the groups user belongs to
                    $this->ion_auth->remove_from_group('', $id);

                    $groupData = $this->input->post('groups');
                    if (isset($groupData) && !empty($groupData)) {
                        foreach ($groupData as $grp) {
                            $this->ion_auth->add_to_group($grp, $id);
                        }
                    }
                }

// check to see if we are updating the user
                if ($this->ion_auth->update($user->id, $data)) {
// redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    $this->redirectUser();
                } else {
// redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    $this->redirectUser();
                }
            }
        }

// display the edit user form
        $this->data['csrf'] = $this->_get_csrf_nonce();

// set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

// pass the user to the view
        $this->data['user'] = $user;
        $this->data['groups'] = $groups;
        $this->data['currentGroups'] = $currentGroups;

        $this->data['first_name'] = [
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('first_name', $user->first_name),
        ];
        $this->data['last_name'] = [
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('last_name', $user->last_name),
        ];
        $this->data['company'] = [
            'name' => 'company',
            'id' => 'company',
            'type' => 'text',
            'value' => $this->form_validation->set_value('company', $user->company),
        ];
        $this->data['phone'] = [
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'value' => $this->form_validation->set_value('phone', $user->phone),
        ];
        $this->data['password'] = [
            'name' => 'password',
            'id' => 'password',
            'type' => 'password'
        ];
        $this->data['password_confirm'] = [
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'type' => 'password'
        ];

        $this->renderView('auth' . DIRECTORY_SEPARATOR . 'edit_user');
    }

    /**
     * Create a new group
     */
    public function create_group() {
        $this->data['title'] = $this->lang->line('create_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

// validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'trim|required|alpha_dash');

        if ($this->form_validation->run() === TRUE) {
            $new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
            if ($new_group_id) {
// check to see if we are creating the group
// redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth", 'refresh');
            }
        } else {
// display the create group form
// set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['group_name'] = [
                'name' => 'group_name',
                'id' => 'group_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('group_name'),
            ];
            $this->data['description'] = [
                'name' => 'description',
                'id' => 'description',
                'type' => 'text',
                'value' => $this->form_validation->set_value('description'),
            ];

            $this->renderView('auth' . DIRECTORY_SEPARATOR . 'create_group');
        }
    }

    /**
     * Edit a group
     *
     * @param int|string $id
     */
    public function edit_group($id) {
// bail if no group id given
        if (!$id || empty($id)) {
            redirect('auth', 'refresh');
        }

        $this->data['title'] = $this->lang->line('edit_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        $group = $this->ion_auth->group($id)->row();

// validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'trim|required|alpha_dash');

        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() === TRUE) {
                $additionaldata = ['description' => $_POST['group_description']];
                $group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $additionaldata);

                if ($group_update) {
                    $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
                } else {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                }
                redirect("auth", 'refresh');
            }
        }

// set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

// pass the user to the view
        $this->data['group'] = $group;

        $readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

        $this->data['group_name'] = [
            'name' => 'group_name',
            'id' => 'group_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_name', $group->name),
            $readonly => $readonly,
        ];
        $this->data['group_description'] = [
            'name' => 'group_description',
            'id' => 'group_description',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_description', $group->description),
        ];

        $this->renderView('auth' . DIRECTORY_SEPARATOR . 'edit_group');
    }

    /**
     * @return array A CSRF key-value pair
     */
    public function _get_csrf_nonce() {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return [$key => $value];
    }

    /**
     * @return bool Whether the posted CSRF token matches
     */
    public function _valid_csrf_nonce() {
        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue')) {
            return TRUE;
        }
        return FALSE;
    }

    public function create_email_richiesta_certificato_preiscrizione($id,$identity,$lingua) {
        $this->load->model('tabelle_model');
        $this->load->model('studente_model');
        $tab_parametri=$this->tabelle_model->tab_parametri_preiscrizione();

        $data = array(
            'identity' => str_replace('%20',' ',$identity),
            'id' => $id,
        );
        $attribute['from']['from'] = 'verboetopere@alfonsiana.org';
        $attribute['from']['name'] = 'Accademia Alfonsiana';
        $attribute['to'] = $tab_parametri['EMAIL_SEGRETERIA'];//'annamaria.filice@gmail.com'; 
        $attribute['subject'] = 'Richiesta Certificato Preiscrizione'; 
        $attribute['message'] = $this->load->view('auth/email/richiesta_certificato_preiscrizione.tpl.php', $data, TRUE);

        if ($this->send_mail($attribute)) {
            $this->studente_model->SalvaModificaInvioEmailSegreteriaRichiestaCertificatoPreiscrizione($id);
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente_preiscrizione' . DIRECTORY_SEPARATOR . $id.'/NULL/'.$lingua));
        } else {
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            exit($this->ion_auth->errors());
            redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente_preiscrizione' . DIRECTORY_SEPARATOR . $id.'/NULL/'.$lingua));
        }
    }        
    public function create_email_invio_certificato_preiscrizione($id) {
        $this->load->model('studente_model');
        $email=$this->studente_model->trova_email_da_id($id);
        
        $data = array(
            'id' => $id,
        );
        $attribute['from']['from'] = 'verboetopere@alfonsiana.org';
        $attribute['from']['name'] = 'Accademia Alfonsiana';
        $attribute['to'] = $email; 
        $attribute['subject'] = 'Invio Certificato Preiscrizione - Sending Pre-enrollment Certificate'; 
        $attribute['message'] = $this->load->view('auth/email/invio_certificato_preiscrizione.tpl.php', $data, TRUE);
        $filepath='./assets/images/preiscrizione/'.$id.'_CertificatoPreiscrizione.pdf';
//        $this->email->attach($filepath);
        $cognome=$this->studente_model->trova_cognome_da_id($id);
        $filepath2=str_replace("_CertificatoPreiscrizione","_CertificatoPreiscrizione".$cognome,$filepath);
        $filepath2=str_replace($id."_","",$filepath2);
        copy($filepath, $filepath2);
        $this->email->attach($filepath2);
        unlink($filepath2);

        if ($this->send_mail($attribute)) {
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente_preiscrizione' . DIRECTORY_SEPARATOR . $id));
        } else {
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            exit($this->ion_auth->errors());
            redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente_preiscrizione' . DIRECTORY_SEPARATOR . $id));
        }
    }        
    public function recupera_password($message=NULL) {
        $this->data['title'] = $this->lang->line('forgot_password_heading');

        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');

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
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            if (isset($message)){
                if ($message=='InvioEmail'){
                    $this->data['message'] = "Email per reimpostare la password inviata";
                }
            }
            $this->renderView('auth/recupera_password', 'auth/login');
        }
    }
    
    public function recupera_password_old($message=NULL) {
        $this->data['title'] = $this->lang->line('forgot_password_heading');

        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

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
            if (isset($message)){
                if ($message=='InvioEmail'){
                    $this->data['message'] = "Email per reimpostare la password inviata";
                }
            }
            $this->renderView('auth/recupera_password', 'auth\login');
        }        
    }    
    
    function email_recupera_password(){
        $this->data['title'] = $this->lang->line('forgot_password_heading');

        if ($this->config->item('identity', 'ion_auth') != 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
        } else {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
        }
 
        $identity_column = $this->config->item('identity', 'ion_auth');
        $identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

        if (empty($identity)) {

            if ($this->config->item('identity', 'ion_auth') != 'email') {
                $this->ion_auth->set_error('forgot_password_identity_not_found');
            } else {
                $this->ion_auth->set_error('forgot_password_email_not_found');
            }

            $this->session->set_flashdata('message', $this->ion_auth->errors());
            $this->data['message'] = $this->session->userdata('message');
            redirect("forgot_password", 'refresh');
        }

        $forgotten = $this->genera_codice($identity);

        if ($forgotten) {
            $str_query="SELECT * from users where email='".$identity->email."'"; 
            $query=$this->db->query($str_query);
            $user = $query->row_array(); 
            $data = array(
                'identity' => $forgotten['identity'],
//                'forgotten_password_selector' => $user['forgotten_password_selector'],
//                'forgotten_password_code' => $user['forgotten_password_code'],
                'forgotten_password_code' => $user['forgotten_password_selector'],
            );

            $attribute['from']['from'] = 'verboetopere@alfonsiana.org';
            $attribute['from']['name'] = 'Accademia Alfonsiana';
            $attribute['to'] = $identity->email;
            $attribute['subject'] = 'Resetta Password';
            $attribute['message'] = $this->load->view('auth/email/forgot_password.tpl.php', $data, TRUE);
            if ($this->send_mail($attribute)) {
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect(site_url('auth/recupera_password/InvioEmail'));
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                exit($this->ion_auth->errors());
                redirect("forgot_password", 'refresh');
            }
        }
    }
    
    private function genera_codice($identity){
        $str_query="SELECT * from users where email='".$identity->email."'"; 
        $query=$this->db->query($str_query);
        $user = $query->row_array(); 

        if ($user)
        {
                // Generate code
                $code = $this->ion_auth_model->forgotten_password($user['email']);
                if ($code)
                {
                    return TRUE;
                }
        }
        $this->set_error('forgot_password_unsuccessful');
        return FALSE;
    }        
    public function imposta_nuova_password($code = NULL) {
//        if (!$code) {
//            show_404();
//        }else{
            $this->data['title'] = $this->lang->line('forgot_password_heading');

            $tables = $this->config->item('tables', 'ion_auth');
            $identity_column = $this->config->item('identity', 'ion_auth');
            $this->data['identity_column'] = $identity_column;

            // validate form input
            $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['new_password'] = [
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            ];
            $this->data['new_password_confirm'] = [
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            ];
            $this->data['forgotten_password_selector'] = $code;
//            $this->renderView('auth/imposta_nuova_password', 'auth\login');
            $this->renderView('auth/imposta_nuova_password');
//        }
    }
        
    public function imposta_nuova_password_OLD($code = NULL) {
        if (!$code) {
            show_404();
        }else{
            $this->data['title'] = $this->lang->line('forgot_password_heading');

            $tables = $this->config->item('tables', 'ion_auth');
            $identity_column = $this->config->item('identity', 'ion_auth');
            $this->data['identity_column'] = $identity_column;            

            $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['new_password'] = [
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            ];
            $this->data['new_password_confirm'] = [
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            ];
            $this->data['forgotten_password_selector'] = $code;
            $this->renderView('auth/imposta_nuova_password', 'auth\login');
        }
    }
    public function modifica_password_dimenticata($forgotten_password_selector) {
        $post = $this->input->post();
	$this->load->model('ion_auth_model');

  	$password = $this->ion_auth_model->hash_password($post['new']);

        $str_query="UPDATE users SET
                    password='".$password."',
                    forgotten_password_selector=null,
                    forgotten_password_code=null,
                    forgotten_password_time=null
                    where forgotten_password_selector='".$forgotten_password_selector."'"; 
        $this->db->query($str_query); 
        redirect(site_url('auth' . DIRECTORY_SEPARATOR . 'login'));
//        $this->login();
    }

    public function preiscrizione_ok() {
        $this->data['body_class'] = 'bg-gradient-login';
        $this->data['title'] = $this->lang->line('login_heading');

//        $this->renderView('auth/preiscrizione_ok', 'auth/preiscrizione_ok');
        $this->data['lingua'] = $_SESSION['lingua'];
        $this->renderView('auth/preiscrizione_ok', 'auth/login');
    }
    
    public function preiscrizione_ko() {
        $this->data['body_class'] = 'bg-gradient-login';
        $this->data['title'] = $this->lang->line('login_heading');

//        $this->renderView('auth/preiscrizione_ok', 'auth/preiscrizione_ok');
        $this->data['lingua'] = $_SESSION['lingua'];
        $this->renderView('auth/preiscrizione_ko', 'auth/login');
    }

    public function ServiziOnLine() {
        $this->data['body_class'] = 'bg-gradient-login';
        $this->data['title'] = $this->lang->line('login_heading');
        
        $this->load->model('tabelle_model');
        $tab_parametri_preiscrizione=$this->tabelle_model->tab_parametri_preiscrizione();
        $this->data['PREISCRIZIONI_SCHEDA'] = $tab_parametri_preiscrizione['PREISCRIZIONI_SCHEDA'];

        if(!isset($_SESSION['lingua'])){
            $_SESSION['lingua']='IT';
        }
        $this->data['lingua'] = $_SESSION['lingua'];
        $this->renderView('auth/servizi_online', 'auth/login');
    }    
        
}
