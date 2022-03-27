<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<style>
    .anyClass {
        height: 150px;
        overflow-y: scroll;
    }
</style>
<!-- AMF -->
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mb-2 mt-2">
            <h1 class="h3 mb-4 text-gray-800">Piano Studi</h1>
        </div>
    </div>    
    <table class="table table-hover" id='corsilist'>
        <thead>
            <tr>
                <th width="15%" scope="col">Tipo corso</th>
                <th width="5%" scope="col">Codice</th>
                <th width="40%" scope="col">Titolo</th>
                <th width="25%" scope="col">Professore</th>
                <th width="15%" scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr id=1>
                <th scope="row">Metodologia</th>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Metodologia_ModalCenter" data-row-id="1">+</button>
                    <button type="button" class="btn btn-primary" id="empty" data-row-id="1" onclick='corsoDelete(this)'>#</button>
                </td>
            </tr>
            <tr id=2>
                <th scope="row">Antico Testamento</th>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AnticoTestamento_ModalCenter" data-row-id="2">+</button>
                    <button type="button" class="btn btn-primary" id="empty" data-row-id="2" onclick='corsoDelete(this)'>#</button>
                </td>
            </tr>
            <tr id=3>
                <th scope="row">Nuovo Testamento</th>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#NuovoTestamento_ModalCenter" data-row-id="3">+</button>
                    <button type="button" class="btn btn-primary" id="empty" data-row-id="3" onclick='corsoDelete(this)'>#</button>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- <button type="button" class="btn btn-primary"  onclick='corsoSave()'>Save</button> -->
    <?php echo $myform; ?>
</div>

<!-- Modal -->
<!-- Inizio Maschera Nascosta Metodologia -->
<div class="modal fade" id="Metodologia_ModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Corso Metodologia</h5>
                <!--<h5 class="modal-title" id="exampleModalCenterTitle"></h5>-->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--<h5>Metodologia</h5>-->
                <!-- List group -->
                <div class="list-group anyClass" id="myList" role="tablist">
                    <?php foreach ($c_metodologia as $rec) : ?>                    
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#Metodologia_<?php echo $rec['CORSI'];?>" role="tab"><?php echo $rec['DESCRIZIONECORSI'];?></a>
                    <?php endforeach; ?>  
                </div>

                <!-- Tab panes -->
                <div class="tab-content">
                    <?php foreach ($c_metodologia as $rec) : ?>                    
                        <div class="tab-pane" data-codice="<?php echo $rec['sigla'];?>" data-titolo="<?php echo $rec['DESCRIZIONECORSI'];?>" data-prof="<?php echo $rec['COGNOME'];?>" id="Metodologia_<?php echo $rec['CORSI'];?>" role="tabpanel"></div>
                    <?php endforeach; ?>  
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="close-modal" class="btn btn-primary btn-save">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Fine Maschera Nascosta Metodologia -->

<!-- Inizio Maschera Nascosta Antico Testamento -->
<div class="modal fade" id="AnticoTestamento_ModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Corso Antico Testamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--<h5>Antico Testamento</h5>-->
                <!-- List group -->
                <div class="list-group anyClass" id="myList" role="tablist">
                    <?php foreach ($c_antico_testamento as $rec) : ?>                    
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#AnticoTestamento_<?php echo $rec['CORSI'];?>" role="tab"><?php echo $rec['DESCRIZIONECORSI'];?></a>
                    <?php endforeach; ?>  
                </div>

                <!-- Tab panes -->
                <div class="tab-content">
                    <?php foreach ($c_antico_testamento as $rec) : ?>                    
                    <div class="tab-pane" data-codice="<?php echo $rec['sigla'];?>" data-titolo="<?php echo $rec['DESCRIZIONECORSI'];?>" data-prof="<?php echo $rec['COGNOME'];?>" id="AnticoTestamento_<?php echo $rec['CORSI'];?>" role="tabpanel"></div>
                    <?php endforeach; ?>  
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="close-modal" class="btn btn-primary btn-save">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Fine Maschera Nascosta Antico Testamento -->

<!-- Inizio Maschera Nascosta Nuovo Testamento -->
<div class="modal fade" id="NuovoTestamento_ModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Corso Nuovo Testamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--<h5>Nuovo Testamento</h5>-->
                <!-- List group -->
                <div class="list-group anyClass" id="myList" role="tablist">
                    <?php foreach ($c_nuovo_testamento as $rec) : ?>                    
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#NuovoTestamento_<?php echo $rec['CORSI'];?>" role="tab"><?php echo $rec['DESCRIZIONECORSI'];?></a>
                    <?php endforeach; ?>  
                </div>

                <!-- Tab panes -->
                <div class="tab-content">
                    <?php foreach ($c_nuovo_testamento as $rec) : ?>                    
                    <div class="tab-pane" data-codice="<?php echo $rec['sigla'];?>" data-titolo="<?php echo $rec['DESCRIZIONECORSI'];?>" data-prof="<?php echo $rec['COGNOME'];?>" id="NuovoTestamento_<?php echo $rec['CORSI'];?>" role="tabpanel"></div>
                    <?php endforeach; ?>  
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="close-modal" class="btn btn-primary btn-save">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Fine Maschera Nascosta Nuovo Testamento -->

<!-- /.container-fluid -->