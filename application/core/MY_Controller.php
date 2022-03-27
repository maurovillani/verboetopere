<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MY_Controller extends CI_Controller {

    protected $data = [];
    protected $mVarsJS = [];
    protected $mScripts = [];
    protected $mScriptsSource = [];
    protected $mMetaData;
    protected $mStylesheets = array();
    protected $mController;
    protected $mAction;
    protected $mBody_class;
    protected $site_name;
    protected $page_title_prefix;
    protected $page_title;
    protected $author;
    protected $version;
    protected $site_description;
    protected $customer;
    protected $mMenu;
    protected $domain;
    protected $sidebar = [];
    protected $mUser;
    protected $mConfig;
    public $mail = [];

    public function __construct() {
        parent::__construct();
        if ($this->session->has_userdata('current_url')) {
            if ($this->session->has_userdata('referred_from')) {
                if ($this->session->has_userdata('referred_from_from')) {
                    $this->session->set_userdata('referred_from_from_from', $this->session->userdata('referred_from_from'));
                }
                $this->session->set_userdata('referred_from_from', $this->session->userdata('referred_from'));
            }
            $this->session->set_userdata('referred_from', $this->session->userdata('current_url'));
        }
        $this->session->set_userdata('current_url', current_url());
        $this->mConfig = $this->config->item('ci_bootstrap'); // carico il file delle impostazioni personalizzate
        $this->mMenu = empty($this->mConfig['menu']) ? array() : $this->mConfig['menu'];
        $this->mController = $this->uri->segment(1);
        $this->mAction = $this->uri->segment(2);

        $this->author = empty($this->mConfig['author']) ? 'da mettere' : $this->mConfig['author'];
        $this->site_description = empty($this->mConfig['site_description']) ? 'da mettere' : $this->mConfig['site_description'];
        $this->site_company = empty($this->mConfig['site_company']) ? 'da mettere' : $this->mConfig['site_company'];
        $this->customer = empty($this->mConfig['customer']) ? 'da mettere' : $this->mConfig['customer'];
        $this->site_name = empty($this->mConfig['site_name']) ? 'da mettere' : $this->mConfig['site_name'];
        $this->author = empty($this->mConfig['author']) ? 'da mettere' : $this->mConfig['author'];
        $this->version = empty($this->mConfig['version']) ? 'da mettere' : $this->mConfig['version'];
        $this->site_name = empty($this->mConfig['site_name']) ? 'da mettere' : $this->mConfig['site_name'];
        $this->page_title_prefix = empty($this->mConfig['page_title_prefix']) ? 'da mettere' : $this->mConfig['page_title_prefix'];
        $this->page_title = empty($this->mConfig['page_title']) ? $this->mController . ' - ' . $this->mAction : $this->mConfig['page_title'];

        $this->mBody_class = $this->mConfig['body_class'];

        $this->mMetaData = empty($this->mConfig['meta_data']) ? array() : $this->mConfig['meta_data'];
        $this->mScripts = empty($this->mConfig['scripts']) ? array() : $this->mConfig['scripts'];
        $this->mScriptsSource = empty($this->mConfig['ScriptsSource']) ? array() : $this->mConfig['ScriptsSource'];
        $this->mVarsJS = empty($this->mConfig['varsJs']) ? array() : $this->mConfig['varsJs'];
        $this->mStylesheets = empty($this->mConfig['stylesheets']) ? array() : $this->mConfig['stylesheets'];

        $this->load->database();
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        // Your own constructor code
        if ($this->ion_auth->logged_in()) {
            $this->data['user'] = $this->ion_auth->user()->row();
            /*
             * Livello di sicurezza basato su e-mail
             */
            $this->domain = substr(strstr($this->data['user']->email, '@'), 1);
        }
        $this->mail['protocol'] = 'smtp';
        $this->mail['smtp_host'] = 'smtp.alfonsiana.org';
        $this->mail['smtp_user'] = 'verboetopere@alfonsiana.org';
        $this->mail['smtp_pass'] = 'alfonso2019';
        $this->mail['smtp_port'] = 25;
        $this->mail['charset'] = 'utf-8';
        $this->mail['newline'] = "\r\n";
        $this->mail['crlf'] = "\r\n"; //AMF apparivano degli '=' 2021-04-19
    }

    /**
     * Load view with selected layout.
     * @param type string $view vista da caricare
     * @param type string | default $layout layout scelto, di default test.
     * @param type boolean $returnhtml rendering si o no
     * @return string
     */
    protected function renderView($view, $layout = 'backend', $returnhtml = FALSE) {
        $this->data['layout'] = $layout;
        $this->data['inner_view'] = $view;


        if ($layout === 'empty') {
            if ($returnhtml) {
                $output = $this->load->view('_layouts/' . $layout, $this->data, TRUE);
                return $output;
            } else {
                return $output = $this->load->view('_layouts/' . $layout, $this->data, FALSE);
            }
        }
        //$this->setupLayout($layout);
        $this->data['base_url'] = empty($this->mConfig['base_url']) ? '' : $this->mConfig['base_url'];

        $this->data['author'] = $this->author;
        $this->data['site_description'] = $this->site_description;
        $this->data['site_company'] = $this->site_company;
        $this->data['site_name'] = $this->site_name;
        $this->data['page_title'] = $this->page_title_prefix . ' - ' . $this->page_title;
        $this->data['version'] = $this->version;

        $this->data['scriptssource'] = $this->mScriptsSource;
        $this->data['varsJs'] = $this->mVarsJS;
        /**
         * Verifica che la stessa libreria non venga caricata due volta...
         */
        $this->data['meta_data'] = array_unique($this->mMetaData, SORT_REGULAR);
        $this->data['scripts'] = array_unique($this->mScripts, SORT_REGULAR);
        $this->data['stylesheets'] = array_unique($this->mStylesheets, SORT_REGULAR);

        !isset($this->data['body_class']) ? $this->mBody_class : $this->data['body_class'];
        $this->data['layout'] = $layout;

        $this->data['inner_view'] = $view;

        if ($returnhtml) {
            $output = $this->load->view('_base/head', $this->data, TRUE)
                    . $this->load->view('_layouts/' . $layout, $this->data, TRUE)
                    . $this->load->view('_base/foot', $this->data, TRUE);
            return $output;
        } else {
            $this->load->view('_base/head', $this->data, FALSE);
            $this->load->view('_layouts/' . $layout, $this->data, FALSE);
            $this->load->view('_base/foot', $this->data, FALSE);
        }
    }

    // Output JSON string
    protected function render_json($data, $code = 200) {
        $this->output
                ->set_status_header($code)
                ->set_content_type('application/json')
                ->set_output(json_encode($data));

        // force output immediately and interrupt other scripts
        global $OUT;
        $OUT->_display();
        exit;
    }
    protected function render_json1($response, $code = 200)
    {
        $this->output
            ->set_status_header($code)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }
    
    // Add js script vars, either append or prepend to $this->mVarsJS array
    // ($vars can be string or string array)
    protected function add_JSvars($vars, $append = TRUE, $position = 'foot') {
        $vars = is_string($vars) ? array($vars) : $vars;
        $position = ($position === 'head' || $position === 'foot') ? $position : 'foot';
        if ($append) {
            $this->mVarsJS[$position] = array_merge($this->mVarsJS[$position], $vars);
        } else {
            $this->mVarsJS[$position] = array_merge($vars, $this->mVarsJS[$position]);
        }
    }

    // Add script files, either append or prepend to $this->mScripts array
    // ($files can be string or string array)
    protected function add_script($files, $append = TRUE, $position = 'foot') {
        $files = is_string($files) ? array($files) : $files;
        $position = ($position === 'head' || $position === 'foot') ? $position : 'foot';
        if ($append) {
            $this->mScripts[$position] = array_merge($this->mScripts[$position], $files);
        } else {
            $this->mScripts[$position] = array_merge($files, $this->mScripts[$position]);
        }
    }

    // Add script source java/text, either append or prepend to $this->mScripts array
    // ($files can be string or string array)
    protected function add_scriptSource($files, $append = TRUE, $position = 'foot') {
        $files = is_string($files) ? array($files) : $files;
        $position = ($position === 'head' || $position === 'foot') ? $position : 'foot';

        if ($append) {
            $this->mScriptsSource[$position] = array_merge($this->mScriptsSource[$position], $files);
        } else {
            $this->mScriptsSource[$position] = array_merge($files, $this->mScriptsSource[$position]);
        }
    }

    // Add stylesheet files, either append or prepend to $this->mStylesheets array
    // ($files can be string or string array)
    protected function add_stylesheet($files, $append = TRUE, $media = 'screen') {
        $files = is_string($files) ? array($files) : $files;

        if ($append) {
            $this->mStylesheets[$media] = array_merge($this->mStylesheets[$media], $files);
        } else {
            $this->mStylesheets[$media] = array_merge($files, $this->mStylesheets[$media]);
        }
    }

    protected function get_csrf() {
        $csrf['csrf_name'] = $this->security->get_csrf_token_name();
        $csrf['csrf_token'] = $this->security->get_csrf_hash();
        $this->render_json($csrf);
    }

    /**
     * Costruisce la sidebar e ne calcola anche il nodo padre per ogni menu cliccato in modo di lasciarlo aperto
     * Nel caso si voglia comunque ignorare il parent node si puÃ² dare un numero direttamente... non consigliato
     * @param array $array dei menu letti sul db
     * @param integer $active_menu meglio non valorizzarlo se non si sa quello che si sta facendo
     * @return string contiene html dei nodi della sidebar
     */
    protected function buildSidebar($array, $active_menu = 0) {
        $this->load->model('service_model', 'serviceDB');
        $active_menu = ($active_menu === 0 ? $this->serviceDB->getParentMenuId($this->uri->uri_string()) : $active_menu);
        $this->data['active_menu'] = $active_menu;
        return $this->recursive($array, 1);
    }

    /**
     * Genera menu utile alla navigazione in maniera ricorsiva
     * @param type $array Associative array with children
     * @param type $MaxDepth Max depth i have to traverse the array
     * @param type $level do not use setted at start to 0 used only for recursive limit
     * @author Paolo Minervino <paolo.minervino@ecm2.it>
     */
    private function recursive($array, $MaxDepth = 1, $level = 0) {
        echo PHP_EOL;
        $result = '';
        foreach ($array as $node) {
            if ($MaxDepth < $level)
                break;
            $nav = $this->settingSideBar($node, $level);
            if (isset($node['children'])) {
                $result .= $nav['withchild']['header'];
                $result .= $this->recursive($node['children'], $MaxDepth, $level + 1);
                $result .= $nav['withchild']['footer'];
            } else {
                $result .= $nav['nochild']['header'];
                $result .= $nav['nochild']['footer'];
            }
        }
        return $result;
    }

    private function settingSideBar($node, $level) {
        $myNav = [];

        switch ($node['type']) {
            case 'nav-link':
                $myNav[0] = [
                    'nochild' => [
                        'header' =>
                        '<li class="nav-item">' . PHP_EOL
                        . str_repeat("\t", 2) . '<a class="nav-link" href="' . site_url($node['url']) . '" target="' . $node['target'] . '">' . PHP_EOL
                        . str_repeat("\t", 3) . $node['icon'] . PHP_EOL
                        . str_repeat("\t", 4) . '<span>' . $node['name'] . '</span>' . PHP_EOL
                        . str_repeat("\t", 2) . '</a>' . PHP_EOL,
                        'footer' =>
                        str_repeat("\t", 1) . '</li>' . PHP_EOL
                        . str_repeat("\t", 1) . '<!-- Divider -->' . PHP_EOL
                        . str_repeat("\t", 1) . '<hr class="sidebar-divider my-0">' . PHP_EOL
                    ],
                    'withchild' => [
                        'header' =>
                        str_repeat("\t", 1) . '<!-- Nav Item - Pages Collapse Menu -->' . PHP_EOL
                        . str_repeat("\t", 1) . '<li class="nav-item ' . ($this->data['active_menu'] === intval($node['id']) ? 'active' : '') . '">' . PHP_EOL
                        . str_repeat("\t", 2) . '<a class="nav-link' . ($this->data['active_menu'] === intval($node['id']) ? '' : ' collapsed') . '"'
                        . ' href="#" data-toggle="collapse" data-target="#collapse' . $node['key'] . '"'
                        . '   aria-expanded="' . ($this->data['active_menu'] === intval($node['id']) ? 'true' : 'false')
                        . '" aria-controls="collapseTwo" target="' . $node['target'] . '">' . PHP_EOL
                        . str_repeat("\t", 3) . $node['icon'] . PHP_EOL
                        . str_repeat("\t", 4) . '<span>' . $node['name'] . '</span>' . PHP_EOL
                        . str_repeat("\t", 2) . '</a>' . PHP_EOL
                        . str_repeat("\t", 2) . '<div id="collapse' . $node['key'] . '" class="collapse ' . ($this->data['active_menu'] === intval($node['id']) ? 'show' : '') . '" '
                        . ' aria-labelledby="heading' . $node['key'] . '" data-parent="#accordionSidebar">' . PHP_EOL
                        . str_repeat("\t", 3) . '<div class="bg-white py-2 collapse-inner rounded">' . PHP_EOL,
                        'footer' =>
                        str_repeat("\t", 3) . '</div>' . PHP_EOL
                        . str_repeat("\t", 2) . '</div>' . PHP_EOL
                        . str_repeat("\t", 1) . '</li>' . PHP_EOL
                        . str_repeat("\t", 1) . '<!-- Divider -->' . PHP_EOL
                        . str_repeat("\t", 1) . '<hr class="sidebar-divider my-0">' . PHP_EOL
                    ]
                ];
                $myNav[1] = [
                    'nochild' => [
                        'header' =>
                        str_repeat("\t", 4) . '<a class="collapse-item" href="' . site_url($node['url']) . '" target="' . $node['target'] . '">' . PHP_EOL
                        . str_repeat("\t", 5) . $node['icon'] . PHP_EOL
                        . str_repeat("\t", 6) . '<span>' . $node['name'] . '</span>' . PHP_EOL
                        . str_repeat("\t", 4) . '</a>' . PHP_EOL,
                        'footer' => ''
                    ]
                ];
                break;
            case 'sidebar-heading':
                $myNav[0] = [
                    'nochild' => [
                        'header' =>
                        str_repeat("\t", 1) . '<div class="sidebar-heading">' . $node['name'] . '</div>' . PHP_EOL,
                        'footer' => ''
                    ]
                ];

                break;
        }
        return $myNav[$level];
    }

    /**
     * Send e-mail...
     * @author Paolo Minervino
     * @param type array $mail_attributes...
     * @return boolean
     */
    public function send_mail($mail_attributes) {
        $this->load->library('email');
        $this->email->initialize($this->mail);
        /**
         * Initializes all the email variables to an empty state.
         * This method is intended for use if you run the email sending method in a loop, 
         * permitting the data to be reset between cycles.
         */
        if (isset($mail_attributes['clear']))
            $this->email->clear($mail_attributes['clear']); //clear_attachments (bool) â€“ Whether or not to clear attachments

            
//from($from[, $name = ''[, $return_path = NULL]]) Sets the email address and name of the person sending the email:
        if (is_array($mail_attributes['from'])) {
            if (isset($mail_attributes['from']['from']))
                $this->email->from($mail_attributes['from']['from']); //from string) 
            if (isset($mail_attributes['from']['name']))
                $this->email->from($mail_attributes['from']['from'], $mail_attributes['from']['name']); //$name (string) â€“ â€œFromâ€� display name
            if (isset($mail_attributes['from']['return_path']))
                $this->email->from($mail_attributes['from']['from'], $mail_attributes['from']['name'], $mail_attributes['from']['return_path']); //$return_path (string) â€“ Optional email address to redirect undelivered e-mail to
        } else {
            $this->email->from($mail_attributes['from']);
        }

        $this->email->to($mail_attributes['to']); //to (mixed) â€“ Comma-delimited string or an array of e-mail addresses
        if (isset($mail_attributes['cc']))
            $this->email->cc($mail_attributes['cc']); //cc (mixed) â€“ Comma-delimited string or an array of e-mail addresses

        /**
         * bcc($bcc[, $limit = ''])
         * Sets the BCC email address(s). Just like the to() method, can be a single e-mail, a comma-delimited list or an array. 
         * If $limit is set, â€œbatch modeâ€� will be enabled, which will send the emails to batches, with each batch not exceeding the specified $limit.
         */
        if (isset($mail_attributes['bcc']['bcc']))
            $this->email->cc($mail_attributes['bcc']['bcc']); //bcc (mixed) â€“ Comma-delimited string or an array of e-mail addresses
        if (isset($mail_attributes['bcc']['limit']))
            $this->email->cc($mail_attributes['bcc']['bcc'], $mail_attributes['bcc']['limit']); //limit (int) â€“ Maximum number of e-mails to send per batch

        if (isset($mail_attributes['subject']))
            $this->email->subject($mail_attributes['subject']); //subject (string) â€“ E-mail subject line
        if (isset($mail_attributes['message']))
            $this->email->message($mail_attributes['message']); //message (string) â€“ E-mail message body

        if (isset($mail_attributes['set_alt_message']))
            $this->email->set_alt_message($mail_attributes['set_alt_message']); //str (string) â€“ Alternative e-mail message body

            
//attach($filename[, $disposition = ''[, $newname = NULL[, $mime = '']]])
        if (isset($mail_attributes['filename']))
            $this->email->attach($mail_attributes['filename']); //message (string) â€“ E-mail message body
        return $this->email->send();
    }

    /**
     * Check permission based on groups
     * @author Paolo Minervino <paolo.minervino@ecm2.it>
     * @param array $exceptions
     * @return mixed array sidebar with permitted uri or exit script!
     */
    protected function buildSidebarMenuWthCurrentUriPermitted($exceptions = null) {
        $this->load->model('service_model', 'serviceDB');
        if (is_null($exceptions)) {
            if (!$this->serviceDB->IsCurrentUriPermitted(
                $this->ion_auth->get_users_groups()->result(), $this->uri->uri_string()
                    )) {
                exit('L\'url che hai digitato non ti Ã¨ permesso!. Ogni abuso verrÃ  perseguito.');
            }
        } else {
            if (!$this->serviceDB->IsCurrentUriPermitted(
                $this->ion_auth->get_users_groups()->result(),  $this->uri->uri_string(), $exceptions
                    )) {
                exit('L\'url che hai digitato non ti Ã¨ permesso!. Ogni abuso verrÃ  perseguito.');
            }
        }
        return $this->serviceDB->buildSidebarMenu(true, $this->ion_auth->get_users_groups()->result());
    }

    /**
     * Controlla il formato della data per le date obbligatorie
     * @author Anna Maria Filice
     * @param array $exceptions
     * @return array
     */
    public function ControllaFormatoData($myForm,$campo,$etichetta,$obbligatorio){
        $str='
            if (document.'.$myForm.'.'.$campo.'.value.substring(4,5) != "-" ||
                document.'.$myForm.'.'.$campo.'.value.substring(7,8) != "-" ||
                isNaN(document.'.$myForm.'.'.$campo.'.value.substring(0,4)) ||
                isNaN(document.'.$myForm.'.'.$campo.'.value.substring(5,7)) ||
                isNaN(document.'.$myForm.'.'.$campo.'.value.substring(8,10))) {
                alert("Inserire la '.$etichetta.' in formato aaaa-mm-gg");
                document.'.$myForm.'.'.$campo.'.focus();
                return false;
            } else if (document.'.$myForm.'.'.$campo.'.value.substring(8,10) > 31) {
                alert("Per la '.$etichetta.' impossibile utilizzare un valore superiore a 31 per i giorni");
                document.'.$myForm.'.'.$campo.'.select();
                return false;
            } else if (document.'.$myForm.'.'.$campo.'.value.substring(5,7) > 12) {
                alert("Per la '.$etichetta.' impossibile utilizzare un valore superiore a 12 per i mesi");
                document.'.$myForm.'.'.$campo.'.focus();
                return false;
            } else if (document.'.$myForm.'.'.$campo.'.value.substring(0,4) < 1900) {
                alert("Per la '.$etichetta.' impossibile utilizzare un valore inferiore a 1900 per l\'anno");
                document.'.$myForm.'.'.$campo.'.focus();
                return false;
            }
        ';
        if (!$obbligatorio){
            $str='
                if (document.'.$myForm.'.'.$campo.'.value != "") {
                '.$str.'}'; 
        }
        return $str;
    }    
    public function ControllaFormatoData_IN($myForm,$campo,$etichetta,$obbligatorio){
        $str='
            if (document.'.$myForm.'.'.$campo.'.value.substring(4,5) != "-" ||
                document.'.$myForm.'.'.$campo.'.value.substring(7,8) != "-" ||
                isNaN(document.'.$myForm.'.'.$campo.'.value.substring(0,4)) ||
                isNaN(document.'.$myForm.'.'.$campo.'.value.substring(5,7)) ||
                isNaN(document.'.$myForm.'.'.$campo.'.value.substring(8,10))) {
                alert("Enter '.$etichetta.' format aaaa-mm-gg");
                document.'.$myForm.'.'.$campo.'.focus();
                return false;
            } else if (document.'.$myForm.'.'.$campo.'.value.substring(8,10) > 31) {
                alert("Per la '.$etichetta.' cannot use a value greater than 31 for days");
                document.'.$myForm.'.'.$campo.'.select();
                return false;
            } else if (document.'.$myForm.'.'.$campo.'.value.substring(5,7) > 12) {
                alert("Per la '.$etichetta.' cannot use a value greater than 12 for months");
                document.'.$myForm.'.'.$campo.'.focus();
                return false;
            } else if (document.'.$myForm.'.'.$campo.'.value.substring(0,4) < 1900) {
                alert("Per la '.$etichetta.' cannot use a value less than 1900 for the year");
                document.'.$myForm.'.'.$campo.'.focus();
                return false;
            }
        ';
        if (!$obbligatorio){
            $str='
                if (document.'.$myForm.'.'.$campo.'.value != "") {
                '.$str.'}'; 
        }
        return $str;
    }    

    public function ControllaCampiObbligatori($myForm,$campo,$etichetta){
        $str='
        if (document.'.$myForm.'.'.$campo.'.value == "" || document.'.$myForm.'.'.$campo.'.value == "undefined") {
            alert("'.$etichetta.'");
            document.'.$myForm.'.'.$campo.'.focus();
            return false;
        }
        ';
        return $str;
    }    
    public function ControllaCampiCheckObbligatori($myForm,$campo,$etichetta,$value){
        $str='
        if (document.'.$myForm.'.'.$campo.'.value == "'.$value.'" || document.'.$myForm.'.'.$campo.'.value == "undefined") {
            alert("'.$etichetta.'");
            document.'.$myForm.'.'.$campo.'.focus();
            return false;
        }
        ';
        return $str;
    }    
    
}
