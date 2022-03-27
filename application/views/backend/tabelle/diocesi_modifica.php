<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php //echo 'ciao'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    
    <div class="row">
        <div class="col-lg-12 mb-2 mt-2">
            <h1 class="h3 mb-4 text-gray-800">Modifica Diocesi</h1>
        </div>
    </div>
    
<div class="row">
    <div class="col-lg-10 mb-1 ml-3">
        <div class="row">
            <div class="col-lg-6 mb-1">
                <?php echo form_open('backend/edit_record/diocesi/'.$tab_diocesi['CODICE']); ?>
                <div class="row">
                    <label for="DIOCESI">Nome Diocesi</label>
                    <input type="text" class="form-control" id="DIOCESI" name="DIOCESI" value="<?php echo $tab_diocesi['DIOCESI'];?>" required/>
                </div>
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <!--DIV PER SPAZIATURA DAL PULSANTE-->
                    </div>         
                </div>
                <div class="row">
                    <div class="col-lg-2 mb-4">
                    <input type="submit" class="btn btn-primary m-1" value="Salva"></button>                
                    </div>         
                    <div class="col-lg-2 mb-4">
                    <?php  
                    echo anchor(site_url('backend/delete_record/diocesi/'.$tab_diocesi['CODICE']), '<button type="button" class="btn btn-primary m-1">Elimina</button>'); 
                    ?>
                    </div>         
                    <?php echo form_close(); ?>    
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /.container-fluid -->
