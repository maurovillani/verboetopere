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
<!-- INIZIO MASCHERA POP UP SCELTA TIPO PAGAMENTO TASSA-->
    <div class="modal fade" id="SceltaPagamento_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo $specchietto_corso; ?></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <h4><b><?php echo $specchietto_titolo; ?></b></h4>
                    <?php echo form_open('backend/new_record/tasseselfstudente/' . $tab_studente['MATRICOL']); ?>
                    <div class="row">
                        <div class="col-lg-12 mb-2 mt-2">
                            <?php foreach ($specchietto as $riga) : ?>                    
                            <div class="row">
                                <div class="col-lg-1 mb-2">
                                    <?php echo " - ";?>
                                </div>
                                <div class="col-lg-3 mb-2">
                                    <label><?php echo $riga['tipo'].' da'; ?></label>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <label><?php echo 'Euro '.$riga['importo']; ?></label>
                                </div>
                            </div>
                            <?php endforeach; ?> 
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <!--<p><b>N.B.</b></p>-->
                                    <p><?php echo $specchietto_nota1; ?></p>
                                    <p><?php echo $specchietto_nota2; ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <label for="CAUSALETASSE"><b>Scelta modalità pagamento</b></label>
                                </div>
                                <div class="col-lg-5 mb-2">
                                    <select id="CAUSALETASSE" name="CAUSALETASSE" class="form-control" required>
                                        <option value=''></option>
                                        <option value='<?php echo $specchietto[0]['causale_tassa']; ?>'><?php echo $specchietto[0]['tipo']; ?></option>
                                        <option value='<?php echo $specchietto[1]['causale_tassa']; ?>'><?php echo $specchietto[1]['tipo']; ?></option>
                                    </select>       
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <label for="DATAPAGAMENTO"><b>Data presunta di pagamento</b></label>
                                </div>
                                <div class="col-lg-5 mb-2">
                                    <input type="date" class="form-control" id="DATAPAGAMENTO" name="DATAPAGAMENTO" value="" required/>
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
                    <input type="hidden" id="MATRICOL" name="MATRICOL" value="<?php echo $tab_studente['MATRICOL']; ?>" />
                    <input type="hidden" id="CORSODILAUREA" name="CORSODILAUREA" value="<?php echo $tassa_attiva['CORSODILAUREA']; ?>" />
                    <input type="hidden" id="CODICETASSAPAGATA" name="CODICETASSAPAGATA" value="<?php echo $tassa_attiva['CODICETASSAPAGATA']; ?>" />
                    <input type="hidden" id="ANNOACCADEMICO" name="ANNOACCADEMICO" value="<?php echo $tassa_attiva['ANNOACCADEMICO']; ?>" />
                    <!--<input type="hidden" id="ANNOCORSO" name="ANNOCORSO" value="<?php //echo $tassa_attiva['ANNOCORSO']; ?>" />-->
                    <input type="hidden" id="PAGANTICIPATO" name="PAGANTICIPATO" value="<?php echo $tassa_attiva['PAGANTICIPATO']; ?>" />
                    <input type="hidden" id="PAGAMENTO" name="PAGAMENTO" value="<?php echo $tassa_attiva['PAGAMENTO']; ?>" />
                    <input type="hidden" id="PENALE" name="PENALE" value="<?php echo $tassa_attiva['PENALE']; ?>" />
                    <input type="hidden" id="SCONTO" name="SCONTO" value="<?php echo $tassa_attiva['SCONTO']; ?>" />
                    <?php echo form_close(); ?>                   
                    <!-- fine -->                
                </div>
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA SCELTA TIPO PAGAMENTO-->
</div>