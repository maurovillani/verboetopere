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

<!-- INIZIO MASCHERA POP UP NASCOSTA NUOVO RECORD-->
<div class="modal fade" id="NuovoRecord_Modal" role="dialog">
    <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Nuovo anno scadenze</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
    <?php echo form_open('backend/new_record/scadenze'); ?>
    <div class="row">
        <div class="col-lg-12 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="ANNOACCADEMICO">Anno accademico</label>
                    <select id="ANNOACCADEMICO" name="ANNOACCADEMICO" class="form-control">
                        <option selected='selected' value=''></option>
                        <?php
                        foreach ($tab_anno_accademico as $key => $value) {
                            echo "<option  value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                        }
                        ?>
                    </select>  
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
<!-- FINE MASCHERA POP UP NASCOSTA NUOVO RECORD-->    

<!-- INIZIO MASCHERA POP UP NASCOSTA DUPLICA RECORD-->
<div class="modal fade" id="DuplicaRecord_Modal" role="dialog">
    <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Duplica date scadenza</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
    <?php echo form_open('backend/new_record/duplicascadenze'); ?>
    <div class="row">
        <div class="col-lg-12 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="ANNOACCADEMICO_OLD">Anno Accademico da duplicare</label>
                    <select id="ANNOACCADEMICO_OLD" name="ANNOACCADEMICO_OLD" class="form-control">
                        <option value=''></option>
                        <?php
                        foreach ($tab_anno_accademico as $key => $value) {
                            if ($value['ANNOACCA']>2019){
                            echo "<option  value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                            }
                        }
                        ?>
                    </select>  
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="ANNOACCADEMICO_NEW">Anno Accademico da creare</label>
                    <select id="ANNOACCADEMICO_NEW" name="ANNOACCADEMICO_NEW" class="form-control">
                        <option value=''></option>
                        <?php
                        foreach ($tab_anno_accademico as $key => $value) {
                            if ($value['ANNOACCA']>2019){
                            echo "<option  value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                            }
                        }
                        ?>
                    </select>  
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
<!-- FINE MASCHERA POP UP NASCOSTA DUPLICA RECORD--> 

</div>