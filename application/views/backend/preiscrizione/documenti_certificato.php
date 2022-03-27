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
$StyleCertNascTipoAltro='visibility:visible';
if (!isset($tab_studente['CERTNASC_TIPO'])){
    $StyleCertNascTipoAltro='visibility:hidden';
}elseif($tab_studente['CERTNASC_TIPO']!='ALTRO'){
    $StyleCertNascTipoAltro='visibility:hidden';
}

?>
<div class="<?php echo $classe_tab; ?>" id="<?php echo $tab6['id'] ?>" role="tabpanel" aria-labelledby="<?php echo $tab6['id'] ?>-tab">
    <div class="row">
        <div class="col-lg-6 mb-2 mt-2">
            <?php if ($this->studente_model->IsPreiscrizione($_SESSION['user_id'])==='7'): ?> 
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <?php if($lingua=='IT'): ?>
                    <i>Il formato dei documenti richiesti è PDF
                    <br/>Per caricare il documento, premere per ogni file il pulsante <span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span>
                    </i>
                    <?php elseif($lingua=='IT'): ?>
                    <i>The format of the documents requested is PDF
                    <br/>To load the document, press the button for each file <span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span>
                    </i>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif;?>
        <?php if ($this->studente_model->IsSegreteria($_SESSION['user_id'])==='6'):?>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <?php if (!isset($tab_studente['CERTIFICATOPREISCRIZIONE_PDF']) || $tab_studente['CERTIFICATOPREISCRIZIONE_PDF']=='') $tab_studente['CERTIFICATOPREISCRIZIONE_PDF']='N';?>
                    <input type="hidden" id="CERTIFICATOPREISCRIZIONE_PDF" name="CERTIFICATOPREISCRIZIONE_PDF" value="<?php echo $tab_studente['CERTIFICATOPREISCRIZIONE_PDF']; ?>">
                    <input type="checkbox" <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE_PDF']==='S') echo 'checked';?> disabled >
                    <label for="CERTIFICATOPREISCRIZIONE_PDF">Cerficato Preiscrizione</label>
                    <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE_PDF']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_CertificatoPreiscrizione.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <a title="elimina" data-toggle="modal" data-target="#EliminazioneCertificatoPreiscrizione_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                        <a title="invia email" data-toggle="modal" data-target="#InviaEmailCertificatoPreiscrizione_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-at'></i></span></a>                                     
                    <?php else:?>
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoCertificatoPreiscrizione_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                    <?php endif;?>
                </div>
            </div>
        <?php endif;?>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <?php if (!isset($tab_studente['TITOLOSTUDIO_PDF']) || $tab_studente['TITOLOSTUDIO_PDF']=='') $tab_studente['TITOLOSTUDIO_PDF']='N';?>
                    <input type="hidden" id="TITOLOSTUDIO_PDF" name="TITOLOSTUDIO_PDF" value="<?php echo $tab_studente['TITOLOSTUDIO_PDF']; ?>">
                    <input type="checkbox" <?php if ($tab_studente['TITOLOSTUDIO_PDF']==='S') echo 'checked';?> disabled >
                    <label for="TITOLOSTUDIO_PDF">
                        <?php if($lingua=='IT'): ?>
                            Titolo studio (o almeno degli esami già sostenuti) *
                        <?php elseif($lingua=='IN'): ?>
                            Study title (or at least exams already taken) *
                        <?php endif; ?>
                    </label>
                    <?php if ($tab_studente['TITOLOSTUDIO_PDF']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_TitoloStudio.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <?php if ($this->studente_model->IsSegreteria($_SESSION['user_id'])==='6' || $this->studente_model->IsPreiscrizione($_SESSION['user_id'])==='7'): ?> 
                        <a title="elimina" data-toggle="modal" data-target="#EliminazioneTitoloStudio_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                        <?php endif;?>
                    <?php else:?>
                        <?php if ($this->studente_model->IsSegreteria($_SESSION['user_id'])==='6' || $this->studente_model->IsPreiscrizione($_SESSION['user_id'])==='7'): ?> 
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoTitoloStudio_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                        <?php endif;?>
                    <?php endif;?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                <?php if ($tab_studente['TITOLOSTUDIO_PDF']=='S'):?>
                    <?php if (!isset($tab_studente['AUTSUP']) || $tab_studente['AUTSUP']=='') $tab_studente['AUTSUP']='N';?>
                    <input type="hidden" id="AUTSUP" name="AUTSUP" value="<?php echo $tab_studente['AUTSUP']; ?>">
                    <input type="checkbox" <?php if ($tab_studente['AUTSUP']==='S') echo 'checked';?> disabled >
                    <label for="AUTSUP">
                        <?php if($lingua=='IT'): ?>
                            Autorizzazione superiore religioso *
                        <?php elseif($lingua=='IN'): ?>
                            Authorization of religious superior *
                        <?php endif; ?>
                    </label>
                    <?php if ($tab_studente['AUTSUP']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_AutorizzazioneSuperiore.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <?php if ($this->studente_model->IsSegreteria($_SESSION['user_id'])==='6' || $this->studente_model->IsPreiscrizione($_SESSION['user_id'])==='7'): ?> 
                        <a title="elimina" data-toggle="modal" data-target="#EliminazioneAutorizzazioneSuperiore_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                        <?php endif;?>
                    <?php else:?>
                        <?php if ($this->studente_model->IsSegreteria($_SESSION['user_id'])==='6' || $this->studente_model->IsPreiscrizione($_SESSION['user_id'])==='7'): ?> 
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoAutorizzazioneSuperiore_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                        <?php endif;?>
                    <?php endif;?>
                <?php endif;?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                <?php if ($tab_studente['AUTSUP']=='S'):?>
                    <?php if (!isset($tab_studente['PRESAINCARICO']) || $tab_studente['PRESAINCARICO']=='') $tab_studente['PRESAINCARICO']='N';?>
                    <input type="hidden" id="PRESAINCARICO" name="PRESAINCARICO" value="<?php echo $tab_studente['PRESAINCARICO']; ?>">
                    <input type="checkbox" <?php if ($tab_studente['PRESAINCARICO']==='S') echo 'checked';?> disabled >
                    <label for="PRESAINCARICO">
                        <?php if($lingua=='IT'): ?>
                            Presa in carico *
                        <?php elseif($lingua=='IN'): ?>
                            Assumption of responsibility *
                        <?php endif; ?>
                    </label>
                    <?php if ($tab_studente['PRESAINCARICO']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_PresaInCarico.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <?php if ($this->studente_model->IsSegreteria($_SESSION['user_id'])==='6' || $this->studente_model->IsPreiscrizione($_SESSION['user_id'])==='7'): ?> 
                        <a title="elimina" data-toggle="modal" data-target="#EliminazionePresaInCarico_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                        <?php endif;?>
                    <?php else:?>
                        <?php if ($this->studente_model->IsSegreteria($_SESSION['user_id'])==='6' || $this->studente_model->IsPreiscrizione($_SESSION['user_id'])==='7'): ?> 
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoPresaInCarico_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                        <?php endif;?>
                    <?php endif;?>
                <?php endif;?>        
                </div>
            </div>
            <div class="row">
                <?php if ($tab_studente['PRESAINCARICO']=='S'):?>
                <div class="col-lg-12 mb-2">
                    <label for="PRESAINCARICO_RESP">
                        <?php if($lingua=='IT'): ?>
                            Responsabile Presa in carico *
                        <?php elseif($lingua=='IN'): ?>
                            Responsible for assumption of responsibility *
                        <?php endif; ?>
                    </label>
                    <input type="text" class="form-control" id="PRESAINCARICO_RESP" name="PRESAINCARICO_RESP" autocomplete="off" value="<?php echo $tab_studente['PRESAINCARICO_RESP']; ?>" required/>
                </div>
                <?php endif;?>        
            </div>            
            <div class="row">
                <div class="col-lg-12 mb-2">
                <?php if ($tab_studente['PRESAINCARICO']=='S'):?>
                    <?php if (!isset($tab_studente['CERTNASC']) || $tab_studente['CERTNASC']=='') $tab_studente['CERTNASC']='N';?>
                    <input type="hidden" id="CERTNASC" name="CERTNASC" value="<?php echo $tab_studente['CERTNASC']; ?>">
                    <input type="checkbox" <?php if ($tab_studente['CERTNASC']==='S') echo 'checked';?> disabled>
                    <label for="CERTNASC">
                        <?php if($lingua=='IT'): ?>
                            Documento identità *
                        <?php elseif($lingua=='IN'): ?>
                            Identity document *
                        <?php endif; ?>
                    </label>
                    <?php if ($tab_studente['CERTNASC']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_DocumentoIdentita.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <?php if ($this->studente_model->IsSegreteria($_SESSION['user_id'])==='6' || $this->studente_model->IsPreiscrizione($_SESSION['user_id'])==='7'): ?> 
                        <a title="elimina" data-toggle="modal" data-target="#EliminazioneDocumento_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                        <?php endif;?>
                    <?php else:?>
                        <?php if ($this->studente_model->IsSegreteria($_SESSION['user_id'])==='6' || $this->studente_model->IsPreiscrizione($_SESSION['user_id'])==='7'): ?> 
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoDocumento_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                        <?php endif;?>
                    <?php endif;?>
                <?php endif;?>        
                </div>
            </div>
            <?php if ($tab_studente['CERTNASC']=='S'):?>
            <div class="row">
                <div class="col-lg-1 mb-2">
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="CERTNASC_TIPO">
                        <?php if($lingua=='IT'): ?>
                            Tipo documento *
                        <?php elseif($lingua=='IN'): ?>
                            Document type * 
                        <?php endif; ?>
                    </label>
                    <select id="CERTNASC_TIPO" name="CERTNASC_TIPO" class="form-control" onchange="VisualizzaCertNascTipoAltro()">
                        <option value=''></option>
                    <?php
                        if (!isset($tab_studente['CERTNASC_TIPO'])){
                            echo "<option value='PASSAPORTO'>Passaporto</option>";
                            echo "<option value='ALTRO'>Altro</option>";
                        }else{
                            if($tab_studente['CERTNASC_TIPO']==='PASSAPORTO'){
                                echo "<option selected='selected' value='PASSAPORTO'>Passaporto</option>";
                                echo "<option value='ALTRO'>Altro</option>";
                            } else {
                                echo "<option selected='selected' value='ALTRO'>Altro</option>";
                                echo "<option value='PASSAPORTO'>Passaporto</option>";
                            }     
                        }
                    ?>                                
                    </select> 
                </div>
                <div class="col-lg-5 mb-2" style="<?php echo $StyleCertNascTipoAltro;?>" id="CertNascTipoAltro">
                    <label for="CERTNASC_TIPO_ALTRO">
                        <?php if($lingua=='IT'): ?>
                            Specificare altro *
                        <?php elseif($lingua=='IN'): ?>
                            Specify other *
                        <?php endif; ?>
                    </label>
                    <input type="text" class="form-control" id="CERTNASC_TIPO_ALTRO" name="CERTNASC_TIPO_ALTRO" value="<?php echo $tab_studente['CERTNASC_TIPO_ALTRO'];?>"/>                    
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1 mb-2">
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="CERTNASC_NUMERO">
                        <?php if($lingua=='IT'): ?>
                            Numero documento *
                        <?php elseif($lingua=='IN'): ?>
                            Document number *
                        <?php endif; ?>
                    </label>
                    <input type="text" class="form-control" id="CERTNASC_NUMERO" name="CERTNASC_NUMERO" autocomplete="off" value="<?php echo $tab_studente['CERTNASC_NUMERO']; ?>" required/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1 mb-2">
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="CERTNASC_DATARILASCIO">
                        <?php if($lingua=='IT'): ?>
                            Data rilascio documento *
                        <?php elseif($lingua=='IN'): ?>
                            Document issue date *
                        <?php endif; ?>
                    </label>
                    <!--<input type="text" class="form-control" id="CERTNASC_DATARILASCIO" name="CERTNASC_DATARILASCIO" value="<?php echo substr($tab_studente['CERTNASC_DATARILASCIO'],0,10);?>" placeholder="aaaa-mm-gg" onchange="Controlla_CERTNASC_DATARILASCIO()">-->
                    <input type="text" class="form-control" id="CERTNASC_DATARILASCIO" name="CERTNASC_DATARILASCIO" value="<?php echo substr($tab_studente['CERTNASC_DATARILASCIO'],0,10);?>" placeholder="aaaa-mm-gg">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1 mb-2">
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="CERTNASC_DATASCADENZA">
                        <?php if($lingua=='IT'): ?>
                            Data scadenza documento *
                        <?php elseif($lingua=='IN'): ?>
                            Document expiration date *
                        <?php endif; ?>
                    </label>
                    <!--<input type="text" class="form-control" id="CERTNASC_DATASCADENZA" name="CERTNASC_DATASCADENZA" value="<?php echo substr($tab_studente['CERTNASC_DATASCADENZA'],0,10);?>" placeholder="aaaa-mm-gg" onchange="Controlla_CERTNASC_DATASCADENZA()">-->
                    <input type="text" class="form-control" id="CERTNASC_DATASCADENZA" name="CERTNASC_DATASCADENZA" value="<?php echo substr($tab_studente['CERTNASC_DATASCADENZA'],0,10);?>" placeholder="aaaa-mm-gg">
                </div>
            </div>
        <?php endif;?>
        </div>
<!--Pannello di destra-->        
        <div class="col-lg-6 mb-2 mt-2">
        <?php if ($tab_studente['CERTNASC']=='S'):?>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="COLLEGIO">
                        <?php if($lingua=='IT'): ?>
                            Indirizzo a Roma *
                        <?php elseif($lingua=='IN'): ?>
                            Address in Rome *
                        <?php endif; ?>
                    </label>
                    <select id="COLLEGIO" name="COLLEGIO" class="form-control" onchange="VisualizzaIndirizzoRoma()">
                        <option value=''></option>
                    <?php if($lingua=='IT'): ?>
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
                    <?php elseif($lingua=='IN'): ?>
                    <?php
                        if (!isset($tab_studente['COLLEGIO'])){
                            echo "<option value='0'>HOUSE</option>";
                            echo "<option value='-1'>COLLEGE</option>";
                        }else{
                            if($tab_studente['COLLEGIO']==='0'){
                                echo "<option selected='selected' value='0'>HOUSE</option>";
                                echo "<option value='-1'>COLLEGE</option>";
                            } else {
                                echo "<option selected='selected' value='-1'>COLLEGE</option>";
                                echo "<option value='0'>HOUSE</option>";
                            }     
                        }
                    ?> 
                    <?php endif; ?>
                    </select>                   
                </div>
            </div>
            <div class="row" style="<?php echo $StyleIndirizzoCollegio;?>" id="IndirizzoRomaCollegio">
                <div class="col-lg-12 mb-2">
                    <label for="COLLEGIO">
                        <?php if($lingua=='IT'): ?>
                            Nome Collegio *
                        <?php elseif($lingua=='IN'): ?>
                            Collage Name *
                        <?php endif; ?>
                    </label>
                    <div class="ui-widget">
                        <input type="search" class="form-control" id="collegio" value="<?php echo $tab_collegio['COLLEGIO']; ?>">
                        <input type="hidden" id="ID_collegio" name="ID_collegio" value="<?php echo $tab_studente['COLLEGIO']; ?>">
                    </div>
                </div>
            </div>
            <div class="row" style="<?php echo $StyleIndirizzoRoma;?>" id="IndirizzoRomaPresso">
                <div class="col-lg-3 mb-2" align="right">
                    <label for="RECPRES">
                        <?php if($lingua=='IT'): ?>
                            Presso 
                        <?php elseif($lingua=='IN'): ?>
                            At 
                        <?php endif; ?>
                    </label>
                </div>
                <div class="col-lg-9 mb-2">
                    <input type="text" class="form-control" id="RECPRES" name="RECPRES" value="<?php echo $tab_studente['RECPRES'];?>"/>
                </div>
            </div>
            <div class="row" style="<?php echo $StyleIndirizzoRoma;?>" id="IndirizzoRomaIndirizzo">
                <div class="col-lg-3 mb-2" align="right">
                    <label for="RECINDS">
                        <?php if($lingua=='IT'): ?>
                            Indirizzo *
                        <?php elseif($lingua=='IN'): ?>
                            Address *
                        <?php endif; ?>
                    </label>
                </div>
                <div class="col-lg-9 mb-2">
                    <input type="text" class="form-control" id="RECINDS" name="RECINDS" autocomplete="off" value="<?php echo $tab_studente['RECINDS']; ?>" />
                </div>
            </div>            
            <div class="row" style="<?php echo $StyleIndirizzoRoma;?>" id="IndirizzoRomaComune">
                <div class="col-lg-3 mb-2" align="right">
                    <label for="RECCOMUNE">
                        <?php if($lingua=='IT'): ?>
                            Comune *
                        <?php elseif($lingua=='IN'): ?>
                            Municipality or City *
                        <?php endif; ?>
                    </label>
                </div>
                <div class="col-lg-9 mb-2">
                    <input type="text" class="form-control" id="RECCOMUNE" name="RECCOMUNE" autocomplete="off" value="<?php echo $tab_studente['RECCOMUNE']; ?>" />
                </div>
            </div>            
            <div class="row" style="<?php echo $StyleIndirizzoRoma;?>" id="IndirizzoRomaCap">
                <div class="col-lg-3 mb-2" align="right">
                    <label for="RECCAP">
                        <?php if($lingua=='IT'): ?>
                            Cap *
                        <?php elseif($lingua=='IN'): ?>
                            Postal Code *
                        <?php endif; ?>
                    </label>
                </div>
                <div class="col-lg-4 mb-2">
                    <input type="text" class="form-control" id="RECCAP" name="RECCAP" autocomplete="off" value="<?php echo $tab_studente['RECCAP']; ?>" />
                </div>
                
            </div>            
            <div class="row" style="<?php echo $StyleIndirizzoRoma;?>" id="IndirizzoRomaTelefono">
                <div class="col-lg-3 mb-2" align="right">
                    <label for="RECTELE">
                        <?php if($lingua=='IT'): ?>
                            Recapito tel.
                        <?php elseif($lingua=='IN'): ?>
                            Phone number
                        <?php endif; ?>
                    </label>
                </div>
                <div class="col-lg-9 mb-2">
                    <input type="text" class="form-control" id="RECTELE" name="RECTELE" autocomplete="off" value="<?php echo $tab_studente['RECTELE']; ?>" />
                </div>
                
            </div>            
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <!--DIV PER SPAZIATURA PRIMA DELLA TAB-->
                </div>
            </div>    
        <?php endif;?>    
        </div>
    </div>
</div>
