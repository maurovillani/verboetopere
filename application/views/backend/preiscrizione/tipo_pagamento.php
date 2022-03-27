<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'ordinario_religioso';
$classe_tab='tab-pane fade';
if($_SESSION['tab_attivo_studente']==='tab4') $classe_tab .='  fade  show active';
?>
<div class="<?php echo $classe_tab; ?>" id="<?php echo $tab4['id'] ?>" role="tabpanel" aria-labelledby="<?php echo $tab4['id'] ?>-tab">
    <div class="row">
        <div class="col-lg-6 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="PAGAMENTOMOD">Scelta modalità pagamento *</label>
                    <select id="PAGAMENTOMOD" name="PAGAMENTOMOD" class="form-control" required>
                        <option value=''></option>
                        <option <?php if ($tab_iscrizioni[0]['PAGAMENTOMOD'] === '1') echo "selected='selected'"; ?> value='<?php echo $specchietto[0]['causale_tassa']; ?>'><?php echo $specchietto[0]['tipo']; ?></option>
                        <?php if (isset($specchietto[1]['causale_tassa'])): ?>
                        <option <?php if ($tab_iscrizioni[0]['PAGAMENTOMOD'] === '2') echo "selected='selected'"; ?> value='<?php echo $specchietto[1]['causale_tassa']; ?>'><?php echo $specchietto[1]['tipo']; ?></option>
                        <?php endif; ?>
                    </select>       
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="PAGAMENTODATA">Intendo pagare entro *</label>
                    <!--<input type="text" class="form-control" id="PAGAMENTODATA" name="PAGAMENTODATA" value="<?php echo $tab_iscrizioni[0]['PAGAMENTODATA'];?>" placeholder="aaaa-mm-gg">-->
                    <select id="PAGAMENTODATA" name="PAGAMENTODATA" class="form-control" required>
                        <option value=''></option>
                        <option <?php if ($tab_iscrizioni[0]['PAGAMENTODATA'] === $data_pagamento[0]['valore']) echo "selected='selected'"; ?> value='<?php echo $data_pagamento[0]['valore']; ?>'><?php echo $data_pagamento[0]['etichetta']; ?></option>
                        <?php if (isset($data_pagamento[1]['valore'])): ?>
                        <option <?php if ($tab_iscrizioni[0]['PAGAMENTODATA']=== $data_pagamento[1]['valore']) echo "selected='selected'"; ?> value='<?php echo $data_pagamento[1]['valore']; ?>'><?php echo $data_pagamento[1]['etichetta']; ?></option>
                        <?php endif; ?>
                    </select>       
                </div>
            </div>                
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="NOME_PAGANTE">Nome pagante <i>(se diverso da chi si iscrive)</i></label>
                    <input type="text" class="form-control" id="NOME_PAGANTE" name="NOME_PAGANTE" value="<?php echo $tab_iscrizioni[0]['NOME_PAGANTE'];?>">

                </div>
            </div>                
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="EMAIL_PAGANTE">Email pagante <i>(se diverso da chi si iscrive)</i></label>
                    <input type="text" class="form-control" id="EMAIL_PAGANTE" name="EMAIL_PAGANTE" value="<?php echo $tab_iscrizioni[0]['EMAIL_PAGANTE'];?>">

                </div>
            </div>                
            <div class="row">
                <div class="col-lg-9 mb-2">
                    <label for="DETRAZIONE_FISCALE">Si richiede la detrazione fiscale</label>
                </div>    
                <div class="col-lg-3 mb-2">
                <select id="ITASTRANIERI_ESONERO" name="DETRAZIONE_FISCALE" class="form-control">
                <?php
                    if ($tab_studente['DETRAZIONE_FISCALE']=='1'){
                        echo "<option selected='selected' value='1'>SI</option>";
                        echo "<option value='0'>NO</option>";
                    } else {
                        echo "<option selected='selected' value='0'>NO</option>";
                        echo "<option value='1'>SI</option>";
                    }     
                ?>                                
                </select>       
                </div>
            </div>
        </div>
<!--Pannello di destra-->        
        <div class="col-lg-6 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <!--DIV PER SPAZIATURA -->
                    <br/>
                </div>
            </div>    
            <?php if (isset($tab_iscrizioni[0]['CORSOLAUREA']) && count($specchietto)>0): ?>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <p><b>SPECCHIETTO IMPORTI TASSE</b></p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label><?php echo $specchietto_titolo; ?></label>
                </div>
            </div>
            <?php foreach ($specchietto as $riga) : ?>                    
            <div class="row">
                <?php if($tab_iscrizioni[0]['CORSOLAUREA']<'888'):?>
                <div class="col-lg-3 mb-2">
                    <label><?php echo '- '.$riga['tipo'].' da'; ?></label>
                </div>
                <?php endif;?>
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
            <?php endif;?>
        </div>
    </div>
</div>