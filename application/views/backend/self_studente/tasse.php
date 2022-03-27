<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'tasse';
$classe_tab='tab-pane fade';
if($_SESSION['tab_attivo_studente']==='tab8') $classe_tab .='  fade  show active';

?>
<div class="<?php echo $classe_tab; ?>" id="<?php echo $tab8['id'] ?>" role="tabpanel" aria-labelledby="<?php echo $tab8['id'] ?>-tab">
    <div>
        <div class="row">
            <div class="col-lg-12 mb-2 mt-2">
<?php if (isset($specchietto)):?> 
                <div class="row">
                    <div class="col-lg-3 mb-2">
                    </div>
                    <div class="col-lg-6 mb-2">
                    </div>
                    <div class="col-lg-3 mb-2">
                        <a title="scelta pagamento" data-toggle="modal" data-target="#SceltaPagamento_Modal"><button class="btn btn-primary">Scelta pagamento tasse</button></i></a>                                                  
                    </div>
                </div>
<?php endif;?>                                                        
                <div class="row">
                    <div class="col-lg-12 mb-2 bg-light">
                        <div class="panel panel-default" style="background-color: white;">
                            <div class="panel-heading">Tasse</div>
                            <div class="panel-body">
                                <!-- <div class="table table-striped table-bordered"> -->
                                    <table id="Tasse" class="table table-striped table-bordered" style="width:100%; font-size:small; color:#000000">
                                        <thead>
                                            <tr role="row" >
                                                <th>Anno Accademico</th>
                                                <th>Corso di Laurea</th>
                                                <!--<th>Anno corso</th>-->
                                                <th>Causale Tassa</th>
                                                <th>Data pagamento</th>
                                                <th>Importo</th>
                                                <!--<th>Pagamento</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($tab_tasse as $rec) : ?>
                                                <tr role="row" id="row_<?php echo $rec["CODICETASSAPAGATA"]; ?>">
                                                    <td><?php echo $rec["ANNO_ACCADEMICO"]; ?></td>
                                                    <td><?php echo $rec["CORSO_LAUREA"]; ?></td>
                                                    <!--<td><?php // echo $rec["ANNOCORSO"]; ?></td>-->
                                                    <td><?php echo $rec["CAUSALE_TASSA"]; ?></td>
                                                    <td><?php echo substr($rec["DATAPAGAMENTO"],0,10); ?></td>
                                                    <td><?php echo $rec["IMPPAGATO"]; ?></td>
                                                    <!--<td>-->
<?php //if ($rec["POSISCRIZIONE"]=='7'):?>                                                        
                                                    <!--<a title="scelta pagamento" data-toggle="modal" data-target="#SceltaPagamento_Modal"><i class="far fa-edit"></i></a>-->                                                  
<!--                                                    <a title="modifica" data-toggle="modal" data-target="#ModificaTassa_Modal_<?php //echo $rec["CODICETASSAPAGATA"];?>"><i class="far fa-edit"></i></a>                                                  
                                                    &nbsp;
                                                    <a title="elimina" data-toggle="modal" data-target="#EliminaTassa_Modal_<?php //echo $rec["CODICETASSAPAGATA"];?>"><i class="far fa-trash-alt"></i></a>                                                  -->
<?php //endif;?>                                                        
                                                    <!--</td>-->
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