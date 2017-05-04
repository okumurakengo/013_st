<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Source Code'), ['action' => 'edit', $sourceCode->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Source Code'), ['action' => 'delete', $sourceCode->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sourceCode->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Source Codes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Source Code'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Source Codes'), ['controller' => 'SourceCodes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Source Code'), ['controller' => 'SourceCodes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Analyses'), ['controller' => 'Analyses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Analysis'), ['controller' => 'Analyses', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="sourceCodes view large-9 medium-8 columns content">
    <h3><?= h($sourceCode->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Project') ?></th>
            <td><?= $sourceCode->has('project') ? $this->Html->link($sourceCode->project->title, ['controller' => 'Projects', 'action' => 'view', $sourceCode->project->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($sourceCode->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($sourceCode->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Source Code Id') ?></th>
            <td><?= $this->Number->format($sourceCode->source_code_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Display Order') ?></th>
            <td><?= $this->Number->format($sourceCode->display_order) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($sourceCode->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($sourceCode->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Directory Flg') ?></th>
            <td><?= $sourceCode->directory_flg ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Select Flg') ?></th>
            <td><?= $sourceCode->select_flg ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Code') ?></h4>
        <?= $this->Text->autoParagraph(h($sourceCode->code)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Source Codes') ?></h4>
        <?php if (!empty($sourceCode->source_codes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Project Id') ?></th>
                <th scope="col"><?= __('Source Code Id') ?></th>
                <th scope="col"><?= __('Directory Flg') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Code') ?></th>
                <th scope="col"><?= __('Display Order') ?></th>
                <th scope="col"><?= __('Select Flg') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($sourceCode->source_codes as $sourceCodes): ?>
            <tr>
                <td><?= h($sourceCodes->id) ?></td>
                <td><?= h($sourceCodes->project_id) ?></td>
                <td><?= h($sourceCodes->source_code_id) ?></td>
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
    <div class="related">
        <h4><?= __('Related Analyses') ?></h4>
        <?php if (!empty($sourceCode->analyses)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Source Code Id') ?></th>
                <th scope="col"><?= __('Status Id') ?></th>
                <th scope="col"><?= __('Content') ?></th>
                <th scope="col"><?= __('Display Order') ?></th>
                <th scope="col"><?= __('Select Flg') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($sourceCode->analyses as $analyses): ?>
            <tr>
                <td><?= h($analyses->id) ?></td>
                <td><?= h($analyses->user_id) ?></td>
                <td><?= h($analyses->source_code_id) ?></td>
                <td><?= h($analyses->status_id) ?></td>
                <td><?= h($analyses->content) ?></td>
                <td><?= h($analyses->display_order) ?></td>
                <td><?= h($analyses->select_flg) ?></td>
                <td><?= h($analyses->created) ?></td>
                <td><?= h($analyses->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Analyses', 'action' => 'view', $analyses->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Analyses', 'action' => 'edit', $analyses->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Analyses', 'action' => 'delete', $analyses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $analyses->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
