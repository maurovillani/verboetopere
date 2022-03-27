<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!-- Page Wrapper -->
<div id="wrapper">

    <?php if(isset($sidebar)) $this->load->view('_partials/sidebar'); ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <?php if(isset($user)) $this->load->view('_partials/topbar'); ?>
        
        <?php if(isset($message)) $this->load->view('_partials/info_message'); ?>

        <!-- Main Content -->
        <div id="content">
            <?php $this->load->view($inner_view); ?>
        </div>
        <!-- End of Main Content -->
        <?php $this->load->view('_partials/footer'); ?> 
    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->
<?php $this->load->view('_partials/scrolltopbutton'); ?> 

