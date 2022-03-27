<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<style>
    .anyClass {
        height: 350px;
        overflow-y: scroll;
    }
    .modal-dialog {
        width: 800px;
        margin: 30px auto;
    }    
</style>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-9 mb-2 mt-2">
            <h1 class="h3 mb-4 text-gray-800">Piano Studi&nbsp;&nbsp;&nbsp;<b><?php echo $studente; ?></b></h1>
        </div>
        <div class="col-lg-3 mb-2 mt-2">
            <h1 class="h4 mb-4 text-gray-800">
                <!--<button type="button" class="btn btn-primary">Torna alla scheda</button>-->
                    <?php  //echo anchor(site_url('backend/studente/'.$MATRICOLA), '<button type="button" class="btn btn-primary">Torna alla scheda</button>'); ?>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-9 mb-2 mt-2">
        </div>
        <div class="col-lg-3 mb-2 mt-2" align="center">
        <?php echo $myform; ?>
        </div>
    </div>
    <div class="row">
    <table class="table table-hover" id='corsilist'>
        <thead>
            <tr>
                <th width="20%" scope="col">Tipo corso</th>
                <th width="5%" scope="col">Codice</th>
                <th width="40%" scope="col">Titolo</th>
                <th width="20%" scope="col">Professore</th>
                <th width="15%" scope="col"></th>
            </tr>
        </thead>
        <tbody>
<?php foreach ($schema as $numero => $riga) :?>            
            <tr id=<?php echo $riga[1]['numero']; ?>>
                <th scope="row"><?php echo $riga[1]['pos']; ?></th>
                <td>
                    <input type="hidden" name="row_<?php echo $riga[1]['numero']; ?>" value="<?php echo $riga[1]['sigla']; ?>" id="row_<?php echo $riga[1]['numero']; ?>"  />
                    <input type="hidden" name="old_<?php echo $riga[1]['numero']; ?>" value="<?php echo $riga[1]['sigla']; ?>" id="old_<?php echo $riga[1]['numero']; ?>"  />
                    <input type="hidden" name="tipocorso_<?php echo $riga[1]['numero']; ?>" value="<?php echo $riga[1]['tipocorso']; ?>" id="tipocorso_<?php echo $riga[1]['numero']; ?>"  />
                    <?php echo $riga[1]['sigla']; ?>
                </td>
                <td><?php echo $riga[1]['corso']; ?></td>
                <td><?php echo $riga[1]['professore']; ?></td>
                <td>
        <?php if ($riga[1]['voto']==='0') : ?>
                    <button type="button" class="btn btn-primary" title="inserisci corso" data-toggle="modal" data-target="#<?php echo str_replace(' ','',$riga[1]['tipocorso']); ?>_ModalCenter" data-row-id="<?php echo $riga[1]['numero']; ?>"><i class="fas fa-plus-circle"></i></button>
                    <button type="button" class="btn btn-primary" title="elimina" id="empty" data-row-id="<?php echo $riga[1]['numero']; ?>" onclick='corsoDelete(this)'><i class="far fa-trash-alt"></i></button>
        <?php //else: ?>
                    <?php //echo "Voto: ".$riga[1]['voto']; ?>
        <?php endif; ?>
                </td>
            </tr>
<?php endforeach; ?>
        </tbody>
    </table>
    <?php //echo $myform; ?>
</div>

<!-- Modal -->
<?php foreach ($tab_pianostudi_schema as $tipo_rec) :?>   
<div class="modal fade" id="<?php echo str_replace(' ','',$tipo_rec['tipocorso']); ?>_ModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Corso <?php echo $tipo_rec['tipocorso']; ?></b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- List group -->
                <div class="list-group anyClass" id="myList" role="tablist">
                    <?php foreach ($listacorsi as $rec) : ?>                    
                        <?php if ($rec['tipocorso']===$tipo_rec['tipocorso']) : ?>                    
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#<?php echo str_replace(' ','',$tipo_rec['tipocorso']); ?>_<?php echo $rec['CORSI'];?>" role="tab"><?php echo $rec['DESCRIZIONECORSI'];?></a>
                        <?php endif; ?>  
                    <?php endforeach; ?>  
                </div>

                <!-- Tab panes -->
                <div class="tab-content">
                    <?php foreach ($listacorsi as $rec) : ?>                    
                        <?php if ($rec['tipocorso']===$tipo_rec['tipocorso']) : ?>                    
                            <div class="tab-pane" data-codice="<?php echo $rec['sigla'];?>" data-titolo="<?php echo $rec['DESCRIZIONECORSI'];?>" data-prof="<?php echo $rec['COGNOME'];?>" id="<?php echo str_replace(' ','',$tipo_rec['tipocorso']); ?>_<?php echo $rec['CORSI'];?>" role="tabpanel"></div>
                        <?php endif; ?>  
                    <?php endforeach; ?>  
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                <button type="button" id="close-modal" class="btn btn-primary btn-save">Inserisci</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- /.container-fluid -->