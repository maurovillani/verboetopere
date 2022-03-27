<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'dati_iscrizione';
$classe_tab='tab-pane fade';
if($_SESSION['tab_attivo_studente']==='tab9') $classe_tab .='  fade  show active';

?>
<div class="<?php echo $classe_tab; ?>" id="<?php echo $tab9['id'] ?>" role="tabpanel" aria-labelledby="<?php echo $tab9['id'] ?>-tab">
    <div>
        <div class="row">
            <div class="col-lg-12 mb-2 mt-2">
                <div class="row">
                    <div class="col-lg-12 mb-2 bg-light">
                        <div class="panel panel-default" style="background-color: white;">
                            <div class="panel-heading">Tasse</div>
                            <div class="panel-body">
                                <!-- <div class="table table-striped table-bordered"> -->
                                    <table id="datiIscrizione" class="table table-striped table-bordered" style="width:100%; font-size:small; color:#000000">
                                        <thead>
                                            <tr role="row" >
                                                <th>Corso</th>
                                                <th>Anno Accademico</th>
                                                <th>Voto</th>
                                                <th>Ciclo</th>
                                                <th>Anno</th>
                                                <th>Tipo</th>
                                                <th>Professore</th>
                                                <th> 
                                                    <div align="center">
                                                    <!--<a title="nuova" data-toggle="modal" data-target="#NuovoCorso_Modal"><i class="fas fa-plus"></i></a>-->                                                  
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($tab_corsi as $rec) : ?>
                                                <tr role="row" id="row_<?php echo $rec["CORSI"]; ?>">
                                                    <td><?php echo $rec["sigla"]; ?></td>
                                                    <td><?php echo $rec["ANNO_ACCADEMICO"]; ?></td>
                                                    <td><?php echo $rec["VOTOESAME"]; ?></td>
                                                    <td><?php echo $rec["CICLO"]; ?></td>
                                                    <td><?php echo $rec["ANNODICORSO"]; ?></td>
                                                    <td><?php echo $rec["TIPO"]; ?></td>
                                                    <td><?php echo $rec["PROFESSORE"]; ?></td>
                                                    <td>
                                                    <a title="modifica" data-toggle="modal" data-target="#ModificaCorso_Modal_<?php echo $rec["CORSI"];?>"><i class="far fa-edit"></i></a>                                                  
                                                    &nbsp;
                                                    <a title="elimina" data-toggle="modal" data-target="#EliminaCorso_Modal_<?php echo $rec["CORSI"];?>"><i class="far fa-trash-alt"></i></a>                                                  
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
