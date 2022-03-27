<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'form_nascoste';
?>

<div id="<?php echo $FormNascoste['id']; ?>">
<!-- INIZIO MASCHERA POP UP NASCOSTA PER CONFERMA SALVATAGGIO RECORD-->
    <div class="modal fade" id="ConfermaSalvataggio_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Attendere Record in Salvataggio</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER CONFERMA SALVATAGGIO RECORD-->           
    
<!-- INIZIO MASCHERA POP UP NASCOSTA PER CARICAMENTO ED ELIMINAZIONE FOTO-->
    <div class="modal fade" id="CaricamentoFoto_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                    <?php if($lingua=='IT'): ?>
                        Caricamento foto
                    <?php elseif($lingua=='IN'): ?>
                        Upload photos                        
                    <?php endif; ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php //echo $error;?>
                        <?php echo form_open_multipart('backend/do_upload/jpg/preiscrizione/' . $tab_studente['ID'].'/_Foto'); ?>
                        <input type="file" name="userfile" size="20" />
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Upload" />
                        &nbsp;
                        <?php if($lingua=='IT'): ?>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php elseif($lingua=='IN'): ?>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <?php endif; ?>
                        <?php echo form_close(); ?>                
                    </div>

                </div>
            </div>
        </div>
    </div>
<!-- ELIMINAZIONE -->
    <div class="modal fade" id="EliminazioneFoto_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                    <?php if($lingua=='IT'): ?>
                        Elimina Foto
                    <?php elseif($lingua=='IN'): ?>
                        Delete photos                        
                    <?php endif; ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open('backend/delete_record/preiscrizione_upload/' . $tab_studente['ID']); ?>
                        <br /><br />
                        <input type="hidden" id="tipo_documento" name="tipo_documento" value="_Foto">  
                        <?php if($lingua=='IT'): ?>
                            <input type="submit" class="btn btn-primary" value="Elimina file">  
                        <?php elseif($lingua=='IN'): ?>
                            <input type="submit" class="btn btn-primary" value="Delete file">  
                        <?php endif; ?>
                        &nbsp;
                        <?php if($lingua=='IT'): ?>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php elseif($lingua=='IN'): ?>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <?php endif; ?>
                        <?php echo form_close(); ?>                  
                    </div>
                </div>                
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER CARICAMENTO ed ELIMINAZIONE FOTO-->      

<!-- INIZIO MASCHERA POP UP NASCOSTA PER CARICAMENTO ed ELIMINAZIONE DOCUMENTO-->
    <div class="modal fade" id="CaricamentoDocumento_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                    <?php if($lingua=='IT'): ?>
                        Caricamento Documento Identita
                    <?php elseif($lingua=='IN'): ?>
                        Upload Identity document                        
                    <?php endif; ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php //echo $error;?>
                        <?php echo form_open_multipart('backend/do_upload/pdf/preiscrizione/' . $tab_studente['ID'].'/_DocumentoIdentita'); ?>
                        <input type="file" name="userfile" size="20" />
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Upload" />
                        &nbsp;
                        <?php if($lingua=='IT'): ?>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php elseif($lingua=='IN'): ?>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <?php endif; ?>
                        <?php echo form_close(); ?>                  
                    </div>

                </div>
            </div>
        </div>
    </div>
<!-- ELIMINAZIONE -->
    <div class="modal fade" id="EliminazioneDocumento_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                    <?php if($lingua=='IT'): ?>
                        Elimina Documento d'identitàù
                    <?php elseif($lingua=='IN'): ?>
                        Delete Identity document                        
                    <?php endif; ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open('backend/delete_record/preiscrizione_upload/' . $tab_studente['ID']); ?>
                        <br /><br />
                        <input type="hidden" id="tipo_documento" name="tipo_documento" value="_DocumentoIdentita">  
                        <?php if($lingua=='IT'): ?>
                            <input type="submit" class="btn btn-primary" value="Elimina file">  
                        <?php elseif($lingua=='IN'): ?>
                            <input type="submit" class="btn btn-primary" value="Delete file">  
                        <?php endif; ?>
                        &nbsp;
                        <?php if($lingua=='IT'): ?>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php elseif($lingua=='IN'): ?>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <?php endif; ?>
                        <?php echo form_close(); ?>                  
                    </div>
                </div>                
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER CARICAMENTO ed ELIMINAZIONE DOCUMENTO-->  

