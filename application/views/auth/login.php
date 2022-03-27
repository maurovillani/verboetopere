<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script>
    function showPwd() {
        document.getElementById("occhio").style.visibility = 'hidden';
        document.getElementById("occhiob").style.visibility = 'hidden';
        var input = document.getElementById('password');
        if (input.type === "password") {
          input.type = "text";
          document.getElementById("occhio").style.visibility = 'visible';
          document.getElementById("occhiob").style.visibility = 'hidden';
        } else {
          input.type = "password";
          document.getElementById("occhio").style.visibility = 'hidden';
          document.getElementById("occhiob").style.visibility = 'visible';
        }
      }
</script>
<style>
/*div { 
    border-style:solid; 
    border-color:#CCCCCC; 
    border-width:1px; 
    padding-top: 1px;
    padding-bottom: 1px;
    padding-left: 1px;
    padding-right: 1px;
}*/

/*div#b{*/
.div_pos{
    position: absolute;
    top:180px; 
    left:370px;
    /*right:10px;*/
    width:30px
}
</style>
<?php if (isset($message)): ?>
    <div id="infoMessage" class="alert alert-primary alert-success alert-dismissible fade show" role="alert" role="alert" >
        <?php echo $message; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
<?PHP //ECHO constant('ENVIROMENT'); ?>
<div class="col-xl-10 col-lg-12 col-md-9">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                <div class="col-lg-6">
                    <div class="p-5">
                        <div class="text-center">
                            <!--<h1 class="h4 text-gray-900 mb-4"><?php //echo lang('login_heading'); ?></h1>-->
                            <?php if ($lingua=='IT'):?>
                                <h1 class="h4 text-gray-900 mb-4">Accedi</h1>
                            <?php elseif ($lingua=='IN'):?>
                                <h1 class="h4 text-gray-900 mb-4">Log in</h1>
                            <?php endif;?>
                            <!--<h2 class="h6 text-gray-400 mb-4"><?php //echo lang('login_subheading'); ?></h2>-->
                        </div>
                        <?php echo form_open("login", ['class' => 'user']); ?>
                        <!--<form class="user">-->
                        <div class="form-group">
                            <!--<input type="text" class="form-control form-control-user" id="identity" name="identity" aria-describedby="emailHelp" placeholder="Username" tabindex="1">-->
                            <?php
//                            $identity['type'] = 'email';
                            $identity['type'] = 'text';
                            $identity += [
                                'class' => 'form-control form-control-user',
                                'aria-describedby' => 'emailHelp',
//                                'placeholder' => 'Enter Email Address...',
                                'placeholder' => 'Username'
                            ];
                            echo form_input($identity);
                            ?>

                        </div>
                        <div class="form-group">
                            <div class="div_pos" id="occhio" style="visibility:hidden">
                                <button type="button" class="close" onclick="showPwd()">
                                    <i class="fas fa-eye"></i></i> 
                                </button>
                            </div>
                            <div class="div_pos" id="occhiob" style="visibility:visible">
                                <button type="button" class="close" onclick="showPwd()">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                            <!--<input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password" tabindex="2">-->
                            <?php
                            $password += [
                                'class' => 'form-control form-control-user',
                                'placeholder' => 'Password',
                            ];
                            echo form_input($password);
                            ?>
                        </div>
                        <!--<input type="submit" name="button" id="button" class="btn btn-primary  btn-user btn-block" value="Accedi"  tabindex="3">-->  
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
                            <?php if ($lingua=='IT'):?>
                                <a class="small" href="recupera_password">Hai dimenticato la Password</a>
                            <?php elseif ($lingua=='IN'):?>
                                <a class="small" href="recupera_password">Did you forget your password</a>
                            <?php endif;?>
                        </div>
<!--                        <div class="text-center">
                            <a class="small" href="Preiscrizione"><?php //echo 'Preiscrizione'; ?></a>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>