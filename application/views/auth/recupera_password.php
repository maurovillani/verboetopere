<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
echo'';
?>
<div class="container-fluid">
<?php if(isset($message)): ?>
<div id="infoMessage" class="alert alert-primary" role="alert" role="alert" >
    <?php echo $message; ?>
</div>
<?php endif;?>    
    <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                
                    <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-2"><?php echo lang('forgot_password_heading'); ?></h1>
                                <p class="mb-4"><?php echo sprintf(lang('forgot_password_subheading'), $identity_label); ?></p>
                                
                            </div>
                            <?php //echo form_open("email_recupera_password", ['class' => 'user']); ?>
                            <?php echo form_open("email_recupera_password"); ?>
                            <!--<form class="user">-->
                            <div class="form-group">
                                <?php
//amf                                $identity['type'] = 'email';
                                $identity['type'] = 'text';
                                $identity += [
                                    'class' => 'form-control form-control-user',
                                    'aria-describedby' => 'emailHelp',
//amf                                    'placeholder' => 'Enter Email Address...',
                                    'placeholder' => 'Inserisci la Username...',
                                    ' id' => 'exampleInputEmail'
                                ];
                                echo form_input($identity);
                                ?>
                            </div>

                            <?php
                            $data = array(
                                'name' => 'button',
                                'id' => 'button',
                                'value' => 'true',
                                'type' => 'submit',
                                'content' => ' Reset Password',
                                'class' => 'btn btn-primary btn-user btn-block',
                            );

                            echo form_button($data);
                            ?>
                            <?php echo form_close(); ?>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

