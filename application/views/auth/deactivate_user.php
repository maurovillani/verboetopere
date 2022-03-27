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
            <h6 class="m-0 font-weight-bold text-primary"><?php echo lang('deactivate_heading'); ?></h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <h1 class="h3 mb-2 text-gray-800"></h1>
            <p class="mb-4"><?php echo lang('deactivate_subheading'); ?></p>

            <?php echo form_open("deactivate/" . $user->id); ?>

            <p>
                <?php echo lang('deactivate_confirm_y_label', 'confirm'); ?>
                <input type="radio" name="confirm" value="yes" checked="checked" />
                <?php echo lang('deactivate_confirm_n_label', 'confirm'); ?>
                <input type="radio" name="confirm" value="no" />
            </p>

            <?php echo form_hidden($csrf); ?>
            <?php echo form_hidden(['id' => $user->id]); ?>

            <p><?php echo form_submit('submit', lang('deactivate_submit_btn')); ?></p>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>