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
                <div class="col-lg-8 mb-2 mt-2">
                    <label for="DATAAGGIORN">Data aggiornamento dati</label>
                </div>
                <div class="col-lg-4 mb-2">
                    <input type="text" class="form-control" id="DATAAGGIORN" name="DATAAGGIORN" value="<?php echo substr($tab_statodocumenti['DATAAGGIORN'],0,10);?>" placeholder="aaaa-mm-gg"  onchange="Controlla_DATAAGGIORN()"/>
                </div>
                <div class="col-lg-6 mb-2">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <?php if (!isset($tab_statodocumenti['FOTOGRAF']) || $tab_statodocumenti['FOTOGRAF']=='') $tab_statodocumenti['FOTOGRAF']='N';?>
                    <input type="hidden" id="FOTOGRAF" name="FOTOGRAF" value="<?php echo $tab_statodocumenti['FOTOGRAF']; ?>">
                    <input type="checkbox" <?php if ($tab_statodocumenti['FOTOGRAF']==='S') echo 'checked';?> disabled >
                    <label for="FOTOGRAF">Fotografia</label>
                    <?php if ($tab_statodocumenti['FOTOGRAF']=='S'):?>
                        <a title="elimina" data-toggle="modal" data-target="#EliminazioneFoto_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                    <?php else:?>
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoFoto_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                    <?php endif;?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <?php if (!isset($tab_statodocumenti['CERTNASC']) || $tab_statodocumenti['CERTNASC']=='') $tab_statodocumenti['CERTNASC']='N';?>
                    <input type="hidden" id="CERTNASC" name="CERTNASC" value="<?php echo $tab_statodocumenti['CERTNASC']; ?>">
                    <input type="checkbox" <?php if ($tab_statodocumenti['CERTNASC']==='S') echo 'checked';?> disabled>
                    <label for="CERTNASC">Documento identità</label>
                    <?php if ($tab_statodocumenti['CERTNASC']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/students/'.$tab_studente['MATRICOL'].'/DocumentoIdentita.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <a title="elimina" data-toggle="modal" data-target="#EliminazioneDocumento_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                    <?php else:?>
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoDocumento_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                    <?php endif;?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <?php if (!isset($tab_statodocumenti['AUTSUP']) || $tab_statodocumenti['AUTSUP']=='') $tab_statodocumenti['AUTSUP']='N';?>
                    <input type="hidden" id="AUTSUP" name="AUTSUP" value="<?php echo $tab_statodocumenti['AUTSUP']; ?>">
                    <input type="checkbox" <?php if ($tab_statodocumenti['AUTSUP']==='S') echo 'checked';?> disabled >
                    <label for="AUTSUP">Autorizzazione superiore religioso</label>
                    <?php if ($tab_statodocumenti['AUTSUP']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/students/'.$tab_studente['MATRICOL'].'/AutorizzazioneSuperiore.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
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
                    <label for="PRESAINCARICO">Presa in carico</label>
                    <?php if ($tab_studente['PRESAINCARICO']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_PresaInCarico.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <a title="elimina" data-toggle="modal" data-target="#EliminazionePresaInCarico_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                    <?php else:?>
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoPresaInCarico_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                    <?php endif;?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mb-2">
                    <?php if (!isset($tab_statodocumenti['permessosogg']) || $tab_statodocumenti['permessosogg']=='') $tab_statodocumenti['permessosogg']='N';?>
                    <input type="hidden" id="permessosogg" name="permessosogg" value="<?php echo $tab_statodocumenti['permessosogg']; ?>">
                    <input type="checkbox" <?php if ($tab_statodocumenti['permessosogg']==='S') echo 'checked';?> disabled>
                    <label for="permessosogg">Permesso soggiorno -> scadenza</label>
                    <?php if ($tab_statodocumenti['permessosogg']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/students/'.$tab_studente['MATRICOL'].'/PermessoSoggiorno.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <a title="elimina" data-toggle="modal" data-target="#EliminazionePermessoSoggiorno_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                    <?php else:?>
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoPermessoSoggiorno_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                    <?php endif;?>
                </div>
                <div class="col-lg-4 mb-2 mt-n2">
                    <input type="text" class="form-control" id="datascad_permessosogg" name="datascad_permessosogg" value="<?php echo substr($tab_statodocumenti['datascad_permessosogg'],0,10);?>" placeholder="aaaa-mm-gg"  onchange="Controlla_datascad_permessosogg()">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mb-2">
                    <label for="datascad_extracollegio">Data scadenza extracollegialità</label>
                </div>
                <div class="col-lg-4 mb-2 mt-n2">
                    <input type="text" class="form-control" id="datascad_extracollegio" name="datascad_extracollegio" value="<?php echo substr($tab_statodocumenti['datascad_extracollegio'],0,10);?>" placeholder="aaaa-mm-gg"  onchange="Controlla_datascad_extracollegio()">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <?php if (!isset($tab_statodocumenti['celebret']) || $tab_statodocumenti['celebret']=='') $tab_statodocumenti['celebret']='N';?>
                    <input type="hidden" id="celebret" name="celebret" value="<?php echo $tab_statodocumenti['celebret']; ?>">
                    <input type="checkbox" <?php if ($tab_statodocumenti['celebret']==='S') echo 'checked';?> disabled >
                    <label for="celebret">Celebret</label>
                    <?php if ($tab_statodocumenti['celebret']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/students/'.$tab_studente['MATRICOL'].'/Celebret.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <a title="elimina" data-toggle="modal" data-target="#EliminazioneCelebret_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                    <?php else:?>
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoCelebret_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                    <?php endif;?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <?php if (!isset($tab_statodocumenti['LATINO']) || $tab_statodocumenti['LATINO']=='') $tab_statodocumenti['LATINO']='N';?>
                    <input type="hidden" id="LATINO" name="LATINO" value="<?php echo $tab_statodocumenti['LATINO']; ?>">
                    <input type="checkbox" <?php if ($tab_statodocumenti['LATINO']==='S') echo 'checked';?> disabled>
                    <label for="LATINO">Latino</label>
                    <?php if ($tab_statodocumenti['LATINO']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/students/'.$tab_studente['MATRICOL'].'/Latino.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <a title="elimina" data-toggle="modal" data-target="#EliminazioneLatino_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                    <?php else:?>
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoLatino_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                    <?php endif;?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <?php if (!isset($tab_statodocumenti['GRECO']) || $tab_statodocumenti['GRECO']=='') $tab_statodocumenti['GRECO']='N';?>
                    <input type="hidden" id="GRECO" name="GRECO" value="<?php echo $tab_statodocumenti['GRECO']; ?>">
                    <input type="checkbox" <?php if ($tab_statodocumenti['GRECO']==='S') echo 'checked';?> disabled>
                    <label for="GRECO">Greco</label>
                    <?php if ($tab_statodocumenti['GRECO']=='S'):?>
                        <a title="visualizza" href="<?php echo base_url('assets/images/students/'.$tab_studente['MATRICOL'].'/Greco.pdf');?>" target="_blank"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-download'></i></span></a>        
                        <a title="elimina" data-toggle="modal" data-target="#EliminazioneGreco_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>                                     
                    <?php else:?>
                        <a title="upload" data-toggle="modal" data-target="#CaricamentoGreco_Modal"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-upload'></i></span></a>                                                  
                    <?php endif;?>
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
                <div class="col-lg-8 mb-2 mt-2">
                    <label for="PRIVACY">Firmato accordo privacy</label>
                </div>
                <div class="col-lg-4 mb-2">
                    <input type="text" class="form-control" id="PRIVACY" name="PRIVACY" value="<?php if(isset($tab_statodocumenti['PRIVACY'])) echo substr($tab_statodocumenti['PRIVACY'],0,10);?>" placeholder="aaaa-mm-gg"  onchange="Controlla_PRIVACY()">
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
