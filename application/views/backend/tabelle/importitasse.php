<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'form_importitasse';
?>

<div id="<?php echo $FormNascoste['id']; ?>">
    
<!-- INIZIO MASCHERA POP UP NASCOSTA MODIFICA-->
<?php foreach ($tab_importitasse as $rec) :  ?>
<div class="modal fade" id="ModificaRecord_Modal_<?php echo $rec['ID'];?>" role="dialog">
    <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Modifica tassa</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
    <?php echo form_open('backend/edit_record/importitasse/'.$rec['ID']); ?>
    <div class="row">
        <div class="col-lg-12 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="ANNOACCADEMICO">Anno Accademico</label>
                    <select id="ANNOACCADEMICO" name="ANNOACCADEMICO" class="form-control">
                        <?php
                        foreach ($tab_anno_accademico as $key => $value) {
                            if($value['ANNOACCA']===$rec['ANNOACCADEMICO']){
                                echo "<option selected='selected' value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                            }else{
                                echo "<option  value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                            }
                        }
                        ?>
                    </select>  
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="CORSODILAUREA">Corso di laurea</label>
                    <select id="CORSODILAUREA" name="CORSODILAUREA" class="form-control">
                        <option value="999"></option>
                        <?php
                        foreach ($tab_corsidilaurea as $key => $value) {
                            if($value['CODICENU']===$rec['CORSODILAUREA']){
                                echo "<option selected='selected' value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                            }else{
                                echo "<option  value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                            }
                        }
                        ?>
                    </select>  
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="ANNODICORSO">Anno di Corso</label>
                    <select id="ANNODICORSO" name="ANNODICORSO" class="form-control">
                        <option selected='selected' value='99'></option>
                        <option <?php if($rec['ANNODICORSO']==='1') echo "selected='selected"; ?> value='1'>1</option>
                        <option <?php if($rec['ANNODICORSO']==='2') echo "selected='selected"; ?> value='2'>2</option>
                    </select>                        
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="CAUSALETASSA">Causale tassa</label>
                    <select id="CAUSALETASSA" name="CAUSALETASSA" class="form-control">
                        <?php
                        foreach ($tab_causaletassa as $key => $value) {
                            if($value['CODICECAUSALE']===$rec['CAUSALETASSA']){
                                echo "<option selected='selected' value='" . $value['CODICECAUSALE'] . "'>" . $value['DECODIFICA'] . "</option>";
                            }else{
                                echo "<option  value='" . $value['CODICECAUSALE'] . "'>" . $value['DECODIFICA'] . "</option>";
                            }
                        }
                        ?>
                    </select>  
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="IMPORTOTASSA">Importo tassa</label>
                    <input type="text" class="form-control" id="IMPORTOTASSA" name="IMPORTOTASSA" autocomplete="off" value="<?php echo $rec['IMPORTOTASSA']; ?>" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                <!--DIV PER SPAZIATURA DAL PULSANTE-->
                </div>
            </div>    
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <button type="submit" class="btn btn-primary">Salva</button>
                    &nbsp;
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>
     <?php echo form_close(); ?>                   
<!-- fine -->                
            </div>
        </div>
    </div>
</div>
<!-- FINE MASCHERA POP UP NASCOSTA MODIFICA-->    

<!-- INIZIO MASCHERA POP UP NASCOSTA PER ELIMINAZIONE RECORD-->
<div class="modal fade" id="EliminaRecord_Modal_<?php echo $rec['ID'];?>" role="dialog">
    <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Eliminazione record</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <?php echo form_open('backend/delete_record/importitasse/'.$rec['ID']); ?>
                <div class="input-group">
                    <input type="hidden" id="ID" name="ID" value="<?php echo $rec['ID'];?>" />
                    <h5>Sei sicuro di voler eliminare questo record?</h5>
                    <div><br/>
                        <button type="submit" class="btn btn-primary">Elimina</button>
                        &nbsp;
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
                <?php echo form_close(); ?>      
            </div>
       </div>
    </div>
</div>
<?php endforeach; ?>  
<!-- FINE MASCHERA POP UP NASCOSTA PER ELIMINAZIONE RECORD-->      

<!-- INIZIO MASCHERA POP UP NASCOSTA NUOVO RECORD-->
<div class="modal fade" id="NuovoRecord_Modal" role="dialog">
    <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Nuovo importo tassa</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
    <?php echo form_open('backend/new_record/importitasse'); ?>
    <div class="row">
        <div class="col-lg-12 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="ANNOACCADEMICO">Anno Accademico</label>
                    <select id="ANNOACCADEMICO" name="ANNOACCADEMICO" class="form-control">
                        <option value=''></option>
                        <?php
                        foreach ($tab_anno_accademico as $key => $value) {
                            echo "<option  value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                        }
                        ?>
                    </select>  
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="CORSODILAUREA">Corso di laurea</label>
                    <select id="CORSODILAUREA" name="CORSODILAUREA" class="form-control">
                        <option value=''></option>
                        <?php
                        foreach ($tab_corsidilaurea as $key => $value) {
                            echo "<option  value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                        }
                        ?>
                    </select>  
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="ANNOCORSO">Anno di Corso</label>
                    <select id="ANNODICORSO" name="ANNODICORSO" class="form-control">
                        <option value='99'></option>
                        <option value='1'>1</option>
                        <option value='2'>2</option>
                    </select>                        
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="CAUSALETASSA">Causale tassa</label>
                    <select id="CAUSALETASSA" name="CAUSALETASSA" class="form-control">
                        <option value=''></option>
                        <?php
                        foreach ($tab_causaletassa as $key => $value) {
                            echo "<option  value='" . $value['CODICECAUSALE'] . "'>" . $value['DECODIFICA'] . "</option>";
                        }
                        ?>
                    </select>  
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="IMPORTOTASSA">Importo tassa</label>
                    <input type="text" class="form-control" id="IMPORTOTASSA" name="IMPORTOTASSA" autocomplete="off" value="" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                <!--DIV PER SPAZIATURA DAL PULSANTE-->
                </div>
            </div>    
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <button type="submit" class="btn btn-primary">Salva</button>
                    &nbsp;
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>
     <?php echo form_close(); ?>                   
<!-- fine -->                
            </div>
        </div>
    </div>
</div>
<!-- FINE MASCHERA POP UP NASCOSTA NUOVO RECORD-->    

<!-- INIZIO MASCHERA POP UP NASCOSTA DUPLICA RECORD-->
<div class="modal fade" id="DuplicaRecord_Modal" role="dialog">
    <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Duplica record importi tasse</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
    <?php echo form_open('backend/new_record/duplicaimportitasse'); ?>
    <div class="row">
        <div class="col-lg-12 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="ANNOACCADEMICO_OLD">Anno Accademico da duplicare</label>
                    <select id="ANNOACCADEMICO_OLD" name="ANNOACCADEMICO_OLD" class="form-control">
                        <option value=''></option>
                        <?php
                        foreach ($tab_anno_accademico as $key => $value) {
                            if ($value['ANNOACCA']>2019){
                            echo "<option  value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                            }
                        }
                        ?>
                    </select>  
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="ANNOACCADEMICO_NEW">Anno Accademico da creare</label>
                    <select id="ANNOACCADEMICO_NEW" name="ANNOACCADEMICO_NEW" class="form-control">
                        <option value=''></option>
                        <?php
                        foreach ($tab_anno_accademico as $key => $value) {
                            if ($value['ANNOACCA']>2019){
                            echo "<option  value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                            }
                        }
                        ?>
                    </select>  
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                <!--DIV PER SPAZIATURA DAL PULSANTE-->
                </div>
            </div>    
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <button type="submit" class="btn btn-primary">Salva</button>
                    &nbsp;
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>
     <?php echo form_close(); ?>                   
<!-- fine -->                
            </div>
        </div>
    </div>
</div>
<!-- FINE MASCHERA POP UP NASCOSTA DUPLICA RECORD--> 

</div>