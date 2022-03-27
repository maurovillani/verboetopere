<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'dati_iscrizione';
$classe_tab='tab-pane fade';
if($_SESSION['tab_attivo_studente']==='tab7') $classe_tab .='  fade  show active';

?>
<div class="<?php echo $classe_tab; ?>" id="<?php echo $tab7['id'] ?>" role="tabpanel" aria-labelledby="<?php echo $tab7['id'] ?>-tab">
    <div>
        <div class="row">
            <div class="col-lg-12 mb-2 mt-2">
                <div class="row">
                    <div class="col-lg-3 mb-2">
                        <label for="DATAIMMI">Data immatricolazione</label>
                        <input type="date" class="form-control" id="DATAIMMI" name="DATAIMMI" value="<?php echo substr($tab_studente['DATAIMMI'], 0, 10); ?>" readonly/>
                    </div>
                    <div class="col-lg-9 mb-2" align="right">
<?php if (isset($tab_iscrizioni[0]) && $tab_iscrizioni[0]['TERMINATO']==0):?>
                        <br/>
                        <a title="rinnova iscrizione" data-toggle="modal" data-target="#ConfermaIscrizione_Modal"><button class="btn btn-primary">Rinnovo iscrizione</button></a>                                                  
<?php endif;?>                        
<!--                    </div>
                    <div class="col-lg-2 mb-2">
                        <br/>-->
&nbsp;&nbsp;
                        <a title="nuova iscrizione" data-toggle="modal" data-target="#NuovaIscrizione_Modal"><button class="btn btn-primary">Nuovo tipo iscrizione</button></a>                                                  
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mb-2 bg-light">
                        <div class="panel panel-default" style="background-color: white;">
                            <div class="panel-heading">Iscrizioni</div>
                            <div class="panel-body">
                                <!-- <div class="table table-striped table-bordered"> -->
                                    <table id="datiIscrizione" class="table table-striped table-bordered" style="width:100%; font-size:small; color:#000000">
                                        <thead>
                                            <tr role="row" >
                                                <th>Anno Accademico</th>
                                                <th>Tipo iscrizione</th>
                                                <th>Sem. Corso</th>
                                                <th>N. Esami</th>
                                                <th>Note</th>
<!--                                                <th> 
                                                    <div align="center">
                                                    <a title="nuova" data-toggle="modal" data-target="#NuovaIscrizione_Modal"><i class="fas fa-plus"></i></a>                                                  
                                                    </div>
                                                </th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($tab_iscrizioni as $rec) : ?>
                                                <tr role="row" id="row_<?php echo $rec["ANNO_ACCADEMICO"]; ?>">
                                                    <td>
                                                        <?php 
                                                            if($rec["SEMESTREACCA"]=='1'){
                                                                echo $rec["ANNO_ACCADEMICO"].' A';
                                                            }else{
                                                                echo $rec["ANNO_ACCADEMICO"].' B';
                                                            }
                                                            ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $tipocorso=$rec["CORSO_LAUREA"];
                                                            if ($rec['CORSOLAUREA']=='210' && $rec['INDIRIZZO_LAUREA']!=''){
                                                                $tipocorso.=' ('.$rec['INDIRIZZO_LAUREA'].')';
                                                            }
                                                            echo $tipocorso; 
                                                    ?></td>
                                                    <td><?php echo $rec["SEMESTRECORSO"]; ?></td>
                                                    <td><?php echo $rec["NESAMI"]; ?></td>
                                                    <td><?php echo $rec["NOTA"]; ?></td>
<!--                                                    <td>
                                                    <a title="modifica" data-toggle="modal" data-target="#ModificaIscrizione_Modal_<?php echo $rec["ANNOACCA"];?>"><i class="far fa-edit"></i></a>                                                  
                                                    &nbsp;
                                                    <a title="elimina" data-toggle="modal" data-target="#EliminaIscrizione_Modal_<?php echo $rec["ANNOACCA"];?>"><i class="far fa-trash-alt"></i></a>                                                  
                                                    &nbsp;
                                                    <a href="<?php //echo site_url('backend/scelta_corsi_studente/'.$tab_studente['MATRICOL'].'/'.$rec["CODICE_LAUREA"].'/1/'.$rec["ANNOACCA"]); ?>" target="_blank" title="scelta corsi primo semestre"> <span class="badge badge-dark">1</span></i></a>
                                                    &nbsp;
                                                    <a href="<?php //echo site_url('backend/scelta_corsi_studente/'.$tab_studente['MATRICOL'].'/'.$rec["CODICE_LAUREA"].'/2/'.$rec["ANNOACCA"]); ?>" target="_blank" title="scelta corsi secondo semestre"> <span class="badge badge-dark">2</span></a>
                                                    </td>-->
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Pannello di destra-->
<!--            <div class="col-lg-6 mb-2 mt-2">
            </div>-->
        </div>
    </div>
</div>