<!-- INIZIO MASCHERA POP UP NASCOSTA PER CARICAMENTO ed ELIMINAZIONE CELEBRET-->
    <div class="modal fade" id="CaricamentoCelebret_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Caricamento Celebret</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php //echo $error;?>
                        <?php echo form_open_multipart('backend/do_upload/pdf/preiscrizione/' . $tab_studente['ID'].'/_Celebret'); ?>
                        <input type="file" name="userfile" size="20" />
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Upload" />
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>

                </div>
            </div>
        </div>
    </div>
<!-- ELIMINAZIONE -->
    <div class="modal fade" id="EliminazioneCelebret_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Elimina Celebret</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open('backend/delete_record/preiscrizione_upload/' . $tab_studente['ID']); ?>
                        <br /><br />
                        <input type="hidden" id="tipo_documento" name="tipo_documento" value="_Celebret">  
                        <input type="submit" class="btn btn-primary" value="Elimina file">  
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>
                </div>                
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER CARICAMENTE ed ELIMINAZIONE CELEBRET-->  

<!-- INIZIO MASCHERA POP UP NASCOSTA PER CARICAMENTO ed ELIMINAZIONE GRECO-->
    <div class="modal fade" id="CaricamentoGreco_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Caricamento Greco</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php //echo $error;?>
                        <?php echo form_open_multipart('backend/do_upload/pdf/preiscrizione/' . $tab_studente['ID'].'/_Greco'); ?>
                        <input type="file" name="userfile" size="20" />
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Upload" />
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>

                </div>
            </div>
        </div>
    </div>
<!-- ELIMINAZIONE -->
    <div class="modal fade" id="EliminazioneGreco_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Elimina Greco</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open('backend/delete_record/preiscrizione_upload/' . $tab_studente['ID']); ?>
                        <br /><br />
                        <input type="hidden" id="tipo_documento" name="tipo_documento" value="_Greco">  
                        <input type="submit" class="btn btn-primary" value="Elimina file">  
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>
                </div>                
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER CARICAMENTE ed ELIMINAZIONE GRECO-->  

<!-- INIZIO MASCHERA POP UP NASCOSTA PER CARICAMENTO ed ELIMINAZIONE LATINO-->
    <div class="modal fade" id="CaricamentoLatino_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Caricamento Latino</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php //echo $error;?>
                        <?php echo form_open_multipart('backend/do_upload/pdf/preiscrizione/' . $tab_studente['ID'].'/_Latino'); ?>
                        <input type="file" name="userfile" size="20" />
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Upload" />
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>

                </div>
            </div>
        </div>
    </div>
<!-- ELIMINAZIONE -->
    <div class="modal fade" id="EliminazioneLatino_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Elimina Latino</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open('backend/delete_record/preiscrizione_upload/' . $tab_studente['ID']); ?>
                        <br /><br />
                        <input type="hidden" id="tipo_documento" name="tipo_documento" value="_Latino">  
                        <input type="submit" class="btn btn-primary" value="Elimina file">  
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>
                </div>                
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER CARICAMENTE ed ELIMINAZIONE LATINO-->  

<!-- INIZIO MASCHERA POP UP NASCOSTA PER CARICAMENTO ed ELIMINAZIONE pemessosogg-->
    <div class="modal fade" id="CaricamentoPermessoSoggiorno_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Caricamento Permesso di soggiorno</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php //echo $error;?>
                        <?php echo form_open_multipart('backend/do_upload/pdf/preiscrizione/' . $tab_studente['ID'].'/_PermessoSoggiorno'); ?>
                        <input type="file" name="userfile" size="20" />
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Upload" />
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>

                </div>
            </div>
        </div>
    </div>
<!-- ELIMINAZIONE -->
    <div class="modal fade" id="EliminazionePermessoSoggiorno_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Elimina Permesso di soggiorno</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open('backend/delete_record/preiscrizione_upload/' . $tab_studente['ID']); ?>
                        <br /><br />
                        <input type="hidden" id="tipo_documento" name="tipo_documento" value="_PermessoSoggiorno">  
                        <input type="submit" class="btn btn-primary" value="Elimina file">  
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>
                </div>                
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER CARICAMENTE ed ELIMINAZIONE pemessosogg---->  

