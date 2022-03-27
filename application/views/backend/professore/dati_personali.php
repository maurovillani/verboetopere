<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'dati_personali';
?>
<div class="tab-pane fade  show active" id="<?php echo $tab1['id'] ?>" role="tabpanel" aria-labelledby="<?php echo $tab1['id'] ?>-tab">
    <div class="row">
        <div class="col-lg-6 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="NASCDATA">Data di nascita</label>
                    <!--<input type="date" class="form-control" id="NASCDATA" name="NASCDATA" value="<?php //echo substr($tab_professore['NASCDATA'],0,10);?>" required/>-->
                    <input type="text" class="form-control" id="NASCDATA" name="NASCDATA" value="<?php echo substr($tab_professore['NASCDATA'],0,10);?>" placeholder="aaaa-mm-gg" onchange="Controlla_NASCDATA()">
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="NASCCOMUNE">Luogo di nascita</label>
                    <input type="text" class="form-control" id="NASCCOMUNE" name="NASCCOMUNE" autocomplete="off" value="<?php echo $tab_professore['NASCCOMUNE']; ?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="PROVINCIA_NASCITA">Provincia nascita</label>
                    <div class="ui-widget">
                        <input type="search" class="form-control" id="provincia" value="<?php echo $tab_professore_nascita['PROVINCIA']; ?>">
                        <input type="hidden" id="ID_provincia" name="ID_provincia" value="<?php echo $tab_professore['NASCPROV']; ?>">
                    </div>
                    <?php //echo $searchProvinciaNascita; ?>
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="NAZIONE_NASCITA">Nazione nascita</label>
                    <div class="ui-widget">
                        <input type="search" class="form-control" id="nazione" value="<?php echo $tab_professore_nascita['NAZIONE']; ?>">
                        <input type="hidden" id="ID_nazione" name="ID_nazione" value="<?php echo $tab_professore['NASCNAZI']; ?>">
                    </div>
                    <?php //echo $searchNazioneNascita; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="CITTADINANZA_NASCITA">Cittadinanza alla nascita</label>
                    <input type="text" class="form-control" id="CITTADINANZA_NASCITA" name="CITTADINANZA_NASCITA" autocomplete="off" value="<?php echo $tab_professore_nascita['CITTADINANZA']; ?>" readonly/>
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="CITTADI2">Cittadinanza attuale</label>
                    <div class="ui-widget">
                        <input type="search" class="form-control" id="cittadinanza" value="<?php echo $tab_professore['CITTADINANZA_ATTUALE']; ?>">
                        <input type="hidden" id="ID_cittadinanza" name="ID_cittadinanza" value="<?php echo $tab_professore['CITTADI2']; ?>">
                    </div>
                    <?php //echo $searchNazionalitaAttuale; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="TELEFONO1">Telefono 1</label>
                    <input type="text" class="form-control" id="TELEFONO1" name="TELEFONO1" value="<?php echo $tab_professore['TELEFONO1'];?>"/>
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="TELEFONO2">Telefono 2</label>
                    <input type="text" class="form-control" id="TELEFONO2" name="TELEFONO2" value="<?php echo $tab_professore['TELEFONO2'];?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="TELEFONO3">Telefono 3</label>
                    <input type="text" class="form-control" id="TELEFONO3" name="TELEFONO3" value="<?php echo $tab_professore['TELEFONO3'];?>"/>
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="EMAIL">Email</label>
                    <input type="text" class="form-control" id="EMAIL" name="EMAIL" value="<?php echo $tab_professore['EMAIL'];?>"/>
                </div>
            </div>
        </div>
<!--Pannello di destra-->        
        <div class="col-lg-6 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-9 mb-2">
                    <label for="CODFISCA">Codice Fiscale</label>
                    <input type="text" class="form-control" id="CODFISCA" name="CODFISCA" value="<?php echo $tab_professore['CODFISCA'];?>"/>
                </div>
                <div class="col-lg-3 mb-2">
                    <label for="SESSO">Sesso</label>
                    <select id="SESSO" name="SESSO" class="form-control">
                    <?php
                        if($tab_professore['SESSO']==='M'){
                            echo "<option selected='selected' value='M'>M</option>";
                            echo "<option value='F'>F</option>";
                        } else {
                            echo "<option selected='selected' value='F'>F</option>";
                            echo "<option value='M'>M</option>";
                        }                            
                    ?>                                
                    </select>       
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="STATOCIV">Stato civile</label>
                    <select id="STATOCIV" name="STATOCIV" class="form-control">
                    <?php
                        foreach ($tab_statocivile as $key => $value) {
                            if($value['CODICENU'] === $tab_professore['STATOCIV']){
                                echo "<option selected='selected' value='".$value['CODICENU']."'>".$value['DECODIF']."</option>";
                            } else {
                                echo "<option  value='".$value['CODICENU']."'>".$value['DECODIF']."</option>";
                            }                            
                        }
                    ?>                                
                    </select>                   
                </div> 
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="DIOCESI">Diocesi</label>
                    <div class="ui-widget">
                        <input type="search" class="form-control" id="diocesi" value="<?php echo $tab_diocesi['DIOCESI']; ?>">
                        <input type="hidden" id="ID_diocesi" name="ID_diocesi" value="<?php echo $tab_professore['DIOCESI']; ?>">
                    </div>
                    <?php //echo $searchDiocesi; ?>
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="ORDIPROF">Ordine</label>
                    <div class="ui-widget">
                        <input type="search" class="form-control" id="ordine" value="<?php echo $tab_ordine['DECODIF']; ?>">
                        <input type="hidden" id="ID_ordine" name="ID_ordine" value="<?php echo $tab_professore['ORDIPROF']; ?>">
                    </div>
                    <?php //echo $searchOrdine; ?>
                </div> 
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="NOTA_ANAGRAFICA">Note</label>
                    <textarea class="form-control" rows="3" id="NOTA_ANAGRAFICA" name="NOTA_ANAGRAFICA" value=""><?php echo $tab_professore['NOTA'];?></textarea>
                </div> 
            </div>            
        </div>
    </div>
</div>