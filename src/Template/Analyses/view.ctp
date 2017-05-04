<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="analyses view content">
    <h3><?= h($analysis->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $analysis->has('user') ? $this->Html->link($analysis->user->name, ['controller' => 'Users', 'action' => 'view', $analysis->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Source Code') ?></th>
            <td><?= $analysis->has('source_code') ? $this->Html->link($analysis->source_code->name, ['controller' => 'SourceCodes', 'action' => 'view', $analysis->source_code->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $analysis->has('status') ? $this->Html->link($analysis->status->id, ['controller' => 'Statuses', 'action' => 'view', $analysis->status->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Content') ?></th>
            <td><?= h($analysis->content) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($analysis->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Display Order') ?></th>
            <td><?= $this->Number->format($analysis->display_order) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($analysis->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($analysis->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Select Flg') ?></th>
            <td><?= $analysis->select_flg ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
