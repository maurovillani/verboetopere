<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'indirizzi';
$classe_tab='tab-pane fade';
if($_SESSION['tab_attivo_studente']==='tab2') $classe_tab .='  fade  show active';
?>
<?php
$StyleIndirizzoRoma='visibility:visible';
if (!isset($tab_studente['COLLEGIO'])){
    $StyleIndirizzoRoma='visibility:hidden';
}elseif($tab_studente['COLLEGIO']=='0'){
    $StyleIndirizzoRoma='visibility:visible';
}elseif($tab_studente['COLLEGIO']!='0'){
    $StyleIndirizzoRoma='visibility:hidden';
}
$StyleIndirizzoCollegio='visibility:visible';
if (!isset($tab_studente['COLLEGIO'])){
    $StyleIndirizzoCollegio='visibility:hidden';
}elseif($tab_studente['COLLEGIO']!='0'){
    $StyleIndirizzoCollegio='visibility:visible';
}elseif($tab_studente['COLLEGIO']=='0'){
    $StyleIndirizzoCollegio='visibility:hidden';
}
?>
<div class="<?php echo $classe_tab; ?>" id="<?php echo $tab2['id'] ?>" role="tabpanel" aria-labelledby="<?php echo $tab2['id'] ?>-tab">
    <div class="row">
        <div class="col-lg-6 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <h5>Indirizzo a Roma</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="COLLEGIO">
                        Collegio/Fuori Collegio *
                    </label>
                    <select id="COLLEGIO" name="COLLEGIO" class="form-control" onchange="VisualizzaIndirizzoRoma()">
                        <option value=''></option>
                    <?php
                        if (!isset($tab_studente['COLLEGIO'])){
                            echo "<option value='0'>FUORI COLLEGIO</option>";
                            echo "<option value='-1'>COLLEGIO</option>";
                        }else{
                            if($tab_studente['COLLEGIO']==='0'){
                                echo "<option selected='selected' value='0'>FUORI COLLEGIO</option>";
                                echo "<option value='-1'>COLLEGIO</option>";
                            } else {
                                echo "<option selected='selected' value='-1'>COLLEGIO</option>";
                                echo "<option value='0'>FUORI COLLEGIO</option>";
                            }     
                        }
                    ?> 
                    </select>                   
                </div>
            </div>
            <div class="row" style="<?php echo $StyleIndirizzoCollegio;?>" id="IndirizzoRomaCollegio">
                <div class="col-lg-12 mb-2">
                    <label for="COLLEGIO">
                        Nome Collegio *
                    </label>
                    <div class="ui-widget">
                        <input type="search" class="form-control" id="collegio" value="<?php echo $tab_collegio['COLLEGIO']; ?>">
                        <input type="hidden" id="ID_collegio" name="ID_collegio" value="<?php echo $tab_studente['COLLEGIO']; ?>">
                    </div>
                </div>
            </div>
        </div>
<!--Pannello di destra-->        
        <div class="col-lg-6 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <h5></h5>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <h5></h5>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <h5></h5>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <h5></h5>
                </div>
            </div>
            <div class="row" style="<?php echo $StyleIndirizzoRoma;?>" id="IndirizzoRomaPresso">
                <div class="col-lg-3 mb-2" align="right">
                    <label for="RECPRES">
                        Presso 
                    </label>
                </div>
                <div class="col-lg-9 mb-2">
                    <input type="text" class="form-control" id="RECPRES" name="RECPRES" value="<?php echo $tab_studente['RECPRES'];?>"/>
                </div>
            </div>
            <div class="row" style="<?php echo $StyleIndirizzoRoma;?>" id="IndirizzoRomaIndirizzo">
                <div class="col-lg-3 mb-2" align="right">
                    <label for="RECINDS">
                        Indirizzo *
                    </label>
                </div>
                <div class="col-lg-9 mb-2">
                    <input type="text" class="form-control" id="RECINDS" name="RECINDS" autocomplete="off" value="<?php echo $tab_studente['RECINDS']; ?>" />
                </div>
            </div>            
            <div class="row" style="<?php echo $StyleIndirizzoRoma;?>" id="IndirizzoRomaComune">
                <div class="col-lg-3 mb-2" align="right">
                    <label for="RECCOMUNE">
                        Comune *
                    </label>
                </div>
                <div class="col-lg-9 mb-2">
                    <input type="text" class="form-control" id="RECCOMUNE" name="RECCOMUNE" autocomplete="off" value="<?php echo $tab_studente['RECCOMUNE']; ?>" />
                </div>
            </div>            
            <div class="row" style="<?php echo $StyleIndirizzoRoma;?>" id="IndirizzoRomaCap">
                <div class="col-lg-3 mb-2" align="right">
                    <label for="RECCAP">
                        Cap *
                    </label>
                </div>
                <div class="col-lg-4 mb-2">
                    <input type="text" class="form-control" id="RECCAP" name="RECCAP" autocomplete="off" value="<?php echo $tab_studente['RECCAP']; ?>" />
                </div>
                
            </div>            
            <div class="row" style="<?php echo $StyleIndirizzoRoma;?>" id="IndirizzoRomaTelefono">
                <div class="col-lg-3 mb-2" align="right">
                    <label for="RECTELE">
                        Recapito tel.
                    </label>
                </div>
                <div class="col-lg-9 mb-2">
                    <input type="text" class="form-control" id="RECTELE" name="RECTELE" autocomplete="off" value="<?php echo $tab_studente['RECTELE']; ?>" />
                </div>
            </div>           

        </div>
    </div>
</div>