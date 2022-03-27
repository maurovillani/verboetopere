<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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
                                <h1 class="h4 text-gray-900 mb-2"><?php echo 'Imposta nuova password';//lang('forgot_password_heading'); ?></h1>
                                
                            </div>
                            <?php echo form_open("modifica_password_dimenticata/".$forgotten_password_selector, ['class' => 'user']); ?>
                            <div class="form-group">
                            <p>
                                <label for="new_password">Nuova password <i>(almeno 8 caratteri)</i></label> <br />
                                <?php echo form_input($new_password); ?>
                            </p>

                            <p>
                                <label for="new_password_confirm">Conferma nuova password</label> <br />
                                <?php echo form_input($new_password_confirm); ?>
                            </p>                            
                            </div>

                            <p><?php echo form_submit('submit', lang('change_password_submit_btn')); ?></p>

                            <?php echo form_close(); ?>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

