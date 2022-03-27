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
<!-- INIZIO MASCHERA POP UP NASCOSTA PER CARICAMENTO FOTO-->
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
                        <?php echo form_open_multipart('backend/do_upload/jpg/students/' . $tab_studente['MATRICOL']); ?>
                        <input type="file" name="userfile" size="20" />
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Carica foto" />
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
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