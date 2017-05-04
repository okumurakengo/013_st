<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="projects index content">
    <?= $this->element('add_button') ?>
    <h3><?= __('Projects') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('url') ?></th>
                <th scope="col"><?= $this->Paginator->sort('display_order') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('select_flg') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
            <tr>
                <td><?= $this->Number->format($project->id) ?></td>
                <td><?= h($project->title) ?></td>
                <td><?= h($project->url) ?></td>
                <td><?= $this->Number->format($project->display_order) ?></td>
                <td><?= $project->has('status') ? $this->Html->link($project->status->id, ['controller' => 'Statuses', 'action' => 'view', $project->status->id]) : '' ?></td>
                <td><?= h($project->select_flg) ?></td>
                <td><?= h($project->created) ?></td>
                <td><?= h($project->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $project->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $project->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $project->id], ['confirm' => __('Are you sure you want to delete # {0}?', $project->id)]) ?>
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
