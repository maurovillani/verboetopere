<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'ordinario_religioso';
$classe_tab='tab-pane fade';
if($_SESSION['tab_attivo_studente']==='tab5') $classe_tab .='  fade  show active';
?>

<div class="<?php echo $classe_tab; ?>" id="<?php echo $tab5['id'] ?>" role="tabpanel" aria-labelledby="<?php echo $tab5['id'] ?>-tab">
    <div class="row">
        <div class="col-lg-6 mb-2 mt-2">
            <div class="row">
                <?php 
                    $star='';
                    if ($tab_studente['STATOCIV']!='5' && $tab_studente['STATOCIV']!='6') $star='*';
                ?>
                <div class="col-lg-12 mb-2">
                    <label for="SUPERIORE">Nome Superiore/Vescovo <?php echo $star; ?></label>
                    <input type="text" class="form-control" id="SUPERIORE" name="SUPERIORE" autocomplete="off" value="<?php echo $tab_studente['SUPERIORE']; ?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="IND_SUP1">Indirizzo 1</label>
                    <input type="text" class="form-control" id="IND_SUP1" name="IND_SUP1" autocomplete="off" value="<?php echo $tab_studente['IND_SUP1']; ?>" />
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="IND_SUP2">Indirizzo 2</label>
                    <input type="text" class="form-control" id="IND_SUP2" name="IND_SUP2" autocomplete="off" value="<?php echo $tab_studente['IND_SUP2']; ?>" />
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-9 mb-2">
                    <label for="SUP_CITY">Comune</label>
                    <input type="text" class="form-control" id="SUP_CITY" name="SUP_CITY" autocomplete="off" value="<?php echo $tab_studente['SUP_CITY']; ?>" />
                </div>
                <div class="col-lg-3 mb-2">
                    <label for="SZIPEUR">Cap</label>
                    <input type="text" class="form-control" id="SZIPEUR" name="SZIPEUR" autocomplete="off" value="<?php echo $tab_studente['SZIPEUR']; ?>" />
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="SUP_STATE">Provincia</label>
                    <input type="text" class="form-control" id="SUP_STATE" name="SUP_STATE" autocomplete="off" value="<?php echo $tab_studente['SUP_STATE']; ?>" />
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="S_COUNTRY">Nazione</label>
                    <input type="text" class="form-control" id="S_COUNTRY" name="S_COUNTRY" autocomplete="off" value="<?php echo $tab_studente['S_COUNTRY']; ?>" />
                </div>
            </div>            
        </div>
<!--Pannello di destra-->        
        <div class="col-lg-6 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="SPHONE">Telefono</label>
                    <input type="text" class="form-control" id="SPHONE" name="SPHONE" autocomplete="off" value="<?php echo $tab_studente['SPHONE']; ?>" />
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="SFAX">Fax</label>
                    <input type="text" class="form-control" id="SFAX" name="SFAX" autocomplete="off" value="<?php echo $tab_studente['SFAX']; ?>" />
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="SUPMOVILE">Cellulare</label>
                    <input type="text" class="form-control" id="SUPMOVILE" name="SUPMOVILE" autocomplete="off" value="<?php echo $tab_studente['SUPMOVILE']; ?>" />
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="SEMAIL">Email Superiore/Vescovo <?php echo $star; ?></label>
                    <input type="text" class="form-control" id="SEMAIL" name="SEMAIL" autocomplete="off" value="<?php echo $tab_studente['SEMAIL']; ?>" />
                </div>
            </div>            

        </div>
    </div>
</div>