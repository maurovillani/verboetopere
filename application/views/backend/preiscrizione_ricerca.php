<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php //echo 'ciao'; ?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    
    <div class="row">
        <div class="col-lg-12 mb-2 mt-2">
            <h1 class="h3 mb-4 text-gray-800">Ricerca Preiscritti</h1>
        </div>
    </div>
    
<div class="row">
    <div class="col-lg-8 mb-1 ml-3">
        <div class="row">
            <div class="col-lg-4 mb-1">
                <?php //echo form_open('backend/datatable/studenti'); ?>
                <?php echo form_open('backend/preiscrizione_cartella/0'); ?>
                <div class="row">
                    <label for="CORSOLAUREA">Tipo iscrizione </label>
                    <select id="CORSOLAUREA" name="CORSOLAUREA" class="form-control">
                        <option selected='selected' value='tutti'></option>
                        <?php
                        foreach ($tab_corsidilaurea as $key => $value) {
                            if ($value['CODICENU']=='210' || $value['CODICENU']=='230') {
                                if(isset($CORSOLAUREA) && $value['CODICENU']===$CORSOLAUREA){
                                    echo "<option selected='selected' value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                                }else{
                                    echo "<option  value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                                }
                            }
                        }
                        ?>
                    </select>  
                </div>
                <div class="row">
                    <label for="CERTIFICATOPREISCRIZIONE">Richiesta Certificato preiscrizione</label>
                    <select id="CERTIFICATOPREISCRIZIONE" name="CERTIFICATOPREISCRIZIONE" class="form-control">
                        <option selected='selected' value='tutti'></option>
                        <option value='S'>SI</option>
                        <option value='N'>NO</option>
                    </select>  
                </div>
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <!--DIV PER SPAZIATURA DAL PULSANTE-->
                    </div>         
                    <input type="submit" class="btn btn-primary m-1" value="Cartella"></button>                
                    <!--<input type="submit" class="btn btn-primary" value="Elenco"></button>-->                
                    <?php echo form_close(); ?>    
                    <?php echo form_open(site_url('backend/preiscrizione_ricerca_azzera')); ?>
                    <input type="submit" class="btn btn-primary m-1" value="Azzera">     
                    <?php echo form_close(); ?>    
                    
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /.container-fluid -->
