<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'form_nascoste';
?>

<div id="<?php echo $FormNascoste['id']; ?>">
    
<!-- INIZIO MASCHERA POP UP NASCOSTA NUOVO COLLEGIO-->
<div class="modal fade" id="NuovoRecord_Modal" role="dialog">
    <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Nuovo collegio</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
    <?php echo form_open('backend/new_record/collegio'); ?>
    <div class="row">
        <div class="col-lg-12 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-10 mb-2">
                    <label for="COLLEGIO">Nome Collegio</label>
                    <input type="text" class="form-control" id="COLLEGIO" name="COLLEGIO" autocomplete="off" value="" />
                    <input type="hidden" id="CODICE" name="CODICE" value="<?php echo $max_codice['MAX']; ?>" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 mb-2">
                    <label for="codice_pug">Codice pug</label>
                    <input type="text" class="form-control" id="codice_pug" name="codice_pug" autocomplete="off" value="" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                <!--DIV PER SPAZIATURA DAL PULSANTE-->
                </div>
            </div>    
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <button type="submit" class="btn btn-primary">Salva</button>
                    &nbsp;
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>
     <?php echo form_close(); ?>                   
<!-- fine -->                
            </div>
        </div>
    </div>
</div>
<!-- FINE MASCHERA POP UP NASCOSTA NUOVO COLLEGIO-->    

</div>