<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * @author Paolo Minervino paolo.minervino@ecm2.it
 */
function myModal($menu)
{
    $hidden = array('menu_id' => $menu->id);
    $result = '';
    $result .= '
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal_' . $menu->id . '">
                <i class="fas fa-wrench"></i>
                </button>
                <!-- The Modal -->
                ' . form_open('menu/group', '', $hidden) . '
                    <div class="modal fade" tabindex="-1" id="myModal_' . $menu->id . '" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Assegna Gruppi</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <h3>' . $menu->name . '</h3>';
    foreach ($menu->groups as $group) {
        $result .= '
                                    <div class="form-group">
                                            <div id="radioBtn" class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <span>' . $group->name . '</span>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <a class="btn btn-primary btn-sm ' . ($group->IsOwned ? 'active' : 'notActive') . '" data-toggle="' . $menu->key . '_' . $group->name . '" data-title="Y">YES</a>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <a class="btn btn-primary btn-sm ' . (!$group->IsOwned ? 'active' : 'notActive') . '" data-toggle="' . $menu->key . '_' . $group->name . '" data-title="N">NO</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="' . $menu->key . '_' . $group->name . '" name="mygroups[' . $group->id . ']" value="' . ($group->IsOwned ? 'Y' : 'N') . '">
                                    </div>
                                    <br />
                                    ';
    }
    $result .= '
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                ' . form_close() . '
        ';
    return $result;
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Menu</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <h1 class="h3 mb-2 text-gray-800"></h1>
            <p class="mb-4">Elenco voci di menu</p>


            <table id='menus' class="table table-bordered" id="users" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>parent</th>
                        <th>pos</th>
                        <th class="no-sort">icon</th>
                        <th>name</th>
                        <th>url</th>
                        <th>groups</th>
                        <th>data_inserimento</th>
                        <th>data_ultima_modifica</th>
                        <th class="no-sort">actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menus as $menu) : ?>
                        <?php
                        //$actions = ($user->active) ? anchor("deactivate/" . $user->id, '<i class="fas fa-stop-circle"></i>', ['title' => lang('index_active_link')]) : anchor("activate/" . $user->id, '<i class="fas fa-play-circle"></i>', ['title' => lang('index_inactive_link')]);
                        $actions = anchor("menu/edit_menu/" . $user->id, '<i class="fas fa-user-edit"></i>');
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($menu->id, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($menu->parent, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($menu->pos, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo $menu->icon; ?></td>
                            <td><?php echo htmlspecialchars($menu->name, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($menu->url, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <?php echo myModal($menu); ?> 
                                <?php foreach ($menu->groups as $group) : ?>
                                    <?php echo ($group->IsOwned ? htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8') . '<br />' : ''); ?>
                                <?php endforeach ?>
                            </td>
                            <td><?php echo htmlspecialchars(Date('d-m-y H:i:s', strtotime($menu->data_inserimento)), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars(Date('d-m-y H:i:s', strtotime($menu->data_ultima_modifica)), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <?php echo $actions; ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p><?php echo anchor('create_menu', 'create menu') ?></p>
        </div>
    </div>
</div>