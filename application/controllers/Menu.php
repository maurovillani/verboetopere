<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Controller per la gestione dei menu
 * @author Paolo Minervino <paolo.minervino@ecm2.it> 
 */
class Menu extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('login', 'refresh');
        }
        $exceptions = ['menu/group', 'menu/test', 'menu/getLists/*'];
        $this->sidebar = $this->buildSidebarMenuWthCurrentUriPermitted($exceptions);
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar);
    }

    public function index()
    {
        $this->load->library('components');
        $this->components->addDatatable('menus');
        $this->components->addRadiobutton();

        $this->renderView('menu' . DIRECTORY_SEPARATOR . 'index');
    }
    public function group()
    {
        $mygroups = $this->input->post('mygroups');
        $menu_id = $this->input->post('menu_id');
        $this->load->model('service_model', 'serviceDB');
        $myvar1 = $this->serviceDB->get_menus_groups($menu_id)->result();

        foreach ($myvar1 as $group) {
            if ($group->IsOwned && $mygroups[$group->id] === 'N') {
                $where = 'menus_id =' . $menu_id . ' and group_id =' . $group->id;
                $this->db->where($where)->delete('menus_groups');
            }
            if (!$group->IsOwned && $mygroups[$group->id] === 'Y') {
                $this->db->insert('menus_groups', ['menus_id' => $menu_id, 'group_id' => $group->id]);
            }
        }
        redirect(site_url('menu'), 'refresh');
    }
    public function test()
    {

    }
}
