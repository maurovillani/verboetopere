<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<script type="text/javascript">
function ConfermaInvio() {
    <?php 
        echo $campo_INIZIOISCRIZIONI_SEM1;
        echo $campo_FINEISCRIZIONI_SEM1;
        echo $campo_SCONTOISCRIZIONE_SEM1;
        echo $campo_INIZIOISCRCORSISEM_SEM1;
        echo $campo_FINEISCRIZIONISEMINARI_SEM1;
        echo $campo_FINEISCRIZIONICORSI_SEM1;
        echo $campo_INIZIOLEZIONI_SEM1;
        echo $campo_INIZIOPRENOTESAMI_SEM1;
        echo $campo_FINEPRENOTESAMI_SEM1;
        echo $campo_INIZIOPRENOTRECENSIONE;
        echo $campo_FINEPRENOTRECENSIONE;
        echo $campo_FINELEZIONI_SEM1;
        echo $campo_INIZIOESAMI_SEM1;
        echo $campo_FINEESAMI_SEM1;
        echo $campo_INIZIOISCRIZIONI_SEM2;
        echo $campo_FINEISCRIZIONI_SEM2;
        echo $campo_SCONTOISCRIZIONE_SEM2;
        echo $campo_INIZIOISCRCORSISEM_SEM2;
        echo $campo_FINEISCRIZIONISEMINARI_SEM2;
        echo $campo_FINEISCRIZIONICORSI_SEM2;
        echo $campo_INIZIOLEZIONI_SEM2;
        echo $campo_INIZIOPRENOTESAMI_SEM2;
        echo $campo_FINEPRENOTESAMI_SEM2;
        echo $campo_FINELEZIONI_SEM2;
        echo $campo_INIZIOESAMI_SEM2;
        echo $campo_FINEESAMI_SEM2;
    ?>
    document.getElementById("myForm").submit();
}
</script>
<!-- INIZIO MASCHERA POP UP NASCOSTA-->
<div id="<?php echo $FormNascoste['id']; ?>">
    <div class="modal fade" id="VerificaPassaggioSemestre_Modal" role="dialog">
        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Verifica passaggio semestre corso</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <?php echo form_open('backend/edit_record/verificapassaggiosemestrecorso/0'); ?>
                    <div class="input-group">
                        <h5>Aggiornare i semestri di corso</h5>
                        <h5> per gli studenti di licenza?</h5>
                        <div>
                        <br/>
                        <br/>
                            <button type="submit" class="btn btn-primary">Aggiorna</button>
                            &nbsp;
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                        </div>    
                    </div>
                    <?php echo form_close(); ?>      
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FINE MASCHERA POP UP NASCOSTA-->

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $page_heading; ?></h1>
    <?php 
        $attributes = array('id' => 'myForm', 'name'=>'myForm');
        echo form_open('backend/edit_record/scadenze/'.$tab_scadenze['ANNOACCADEMICO'],'autocomplete="off"',$attributes); 
        ?>
    <div class="row">
        <div class="col-lg-6 mb-2">
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <h5>Anno Accademico <b><?php echo ($tab_scadenze['ANNOACCADEMICO']-1).'-'.$tab_scadenze['ANNOACCADEMICO'];?></b></h5>
                    <input type="hidden" name="ANNOACCADEMICO" value="<?php echo $tab_scadenze['ANNOACCADEMICO'];?>">
                </div>
                <div class="col-lg-6 mb-2" align="right">
                    Anno attivo
                    <input type="hidden" name="ATTIVO" value="0">
                    <input type="checkbox" id="ATTIVO" name="ATTIVO" value="1" <?php if ($tab_scadenze['ATTIVO']==='1') echo 'checked';?> >
                    <input type="hidden" id="ATTIVO_OLD" name="ATTIVO_OLD" value="<?php echo $tab_scadenze['ATTIVO']; ?>">                    
                </div>
            </div>        
        </div>
        <div class="col-lg-6 mb-2" align="left">
            <div class="row">
                <div class="col-lg-6 mb-2">
                    Semestre attivo
                    <select name="SEMESTRE">
                        <?php
                        if ($tab_scadenze['SEMESTRE'] === '1' || !isset($tab_scadenze['SEMESTRE'])) {
                            echo "<option selected='selected' value='1'>1</option>";
                            echo "<option value='2'>2</option>";
                        } else {
                            echo "<option selected='selected' value='2'>2</option>";
                            echo "<option value='1'>1</option>";
                        }
                        ?>                                
                    </select>       
                </div>
                <div class="col-lg-6 mb-2" align="right">
                    <input type="submit" class="btn btn-primary" value="Salva">
                    &nbsp;&nbsp;
                    <?php
                        echo anchor(site_url('backend/datatable/scadenze'), '<button type="button" class="btn btn-primary">Vai ad elenco</button>');
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
<!--Pannello primo semestre-->        
        <div class="col-lg-6 mb-2 mt-2">
            <div class="p-3 mb-2 jumbotron text-dark">
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <p align="center"><b>I Semestre</b></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-2">
                        Inizio iscrizione
                        <input type="text" class="form-control" id="INIZIOISCRIZIONI_SEM1" name="INIZIOISCRIZIONI_SEM1" value="<?php echo $tab_scadenze['INIZIOISCRIZIONI_SEM1'];?>" placeholder="aaaa-mm-gg">
                    </div>
                    <div class="col-lg-4 mb-2">
                        Sconto
                        <input type="text" class="form-control" id="SCONTOISCRIZIONE_SEM1" name="SCONTOISCRIZIONE_SEM1" value="<?php echo $tab_scadenze['SCONTOISCRIZIONE_SEM1'];?>" placeholder="aaaa-mm-gg">
                    </div>
                    <div class="col-lg-4 mb-2">
                        Fine iscrizione
                        <input type="text" class="form-control" id="FINEISCRIZIONI_SEM1" name="FINEISCRIZIONI_SEM1" value="<?php echo $tab_scadenze['FINEISCRIZIONI_SEM1'];?>" placeholder="aaaa-mm-gg">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-2">
                        Inizio corsi e semin.
                        <input type="text" class="form-control" id="INIZIOISCRCORSISEM_SEM1" name="INIZIOISCRCORSISEM_SEM1" value="<?php echo $tab_scadenze['INIZIOISCRCORSISEM_SEM1'];?>" placeholder="aaaa-mm-gg">
                    </div>
                    <div class="col-lg-4 mb-2">
                        Fine corsi
                        <input type="text" class="form-control" id="FINEISCRIZIONICORSI_SEM1" name="FINEISCRIZIONICORSI_SEM1" value="<?php echo $tab_scadenze['FINEISCRIZIONICORSI_SEM1'];?>" placeholder="aaaa-mm-gg">
                    </div>
                    <div class="col-lg-4 mb-2">
                        Fine seminari
                        <input type="text" class="form-control" id="FINEISCRIZIONISEMINARI_SEM1" name="FINEISCRIZIONISEMINARI_SEM1" value="<?php echo $tab_scadenze['FINEISCRIZIONISEMINARI_SEM1'];?>" placeholder="aaaa-mm-gg">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-2">
                        Inizio lezioni
                        <input type="text" class="form-control" id="INIZIOLEZIONI_SEM1" name="INIZIOLEZIONI_SEM1" value="<?php echo $tab_scadenze['INIZIOLEZIONI_SEM1'];?>" placeholder="aaaa-mm-gg">
                    </div>
                    <div class="col-lg-4 mb-2">
                        Fine lezioni
                        <input type="text" class="form-control" id="FINELEZIONI_SEM1" name="FINELEZIONI_SEM1" value="<?php echo $tab_scadenze['FINELEZIONI_SEM1'];?>" placeholder="aaaa-mm-gg">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-2">
                        Inizio prenot. esami
                        <input type="text" class="form-control" id="INIZIOPRENOTESAMI_SEM1" name="INIZIOPRENOTESAMI_SEM1" value="<?php echo $tab_scadenze['INIZIOPRENOTESAMI_SEM1'];?>" placeholder="aaaa-mm-gg">
                    </div>
                    <div class="col-lg-4 mb-2">
                        Fine prenot. esami
                        <input type="text" class="form-control" id="FINEPRENOTESAMI_SEM1" name="FINEPRENOTESAMI_SEM1" value="<?php echo $tab_scadenze['FINEPRENOTESAMI_SEM1'];?>" placeholder="aaaa-mm-gg">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-2">
                        Inizio esami
                        <input type="text" class="form-control" id="INIZIOESAMI_SEM1" name="INIZIOESAMI_SEM1" value="<?php echo $tab_scadenze['INIZIOESAMI_SEM1'];?>" placeholder="aaaa-mm-gg">
                    </div>
                    <div class="col-lg-4 mb-2">
                        Fine esami
                        <input type="text" class="form-control" id="FINEESAMI_SEM1" name="FINEESAMI_SEM1" value="<?php echo $tab_scadenze['FINEESAMI_SEM1'];?>" placeholder="aaaa-mm-gg">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 mb-2">
                    Inizio prenot. recensioni
                    <input type="text" class="form-control" id="INIZIOPRENOTRECENSIONE" name="INIZIOPRENOTRECENSIONE" value="<?php echo $tab_scadenze['INIZIOPRENOTRECENSIONE'];?>" placeholder="aaaa-mm-gg">
                </div>
                <div class="col-lg-4 mb-2">
                    Fine prenot. recensioni
                    <input type="text" class="form-control" id="FINEPRENOTRECENSIONE" name="FINEPRENOTRECENSIONE" value="<?php echo $tab_scadenze['FINEPRENOTRECENSIONE'];?>" placeholder="aaaa-mm-gg">
                </div>
            </div>
        </div> 
