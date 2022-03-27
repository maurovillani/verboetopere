<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 mb-2 mt-2">
            <div class="col-lg-6 mb-2">
                <h1 class="h3 mb-4 text-gray-800">Ricerca Studenti</h1>
            </div>
            <div class="col-lg-6 mb-2">
                <div class="col-lg-8 mb-1">
                    <?php echo form_open('backend/datatable/studenti'); ?>
                    <div class="row">
                        <label for="ANNOACCA">Anno Accademico</label>
                        <select id="ANNOACCA" name="ANNOACCA" class="form-control">
                            <option selected='selected' value='tutti'></option>
                            <?php
                            foreach ($tab_anno_accademico as $key => $value) {
                                echo "<option  value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                            }
                            ?>
                        </select>  
                    </div>
                    <div class="row">
                        <label for="ANNOCORSO">Anno di Corso</label>

                        <select id="ANNOCORSO" name="ANNOCORSO" class="form-control">
                            <option selected='selected' value='tutti'></option>
                            <option value='1'>1</option>
                            <option value='2'>2</option>
                        </select>                        
                    </div>
                    <div class="row">
                        <label for="CATEGORIA">Categoria studente</label>
                        <select id="CATEGORIA" name="CATEGORIA" class="form-control">
                            <option selected='selected' value='tutti'></option>
                            <option value='ORD'>Ordinario</option>
                            <option value='OSP'>Ospite</option>
                            <option value='STR'>Straordinario</option>
                        </select>  
                    </div> 
                    <div class="row">
                        <label for="CORSOLAUREA">Corso laurea</label>
                        <select id="CORSOLAUREA" name="CORSOLAUREA" class="form-control">
                            <option selected='selected' value='tutti'></option>
                            <?php
                            foreach ($tab_corsidilaurea as $key => $value) {
                                echo "<option  value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                            }
                            ?>
                        </select>  
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <!--DIV PER SPAZIATURA DAL PULSANTE-->
                        </div>         
                        <input type="submit" class="btn btn-primary m-1" value="Elenco">              
                        <?php echo form_close(); ?>    
                        <?php echo form_open(site_url('backend/studente/0')); ?>
                        <input type="hidden" id="ANNOACCA2" name="ANNOACCA2" value="tutti" />
                        <input type="hidden" id="ANNOCORSO2" name="ANNOCORSO2" value="tutti" />
                        <input type="hidden" id="CATEGORIA2" name="CATEGORIA2" value="tutti" />
                        <input type="hidden" id="CORSOLAUREA2" name="CORSOLAUREA2" value="tutti" />
                        <input type="submit" class="btn btn-primary m-1" value="Scheda">     
                        <?php echo form_close(); ?>    
                    </div>
                </div>
            </div>
        </div>
<!--Pannello di destra-->        
        <div class="col-lg-6 mb-2 mt-2">
            <div class="col-lg-6 mb-2">
                <h1 class="h3 mb-4 text-gray-800">Ricerca Professori</h1>
            </div>
            <div class="col-lg-6 mb-2">
                <div class="col-lg-8 mb-1">
                    <?php echo form_open('backend/datatable/professori'); ?>
                    <div class="row">
                        <label for="ANNOACCA">Anno Accademico</label>
                        <select id="ANNOACCA" name="ANNOACCA" class="form-control">
                            <option selected='selected' value='tutti'></option>
                            <?php
                            foreach ($tab_anno_accademico as $key => $value) {
                                echo "<option  value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                            }
                            ?>
                        </select>  
                    </div>
                    <div class="row">
                        <label for="STATOCIV">Stato civile</label>
                        <select id="STATOCIV" name="STATOCIV" class="form-control">
                            <option selected='selected' value='tutti'></option>
                            <?php
                            foreach ($tab_statocivile as $key => $value) {
                                echo "<option  value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                            }
                            ?>
                        </select>  
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <!--DIV PER SPAZIATURA-->
                        </div>         
                        <input type="submit" class="btn btn-primary m-1" value="Elenco">             
                        <?php echo form_close(); ?>    
                        <?php echo form_open(site_url('backend/professore/0')); ?>
                        <input type="hidden" id="ANNOACCA2" name="ANNOACCA2" value="tutti" />
                        <input type="hidden" id="STATOCIV2" name="STATOCIV2" value="tutti" />
                        <input type="submit" class="btn btn-primary m-1" value="Scheda">    
                        <?php echo form_close(); ?>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
