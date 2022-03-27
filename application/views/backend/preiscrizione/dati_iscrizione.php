<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'dati_iscrizione';
$classe_tab='tab-pane fade';
if($_SESSION['tab_attivo_studente']==='tab3') $classe_tab .='  fade  show active';
?>
<?php
$StyleIndirizzoLaurea='visibility:visible';
$StyleStraordinarioOspite='visibility:visible';
$StyleCheckStraordinarioOspite='visibility:visible';
if (!isset($tab_studente['CORSOLAUREA'])){
    $StyleIndirizzoLaurea='visibility:hidden';
}else if ($tab_studente['CORSOLAUREA']=='210'){
    $StyleIndirizzoLaurea='visibility:visible';
}else{
    $StyleIndirizzoLaurea='visibility:hidden';
}
//$StyleStraordinarioOspite='visibility:visible';
if (!isset($tab_studente['CORSOLAUREA'])){
    $StyleStraordinarioOspite='visibility:hidden';
}else if ($tab_studente['CORSOLAUREA']>'800'){
    $StyleStraordinarioOspite='visibility:visible';
}else{
    $StyleStraordinarioOspite='visibility:hidden';
}
//$StyleCheckStraordinarioOspite='visibility:visible';
if (!isset($tab_studente['ISTITUTO_PROVENIENZA']) && !isset($tab_studente['ISTITUTO_PROVENIENZA_ALTRO'])){
    $StyleCheckStraordinarioOspite='visibility:hidden';
}else {
    $StyleCheckStraordinarioOspite='visibility:visible';
}

$StyleTitoloStudioAltro='visibility:visible';
if (!isset($tab_studente['TITOLOSTUDIO'])){
    $StyleTitoloStudioAltro='visibility:hidden';
}elseif($tab_studente['TITOLOSTUDIO']!='0'){
    $StyleTitoloStudioAltro='visibility:hidden';
}
?>

