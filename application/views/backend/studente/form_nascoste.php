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
<!-- INIZIO MASCHERA POP UP NASCOSTA NUOVO STUDENTE-->
    <div class="modal fade" id="NuovoStudente_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Nuovo studente</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <?php echo form_open('backend/new_record/studente'); ?>
                    <div class="row">
                        <div class="col-lg-12 mb-2 mt-2">
                            <div class="row">
                                <div class="col-lg-8 mb-2">
                                    <label for="MATRICOL">Matricola</label>
                                    <input type="text" class="form-control" id="MATRICOL" name="MATRICOL" value="<?php echo $max_matricola['MAX_MATRICOL'] ?>" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8 mb-2">
                                    <label for="COGNOME">Cognome</label>
                                    <input type="text" class="form-control" id="COGNOME" name="COGNOME" value="" required />
                                </div> 
                            </div> 
                            <div class="row">
                                <div class="col-lg-8 mb-2">
                                    <label for="NOMESTUD">Nome</label>
                                    <input type="text" class="form-control" id="NOMESTUD" name="NOMESTUD" value="" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8 mb-2">
                                    <label for="SESSO">Sesso</label>
                                    <select id="SESSO" name="SESSO" class="form-control" required>
                                        <option value=''></option>
                                        <option value='M'>M</option>
                                        <option value='F'>F</option>
                                    </select>       
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <!--DIV PER SPAZIATURA DAL PULSANTE-->
                                </div>
                            </div>    
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <button type="submit" class="btn btn-primary">Salva</button>
                                    &nbsp;
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>                   
                    <!-- fine -->                
                </div>
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA NUOVO STUDENTE-->    

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
                    <?php echo form_open('backend/delete_record/studente/' . $tab_studente['MATRICOL']); ?>
                    <div class="input-group">
                        <input type="hidden" id="MATRICOL_PREC" name="MATRICOL_PREC" value="<?php echo $tab_pulsanti_scheda[1]['MATRICOL']; ?>" />
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
<!-- FINE MASCHERA POP UP NASCOSTA PER ELIMINAZIONE RECORD ISCRIZIONE-->          

<!-- INIZIO MASCHERA POP UP NASCOSTA PER CARICAMENTO ED ELIMINAZIONE FOTO-->
    <div class="modal fade" id="CaricamentoFoto_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Caricamento foto</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php //echo $error;?>
                        <?php echo form_open_multipart('backend/do_upload/jpg/students/' . $tab_studente['MATRICOL'].'/_Foto'); ?>
                        <input type="file" name="userfile" size="20" />
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Carica foto" />
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
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
                    <h4 class="modal-title">Elimina Foto</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open('backend/delete_record/students_upload/' . $tab_studente['MATRICOL']); ?>
                        <br /><br />
                        <input type="hidden" id="tipo_documento" name="tipo_documento" value="_Foto">  
                        <input type="submit" class="btn btn-primary" value="Elimina file">  
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
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
                    <h4 class="modal-title">Caricamento Documento Identita</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php //echo $error;?>
                        <?php echo form_open_multipart('backend/do_upload/pdf/students/' . $tab_studente['MATRICOL'].'/_DocumentoIdentita'); ?>
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
    <div class="modal fade" id="EliminazioneDocumento_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Elimina Documento d'identità</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open('backend/delete_record/students_upload/' . $tab_studente['MATRICOL']); ?>
                        <br /><br />
                        <input type="hidden" id="tipo_documento" name="tipo_documento" value="_DocumentoIdentita">  
                        <input type="submit" class="btn btn-primary" value="Elimina file">  
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
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
                        <?php echo form_open_multipart('backend/do_upload/pdf/students/' . $tab_studente['MATRICOL'].'/_Celebret'); ?>
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
                        <?php echo form_open('backend/delete_record/students_upload/' . $tab_studente['MATRICOL']); ?>
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
                        <?php echo form_open_multipart('backend/do_upload/pdf/students/' . $tab_studente['MATRICOL'].'/_Greco'); ?>
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
                        <?php echo form_open('backend/delete_record/students_upload/' . $tab_studente['MATRICOL']); ?>
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
                        <?php echo form_open_multipart('backend/do_upload/pdf/students/' . $tab_studente['MATRICOL'].'/_Latino'); ?>
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
                        <?php echo form_open('backend/delete_record/students_upload/' . $tab_studente['MATRICOL']); ?>
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
                        <?php echo form_open_multipart('backend/do_upload/pdf/students/' . $tab_studente['MATRICOL'].'/_PermessoSoggiorno'); ?>
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
                        <?php echo form_open('backend/delete_record/students_upload/' . $tab_studente['MATRICOL']); ?>
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
                    <h4 class="modal-title">Caricamento Autorizzazione superiore religioso</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php //echo $error;?>
                        <?php echo form_open_multipart('backend/do_upload/pdf/students/' . $tab_studente['MATRICOL'].'/_AutorizzazioneSuperiore'); ?>
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
    <div class="modal fade" id="EliminazioneAutorizzazioneSuperiore_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Elimina Autorizzazione superiore religioso</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open('backend/delete_record/students_upload/' . $tab_studente['MATRICOL']); ?>
                        <br /><br />
                        <input type="hidden" id="tipo_documento" name="tipo_documento" value="_AutorizzazioneSuperiore">  
                        <input type="submit" class="btn btn-primary" value="Elimina file">  
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
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
                        <?php echo form_open_multipart('backend/do_upload/pdf/students/' . $tab_studente['MATRICOL'].'/_Privacy'); ?>
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
                        <?php echo form_open('backend/delete_record/students_upload/' . $tab_studente['MATRICOL']); ?>
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

<!-- INIZIO MASCHERA POP UP NASCOSTA PER CARICAMENTO ed ELIMINAZIONE PRESA IN CARICO-->
    <div class="modal fade" id="CaricamentoPresaInCarico_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Caricamento Presa in carico</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php //echo $error;?>
                        <?php echo form_open_multipart('backend/do_upload/pdf/students/' . $tab_studente['MATRICOL'].'/_PresaInCarico'); ?>
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
    <div class="modal fade" id="EliminazionePresaInCarico_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Elimina Presa in carico</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group">
                        <?php echo form_open('backend/delete_record/students_upload/' . $tab_studente['MATRICOL']); ?>
                        <br /><br />
                        <input type="hidden" id="tipo_documento" name="tipo_documento" value="_PresaInCarico">  
                        <input type="submit" class="btn btn-primary" value="Elimina file">  
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        <?php echo form_close(); ?>                  
                    </div>
                </div>                
            </div>
        </div>
    </div>
<!-- FINE MASCHERA POP UP NASCOSTA PER CARICAMENTE ed ELIMINAZIONE PRESA IN CARICO---->  

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
                        <?php echo form_open('backend/delete_record/students_upload/' . $tab_studente['MATRICOL']); ?>
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
                        <?php echo form_open_multipart('backend/do_upload_multipla/file/students/' . $tab_studente['MATRICOL'].'/_File'); ?>
                        <!--<input type="file" name="userfile" size="20" />-->
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


</div>