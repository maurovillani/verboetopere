<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo lang('index_heading'); ?></h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <h1 class="h3 mb-2 text-gray-800"></h1>
            <p class="mb-4"><?php echo lang('index_subheading'); ?></p>


            <table class="table table-bordered" id="users" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><?php echo lang('index_fname_th'); ?></th>
                        <th><?php echo lang('index_lname_th'); ?></th>
                        <th><?php echo lang('index_email_th'); ?></th>
                        <th><?php echo lang('index_groups_th'); ?></th>
                        <th>created_on</th>
                        <th>last_login</th>
                        <!--<th><?php echo lang('index_status_th'); ?></th>-->
                        <th><?php echo lang('index_action_th'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <?php 
                        $actions = ($user->active) ? anchor("deactivate/" . $user->id, '<i class="fas fa-stop-circle"></i>', ['title' => lang('index_active_link')]) : anchor("activate/" . $user->id, '<i class="fas fa-play-circle"></i>', ['title' => lang('index_inactive_link')]);
                        $actions .= anchor("edit_user/" . $user->id, '<i class="fas fa-user-edit"></i>');
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <?php foreach ($user->groups as $group): ?>
                                    <?php echo anchor("edit_group/" . $group->id, htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8')); ?><br />
                                <?php endforeach?>
                            </td>
                            <td><?php echo htmlspecialchars(Date('d-m-y H:i:s', $user->created_on), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars(Date('d-m-y H:i:s', $user->last_login), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <?php echo $actions; ?>
                            </td>

                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>

            <p><?php echo anchor('create_user', lang('index_create_user_link')) ?> | <?php echo anchor('create_group', lang('index_create_group_link')) ?></p>
        </div>
    </div>
</div>