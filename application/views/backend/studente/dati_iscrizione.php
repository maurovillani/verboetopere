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
                    <div class="col-lg-2 mb-2">
                        <label for="DATAIMMI">Data immatricolazione</label>
                        <input type="date" class="form-control" id="DATAIMMI" name="DATAIMMI" value="<?php echo substr($tab_studente['DATAIMMI'], 0, 10); ?>"/>
                    </div>
                    <div class="col-lg-1 mb-2" align="center">
                        <label for="FSOSPES">Sospeso</label>
                        <input type="hidden" name="FSOSPES" value="N">
                        <input type="checkbox" class="form-control" id="FSOSPES" name="FSOSPES" value="S" <?php if ($tab_studente['FSOSPES']==='S') echo 'checked';?> >
                        <input type="hidden" id="FSOSPES_OLD" name="FSOSPES_OLD" value="<?php echo $tab_studente['FSOSPES']; ?>">                    
                    </div>
                    <div class="col-lg-3 mb-2">
                        <?php if(isset($tab_qualificadottorato['QUALIFICA'])): ?>
                        <label for="QUALIFICA_DOTTORATO">Qualifica dottorato</label>
                        <input type="text" class="form-control" id="QUALIFICA_DOTTORATO" name="QUALIFICA_DOTTORATO" value="<?php echo $tab_qualificadottorato['QUALIFICA']; ?>" readonly />
                        <?php endif;?>
                    </div>
                    <div class="col-lg-3 mb-2">
                        <?php if(isset($tab_qualificalicenza['QUALIFICA'])): ?>
                        <label for="QUALIFICA_LICENZA">Qualifica licenza</label>
                        <input type="text" class="form-control" id="QUALIFICA_LICENZA" name="QUALIFICA_LICENZA" value="<?php echo $tab_qualificalicenza['QUALIFICA']; ?>" readonly />
                        <?php endif;?>
                    </div>
                    <div class="col-lg-3 mb-2">
                        <?php if(isset($tab_indirizzolicenza['INDIRIZZO_LAUREA'])): ?>
                        <label for="INDIRIZZO_LAUREA">Indirizzo licenza</label>
                        <input type="text" class="form-control" id="INDIRIZZO_LAUREA" name="INDIRIZZO_LAUREA" value="<?php echo $tab_indirizzolicenza['INDIRIZZO_LAUREA']; ?>" readonly />
                        <?php endif;?>
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
                                                <th> 
                                                    <div align="center">
                                                    <a title="nuovo tipo di iscrizione" data-toggle="modal" data-target="#NuovaIscrizione_Modal"><i class="fas fa-plus"></i></a>
                                                    <!--<a><button type="button" class="btn btn-secondary btn-xs" data-toggle="modal" data-target="#NuovaIscrizione_Modal">Nuovo Tipo iscrizione</button></a>-->
                                                    
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
    <?php 
        $n=0; 
        if (isset($tab_iscrizioni[0]['id_iscrizione'])){
           $corso_laurea=$tab_iscrizioni[0]['CORSOLAUREA'];
        }
    ?>                                            <?php foreach ($tab_iscrizioni as $rec) : ?>

    <?php 
        if ($rec['CORSOLAUREA']!=$corso_laurea){
           $corso_laurea=$rec['CORSOLAUREA'];
           $n=0; 
        }
        $n=$n+1;
    ?>                                            
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
                                                        <?php echo $rec["CORSO_LAUREA"]; ?>
                                                        <?php if ($n==1):?>
                                                        &nbsp;&nbsp;
                                                        <a title="corso di laurea" data-toggle="modal" data-target="#EsamiLaurea_Modal_<?php echo $rec["CORSOLAUREA"];?>"><i class="far fa-star"></i></a>                                                  
                                                        <?php endif;?>                                                                
                                                    </td>
                                                    <td><?php echo $rec["SEMESTRECORSO"]; ?></td>
                                                    <td><?php echo $rec["NESAMI"]; ?></td>
                                                    <td><?php echo $rec["NOTA"]; ?></td>
                                                    <td>
<?php
    $trovato=FALSE;
    foreach($tab_iscrizioni as $index => $car) {
        if ($rec['SEMESTREACCA']=='1'){
            if($car['ANNOACCA'] == $rec['ANNOACCA'] AND $car['SEMESTREACCA']=='2'){ 
                $trovato=TRUE;
                break;
            }
        }else{
            if($car['ANNOACCA'] == strval(intval($rec['ANNOACCA'])+1) AND $car['SEMESTREACCA']=='1'){ 
                $trovato=TRUE;
                break;
            }
        }
    }
?>  
                                                    <a title="modifica" data-toggle="modal" data-target="#ModificaIscrizione_Modal_<?php echo $rec["id_iscrizione"];?>"><i class="far fa-edit"></i></a>
                                                    &nbsp;
                                                    <a title="elimina" data-toggle="modal" data-target="#EliminaIscrizione_Modal_<?php echo $rec["id_iscrizione"];?>"><i class="far fa-trash-alt"></i></a>                                                  
                                                    &nbsp;
                                                    <?php 
                                                    if (intval($rec['SEMESTRECORSO'])>0 AND !$trovato AND intval($rec['CORSOLAUREA'])<250):?>
                                                        <?php if ($rec['TERMINATO']==0 
                                                                || (intval($rec['SEMESTRECORSO'])<4 AND $rec['TERMINATO']==1)
                                                                ):?>
                                                            <a title="crea semestre" data-toggle="modal" data-target="#DividiIscrizione_Modal_<?php echo $rec["id_iscrizione"];?>"><i class="far fa-clone"></i></a>                                                  
                                                        <?php endif;?>
                                                    <!--<a href="<?php //echo site_url('backend/pianostudi_studente/'.$tab_studente['MATRICOL'].'/'.$rec["CODICE_LAUREA"]); ?>" target="_blank" title="piano di studi"> <i class="fas fa-chalkboard-teacher"></i></a>-->
                                                    <?php else:?>
                                                    &nbsp;
                                                    &nbsp;
                                                    <?php endif;?>
                                                    &nbsp;
                                                    &nbsp;
                                                    <?php if (intval($rec['SEMESTRECORSO'])>0):?>
                                                    <a href="<?php echo site_url('backend/scelta_corsi_studente/'.$tab_studente['MATRICOL'].'/'.$rec["CODICE_LAUREA"].'/'.$rec["SEMESTREACCA"].'/'.$rec["ANNOACCA"].'/'.$rec["SEMESTRECORSO"]); ?>" target="_blank" title="scelta corsi"><i class="fas fa-chalkboard-teacher"></i></a>
                                                    <?php endif;?>
                                                    <!--&nbsp;-->
                                                    <!--<a href="<?php //echo site_url('backend/scelta_corsi_studente/'.$tab_studente['MATRICOL'].'/'.$rec["CODICE_LAUREA"].'/2/'.$rec["ANNOACCA"]); ?>" target="_blank" title="scelta corsi secondo semestre"> <span class="badge badge-dark">2</span></a>-->
                                                    </td>
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