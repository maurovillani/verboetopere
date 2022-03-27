<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!-- INIZIO MASCHERA POP UP NASCOSTA PER ELIMINAZIONE RECORD-->
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
        <div class="input-group">
            <h5>Sei sicuro di voler eliminare questo collegio?</h5>
            <br/><br/><br/>
        <?php 
            echo anchor(site_url('backend/delete_record/collegio/'.$tab_collegio['CODICE']), 'Elimina',["class"=>"btn btn-primary"]);
        ?>
            &nbsp;<button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
        </div>
        </div>
       </div>
    </div>
</div>
<!-- FINE MASCHERA POP UP NASCOSTA PER ELIMINAZIONE RECORD-->    


<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $page_heading; ?></h1>
    <?php echo form_open('backend/edit_record/collegio/'.$tab_collegio['CODICE'],'autocomplete="off"'); ?>
    <div class="row">
        <div class="col-lg-12 mb-2">
            <input type="submit" class="btn btn-primary" value="Salva">
            &nbsp;&nbsp;
            <a><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#EliminazioneRecord_Modal">Elimina collegio</button></a>
            &nbsp;&nbsp;
            <?php
                echo anchor(site_url('backend/datatable/collegi'), '<button type="button" class="btn btn-primary">Vai ad elenco</button>');
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-10 mb-2">
                    <label for="COLLEGIO">Nome Collegio</label>
                    <input type="text" class="form-control" id="COLLEGIO" name="COLLEGIO" autocomplete="off" value="<?php echo $tab_collegio['COLLEGIO']; ?>" />
                </div>
                <div class="col-lg-2 mb-2">
                    <label for="COLLEGIO">Codice pug</label>
                    <input type="text" class="form-control" id="codice_pug" name="codice_pug" autocomplete="off" value="<?php echo $tab_collegio['codice_pug']; ?>" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9 mb-2">
                    <label for="INDIRIZZO">Indirizzo</label>
                    <input type="text" class="form-control" id="INDIRIZZO" name="INDIRIZZO" autocomplete="off" value="<?php echo $tab_collegio['INDIRIZZO']; ?>" />
                </div>
                <div class="col-lg-3 mb-2">
                    <label for="CAP">Cap</label>
                    <input type="text" class="form-control" id="CAP" name="CAP" autocomplete="off" value="<?php echo $tab_collegio['CAP']; ?>" />
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="COMUNE">Comune</label>
                    <input type="text" class="form-control" id="COMUNE" name="COMUNE" autocomplete="off" value="<?php echo $tab_collegio['COMUNE']; ?>" />
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="PROVINCIA">Provincia</label>
                    <div class="ui-widget">
                        <input type="search" class="form-control" id="provincia" value="<?php echo $tab_collegio['PROVINCIA_ESTESA']; ?>">
                        <input type="hidden" id="ID_provincia" name="ID_provincia" value="<?php echo $tab_collegio['PROVINCIA']; ?>">
                    </div>
                    <?php //echo $searchProvincia; ?>
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="TELEFONO">Telefono</label>
                    <input type="text" class="form-control" id="TELEFONO" name="TELEFONO" autocomplete="off" value="<?php echo $tab_collegio['TELEFONO']; ?>" />
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="FAX">Fax</label>
                    <input type="text" class="form-control" id="FAX" name="FAX" autocomplete="off" value="<?php echo $tab_collegio['FAX']; ?>" />
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" autocomplete="off" value="<?php echo $tab_collegio['email']; ?>" />
                </div>
            </div>    
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="sito_web">Sito web</label>
                    <input type="text" class="form-control" id="sito_web" name="sito_web" autocomplete="off" value="<?php echo $tab_collegio['sito_web']; ?>" />
                </div>
            </div>    
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="descrizione_pubblicazioni">Descrizione pubblicazioni</label>
                    <input type="text" class="form-control" id="descrizione_pubblicazioni" name="descrizione_pubblicazioni" autocomplete="off" value="<?php echo $tab_collegio['descrizione_pubblicazioni']; ?>" />
                </div>
            </div>    
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="note">Note</label>
                    <textarea class="form-control" rows="2" id="note" name="note" value=""><?php echo $tab_collegio['note'];?></textarea>
                </div> 
            </div>            
            
        </div>
