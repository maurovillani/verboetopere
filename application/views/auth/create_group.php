<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo lang('create_group_heading'); ?></h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <h1 class="h3 mb-2 text-gray-800"></h1>
            <p class="mb-4"><?php echo lang('create_group_subheading'); ?></p>


            <div id="infoMessage"><?php echo $message; ?></div>




            <?php echo form_open("create_group"); ?>

            <p>
                <?php echo lang('create_group_name_label', 'group_name'); ?> <br />
                <?php echo form_input($group_name); ?>
            </p>

            <p>
                <?php echo lang('create_group_desc_label', 'description'); ?> <br />
                <?php echo form_input($description); ?>
            </p>

            <p><?php echo form_submit('submit', lang('create_group_submit_btn')); ?></p>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>