<!-- INIZIO MASCHERA POP UP NASCOSTA PER CARICAMENTO ed ELIMINAZIONE AUTORIZZAZIONE SUPERIORE-->
    <div class="modal fade" id="CaricamentoAutorizzazioneSuperiore_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                    <?php if($lingua=='IT'): ?>
                        Caricamento Autorizzazione superiore religioso
                    <?php elseif($lingua=='IN'): ?>
                        Upload Authorization of religious superior                        
                    <?php endif; ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php //echo $error;?>
                        <?php echo form_open_multipart('backend/do_upload/pdf/preiscrizione/' . $tab_studente['ID'].'/_AutorizzazioneSuperiore'); ?>
                        <input type="file" name="userfile" size="20" />
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Upload" />
                        &nbsp;
                        <?php if($lingua=='IT'): ?>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php elseif($lingua=='IN'): ?>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <?php endif; ?>
                        <?php echo form_close(); ?>                  
                    </div>

                </div>
            </div>
        </div>
    </div>
<!-- ELIMINAZIONE -->
    <div class="modal fade" id="EliminazioneAutorizzazioneSuperiore_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                    <?php if($lingua=='IT'): ?>
                        Elimina Autorizzazione superiore religioso
                    <?php elseif($lingua=='IN'): ?>
                        Delete Authorization of religious superior                        
                    <?php endif; ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open('backend/delete_record/preiscrizione_upload/' . $tab_studente['ID']); ?>
                        <br /><br />
                        <input type="hidden" id="tipo_documento" name="tipo_documento" value="_AutorizzazioneSuperiore">  
                        <?php if($lingua=='IT'): ?>
                            <input type="submit" class="btn btn-primary" value="Elimina file">  
                        <?php elseif($lingua=='IN'): ?>
                            <input type="submit" class="btn btn-primary" value="Delete file">  
                        <?php endif; ?>
                        &nbsp;
                        <?php if($lingua=='IT'): ?>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php elseif($lingua=='IN'): ?>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <?php endif; ?>
                        <?php echo form_close(); ?>                  
                    </div>
                </div>                
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER CARICAMENTE ed ELIMINAZIONE AUTORIZZAZIONE SUPERIORE---->  

<!-- INIZIO MASCHERA POP UP NASCOSTA PER CARICAMENTO ed ELIMINAZIONE PRIVACY-->
    <div class="modal fade" id="CaricamentoPrivacy_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Caricamento Privacy</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php //echo $error;?>
                        <?php echo form_open_multipart('backend/do_upload/pdf/preiscrizione/' . $tab_studente['ID'].'/_Privacy'); ?>
                        <input type="file" name="userfile" size="20" />
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Upload" />
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>

                </div>
            </div>
        </div>
    </div>
<!-- ELIMINAZIONE -->
    <div class="modal fade" id="EliminazionePrivacy_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Elimina Privacy</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open('backend/delete_record/preiscrizione_upload/' . $tab_studente['ID']); ?>
                        <br /><br />
                        <input type="hidden" id="tipo_documento" name="tipo_documento" value="_Privacy">  
                        <input type="submit" class="btn btn-primary" value="Elimina file">  
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>
                </div>                
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER CARICAMENTE ed ELIMINAZIONE PRIVACY---->  

<!-- INIZIO MASCHERA POP UP NASCOSTA PER ELIMINAZIONE RECORD STUDENTE-->
    <div class="modal fade" id="EliminazioneRecord_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Eliminazione record</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <?php echo form_open('backend/delete_record/users/' . $tab_studente['ID'].'/preiscrizione'); ?>
                    <div class="input-group">
                        <h5>Sei sicuro di voler eliminare questo record?</h5>
                        <div><br/>
                        <button type="submit" class="btn btn-primary">Elimina</button>
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER ELIMINAZIONE RECORD-->      


<!-- INIZIO MASCHERA POP UP NASCOSTA PER CARICAMENTO ed ELIMINAZIONE PRESA IN CARICO-->
    <div class="modal fade" id="CaricamentoPresaInCarico_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                    <?php if($lingua=='IT'): ?>
                        Caricamento Presa in carico
                    <?php elseif($lingua=='IN'): ?>
                        Upload Assumption of responsibility
                    <?php endif; ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php //echo $error;?>
                        <?php echo form_open_multipart('backend/do_upload/pdf/preiscrizione/' . $tab_studente['ID'].'/_PresaInCarico'); ?>
                        <label for="PRESAINCARICO_RESP">
                            <?php if($lingua=='IT'): ?>
                                Responsabile Presa in carico *
                            <?php elseif($lingua=='IN'): ?>
                                Responsible for assumption of responsibility *
                            <?php endif; ?>
                        </label>
                        <input type="text" class="form-control" id="PRESAINCARICO_RESP" name="PRESAINCARICO_RESP" autocomplete="off" value="" required/>
                        <br />
                        <input type="file" name="userfile" size="20" />
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Upload" />
                        &nbsp;
                        <?php if($lingua=='IT'): ?>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php elseif($lingua=='IN'): ?>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <?php endif; ?>
                        <?php echo form_close(); ?>                  
                    </div>

                </div>
            </div>
        </div>
    </div>
