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
$StyleCertNascTipoAltro='visibility:visible';
if (!isset($tab_studente['CERTNASC_TIPO'])){
    $StyleCertNascTipoAltro='visibility:hidden';
}elseif($tab_studente['CERTNASC_TIPO']!='ALTRO'){
    $StyleCertNascTipoAltro='visibility:hidden';
}
$StyleCheckStraordinarioOspite='visibility:visible';
if ($tab_studente['CORSOLAUREA']>'800' && $CRUIPRO=='1'){
    $StyleCheckStraordinarioOspite='visibility:visible';
}else{
    $StyleCheckStraordinarioOspite='visibility:hidden';
}
?>
<div class="<?php echo $classe_tab; ?>" id="<?php echo $tab6['id'] ?>" role="tabpanel" aria-labelledby="<?php echo $tab6['id'] ?>-tab">
    <div class="row">
        <div class="col-lg-6 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <?php if (!isset($tab_studente['FOTOGRAF']) || $tab_studente['FOTOGRAF']=='') $tab_studente['FOTOGRAF']='N';?>
                    <input type="hidden" id="FOTOGRAF" name="FOTOGRAF" value="<?php echo $tab_studente['FOTOGRAF']; ?>">
                    <input type="checkbox" <?php if ($tab_studente['FOTOGRAF']==='S') echo 'checked';?> disabled >
                    <label for="FOTOGRAF">Fotografia <i>(formato jpg)</i> *</label>
                    <?php if ($tab_studente['FOTOGRAF']=='S'):?>
                        <a title="elimina" data-toggle="modal" data-target="#EliminazioneFoto_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                    <?php else:?>
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoFoto_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                    <?php endif;?>
                </div>
            </div>
        <?php if ($tipo_utente=='preiscrizione'): ?> 
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <i>Il formato dei documenti richiesti è PDF
                    <br/>Per caricare il documento, premere per ogni file il pulsante <span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span>
                    </i>
                </div>
            </div>
        <?php endif;?>
            <?php if ($tipo_utente=='segreteria'):?>
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
                    <label for="TITOLOSTUDIO_PDF">Titolo studio <i>(o almeno degli esami già sostenuti)</i> *</label>
                    <?php if ($tab_studente['TITOLOSTUDIO_PDF']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_TitoloStudio.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <a title="elimina" data-toggle="modal" data-target="#EliminazioneTitoloStudio_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                    <?php else:?>
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoTitoloStudio_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                    <?php endif;?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <?php if (!isset($tab_studente['AUTSUP']) || $tab_studente['AUTSUP']=='') $tab_studente['AUTSUP']='N';?>
                    <input type="hidden" id="AUTSUP" name="AUTSUP" value="<?php echo $tab_studente['AUTSUP']; ?>">
                    <input type="checkbox" <?php if ($tab_studente['AUTSUP']==='S') echo 'checked';?> disabled >
                    <label for="AUTSUP">Autorizzazione superiore religioso *</label>
                    <?php if ($tab_studente['AUTSUP']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_AutorizzazioneSuperiore.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <a title="elimina" data-toggle="modal" data-target="#EliminazioneAutorizzazioneSuperiore_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                    <?php else:?>
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoAutorizzazioneSuperiore_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                    <?php endif;?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <?php if (!isset($tab_studente['PRESAINCARICO']) || $tab_studente['PRESAINCARICO']=='') $tab_studente['PRESAINCARICO']='N';?>
                    <input type="hidden" id="PRESAINCARICO" name="PRESAINCARICO" value="<?php echo $tab_studente['PRESAINCARICO']; ?>">
                    <input type="checkbox" <?php if ($tab_studente['PRESAINCARICO']==='S') echo 'checked';?> disabled >
                    <label for="PRESAINCARICO">Presa in carico *</label>
                    <?php if ($tab_studente['PRESAINCARICO']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_PresaInCarico.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <a title="elimina" data-toggle="modal" data-target="#EliminazionePresaInCarico_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                    <?php else:?>
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoPresaInCarico_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                    <?php endif;?>
                </div>
            </div>
            <div class="row">
                <?php if ($tab_studente['PRESAINCARICO']=='S'):?>
                <div class="col-lg-12 mb-2">
                    <label for="PRESAINCARICO_RESP">
                        Responsabile Presa in carico *
                    </label>
                    <input type="text" class="form-control" id="PRESAINCARICO_RESP" name="PRESAINCARICO_RESP" autocomplete="off" value="<?php echo $tab_studente['PRESAINCARICO_RESP']; ?>" required/>
                </div>
                <?php endif;?>        
            </div>  
            <?php if ($tab_studente['CORSOLAUREA']>'800' && $CRUIPRO=='1'):?>
                <div class="row" style="<?php echo $StyleCheckStraordinarioOspite;?>" id="AutUniv">
                    <div class="col-lg-12 mb-2">
                        <?php if (!isset($tab_studente['AUT_UNIV']) || $tab_studente['AUT_UNIV']=='') $tab_studente['AUT_UNIV']='N';?>
                        <input type="hidden" id="AUT_UNIV" name="AUT_UNIV" value="<?php echo $tab_studente['AUT_UNIV']; ?>">
                        <input type="checkbox" <?php if ($tab_studente['AUT_UNIV']==='S') echo 'checked';?> disabled >
                        <label for="AUT_UNIV">Lettera di autorizzazione Istituto provenienza *</label>
                        <?php if ($tab_studente['AUT_UNIV']=='S'):?>
                            <a title="visualizza" href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_AutorizzazioneIstitutoProvenienza.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                            <a title="elimina" data-toggle="modal" data-target="#EliminazioneAutorizzazioneIstitutoProvenienza_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>
                        <?php else:?>
                            <a title="upload" data-toggle="modal" data-target="#CaricamentoAutorizzazioneIstitutoProvenienza_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>
                        <?php endif;?>
                    </div>
                </div>
            <?php endif;?>
            <?php if ($tab_studente['CORSOLAUREA']>'800' && (isset($tab_studente['ISTITUTO_PROVENIENZA']) || isset($tab_studente['ISTITUTO_PROVENIENZA_ALTRO']))):?>
                <div class="row" style="<?php echo $StyleCheckStraordinarioOspite;?>" id="CertIscrAltraUniv">
                    <div class="col-lg-12 mb-2">
                        <?php if (!isset($tab_studente['CERT_ISCR_ALTRA_UNIV']) || $tab_studente['CERT_ISCR_ALTRA_UNIV']=='') $tab_studente['CERT_ISCR_ALTRA_UNIV']='N';?>
                        <input type="hidden" id="CERT_ISCR_ALTRA_UNIV" name="CERT_ISCR_ALTRA_UNIV" value="<?php echo $tab_studente['CERT_ISCR_ALTRA_UNIV']; ?>">
                        <input type="checkbox" <?php if ($tab_studente['CERT_ISCR_ALTRA_UNIV']==='S') echo 'checked';?> disabled >
                        <label for="CERT_ISCR_ALTRA_UNIV">Certificato iscrizione altra università *</label>
                        <?php if ($tab_studente['CERT_ISCR_ALTRA_UNIV']=='S'):?>
                            <a title="visualizza" href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_CertificatoIscrizioneAltraUniv.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                            <a title="elimina" data-toggle="modal" data-target="#EliminazioneCertificatoIscrizioneAltraUniv_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>
                        <?php else:?>
                            <a title="upload" data-toggle="modal" data-target="#CaricamentoCertificatoIscrizioneAltraUniv_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>
                        <?php endif;?>
                    </div>
                </div>
            <?php endif;?>
            <?php if ($tab_studente['CORSOLAUREA']=='230'):?>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <?php if (!isset($tab_studente['TESI_LICENZA']) || $tab_studente['TESI_LICENZA']=='') $tab_studente['TESI_LICENZA']='N';?>
                    <input type="hidden" id="AUT_UNIV" name="TESI_LICENZA" value="<?php echo $tab_studente['TESI_LICENZA']; ?>">
                    <input type="checkbox" <?php if ($tab_studente['TESI_LICENZA']==='S') echo 'checked';?> disabled >
                    <label for="TESI_LICENZA">Tesi di licenza *</label>
                    <?php if ($tab_studente['TESI_LICENZA']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_TesiLicenza.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <a title="elimina" data-toggle="modal" data-target="#EliminazioneTesiLicenza_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>
                    <?php else:?>
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoTesiLicenza_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>
                    <?php endif;?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <?php if (!isset($tab_studente['DICHIARAZIONE_PERMANENZA_ROMA']) || $tab_studente['DICHIARAZIONE_PERMANENZA_ROMA']=='') $tab_studente['DICHIARAZIONE_PERMANENZA_ROMA']='N';?>
                    <input type="hidden" id="DICHIARAZIONE_PERMANENZA_ROMA" name="DICHIARAZIONE_PERMANENZA_ROMA" value="<?php echo $tab_studente['DICHIARAZIONE_PERMANENZA_ROMA']; ?>">
                    <input type="checkbox" <?php if ($tab_studente['DICHIARAZIONE_PERMANENZA_ROMA']==='S') echo 'checked';?> disabled >
                    <label for="DICHIARAZIONE_PERMANENZA_ROMA">Dichiarazione permanenza a Roma *</label>
                    <?php if ($tab_studente['DICHIARAZIONE_PERMANENZA_ROMA']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_DichiarazionePermanenzaRoma.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <a title="elimina" data-toggle="modal" data-target="#EliminazioneDichiarazionePermanenzaRoma_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>
                    <?php else:?>
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoDichiarazionePermanenzaRoma_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>
                    <?php endif;?>
                </div>
            </div>
            <?php endif;?>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <?php if (!isset($tab_studente['celebret']) || $tab_studente['celebret']=='') $tab_studente['celebret']='N';?>
                    <input type="hidden" id="celebret" name="celebret" value="<?php echo $tab_studente['celebret']; ?>">
                    <input type="checkbox" <?php if ($tab_studente['celebret']==='S') echo 'checked';?> disabled >
                    <label for="celebret">Celebret</label>
                    <?php if ($tab_studente['celebret']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_Celebret.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <a title="elimina" data-toggle="modal" data-target="#EliminazioneCelebret_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                    <?php else:?>
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoCelebret_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                    <?php endif;?>
                </div>
            </div>
            <div class="row">
                <?php 
                    $star='';
                    if ($tab_studente['CORSOLAUREA']<='250' || ($tab_studente['CORSOLAUREA']=='888' && $CRUIPRO=='0')) $star='*';
                ?>
                <div class="col-lg-12 mb-2">
                    <?php if (!isset($tab_studente['LATINO']) || $tab_studente['LATINO']=='') $tab_studente['LATINO']='N';?>
                    <input type="hidden" id="LATINO" name="LATINO" value="<?php echo $tab_studente['LATINO']; ?>">
                    <input type="checkbox" <?php if ($tab_studente['LATINO']==='S') echo 'checked';?> disabled>
                    <label for="LATINO">Latino <?php echo $star; ?></label>
                    <?php if ($tab_studente['LATINO']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_Latino.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <a title="elimina" data-toggle="modal" data-target="#EliminazioneLatino_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                    <?php else:?>
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoLatino_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                    <?php endif;?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <?php if (!isset($tab_studente['GRECO']) || $tab_studente['GRECO']=='') $tab_studente['GRECO']='N';?>
                    <input type="hidden" id="GRECO" name="GRECO" value="<?php echo $tab_studente['GRECO']; ?>">
                    <input type="checkbox" <?php if ($tab_studente['GRECO']==='S') echo 'checked';?> disabled>
                    <label for="GRECO">Greco <?php echo $star; ?></label>
                    <?php if ($tab_studente['GRECO']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_Greco.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <a title="elimina" data-toggle="modal" data-target="#EliminazioneGreco_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                    <?php else:?>
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoGreco_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                    <?php endif;?>
                </div>
            </div>
            <?php if ($tab_studente['CITTADI2']!='1' && $tab_studente['ITASTRANIERI_ESONERATO']=='0'):?>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <?php if (!isset($tab_studente['ITASTRANIERI']) || $tab_studente['ITASTRANIERI']=='') $tab_studente['ITASTRANIERI']='N';?>
                    <input type="hidden" id="ITASTRANIERI" name="ITASTRANIERI" value="<?php echo $tab_studente['ITASTRANIERI']; ?>">
                    <input type="checkbox" <?php if ($tab_studente['ITASTRANIERI']==='S') echo 'checked';?> disabled>
                    <label for="ITASTRANIERI">Cert. QCER-A2 italiano per stranieri *</label>
                    <?php if ($tab_studente['ITASTRANIERI']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_QCER-A2.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <a title="elimina" data-toggle="modal" data-target="#EliminazioneQCER_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                    <?php else:?>
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoQCER_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                    <?php endif;?>
                </div>
            </div>
            <?php endif;?>
            <?php if ($tipo_utente=='segreteria'): ?> 
            <div class="row">
                <div class="col-lg-9 mb-2">
                    <label for="ITASTRANIERI_ESONERO">Esonero Cert. QCER-A2 italiano per stranieri</label>
                </div>    
                <div class="col-lg-3 mb-2">
                <select id="ITASTRANIERI_ESONERO" name="ITASTRANIERI_ESONERO" class="form-control">
                <?php
                    if ($tab_studente['ITASTRANIERI_ESONERO']=='1'){
                        echo "<option selected='selected' value='1'>SI</option>";
                        echo "<option value='0'>NO</option>";
                    } else {
                        echo "<option selected='selected' value='0'>NO</option>";
                        echo "<option value='1'>SI</option>";
                    }     
                ?>                                
                </select>       
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mb-2 mt-2">
                    <label for="esame_ital">Esame interno d’italiano</label>
                </div>
                <div class="col-lg-4 mb-2">
                    <select id="esame_ital" name="esame_ital" class="form-control">
                    <?php
                        if (!isset($tab_studente['esame_ital'])) $tab_studente['esame_ital']='';
                        if($tab_studente['esame_ital']==='N'){
                            echo "<option selected='selected' value='N'>Non Superato</option>";
                            echo "<option value='S'>Superato</option>";
                            echo "<option value=''></option>";
                        } 
                        else if($tab_studente['esame_ital']===''){
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
            <?php endif; ?>
            <?php if ($tab_studente['CITTADI2']!='1'):?>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <?php if (!isset($tab_studente['permessosogg']) || $tab_studente['permessosogg']=='') $tab_studente['permessosogg']='N';?>
                    <input type="hidden" id="permessosogg" name="permessosogg" value="<?php echo $tab_studente['permessosogg']; ?>">
                    <input type="checkbox" <?php if ($tab_studente['permessosogg']==='S') echo 'checked';?> disabled>
                    <label for="permessosogg">Permesso soggiorno</label>
                    <?php if ($tab_studente['permessosogg']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_PermessoSoggiorno.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <a title="elimina" data-toggle="modal" data-target="#EliminazionePermessoSoggiorno_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                    <?php else:?>
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoPermessoSoggiorno_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                    <?php endif;?>
                </div>
            </div>
            <?php if ($tab_studente['permessosogg']=='S'):?>
            <div class="row">
                <div class="col-lg-8 mb-2">
                    Permesso soggiorno scadenza  
                </div>
                <div class="col-lg-4 mb-2 mt-n2">
                    <input type="text" class="form-control" id="datascad_permessosogg" name="datascad_permessosogg" value="<?php echo substr($tab_studente['datascad_permessosogg'],0,10);?>" placeholder="aaaa-mm-gg"/>
                </div>
            </div>
            <?php endif; ?>
            <?php endif; ?>
            <?php if ($tipo_utente=='segreteria' ): ?> 
            <div class="row">
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="AccordoPrivacy">Firmato accordo privacy</label>
                </div>
                <div class="col-lg-3 mb-2">
                    <select id="AccordoPrivacy" name="AccordoPrivacy" class="form-control">
                        <option value=''></option>
                    <?php
                        if ($tab_studente['AccordoPrivacy']==='S'){
                            echo "<option selected='selected' value='S'>SI</option>";
                            echo "<option value='N'>NO</option>";
                        } else {
                            echo "<option value='N'>NO</option>";
                            echo "<option value='S'>SI</option>";
                        }     
                    ?>                                
                    </select>       
                </div>
            </div>
            <?php endif; ?>
            
        </div>
<!--Pannello di destra-->        
        <div class="col-lg-6 mb-2 mt-2">
        <?php if ($doc_inseriti==1):?>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <?php if (!isset($tab_studente['CERTNASC']) || $tab_studente['CERTNASC']=='') $tab_studente['CERTNASC']='N';?>
                    <input type="hidden" id="CERTNASC" name="CERTNASC" value="<?php echo $tab_studente['CERTNASC']; ?>">
                    <input type="checkbox" <?php if ($tab_studente['CERTNASC']==='S') echo 'checked';?> disabled>
                    <label for="CERTNASC">Documento identità *</label>
                    <?php if ($tab_studente['CERTNASC']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_DocumentoIdentita.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <a title="elimina" data-toggle="modal" data-target="#EliminazioneDocumento_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                    <?php else:?>
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoDocumento_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                    <?php endif;?>
                </div>
            </div>
            <?php if ($tab_studente['CERTNASC']=='S'):?>
            <div class="row">
                <div class="col-lg-1 mb-2">
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="CERTNASC_TIPO">
                        Tipo documento *
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
                        Specificare altro *
                    </label>
                    <input type="text" class="form-control" id="CERTNASC_TIPO_ALTRO" name="CERTNASC_TIPO_ALTRO" value="<?php echo $tab_studente['CERTNASC_TIPO_ALTRO'];?>"/>                    
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1 mb-2">
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="CERTNASC_NUMERO">
                        Numero documento *
                    </label>
                    <input type="text" class="form-control" id="CERTNASC_NUMERO" name="CERTNASC_NUMERO" autocomplete="off" value="<?php echo $tab_studente['CERTNASC_NUMERO']; ?>" required/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1 mb-2">
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="CERTNASC_DATARILASCIO">
                        Data rilascio documento *
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
                        Data scadenza documento *
                    </label>
                    <!--<input type="text" class="form-control" id="CERTNASC_DATASCADENZA" name="CERTNASC_DATASCADENZA" value="<?php echo substr($tab_studente['CERTNASC_DATASCADENZA'],0,10);?>" placeholder="aaaa-mm-gg" onchange="Controlla_CERTNASC_DATASCADENZA()">-->
                    <input type="text" class="form-control" id="CERTNASC_DATASCADENZA" name="CERTNASC_DATASCADENZA" value="<?php echo substr($tab_studente['CERTNASC_DATASCADENZA'],0,10);?>" placeholder="aaaa-mm-gg">
                </div>
            </div>
            <?php endif;?>
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <!--DIV PER SPAZIATURA PRIMA DELLA TAB-->
                </div>
            </div> 

            <?php if (isset($tab_studente['CERTNASC_DATASCADENZA'])):?>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <h5>Lingue conosciute</h5>
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-4 mb-2 ml-5 mt-2">
                    <label for="PRIMALINGUA">Prima lingua*</label>
                </div>
                <div class="col-lg-5 mb-2">
                    <select id="PRIMALINGUA" name="PRIMALINGUA" class="form-control">
                        <option value="0"></option>
                    <?php
                        foreach ($tab_lingue_moderne as $key => $value) {
                            if($value['CODICENU'] === $tab_studente['PRIMALINGUA']){
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
                <?php 
                    $star='';
                    if ($tab_studente['CORSOLAUREA']!='999' || ($tab_studente['CORSOLAUREA']=='999' && $CRUIPRO=='1')) $star='*';
                ?>
                <div class="col-lg-4 mb-2 ml-5 mt-2">
                    <label for="SECLINGUA">Seconda lingua <?php echo $star; ?></label>
                </div>
                <div class="col-lg-5 mb-2">
                    <select id="SECLINGUA" name="SECLINGUA" class="form-control">
                        <option value="0"></option>
                    <?php
                        foreach ($tab_lingue_moderne as $key => $value) {
                            if($value['CODICENU'] === $tab_studente['SECLINGUA']){
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
                <?php 
                    $star='';
                    if ($tab_studente['CORSOLAUREA']<='250') $star='*';
                ?>
                <div class="col-lg-4 mb-2 ml-5 mt-2">
                    <label for="TERLINGUA">Terza lingua <?php echo $star; ?></label>
                </div>
                <div class="col-lg-5 mb-2">
                    <select id="TERLINGUA" name="TERLINGUA" class="form-control">
                        <option value="0"></option>
                    <?php
                        foreach ($tab_lingue_moderne as $key => $value) {
                            if($value['CODICENU'] === $tab_studente['TERLINGUA']){
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
                <div class="col-lg-4 mb-2 ml-5 mt-2">
                    <label for="QUALINGUA">Quarta lingua</label>
                </div>
                <div class="col-lg-5 mb-2">
                    <select id="QUALINGUA" name="QUALINGUA" class="form-control">
                        <option value="0"></option>
                    <?php
                        foreach ($tab_lingue_moderne as $key => $value) {
                            if($value['CODICENU'] === $tab_studente['QUALINGUA']){
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
            <?php endif;?>
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <!--DIV PER SPAZIATURA PRIMA DELLA TAB-->
                </div>
            </div>    
        <?php endif;?>
        </div>
    </div>
</div>
