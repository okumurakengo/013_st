<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Analysis'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Source Codes'), ['controller' => 'SourceCodes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Source Code'), ['controller' => 'SourceCodes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Statuses'), ['controller' => 'Statuses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Status'), ['controller' => 'Statuses', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="analyses index large-9 medium-8 columns content">
    <h3><?= __('Analyses') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('source_code_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('content') ?></th>
                <th scope="col"><?= $this->Paginator->sort('display_order') ?></th>
                <th scope="col"><?= $this->Paginator->sort('select_flg') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($analyses as $analysis): ?>
            <tr>
                <td><?= $this->Number->format($analysis->id) ?></td>
                <td><?= $analysis->has('user') ? $this->Html->link($analysis->user->name, ['controller' => 'Users', 'action' => 'view', $analysis->user->id]) : '' ?></td>
                <td><?= $analysis->has('source_code') ? $this->Html->link($analysis->source_code->name, ['controller' => 'SourceCodes', 'action' => 'view', $analysis->source_code->id]) : '' ?></td>
                <td><?= $analysis->has('status') ? $this->Html->link($analysis->status->id, ['controller' => 'Statuses', 'action' => 'view', $analysis->status->id]) : '' ?></td>
                <td><?= h($analysis->content) ?></td>
                <td><?= $this->Number->format($analysis->display_order) ?></td>
                <td><?= h($analysis->select_flg) ?></td>
                <td><?= h($analysis->created) ?></td>
                <td><?= h($analysis->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $analysis->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $analysis->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $analysis->id], ['confirm' => __('Are you sure you want to delete # {0}?', $analysis->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
