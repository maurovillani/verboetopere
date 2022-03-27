<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'dati_personali'; tab-pane fade  show active
$classe_tab='tab-pane fade';
if($_SESSION['tab_attivo_studente']==='tab1') $classe_tab .='  fade  show active';
?>
<?php
$StyleSuperioreVescovo='visibility:visible';
if (!isset($tab_studente['STATOCIV'])){
    $StyleSuperioreVescovo='visibility:hidden';
}elseif($tab_studente['STATOCIV']=='5' || $tab_studente['STATOCIV']=='6'){
    $StyleSuperioreVescovo='visibility:hidden';
}

//$StyleProvinciaNascita='visibility:visible';
//if ($tab_studente['NASCNAZI']!='1'){
//    $StyleProvinciaNascita='visibility:hidden';
//}
$StyleProvinciaNascita='visibility:hidden';
if (isset($tab_studente['NASCNAZI'])){
    $StyleProvinciaNascita='visibility:visible';
}else{
    $StyleProvinciaNascita='visibility:hidden';
}


$StyleTitoloStudioAltro='visibility:visible';
if (!isset($tab_studente['TITOLOSTUDIO'])){
    $StyleTitoloStudioAltro='visibility:hidden';
}elseif($tab_studente['TITOLOSTUDIO']!='0'){
    $StyleTitoloStudioAltro='visibility:hidden';
}
?>
<div class="<?php echo $classe_tab; ?>" id="<?php echo $tab1['id'] ?>" role="tabpanel" aria-labelledby="<?php echo $tab1['id'] ?>-tab">
    <div class="row">
        <div class="col-lg-6 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="NASCDATA">
                        <?php if($lingua=='IT'): ?>
                            Data di nascita *
                        <?php elseif($lingua=='IN'): ?>
                            Date of Birth *
                        <?php endif; ?>
                    </label>
                    <!--<input type="text" class="form-control" id="NASCDATA" name="NASCDATA" value="<?php echo substr($tab_studente['NASCDATA'],0,10);?>" placeholder="aaaa-mm-gg" onchange="Controlla_NASCDATA()">-->
                    <input type="text" class="form-control" id="NASCDATA" name="NASCDATA" value="<?php echo substr($tab_studente['NASCDATA'],0,10);?>" placeholder="aaaa-mm-gg">
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="NASCCOMUNE">
                        <?php if($lingua=='IT'): ?>
                            Luogo di nascita *
                        <?php elseif($lingua=='IN'): ?>
                            Place of Birth *
                        <?php endif; ?>
                    </label>
                    <input type="text" class="form-control" id="NASCCOMUNE" name="NASCCOMUNE" autocomplete="off" value="<?php echo $tab_studente['NASCCOMUNE']; ?>" required/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="NAZIONE_NASCITA">
                        <?php if($lingua=='IT'): ?>
                            Paese nascita *
                        <?php elseif($lingua=='IN'): ?>
                            Birth Country *
                        <?php endif; ?>
                    </label>
                    <div class="ui-widget">
                        <input type="search" class="form-control" id="nazione" value="<?php echo $tab_studente_nascita['NAZIONE']; ?>"  >
                        <input type="hidden" id="ID_nazione" name="ID_nazione" value="<?php echo $tab_studente['NASCNAZI']; ?>" onchange="VisualizzaProvinciaNascita()">
                    </div>
                </div>
                <div class="col-lg-6 mb-2" style="<?php echo $StyleProvinciaNascita;?>" id="ProvinciaNascita">
                    <label for="PROVINCIA_NASCITA">
                        <?php if($lingua=='IT'): ?>
                            Provincia nascita *
                        <?php elseif($lingua=='IN'): ?>
                            Birth Province *
                        <?php endif; ?>
                    </label>
                    <?php if(!isset($tab_studente['NASCNAZI'])):?>
                    <input type="hidden" class="form-control" id="NASCPROV_ESTERA" name="NASCPROV_ESTERA" value="">
                    <div class="ui-widget">
                        <input type="hidden" class="form-control" id="provincia" value="<?php echo $tab_studente_nascita['PROVINCIA']; ?>">
                    <?php elseif($tab_studente['NASCNAZI']=='1'):?>
                    <input type="hidden" class="form-control" id="NASCPROV_ESTERA" name="NASCPROV_ESTERA" value="<?php echo $tab_studente['NASCPROV_ESTERA']; ?>">
                    <div class="ui-widget">
                        <input type="search" class="form-control" id="provincia" value="<?php echo $tab_studente_nascita['PROVINCIA']; ?>">
                    <?php else:?>
                    <input type="text" class="form-control" id="NASCPROV_ESTERA" name="NASCPROV_ESTERA" value="<?php echo $tab_studente['NASCPROV_ESTERA']; ?>">
                    <div class="ui-widget">
                        <input type="hidden" class="form-control" id="provincia" value="<?php echo $tab_studente_nascita['PROVINCIA']; ?>">
                    <?php endif;?>
                    <input type="hidden" id="ID_provincia" name="ID_provincia" value="<?php echo $tab_studente['NASCPROV']; ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="CITTADI2">
                        <?php if($lingua=='IT'): ?>
                            Cittadinanza attuale *
                        <?php elseif($lingua=='IN'): ?>
                            Current Citizenship *
                        <?php endif; ?>
                    </label>
                    <div class="ui-widget">
                        <input type="search" class="form-control" id="cittadinanza" value="<?php echo $tab_studente['CITTADINANZA_ATTUALE']; ?>">
                        <input type="hidden" id="ID_cittadinanza" name="ID_cittadinanza" value="<?php echo $tab_studente['CITTADI2']; ?>">
                    </div>
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="STATOCIV">
                        <?php if($lingua=='IT'): ?>
                            Stato religioso *
                        <?php elseif($lingua=='IN'): ?>
                            Religious status *
                        <?php endif; ?>
                    </label>
                    <select id="STATOCIV" name="STATOCIV" class="form-control" onchange="VisualizzaDatiSuperioreVescovo()">
                        <option value=''></option>
                    <?php
                        foreach ($tab_statocivile as $key => $value) {
                            if($value['CODICENU'] === $tab_studente['STATOCIV']){
                                echo "<option selected='selected' value='".$value['CODICENU']."'>".$value['DECODIF']."</option>";
                            } else {
                                echo "<option  value='".$value['CODICENU']."'>".$value['DECODIF']."</option>";
                            }                            
                        }
                    ?>                                
                    </select>                   
                </div> 
            </div>
            <div class="row" style="<?php echo $StyleSuperioreVescovo;?>" id="NomeSuperioreVescovo">
                <div class="col-lg-12 mb-2">
                    <label for="SUPERIORE">
                        <?php if($lingua=='IT'): ?>
                            Nome Superiore/Vescovo *
                        <?php elseif($lingua=='IN'): ?>
                            Name of Superior or Bishop *
                        <?php endif; ?>
                    </label>
                    <input type="text" class="form-control" id="SUPERIORE" name="SUPERIORE" autocomplete="off" value="<?php echo $tab_studente['SUPERIORE']; ?>"/>
                </div>
            </div>
            <div class="row" style="<?php echo $StyleSuperioreVescovo;?>" id="EmailSuperioreVescovo">
                <div class="col-lg-12 mb-2">
                    <label for="SEMAIL">
                        <?php if($lingua=='IT'): ?>
                            Email Superiore/Vescovo*
                        <?php elseif($lingua=='IN'): ?>
                            Email of Superior or Bishop *
                        <?php endif; ?>
                    </label>
                    <input type="text" class="form-control" id="SEMAIL" name="SEMAIL" autocomplete="off" value="<?php echo $tab_studente['SEMAIL']; ?>" />
                </div>
            </div>            
        </div>
        
