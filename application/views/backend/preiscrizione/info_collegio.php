<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'info_collegio';
$classe_tab='tab-pane fade';
if($_SESSION['tab_attivo_studente']==='tab7') $classe_tab .='  fade  show active';
?>

<div class="<?php echo $classe_tab; ?>" id="<?php echo $tab7['id'] ?>" role="tabpanel" aria-labelledby="<?php echo $tab7['id'] ?>-tab">
    <div class="row">
        <div class="col-lg-6 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-9 mb-2">
                    <label for="Collegio">Collegio</label>
                    <?php if (!isset($tab_studente['COLLEGIO'])):?>
                        <input type="text" class="form-control" id="NOME_COLLEGIO" name="NOME_COLLEGIO" value="FUORI COLLEGIO" readonly/>
                    <?php else:?>
                        <input type="text" class="form-control" id="NOME_COLLEGIO" name="NOME_COLLEGIO" value="<?php echo $tab_collegio['COLLEGIO'];?>" readonly/>
                    <?php endif;?>
                </div>
                <div class="col-lg-3 mb-2">
                    <label for="codice_pug">Codice pug</label>
                    <input type="text" class="form-control" id="codice_pug" name="codice_pug" autocomplete="off" value="<?php echo $tab_collegio['codice_pug']; ?>" readonly/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9 mb-2">
                    <label for="INDIRIZZO_COLLEGIO">Indirizzo</label>
                    <input type="text" class="form-control" id="INDIRIZZO_COLLEGIO" name="INDIRIZZO_COLLEGIO" autocomplete="off" value="<?php echo $tab_collegio['INDIRIZZO']; ?>" readonly/>
                </div>
                <div class="col-lg-3 mb-2">
                    <label for="CAP_COLLEGIO">Cap</label>
                    <input type="text" class="form-control" id="CAP_COLLEGIO" name="CAP_COLLEGIO" autocomplete="off" value="<?php echo $tab_collegio['CAP']; ?>" readonly/>
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="COMUNE_COLLEGIO">Comune</label>
                    <input type="text" class="form-control" id="COMUNE_COLLEGIO" name="COMUNE_COLLEGIO" autocomplete="off" value="<?php echo $tab_collegio['COMUNE']; ?>" readonly/>
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="PROVINCIA_COLLEGIO">Provincia</label>
                    <input type="text" class="form-control" id="PROVINCIA_COLLEGIO" name="PROVINCIA_COLLEGIO" autocomplete="off" value="<?php echo $tab_collegio['PROV']; ?>" readonly/>
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="TELEFONO_COLLEGIO">Telefono</label>
                    <input type="text" class="form-control" id="TELEFONO_COLLEGIO" name="TELEFONO_COLLEGIO" autocomplete="off" value="<?php echo $tab_collegio['TELEFONO']; ?>" readonly/>
                </div>
            </div>            
        </div>
<!--Pannello di destra-->        
        <div class="col-lg-6 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="RETTORE_COLLEGIO">Rettore</label>
                    <input type="text" class="form-control" id="RETTORE_COLLEGIO" name="RETTORE_COLLEGIO" autocomplete="off" value="<?php echo $tab_collegio['rettore']; ?>" readonly/>
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="email_rettore">Email</label>
                    <input type="text" class="form-control" id="email_rettore" name="email_rettore" autocomplete="off" value="<?php echo $tab_collegio['email_rettore']; ?>" readonly/>
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="tel_rettore">Telefono</label>
                    <input type="text" class="form-control" id="tel_rettore" name="tel_rettore" autocomplete="off" value="<?php echo $tab_collegio['tel_rettore']; ?>" readonly/>
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="DIRETTORE_STUDI">Direttore studi</label>
                    <input type="text" class="form-control" id="DIRETTORE_STUDI" name="DIRETTORE_STUDI" autocomplete="off" value="<?php echo $tab_collegio['direttore_studi']; ?>" readonly/>
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label for="email_dirstudi">Email</label>
                    <input type="text" class="form-control" id="email_dirstudi" name="email_dirstudi" autocomplete="off" value="<?php echo $tab_collegio['email_dirstudi']; ?>" readonly/>
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="tel_dirstudi">Telefono</label>
                    <input type="text" class="form-control" id="tel_dirstudi" name="tel_dirstudi" autocomplete="off" value="<?php echo $tab_collegio['tel_dirstudi']; ?>" readonly/>
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <label for="NOTE_COLLEGIO">Note</label>
                    <textarea class="form-control" rows="3" id="NOTE_COLLEGIO" name="NOTE_COLLEGIO" value="" readonly><?php echo $tab_collegio['note'];?></textarea>
                </div> 
            </div>            

        </div>
    </div>
</div>