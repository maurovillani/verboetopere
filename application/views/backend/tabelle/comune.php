<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $page_heading; ?></h1>
    <?php echo form_open('backend/edit_record/comune/'.$tab_comune['CODICECOMUNE']); ?>
    <div class="row">
        <div class="col-lg-6 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="DECODIF">Nome Comune</label>
                    <input type="text" class="form-control" id="DECODIF" name="DECODIF" autocomplete="off" value="<?php echo $tab_comune['DECODIF']; ?>" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="PROVINCIA">Provincia</label>
                    <?php echo $searchProvincia; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="NAZIONE">Nazione</label>
                    <?php echo $searchNazione; ?>
                </div>
            </div> 
            <div class="row">
                <div class="col-lg-12 mb-2">
                <!--DIV PER SPAZIATURA DAL PULSANTE-->
                </div>
            </div>    
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <input type="submit" class="btn btn-primary" value="Salva"></button>     
                    <?php echo anchor(site_url('backend/datatable/comuni'), '<button type="button" class="btn btn-primary">Torna ad elenco</button>');?>
                </div>
            </div>
        </div>
    </div>
     <?php echo form_close(); ?>                
</div>
<!-- /.container-fluid -->