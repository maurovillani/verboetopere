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
    <table class="table table-hover" id='corsilist'>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Codice</th>
                <th scope="col">Titolo</th>
                <th scope="col">Professore</th>
                <th scope="col">Actins</th>
            </tr>
        </thead>
        <tbody>
            <tr id=1>
                <th scope="row">1</th>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#MetodologiaModalCenter" data-row-id="1">+</button>
                    <button type="button" class="btn btn-primary" id="empty" data-row-id="1" onclick='corsoDelete(this)'>#</button>
                </td>
            </tr>
            <tr id=2>
                <th scope="row">2</th>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#MetodologiaModalCenter" data-row-id="2">+</button>
                    <button type="button" class="btn btn-primary" id="empty" data-row-id="2" onclick='corsoDelete(this)'>#</button>
                </td>
            </tr>
            <tr id=3>
                <th scope="row">3</th>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#MetodologiaModalCenter" data-row-id="3">+</button>
                    <button type="button" class="btn btn-primary" id="empty" data-row-id="3" onclick='corsoDelete(this)'>#</button>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- <button type="button" class="btn btn-primary"  onclick='corsoSave()'>Save</button> -->
    <?php echo $myform; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="MetodologiaModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Metodologia</h5>
                <!-- List group -->
                <div class="list-group anyClass" id="myList" role="tablist">
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#Metodologia1" role="tab">Metodologia1</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#Metodologia2" role="tab">Metodologia2</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#Metodologia3" role="tab">Metodologia3</a>
                </div>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane" data-codice="met1" data-titolo="Metodologia1" data-prof="Paolo Minervino" id="Metodologia1" role="tabpanel">Paoletto1 Metodologia1 Metodologia1 Metodologia1</div>
                    <div class="tab-pane" data-codice="met2" data-titolo="Metodologia2" data-prof="Paolo Minervino" id="Metodologia2" role="tabpanel">Paoletto2 Metodologia2 Metodologia2 Metodologia2 Metodologia2 Metodologia2</div>
                    <div class="tab-pane" data-codice="met3" data-titolo="Metodologia3" data-prof="Paolo Minervino" id="Metodologia3" role="tabpanel">Paoletto2 Metodologia2 Metodologia2 Metodologia2 Metodologia2 Metodologia2</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="close-modal" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->