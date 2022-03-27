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
<!-- INIZIO MASCHERA POP UP NASCOSTA NUOVO STUDENTE-->
    <div class="modal fade" id="NuovoStudente_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Nuovo studente</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <?php echo form_open('backend/new_record/studente'); ?>
                    <div class="row">
                        <div class="col-lg-12 mb-2 mt-2">
                            <div class="row">
                                <div class="col-lg-8 mb-2">
                                    <label for="MATRICOL">Matricola</label>
                                    <input type="text" class="form-control" id="MATRICOL" name="MATRICOL" value="<?php echo $max_matricola['MAX_MATRICOL'] ?>" required />
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
                                    <label for="NOMESTUD">Nome</label>
                                    <input type="text" class="form-control" id="NOMESTUD" name="NOMESTUD" value="" required />
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
<!-- FINE MASCHERA POP UP NASCOSTA NUOVO STUDENTE-->    

<!-- INIZIO MASCHERA POP UP NASCOSTA PER ELIMINAZIONE RECORD STUDENTE-->
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
                    <?php echo form_open('backend/delete_record/studente/' . $tab_studente['MATRICOL']); ?>
                    <div class="input-group">
                        <input type="hidden" id="MATRICOL_PREC" name="MATRICOL_PREC" value="<?php echo $tab_pulsanti_scheda[1]['MATRICOL']; ?>" />
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
<!-- FINE MASCHERA POP UP NASCOSTA PER ELIMINAZIONE RECORD STUDENTE-->      

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

<!-- INIZIO MASCHERA POP UP NASCOSTA PER CONFERMA SALVATAGGIO RECORD STUDENTE-->
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
<!-- FINE MASCHERA POP UP NASCOSTA PER SALVATAGGIO RECORD STUDENTE-->          
    
<!-- *************************************************** -->
<!-- TASSE ********************************************* -->    
<!-- *************************************************** -->
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
                                <div class="row">
                                    <div class="col-lg-4 mb-2">
                                        <label for="ANNOCORSO">Anno di corso</label>
                                        <select id="ANNOCORSO" name="ANNOCORSO" class="form-control" requered>
                                            <?php
                                            if ($rec['ANNOCORSO'] === '1') {
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
<!-- FINE MASCHERA POP UP NASCOSTA PER ELIMINAZIONE RECORD TASSE-->    

<!-- *************************************************** -->
<!-- TITOLO ACCADEMICO ********************************* -->    
<!-- *************************************************** -->
<!-- INIZIO MASCHERA POP UP NASCOSTA MODIFICA/ELIMINAZIONE TITOLO ACCADEMICO-->
    <?php foreach ($tab_titoli_accademici as $rec) : ?>
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
                        <?php echo form_open('backend/edit_record/titolistudente/' . $rec['TIPTITST']); ?>
                        <div class="row">
                            <div class="col-lg-12 mb-2 mt-2">
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <label for="TIPTITST">Corso di laurea</label>
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
                                    <div class="col-lg-6 mb-2">
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
                                        <label for="DATA_SANATIO">Data satatio</label>
                                        <input type="date" class="form-control" id="DATA_SANATIO" name="DATA_SANATIO" value="<?php echo substr($rec['DATA_SANATIO'], 0, 10); ?>" required />
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
                        <?php echo form_open('backend/delete_record/titolistudente/' . $tab_studente['MATRICOL']); ?>
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
                    <?php echo form_open('backend/new_record/titolistudente/' . $tab_studente['MATRICOL']); ?>
                    <div class="row">
                        <div class="col-lg-12 mb-2 mt-2">
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <label for="TIPTITST">Corso di laurea</label>
                                    <input type="hidden" id="MATRICOL" name="MATRICOL" value="<?php echo $tab_studente['MATRICOL']; ?>" />
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
                                <div class="col-lg-6 mb-2">
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
                                    <label for="DATA_SANATIO">Data satatio</label>
                                    <input type="date" class="form-control" id="DATA_SANATIO" name="DATA_SANATIO" value="" required />
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

<!-- *************************************************** -->
<!-- ISCRIZIONE **************************************** -->
<!-- *************************************************** -->
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