<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Frontend extends MY_Controller {

    protected $dataset = [];

    public function __construct() {
        parent::__construct();
        /*
        $this->data['active_menu'] = 'vuota';
        $this->load->model('service_model', 'serviceDB');
        $this->sidebar = $this->serviceDB->buildSidebarMenu();
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar);
        */
    }
    
    public function index() {
        if (!$this->ion_auth->logged_in()) {
            redirect('login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()&&!$this->ion_auth->in_group(['Frontend','Backend'])) {
            $this->ion_auth->logout();
             $this->session->set_flashdata('message', 'La sua utenza è attiva ma deve essere abilitata dalla segreteria');
            redirect('login', 'refresh');
        }
        redirect('backend');
        //$this->renderView('frontend' . DIRECTORY_SEPARATOR . 'blank','frontend');
    }
//    public function preiscrizione(){
//        $this->add_script('assets/js/multistep.js');
//        $this->renderView('frontend' . DIRECTORY_SEPARATOR . 'preiscrizione','frontend');
//    }
    /**
     * Raccoglie le informazioni della form preiscrizione per essere salvate
     *
     * @return void
     */
    public function save(){
        $this->data['preiscrizione']=$this->input->post();
        $this->renderView('frontend' . DIRECTORY_SEPARATOR . 'save','frontend');

    }

    public function error404() {
        $this->renderView('frontend' . DIRECTORY_SEPARATOR . '404','frontend');
    }



}