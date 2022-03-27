<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'indirizzi';
?>

<div class="tab-pane fade" id="<?php echo $tab2['id'] ?>" role="tabpanel" aria-labelledby="<?php echo $tab2['id'] ?>-tab">
    <div class="row">
        <div class="col-lg-6 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <h5>Indirizzo Fiscale</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9 mb-2">
                    <label for="RESINDS">Indirizzo</label>
                    <input type="text" class="form-control" id="RESINDS" name="RESINDS" autocomplete="off" value="<?php echo $tab_professore['RESINDS']; ?>" />
                </div>
                <div class="col-lg-3 mb-2">
                    <label for="RESCAP">Cap</label>
                    <input type="text" class="form-control" id="RESCAP" name="RESCAP" autocomplete="off" value="<?php echo $tab_professore['RESCAP']; ?>" />
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="RESCOMUNE">Comune</label>
                    <input type="text" class="form-control" id="RESCOMUNE" name="RESCOMUNE" autocomplete="off" value="<?php echo $tab_professore['RESCOMUNE']; ?>" />
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="PROVINCIA_RESIDENZA">Provincia</label>
                    <div class="ui-widget">
                        <input type="search" class="form-control" id="provinciaresidenza" value="<?php echo $tab_professore_residenza['PROVINCIA']; ?>">
                        <input type="hidden" id="ID_provinciaresidenza" name="ID_provinciaresidenza" value="<?php echo $tab_professore['RESPROV']; ?>">
                    </div>
                    <?php //echo $searchProvinciaResidenza; ?>
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="NAZIONE_RESIDENZA">Nazione</label>
                    <div class="ui-widget">
                        <input type="search" class="form-control" id="nazioneresidenza" value="<?php echo $tab_professore_residenza['NAZIONE']; ?>">
                        <input type="hidden" id="ID_nazioneresidenza" name="ID_nazioneresidenza" value="<?php echo $tab_professore['RESNAZI']; ?>">
                    </div>
                    <?php //echo $searchNazioneResidenza; ?>
                </div>
            </div>            
        </div>
<!--Pannello di destra-->        
        <div class="col-lg-6 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <h5>Indirizzo a Roma</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="RECPRES">Presso</label>
                    <input type="text" class="form-control" id="RECPRES" name="RECPRES" value="<?php echo $tab_professore['RECPRES'];?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9 mb-2">
                    <label for="RECINDS">Indirizzo</label>
                    <input type="text" class="form-control" id="RECINDS" name="RECINDS" autocomplete="off" value="<?php echo $tab_professore['RECINDS']; ?>" />
                </div>
                <div class="col-lg-3 mb-2">
                    <label for="RECCAP">Cap</label>
                    <input type="text" class="form-control" id="RECCAP" name="RECCAP" autocomplete="off" value="<?php echo $tab_professore['RECCAP']; ?>" />
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="RECCOMUNE">Comune</label>
                    <input type="text" class="form-control" id="RECCOMUNE" name="RECCOMUNE" autocomplete="off" value="<?php echo $tab_professore['RECCOMUNE']; ?>" />
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="PROVINCIA_RECAPITO">Provincia</label>
                    <div class="ui-widget">
                        <input type="search" class="form-control" id="provinciarecapito" value="<?php echo $tab_professore_recapito['PROVINCIA']; ?>">
                        <input type="hidden" id="ID_provinciarecapito" name="ID_provinciarecapito" value="<?php echo $tab_professore['RECPROV']; ?>">
                    </div>
                    <?php //echo $searchProvinciaRecapito; ?>
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="NAZIONE_RECAPITO">Nazione</label>
                    <div class="ui-widget">
                        <input type="search" class="form-control" id="nazionerecapito" value="<?php echo $tab_professore_recapito['NAZIONE']; ?>">
                        <input type="hidden" id="ID_nazionerecapito" name="ID_nazionerecapito" value="<?php echo $tab_professore['RECNAZI']; ?>">
                    </div>
                    <?php //echo $searchNazioneRecapito; ?>
                </div>
            </div>            
        </div>
    </div>
</div>