<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Project'), ['action' => 'edit', $project->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Project'), ['action' => 'delete', $project->id], ['confirm' => __('Are you sure you want to delete # {0}?', $project->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Statuses'), ['controller' => 'Statuses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Status'), ['controller' => 'Statuses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Source Codes'), ['controller' => 'SourceCodes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Source Code'), ['controller' => 'SourceCodes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="projects view large-9 medium-8 columns content">
    <h3><?= h($project->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($project->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Url') ?></th>
            <td><?= h($project->url) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $project->has('status') ? $this->Html->link($project->status->id, ['controller' => 'Statuses', 'action' => 'view', $project->status->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($project->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Display Order') ?></th>
            <td><?= $this->Number->format($project->display_order) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($project->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($project->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Select Flg') ?></th>
            <td><?= $project->select_flg ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Source Codes') ?></h4>
        <?php if (!empty($project->source_codes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Project Id') ?></th>
                <th scope="col"><?= __('Folder Id') ?></th>
                <th scope="col"><?= __('Directory Flg') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Code') ?></th>
                <th scope="col"><?= __('Display Order') ?></th>
                <th scope="col"><?= __('Select Flg') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($project->source_codes as $sourceCodes): ?>
            <tr>
                <td><?= h($sourceCodes->id) ?></td>
                <td><?= h($sourceCodes->project_id) ?></td>
                <td><?= h($sourceCodes->folder_id) ?></td>
                <td><?= h($sourceCodes->directory_flg) ?></td>
                <td><?= h($sourceCodes->name) ?></td>
                <td><?= h($sourceCodes->code) ?></td>
                <td><?= h($sourceCodes->display_order) ?></td>
                <td><?= h($sourceCodes->select_flg) ?></td>
                <td><?= h($sourceCodes->created) ?></td>
                <td><?= h($sourceCodes->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SourceCodes', 'action' => 'view', $sourceCodes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SourceCodes', 'action' => 'edit', $sourceCodes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SourceCodes', 'action' => 'delete', $sourceCodes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sourceCodes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
