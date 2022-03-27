<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'form_nascoste';
?>

<div id="<?php echo $FormNascosteTitoliAccademici['id']; ?>">
<!-- INIZIO MASCHERA POP UP NASCOSTA MODIFICA/ELIMINAZIONE TITOLO ACCADEMICO-->
    <?php 
    foreach ($tab_titoli_accademici as $rec) : ?>
        <div class="modal fade" id="ModificaTitoloAccademico_Modal_<?php echo $rec['TIPTITST']; ?>" role="dialog">
            <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Modifica titolo accademico</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <?php echo form_open('backend/edit_record/titolistudente_preiscrizione/' . $rec['ID']); ?>
                        <div class="row">
                            <div class="col-lg-12 mb-2 mt-2">
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <label for="TIPTITST">Titolo di studio</label>
                                        <select id="TIPTITST" name="TIPTITST" class="form-control" required>
                                            <?php
                                            foreach ($tab_tipotitolosup as $key => $value) {
                                                if ($value['CODICENU'] === $rec['TIPTITST']) {
                                                    echo "<option selected='selected' value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                                                } else {
                                                    echo "<option  value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>  
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <label for="ANNOACCA">Anno Conseguimento</label>
                                        <select id="ANNOACCA" name="ANNOACCA" class="form-control" required>
                                            <?php
                                            foreach ($tab_anno_accademico as $key => $value) {
                                                if ($value['ANNOACCA'] === $rec['ANNOACCA']) {
                                                    echo "<option selected='selected' value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                                                } else {
                                                    echo "<option  value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>  
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <label for="VOTAZIONE">Votazione</label>
                                        <input type="text" class="form-control" id="VOTAZIONE" name="VOTAZIONE" autocomplete="off" value="<?php echo $rec['VOTAZIONE']; ?>" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <label for="QUALIFICA">Qualifica</label>
                                        <input type="text" class="form-control" id="QUALIFICA" name="QUALIFICA" autocomplete="off" value="<?php echo $rec['QUALIFICA']; ?>" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <label for="ISTISUPE">Università</label>
                                        <select id="ISTISUPE" name="ISTISUPE" class="form-control" required>
                                            <?php
                                            foreach ($tab_universitatrasf as $key => $value) {
                                                if ($value['CODICENU'] === $rec['ISTISUPE']) {
                                                    echo "<option selected='selected' value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                                                } else {
                                                    echo "<option  value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>  
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <label for="TIPDOCAL">Documento</label>
                                        <select id="ISTISUPE" name="TIPDOCAL" class="form-control" required>
                                            <?php
                                            foreach ($tab_tipodocumentazione as $key => $value) {
                                                if ($value['CODICENU'] === $rec['TIPDOCAL']) {
                                                    echo "<option selected='selected' value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                                                } else {
                                                    echo "<option  value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>  
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <label for="NOTA">Nota</label>
                                        <input type="text" class="form-control" id="NOTA" name="NOTA" autocomplete="off" value="<?php echo $rec['NOTA']; ?>" />
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
        <?php //endforeach; ?>  
<!-- FINE MASCHERA POP UP NASCOSTA MODIFICA TITOLO ACCADEMICO-->
<!-- INIZIO MASCHERA POP UP NASCOSTA PER ELIMINAZIONE RECORD TITOLO ACCADEMICO-->
        <?php //foreach ($tab_titoli_accademici as $rec) :  ?>
        <div class="modal fade" id="EliminaTitoloAccademico_Modal_<?php echo $rec['TIPTITST']; ?>" role="dialog">
            <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Eliminazione record</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <?php echo form_open('backend/delete_record/titolistudente_preiscrizione/' . $tab_studente['ID']); ?>
                        <div class="input-group">
                            <input type="hidden" id="TIPTITST" name="TIPTITST" value="<?php echo $rec['TIPTITST']; ?>" />
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
<!-- FINE MASCHERA POP UP NASCOSTA PER MODIFICA/ELIMINAZIONE RECORD TITOLO ACCADEMICO-->      

<!-- INIZIO MASCHERA POP UP NASCOSTA NUOVO TITOLO ACCADEMICO-->
    <div class="modal fade" id="NuovoTitoloAccademico_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Nuovo titolo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <?php echo form_open('backend/new_record/titolistudente_preiscrizione/' . $tab_studente['ID']); ?>
                    <div class="row">
                        <div class="col-lg-12 mb-2 mt-2">
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <label for="TIPTITST">Titolo di studio</label>
                                    <input type="hidden" id="ID" name="ID" value="<?php echo $tab_studente['ID']; ?>" />
                                    <select id="TIPTITST" name="TIPTITST" class="form-control" required>
                                        <option value=''></option>
                                        <?php
                                        foreach ($tab_tipotitolosup as $key => $value) {
                                            echo "<option  value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                                        }
                                        ?>
                                    </select>  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <label for="ANNOACCA">Anno Conseguimento</label>
                                    <select id="ANNOACCA" name="ANNOACCA" class="form-control" required>
                                        <option value=''></option>
                                        <?php
                                        foreach ($tab_anno_accademico as $key => $value) {
                                            echo "<option  value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                                        }
                                        ?>
                                    </select>  
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label for="VOTAZIONE">Votazione</label>
                                    <input type="text" class="form-control" id="VOTAZIONE" name="VOTAZIONE" autocomplete="off" value="" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <label for="QUALIFICA">Qualifica</label>
                                    <input type="text" class="form-control" id="QUALIFICA" name="QUALIFICA" autocomplete="off" value="" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <label for="ISTISUPE">Università</label>
                                    <select id="ISTISUPE" name="ISTISUPE" class="form-control" required>
                                        <option value=''></option>
                                        <?php
                                        foreach ($tab_universitatrasf as $key => $value) {
                                            echo "<option  value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                                        }
                                        ?>
                                    </select>  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <label for="TIPDOCAL">Documento</label>
                                    <select id="ISTISUPE" name="TIPDOCAL" class="form-control" required>
                                        <option value=''></option>
                                        <?php
                                        foreach ($tab_tipodocumentazione as $key => $value) {
                                            echo "<option  value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                                        }
                                        ?>
                                    </select>  
                                </div>
                                <div class="col-lg-6 mb-2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <label for="NOTA">Nota</label>
                                    <input type="text" class="form-control" id="NOTA" name="NOTA" autocomplete="off" value="" />
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
<!-- FINE MASCHERA POP UP NASCOSTA NUOVO TITOLO ACCADEMICO-->
</div>