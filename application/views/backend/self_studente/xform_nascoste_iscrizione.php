<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'form_nascoste';
?>

<div id="<?php echo $FormNascosteIscrizione['id']; ?>">
<!-- INIZIO MASCHERA POP UP NASCOSTA NUOVA ISCRIZIONE-->
    <div class="modal fade" id="NuovaIscrizione_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Nuova iscrizione</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <?php echo form_open('backend/new_record/iscrizionistudente/' . $tab_studente['MATRICOL']); ?>
                    <div class="row">
                        <div class="col-lg-12 mb-2 mt-2">
                            <div class="row">
                                <div class="col-lg-8 mb-2">
                                    <label for="ANNOACCA">Anno Accademico</label>
                                    <input type="hidden" id="MATRICOL" name="MATRICOL" value="<?php echo $tab_studente['MATRICOL']; ?>" />
                                    <select id="ANNOACCA" name="ANNOACCA" class="form-control" required>
                                        <option value=''></option>
                                        <?php
                                        foreach ($tab_anno_accademico as $key => $value) {
                                            echo "<option  value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                                        }
                                        ?>
                                    </select>  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8 mb-2">
                                    <label for="CATEGORIA">Categoria</label>
                                    <select id="CATEGORIA" name="CATEGORIA" class="form-control" required>
                                        <option value=''></option>
                                        <option value='ORD'>Ordinario</option>
                                        <option value='OSP'>Ospite</option>
                                        <option value='STR'>Straordinario</option>
                                    </select>  
                                </div> 
                            </div> 
                            <div class="row">
                                <div class="col-lg-8 mb-2">
                                    <label for="CORSOLAUREA">Corso di laurea</label>
                                    <select id="CORSOLAUREA" name="CORSOLAUREA" class="form-control">
                                        <option value=''></option>
                                        <?php
                                        foreach ($tab_corsidilaurea as $key => $value) {
                                            echo "<option  value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                                        }
                                        ?>
                                    </select>  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 mb-2">
                                    <label for="ANNOCORSO">Anno di corso</label>
                                    <select id="ANNOCORSO" name="ANNOCORSO" class="form-control" required>
                                        <option value=''></option>
                                        <option value='1'>1</option>
                                        <option value='2'>2</option>
                                    </select>       
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8 mb-2">
                                    <label for="INDIRIZZOLAUREA">Indirizzo di laurea</label>
                                    <select id="INDIRIZZOLAUREA" name="INDIRIZZOLAUREA" class="form-control">
                                        <option value=''></option>
                                        <?php
                                        foreach ($tab_indirizzolaurea as $key => $value) {
                                            echo "<option  value='" . $value['CODICENU'] . "'>" . $value['DECODIFICA'] . "</option>";
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
<!-- FINE MASCHERA POP UP NASCOSTA NUOVA ISCRIZIONE-->

<!-- INIZIO MASCHERA POP UP NASCOSTA MODIFICA/ELIMINAZIONE ISCRIZIONE-->
    <?php foreach ($tab_iscrizioni as $rec) : ?>
        <div class="modal fade" id="ModificaIscrizione_Modal_<?php echo $rec['ANNOACCA']; ?>" role="dialog">
            <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Modifica iscrizione</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <?php echo form_open('backend/edit_record/iscrizionistudente/' . $rec['MATRICOL']); ?>
                        <div class="row">
                            <div class="col-lg-12 mb-2 mt-2">
                                <div class="row">
                                    <div class="col-lg-4 mb-2">
                                        <label for="ANNOACCA">Anno Accademico</label>
                                        <input type="hidden" id="ANNOACCA_old" name="ANNOACCA_old" value="<?php echo $rec['ANNOACCA']; ?>" />
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
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 mb-2">
                                        <label for="CATEGORIA">Categoria</label>
                                        <select id="CATEGORIA" name="CATEGORIA" class="form-control" required>
                                            <option <?php if ($rec['CATEGORIA'] === 'ORD') echo "selected='selected'"; ?> value='ORD'>Ordinario</option>
                                            <option <?php if ($rec['CATEGORIA'] === 'OSP') echo "selected='selected'"; ?> value='OSP'>Ospite</option>
                                            <option <?php if ($rec['CATEGORIA'] === 'STR') echo "selected='selected'"; ?> value='STR'>Straordinario</option>
                                        </select>  
                                    </div> 
                                </div> 
                                <div class="row">
                                    <div class="col-lg-8 mb-2">
                                        <label for="CORSOLAUREA">Corso di laurea</label>
                                        <select id="CORSOLAUREA" name="CORSOLAUREA" class="form-control">
                                            <?php
                                            foreach ($tab_corsidilaurea as $key => $value) {
                                                if ($value['CODICENU'] === $rec['CORSOLAUREA']) {
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
                                    <div class="col-lg-4 mb-2">
                                        <label for="ANNOCORSO">Anno di corso</label>
                                        <select id="ANNOCORSO" name="ANNOCORSO" class="form-control" requered>
                                            <?php
                                            if ($tab_studente['ANNOCORSO'] === '1') {
                                                echo "<option selected='selected' value='1'>1</option>";
                                                echo "<option value='2'>2</option>";
                                            } else {
                                                echo "<option selected='selected' value='2'>2</option>";
                                                echo "<option value='1'>1</option>";
                                            }
                                            ?>                                
                                        </select>       
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8 mb-2">
                                        <label for="INDIRIZZOLAUREA">Indirizzo di laurea</label>
                                        <select id="INDIRIZZOLAUREA" name="INDIRIZZOLAUREA" class="form-control">
                                            <?php
                                            foreach ($tab_indirizzolaurea as $key => $value) {
                                                if ($value['CODICENU'] === $rec['INDIRIZZOLAUREA']) {
                                                    echo "<option selected='selected' value='" . $value['CODICENU'] . "'>" . $value['DECODIFICA'] . "</option>";
                                                } else {
                                                    echo "<option  value='" . $value['CODICENU'] . "'>" . $value['DECODIFICA'] . "</option>";
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
        <?php //endforeach; ?>  
<!-- FINE MASCHERA POP UP NASCOSTA MODIFICA ISCRIZIONE-->
<!-- INIZIO MASCHERA POP UP NASCOSTA PER ELIMINAZIONE RECORD ISCRIZIONE-->
        <?php //foreach ($tab_iscrizioni as $rec) :  ?>
        <div class="modal fade" id="EliminaIscrizione_Modal_<?php echo $rec['ANNOACCA']; ?>" role="dialog">
            <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Eliminazione record</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <?php echo form_open('backend/delete_record/iscrizionistudente/' . $tab_studente['MATRICOL']); ?>
                        <div class="input-group">
                            <input type="hidden" id="ANNOACCA" name="ANNOACCA" value="<?php echo $rec['ANNOACCA']; ?>" />
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
<!-- FINE MASCHERA POP UP NASCOSTA PER MODIFICA/ELIMINAZIONE RECORD ISCRIZIONE-->      
</div>