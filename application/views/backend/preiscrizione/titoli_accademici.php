<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'titoli_accademici';
$classe_tab='tab-pane fade';
if($_SESSION['tab_attivo_studente']==='tab8') $classe_tab .='  fade  show active';
?>
<div class="<?php echo $classe_tab; ?>" id="<?php echo $tab8['id'] ?>" role="tabpanel" aria-labelledby="<?php echo $tab8['id'] ?>-tab">
    <div>
        <div class="row">
            <div class="col-lg-12 mb-2 mt-2">
                <div class="row">
                    <div class="col-lg-12 mb-2 bg-light">
                        <div class="panel panel-default" style="background-color: white;">
                            <!--<div class="panel-heading">Titoli accademici</div>-->
                            <div class="panel-body">
                                <!-- <div class="table table-striped table-bordered"> -->
                                    <table id="titoliAccademici" class="table table-striped table-bordered" style="width:100%; font-size:small; color:#000000">
                                        <thead>
                                            <tr role="row" >
                                                <th>Titolo di studio</th>
                                                <th>Anno conseguimento</th>
                                                <th>Votazione</th>
                                                <th>Qualifica</th>
                                                <th>Università</th>
                                                <th>Documento</th>
                                                <th>Nota</th>
                                                <th> 
                                                    <div align="center">
                                                    <a title="nuova" data-toggle="modal" data-target="#NuovoTitoloAccademico_Modal"><i class="fas fa-plus"></i></a>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($tab_titoli_accademici as $rec) : ?>
                                                <tr role="row" id="row_<?php echo $rec["TIPTITST"]; ?>">
                                                    <td><?php echo $rec["TITOLO_STUDIO"]; ?></td>
                                                    <td><?php echo $rec["ANNO_CONSEGUIMENTO"]; ?></td>
                                                    <td><?php echo $rec["VOTAZIONE"]; ?></td>
                                                    <td><?php echo $rec["QUALIFICA"]; ?></td>
                                                    <td><?php echo $rec["UNIVERSITA"]; ?></td>
                                                    <td><?php echo $rec["DOCUMENTO"]; ?></td>
                                                    <td><?php echo $rec["NOTA"]; ?></td>
                                                    <td>
                                                    <a title="modifica" data-toggle="modal" data-target="#ModificaTitoloAccademico_Modal_<?php echo $rec["TIPTITST"];?>"><i class="far fa-edit"></i></a>                                                  
                                                    &nbsp;
                                                    <a title="elimina" data-toggle="modal" data-target="#EliminaTitoloAccademico_Modal_<?php echo $rec["TIPTITST"];?>"><i class="far fa-trash-alt"></i></a>                                                  
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