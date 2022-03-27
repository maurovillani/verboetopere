<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'documenti_requisiti';
$classe_tab='tab-pane fade';
if($_SESSION['tab_attivo_studente']==='tab6') $classe_tab .='  fade  show active';
?>
<div class="<?php echo $classe_tab; ?>" id="<?php echo $tab6['id'] ?>" role="tabpanel" aria-labelledby="<?php echo $tab6['id'] ?>-tab">
    <div class="row">
        <div class="col-lg-6 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="DATAAGGIORN">Data aggiornamento dati</label>
                </div>
                <div class="col-lg-6 mb-2">
                    <input type="date" class="form-control" id="DATAAGGIORN" name="DATAAGGIORN" value="<?php echo substr($tab_statodocumenti['DATAAGGIORN'],0,10);?>"/>
                </div>
                <div class="col-lg-6 mb-2">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <input type="hidden" name="FOTOGRAF" value="N">
                    <input type="checkbox" id="FOTOGRAF" name="FOTOGRAF" value="S" <?php if ($tab_statodocumenti['FOTOGRAF']==='S') echo 'checked';?> >
                    <input type="hidden" id="FOTOGRAF_OLD" name="FOTOGRAF_OLD" value="<?php echo $tab_statodocumenti['FOTOGRAF']; ?>">                    
                    <label for="FOTOGRAF">Fotografia</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <input type="hidden" name="CERTNASC" value="N">
                    <input type="checkbox" id="CERTNASC" name="CERTNASC" value="S" <?php if ($tab_statodocumenti['CERTNASC']==='S') echo 'checked';?> >
                    <input type="hidden" id="CERTNASC_OLD" name="CERTNASC_OLD" value="<?php echo $tab_statodocumenti['CERTNASC']; ?>">                    
                    <label for="CERTNASC">Documento identità</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <input type="hidden" name="AUTSUP" value="N">
                    <input type="checkbox" id="AUTSUP" name="AUTSUP" value="S" <?php //if ($tab_statodocumenti['AUTSUP']==='S') echo 'checked';?> >
                    <input type="hidden" id="AUTSUP_OLD" name="AUTSUP_OLD" value="<?php //echo $tab_statodocumenti['AUTSUP']; ?>">                    
                    <label for="CERTNASC">Autorizzazione superiore religioso</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <input type="hidden" name="permessosogg" value="N">
                    <input type="checkbox" id="permessosogg" name="permessosogg" value="S" <?php if ($tab_statodocumenti['permessosogg']==='S') echo 'checked';?> >
                    <input type="hidden" id="permessosogg_OLD" name="pemessosogg_OLD" value="<?php echo $tab_statodocumenti['permessosogg']; ?>">                    
                    <label for="CERTNASC">Permesso soggiorno -> scadenza</label>
                </div>
                <div class="col-lg-6 mb-2 mt-n2">
                    <input type="date" class="form-control" id="datascad_permessosogg" name="datascad_permessosogg" value="<?php echo substr($tab_statodocumenti['datascad_permessosogg'],0,10);?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="datascad_extracollegio">Data scadenza extracollegialità</label>
                </div>
                <div class="col-lg-6 mb-2 mt-n2">
                    <input type="date" class="form-control" id="datascad_extracollegio" name="datascad_extracollegio" value="<?php echo substr($tab_statodocumenti['datascad_extracollegio'],0,10);?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <input type="hidden" name="celebret" value="N">
                    <input type="checkbox" id="celebret" name="celebret" value="S" <?php if ($tab_statodocumenti['celebret']==='S') echo 'checked';?> >
                    <input type="hidden" id="celebret_OLD" name="celebret_OLD" value="<?php echo $tab_statodocumenti['celebret']; ?>">                    
                    <label for="celebret">Celebret</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <input type="hidden" name="LATINO" value="N">
                    <input type="checkbox" id="LATINO" name="LATINO" value="S" <?php if ($tab_statodocumenti['LATINO']==='S') echo 'checked';?> >
                    <input type="hidden" id="LATINO_OLD" name="LATINO_OLD" value="<?php echo $tab_statodocumenti['LATINO']; ?>">                    
                    <label for="LATINO">Latino</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <input type="hidden" name="GRECO" value="N">
                    <input type="checkbox" id="greco" name="GRECO" value="S" <?php if ($tab_statodocumenti['GRECO']==='S') echo 'checked';?> >
                    <input type="hidden" id="GRECO_OLD" name="GRECO_OLD" value="<?php echo $tab_statodocumenti['GRECO']; ?>">                    
                    <label for="GRECO">Greco</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <input type="hidden" name="ITASTRANIERI" value="N">
                    <input type="checkbox" id="ITASTRANIERI" name="ITASTRANIERI" value="S" <?php if ($tab_statodocumenti['ITASTRANIERI']==='S') echo 'checked';?> >
                    <input type="hidden" id="ITASTRANIERI_OLD" name="ITASTRANIERI_OLD" value="<?php echo $tab_statodocumenti['ITASTRANIERI']; ?>">                    
                    <label for="ITASTRANIERI_OLD">Cert. QCER-A2 italiano per stranieri</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="esame_ital">Esame interno d’italiano</label>
                </div>
                <div class="col-lg-6 mb-2">
                    <select id="esame_ital" name="esame_ital" class="form-control">
                        <option value=""></option>
                    <?php
                        if (!isset($tab_statodocumenti['esame_ital'])) $tab_statodocumenti['esame_ital']='';
                        if($tab_statodocumenti['esame_ital']==='N'){
                            echo "<option selected='selected' value='N'>Non Superato</option>";
                            echo "<option value='S'>Superato</option>";
                            echo "<option value=''></option>";
                        } 
                        else if($tab_statodocumenti['esame_ital']===''){
                            echo "<option value='N'>Non Superato</option>";
                            echo "<option value='S'>Superato</option>";
                            echo "<option selected='selected' value=''></option>";
                        } 
                        else  {
                            echo "<option selected='selected' value='S'>Superato</option>";
                            echo "<option value='N'>Non Superato</option>";
                            echo "<option value=''></option>";
                        }                            
                    ?>                                
                    </select>       
                </div>
            </div>
        </div>
