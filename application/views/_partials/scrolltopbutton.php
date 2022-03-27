<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!--<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>-->
                <h5 class="modal-title" id="exampleModalLabel">Sicuro di voler uscire?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <!--<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>-->
            <div class="modal-body">Premi "Logout" se sei sicuro di voler uscire dalla sessione corrente.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Annulla</button>
                <a class="btn btn-primary" href="<?php echo site_url('logout'); ?>">Logout</a>
            </div>
        </div>
    </div>
</div>
