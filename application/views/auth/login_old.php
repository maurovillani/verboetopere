<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php if (isset($message)): ?>
    <div id="infoMessage" class="alert alert-primary alert-success alert-dismissible fade show" role="alert" role="alert" >
        <?php echo $message; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
<div class="col-xl-10 col-lg-12 col-md-9">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                <div class="col-lg-6">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h6 text-gray-900 mb-4">Se hai già fatto la preiscrizione e vuoi procedere con l'iscrizione, puoi fare qui il login</h1>
                            <h2 class="h6 text-gray-400 mb-4">
                            <a class="small" href="Preiscrizione">Se vuoi fare la tua preiscrizione, clicca qui</a>
                            </h2>
                            <!--<h2 class="h6 text-gray-400 mb-4"><?php //echo lang('login_subheading'); ?></h2>-->
<!--                            <h1 class="h4 text-gray-900 mb-4"><?php echo lang('login_heading'); ?></h1>
                            <h2 class="h6 text-gray-400 mb-4"><?php echo lang('login_subheading'); ?></h2>-->
                        </div>
                        <?php echo form_open("login", ['class' => 'user']); ?>
                        <!--<form class="user">-->
                        <div class="form-group">
                            <!--<input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">-->
                            <?php
                            $identity['type'] = 'email';
                            $identity += [
                                'class' => 'form-control form-control-user',
                                'aria-describedby' => 'emailHelp',
                                'placeholder' => 'Enter Email Address...',
                            ];
                            echo form_input($identity);
                            ?>

                        </div>
                        <div class="form-group">
                            <!--<input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">-->
                            <?php
                            $password += [
                                'class' => 'form-control form-control-user',
                                'placeholder' => 'Password',
                            ];
                            echo form_input($password);
                            ?>
                        </div>
                        <!--                        <div class="form-group">
                                                    <div class="custom-control custom-checkbox small">
                                                        <label class="custom-control-label" for="customCheck"><?php echo lang('login_remember_label', 'remember'); ?></label>
                                                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <?php //echo form_checkbox('remember', '1', FALSE, 'id="remember"'); ?>
                                                    </div>
                                                </div>-->
                        <?php
                        $data = array(
                            'name' => 'button',
                            'id' => 'button',
                            'value' => 'true',
                            'type' => 'submit',
                            'content' => lang('login_submit_btn'),
                            'class' => 'btn btn-primary btn-user btn-block',
                        );
                        echo form_button($data);
                        ?>
                        <?php echo form_close(); ?>
                        <hr>
                        <div class="text-center">
                            <!--<a class="small" href="<?php // echo site_url('forgot_password'); ?>"><?php //echo lang('Forgot Password?'); ?></a>-->
                            <a class="small" href="recupera_password"><?php echo 'Hai dimenticato la Password'; ?></a>
                        </div>
<!--                        <div class="text-left">
                            <p style="font-size:22px">
                            <a class="small" href="Preiscrizione">Se vuoi fare la tua preiscrizione, clicca qui</a>
                            </p>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>