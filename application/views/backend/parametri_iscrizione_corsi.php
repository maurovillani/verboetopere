<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php //echo 'ciao'; ?>
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
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    
    <div class="row">
        <div class="col-lg-12 mb-2 mt-2">
            <h1 class="h3 mb-4 text-gray-800">Parametri Iscrizione Corsi</h1>
        </div>
    </div>
    
<div class="row">
    <div class="col-lg-10 mb-1 ml-3">
        <div class="row">
            <div class="col-lg-2 mb-1">
                <?php echo form_open('backend/edit_record/parametri_iscrizione_corsi/0'); ?>
                <div class="row">
                    <label for="ANNOACCA">Anno Accademico</label>
                    <select id="ANNOACCA" name="ANNOACCA" class="form-control">
                        <option selected='selected' value='tutti'></option>
                        <?php
                        foreach ($tab_anno_accademico as $key => $value) {
                            if($value['ANNOACCA']===$tab_parametri_iscrizione_corsi['ANNOACCA']){
                                echo "<option selected='selected' value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                            }else{
                                echo "<option  value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                            }
                        }
                        ?>
                    </select>  
                </div>
                <div class="row">
                    <label for="SEMESTRE">Semestre</label>
                    <select id="SEMESTRE" name="SEMESTRE" class="form-control" requered>
                        <?php
                        if ($tab_parametri_iscrizione_corsi['SEMESTRE'] === '1') {
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
                    <input type="date" class="form-control" id="DATAINIZIO" name="DATAINIZIO" value="<?php echo substr($tab_parametri_iscrizione_corsi['DATAINIZIO'],0,10);?>" required/>
                </div>
                <div class="row">
                    <label for="DATAFINE">Data fine</label>
                    <input type="date" class="form-control" id="DATAFINE" name="DATAFINE" value="<?php echo substr($tab_parametri_iscrizione_corsi['DATAFINE'],0,10);?>" required/>
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
            <div class="col-lg-6 mb-1">
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <!--DIV PER SPAZIATURA DAL PULSANTE-->
                    </div>         
                    &nbsp;&nbsp;
                    <a><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#VerificaPassaggioSemestre_Modal">Aggiorna anno di corso per gli studenti di licenza</button></a>
                </div>
            </div>    
        </div>
    </div>
</div>
</div>
<!-- /.container-fluid -->