<!--Pannello secondo-->        
        <div class="col-lg-6 mb-2 mt-2">
            <div class="p-3 mb-2 jumbotron text-dark">
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <p align="center"><b>II Semestre</b></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-2">
                        Inizio iscrizione
                        <input type="text" class="form-control" id="INIZIOISCRIZIONI_SEM2" name="INIZIOISCRIZIONI_SEM2" value="<?php echo $tab_scadenze['INIZIOISCRIZIONI_SEM2'];?>" placeholder="aaaa-mm-gg">
                    </div>
                    <div class="col-lg-4 mb-2">
                        Sconto
                        <input type="text" class="form-control" id="SCONTOISCRIZIONE_SEM2" name="SCONTOISCRIZIONE_SEM2" value="<?php echo $tab_scadenze['SCONTOISCRIZIONE_SEM2'];?>" placeholder="aaaa-mm-gg">
                    </div>
                    <div class="col-lg-4 mb-2">
                        Fine iscrizione
                        <input type="text" class="form-control" id="FINEISCRIZIONI_SEM2" name="FINEISCRIZIONI_SEM2" value="<?php echo $tab_scadenze['FINEISCRIZIONI_SEM2'];?>" placeholder="aaaa-mm-gg">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-2">
                        Inizio corsi e semin.
                        <input type="text" class="form-control" id="INIZIOISCRCORSISEM_SEM2" name="INIZIOISCRCORSISEM_SEM2" value="<?php echo $tab_scadenze['INIZIOISCRCORSISEM_SEM2'];?>" placeholder="aaaa-mm-gg">
                    </div>
                    <div class="col-lg-4 mb-2">
                        Fine corsi
                        <input type="text" class="form-control" id="FINEISCRIZIONICORSI_SEM2" name="FINEISCRIZIONICORSI_SEM2" value="<?php echo $tab_scadenze['FINEISCRIZIONICORSI_SEM2'];?>" placeholder="aaaa-mm-gg">
                    </div>
                    <div class="col-lg-4 mb-2">
                        Fine seminari
                        <input type="text" class="form-control" id="FINEISCRIZIONISEMINARI_SEM2" name="FINEISCRIZIONISEMINARI_SEM2" value="<?php echo $tab_scadenze['FINEISCRIZIONISEMINARI_SEM2'];?>" placeholder="aaaa-mm-gg">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-2">
                        Inizio lezioni
                        <input type="text" class="form-control" id="INIZIOLEZIONI_SEM2" name="INIZIOLEZIONI_SEM2" value="<?php echo $tab_scadenze['INIZIOLEZIONI_SEM2'];?>" placeholder="aaaa-mm-gg">
                    </div>
                    <div class="col-lg-4 mb-2">
                        Fine lezioni
                        <input type="text" class="form-control" id="FINELEZIONI_SEM2" name="FINELEZIONI_SEM2" value="<?php echo $tab_scadenze['FINELEZIONI_SEM2'];?>" placeholder="aaaa-mm-gg">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-2">
                        Inizio prenot. esami
                        <input type="text" class="form-control" id="INIZIOPRENOTESAMI_SEM2" name="INIZIOPRENOTESAMI_SEM2" value="<?php echo $tab_scadenze['INIZIOPRENOTESAMI_SEM2'];?>" placeholder="aaaa-mm-gg">
                    </div>
                    <div class="col-lg-4 mb-2">
                        Fine prenot. esami
                        <input type="text" class="form-control" id="FINEPRENOTESAMI_SEM2" name="FINEPRENOTESAMI_SEM2" value="<?php echo $tab_scadenze['FINEPRENOTESAMI_SEM2'];?>" placeholder="aaaa-mm-gg">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-2">
                        Inizio esami
                        <input type="text" class="form-control" id="INIZIOESAMI_SEM2" name="INIZIOESAMI_SEM2" value="<?php echo $tab_scadenze['INIZIOESAMI_SEM2'];?>" placeholder="aaaa-mm-gg">
                    </div>
                    <div class="col-lg-4 mb-2">
                        Fine esami
                        <input type="text" class="form-control" id="FINEESAMI_SEM2" name="FINEESAMI_SEM2" value="<?php echo $tab_scadenze['FINEESAMI_SEM2'];?>" placeholder="aaaa-mm-gg">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2" align="right">
                    <a><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#VerificaPassaggioSemestre_Modal">Conferma passaggio di corso per gli studenti di licenza</button></a>
                </div>
            </div>
        </div> 
</div>
<!-- /.container-fluid -->