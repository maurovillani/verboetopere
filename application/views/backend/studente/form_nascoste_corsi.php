<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'form_nascoste';
?>

<div id="<?php echo $FormNascosteCorsi['id']; ?>">
<!-- INIZIO MASCHERA POP UP NASCOSTA MODIFICA/ELIMINAZIONE CORSO-->
    <?php foreach ($tab_corsi as $rec) : ?>
        <div class="modal fade" id="ModificaCorso_Modal_<?php echo $rec['CORSI']; ?>" role="dialog">
            <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Modifica corso</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <?php 
                        if ($rec['VOTOESAME']>0)
                            echo form_open('backend/edit_record/esamistudente/' . $rec['MATRICOL']); 
                        else
                            echo form_open('backend/new_record/esamistudente/'); 
                        ?>
                        <div class="row">
                            <div class="col-lg-12 mb-2 mt-2">
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <label for="sigla">CORSO</label>
                                        <input type="text" class="form-control" id="sigla" name="sigla" value="<?php echo $rec['sigla']; ?>" readonly/>
                                        <input type="hidden" id="MATRICOL" name="MATRICOL" value="<?php echo $rec['MATRICOL']; ?>" />
                                   </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <label for="VOTOESAME">Voto</label>
                                        <input type="text" class="form-control" id="VOTOESAME" name="VOTOESAME" value="<?php echo $rec['VOTOESAME']; ?>" />
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
        <!-- ELIMINAZIONE-->
        <div class="modal fade" id="EliminaCorsi_Modal_<?php echo $rec['CORSI']; ?>" role="dialog">
            <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Eliminazione record</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <?php echo form_open('backend/delete_record/pianistudiostudente/' . $tab_studente['MATRICOL']); ?>
                        <div class="input-group">
                            <input type="hidden" id="CORSI" name="CORSI" value="<?php echo $rec['CORSI']; ?>" />
                            <h5>Sei sicuro di voler eliminare questo record?</h5>
                            <div><br/>
                                <button type="submit" class="btn btn-primary">Elimina</button>
                                &nbsp;
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                            </div>    
                        </div>
                        <?php echo form_close(); ?>      
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>  
<!-- FINE MASCHERA POP UP NASCOSTA PER MODIFICA/ELIMINAZIONE RECORD TASSE-->          
</div>