<!--Pannello di destra-->        
        <div class="col-lg-6 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-3 mb-2">
                    <label for="SESSO">
                        <?php if($lingua=='IT'): ?>
                            Sesso *
                        <?php elseif($lingua=='IN'): ?>
                            Sex *
                        <?php endif; ?>
                    </label>
                    <select id="SESSO" name="SESSO" class="form-control">
                        <option value=''></option>
                    <?php
                        if (!isset($tab_studente['SESSO'])){
                            echo "<option value='F'>F</option>";
                            echo "<option value='M'>M</option>";
                        }else{
                            if($tab_studente['SESSO']==='M'){
                                echo "<option selected='selected' value='M'>M</option>";
                                echo "<option value='F'>F</option>";
                            } else {
                                echo "<option selected='selected' value='F'>F</option>";
                                echo "<option value='M'>M</option>";
                            }     
                        }
                    ?>                                
                    </select>       
                </div>
                <div class="col-lg-9 mb-2">
                    <label for="email">
                        <?php if($lingua=='IT'): ?>
                            Posta elettronica *
                        <?php elseif($lingua=='IN'): ?>
                            Email address *
                        <?php endif; ?>
                    </label>
                    <input type="text" class="form-control" id="email" name="email" value="<?php echo $tab_studente['email'];?>" readonly/>
                </div>                 
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="CORSOLAUREA">
                        <?php if($lingua=='IT'): ?>
                            Tipo iscrizione *
                        <?php elseif($lingua=='IN'): ?>
                            Enrollment type *
                        <?php endif; ?>
                    </label>
                    <select id="CORSOLAUREA" name="CORSOLAUREA" class="form-control">
                       <option value=''></option>
                    <?php
                        foreach ($tab_corsidilaurea as $key => $value) {
                            if ($value['CODICENU']=='210' || $value['CODICENU']=='230') {
                                if($value['CODICENU'] === $tab_studente['CORSOLAUREA']){
                                    echo "<option selected='selected' value='".$value['CODICENU']."'>".$value['DECODIF']."</option>";
                                } else {
                                    echo "<option  value='".$value['CODICENU']."'>".$value['DECODIF']."</option>";
                                }                            
                            }
                        }
                    ?>                                
                    </select>                        
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="TITOLOSTUDIO">
                        <?php if($lingua=='IT'): ?>
                            Titolo di studio *
                        <?php elseif($lingua=='IN'): ?>
                            Title of study *
                        <?php endif; ?>
                    </label>
                    <select id="TITOLOSTUDIO" name="TITOLOSTUDIO" class="form-control" onchange="VisualizzaTitoloStudioAltro()">
                       <option value=''></option>
                    <?php
                        foreach ($tab_titolistudio as $key => $value) {
                            if ($value['CODICENU']=='2101' || $value['CODICENU']=='1201' || $value['CODICENU']=='0') {
                                if($value['CODICENU'] === $tab_studente['TITOLOSTUDIO']){
                                    echo "<option selected='selected' value='".$value['CODICENU']."'>".$value['DECODIF']."</option>";
                                } else {
                                    echo "<option  value='".$value['CODICENU']."'>".$value['DECODIF']."</option>";
                                }                            
                            }
                        }
                    ?>                                
                    </select>                        
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2" style="<?php echo $StyleTitoloStudioAltro;?>" id="TitoloStudioAltro">
                    <label for="TITOLOSTUDIO_ALTRO">
                        <?php if($lingua=='IT'): ?>
                            Specificare altro *
                        <?php elseif($lingua=='IN'): ?>
                            Specify other *
                        <?php endif; ?>
                    </label>
                    <input type="text" class="form-control" id="TITOLOSTUDIO_ALTRO" name="TITOLOSTUDIO_ALTRO" value="<?php echo $tab_studente['TITOLOSTUDIO_ALTRO'];?>"/>                    
                    <input type="hidden" id="NOTA_ANAGRAFICA" name="NOTA_ANAGRAFICA" value=""/>                    
                </div>
            </div>
<!--            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="CERTIFICATOPREISCRIZIONE">
                     <br/><b>
                    <?php //if($lingua=='IT'): ?>
                    Si richiede un certificato di preiscrizione
                    &nbsp;<input type="radio" id="CERTIFICATOPREISCRIZIONE" name="CERTIFICATOPREISCRIZIONE" value="S" <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE']==='S') echo 'checked';?> onclick="this.form.submit();" required>&nbsp;SI
                    &nbsp;<input type="radio" id="CERTIFICATOPREISCRIZIONE" name="CERTIFICATOPREISCRIZIONE" value="N" <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE']==='N') echo 'checked';?> onclick="this.form.submit();" required>&nbsp;NO
                    <?php //elseif($lingua=='IN'): ?>
                    Pre-enrollment certificate required
                    &nbsp;<input type="radio" name="CERTIFICATOPREISCRIZIONE" value="S" <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE']==='S') echo 'checked';?> required>&nbsp;YES
                    &nbsp;<input type="radio" name="CERTIFICATOPREISCRIZIONE" value="N" <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE']==='N') echo 'checked';?> required>&nbsp;NO
                    <?php //endif; ?>
                        </b>
                    </label>
                </div>
            </div>-->
        </div>

    </div>
</div>