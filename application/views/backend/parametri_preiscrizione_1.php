<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php //echo 'ciao'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    
    <div class="row">
        <div class="col-lg-12 mb-2 mt-2">
            <h1 class="h3 mb-4 text-gray-800">Parametri Iscrizione e Preiscrizione</h1>
        </div>
    </div>
    
<div class="row">
    <div class="col-lg-10 mb-1 ml-3">
        <div class="row">
            <div class="col-lg-3 mb-1">
                <?php echo form_open('backend/edit_record/parametri_preiscrizione/0'); ?>
                <div class="row">
                    <label for="ANNOACCA">Anno Accademico</label>
                    <select id="ANNOACCA" name="ANNOACCA" class="form-control">
                        <option selected='selected' value='tutti'></option>
                        <?php
                        foreach ($tab_anno_accademico as $key => $value) {
                            if ($value['ANNOACCA']>=substr(date("Y-m-d"),0,4)){
                                if($value['ANNOACCA']===$tab_parametri_preiscrizione['ANNOACCA']){
                                    echo "<option selected='selected' value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                                }else{
                                    echo "<option  value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                                }
                            }
                        }
                        ?>
                    </select>  
                </div>
                <div class="row">
                    <label for="SEMESTRE">Semestre attivo</label>
                    <select id="SEMESTRE" name="SEMESTRE" class="form-control" requered>
                        <?php
                        if ($tab_parametri_preiscrizione['SEMESTRE'] === '1') {
                            echo "<option selected='selected' value='1'>1</option>";
                            echo "<option value='2'>2</option>";
                        } else {
                            echo "<option selected='selected' value='2'>2</option>";
                            echo "<option value='1'>1</option>";
                        }
                        ?>                                
                    </select>       
                </div>
                <div class="row">
                    <label for="DATAINIZIO">Data inizio</label>
                    <input type="date" class="form-control" id="DATAINIZIO" name="DATAINIZIO" value="<?php echo substr($tab_parametri_preiscrizione['DATAINIZIO'],0,10);?>" required/>
                </div>
                <div class="row">
                    <label for="DATAFINE">Data fine</label>
                    <input type="date" class="form-control" id="DATAFINE" name="DATAFINE" value="<?php echo substr($tab_parametri_preiscrizione['DATAFINE'],0,10);?>" required/>
                </div>
                <div class="row">
                    <label for="PREISCRIZIONI_SCHEDA">Tipo scheda</label>
                    <select id="PREISCRIZIONI_SCHEDA" name="PREISCRIZIONI_SCHEDA" class="form-control">
                    <?php
                        if($tab_parametri_preiscrizione['PREISCRIZIONI_SCHEDA']==='0'){
                            echo "<option selected='selected' value='0'>Scheda Preiscrizione</option>";
                            echo "<option value='1'>Scheda Iscrizione</option>";
                        } else {
                            echo "<option selected='selected' value='1'>Scheda Iscrizione</option>";
                            echo "<option value='0'>Scheda Preiscrizione</option>";
                        }     
                    ?>                                
                    </select>       
                </div>
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <!--DIV PER SPAZIATURA DAL PULSANTE-->
                    </div>         
                    <input type="submit" class="btn btn-primary m-1" value="Salva"></button>                
                    <!--<input type="submit" class="btn btn-primary" value="Elenco"></button>-->                
                    <?php echo form_close(); ?>    
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /.container-fluid -->
