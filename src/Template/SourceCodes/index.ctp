<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="sourceCodes index content">
    <?= $this->element('add_button') ?>
    <h3><?= __('Source Codes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('project_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('source_code_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('directory_flg') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('display_order') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sourceCodes as $sourceCode): ?>
            <tr>
                <td><?= $sourceCode->has('project') ? $this->Html->link($sourceCode->project->title, ['controller' => 'Projects', 'action' => 'view', $sourceCode->project->id]) : '' ?></td>
                <td><?= $this->Number->format($sourceCode->source_code_id) ?></td>
                <td><?= h($sourceCode->directory_flg) ?></td>
                <td><?= h($sourceCode->name) ?></td>
                <td><?= $this->Number->format($sourceCode->display_order) ?></td>
                <td><?= h($sourceCode->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $sourceCode->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $sourceCode->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $sourceCode->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sourceCode->id)]) ?>
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