<!--Pannello di destra-->        
        <div class="col-lg-6 mb-2 mt-2">
    <!--Rettore-->  
            <div class="p-3 mb-2 jumbotron text-dark">
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <h5>Rettore</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-2 mb-2 mt-2">
                        <label for="rettore">&nbsp;&nbsp;&nbsp;&nbsp;Nome</label>
                    </div>    
                    <div class="col-lg-10 mb-2">
                        <input type="text" class="form-control" id="rettore" name="rettore" autocomplete="off" value="<?php echo $tab_collegio['rettore']; ?>" />
                    </div>
                </div>            
                <div class="row">
                    <div class="col-lg-2 mb-2 mt-2">
                        <label for="titolo_rettore">&nbsp;&nbsp;&nbsp;&nbsp;Tit. rettore</label>
                    </div>    
                    <div class="col-lg-4 mb-2">
                        <input type="text" class="form-control" id="titolo_rettore" name="titolo_rettore" autocomplete="off" value="<?php echo $tab_collegio['titolo_rettore']; ?>" />
                    </div>
                    <div class="col-lg-2 mb-2 mt-2">
                        <label for="titolo_vicerettore">&nbsp;&nbsp;Tit. viceret.</label>
                    </div>    
                    <div class="col-lg-4 mb-2">
                        <input type="text" class="form-control" id="titolo_vicerettore" name="titolo_vicerettore" autocomplete="off" value="<?php echo $tab_collegio['titolo_vicerettore']; ?>" />
                    </div>
                </div>    
                <div class="row">
                    <div class="col-lg-2 mb-2 mt-2">
                        <label for="tel_rettore">&nbsp;&nbsp;&nbsp;&nbsp;Telefono</label>
                    </div>    
                    <div class="col-lg-4 mb-2">
                        <input type="text" class="form-control" id="tel_rettore" name="tel_rettore" autocomplete="off" value="<?php echo $tab_collegio['tel_rettore']; ?>" />
                    </div>
                    <div class="col-lg-2 mb-2 mt-2">
                        <label for="email_rettore">&nbsp;&nbspEmail</label>
                    </div>    
                    <div class="col-lg-4 mb-2">
                        <input type="text" class="form-control" id="email_rettore" name="email_rettore" autocomplete="off" value="<?php echo $tab_collegio['email_rettore']; ?>" />
                    </div>
                </div>            
            </div>
    <!--Delegato-->  
            <div class="p-3 mb-2 jumbotron text-dark">
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <h5>Delegato</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-2 mb-2 mt-2">
                        <label for="delegato">&nbsp;&nbsp;&nbsp;&nbsp;Nome</label>
                    </div>    
                    <div class="col-lg-10 mb-2">
                        <input type="text" class="form-control" id="delegato" name="delegato" autocomplete="off" value="<?php echo $tab_collegio['delegato']; ?>" />
                    </div>
                </div>            
                <div class="row">
                    <div class="col-lg-2 mb-2 mt-2">
                        <label for="tel_delegato">&nbsp;&nbsp;&nbsp;&nbsp;Telefono</label>
                    </div>    
                    <div class="col-lg-4 mb-2">
                        <input type="text" class="form-control" id="tel_delegato" name="tel_delegato" autocomplete="off" value="<?php echo $tab_collegio['tel_delegato']; ?>" />
                    </div>
                    <div class="col-lg-2 mb-2 mt-2">
                        <label for="email_delegato">&nbsp;&nbsp;&nbsp;&nbsp;Email</label>
                    </div>    
                    <div class="col-lg-4 mb-2">
                        <input type="text" class="form-control" id="email_delegato" name="email_delegato" autocomplete="off" value="<?php echo $tab_collegio['email_delegato']; ?>" />
                    </div>
                </div>            
            </div>
    <!--Direttore Studi-->  
            <div class="p-3 mb-2 jumbotron text-dark">
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <h5>Direttore studi</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-2 mb-2 mt-2">
                        <label for="direttore_studi">&nbsp;&nbsp;&nbsp;&nbsp;Nome</label>
                    </div>    
                    <div class="col-lg-10 mb-2">
                        <input type="text" class="form-control" id="direttore_studi" name="direttore_studi" autocomplete="off" value="<?php echo $tab_collegio['direttore_studi']; ?>" />
                    </div>
                </div>            
                <div class="row">
                    <div class="col-lg-2 mb-2 mt-2">
                        <label for="tel_delegato">&nbsp;&nbsp;&nbsp;&nbsp;Telefono</label>
                    </div>    
                    <div class="col-lg-4 mb-2">
                        <input type="text" class="form-control" id="tel_dirstudi" name="tel_dirstudi" autocomplete="off" value="<?php echo $tab_collegio['tel_dirstudi']; ?>" />
                    </div>
                    <div class="col-lg-2 mb-2 mt-2">
                        <label for="email_dirstudi">&nbsp;&nbsp;&nbsp;&nbsp;Email</label>
                    </div>    
                    <div class="col-lg-4 mb-2">
                        <input type="text" class="form-control" id="email_dirstudi" name="email_dirstudi" autocomplete="off" value="<?php echo $tab_collegio['email_dirstudi']; ?>" />
                    </div>
                </div>            
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->