<div class="<?php echo $classe_tab; ?>" id="<?php echo $tab3['id'] ?>" role="tabpanel" aria-labelledby="<?php echo $tab3['id'] ?>-tab">
    <div>
        <div class="row">
            <div class="col-lg-6 mb-2 mt-2">
                <div class="row">
                    <div class="col-lg-11 mb-2">
                        <label for="CORSOLAUREA">Tipo iscrizione *</label>
                        <?php if (!isset($tab_studente['CORSOLAUREA'])):?>
                        <select id="CORSOLAUREA" name="CORSOLAUREA" class="form-control" onchange="VisualizzaTipoIscrizione()">
                        <?php else:?>
                        <select id="CORSOLAUREA" name="CORSOLAUREA" class="form-control" disabled="disabled">
                        <?php endif;?>
                           <option value=''></option>
                        <?php
                            foreach ($tab_corsidilaurea as $key => $value) {
                                if ($value['CODICENU']=='210' || $value['CODICENU']=='230' || $value['CODICENU']=='888' || $value['CODICENU']=='999'){
                                    if($value['CODICENU'] === $tab_iscrizioni[0]['CORSOLAUREA']){
                                        echo "<option selected='selected' value='".$value['CODICENU']."'>".$value['DECODIF']."</option>";
                                    } else {
                                        echo "<option  value='".$value['CODICENU']."'>".$value['DECODIF']."</option>";
                                    }                            
                                }
                            }
                        ?>                                
                        </select>                        
                    </div>
                    <?php if (isset($tab_iscrizioni[0]['CORSOLAUREA'])): ?>
                    <div class="col-lg-1 mb-2">
                        <br/>
                        <a title="modifica" data-toggle="modal" data-target="#AzzeramentoCorsoLaurea_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-edit'></i></span></a>                                                  
                    </div>
                    <?php endif;?>
                </div>
                <div class="row" style="<?php echo $StyleIndirizzoLaurea;?>" id="IndirizzoLaurea">
                    <div class="col-lg-12 mb-2">
                        <label for="INDIRIZZOLAUREA">Indirizzo di laurea </label>
                        <select id="INDIRIZZOLAUREA" name="INDIRIZZOLAUREA" class="form-control">
                           <option value=''></option>
                        <?php
                            foreach ($tab_indirizzolaurea as $key => $value) {
                                if ($value['CODICENU']=='210010' || $value['CODICENU']=='210020' || $value['CODICENU']=='210030'){
                                    if($value['CODICENU'] === $tab_iscrizioni[0]['INDIRIZZOLAUREA']){
                                        echo "<option selected='selected' value='".$value['CODICENU']."'>".$value['DECODIFICA']."</option>";
                                    } else {
                                        echo "<option  value='".$value['CODICENU']."'>".$value['DECODIFICA']."</option>";
                                    }                            
                                }
                            }
                        ?>                                
                        </select>                        
                    </div>
                </div>
                <div class="row" style="<?php echo $StyleStraordinarioOspite;?>" id="StraordinarioOspite">
                    <div class="col-lg-9 mb-2">
                        <label for="StraordinarioOspite">Sei già iscritto come studente ordinario in un’altra Facoltà/Istituto?</label>
                    </div>    
                    <div class="col-lg-3 mb-2">
                    <select id="CheckStraordinarioOspite" name="CheckStraordinarioOspite" class="form-control" onchange="VisualizzaIstitutoProvenienza()">
                    <?php
                        if ($CRUIPRO=='1'){
                            echo "<option selected='selected' value='1'>SI</option>";
                            echo "<option value='0'>NO</option>";
                            echo "<option value=''></option>";
                        } else {
                            echo "<option selected='selected' value='0'>NO</option>";
                            echo "<option value='1'>SI</option>";
                            echo "<option value=''></option>";
                        }     
                    ?>                                
                    </select>       
                    </div>
                </div>
                <div class="row" style="<?php echo $StyleCheckStraordinarioOspite;?>" id="IstitutoPovenienza">
                    <div class="col-lg-12 mb-2">
                    <label for="ISTITUTO_PROVENIENZA">Istituzione Provenienza *</label>
                    <div class="ui-widget">
                        <input type="search" class="form-control" id="istituzioneprovenienza" value="<?php echo $tab_studente_istituzione_provenienza['ISTITUTO_PROVENIENZA']; ?>">
                        <input type="hidden" id="ID_istituzioneprovenienza" name="ID_istituzioneprovenienza" value="<?php echo $tab_studente['ISTITUTO_PROVENIENZA']; ?>">
                    </div>
                    <input type="hidden" class="form-control" id="CRUIPRO" name="CRUIPRO" autocomplete="off" value="<?php echo $tab_studente_istituzione_provenienza['CRUIPRO']; ?>" readonly/>
                    <input type="hidden" class="form-control" id="Accordo_mobil" name="CRUIPRO" autocomplete="off" value="<?php echo $tab_studente_istituzione_provenienza['Accordo_mobil']; ?>" readonly/>
                    </div>
                </div>
                <div class="row" style="<?php echo $StyleCheckStraordinarioOspite;?>" id="IstitutoPovenienzaAltro">
                    <div class="col-lg-12 mb-2">
                        <label for="ISTITUTO_PROVENIENZA_ALTRO">
                            Inserire Istituto provenienza se non in elenco
                        </label>
                        <input type="text" class="form-control" id="ISTITUTO_PROVENIENZA_ALTRO" name="ISTITUTO_PROVENIENZA_ALTRO" value="<?php echo $tab_studente['ISTITUTO_PROVENIENZA_ALTRO'];?>"/>                    
                    </div>
                </div>
                <div class="row" style="<?php echo $StyleCheckStraordinarioOspite;?>" id="CicloAltraUniv">
                    <div class="col-lg-12 mb-2">
                        <label for="CICLO_ALTRA_UNIV">Ciclo altra università *</label>
                        <select id="CICLO_ALTRA_UNIV" name="CICLO_ALTRA_UNIV" class="form-control">
                           <option value=''></option>
                            <?php
                                if(!isset($tab_studente['CICLO_ALTRA_UNIV'])){
                                    echo "<option value='Licenza'>Licenza</option>";
                                    echo "<option value='Dottorato'>Dottorato</option>";
                                }else{
                                    if ($tab_studente['CICLO_ALTRA_UNIV']=='Licenza'){
                                        echo "<option selected='selected' value='Licenza'>Licenza</option>";
                                        echo "<option value='Dottorato'>Dottorato</option>";
                                    } else {
                                        echo "<option selected='selected' value='Dottorato'>Dottorato</option>";
                                        echo "<option value='Licenza'>Licenza</option>";
                                    }     
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
                        <label for="TITOLOSTUDIO">
                            Titolo di studio *
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
                            Specificare altro *
                        </label>
                        <input type="text" class="form-control" id="TITOLOSTUDIO_ALTRO" name="TITOLOSTUDIO_ALTRO" value="<?php echo $tab_studente['TITOLOSTUDIO_ALTRO'];?>"/>                    
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <!--DIV PER SPAZIATURA -->
                        <br/>
                    </div>
                </div>    
            </div>    
        </div>
    </div>
</div>