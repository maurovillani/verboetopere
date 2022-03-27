<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo site_url('backend'); ?>">
        <div class="sidebar-brand-icon">
            <img src="<?php echo base_url('assets/images/aaseal60x85.jpg')?>" class="img-thumbnail">
        </div>
<!--        <div class="sidebar-brand-text mx-3">Gestionale Università AMF</div>-->
        <div class="sidebar-brand-text mx-3">Accademia Alfonsiana</div>
    </a>
    <?php echo $sidebar; ?>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
