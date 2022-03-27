<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'form_nascoste';
?>

<div id="<?php echo $FormNascoste['id']; ?>">
    
<!-- INIZIO MASCHERA POP UP NASCOSTA MODIFICA NAZIONE-->
<?php foreach ($tab_nazioni as $rec) :  ?>
<div class="modal fade" id="ModificaRecord_Modal_<?php echo $rec['CODICENU'];?>" role="dialog">
    <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Modifica nazione</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
    <?php echo form_open('backend/edit_record/nazione/'.$rec['CODICENU']); ?>
    <div class="row">
        <div class="col-lg-12 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-8 mb-2">
                    <label for="DECODIF">Nazione</label>
                    <input type="text" class="form-control" id="DECODIF" name="DECODIF" autocomplete="off" value="<?php echo $rec['DECODIF']; ?>" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mb-2">
                    <label for="ALFAUNO">Continente</label>
                    <select id="ALFAUNO" name="ALFAUNO" class="form-control">
                    <?php
                        foreach ($tab_continenti as $key => $value) {
                            if($value['cod_area'] === $rec['ALFAUNO']){
                                echo "<option selected='selected' value='".$value['cod_area']."'>".$value['descrizione']."</option>";
                            } else {
                                echo "<option  value='".$value['cod_area']."'>".$value['descrizione']."</option>";
                            }                            
                        }
                    ?>                                
                    </select>                   
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mb-2">
                    <label for="CITTADINANZA">Cittadinanza</label>
                    <input type="text" class="form-control" id="CITTADINANZA" name="CITTADINANZA" autocomplete="off" value="<?php echo $rec['CITTADINANZA']; ?>" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 mb-2">
                    <label for="FLAG_LINGUA_MODERNA">Lingua moderna</label>
                    <select id="FLAG_LINGUA_MODERNA" name="FLAG_LINGUA_MODERNA" class="form-control">
                    <?php
                        if($rec['FLAG_LINGUA_MODERNA']==='S'){
                            echo "<option selected='selected' value='S'>S</option>";
                            echo "<option value='N'>N</option>";
                        } else {
                            echo "<option selected='selected' value='N'>N</option>";
                            echo "<option value='S'>S</option>";
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
<?php //endforeach; ?>
<!-- FINE MASCHERA POP UP NASCOSTA MODIFICA PROVINCIA-->    

<!-- INIZIO MASCHERA POP UP NASCOSTA PER ELIMINAZIONE RECORD NAZIONE-->
<?php //foreach ($tab_nazioni as $rec) :  ?>
<div class="modal fade" id="EliminaRecord_Modal_<?php echo $rec['CODICENU'];?>" role="dialog">
    <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Eliminazione record</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <?php echo form_open('backend/delete_record/nazione/'.$rec['CODICENU']); ?>
                <div class="input-group">
                <input type="hidden" id="CODICENU" name="CODICENU" value="<?php echo $rec['CODICENU'];?>" />
                <h5>Sei sicuro di voler eliminare questa nazione?</h5>
                <br/><br/><br/>
                    <button type="submit" class="btn btn-primary">Elimina</button>
                    &nbsp;
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                </div>
                <?php echo form_close(); ?>      
            </div>
       </div>
    </div>
</div>
<?php endforeach; ?>  
<!-- FINE MASCHERA POP UP NASCOSTA PER ELIMINAZIONE RECORD NAZIONE-->      

</div>