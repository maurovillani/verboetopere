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

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?php echo lang('change_password_heading'); ?></h1>
    <p class="mb-4">La password deve avere diversi criteri di sicurezza.</p>

    <?php echo form_open("change_password"); ?>

    <p>
        <?php echo lang('change_password_old_password_label', 'old_password'); ?> <br />
        <?php echo form_input($old_password); ?>
    </p>

    <p>
        <label for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length); ?></label> <br />
        <?php echo form_input($new_password); ?>
    </p>

    <p>
        <?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm'); ?> <br />
        <?php echo form_input($new_password_confirm); ?>
    </p>

    <?php echo form_input($user_id); ?>
    <p><?php echo form_submit('submit', lang('change_password_submit_btn')); ?></p>

    <?php echo form_close(); ?>
</div>
<!-- /.container-fluid -->