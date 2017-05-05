<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="analyses index content">
    <?= $this->element('add_button') ?>
    <h3><?= __('Analyses') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('source_code_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('content') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($analyses as $analysis): ?>
            <tr>
                <td><?= $this->Number->format($analysis->id) ?></td>
                <td><?= $analysis->has('source_code') ? $this->Html->link($analysis->source_code->name, ['controller' => 'SourceCodes', 'action' => 'view', $analysis->source_code->id]) : '' ?></td>
                <td><?= $analysis->has('status') ? $this->Html->link($analysis->status->title, ['controller' => 'Statuses', 'action' => 'view', $analysis->status->id]) : '' ?></td>
                <td><?= h($analysis->content) ?></td>
                <td><?= h($analysis->created) ?></td>
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
