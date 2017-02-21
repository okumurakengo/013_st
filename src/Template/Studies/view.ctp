<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Study'), ['action' => 'edit', $study->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Study'), ['action' => 'delete', $study->id], ['confirm' => __('Are you sure you want to delete # {0}?', $study->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Studies'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Study'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Small Chapters'), ['controller' => 'SmallChapters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Small Chapter'), ['controller' => 'SmallChapters', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Statuses'), ['controller' => 'Statuses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Status'), ['controller' => 'Statuses', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="studies view large-9 medium-8 columns content">
    <h3><?= h($study->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $study->has('user') ? $this->Html->link($study->user->name, ['controller' => 'Users', 'action' => 'view', $study->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Small Chapter') ?></th>
            <td><?= $study->has('small_chapter') ? $this->Html->link($study->small_chapter->title, ['controller' => 'SmallChapters', 'action' => 'view', $study->small_chapter->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $study->has('status') ? $this->Html->link($study->status->id, ['controller' => 'Statuses', 'action' => 'view', $study->status->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Content') ?></th>
            <td><?= h($study->content) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Memo') ?></th>
            <td><?= h($study->memo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($study->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Display Order') ?></th>
            <td><?= $this->Number->format($study->display_order) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($study->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($study->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Select Flg') ?></th>
            <td><?= $study->select_flg ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
