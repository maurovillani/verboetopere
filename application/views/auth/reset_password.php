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
    <h1><?php echo lang('reset_password_heading'); ?></h1>


    <?php echo form_open('reset_password/' . $code); ?>

    <p>
        <label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length); ?></label> <br />
        <?php echo form_input($new_password); ?>
    </p>

    <p>
        <?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm'); ?> <br />
        <?php echo form_input($new_password_confirm); ?>
    </p>

    <?php echo form_input($user_id); ?>
    <?php echo form_hidden($csrf); ?>

    <p><?php echo form_submit('submit', lang('reset_password_submit_btn')); ?></p>

    <?php echo form_close(); ?>
</div>