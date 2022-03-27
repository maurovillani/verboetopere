<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php //echo 'ciao'; ?>
<script type="text/javascript">
function ConfermaInvio() {
    <?php echo $campo_INIZIOPREISCRIZIONI_SEM1; ?>  
    <?php echo $campo_INIZIOPREISCRIZIONI_SEM2; ?>  
    <?php echo $campo_INIZIOISCRIZIONI_SEM1; ?>  
    <?php echo $campo_INIZIOISCRIZIONI_SEM2; ?>  
    <?php echo $campo_FINEPREISCRIZIONI_SEM1; ?>  
    <?php echo $campo_FINEPREISCRIZIONI_SEM2; ?>  
    <?php echo $campo_FINEISCRIZIONI_SEM1; ?>  
    <?php echo $campo_FINEISCRIZIONI_SEM2; ?>  
        
    document.getElementById("myForm").submit();
}
</script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    
    <div class="row">
        <div class="col-lg-12 mb-2 mt-2">
            <h1 class="h3 mb-4 text-gray-800">Parametri Iscrizione e Preiscrizione</h1>
        </div>
    </div>
    
<div class="row">
    <div class="col-lg-8 mb-1 ml-3">
        <div class="row">
            <div class="col-lg-12 mb-1">
                <?php //echo form_open('backend/edit_record/parametri_preiscrizione/0'); ?>
                <?php 
                $attributes = array('id' => 'myForm', 'name'=>'myForm');
                echo form_open(site_url('backend/edit_record/parametri_preiscrizione/0'),$attributes);
                ?>
                <div class="row">
                    <div class="col-lg-3 mb-2">
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
                    <div class="col-lg-6 mb-4">
                        <label for="EMAIL_SEGRETERIA">Email segreteria</label>
                        <input type="text" class="form-control" id="EMAIL_SEGRETERIA" name="EMAIL_SEGRETERIA" value="<?php echo $tab_parametri_preiscrizione['EMAIL_SEGRETERIA'];?>" required/>
                    </div>
                    <div class="col-lg-3 mb-4" align="right">
                        <br/>
                        <input type="button" class="btn btn-primary m-1" value="Salva"  onclick="ConfermaInvio()"></button>                
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 mb-2">
                        <p align="center"><b>Preiscrizioni<br/>I Semestre</b></p>
                    </div>
                    <div class="col-lg-3 mb-2">
                        <p align="center"><b>Preiscrizioni<br/>II Semestre</b></p>
                    </div>
                    <div class="col-lg-3 mb-2">
                        <p align="center"><b>Iscrizioni<br/>I Semestre</b></p>
                    </div>
                    <div class="col-lg-3 mb-2">
                        <p align="center"><b>Iscrizioni<br/>II Semestre</b></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 mb-4">
                        <label for="INIZIOPREISCRIZIONI_SEM1">Data inizio</label>
                        <input type="text" class="form-control" id="INIZIOPREISCRIZIONI_SEM1" name="INIZIOPREISCRIZIONI_SEM1" value="<?php echo substr($tab_parametri_preiscrizione['INIZIOPREISCRIZIONI_SEM1'],0,10);?>" placeholder="aaaa-mm-gg">
                    </div>
                    <div class="col-lg-3 mb-4">
                        <label for="INIZIOPREISCRIZIONI_SEM2">Data inizio</label>
                        <input type="text" class="form-control" id="INIZIOPREISCRIZIONI_SEM2" name="INIZIOPREISCRIZIONI_SEM2" value="<?php echo substr($tab_parametri_preiscrizione['INIZIOPREISCRIZIONI_SEM2'],0,10);?>" placeholder="aaaa-mm-gg">
                    </div>
                    <div class="col-lg-3 mb-4">
                        <label for="INIZIOISCRIZIONI_SEM1">Data inizio</label>
                        <input type="text" class="form-control" id="INIZIOISCRIZIONI_SEM1" name="INIZIOISCRIZIONI_SEM1" value="<?php echo substr($tab_parametri_preiscrizione['INIZIOISCRIZIONI_SEM1'],0,10);?>" placeholder="aaaa-mm-gg">
                    </div>
                    <div class="col-lg-3 mb-4">
                        <label for="INIZIOISCRIZIONI_SEM2">Data inizio</label>
                        <input type="text" class="form-control" id="INIZIOISCRIZIONI_SEM2" name="INIZIOISCRIZIONI_SEM2" value="<?php echo substr($tab_parametri_preiscrizione['INIZIOISCRIZIONI_SEM2'],0,10);?>" placeholder="aaaa-mm-gg">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 mb-4">
                        <label for="FINEPREISCRIZIONI_SEM1">Data fine</label>
                        <input type="text" class="form-control" id="FINEPREISCRIZIONI_SEM1" name="FINEPREISCRIZIONI_SEM1" value="<?php echo substr($tab_parametri_preiscrizione['FINEPREISCRIZIONI_SEM1'],0,10);?>" placeholder="aaaa-mm-gg">
                    </div>
                    <div class="col-lg-3 mb-4">
                        <label for="FINEPREISCRIZIONI_SEM2">Data fine</label>
                        <input type="text" class="form-control" id="FINEPREISCRIZIONI_SEM2" name="FINEPREISCRIZIONI_SEM2" value="<?php echo substr($tab_parametri_preiscrizione['FINEPREISCRIZIONI_SEM2'],0,10);?>" placeholder="aaaa-mm-gg">
                    </div>
                    <div class="col-lg-3 mb-4">
                        <label for="FINEISCRIZIONI_SEM1">Data fine</label>
                        <input type="text" class="form-control" id="FINEISCRIZIONI_SEM1" name="FINEISCRIZIONI_SEM1" value="<?php echo substr($tab_parametri_preiscrizione['FINEISCRIZIONI_SEM1'],0,10);?>" placeholder="aaaa-mm-gg">
                    </div>
                    <div class="col-lg-3 mb-4">
                        <label for="FINEISCRIZIONI_SEM2">Data fine</label>
                        <input type="text" class="form-control" id="FINEISCRIZIONI_SEM2" name="FINEISCRIZIONI_SEM2" value="<?php echo substr($tab_parametri_preiscrizione['FINEISCRIZIONI_SEM2'],0,10);?>" placeholder="aaaa-mm-gg">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <!--DIV PER SPAZIATURA DAL PULSANTE-->
                    </div>         
                    <!--<input type="submit" class="btn btn-primary m-1" value="Salva"></button>-->                
                    <!--<input type="submit" class="btn btn-primary" value="Elenco"></button>-->                
                    <?php echo form_close(); ?>    
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /.container-fluid -->