<!-- ELIMINAZIONE -->
    <div class="modal fade" id="EliminazionePresaInCarico_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                    <?php if($lingua=='IT'): ?>
                        Elimina Presa in carico
                    <?php elseif($lingua=='IN'): ?>
                        Delete Assumption of responsibility
                    <?php endif; ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open('backend/delete_record/preiscrizione_upload/' . $tab_studente['ID']); ?>
                        <br /><br />
                        <input type="hidden" id="tipo_documento" name="tipo_documento" value="_PresaInCarico">  
                        <?php if($lingua=='IT'): ?>
                            <input type="submit" class="btn btn-primary" value="Elimina file">  
                        <?php elseif($lingua=='IN'): ?>
                            <input type="submit" class="btn btn-primary" value="Delete file">  
                        <?php endif; ?>
                        &nbsp;
                        <?php if($lingua=='IT'): ?>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php elseif($lingua=='IN'): ?>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <?php endif; ?>
                        <?php echo form_close(); ?>                  
                    </div>
                </div>                
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER CARICAMENTE ed ELIMINAZIONE PRESA IN CARICO---->  

<!-- INIZIO MASCHERA POP UP NASCOSTA PER CARICAMENTO ed ELIMINAZIONE TITOLO STUDIO-->
    <div class="modal fade" id="CaricamentoTitoloStudio_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                    <?php if($lingua=='IT'): ?>
                        Caricamento Titolo studio
                    <?php elseif($lingua=='IN'): ?>
                        Upload Study title 
                    <?php endif; ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php //echo $error;?>
                        <?php echo form_open_multipart('backend/do_upload/pdf/preiscrizione/' . $tab_studente['ID'].'/_TitoloStudio'); ?>
                        <input type="file" name="userfile" size="20" />
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Upload" />
                        &nbsp;
                        <?php if($lingua=='IT'): ?>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php elseif($lingua=='IN'): ?>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <?php endif; ?>
                        <?php echo form_close(); ?>                  
                    </div>

                </div>
            </div>
        </div>
    </div>
<!-- ELIMINAZIONE -->
    <div class="modal fade" id="EliminazioneTitoloStudio_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                    <?php if($lingua=='IT'): ?>
                        Elimina Titolo studio
                    <?php elseif($lingua=='IN'): ?>
                        Delete Study title 
                    <?php endif; ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open('backend/delete_record/preiscrizione_upload/' . $tab_studente['ID']); ?>
                        <br /><br />
                        <input type="hidden" id="tipo_documento" name="tipo_documento" value="_TitoloStudio">  
                        <?php if($lingua=='IT'): ?>
                            <input type="submit" class="btn btn-primary" value="Elimina file">  
                        <?php elseif($lingua=='IN'): ?>
                            <input type="submit" class="btn btn-primary" value="Delete file">  
                        <?php endif; ?>
                        &nbsp;
                        <?php if($lingua=='IT'): ?>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php elseif($lingua=='IN'): ?>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <?php endif; ?>
                        <?php echo form_close(); ?>                  
                    </div>
                </div>                
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER CARICAMENTE ed ELIMINAZIONE TITOLO STUDIO---->  

<!-- INIZIO MASCHERA POP UP NASCOSTA PER CARICAMENTO ed ELIMINAZIONE CERTIFICATO pREISCRIZIONE-->
    <div class="modal fade" id="CaricamentoCertificatoPreiscrizione_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Caricamento Certificato Preiscrizione</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php //echo $error;?>
                        <?php echo form_open_multipart('backend/do_upload/pdf/preiscrizione/' . $tab_studente['ID'].'/_CertificatoPreiscrizione'); ?>
                        <input type="file" name="userfile" size="20" />
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Upload" />
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>

                </div>
            </div>
        </div>
    </div>
<!-- ELIMINAZIONE -->
    <div class="modal fade" id="EliminazioneCertificatoPreiscrizione_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Elimina Certificato Preiscrizione</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open('backend/delete_record/preiscrizione_upload/' . $tab_studente['ID']); ?>
                        <br /><br />
                        <input type="hidden" id="tipo_documento" name="tipo_documento" value="_CertificatoPreiscrizione">  
                        <input type="submit" class="btn btn-primary" value="Elimina file">  
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>
                </div>                
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER CARICAMENTO ed CERTIFICATO PREISCRIZIONE---->  

