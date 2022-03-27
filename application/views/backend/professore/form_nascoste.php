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

<!-- INIZIO MASCHERA POP UP NASCOSTA NUOVO PROFESSORE-->
<div class="modal fade" id="NuovoProfessore_Modal" role="dialog">
    <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Nuovo professore</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
    <?php echo form_open('backend/new_record/professore'); ?>
    <div class="row">
        <div class="col-lg-12 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-8 mb-2">
                    <label for="MATRICOL">Matricola</label>
                    <input type="text" class="form-control" id="MATRICOL" name="MATRICOL" value="<?php echo $max_matricola['MAX_MATRICOL']?>" required />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mb-2">
                    <label for="COGNOME">Cognome</label>
                    <input type="text" class="form-control" id="COGNOME" name="COGNOME" value="" required />
                </div> 
            </div> 
            <div class="row">
                <div class="col-lg-8 mb-2">
                    <label for="NOME">Nome</label>
                    <input type="text" class="form-control" id="NOME" name="NOME" value="" required />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mb-2">
                    <label for="SESSO">Sesso</label>
                    <select id="SESSO" name="SESSO" class="form-control" required>
                        <option value=''></option>
                        <option value='M'>M</option>
                        <option value='F'>F</option>
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
<!-- FINE MASCHERA POP UP NASCOSTA NUOVO PROFESSORE-->        
    
<!-- INIZIO MASCHERA POP UP NASCOSTA PER ELIMINAZIONE RECORD-->
  <!-- Modal -->
<div class="modal fade" id="EliminazioneRecord_Modal" role="dialog">
    <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Eliminazione record</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="input-group">
                    <h5>Sei sicuro di voler eliminare questo record?</h5>
                    <div><br/>
                        <?php echo anchor(site_url('backend/delete_record/professore/'.$tab_professore['MATRICOL']), 'Elimina',["class"=>"btn btn-primary"]); ?>
                        &nbsp;
                        &nbsp;<button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
       </div>
    </div>
</div>
<!-- FINE MASCHERA POP UP NASCOSTA PER ELIMINAZIONE RECORD-->      

<!-- INIZIO MASCHERA POP UP NASCOSTA PER CARICAMENTO FOTO-->
  <!-- Modal -->
<div class="modal fade" id="CaricamentoFoto_Modal" role="dialog">
    <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Caricamento foto</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
        <div class="input-group">
        
    <?php //echo $error;?>
    <?php echo form_open_multipart('backend/do_upload/jpg/professors/'.$tab_professore['MATRICOL']);?>
        <input type="file" name="userfile" size="20" />
        <br /><br />
        <input type="submit" value="Carica foto" />
    <?php echo form_close(); ?> </form>                    
        </div>
            
        </div>
       </div>
    </div>
</div>
<!-- FINE MASCHERA POP UP NASCOSTA PER CARICAMENTO FOTO-->   

<!-- INIZIO MASCHERA POP UP NASCOSTA PER CONFERMA SALVATAGGIO RECORD-->
    <div class="modal fade" id="ConfermaSalvataggio_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Attendere Record in Salvataggio</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
    <!-- FINE MASCHERA POP UP NASCOSTA PER ELIMINAZIONE RECORD ISCRIZIONE-->     

</div>