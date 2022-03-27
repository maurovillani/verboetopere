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
$OrdineDiocesi='';
$StyleOrdineDiocesi='visibility:visible';
if (!isset($tab_studente['STATOCIV'])){
    $StyleOrdineDiocesi='visibility:hidden';
}else{
    $StyleOrdineDiocesi='visibility:visible';
//    if($tab_studente['STATOCIV']=='1' || $tab_studente['STATOCIV']=='3' || $tab_studente['STATOCIV']=='4' || $tab_studente['STATOCIV']=='9'){
    if($tab_studente['STATOCIV']==1 || $tab_studente['STATOCIV']==3 || $tab_studente['STATOCIV']==4){
        $OrdineDiocesi='Ordine *';        
    }else{
        $OrdineDiocesi='Diocesi *';        
    }
}
$StyleProvinciaNascita='visibility:hidden';
if (isset($tab_studente['NASCNAZI'])){
    $StyleProvinciaNascita='visibility:visible';
}else{
    $StyleProvinciaNascita='visibility:hidden';
}
?>


<div class="<?php echo $classe_tab; ?>" id="<?php echo $tab1['id'] ?>" role="tabpanel" aria-labelledby="<?php echo $tab1['id'] ?>-tab">
    <div class="row">
        <div class="col-lg-6 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="NASCDATA">Data di nascita *</label>
                    <!--<input type="text" class="form-control" id="NASCDATA" name="NASCDATA" value="<?php echo substr($tab_studente['NASCDATA'],0,10);?>" placeholder="aaaa-mm-gg" onchange="Controlla_NASCDATA()">-->
                    <input type="text" class="form-control" id="NASCDATA" name="NASCDATA" value="<?php echo substr($tab_studente['NASCDATA'],0,10);?>" placeholder="aaaa-mm-gg">
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="NASCCOMUNE">Luogo di nascita *</label>
                    <input type="text" class="form-control" id="NASCCOMUNE" name="NASCCOMUNE" autocomplete="off" value="<?php echo $tab_studente['NASCCOMUNE']; ?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="NAZIONE_NASCITA">Nazione nascita *</label>
                    <div class="ui-widget">
                        <input type="search" class="form-control" id="nazione" value="<?php echo $tab_studente_nascita['NAZIONE']; ?>" onchange="VisualizzaProvinciaNascita()">
                        <input type="hidden" id="ID_nazione" name="ID_nazione" value="<?php echo $tab_studente['NASCNAZI']; ?>">
                    </div>
                    <?php //echo $searchNazioneNascita; ?>
                </div>
                <div class="col-lg-6 mb-2" style="<?php echo $StyleProvinciaNascita;?>" id="ProvinciaNascita">
                    <label for="PROVINCIA_NASCITA">Provincia nascita *</label>
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
<!--            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="CITTADINANZA_NASCITA">Cittadinanza alla nascita</label>
                    <input type="text" class="form-control" id="CITTADINANZA_NASCITA" name="CITTADINANZA_NASCITA" autocomplete="off" value="<?php echo $tab_studente_nascita['CITTADINANZA']; ?>" readonly/>
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="CONTINENTE_NASCITA">Continente nascita</label>
                    <input type="text" class="form-control" id="CONTINENTE_NASCITA" name="CONTINENTE_NASCITA" value="<?php echo $tab_studente_nascita['CONTINENTE'];?>" readonly/>
                </div>
            </div>  -->
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="CITTADI2">Cittadinanza attuale *</label>
                    <div class="ui-widget">
                        <input type="search" class="form-control" id="cittadinanza" value="<?php echo $tab_studente['CITTADINANZA_ATTUALE']; ?>">
                        <input type="hidden" id="ID_cittadinanza" name="ID_cittadinanza" value="<?php echo $tab_studente['CITTADI2']; ?>">
                    </div>
                    <?php //echo $searchNazionalitaAttuale; ?>
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="email">Posta elettronica *</label>
                    <input type="text" class="form-control" id="email" name="email" value="<?php echo $tab_studente['email'];?>" readonly/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="cellulare">Cellulare *</label>
                    <input type="text" class="form-control" id="cellulare" name="cellulare" value="<?php echo $tab_studente['cellulare'];?>"/>
                </div>
            </div>            

        </div>
<!--Pannello di destra-->        
        <div class="col-lg-6 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-9 mb-2">
                    <label for="CODFISCA">Codice Fiscale</label>
                    <input type="text" class="form-control" id="CODFISCA" name="CODFISCA" value="<?php echo $tab_studente['CODFISCA'];?>" />
                </div>
                <div class="col-lg-3 mb-2">
                    <label for="SESSO">Sesso *</label>
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
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="STATOCIV">Stato religioso *</label>
                    <select id="STATOCIV" name="STATOCIV" class="form-control" onchange="VisualizzaOrdineDiocesi()">
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
            <div class="row" style="<?php echo $StyleOrdineDiocesi;?>">
                <div class="col-lg-12 mb-2">
                    <input type="text" class="form-control-plaintext" id="lblOrdineDiocesi" value="<?php echo $OrdineDiocesi; ?>" readonly/>
                    <div class="ui-widget">
                    <?php if(isset($tab_studente['STATOCIV'])):?>
                        <?php if($tab_studente['STATOCIV']==1 || $tab_studente['STATOCIV']==3 || $tab_studente['STATOCIV']==4):?>
                            <input type="search" class="form-control" id="ordine" value="<?php echo $tab_ordine['DECODIF']; ?>">
                            <input type="hidden" id="ID_ordine" name="ID_ordine" value="<?php echo $tab_studente['ORDINE']; ?>">
                            <input type="hidden" class="form-control" id="diocesi" value="<?php echo $tab_diocesi['DIOCESI']; ?>">
                            <input type="hidden" id="ID_diocesi" name="ID_diocesi" value="<?php echo $tab_studente['DIOCESI']; ?>">
                        <?php else:?>
                            <input type="hidden" class="form-control" id="ordine" value="<?php echo $tab_ordine['DECODIF']; ?>">
                            <input type="hidden" id="ID_ordine" name="ID_ordine" value="<?php echo $tab_studente['ORDINE']; ?>">
                            <input type="search" class="form-control" id="diocesi" value="<?php echo $tab_diocesi['DIOCESI']; ?>">
                            <input type="hidden" id="ID_diocesi" name="ID_diocesi" value="<?php echo $tab_studente['DIOCESI']; ?>">
                        <?php endif;?>
                    <?php else:?>
                        <input type="hidden" class="form-control" id="ordine" value="<?php echo $tab_ordine['DECODIF']; ?>">
                        <input type="hidden" id="ID_ordine" name="ID_ordine" value="<?php echo $tab_studente['ORDINE']; ?>">
                        <input type="hidden" class="form-control" id="diocesi" value="<?php echo $tab_diocesi['DIOCESI']; ?>">
                        <input type="hidden" id="ID_diocesi" name="ID_diocesi" value="<?php echo $tab_studente['DIOCESI']; ?>">
                    <?php endif;?>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>