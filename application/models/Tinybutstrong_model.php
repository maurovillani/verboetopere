<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Tinybutstrong_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getUserData() {

        // of course you can launch a query here ...

        $ud[0]['user_realname'] = 'John DOE';
        $ud[0]['user_photo'] = 'picture1.png';
        $ud[1]['user_realname'] = 'John DOE Junior';
        $ud[1]['user_photo'] = 'picture2.png';

        return $ud;
    }

}
