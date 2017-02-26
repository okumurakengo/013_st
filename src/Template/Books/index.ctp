<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="books index content">
    <p style="float:right;"><?= $this->Html->link('追加', ['action' => 'add'], ['class'=>'button small radius']) ?></p>
    <h3><?= __('Books') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <col width="50">
        <col width="17">
        <col width="17">
        <col width="16">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
            <tr>
                <td>
                <?php if($book->url !== ''): ?>
                    <a href="<?= h($book->url) ?>" target="_blank"><?= h($book->title) ?></a>
                <?php else: ?>
                    <?= h($book->title) ?>
                <?php endif; ?>
                </td>
                <td><?= h($book->created->format('Y年m月d日H:i')) ?></td>
                <td><?= h($book->modified->format('Y年m月d日H:i')) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $book->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $book->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $book->id], ['confirm' => __('Are you sure you want to delete # {0}?', $book->id)]) ?>
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
