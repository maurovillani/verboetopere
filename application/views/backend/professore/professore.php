<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!--<style>
body {
    color: #000000;
}
</style>-->

<?php if (isset($tab_professore['MATRICOL'])): ?>
<script type="text/javascript">
function Controlla_NASCDATA(){
    <?php echo $campo_NASCDATA; ?>  
}    
function ConfermaInvio() {
    <?php echo $campo_NASCDATA; ?>  
    document.getElementById("myForm").submit();
}
</script>

<?php //if (isset($tab_professore['MATRICOL'])): ?>
    <?php echo $FormNascoste['html'] . PHP_EOL; ?>
<?php endif; ?>
   
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-9 mb-2 mt-2">
            <h1 class="h3 mb-4 text-gray-800"><?php echo $page_heading; ?></h1>
        </div>
        <div class="col-lg-3 mb-2 mt-2">
            <h1 class="h4 mb-4 text-gray-800"><?php echo 'Scheda '.$posizione.' di '.$numero_record['rec']; ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 mt-n4">
            <?php echo $Filtri; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 mb-2 card">
            <div class="card-body m-n3">
                <div class="d-flex flex-lg-row">
                <?php echo form_open(site_url('backend/professore/0')); ?>
                    <div class="d-flex justify-content-start">
                        <div class="p-1">
                            <div class="input-group">
                                <select class="custom-select" id="inputGroupSelect01" name="CampoFiltro">
                                    <?php if (isset($CampoFiltro)){ ?>
                                    <option value="COGNOME" <?php if ($CampoFiltro==='COGNOME') echo 'selected'; ?>>Cognome</option>
                                    <option value="MATRICOLA" <?php if ($CampoFiltro==='MATRICOLA') echo 'selected'; ?>>Matricola</option>
                                    <?php }else{ ?>
                                    <option value="COGNOME" selected>Cognome</option>
                                    <option value="MATRICOLA" >Matricola</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="p-1">
                            <div class="input-group">
                                <input type="text" class="custom-input" id="inputSearchValue" name="ValoreFiltro" value="<?php if (isset($ValoreFiltro)) echo $ValoreFiltro; ?>">
                                <div class="input-group-append">
                                    <!--<button class="btn btn-outline-secondary form-control" type="button"><i class="fas fa-search"></i></button>-->
                                    <input type="submit" class="btn btn-primary" value="Cerca">    
                                </div>
                            </div>
                        </div>
                    </div>
                <?php echo form_close(); ?>   
    <?php 
    $attributes = array('id' => 'myForm', 'name'=>'myForm');
    echo form_open(site_url('backend/edit_record/professore/'.$tab_professore['MATRICOL']),$attributes); ?>
                    <div class="d-flex justify-content-end">
                        <div class="p-1">
                            <div class="btn-toolbar justify-content-end" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="First group">
                                    <?php if (count($tab_pulsanti_scheda)>0):?>
                                    <?php if (isset($tab_pulsanti_scheda[0]['MATRICOL'])) echo anchor(site_url('backend/professore/'.$tab_pulsanti_scheda[0]['MATRICOL']), '<button type="button" class="btn btn-light"><i class="fas fa-step-backward"></i></button>');?>
                                    <?php if (isset($tab_pulsanti_scheda[1]['MATRICOL'])) echo anchor(site_url('backend/professore/'.$tab_pulsanti_scheda[1]['MATRICOL']), '<button type="button" class="btn btn-light"><i class="fas fa-arrow-left"></i></button>');?>
                                    <?php if (isset($tab_pulsanti_scheda[3]['MATRICOL'])) echo anchor(site_url('backend/professore/'.$tab_pulsanti_scheda[3]['MATRICOL']), '<button type="button" class="btn btn-light"><i class="fas fa-arrow-right"></i></button>');?>
                                    <?php if (isset($tab_pulsanti_scheda[4]['MATRICOL'])) echo anchor(site_url('backend/professore/'.$tab_pulsanti_scheda[4]['MATRICOL']), '<button type="button" class="btn btn-light"><i class="fas fa-step-forward"></i></button>');?>
                                    <?php endif;?>
                                    <!--<button type="button" class="btn btn-primary"><i class="fas fa-save"></i></button>-->
                                    <?php if (isset($tab_professore['MATRICOL'])): ?>
                                    <!--<input type="submit" class="btn btn-primary" data-toggle="modal" data-target="#ConfermaSalvataggio_Modal" value="Salva">-->  
                                        <input type="button" class="btn btn-primary" value="Salva" onclick="ConfermaInvio()">  
                                    <?php endif;?>
                                </div>
                                    &nbsp;&nbsp;
                                    <?php 
//                                    if(isset($tab_professore['MATRICOL']))
//                                        echo anchor(site_url('backend/professore_new/'.$tab_professore['MATRICOL']), 'Nuovo professore',["class"=>"btn btn-primary"]);
//                                    else
//                                        echo anchor(site_url('backend/professore_new/0'), 'Nuovo professore',["class"=>"btn btn-primary"]);
                                    ?>
                                    <a><button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#NuovoProfessore_Modal">Nuovo</button></a>
                                    &nbsp;&nbsp;
                                    <a><button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#EliminazioneRecord_Modal">Elimina</button></a>
                                    &nbsp;&nbsp;
                                    <?php
//                                    echo anchor(site_url('backend/studenti_ricerca/1'), '<button type="button" class="btn btn-primary">Torna ad elenco filtrato</button>');
                                    echo anchor(site_url('backend/professori_ricerca/1'), '<button type="button" class="btn btn-secondary">Torna ad elenco filtrato</button>');
                                    ?>
                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php if (!isset($tab_professore['MATRICOL'])): ?>
    NESSUN RECORD TROVATO
<?php else: ?>
    <div class="row">
        <div class="col-lg-5 mb-2">
            <label for="COGNOME">Cognome</label>
            <div class="input-group input-group-lg">
            <input type="text" class="form-control" id="COGNOME" name="COGNOME" value="<?php echo $tab_professore['COGNOME']; ?>" required />
            </div>
        </div>
        <div class="col-lg-5 mb-2">
            <label for="NOME">Nome</label>
            <div class="input-group input-group-lg">
            <input type="text" class="form-control" id="NOME" name="NOME" value="<?php echo $tab_professore['NOME']; ?>" required />
            </div>
        </div>
        <div class="col-lg-2 mb-2">
            <label for="MATRICOL">Matricola</label>
            <div class="input-group input-group-lg">
            <input type="text" class="form-control" id="MATRICOL" name="MATRICOL" value="<?php echo $tab_professore['MATRICOL']; ?>" required />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 mb-4">
            <!--DIV PER SPAZIATURA PRIMA DELLA TAB-->
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10 mb-1">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="<?php echo $tab1['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab1['id'] ?>" role="tab" aria-controls="home" aria-selected="true">
                        <?php echo $tab1['name'] ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="<?php echo $tab2['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab2['id'] ?>" role="tab" aria-controls="home" aria-selected="false">
                        <?php echo $tab2['name'] ?>
                    </a>
                </li>
<!--                <li class="nav-item">
                    <a class="nav-link" id="<?php echo $tab3['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab3['id'] ?>" role="tab" aria-controls="home" aria-selected="false">
                        <?php //echo $tab3['name'] ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="<?php echo $tab4['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab4['id'] ?>" role="tab" aria-controls="home"  aria-selected="false">
                        <?php //echo $tab4['name'] ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="<?php echo $tab5['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab5['id'] ?>" role="tab" aria-controls="home"  aria-selected="false">
                        <?php //echo $tab5['name'] ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="<?php echo $tab6['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab6['id'] ?>" role="tab" aria-controls="home"  aria-selected="false">
                        <?php //echo $tab6['name'] ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="<?php echo $tab7['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab7['id'] ?>" role="tab" aria-controls="home"  aria-selected="false">
                        <?php //echo $tab7['name'] ?>
                    </a>
                </li>-->
            </ul>
            <div class="tab-content" id="myTabContent">
                <?php echo $tab1['html'] . PHP_EOL; ?>
                <?php echo $tab2['html'] . PHP_EOL; ?>
                <?php //echo $tab3['html'] . PHP_EOL; ?>
                <?php //echo $tab4['html'] . PHP_EOL; ?>
                <?php //echo $tab5['html'] . PHP_EOL; ?>
                <?php //echo $tab6['html'] . PHP_EOL; ?>
                <?php //echo $tab7['html'] . PHP_EOL; ?>
            </div>
        </div>
        <div class="col-lg-2 mb-1">
            <div class="row">
                <div class="card" style="width: 18rem;">
                    <img src="<?php echo base_url('assets/images/professors/' . $tab_professore['MATRICOL'] . '.jpg'); ?>" class="card-img-top" alt="Foto non disponibile">
                    <div class="card-body">
                        <p class="card-text"></p>
                    </div>
    <?php echo form_close(); ?>   
                </div>
            </div>
            <div class="row">
                <a><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#CaricamentoFoto_Modal">Caricamento Foto</button></a>
            </div>
        </div>
        
    </div>
<?php endif; ?>
    
</div>
<!-- /.container-fluid -->