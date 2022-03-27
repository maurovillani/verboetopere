<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php //echo 'ciao'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    
    <div class="row">
        <div class="col-lg-12 mb-2 mt-2">
            <h1 class="h3 mb-4 text-gray-800">Ricerca Studenti</h1>
        </div>
    </div>
    
<div class="row">
    <div class="col-lg-10 mb-1 ml-3">
        <div class="row">
            <div class="col-lg-4 mb-1">
                <?php //echo form_open('backend/datatable/studenti'); ?>
                <?php echo form_open('backend/studenti_cartella/0'); ?>
                <div class="row">
                    <label for="COGNOME">Cognome</label>
                    <input type="text" class="form-control" id="COGNOME" name="COGNOME" value="<?php if(isset($COGNOME)) echo $COGNOME; ?>" />
                </div>
                <div class="row">
                    <label for="MATRICOL">Matricola</label>
                    <input type="text" class="form-control" id="MATRICOL" name="MATRICOL" value="<?php if(isset($COGNOME)) echo $MATRICOL; ?>" />
                </div>
                <div class="row">
                    <label for="ANNOACCA">Anno Accademico</label>
                    <select id="ANNOACCA" name="ANNOACCA" class="form-control">
                        <option selected='selected' value='tutti'></option>
                        <?php
                        foreach ($tab_anno_accademico as $key => $value) {
                            if(isset($ANNOACCA) && $value['ANNOACCA']===$ANNOACCA){
                                echo "<option selected='selected' value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                            }else{
                                echo "<option  value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                            }
                        }
                        ?>
                    </select>  
                </div>
                <div class="row">
                    <label for="ANNOCORSO">Anno di Corso <i>(scegliere l'anno accademico)</i></label>
                    <select id="ANNOCORSO" name="ANNOCORSO" class="form-control">
                        <option selected='selected' value='tutti'></option>
                        <option <?php if(isset($ANNOCORSO) && $ANNOCORSO==='1') echo "selected='selected"; ?> value='1'>1</option>
                        <option <?php if(isset($ANNOCORSO) && $ANNOCORSO==='2') echo "selected='selected"; ?> value='2'>2</option>
                        <option <?php if(isset($ANNOCORSO) && $ANNOCORSO==='fuori corso') echo "selected='selected"; ?> value='fuori corso'>fuori corso</option>
                    </select>                        
                </div>
                <div class="row">
                    <label for="CATEGORIA">Categoria studente <i>(scegliere l'anno accademico)</i></label>
                    <select id="CATEGORIA" name="CATEGORIA" class="form-control">
                        <option selected='selected' value='tutti'></option>
                        <option <?php if(isset($CATEGORIA) && $CATEGORIA==='ORD') echo "selected='selected"; ?> value='ORD'>Ordinario</option>
                        <option <?php if(isset($CATEGORIA) && $CATEGORIA==='OSP') echo "selected='selected"; ?> value='OSP'>Ospite</option>
                        <option <?php if(isset($CATEGORIA) && $CATEGORIA==='STR') echo "selected='selected"; ?> value='STR'>Straordinario</option>
                    </select>  
                </div> 
                <div class="row">
                    <label for="CORSOLAUREA">Corso laurea <i>(scegliere l'anno accademico)</i></label>
                    <select id="CORSOLAUREA" name="CORSOLAUREA" class="form-control">
                        <option selected='selected' value='tutti'></option>
                        <?php
                        foreach ($tab_corsidilaurea as $key => $value) {
                            if(isset($CORSOLAUREA) && $value['CODICENU']===$CORSOLAUREA){
                                echo "<option selected='selected' value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                            }else{
                                echo "<option  value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                            }
                        }
                        ?>
                    </select>  
                </div>
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <!--DIV PER SPAZIATURA DAL PULSANTE-->
                    </div>         
                    <input type="submit" class="btn btn-primary m-1" value="Cartella"></button>                
                    <!--<input type="submit" class="btn btn-primary" value="Elenco"></button>-->                
                    <?php echo form_close(); ?>    
                    <?php echo form_open(site_url('backend/studenti_ricerca_azzera')); ?>
                    <input type="submit" class="btn btn-primary m-1" value="Azzera">     
                    <?php echo form_close(); ?>    
                    
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /.container-fluid -->