<!-- INIZIO MASCHERA POP UP NASCOSTA PER CARICAMENTO ed ELIMINAZIONE ISTITUTO PROVENIENZA-->
    <div class="modal fade" id="CaricamentoAutorizzazioneIstitutoProvenienza_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                        Caricamento Autorizzazione Istituto Provenienza
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php //echo $error;?>
                        <?php echo form_open_multipart('backend/do_upload/pdf/preiscrizione/' . $tab_studente['ID'].'/_AutorizzazioneIstitutoProvenienza'); ?>
                        <input type="file" name="userfile" size="20" />
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Upload" />
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>

                </div>
            </div>
        </div>
    </div>
<!-- ELIMINAZIONE -->
    <div class="modal fade" id="EliminazioneAutorizzazioneIstitutoProvenienza_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                        Elimina Autorizzazione Istituto Provenienza
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open('backend/delete_record/preiscrizione_upload/' . $tab_studente['ID']); ?>
                        <br /><br />
                        <input type="hidden" id="tipo_documento" name="tipo_documento" value="_AutorizzazioneIstitutoProvenienza">  
                        <input type="submit" class="btn btn-primary" value="Elimina file">  
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>
                </div>                
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER CARICAMENTE ed ELIMINAZIONE AUTORIZZAZIONE ISTITUTO PROVENIENZA---->  

<!-- INIZIO MASCHERA POP UP NASCOSTA PER CARICAMENTO ed ELIMINAZIONE CERTIFICATO ISCRIZIONE ALTRA UNIVERSITA-->
    <div class="modal fade" id="CaricamentoCertificatoIscrizioneAltraUniv_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                        Caricamento Certificato Iscrizione Altra Università
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php //echo $error;?>
                        <?php echo form_open_multipart('backend/do_upload/pdf/preiscrizione/' . $tab_studente['ID'].'/_CertificatoIscrizioneAltraUniv'); ?>
                        <input type="file" name="userfile" size="20" />
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Upload" />
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>

                </div>
            </div>
        </div>
    </div>
<!-- ELIMINAZIONE -->
    <div class="modal fade" id="EliminazioneCertificatoIscrizioneAltraUniv_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                        Elimina Certificato Iscrizione Altra Università
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open('backend/delete_record/preiscrizione_upload/' . $tab_studente['ID']); ?>
                        <br /><br />
                        <input type="hidden" id="tipo_documento" name="tipo_documento" value="_CertificatoIscrizioneAltraUniv">  
                        <input type="submit" class="btn btn-primary" value="Elimina file">  
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>
                </div>                
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER CARICAMENTE ed ELIMINAZIONE CERTIFICATO ISCRIZIONE ALTRA UNIVERSITA--->  



<!-- INIZIO MASCHERA POP UP NASCOSTA PER CARICAMENTO ed ELIMINAZIONE TESI DI LICENZA-->
    <div class="modal fade" id="CaricamentoTesiLicenza_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                        Caricamento Tesi di Licenza
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php //echo $error;?>
                        <?php echo form_open_multipart('backend/do_upload/pdf/preiscrizione/' . $tab_studente['ID'].'/_TesiLicenza'); ?>
                        <input type="file" name="userfile" size="20" />
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Upload" />
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>

                </div>
            </div>
        </div>
    </div>
<!-- ELIMINAZIONE -->
    <div class="modal fade" id="EliminazioneTesiLicenza_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                        Elimina Tesi di Licenza
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open('backend/delete_record/preiscrizione_upload/' . $tab_studente['ID']); ?>
                        <br /><br />
                        <input type="hidden" id="tipo_documento" name="tipo_documento" value="_TesiLicenza">  
                        <input type="submit" class="btn btn-primary" value="Elimina file">  
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>
                </div>                
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER CARICAMENTE ed ELIMINAZIONE TESI DI LICENZA---->  

<!-- INIZIO MASCHERA POP UP NASCOSTA PER CARICAMENTO ed ELIMINAZIONE DICHIARAZIONE PERMANENZA A ROMA-->
    <div class="modal fade" id="CaricamentoDichiarazionePermanenzaRoma_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                        Caricamento Dichiarazione Pemanenza a Roma
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php //echo $error;?>
                        <?php echo form_open_multipart('backend/do_upload/pdf/preiscrizione/' . $tab_studente['ID'].'/_DichiarazionePermanenzaRoma'); ?>
                        <input type="file" name="userfile" size="20" />
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Upload" />
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>

                </div>
            </div>
        </div>
    </div>
