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
                    <?php echo form_open('backend/new_record/iscrizioniselfstudente/' . $tab_studente['MATRICOL']); ?>
                    <div class="row">
                        <div class="col-lg-12 mb-2 mt-2">
                            <div class="row">
                                <div class="col-lg-8 mb-2">
                                    <label for="ANNOACCA">Anno Accademico</label>
                                    <input type="hidden" id="MATRICOL" name="MATRICOL" value="<?php echo $tab_studente['MATRICOL']; ?>" />
                                    <input type="hidden" id="POSISCRIZIONE" name="POSISCRIZIONE" value="7" />
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
<?php if (isset($tab_iscrizioni[0]) && $tab_iscrizioni[0]['TERMINATO']==0):?>
<?php $rec=$tab_iscrizioni[0];?>
<!-- INIZIO MASCHERA POP UP NASCOSTA CONFERMA ISCRIZIONE-->
    <div class="modal fade" id="ConfermaIscrizione_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Conferma iscrizione</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <?php echo form_open('backend/new_record/iscrizioniselfstudentesemestre'); ?>
                    <div class="row">
                        <div class="col-lg-12 mb-2 mt-2">
                            <div class="row">
                                <div class="col-lg-4 mb-2">
                                    <input type="hidden" id="n_record" name="n_record" value="1" />
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
<!-- FINE MASCHERA POP UP NASCOSTA CONFERMA ISCRIZIONE-->
<?php endif;?>
</div>