<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'form_nascoste';
?>
<script>
function VisualizzaIndirizzoLaurea() {
  document.getElementById('subordinato').style.visibility = 'hidden';     
  var corso_laurea = document.getElementById('CORSOLAUREA_NEW').value;
  if (corso_laurea==210){
      document.getElementById('subordinato').style.visibility = 'visible';     
  } else {
      document.getElementById('subordinato').style.visibility = 'hidden';     
  }
} 
</script>
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
//                                            echo "<option  value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                                            if ($value['ANNOACCA'] === $parametri['ANNOACCA']) {
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
                                    <label for="SEMESTREACCA">Semestre Accademico</label>
                                    <select id="SEMESTREACCA" name="SEMESTREACCA" class="form-control" required>
                                        <?php
                                        if ($parametri['SEMESTRE'] === '1') {
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
                                <div class="col-lg-12 mb-2">
                                    <label for="CORSOLAUREA">Tipo iscrizione</label>
                                    <select id="CORSOLAUREA_NEW" name="CORSOLAUREA" class="form-control" onchange="VisualizzaIndirizzoLaurea()">
                                        <option value=''></option>
                                        <?php
                                        foreach ($tab_corsidilaurea as $key => $value) {
                                            echo "<option  value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                                        }
                                        ?>
                                    </select>  
                                </div>
                            </div>
                            <div class="row" style="visibility:hidden" id="subordinato">
                               <div class="col-lg-12 mb-2">
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
                                    <label for="NOTA">Note</label>
                                    <textarea class="form-control" rows="2" id="NOTA" name="NOTA"></textarea>
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

<!-- INIZIO MASCHERA POP UP NASCOSTA MODIFICA/ELIMINAZIONE/DUPLICA ISCRIZIONE-->
    <?php $n=0; ?>
    <?php foreach ($tab_iscrizioni as $rec) : ?>
    <?php $n=$n+1; ?>
        <div class="modal fade" id="ModificaIscrizione_Modal_<?php echo $rec['id_iscrizione']; ?>" role="dialog">
            <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Modifica iscrizione</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <?php echo form_open('backend/edit_record/iscrizionistudente/' . $rec['id_iscrizione']); ?>
                        <div class="row">
                            <div class="col-lg-12 mb-2 mt-2">
                                <div class="row">
                                    <div class="col-lg-4 mb-2">
                                        <input type="hidden" id="MATRICOL" name="MATRICOL" value="<?php echo $rec['MATRICOL']; ?>" />
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
                                        <label for="SEMESTREACCA">Semestre Accademico</label>
                                        <select id="SEMESTREACCA" name="SEMESTREACCA" class="form-control" requered>
                                            <?php
                                            if ($rec['SEMESTREACCA'] === '1') {
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
                                    <div class="col-lg-12 mb-2">
                                        <label for="CORSOLAUREA">Tipo iscrizione</label>
                                        <input type="hidden" id="CORSOLAUREA" name="CORSOLAUREA" value="<?php echo $rec['CORSOLAUREA']; ?>" />
                                        <input type="text" class="form-control" value="<?php echo $rec['CORSO_LAUREA']; ?>" readonly/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 mb-2">
                                        <label for="SEMESTRECORSO">Semestre di corso</label>
                                        <input type="text" class="form-control" id="SEMESTRECORSO" name="SEMESTRECORSO" value="<?php echo $rec['SEMESTRECORSO']; ?>" required />
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <label for="CORSOCONFERMA">Sem. Corso confermato</label>
                                        <select id="CORSOCONFERMA" name="CORSOCONFERMA" class="form-control" requered>
                                            <?php
                                            if ($rec['CORSOCONFERMA'] === '1') {
                                                echo "<option selected='selected' value='1'>SI</option>";
                                                echo "<option value='0'>Calcolato in base agli esami</option>";
                                            } else {
                                                echo "<option selected='selected' value='0'>NO</option>";
                                                echo "<option value='1'>Forzato dalla segreteria</option>";
                                            }
                                            ?>                                
                                        </select>       
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <?php if($rec['CORSOLAUREA']=='210'):?>
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
                                        <?php else:?>
                                        <input type="hidden" id="INDIRIZZOLAUREA" name="INDIRIZZOLAUREA" value="" />
                                        <?php endif;?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <label for="NOTA">Note</label>
                                        <textarea class="form-control" rows="2" id="NOTA" name="NOTA"><?php echo $rec['NOTA']; ?></textarea>
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
<!-- FINE MASCHERA POP UP NASCOSTA MODIFICA ISCRIZIONE-->
<!-- INIZIO MASCHERA POP UP NASCOSTA PER ELIMINAZIONE RECORD ISCRIZIONE-->
        <?php //foreach ($tab_iscrizioni as $rec) :  ?>
        <div class="modal fade" id="EliminaIscrizione_Modal_<?php echo $rec['id_iscrizione']; ?>" role="dialog">
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
                            <input type="hidden" id="id_iscrizione" name="id_iscrizione" value="<?php echo $rec['id_iscrizione']; ?>" />
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
<!-- INIZIO MASCHERA POP UP NASCOSTA PER DUPLICAZIONE RECORD ISCRIZIONE-->
        <div class="modal fade" id="DividiIscrizione_Modal_<?php echo $rec['id_iscrizione']; ?>" role="dialog">
            <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Genera semestre successivo</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <?php echo form_open('backend/new_record/iscrizionisemestre'); ?>
                        <div class="row">
                            <div class="col-lg-12 mb-2 mt-2">
                                <div class="row">
                                    <div class="col-lg-4 mb-2">
                                        <input type="hidden" id="n_record" name="n_record" value="<?php echo $n; ?>" />
                                        <input type="hidden" id="id_iscrizione" name="id_iscrizione" value="<?php echo $rec['id_iscrizione']; ?>" />
                                        <input type="hidden" id="MATRICOL" name="MATRICOL" value="<?php echo $rec['MATRICOL']; ?>" />
                                        <?php
                                            if ($rec['SEMESTREACCA']=='1'){
                                                $ANNOACCA = $rec['ANNOACCA'];
                                                $SEMESTREACCA = '2';
                                            }else{
                                                $ANNOACCA = strval(intval($rec['ANNOACCA']) + 1 );
                                                $SEMESTREACCA = '1';
                                            }  
                                            $SEMESTRECORSO=$rec['SEMESTRECORSO'];
                                            if ($rec['CORSOLAUREA']=='230'){
                                                $SEMESTRECORSO = strval(intval($rec['SEMESTRECORSO']) + 1 );
                                            }
                                            if ($rec['CORSOLAUREA']=='210'){
                                                if (intval($rec['NESAMI'])>1){
                                                    $SEMESTRECORSO = strval(intval($rec['SEMESTRECORSO']) + 1 );
                                                }elseif ($rec['SEMESTRECORSO']=='0'){
                                                    $SEMESTRECORSO='1';
                                                }else{
                                                    $SEMESTRECORSO=strval(intval($rec['SEMESTRECORSO']) + 1 );
                                                }
                                            }
                                        ?>
                                        
                                        <label for="ANNOACCA">Anno Accademico</label>
                                        <select id="ANNOACCA" name="ANNOACCA" class="form-control" required>
                                            <?php
                                            foreach ($tab_anno_accademico as $key => $value) {
                                                if ($value['ANNOACCA'] === $ANNOACCA) {
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
                                        <label for="SEMESTREACCA">Semestre Accademico</label>
                                        <select id="SEMESTREACCA" name="SEMESTREACCA" class="form-control" requered>
                                            <?php
                                            if ($SEMESTREACCA === '1') {
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
                                    <div class="col-lg-12 mb-2">
                                        <label for="CORSOLAUREA">Tipo iscrizione</label>
                                        <input type="hidden" id="CORSOLAUREA" name="CORSOLAUREA" value="<?php echo $rec['CORSOLAUREA']; ?>" />
                                        <input type="text" class="form-control "value="<?php echo $rec['CORSO_LAUREA']; ?>" readonly/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 mb-2">
                                        <label for="SEMESTRECORSO">Semestre di corso</label>
                                        <input type="text" class="form-control" id="SEMESTRECORSO" name="SEMESTRECORSO" value="<?php echo $SEMESTRECORSO; ?>" required />
                                    </div>
                                    <div class="col-lg-8 mb-2">
                                        <input type="hidden" id="CORSOCONFERMA" name="CORSOCONFERMA" value="0" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8 mb-2">
                                        <?php if($rec['CORSOLAUREA']=='210'):?>
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
                                        <?php else:?>
                                        <input type="hidden" id="INDIRIZZOLAUREA" name="INDIRIZZOLAUREA" value="" />
                                        <?php endif;?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <label for="NOTA">Note</label>
                                        <textarea class="form-control" rows="2" id="NOTA" name="NOTA"><?php echo $rec['NOTA']; ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <!--DIV PER SPAZIATURA DAL PULSANTE-->
                                    </div>
                                </div>    
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <button type="submit" class="btn btn-primary">Crea</button>
                                        &nbsp;
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>      
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>  
<!-- FINE MASCHERA POP UP NASCOSTA PER MODIFICA/ELIMINAZIONE RECORD ISCRIZIONE--> 
<!-- INIZIO MASCHERA POP UP NASCOSTA ESAMI DI LAUREA-->
    <?php foreach ($tab_esamidilaurea as $rec) : ?>
        <div class="modal fade" id="EsamiLaurea_Modal_<?php echo $rec['CORSOLAUREA']; ?>" role="dialog">
            <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Esame di Laurea</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <?php echo form_open('backend/edit_record/esamedilaurea/' . $rec['MATRICOL']); ?>
                        <div class="row">
                            <div class="col-lg-12 mb-2 mt-2">
                                <div class="row">
                                    <div class="col-lg-4 mb-2">
                                        <?php if($rec['CORSOLAU']==$rec['CORSOLAUREA']):?>
                                            <input type="hidden" id="AZIONE" name="AZIONE" value="edit" />
                                            <?php else:?>
                                            <input type="hidden" id="AZIONE" name="AZIONE" value="new" />
                                            <?php endif;?>
                                        <input type="hidden" id="MATRICOL" name="MATRICOL" value="<?php echo $rec['MATRICOL']; ?>" />
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
<!--                                </div>
                                <div class="row">-->
                                    <div class="col-lg-4 mb-2">
                                        <label for="SESSIONE">Sessione</label>
                                        <select id="SESSIONE" name="SESSIONE" class="form-control" requered>
                                            <?php
                                            if ($rec['SESSIONE'] == NULL) {
                                                echo "<option value='null'></option>";
                                                echo "<option value='1'>1</option>";
                                                echo "<option value='2'>2</option>";
                                                echo "<option value='3'>3</option>";
                                                echo "<option value='4'>4</option>";
                                            }elseif ($rec['SESSIONE'] === '1') {
                                                echo "<option selected='selected' value='1'>1</option>";
                                                echo "<option value='2'>2</option>";
                                                echo "<option value='3'>3</option>";
                                                echo "<option value='4'>4</option>";
                                                echo "<option value='null'></option>";
                                            } elseif ($rec['SESSIONE'] === '2') {
                                                echo "<option value='1'>1</option>";
                                                echo "<option selected='selected' value='2'>2</option>";
                                                echo "<option value='3'>3</option>";
                                                echo "<option value='4'>4</option>";
                                                echo "<option value='null'></option>";
                                            } elseif ($rec['SESSIONE'] === '3') {
                                                echo "<option value='1'>1</option>";
                                                echo "<option value='2'>2</option>";
                                                echo "<option selected='selected' value='3'>3</option>";
                                                echo "<option value='4'>4</option>";
                                                echo "<option value='null'></option>";
                                            } elseif ($rec['SESSIONE'] === '4') {
                                                echo "<option value='1'>1</option>";
                                                echo "<option value='2'>2</option>";
                                                echo "<option value='3'>3</option>";
                                                echo "<option selected='selected' value='4'>4</option>";
                                                echo "<option value='null'></option>";
                                            }
                                            ?>                                
                                        </select>       
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <label for="CORSOLAU">Tipo iscrizione</label>
                                        <input type="hidden" id="CORSOLAU" name="CORSOLAU" value="<?php echo $rec['CORSOLAUREA']; ?>" />
                                        <input type="text" class="form-control" value="<?php echo $rec['CORSO_LAUREA']; ?>" readonly/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <?php if($rec['CORSOLAUREA']=='210'):?>
                                        <label for="INDIRIZZOLAUREA">Indirizzo di laurea</label>
                                        <input type="hidden" id="INDIRIZZOLAUREA" name="INDIRIZZOLAUREA" value="<?php echo $tab_indirizzolicenza['CODICENU']; ?>" />
                                        <input type="text" class="form-control" value="<?php echo $tab_indirizzolicenza['INDIRIZZO_LAUREA']; ?>" readonly/>
                                        <?php else:?>
                                        <input type="hidden" id="INDIRIZZOLAUREA" name="INDIRIZZOLAUREA" value="" />
                                        <?php endif;?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <label for="DATAESAME">Data esame</label>
                                        <input type="date" class="form-control" id="DATAESAME" name="DATAESAME" value="<?php echo substr($rec['DATAESAME'], 0, 10); ?>"  />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 mb-2">
                                        <label for="VOTOESAME">Voto esame</label>
                                        <input type="text" class="form-control" id="VOTOESAME" name="VOTOESAME" value="<?php echo $rec['VOTOESAME']; ?>"  />
                                    </div>
<!--                                </div>
                                <div class="row">-->
                                    <div class="col-lg-4 mb-2">
                                        <label for="votodifesa">Voto difesa</label>
                                        <input type="text" class="form-control" id="votodifesa" name="votodifesa" value="<?php echo $rec['votodifesa']; ?>"  />
                                    </div>
<!--                                </div>
                                <div class="row">-->
                                    <div class="col-lg-4 mb-2">
                                        <label for="vototesi">Voto tesi</label>
                                        <input type="text" class="form-control" id="vototesi" name="vototesi" value="<?php echo $rec['vototesi']; ?>"  />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <label for="QUALIFICA">Qualifica</label>
                                        <input type="text" class="form-control" id="QUALIFICA" name="QUALIFICA" value="<?php echo $rec['QUALIFICA']; ?>" required />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <label for="NOTE">Note</label>
                                        <textarea class="form-control" rows="2" id="NOTE" name="NOTE"><?php echo $rec['NOTE']; ?></textarea>
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
    <?php endforeach; ?>  
<!-- FINE MASCHERA POP UP NASCOSTA PER ESAMI DI LAUREA-->   

</div>