<!-- ELIMINAZIONE -->
    <div class="modal fade" id="EliminazioneDichiarazionePermanenzaRoma_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                        Elimina Dichiarazione Pemanenza a Roma
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open('backend/delete_record/preiscrizione_upload/' . $tab_studente['ID']); ?>
                        <br /><br />
                        <input type="hidden" id="tipo_documento" name="tipo_documento" value="_DichiarazionePermanenzaRoma">  
                        <input type="submit" class="btn btn-primary" value="Elimina file">  
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>
                </div>                
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER CARICAMENTE ed ELIMINAZIONE DICHIARAZIONE PERMANENZA A ROMA---->  

<!-- INIZIO MASCHERA POP UP NASCOSTA PER CARICAMENTO ed ELIMINAZIONE QCER-A2-->
    <div class="modal fade" id="CaricamentoQCER_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                        Caricamento Cert. QCER-A2 italiano per stranieri
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php //echo $error;?>
                        <?php echo form_open_multipart('backend/do_upload/pdf/preiscrizione/' . $tab_studente['ID'].'/_QCERTA2'); ?>
                        <input type="file" name="userfile" size="20" />
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Upload" />
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>

                </div>
            </div>
        </div>
    </div>
<!-- ELIMINAZIONE -->
    <div class="modal fade" id="EliminazioneQCER_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                        Elimina Cert. QCERTA2 italiano per stranieri
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open('backend/delete_record/preiscrizione_upload/' . $tab_studente['ID']); ?>
                        <br /><br />
                        <input type="hidden" id="tipo_documento" name="tipo_documento" value="_QCERTA2">  
                        <input type="submit" class="btn btn-primary" value="Elimina file">  
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>
                </div>                
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER CARICAMENTE ed ELIMINAZIONE QCER-A2---->  

<!-- INIZIO MASCHERA POP UP NASCOSTA PER ELIMINAZIONE FILE---->  
<?php if(isset($elencofile)):  ?>
<?php foreach ($elencofile as $indice => $file): ?>
    <div class="modal fade" id="EliminazioneFile_Modal_<?php echo $indice;?>" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Elimina File</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open('backend/delete_record/preiscrizione_upload/' . $tab_studente['ID']); ?>
                        <br /><br />
                        <input type="hidden" id="tipo_documento" name="tipo_documento" value="_File">  
                        <input type="hidden" id="nome_file" name="nome_file" value="<?php echo $file;?>">  
                        <input type="submit" class="btn btn-primary" value="Elimina file">  
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>
                </div>                
            </div>
        </div>
    </div>
<?php endforeach;?>
<?php endif;?>
<!-- FINE MASCHERA POP UP NASCOSTA PER ELIMINAZIONE FILE---->  


<!-- INIZIO MASCHERA POP UP NASCOSTA PER CARICARE FILE-->
    <div class="modal fade" id="CaricaFile_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Carica File</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open_multipart('backend/do_upload_multipla/file/preiscrizione/' . $tab_studente['ID'].'/_File'); ?>
                        <!--<input type="file" name="userfile" size="20"/>-->
                        <input type="file" name="userfile[]" size="20" multiple/>
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Upload" />
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>

                </div>
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER CARICARE FILE---->  

<!-- INIZIO MASCHERA POP UP NASCOSTA PER INVIO EMAIL CERTIFICATO-->
    <div class="modal fade" id="InviaEmailCertificatoPreiscrizione_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Invia Email</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open_multipart('create_email_invio_certificato_preiscrizione/' . $tab_studente['ID']); ?>
                        Inviare email con allegato il certificato di preiscrizione?
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Invia" />
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>

                </div>
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER INVIO EMAIL CERTIFICATO---->  

<!-- INIZIO MASCHERA POP UP NASCOSTA PER AZZERAMENTO CATEGORIA STUDENTE-->
    <div class="modal fade" id="AzzeramentoCorsoLaurea_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Cambio Tipo iscrizione</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php //echo $error;?>
                        <?php echo form_open('backend/edit_record/preiscrizione_studente_corsolaurea/' . $tab_studente['ID']); ?>
                        <input type="submit" class="btn btn-primary" value="Cambia" />
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                
                    </div>

                </div>
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER AZZERAMENTO CATEGORIA STUDENTE---->  


</div>

