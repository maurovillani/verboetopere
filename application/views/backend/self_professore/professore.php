<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<?php if (isset($tab_professore['MATRICOL'])): ?>
    <?php echo $FormNascoste['html'] . PHP_EOL; ?>
<?php endif; ?>
   
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <?php echo form_open(site_url('backend/edit_record/professore/'.$tab_professore['MATRICOL'])); ?>
    <div class="row">
        <div class="col-lg-9 mb-2 mt-2">
            <h1 class="h3 mb-4 text-gray-800"><?php echo $page_heading; ?></h1>
        </div>
        <div class="col-lg-3 mb-2 mt-2">
            <?php if (isset($tab_professore['MATRICOL'])): ?>
            <input type="submit" class="btn btn-primary" data-toggle="modal" data-target="#ConfermaSalvataggio_Modal" value="Salva">  
        </div>
    </div>
<?php if (!isset($tab_professore['MATRICOL'])): ?>
    NESSUN RECORD TROVATO
<?php else: ?>
    <div>                
<?php endif;?>
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
            <input type="text" class="form-control" id="MATRICOL" name="MATRICOL" value="<?php echo $tab_professore['MATRICOL']; ?>" readonly />
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
            </ul>
            <div class="tab-content" id="myTabContent">
                <?php echo $tab1['html'] . PHP_EOL; ?>
                <?php echo $tab2['html'] . PHP_EOL; ?>
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