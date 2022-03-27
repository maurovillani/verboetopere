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
    
<!-- INIZIO MASCHERA POP UP NASCOSTA MODIFICA PROVINCIA-->
<?php foreach ($tab_province as $rec) :  ?>
<div class="modal fade" id="ModificaRecord_Modal_<?php echo $rec['CODICENU'];?>" role="dialog">
    <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Modifica provincia</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
    <?php echo form_open('backend/edit_record/provincia/'.$rec['CODICENU']); ?>
    <div class="row">
        <div class="col-lg-12 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="DECODIF">Provincia</label>
                    <input type="text" class="form-control" id="DECODIF" name="DECODIF" autocomplete="off" value="<?php echo $rec['DECODIF']; ?>" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 mb-2">
                    <label for="ALFAUNO">Sigla</label>
                    <input type="text" class="form-control" id="ALFAUNO" name="ALFAUNO" autocomplete="off" value="<?php echo $rec['ALFAUNO']; ?>" />
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
<?php endforeach; ?>
<!-- FINE MASCHERA POP UP NASCOSTA MODIFICA PROVINCIA-->    

<!-- INIZIO MASCHERA POP UP NASCOSTA PER ELIMINAZIONE RECORD PROVINCIA-->
<?php foreach ($tab_province as $rec) :  ?>
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
                <?php echo form_open('backend/delete_record/provincia/'.$rec['CODICENU']); ?>
                <div class="input-group">
                <input type="hidden" id="CODICENU" name="CODICENU" value="<?php echo $rec['CODICENU'];?>" />
                <h5>Sei sicuro di voler eliminare questa provincia?</h5>
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
<!-- FINE MASCHERA POP UP NASCOSTA PER ELIMINAZIONE RECORD PROVINCIA-->      

</div>