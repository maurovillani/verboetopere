<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'form_nascoste';
?>

<div id="<?php echo $FormNascosteTasse['id']; ?>">
<!-- INIZIO MASCHERA POP UP NASCOSTA NUOVA TASSA-->
    <div class="modal fade" id="NuovaTassa_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Nuovo pagamento tassa</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <?php echo form_open('backend/new_record/tassestudente/' . $tab_studente['MATRICOL']); ?>
                    <div class="row">
                        <div class="col-lg-12 mb-2 mt-2">
                            <div class="row">
                                <div class="col-lg-6 mb-2">
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
                                <div class="col-lg-10 mb-2">
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
<!--                            <div class="row">
                                <div class="col-lg-4 mb-2">
                                    <label for="ANNOCORSO">Anno di corso</label>
                                    <select id="ANNOCORSO" name="ANNOCORSO" class="form-control" required>
                                        <option value=''></option>
                                        <option value='1'>1</option>
                                        <option value='2'>2</option>
                                    </select>       
                                </div>
                            </div>-->
                            <div class="row">
                                <div class="col-lg-10 mb-2">
                                    <label for="CAUSALETASSE">Causale Tassa</label>
                                    <select id="CAUSALETASSE" name="CAUSALETASSE" class="form-control">
                                        <option value=''></option>
                                        <?php
                                        foreach ($tab_causaletassa as $key => $value) {
                                            echo "<option  value='" . $value['CODICECAUSALE'] . "'>" . $value['DECODIFICA'] . "</option>";
                                        }
                                        ?>
                                    </select>  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <label for="DATAPAGAMENTO">Data pagamento</label>
                                    <input type="date" class="form-control" id="DATAPAGAMENTO" name="DATAPAGAMENTO" value=""/>
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <label for="IMPPAGATO">Importo</label>
                                        <input type="text" class="form-control" id="IMPPAGATO" name="IMPPAGATO" value="" />
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
<!-- FINE MASCHERA POP UP NASCOSTA NUOVA TASSA-->

<!-- INIZIO MASCHERA POP UP NASCOSTA MODIFICA/ELIMINAZIONE TASSA-->
    <?php foreach ($tab_tasse as $rec) : ?>
        <div class="modal fade" id="ModificaTassa_Modal_<?php echo $rec['CODICETASSAPAGATA']; ?>" role="dialog">
            <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Modifica tassa</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <?php echo form_open('backend/edit_record/tassestudente/' . $rec['CODICETASSAPAGATA']); ?>
                        <div class="row">
                            <div class="col-lg-12 mb-2 mt-2">
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <label for="ANNOACCA">Anno Accademico</label>
                                        <input type="hidden" id="MATRICOL" name="MATRICOL" value="<?php echo $tab_studente['MATRICOL']; ?>" />
                                        <select id="ANNOACCA" name="ANNOACCA" class="form-control" required>
                                            <?php
                                            foreach ($tab_anno_accademico as $key => $value) {
                                                if ($value['ANNOACCA'] === $rec['ANNOACCADEMICO']) {
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
                                    <div class="col-lg-10 mb-2">
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
<!--                                <div class="row">
                                    <div class="col-lg-4 mb-2">
                                        <label for="ANNOCORSO">Anno di corso</label>
                                        <select id="ANNOCORSO" name="ANNOCORSO" class="form-control" requered>
                                            <?php
//                                            if ($rec['ANNOCORSO'] === '1') {
//                                                echo "<option selected='selected' value='1'>1</option>";
//                                                echo "<option value='2'>2</option>";
//                                            } else {
//                                                echo "<option selected='selected' value='2'>2</option>";
//                                                echo "<option value='1'>1</option>";
//                                            }
                                            ?>                                
                                        </select>       
                                    </div>
                                </div>-->
                                <div class="row">
                                    <div class="col-lg-10 mb-2">
                                        <label for="CAUSALETASSE">Causale tassa</label>
                                        <select id="CAUSALETASSE" name="CAUSALETASSE" class="form-control">
                                            <?php
                                            foreach ($tab_causaletassa as $key => $value) {
                                                if ($value['CODICECAUSALE'] === $rec['CAUSALETASSA']) {
                                                    echo "<option selected='selected' value='" . $value['CODICECAUSALE'] . "'>" . $value['DECODIFICA'] . "</option>";
                                                } else {
                                                    echo "<option  value='" . $value['CODICECAUSALE'] . "'>" . $value['DECODIFICA'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>  
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <label for="DATAPAGAMENTO">Data pagamento</label>
                                        <input type="date" class="form-control" id="DATAPAGAMENTO" name="DATAPAGAMENTO" value="<?php echo substr($rec['DATAPAGAMENTO'], 0, 10); ?>"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <label for="IMPPAGATO">Importo</label>
                                        <input type="text" class="form-control" id="IMPPAGATO" name="IMPPAGATO" value="<?php echo $rec['IMPPAGATO']; ?>" />
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
<!-- FINE MASCHERA POP UP NASCOSTA MODIFICA TASSE-->
<!-- INIZIO MASCHERA POP UP NASCOSTA PER ELIMINAZIONE RECORD TASSE-->
        <?php //foreach ($tab_iscrizioni as $rec) :  ?>
        <div class="modal fade" id="EliminaTassa_Modal_<?php echo $rec['CODICETASSAPAGATA']; ?>" role="dialog">
            <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Eliminazione record</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <?php echo form_open('backend/delete_record/tassestudente/' . $tab_studente['MATRICOL']); ?>
                        <div class="input-group">
                            <input type="hidden" id="CODICETASSAPAGATA" name="CODICETASSAPAGATA" value="<?php echo $rec['CODICETASSAPAGATA']; ?>" />
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