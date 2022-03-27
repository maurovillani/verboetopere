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
            <h6 class="m-0 font-weight-bold text-primary"><?php echo lang('create_user_heading'); ?></h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <h1 class="h3 mb-2 text-gray-800"></h1>
            <p class="mb-4"><?php echo lang('create_user_subheading'); ?></p>
            <div id="infoMessage"><?php echo $message; ?></div>
            <!-- ion Auth original -->
            <?php echo form_open("auth/create_user_preiscrizione"); ?>

            <p>
                <?php echo lang('create_user_fname_label', 'first_name'); ?> <br />
                <?php echo form_input($first_name); ?>
            </p>

            <p>
                <?php echo lang('create_user_lname_label', 'last_name'); ?> <br />
                <?php echo form_input($last_name); ?>
            </p>

            <?php
            if ($identity_column !== 'email') {
                echo '<p>';
                echo lang('create_user_identity_label', 'identity');
                echo '<br />';
                echo form_error('identity');
                echo form_input($identity);
                echo '</p>';
            }
            ?>

<!--            <p>
                <?php //echo lang('create_user_company_label', 'company'); ?> <br />
                <?php //echo form_input($company); ?>
            </p>-->

            <p>
                <?php echo lang('create_user_email_label', 'email'); ?> <br />
                <?php echo form_input($email); ?>
            </p>

            <p>
                <?php echo lang('create_user_phone_label', 'phone'); ?> <br />
                <?php echo form_input($phone); ?>
            </p>

            <p>
                <?php echo lang('create_user_password_label', 'password'); ?> <br />
                <?php echo form_input($password); ?>
            </p>

            <p>
                <?php echo lang('create_user_password_confirm_label', 'password_confirm'); ?> <br />
                <?php echo form_input($password_confirm); ?>
            </p>


            <p><?php echo form_submit('submit', lang('create_user_submit_btn')); ?></p>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>