<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<?php if (isset($tab_studente['MATRICOL'])): ?>
    <?php echo $FormNascoste['html'] . PHP_EOL; ?>
    <?php echo $FormNascosteIscrizione['html'] . PHP_EOL; ?>
    <?php //echo $FormNascosteTitoliAccademici['html'] . PHP_EOL; ?>
    <?php 
    if(isset($tassa_attiva)):
        echo $FormNascosteTasse['html'] . PHP_EOL; 
    endif;
    ?>
    <?php //echo $FormNascosteCorsi['html'] . PHP_EOL; ?>
<?php endif; ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <?php echo form_open(site_url('backend/edit_record/self_studente/'.$tab_studente['MATRICOL'])); ?>
    <div class="row">
        <div class="col-lg-9 mb-2 mt-2">
            <h1 class="h3 mb-4 text-gray-800"><?php echo $page_heading; ?></h1>
        </div>
        <div class="col-lg-3 mb-2 mt-2">
            <?php if (isset($tab_studente['MATRICOL'])): ?>
            <input type="submit" class="btn btn-primary" data-toggle="modal" data-target="#ConfermaSalvataggio_Modal" value="Salva">  
        </div>
    </div>

<?php if (!isset($tab_studente['MATRICOL'])): ?>
    NESSUN RECORD TROVATO
<?php else: ?>
    <div>                
<?php endif;?>
        <div class="row">
            <div class="col-lg-5 mb-2">
                <label for="COGNOME">Cognome</label>
                <div class="input-group input-group-lg">
                <input type="text" class="form-control" id="COGNOME" name="COGNOME" value="<?php echo $tab_studente['COGNOME']; ?>" required />
                </div>
            </div>
            <div class="col-lg-5 mb-2">
                <label for="NOMESTUD">Nome</label>
                <div class="input-group input-group-lg">
                <input type="text" class="form-control" id="NOMESTUD" name="NOMESTUD" value="<?php echo $tab_studente['NOMESTUD']; ?>" required />
                </div>
            </div>
            <div class="col-lg-2 mb-2">
                <label for="MATRICOL">Matricola</label>
                <div class="input-group input-group-lg">
                <input type="text" class="form-control" id="MATRICOL" name="MATRICOL" value="<?php echo $tab_studente['MATRICOL']; ?>" readonly />
                </div>
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
                    <a class="<?php echo ($_SESSION['tab_attivo_studente']==='tab1'? 'nav-link active':'nav-link'); ?>" id="<?php echo $tab1['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab1['id'] ?>" role="tab" aria-controls="home" aria-selected="true">
                        <?php echo $tab1['name'] ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="<?php echo ($_SESSION['tab_attivo_studente']==='tab2'? 'nav-link active':'nav-link'); ?>" id="<?php echo $tab2['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab2['id'] ?>" role="tab" aria-controls="home" aria-selected="false">
                        <?php echo $tab2['name'] ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="<?php echo ($_SESSION['tab_attivo_studente']==='tab3'? 'nav-link active':'nav-link'); ?>" id="<?php echo $tab3['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab3['id'] ?>" role="tab" aria-controls="home" aria-selected="false">
                        <?php echo $tab3['name'] ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="<?php echo ($_SESSION['tab_attivo_studente']==='tab4'? 'nav-link active':'nav-link'); ?>" id="<?php echo $tab4['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab4['id'] ?>" role="tab" aria-controls="home"  aria-selected="false">
                        <?php echo $tab4['name'] ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="<?php echo ($_SESSION['tab_attivo_studente']==='tab5'? 'nav-link active':'nav-link'); ?>" id="<?php echo $tab5['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab5['id'] ?>" role="tab" aria-controls="home"  aria-selected="false">
                        <?php echo $tab5['name'] ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="<?php echo ($_SESSION['tab_attivo_studente']==='tab6'? 'nav-link active':'nav-link'); ?>" id="<?php echo $tab6['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab6['id'] ?>" role="tab" aria-controls="home"  aria-selected="false">
                        <?php echo $tab6['name'] ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="<?php echo ($_SESSION['tab_attivo_studente']==='tab7'? 'nav-link active':'nav-link'); ?>" id="<?php echo $tab7['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab7['id'] ?>" role="tab" aria-controls="home"  aria-selected="false">
                        <?php echo $tab7['name'] ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="<?php echo ($_SESSION['tab_attivo_studente']==='tab8'? 'nav-link active':'nav-link'); ?>" id="<?php echo $tab8['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab8['id'] ?>" role="tab" aria-controls="home"  aria-selected="false">
                        <?php echo $tab8['name'] ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="<?php echo ($_SESSION['tab_attivo_studente']==='tab9'? 'nav-link active':'nav-link'); ?>" id="<?php echo $tab9['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab9['id'] ?>" role="tab" aria-controls="home"  aria-selected="false">
                        <?php echo $tab9['name'] ?>
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <?php echo $tab1['html'] . PHP_EOL; ?>
                <?php echo $tab2['html'] . PHP_EOL; ?>
                <?php echo $tab3['html'] . PHP_EOL; ?>
                <?php echo $tab4['html'] . PHP_EOL; ?>
                <?php echo $tab5['html'] . PHP_EOL; ?>
                <?php echo $tab6['html'] . PHP_EOL; ?>
                <?php echo $tab7['html'] . PHP_EOL; ?>
                <?php echo $tab8['html'] . PHP_EOL; ?>
                <?php echo $tab9['html'] . PHP_EOL; ?>           
            </div>
        </div>
        <div class="col-lg-2 mb-1">
            <div class="row">
                <div class="card" style="width: 18rem;">
                    <img src="<?php echo base_url('assets/images/students/' . $tab_studente['MATRICOL'] . '.jpg'); ?>" class="card-img-top" alt="Foto non disponibile">
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