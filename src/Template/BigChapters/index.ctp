<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="bigChapters index content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('検索') ?></legend>
        <div class="row">
            <div class="medium-2 columns">技術書名</div>
            <div class="medium-10 columns end"><?= $this->Form->select('books', $selectBooks, $searchBooks) ?></div>
        </div>
    </fieldset>
    <?= $this->Form->button(__('検索')) ?>
    <?= $this->Form->end() ?>
    <?= $this->element('add_button') ?>
    <h3><?= __('Big Chapters') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <col width="30">
        <col width="65">
        <col width="15">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('book_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bigChapters as $bigChapter): ?>
            <tr>
                <td><?= $bigChapter->has('book') ? $this->Html->link($bigChapter->book->display_order . ". " . $bigChapter->book->title, ['controller' => 'Books', 'action' => 'view', $bigChapter->book->id]) : '' ?></td>
                <td><?= $this->Number->format($bigChapter->display_order) . ". " . h($bigChapter->title) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $bigChapter->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $bigChapter->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $bigChapter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bigChapter->id)]) ?>
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