<!--Pannello di destra-->        
        <div class="col-lg-6 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="PRIVACY">Firmato accordo privacy</label>
                </div>
                <div class="col-lg-6 mb-2">
                    <input type="date" class="form-control" id="PRIVACY" name="PRIVACY" value="<?php if(isset($tab_statodocumenti['PRIVACY'])) echo substr($tab_statodocumenti['PRIVACY'],0,10);?>"/>
                </div>
                <div class="col-lg-6 mb-2">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <!--DIV PER SPAZIATURA PRIMA DELLA TAB-->
                </div>
            </div>    
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <h5>Lingue conosciute</h5>
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-3 mb-2 ml-5 mt-2">
                    <label for="PRIMALINGUA">Prima lingua</label>
                </div>
                <div class="col-lg-6 mb-2">
                    <select id="PRIMALINGUA" name="PRIMALINGUA" class="form-control">
                        <option value="">--- Seleziona una lingua ---</option>
                    <?php
                        foreach ($tab_lingue_moderne as $key => $value) {
                            if($value['CODICENU'] === $tab_statodocumenti['PRIMALINGUA']){
                                echo "<option selected='selected' value='".$value['CODICENU']."'>".$value['CITTADINANZA']."</option>";
                            } else {
                                echo "<option  value='".$value['CODICENU']."'>".$value['CITTADINANZA']."</option>";
                            }                            
                        }
                    ?>                                
                    </select>                   
                </div> 
            </div>
            <div class="row">
                <div class="col-lg-3 mb-2 ml-5 mt-2">
                    <label for="SECLINGUA">Seconda lingua</label>
                </div>
                <div class="col-lg-6 mb-2">
                    <select id="SECLINGUA" name="SECLINGUA" class="form-control">
                        <option value="">--- Seleziona una lingua ---</option>
                    <?php
                        foreach ($tab_lingue_moderne as $key => $value) {
                            if($value['CODICENU'] === $tab_statodocumenti['SECLINGUA']){
                                echo "<option selected='selected' value='".$value['CODICENU']."'>".$value['CITTADINANZA']."</option>";
                            } else {
                                echo "<option  value='".$value['CODICENU']."'>".$value['CITTADINANZA']."</option>";
                            }                            
                        }
                    ?>                                
                    </select>                   
                </div> 
            </div>
            <div class="row">
                <div class="col-lg-3 mb-2 ml-5 mt-2">
                    <label for="TERLINGUA">Terza lingua</label>
                </div>
                <div class="col-lg-6 mb-2">
                    <select id="TERLINGUA" name="TERLINGUA" class="form-control">
                        <option value="">--- Seleziona una lingua ---</option>
                    <?php
                        foreach ($tab_lingue_moderne as $key => $value) {
                            if($value['CODICENU'] === $tab_statodocumenti['TERLINGUA']){
                                echo "<option selected='selected' value='".$value['CODICENU']."'>".$value['CITTADINANZA']."</option>";
                            } else {
                                echo "<option  value='".$value['CODICENU']."'>".$value['CITTADINANZA']."</option>";
                            }                            
                        }
                    ?>                                
                    </select>                   
                </div> 
            </div>
            <div class="row">
                <div class="col-lg-3 mb-2 ml-5 mt-2">
                    <label for="QUALINGUA">Quarta lingua</label>
                </div>
                <div class="col-lg-6 mb-2">
                    <select id="QUALINGUA" name="QUALINGUA" class="form-control">
                        <option value="">--- Seleziona una lingua ---</option>
                    <?php
                        foreach ($tab_lingue_moderne as $key => $value) {
                            if($value['CODICENU'] === $tab_statodocumenti['QUALINGUA']){
                                echo "<option selected='selected' value='".$value['CODICENU']."'>".$value['CITTADINANZA']."</option>";
                            } else {
                                echo "<option  value='".$value['CODICENU']."'>".$value['CITTADINANZA']."</option>";
                            }                            
                        }
                    ?>                                
                    </select>                   
                </div> 
            </div> 
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <!--DIV PER SPAZIATURA PRIMA DELLA TAB-->
                </div>
            </div>    
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="STATODOC_NOTA">Note</label>
                    <textarea class="form-control" rows="3" id="STATODOC_NOTA" name="STATODOC_NOTA" value=""><?php if(isset($tab_statodocumenti['NOTA']))echo $tab_statodocumenti['NOTA'];?></textarea>
                </div> 
            </div>            
            
        </div>
    </div>
</div>
