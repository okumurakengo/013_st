<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="smallChapters index content">
    <?= $this->Form->create('',['id' => 'search']) ?>
    <fieldset>
        <legend><?= __('検索') ?></legend>
        <div class="row">
            <div class="medium-2 columns">技術書名</div>
            <div class="medium-10 columns"><?= $this->Form->select('books', $selectBooks, [$searchBooks, 'id'=>'books']) ?></div>
        </div>
    </fieldset>
    <?= $this->Form->end() ?>
    <p style="float:right;"><?= $this->Html->link('追加', ['action' => 'add'], ['class'=>'button small radius']) ?></p>
    <h3><?= __('Small Chapters') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <col width="25">
        <col width="25">
        <col width="35">
        <col width="15">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('big_chapter_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('middle_chapter_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($smallChapters as $smallChapter): ?>
            <tr>
                <td><?= $smallChapter->has('middle_chapter') ? $this->Html->link($smallChapter->middle_chapter->big_chapter->display_order . '. ' . $smallChapter->middle_chapter->big_chapter->title, ['controller' => 'BigChapters', 'action' => 'view', $smallChapter->middle_chapter->big_chapter->id]) : '' ?></td>
                <td><?= $smallChapter->has('middle_chapter') ? $this->Html->link($smallChapter->middle_chapter->display_order . '. ' . $smallChapter->middle_chapter->title, ['controller' => 'MiddleChapters', 'action' => 'view', $smallChapter->middle_chapter->id]) : '' ?></td>
                <td><?= h($smallChapter->display_order . '. ' . $smallChapter->title) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $smallChapter->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $smallChapter->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $smallChapter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $smallChapter->id)]) ?>
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
<script>

    $('.button').focus();

    var books = document.getElementById('books');
    var target = document.getElementById('search');
    books.onchange = function(){

        target.method = "post";
        target.submit();

    }

</script>
