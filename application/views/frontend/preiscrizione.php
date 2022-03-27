<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style type="text/css">
#regiration_form fieldset:not(:first-of-type) {
    display: none;
}
</style>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Preiscrizione</h1>
    <div class="progress">
        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
        </div>
    </div>
    <?php 
        $attributes = [
//            'novalidate'=>'value', 
            'id' => 'regiration_form'
        ];
        echo form_open('preiscrizione/salva', $attributes);
    ?>
    <!-- <form id="regiration_form" novalidate action="action.php" method="post"> -->
        <fieldset>
            <h2>Step 1: Crea il tuo account</h2>
            <div class="form-group">
                <label for="email">Indirizzo Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" style="width:30%">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" style="width:30%">
            </div>
            <input type="button" name="password" class="next btn btn-info" value="Next" />
        </fieldset>
        <fieldset>
            <h2> Step 2: Dati Personali</h2>
            <div class="form-group">
                <label for="COGNOME">*Cognome</label>
                <input type="text" class="form-control" name="COGNOME" id="COGNOME" placeholder="Cognome" style="width:30%">
            </div>
            <div class="form-group">
                <label for="NOME">*Nome</label>
                <input type="text" class="form-control" name="NOME" id="NOME" placeholder="Nome" style="width:30%">
            </div>
            <div class="form-group">
                <label for="NASCDATA">*Data nascita</label>
                <input type="date" class="form-control" name="NASCDATA" id="NASCDATA" style="width:15%">
            </div>
            <input type="button" name="previous" class="previous btn btn-default" value="Previous" />
            <input type="button" name="next" class="next btn btn-info" value="Next" />
        </fieldset>
        <fieldset>
            <h2>Step 3: Contact Information</h2>
            <div class="form-group">
                <label for="mob">Mobile Number</label>
                <input type="text" class="form-control" id="mob" placeholder="Mobile Number">
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" name="address" placeholder="Communication Address"></textarea>
            </div>
            <input type="button" name="previous" class="previous btn btn-default" value="Previous" />
            <input type="submit" name="submit" class="submit btn btn-success" value="Submit" />
        </fieldset>
    </form>
</div>
<!-- /.container-fluid -->

<?php
/**
 * Path:   application\views\frontend\preiscrizione.php
 * Source: https://www.phpflow.com/php/multi-step-form-using-php-bootstrap-jquery/
 */