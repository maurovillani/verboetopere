<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php
echo $this->session->flashdata('email_sent');
?>


<div class="container">

    <div class="row">

        <div class="col-xl-12 offset-xl-1 py-5">

            <h1>Campus Assistant</h1>

            <p class="lead">Scrivi alla segreteria</p>

            <?php echo form_open(site_url('sendemail')); ?>
            <div class="messages"></div>

            <div class="controls">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="form_name">Firstname</label>
                            <input id="form_name" type="text" name="name" class="form-control" placeholder="<?php echo $first_name; ?>" value="<?php echo $first_name; ?>" readonly>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="form_lastname">Lastname</label>
                            <input id="form_lastname" type="text" name="surname" class="form-control" placeholder="<?php echo $last_name; ?>" value="<?php echo $last_name; ?>" readonly>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="form_email">Email</label>
                            <input id="form_email" type="email" name="email" class="form-control" placeholder="<?php echo $email; ?>" value="<?php echo $email; ?>" readonly>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="form_need">Specifica l'argomento</label>
                            <input id="form_need" type="text" name="need" class="form-control" required="required" data-error="Please, leave us a subject." value="<?php echo set_value('need'); ?>">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="form_message">Messaggio </label>
                            <textarea id="form_message" name="message" class="form-control" placeholder="Messaggio..    " rows="6" required="required" data-error="Please, leave us a message." value="<?php echo set_value('message',''); ?>"></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <input type="submit" class="btn btn-success btn-send" value="Send message">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-muted">
                            <strong>*</strong> These fields are required. Contact form template by
                            <a href="https://ecm2.it" target="_blank">ECM2.it</a>.</p>
                    </div>
                </div>
            </div>

            <?php echo form_close(); ?>

        </div>

    </div>

</div>