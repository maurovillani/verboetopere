<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'indirizzi';
$classe_tab='tab-pane fade';
if($_SESSION['tab_attivo_studente']==='tab4') $classe_tab .='  fade  show active';
?>

<div class="<?php echo $classe_tab; ?>" id="<?php echo $tab4['id'] ?>" role="tabpanel" aria-labelledby="<?php echo $tab4['id'] ?>-tab">
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
                    <input type="text" class="form-control" id="RESINDS" name="RESINDS" autocomplete="off" value="<?php echo $tab_studente['RESINDS']; ?>" />
                </div>
                <div class="col-lg-3 mb-2">
                    <label for="RESCAP">Cap</label>
                    <input type="text" class="form-control" id="RESCAP" name="RESCAP" autocomplete="off" value="<?php echo $tab_studente['RESCAP']; ?>" />
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="RESCOMUNE">Comune</label>
                    <input type="text" class="form-control" id="RESCOMUNE" name="RESCOMUNE" autocomplete="off" value="<?php echo $tab_studente['RESCOMUNE']; ?>" />
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="PROVINCIA_RESIDENZA">Provincia</label>
                    <div class="ui-widget">
                        <input type="search" class="form-control" id="provinciaresidenza" value="<?php echo $tab_studente_residenza['PROVINCIA']; ?>">
                        <input type="hidden" id="ID_provinciaresidenza" name="ID_provinciaresidenza" value="<?php echo $tab_studente['RESPROV']; ?>">
                    </div>
                    <?php //echo $searchProvinciaResidenza; ?>
                </div>
            </div> 
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="NAZIONE_RESIDENZA">Nazione</label>
                    <div class="ui-widget">
                        <input type="search" class="form-control" id="nazioneresidenza" value="<?php echo $tab_studente_residenza['NAZIONE']; ?>">
                        <input type="hidden" id="ID_nazioneresidenza" name="ID_nazioneresidenza" value="<?php echo $tab_studente['RESNAZI']; ?>">
                    </div>
                    <?php //echo $searchNazioneResidenza; ?>
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="CONTINENTE_RESIDENZA">Continente</label>
                    <input type="text" class="form-control" id="CONTINENTE_RESIDENZA" name="CONTINENTE_RESIDENZA" value="<?php echo $tab_studente_residenza['CONTINENTE'];?>" readonly/>
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="RESTELE">Telefono</label>
                    <input type="text" class="form-control" id="RESTELE" name="RESTELE" value="<?php echo $tab_studente['RESTELE'];?>"/>
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
                    <input type="text" class="form-control" id="RECPRES" name="RECPRES" value="<?php echo $tab_studente['RECPRES'];?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9 mb-2">
                    <label for="RECINDS">Indirizzo</label>
                    <input type="text" class="form-control" id="RECINDS" name="RECINDS" autocomplete="off" value="<?php echo $tab_studente['RECINDS']; ?>" />
                </div>
                <div class="col-lg-3 mb-2">
                    <label for="RECCAP">Cap</label>
                    <input type="text" class="form-control" id="RECCAP" name="RECCAP" autocomplete="off" value="<?php echo $tab_studente['RECCAP']; ?>" />
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="RECCOMUNE">Comune</label>
                    <input type="text" class="form-control" id="RECCOMUNE" name="RECCOMUNE" autocomplete="off" value="<?php echo $tab_studente['RECCOMUNE']; ?>" />
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="PROVINCIA_RECAPITO">Provincia</label>
                    <div class="ui-widget">
                        <input type="search" class="form-control" id="provinciarecapito" value="<?php echo $tab_studente_recapito['PROVINCIA']; ?>">
                        <input type="hidden" id="ID_provinciarecapito" name="ID_provinciarecapito" value="<?php echo $tab_studente['RECPROV']; ?>">
                    </div>
                    <?php //echo $searchProvinciaRecapito; ?>
                </div>
            </div>            
            <div class="row">
<!--                <div class="col-lg-12 mb-2">
                    <label for="RECTELE">Telefono</label>
                    <input type="text" class="form-control" id="RECTELE" name="RECTELE" value="<?php //echo $tab_studente['RECTELE'];?>"/>
                </div>-->
            </div>
<!--            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="NAZIONE_RECAPITO">Nazione</label>
                    <?php //echo $searchNazioneRecapito; ?>
                </div>
                <div class="col-lg-6 mb-2">
                </div>
            </div>            -->
        </div>
    </div>
</div>